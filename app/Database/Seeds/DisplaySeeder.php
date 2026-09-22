<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\SettingModel;
use App\Models\AgendaModel;
use App\Models\KeuanganModel;
use App\Models\JadwalJumatModel;

class DisplaySeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        // 1. Seed Sys Settings
        $settingModel = new SettingModel();
        $settingModel->setSetting('nama_masjid', 'MASJID AGUNG NUJUMUL ITTIHAD', 'general');
        $settingModel->setSetting('alamat_masjid', 'Jl. Persatuan Raya No. 1, Kab. Sinjai', 'general');

        // 2. Update Master Personil agar tidak menggunakan nama orang asli
        $personils = $db->table('mst_personil p')
            ->select('p.id, p.nama, ik.jabatan')
            ->join('mst_imam_khatib ik', 'ik.personil_id = p.id', 'left')
            ->get()->getResultArray();

        $khatibCount = 1;
        $imamCount = 1;
        $muadzinCount = 1;
        $petugasCount = 1;

        foreach ($personils as $p) {
            $newNama = '';
            $jabatan = $p['jabatan'] ?? '';

            if (strpos($jabatan, 'khatib') !== false) {
                $newNama = 'Khatib ' . $khatibCount++;
            } elseif ($jabatan === 'imam') {
                $newNama = 'Imam ' . $imamCount++;
            } elseif ($jabatan === 'muadzin') {
                $newNama = 'Muadzin ' . $muadzinCount++;
            } else {
                $newNama = 'Petugas ' . $petugasCount++;
            }

            $db->table('mst_personil')->where('id', $p['id'])->update(['nama' => $newNama]);
        }

        // 3. Seed Jadwal Jumat (3 Jumat ke Depan)
        $jadwalJumatModel = new JadwalJumatModel();
        $db->table('trn_jadwal_jumat')->truncate();
        
        // Ambil data petugas dari mst_imam_khatib
        $petugasList = $db->table('mst_imam_khatib')->get()->getResultArray();
        $khatib  = $db->table('mst_imam_khatib')->where('jabatan', 'khatib')->get()->getRowArray() ?? ($petugasList[0] ?? null);
        $imam    = $db->table('mst_imam_khatib')->where('jabatan', 'imam')->get()->getRowArray() ?? ($petugasList[1] ?? null);
        $muadzin = $db->table('mst_imam_khatib')->where('jabatan', 'muadzin')->get()->getRowArray() ?? ($petugasList[2] ?? null);

        $today = date('Y-m-d');
        $friday1 = (date('N', strtotime($today)) == 5) ? $today : date('Y-m-d', strtotime('next Friday', strtotime($today)));
        $friday2 = date('Y-m-d', strtotime('+1 week', strtotime($friday1)));
        $friday3 = date('Y-m-d', strtotime('+2 weeks', strtotime($friday1)));

        if ($khatib && $imam) {
            $jadwalJumatModel->insert([
                'tanggal'       => $friday1,
                'khatib_id'     => $khatib['id'],
                'imam_id'       => $imam['id'],
                'muadzin_id'    => $muadzin['id'] ?? $imam['id'],
                'judul_khotbah' => 'Menjaga Ukhuwah Islamiyah dan Keberkahan Jamaah di Era Modern',
                'keterangan'    => 'Petugas Jumat Ke-1'
            ]);

            $jadwalJumatModel->insert([
                'tanggal'       => $friday2,
                'khatib_id'     => $imam['id'],
                'imam_id'       => $khatib['id'],
                'muadzin_id'    => $muadzin['id'] ?? $khatib['id'],
                'judul_khotbah' => 'Urgensi Pendidikan Karakter Menurut Al-Qur\'an',
                'keterangan'    => 'Petugas Jumat Ke-2'
            ]);

            $jadwalJumatModel->insert([
                'tanggal'       => $friday3,
                'khatib_id'     => $khatib['id'],
                'imam_id'       => $imam['id'],
                'muadzin_id'    => $muadzin['id'] ?? $imam['id'],
                'judul_khotbah' => 'Meraih Keberkahan Rezeki dengan Sedekah dan Wakaf',
                'keterangan'    => 'Petugas Jumat Ke-3'
            ]);
        }

        // 4. Seed Agenda Kegiatan
        $agendaModel = new AgendaModel();
        // Bersihkan data agenda lama agar tidak menumpuk
        $db->table('mst_agenda')->truncate();

        $agendas = [
            [
                'judul'      => 'Kajian Subuh Berjamaah & Dzikir Bersama',
                'deskripsi'  => 'Meningkatkan keimanan dan ketakwaan melalui kajian rutin subuh serta dzikir berjamaah.',
                'tanggal'    => date('Y-m-d', strtotime('+1 day')),
                'waktu'      => '05:00:00',
                'lokasi'     => 'Ruang Utama Masjid',
                'narasumber' => 'Ustadz 1'
            ],
            [
                'judul'      => 'Tabligh Akbar Menyambut Maulid Nabi SAW',
                'deskripsi'  => 'Peringatan hari besar Islam dengan menghadirkan penceramah utama dan doa bersama.',
                'tanggal'    => date('Y-m-d', strtotime('+3 days')),
                'waktu'      => '19:30:00',
                'lokasi'     => 'Halaman Utama Masjid Agung',
                'narasumber' => 'Ustadz 2'
            ],
            [
                'judul'      => 'Pelatihan Tajwid & Tahsin Al-Qur\'an',
                'deskripsi'  => 'Bimbingan membaca Al-Qur\'an secara tartil dan fasih untuk seluruh jamaah.',
                'tanggal'    => date('Y-m-d', strtotime('+5 days')),
                'waktu'      => '16:00:00',
                'lokasi'     => 'Aula Lantai 2 Masjid',
                'narasumber' => 'Ustadz 3'
            ]
        ];

        foreach ($agendas as $ag) {
            $agendaModel->insert($ag);
        }

        // 5. Seed Keuangan Kas Masjid
        $keuanganModel = new KeuanganModel();
        // Truncate tabel keuangan dummy
        $db->table('trn_keuangan')->truncate();

        $transaksi = [
            [
                'tanggal'          => date('Y-m-d', strtotime('-5 days')),
                'kategori'         => 'operasional',
                'tipe'             => 'masuk',
                'nominal'          => 12500000,
                'keterangan'       => 'Infak & Sedekah Kotak Jumat',
                'penanggung_jawab' => 'Bendahara Masjid'
            ],
            [
                'tanggal'          => date('Y-m-d', strtotime('-3 days')),
                'kategori'         => 'pembangunan',
                'tipe'             => 'masuk',
                'nominal'          => 25000000,
                'keterangan'       => 'Donasi Wakaf Pembangunan Menara & Canopy',
                'penanggung_jawab' => 'Panitia Pembangunan'
            ],
            [
                'tanggal'          => date('Y-m-d', strtotime('-2 days')),
                'kategori'         => 'operasional',
                'tipe'             => 'keluar',
                'nominal'          => 3400000,
                'keterangan'       => 'Pembayaran Kebersihan, Air & Listrik Masjid',
                'penanggung_jawab' => 'Seksi Operasional'
            ],
            [
                'tanggal'          => date('Y-m-d', strtotime('-1 day')),
                'kategori'         => 'sosial',
                'tipe'             => 'keluar',
                'nominal'          => 5000000,
                'keterangan'       => 'Santunan Anak Yatim & Dhuafa Bulanan',
                'penanggung_jawab' => 'Seksi Sosial'
            ]
        ];

        foreach ($transaksi as $tr) {
            $keuanganModel->insert($tr);
        }

        // 6. Seed Berita & Pengumuman
        $beritaModel = new \App\Models\BeritaModel();
        $db->table('mst_berita')->truncate();

        $user = $db->table('sys_users')->get()->getRowArray();
        $userId = $user['id'] ?? null;

        if ($userId) {
            $beritaModel->insert([
                'judul'      => 'Himbauan Menjaga Kebersihan & Kerapihan Saf Shalat',
                'konten'     => 'Dihimbau kepada seluruh jamaah Masjid Agung Nujumul Ittihad untuk selalu menjaga kebersihan area utama masjid dan merapatkan saf saat shalat berjamaah.',
                'status'     => 'published',
                'created_by' => $userId
            ]);

            $beritaModel->insert([
                'judul'      => 'Penerimaan Donasi & ZIS Berbasis QRIS Resmi Masjid',
                'konten'     => 'Jamaah dapat menyalurkan donasi, infak, dan sedekah secara non-tunai melalui scan kode QRIS Masjid yang terpasang di setiap tiang utama masjid.',
                'status'     => 'published',
                'created_by' => $userId
            ]);
        }
    }
}
