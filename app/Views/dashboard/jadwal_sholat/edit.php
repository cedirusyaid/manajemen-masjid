<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Jadwal Waktu Shalat - <?= site_name() ?></title>
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
                <a href="<?= base_url('dashboard/jadwal-sholat') ?>" class="menu-link active">
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
                <h1 class="h3 fw-bold mb-1 text-dark">Ubah Jadwal Waktu Shalat</h1>
                <p class="text-muted mb-0">Sesuaikan waktu shalat untuk Tanggal <?= sprintf('%02d', $jadwal['tanggal']) ?> <?= $nama_bulan[$jadwal['bulan']] ?>.</p>
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
                    <span class="badge bg-success text-white px-3 py-2 rounded-pill font-heading">
                        <i class="fa-solid fa-calendar-day me-1"></i> Tgl <?= sprintf('%02d', $jadwal['tanggal']) ?> <?= $nama_bulan[$jadwal['bulan']] ?>
                    </span>
                    <h5 class="fw-bold mb-0 text-dark">Penyesuaian Jam Shalat</h5>
                </div>
                <a href="<?= base_url('dashboard/jadwal-sholat?bulan=' . $jadwal['bulan']) ?>" class="btn btn-outline-secondary rounded-pill px-3 py-1 btn-sm">
                    <i class="fa-solid fa-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <form action="<?= base_url('dashboard/jadwal-sholat/update/' . $jadwal['id']) ?>" method="POST">
                <?= csrf_field() ?>

                <div class="p-3 bg-light rounded-3 mb-4">
                    <h6 class="fw-bold text-dark mb-3"><i class="fa-solid fa-clock text-success me-2"></i>Rincian Waktu Shalat (Format HH:MM)</h6>
                    <div class="row g-3">
                        <div class="col-6 col-md-3">
                            <label class="form-label small">Subuh <span class="text-danger">*</span></label>
                            <input type="text" name="subuh" class="form-control fw-bold text-success" value="<?= old('subuh', $jadwal['subuh']) ?>" required>
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="form-label small">Dzuhur <span class="text-danger">*</span></label>
                            <input type="text" name="dzuhur" class="form-control fw-bold text-success" value="<?= old('dzuhur', $jadwal['dzuhur']) ?>" required>
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="form-label small">Ashar <span class="text-danger">*</span></label>
                            <input type="text" name="ashar" class="form-control fw-bold text-success" value="<?= old('ashar', $jadwal['ashar']) ?>" required>
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="form-label small">Maghrib <span class="text-danger">*</span></label>
                            <input type="text" name="maghrib" class="form-control fw-bold text-warning-emphasis" value="<?= old('maghrib', $jadwal['maghrib']) ?>" required>
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="form-label small">Isya <span class="text-danger">*</span></label>
                            <input type="text" name="isya" class="form-control fw-bold text-success" value="<?= old('isya', $jadwal['isya']) ?>" required>
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="form-label small">Imsak</label>
                            <input type="text" name="imsak" class="form-control" value="<?= old('imsak', $jadwal['imsak']) ?>">
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="form-label small">Terbit</label>
                            <input type="text" name="terbit" class="form-control" value="<?= old('terbit', $jadwal['terbit']) ?>">
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="form-label small">Dhuha</label>
                            <input type="text" name="dhuha" class="form-control" value="<?= old('dhuha', $jadwal['dhuha']) ?>">
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Keterangan / Catatan</label>
                    <input type="text" name="keterangan" class="form-control" value="<?= old('keterangan', $jadwal['keterangan']) ?>" placeholder="Contoh: Rujukan Hisab / Penyesuaian BHR Sinjai">
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="<?= base_url('dashboard/jadwal-sholat?bulan=' . $jadwal['bulan']) ?>" class="btn btn-light px-4">Batal</a>
                    <button type="submit" class="btn btn-submit">
                        <i class="fa-solid fa-save me-2"></i> Perbarui Jadwal
                    </button>
                </div>
            </form>
        </div>
    </main>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
