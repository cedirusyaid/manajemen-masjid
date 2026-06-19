<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\RoleModel;
use Exception;

class AuthController extends BaseController
{
    protected $userModel;
    protected $session;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->session   = \Config\Services::session();
        helper(['url', 'form', 'telegram_helper', 'audit_helper']);
    }

    /**
     * Menampilkan halaman login
     */
    public function login()
    {
        // Jika sudah login, redirect ke Dashboard
        if ($this->session->get('is_logged_in')) {
            return redirect()->to('/dashboard');
        }

        // Inisialisasi Google Client untuk tombol Login Google
        $googleUrl = $this->getGoogleAuthUrl();

        return view('auth/login', [
            'google_login_url' => $googleUrl,
            'validation'       => \Config\Services::validation()
        ]);
    }

    /**
     * Memproses login menggunakan username & password lokal (Native Login)
     */
    public function loginProcess()
    {
        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Username dan Password wajib diisi.');
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $this->userModel->where('username', $username)->first();

        if (!$user) {
            return redirect()->back()->withInput()->with('error', 'Username tidak ditemukan.');
        }

        if ($user['status'] !== 'active') {
            return redirect()->back()->withInput()->with('error', 'Akun Anda dinonaktifkan.');
        }

        // Verifikasi password BCRYPT
        if (!password_verify($password, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Password salah.');
        }

        // Set Session data user
        $this->setSessionUser($user);

        // Catat Audit Trail
        log_activity('LOGIN', 'sys_users', $user['id'], null, ['username' => $username, 'method' => 'native']);

        return redirect()->to('/dashboard')->with('success', 'Selamat datang kembali, ' . $user['username'] . '!');
    }

    /**
     * Callback handler setelah pengguna sukses login di halaman Google
     */
    public function googleCallback()
    {
        $code = $this->request->getVar('code');

        if (empty($code)) {
            return redirect()->to('/login')->with('error', 'Autentikasi Google dibatalkan.');
        }

        try {
            $client = $this->getGoogleClient();
            $token  = $client->fetchAccessTokenWithAuthCode($code);

            if (isset($token['error'])) {
                throw new Exception('Token Error: ' . $token['error_description']);
            }

            $client->setAccessToken($token['access_token']);

            // Dapatkan informasi profil pengguna dari Google
            $googleService = new \Google\Service\Oauth2($client);
            $userInfo      = $googleService->userinfo->get();

            $email    = $userInfo->email;
            $googleId = $userInfo->id;
            $avatar   = $userInfo->picture;
            $name     = $userInfo->name;

            // Cari user berdasarkan email
            $user = $this->userModel->where('email', $email)->first();

            if (!$user) {
                // Skenario Auto-Register sebagai Jemaah (Role ID 5)
                $usernameBase = explode('@', $email)[0];
                
                // Pastikan username unik
                $username = $usernameBase;
                $counter = 1;
                while ($this->userModel->where('username', $username)->first()) {
                    $username = $usernameBase . $counter;
                    $counter++;
                }

                // Cek apakah email sudah terdaftar di Master Personel
                $personilModel = new \App\Models\PersonilModel();
                $personil = $personilModel->where('email', $email)->first();

                $newData = [
                    'username'    => $username,
                    'email'       => $email,
                    'google_id'   => $googleId,
                    'avatar'      => $avatar,
                    'personil_id' => $personil ? $personil['id'] : null,
                    'role_id'     => 5, // Jemaah
                    'status'      => 'active'
                ];

                $this->userModel->insert($newData);
                
                // Ambil data user yang baru dibuat
                $user = $this->userModel->where('email', $email)->first();
                
                // Catat log pendaftaran baru
                log_activity('REGISTER_OAUTH', 'sys_users', $user['id'], null, $newData);
            }

            if ($user['status'] !== 'active') {
                return redirect()->to('/login')->with('error', 'Akun Anda dinonaktifkan.');
            }

            // Update data Google ID, Avatar, dan personil_id jika berubah atau baru login pertama via Google
            $updateData = [];
            if ($user['google_id'] !== $googleId) {
                $updateData['google_id'] = $googleId;
            }
            if ($user['avatar'] !== $avatar) {
                $updateData['avatar'] = $avatar;
            }
            if (empty($user['personil_id'])) {
                $personilModel = new \App\Models\PersonilModel();
                $personil = $personilModel->where('email', $email)->first();
                if ($personil) {
                    $updateData['personil_id'] = $personil['id'];
                }
            }

            if (!empty($updateData)) {
                $before = $user;
                $this->userModel->update($user['id'], $updateData);
                $after = array_merge($user, $updateData);
                log_activity('UPDATE_OAUTH', 'sys_users', $user['id'], $before, $after);
                // Sinkronkan data user lokal agar session mendapatkan info terbaru
                $user = array_merge($user, $updateData);
            }

            // Set Session login
            $this->setSessionUser($user);

            // Catat Audit Trail
            log_activity('LOGIN', 'sys_users', $user['id'], null, ['email' => $email, 'method' => 'google']);

            return redirect()->to('/dashboard')->with('success', 'Selamat datang kembali, ' . $name . '!');

        } catch (Exception $e) {
            // Kirim notifikasi error ke Telegram
            telegram_log_error($e);
            return redirect()->to('/login')->with('error', 'Terjadi kesalahan login Google: ' . $e->getMessage());
        }
    }

    /**
     * Memproses Logout
     */
    public function logout()
    {
        $userId   = $this->session->get('user_id');
        $username = $this->session->get('username');

        if ($userId) {
            log_activity('LOGOUT', 'sys_users', $userId, null, ['username' => $username]);
        }

        $this->session->destroy();
        return redirect()->to('/login')->with('success', 'Anda telah berhasil keluar.');
    }

    // ----------------------------------------------------------------------
    // PRIVATE METHODS
    // ----------------------------------------------------------------------

    /**
     * Dapatkan URL redirect untuk autentikasi Google
     */
    private function getGoogleAuthUrl(): string
    {
        try {
            $client = $this->getGoogleClient();
            return $client->createAuthUrl();
        } catch (Exception $e) {
            log_message('error', 'Google Auth URL Generation Failed: ' . $e->getMessage());
            return '#';
        }
    }

    /**
     * Inisialisasi Google Client API
     */
    private function getGoogleClient(): \Google\Client
    {
        $clientId     = env('google.clientID');
        $clientSecret = env('google.clientSecret');
        $redirectUri  = env('google.redirectURI');

        if (empty($clientId) || empty($clientSecret) || empty($redirectUri)) {
            throw new Exception('Konfigurasi Google OAuth di file .env belum diisi.');
        }

        $client = new \Google\Client();
        $client->setClientId($clientId);
        $client->setClientSecret($clientSecret);
        $client->setRedirectUri($redirectUri);
        $client->addScope("email");
        $client->addScope("profile");

        return $client;
    }

    /**
     * Set Session login pengguna
     */
    private function setSessionUser(array $user)
    {
        $roleModel = new RoleModel();
        $role      = $roleModel->find($user['role_id']);

        $this->session->set([
            'user_id'      => $user['id'],
            'username'     => $user['username'],
            'email'        => $user['email'],
            'avatar'       => $user['avatar'] ?: base_url('assets/images/default-avatar.png'),
            'personil_id'  => $user['personil_id'] ?? null,
            'role_id'      => $user['role_id'],
            'role_name'    => $role ? $role['name'] : 'User',
            'is_logged_in' => true
        ]);
    }
}
