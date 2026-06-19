<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Data Personel - Panel Admin</title>
    <!-- Google Fonts: Inter & Outfit -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #064e3b;
            --primary-light: #0f766e;
            --accent: #d97706;
            --dark-navy: #022c22;
            --light-bg: #f3f4f6;
            --white: #ffffff;
            --sidebar-width: 260px;
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.04);
            --transition: all 0.25s ease;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--light-bg);
            color: #1f2937;
            min-height: 100vh;
            display: flex;
        }

        h1, h2, h3, h4, h5, .font-heading {
            font-family: 'Outfit', sans-serif;
        }

        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            background-color: var(--dark-navy);
            color: rgba(255, 255, 255, 0.85);
            min-height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 100;
            display: flex;
            flex-direction: column;
            border-right: 1px solid rgba(255, 255, 255, 0.08);
        }

        .sidebar-header {
            padding: 24px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-brand {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--white);
            text-decoration: none;
        }

        .sidebar-brand i {
            color: var(--accent);
        }

        .sidebar-menu {
            list-style: none;
            padding: 20px 12px;
            margin: 0;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .menu-link {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 16px;
            color: rgba(255, 255, 255, 0.75);
            text-decoration: none;
            border-radius: 10px;
            font-weight: 500;
            font-size: 0.925rem;
            transition: var(--transition);
        }

        .menu-link:hover, .menu-link.active {
            background-color: rgba(255, 255, 255, 0.08);
            color: var(--white);
        }

        .menu-link.active i {
            color: var(--accent);
        }

        .menu-link i {
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }

        .sidebar-footer {
            padding: 20px 12px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .btn-logout {
            background-color: rgba(220, 38, 38, 0.15);
            color: #ef4444 !important;
            border: 1px solid rgba(220, 38, 38, 0.2);
            font-weight: 600;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 12px;
            width: 100%;
            transition: var(--transition);
            text-decoration: none;
            font-size: 0.9rem;
        }

        .btn-logout:hover {
            background-color: #dc2626;
            color: var(--white) !important;
        }

        /* Content Area */
        .main-content {
            margin-left: var(--sidebar-width);
            flex-grow: 1;
            padding: 40px;
            max-width: calc(100% - var(--sidebar-width));
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
        }

        .profile-card {
            display: flex;
            align-items: center;
            gap: 12px;
            background-color: var(--white);
            padding: 8px 18px 8px 10px;
            border-radius: 30px;
            box-shadow: var(--shadow-sm);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .profile-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary);
        }

        .profile-name {
            font-weight: 700;
            font-size: 0.875rem;
            color: #111827;
        }

        .profile-role {
            font-size: 0.725rem;
            color: #6b7280;
            font-weight: 600;
            text-transform: uppercase;
        }

        .panel-card {
            background-color: var(--white);
            border-radius: 16px;
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: var(--shadow-sm);
            padding: 30px;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.85rem;
            color: #374151;
        }

        .form-control, .form-select {
            padding: 12px 16px;
            border-radius: 10px;
            border: 1.5px solid #d1d5db;
            font-size: 0.95rem;
            transition: var(--transition);
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-light);
            box-shadow: 0 0 0 4px rgba(15, 118, 110, 0.15);
        }

        .btn-submit {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: var(--white);
            border: none;
            font-weight: 600;
            padding: 12px 24px;
            border-radius: 10px;
            transition: var(--transition);
        }

        .btn-submit:hover {
            opacity: 0.95;
            box-shadow: 0 4px 12px rgba(6, 78, 59, 0.25);
            color: var(--white);
        }

        .btn-cancel {
            background-color: #f3f4f6;
            color: #4b5563;
            border: 1px solid #d1d5db;
            font-weight: 600;
            padding: 12px 24px;
            border-radius: 10px;
            transition: var(--transition);
            text-decoration: none;
        }

        .btn-cancel:hover {
            background-color: #e5e7eb;
        }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <a href="<?= base_url('dashboard') ?>" class="sidebar-brand">
                <i class="fa-solid fa-mosque me-2"></i>Masjid Agung
            </a>
        </div>
        
        <ul class="sidebar-menu">
            <li>
                <a href="<?= base_url('dashboard') ?>" class="menu-link">
                    <i class="fa-solid fa-gauge-high"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="<?= base_url('dashboard/jadwal-jumat') ?>" class="menu-link">
                    <i class="fa-solid fa-calendar-week"></i> Jadwal Jumat
                </a>
            </li>
            <li>
                <a href="<?= base_url('dashboard/keuangan') ?>" class="menu-link">
                    <i class="fa-solid fa-wallet"></i> Kas Keuangan
                </a>
            </li>
            <li>
                <a href="<?= base_url('dashboard/rekening') ?>" class="menu-link">
                    <i class="fa-solid fa-credit-card"></i> Rekening Infaq
                </a>
            </li>
            <li>
                <a href="<?= base_url('dashboard/berita') ?>" class="menu-link">
                    <i class="fa-solid fa-newspaper"></i> Berita & Info
                </a>
            </li>
            <li>
                <a href="<?= base_url('dashboard/agenda') ?>" class="menu-link">
                    <i class="fa-solid fa-book-open-reader"></i> Jadwal Pengajian
                </a>
            </li>
            <li>
                <a href="<?= base_url('dashboard/personil') ?>" class="menu-link active">
                    <i class="fa-solid fa-user-gear"></i> Master Personel
                </a>
            </li>
            <li>
                <a href="<?= base_url('dashboard/kepengurusan') ?>" class="menu-link">
                    <i class="fa-solid fa-users"></i> Kepengurusan
                </a>
            </li>
            <li>
                <a href="<?= base_url('dashboard/kepanitiaan') ?>" class="menu-link">
                    <i class="fa-solid fa-people-group"></i> Kepanitiaan
                </a>
            </li>
        </ul>

        <div class="sidebar-footer">
            <a href="<?= base_url('logout') ?>" class="btn-logout">
                <i class="fa-solid fa-arrow-right-from-bracket"></i> Keluar Sistem
            </a>
        </div>
    </aside>

    <!-- CONTENT -->
    <main class="main-content">
        <!-- TOPBAR -->
        <div class="topbar">
            <div>
                <h1 class="h3 fw-bold mb-1 text-dark">Ubah Data Personel</h1>
                <p class="text-muted mb-0">Perbarui informasi data diri personel <?= site_name() ?>.</p>
            </div>
            
            <div class="profile-card">
                <img class="profile-avatar" src="<?= esc($avatar) ?>" alt="Avatar">
                <div class="profile-info">
                    <div class="profile-name"><?= esc($username) ?></div>
                    <div class="profile-role"><?= esc($role_name) ?></div>
                </div>
            </div>
        </div>

        <!-- Flash Messages -->
        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger d-flex align-items-center gap-2 mb-4 border-0" role="alert">
                <i class="fa-solid fa-circle-exclamation"></i>
                <div><?= session()->getFlashdata('error') ?></div>
            </div>
        <?php endif; ?>

        <!-- FORM CARD -->
        <div class="panel-card">
            <form action="<?= base_url('dashboard/personil/update/' . $personil['id']) ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                
                <div class="row g-4 mb-4">
                    <!-- Nama Lengkap -->
                    <div class="col-md-6">
                        <label for="nama" class="form-label mb-2">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?= ($validation->hasError('nama')) ? 'is-invalid' : '' ?>" id="nama" name="nama" value="<?= old('nama', $personil['nama']) ?>" placeholder="Masukkan nama lengkap" required>
                        <div class="invalid-feedback"><?= $validation->getError('nama') ?></div>
                    </div>

                    <!-- NIK -->
                    <div class="col-md-6">
                        <label for="nik" class="form-label mb-2">Nomor Induk Kependudukan (NIK)</label>
                        <input type="text" class="form-control <?= ($validation->hasError('nik')) ? 'is-invalid' : '' ?>" id="nik" name="nik" value="<?= old('nik', $personil['nik']) ?>" maxlength="16" placeholder="Masukkan 16 digit NIK">
                        <div class="invalid-feedback"><?= $validation->getError('nik') ?></div>
                    </div>

                    <!-- No HP -->
                    <div class="col-md-6">
                        <label for="no_hp" class="form-label mb-2">Nomor WhatsApp / HP</label>
                        <input type="text" class="form-control <?= ($validation->hasError('no_hp')) ? 'is-invalid' : '' ?>" id="no_hp" name="no_hp" value="<?= old('no_hp', $personil['no_hp']) ?>" placeholder="Contoh: 08123456789">
                        <div class="invalid-feedback"><?= $validation->getError('no_hp') ?></div>
                    </div>

                    <!-- Email -->
                    <div class="col-md-6">
                        <label for="email" class="form-label mb-2">Alamat Email</label>
                        <input type="email" class="form-control <?= ($validation->hasError('email')) ? 'is-invalid' : '' ?>" id="email" name="email" value="<?= old('email', $personil['email']) ?>" placeholder="Contoh: alamat@email.com">
                        <div class="invalid-feedback"><?= $validation->getError('email') ?></div>
                    </div>

                    <!-- Jenis Kelamin -->
                    <div class="col-md-6">
                        <label class="form-label mb-2">Jenis Kelamin <span class="text-danger">*</span></label>
                        <div class="d-flex gap-4 mt-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="jk_l" value="L" <?= old('jenis_kelamin', $personil['jenis_kelamin']) === 'L' ? 'checked' : '' ?> required>
                                <label class="form-check-label" for="jk_l">Laki-laki</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="jk_p" value="P" <?= old('jenis_kelamin', $personil['jenis_kelamin']) === 'P' ? 'checked' : '' ?> required>
                                <label class="form-check-label" for="jk_p">Perempuan</label>
                            </div>
                        </div>
                    </div>

                    <!-- Tipe Default (SET) -->
                    <div class="col-md-6">
                        <label class="form-label mb-2">Peran/Tipe Personel (Bisa pilih lebih dari satu)</label>
                        <div class="d-flex flex-wrap gap-3 mt-2">
                            <?php 
                                $currTipe = explode(',', $personil['tipe_default']);
                                $oldTipe = old('tipe_default');
                                $isChecked = function($val) use ($currTipe, $oldTipe) {
                                    if (is_array($oldTipe)) {
                                        return in_array($val, $oldTipe) ? 'checked' : '';
                                    }
                                    return in_array($val, $currTipe) ? 'checked' : '';
                                };
                            ?>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="tipe_default[]" id="tipe_jamaah" value="jamaah" <?= $isChecked('jamaah') ?>>
                                <label class="form-check-label" for="tipe_jamaah">Jamaah</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="tipe_default[]" id="tipe_pengurus" value="pengurus" <?= $isChecked('pengurus') ?>>
                                <label class="form-check-label" for="tipe_pengurus">Pengurus</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="tipe_default[]" id="tipe_panitia" value="panitia" <?= $isChecked('panitia') ?>>
                                <label class="form-check-label" for="tipe_panitia">Panitia</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="tipe_default[]" id="tipe_ustadz" value="ustadz" <?= $isChecked('ustadz') ?>>
                                <label class="form-check-label" for="tipe_ustadz">Ustadz/Khatib</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="tipe_default[]" id="tipe_petugas" value="petugas" <?= $isChecked('petugas') ?>>
                                <label class="form-check-label" for="tipe_petugas">Petugas/Muadzin</label>
                            </div>
                        </div>
                    </div>

                    <!-- Alamat -->
                    <div class="col-md-12">
                        <label for="alamat" class="form-label mb-2">Alamat Rumah</label>
                        <textarea class="form-control <?= ($validation->hasError('alamat')) ? 'is-invalid' : '' ?>" id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat tinggal"><?= old('alamat', $personil['alamat']) ?></textarea>
                        <div class="invalid-feedback"><?= $validation->getError('alamat') ?></div>
                    </div>

                    <!-- Foto Profil -->
                    <div class="col-md-12">
                        <label for="foto" class="form-label mb-2">Foto Profil (Biarkan kosong jika tidak ingin mengubah)</label>
                        <div class="d-flex align-items-start gap-4 mb-3">
                            <?php if ($personil['foto']) : ?>
                                <img src="<?= base_url('uploads/images/' . $personil['foto']) ?>" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;" alt="Foto Saat Ini">
                            <?php else : ?>
                                <div class="bg-light text-muted border border-light-subtle rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                    <i class="fa-solid fa-user fa-2x"></i>
                                </div>
                            <?php endif; ?>
                            
                            <div class="flex-grow-1">
                                <input type="file" class="form-control <?= ($validation->hasError('foto')) ? 'is-invalid' : '' ?>" id="foto" name="foto" accept="image/*">
                                <small class="text-muted mt-1 d-block">Format yang didukung: JPG, JPEG, PNG, WEBP. Maksimal ukuran: 2MB.</small>
                                <div class="invalid-feedback"><?= $validation->getError('foto') ?></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Aksi Form -->
                <div class="d-flex justify-content-end gap-3 border-top pt-4">
                    <a href="<?= base_url('dashboard/personil') ?>" class="btn btn-cancel">
                        <i class="fa-solid fa-arrow-left me-2"></i> Batal / Kembali
                    </a>
                    <button type="submit" class="btn btn-submit">
                        <i class="fa-solid fa-floppy-disk me-2"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </main>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
