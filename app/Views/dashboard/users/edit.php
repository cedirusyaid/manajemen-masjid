<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Data Pengguna - <?= site_name() ?></title>
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
            --shadow-md: 0 4px 20px rgba(0, 0, 0, 0.08);
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
            letter-spacing: -0.5px;
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
            margin-bottom: 30px;
        }

        .profile-card {
            user-select: none;
            transition: var(--transition);
        }
        .profile-card:hover {
            background-color: #f9fafb;
            box-shadow: var(--shadow-md);
        }
        .profile-card::after {
            display: none !important;
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
            padding: 32px;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.875rem;
            color: #374151;
            margin-bottom: 6px;
        }

        .form-control, .form-select {
            border-radius: 10px;
            padding: 10px 14px;
            border: 1px solid #d1d5db;
            font-size: 0.95rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-light);
            box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.15);
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
                <a href="<?= base_url('dashboard/users') ?>" class="menu-link active">
                    <i class="fa-solid fa-users-gear"></i> Kelola Pengguna
                </a>
            </li>
            <li>
                <a href="<?= base_url('dashboard/pelayanan') ?>" class="menu-link">
                    <i class="fa-solid fa-hand-holding-hand"></i> Pelayanan Jamaah
                </a>
            </li>
            <li>
                <a href="<?= base_url('dashboard/layanan') ?>" class="menu-link">
                    <i class="fa-solid fa-layer-group"></i> Master Layanan
                </a>
            </li>
            <li>
                <a href="<?= base_url('dashboard/jadwal-sholat') ?>" class="menu-link">
                    <i class="fa-solid fa-clock"></i> Waktu Shalat
                </a>
            </li>
            <li>
                <a href="<?= base_url('dashboard/jadwal-jumat') ?>" class="menu-link">
                    <i class="fa-solid fa-calendar-week"></i> Pelaksana Shalat Jumat
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
                <a href="<?= base_url('dashboard/personil') ?>" class="menu-link">
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
                <h1 class="h3 fw-bold mb-1 text-dark">Ubah Data Pengguna</h1>
                <p class="text-muted mb-0">Perbarui profil, hak akses (role), tautan personil, atau reset password akun.</p>
            </div>
            
            <div class="d-flex align-items-center gap-3">
                <a href="<?= base_url() ?>" target="_blank" class="btn btn-outline-success btn-sm d-flex align-items-center gap-2 rounded-pill px-3 py-2 fw-semibold shadow-sm bg-white text-decoration-none">
                    <i class="fa-solid fa-globe text-success"></i>
                    <span>Lihat Website</span>
                    <i class="fa-solid fa-arrow-up-right-from-square text-muted" style="font-size: 0.7rem;"></i>
                </a>
                <div class="dropdown">
                    <div class="profile-card dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" role="button" style="cursor: pointer;">
                        <img class="profile-avatar" src="<?= esc($avatar ?? base_url('assets/images/default-avatar.png')) ?>" alt="Avatar">
                        <div class="profile-info me-1">
                            <div class="profile-name"><?= esc($username ?? 'Pengguna') ?></div>
                            <div class="profile-role"><?= esc($role_name ?? 'Pengurus') ?></div>
                        </div>
                        <i class="fa-solid fa-chevron-down text-muted" style="font-size: 0.75rem;"></i>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3 mt-2 py-2" style="min-width: 210px;">
                        <li class="px-3 py-2 border-bottom">
                            <div class="fw-bold text-dark small"><?= esc($username ?? 'Pengguna') ?></div>
                            <div class="text-muted" style="font-size: 0.75rem;"><?= esc(session()->get('email') ?? '') ?></div>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2 py-2 text-dark small" href="<?= base_url("dashboard") ?>">
                                <i class="fa-solid fa-gauge-high text-muted"></i> Dashboard
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2 py-2 text-dark small" href="<?= base_url() ?>" target="_blank">
                                <i class="fa-solid fa-globe text-muted"></i> Halaman Publik
                                <i class="fa-solid fa-arrow-up-right-from-square ms-auto text-muted" style="font-size: 0.7rem;"></i>
                            </a>
                        </li>
                        <li><hr class="dropdown-divider my-1"></li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2 py-2 text-danger small" href="<?= base_url("logout") ?>">
                                <i class="fa-solid fa-arrow-right-from-bracket"></i> Keluar (Logout)
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger d-flex align-items-center gap-2 mb-4 border-0" role="alert">
                <i class="fa-solid fa-circle-exclamation"></i>
                <div><?= session()->getFlashdata('error') ?></div>
            </div>
        <?php endif; ?>

        <div class="panel-card" style="max-width: 800px;">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-primary text-white px-3 py-2 rounded-pill font-heading">
                        <i class="fa-solid fa-user me-1"></i> <?= esc($user['username']) ?>
                    </span>
                    <h5 class="fw-bold mb-0 text-dark">Edit Akun Pengguna</h5>
                </div>
                <a href="<?= base_url('dashboard/users') ?>" class="btn btn-outline-secondary rounded-pill px-3 py-1 btn-sm">
                    <i class="fa-solid fa-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <form action="<?= base_url('dashboard/users/update/' . $user['id']) ?>" method="POST">
                <?= csrf_field() ?>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Username <span class="text-danger">*</span></label>
                        <input type="text" name="username" class="form-control" value="<?= old('username', $user['username']) ?>" required autocomplete="off">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email Resmi <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" value="<?= old('email', $user['email']) ?>" required>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Role / Hak Akses <span class="text-danger">*</span></label>
                        <select name="role_id" class="form-select" required>
                            <?php foreach ($roles as $r) : ?>
                                <option value="<?= $r['id'] ?>" <?= (string)old('role_id', $user['role_id']) === (string)$r['id'] ? 'selected' : '' ?>>
                                    <?= esc($r['name']) ?> (<?= esc($r['description']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Status Akun <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="active" <?= old('status', $user['status']) === 'active' ? 'selected' : '' ?>>Aktif (Dapat Login)</option>
                            <option value="inactive" <?= old('status', $user['status']) === 'inactive' ? 'selected' : '' ?>>Non-Aktif (Terkunci)</option>
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Tautkan ke Master Personel (Opsional)</label>
                    <select name="personil_id" class="form-select">
                        <option value="">-- Tidak Ditautkan ke Personil --</option>
                        <?php foreach ($personils as $p) : ?>
                            <option value="<?= $p['id'] ?>" <?= old('personil_id', $user['personil_id']) === $p['id'] ? 'selected' : '' ?>>
                                <?= esc($p['nama']) ?> (<?= esc($p['no_hp'] ?: 'Tanpa No HP') ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Penugasan Kepanitiaan (Many-to-Many) -->
                <div class="p-3 bg-light rounded-3 mb-4 border border-light-subtle">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <i class="fa-solid fa-people-group text-success"></i>
                        <h6 class="fw-bold text-dark mb-0">Penugasan Kepanitiaan / Proyek (Multi-Kepanitiaan)</h6>
                    </div>
                    <p class="text-muted small mb-3">Centang satu atau lebih kepanitiaan yang menjadi wewenang akun ini (akun dapat mengelola banyak kepanitiaan sekaligus).</p>

                    <?php if (!empty($kegiatans)) : ?>
                        <div class="row g-2">
                            <?php foreach ($kegiatans as $keg) : ?>
                                <?php 
                                $isChecked = in_array($keg['id'], old('kegiatan_ids', $assigned_kegiatan_ids ?? []));
                                ?>
                                <div class="col-md-6">
                                    <div class="form-check p-2 border rounded bg-white shadow-none">
                                        <input class="form-check-input ms-1 me-2" type="checkbox" name="kegiatan_ids[]" value="<?= $keg['id'] ?>" id="keg_<?= $keg['id'] ?>" <?= $isChecked ? 'checked' : '' ?>>
                                        <label class="form-check-label fw-semibold text-dark small cursor-pointer" for="keg_<?= $keg['id'] ?>">
                                            <?= esc($keg['nama_kegiatan']) ?>
                                            <span class="badge bg-light text-secondary border ms-1" style="font-size: 0.65rem;"><?= ucfirst($keg['status']) ?></span>
                                        </label>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else : ?>
                        <small class="text-muted italic"><i class="fa-solid fa-circle-info me-1"></i>Belum ada data kepanitiaan aktif.</small>
                    <?php endif; ?>
                </div>

                <!-- Reset Password Box -->
                <div class="p-3 bg-light rounded-3 mb-4 border border-light-subtle">
                    <h6 class="fw-bold text-dark mb-2"><i class="fa-solid fa-key text-warning me-2"></i>Reset Password (Opsional)</h6>
                    <p class="text-muted small mb-2">Kosongkan kolom password jika tidak ingin mengubah kata sandi akun ini.</p>
                    <div class="row g-2">
                        <div class="col-md-8">
                            <input type="password" name="password" class="form-control" placeholder="Masukkan password baru (minimal 6 karakter)" autocomplete="new-password">
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 pt-2 border-top">
                    <a href="<?= base_url('dashboard/users') ?>" class="btn btn-light px-4">Batal</a>
                    <button type="submit" class="btn btn-submit">
                        <i class="fa-solid fa-save me-2"></i> Perbarui Akun
                    </button>
                </div>
            </form>
        </div>
    </main>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
