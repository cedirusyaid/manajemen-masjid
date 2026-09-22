<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Waktu Shalat - <?= site_name() ?></title>
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
            padding: 24px;
        }

        .btn-add {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: var(--white);
            border: none;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 10px;
            transition: var(--transition);
        }

        .btn-add:hover {
            opacity: 0.95;
            box-shadow: 0 4px 12px rgba(6, 78, 59, 0.25);
            color: var(--white);
        }

        .btn-action {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
            border: none;
            text-decoration: none;
        }

        .btn-edit {
            background-color: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
        }

        .btn-edit:hover {
            background-color: #3b82f6;
            color: var(--white);
        }

        .btn-delete {
            background-color: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }

        .btn-delete:hover {
            background-color: #ef4444;
            color: var(--white);
        }

        .table th {
            background-color: #f9fafb;
            color: #374151;
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 14px 12px;
            border-bottom: 1.5px solid #e5e7eb;
        }

        .table td {
            padding: 12px;
            vertical-align: middle;
            font-size: 0.9rem;
            border-bottom: 1px solid #f3f4f6;
        }

        .row-today {
            background-color: rgba(16, 185, 129, 0.08) !important;
            font-weight: 600;
        }

        .month-pill {
            padding: 8px 16px;
            border-radius: 20px;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 600;
            transition: var(--transition);
            border: 1px solid #e5e7eb;
            background: #ffffff;
            color: #374151;
            display: inline-block;
        }

        .month-pill:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        .month-pill.active {
            background-color: var(--primary);
            color: #ffffff;
            border-color: var(--primary);
            box-shadow: 0 2px 8px rgba(6, 78, 59, 0.25);
        }

        .today-card {
            background: linear-gradient(135deg, #022c22 0%, #064e3b 100%);
            color: #ffffff;
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 24px;
        }

        .prayer-badge {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            padding: 10px 14px;
            text-align: center;
        }

        .prayer-badge .name {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 4px;
        }

        .prayer-badge .time {
            font-size: 1.15rem;
            font-weight: 700;
            font-family: 'Outfit', sans-serif;
            color: #ffffff;
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
                <h1 class="h3 fw-bold mb-1 text-dark">Master Jadwal Waktu Shalat</h1>
                <p class="text-muted mb-0">Rujukan hisab dan penentuan waktu shalat tahunan resmi Masjid Agung Nujumul Ittihad Sinjai.</p>
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

        <!-- Flash Messages -->
        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success d-flex align-items-center gap-2 mb-4 border-0" role="alert">
                <i class="fa-solid fa-circle-check"></i>
                <div><?= session()->getFlashdata('success') ?></div>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger d-flex align-items-center gap-2 mb-4 border-0" role="alert">
                <i class="fa-solid fa-circle-exclamation"></i>
                <div><?= session()->getFlashdata('error') ?></div>
            </div>
        <?php endif; ?>

        <!-- HIGHLIGHT HARI INI -->
        <?php if (!empty($hari_ini)) : ?>
            <div class="today-card shadow-sm">
                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                    <div>
                        <span class="badge bg-warning text-dark font-heading fw-bold px-3 py-1 rounded-pill mb-1">
                            <i class="fa-solid fa-calendar-day me-1"></i> HARI INI
                        </span>
                        <h4 class="fw-bold mb-0 font-heading text-white">
                            <?= date('d') ?> <?= $nama_bulan[(int)date('n')] ?> <?= date('Y') ?>
                        </h4>
                    </div>
                    <div class="text-white-50 small">
                        <i class="fa-solid fa-location-dot text-warning me-1"></i> Sinjai, Sulawesi Selatan (WITA)
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-6 col-md-3 col-lg">
                        <div class="prayer-badge">
                            <div class="name">Imsak</div>
                            <div class="time"><?= esc($hari_ini['imsak']) ?></div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3 col-lg">
                        <div class="prayer-badge" style="background: rgba(16, 185, 129, 0.2); border-color: rgba(16, 185, 129, 0.4);">
                            <div class="name" style="color: #6ee7b7;">Subuh</div>
                            <div class="time"><?= esc($hari_ini['subuh']) ?></div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3 col-lg">
                        <div class="prayer-badge">
                            <div class="name">Terbit</div>
                            <div class="time"><?= esc($hari_ini['terbit']) ?></div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3 col-lg">
                        <div class="prayer-badge">
                            <div class="name">Dhuha</div>
                            <div class="time"><?= esc($hari_ini['dhuha']) ?></div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3 col-lg">
                        <div class="prayer-badge" style="background: rgba(16, 185, 129, 0.2); border-color: rgba(16, 185, 129, 0.4);">
                            <div class="name" style="color: #6ee7b7;">Dzuhur</div>
                            <div class="time"><?= esc($hari_ini['dzuhur']) ?></div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3 col-lg">
                        <div class="prayer-badge" style="background: rgba(16, 185, 129, 0.2); border-color: rgba(16, 185, 129, 0.4);">
                            <div class="name" style="color: #6ee7b7;">Ashar</div>
                            <div class="time"><?= esc($hari_ini['ashar']) ?></div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3 col-lg">
                        <div class="prayer-badge" style="background: rgba(217, 119, 6, 0.2); border-color: rgba(217, 119, 6, 0.4);">
                            <div class="name" style="color: #fcd34d;">Maghrib</div>
                            <div class="time"><?= esc($hari_ini['maghrib']) ?></div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3 col-lg">
                        <div class="prayer-badge" style="background: rgba(16, 185, 129, 0.2); border-color: rgba(16, 185, 129, 0.4);">
                            <div class="name" style="color: #6ee7b7;">Isya</div>
                            <div class="time"><?= esc($hari_ini['isya']) ?></div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- PENGATURAN DURASI BLANK LAYAR DISPLAY -->
        <div class="panel-card mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <div>
                    <h5 class="fw-bold mb-1 text-dark">
                        <i class="fa-solid fa-tv me-2 text-primary"></i>
                        Pengaturan Waktu Layar Padam (Blank Screen) Display TV
                    </h5>
                    <p class="text-muted small mb-0">
                        Atur durasi otomatis layar TV display menjadi gelap total (blank) saat shalat berjamaah berlangsung agar tidak mengganggu kekhusyukan jamaah.
                    </p>
                </div>
                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3" data-bs-toggle="collapse" data-bs-target="#collapseBlankSettings" aria-expanded="true">
                    <i class="fa-solid fa-sliders me-1"></i> Buka / Tutup Pengaturan
                </button>
            </div>

            <div class="collapse show" id="collapseBlankSettings">
                <form action="<?= base_url('dashboard/jadwal-sholat/save-blank-settings') ?>" method="POST">
                    <?= csrf_field() ?>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <div class="p-3 rounded-3 bg-light border">
                                <label class="form-label fw-bold text-dark mb-1">
                                    <i class="fa-solid fa-hourglass-start me-1 text-warning"></i> Waktu Mulai Blank Sebelum Adzan / Waktu Shalat Masuk (Menit)
                                </label>
                                <div class="row align-items-center">
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <input type="number" name="blank_before_prayer" class="form-control" min="0" max="60" value="<?= esc($settings['blank_before_prayer'] ?? '0') ?>" required>
                                            <span class="input-group-text">Menit Sebelum</span>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <small class="text-muted">Isi <code>0</code> jika layar mulai padam tepat saat waktu shalat / adzan masuk (tanpa jeda sebelum).</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 col-md-4 col-lg-2">
                            <label class="form-label small fw-bold text-muted text-uppercase mb-1">Subuh</label>
                            <div class="input-group input-group-sm">
                                <input type="number" name="blank_duration_subuh" class="form-control" min="1" max="120" value="<?= esc($settings['blank_duration_subuh'] ?? '25') ?>" required>
                                <span class="input-group-text">Mnt</span>
                            </div>
                            <small class="text-muted" style="font-size: 0.72rem;">Durasi setelah adzan</small>
                        </div>

                        <div class="col-6 col-md-4 col-lg-2">
                            <label class="form-label small fw-bold text-muted text-uppercase mb-1">Dzuhur</label>
                            <div class="input-group input-group-sm">
                                <input type="number" name="blank_duration_dzuhur" class="form-control" min="1" max="120" value="<?= esc($settings['blank_duration_dzuhur'] ?? '20') ?>" required>
                                <span class="input-group-text">Mnt</span>
                            </div>
                            <small class="text-muted" style="font-size: 0.72rem;">Durasi setelah adzan</small>
                        </div>

                        <div class="col-6 col-md-4 col-lg-2">
                            <label class="form-label small fw-bold text-muted text-uppercase mb-1">Ashar</label>
                            <div class="input-group input-group-sm">
                                <input type="number" name="blank_duration_ashar" class="form-control" min="1" max="120" value="<?= esc($settings['blank_duration_ashar'] ?? '20') ?>" required>
                                <span class="input-group-text">Mnt</span>
                            </div>
                            <small class="text-muted" style="font-size: 0.72rem;">Durasi setelah adzan</small>
                        </div>

                        <div class="col-6 col-md-4 col-lg-2">
                            <label class="form-label small fw-bold text-muted text-uppercase mb-1">Maghrib</label>
                            <div class="input-group input-group-sm">
                                <input type="number" name="blank_duration_maghrib" class="form-control" min="1" max="120" value="<?= esc($settings['blank_duration_maghrib'] ?? '20') ?>" required>
                                <span class="input-group-text">Mnt</span>
                            </div>
                            <small class="text-muted" style="font-size: 0.72rem;">Durasi setelah adzan</small>
                        </div>

                        <div class="col-6 col-md-4 col-lg-2">
                            <label class="form-label small fw-bold text-muted text-uppercase mb-1">Isya</label>
                            <div class="input-group input-group-sm">
                                <input type="number" name="blank_duration_isya" class="form-control" min="1" max="120" value="<?= esc($settings['blank_duration_isya'] ?? '25') ?>" required>
                                <span class="input-group-text">Mnt</span>
                            </div>
                            <small class="text-muted" style="font-size: 0.72rem;">Durasi setelah adzan</small>
                        </div>

                        <div class="col-6 col-md-4 col-lg-2">
                            <label class="form-label small fw-bold text-muted text-uppercase mb-1 text-success">Jumat (Khotbah)</label>
                            <div class="input-group input-group-sm">
                                <input type="number" name="blank_duration_jumat" class="form-control" min="1" max="180" value="<?= esc($settings['blank_duration_jumat'] ?? '45') ?>" required>
                                <span class="input-group-text">Mnt</span>
                            </div>
                            <small class="text-muted" style="font-size: 0.72rem;">Khusus hari Jumat</small>
                        </div>

                        <div class="col-md-12">
                            <div class="p-3 rounded-3 bg-white border d-flex justify-content-between align-items-center flex-wrap gap-3">
                                <div>
                                    <label class="form-label fw-bold text-dark mb-1">
                                        <i class="fa-solid fa-clock-rotate-left me-1 text-info"></i> Durasi Pergantian Tiap Slide Slideshow (Detik)
                                    </label>
                                    <small class="text-muted d-block">Lama waktu tampilan per halaman (Pengumuman, Agenda, Keuangan, Proyek, Pelaksana Shalat Jumat, Donasi) sebelum beralih ke slide berikutnya.</small>
                                </div>
                                <div style="width: 180px;">
                                    <div class="input-group">
                                        <input type="number" name="slideshow_duration" class="form-control fw-bold text-center text-primary" min="3" max="120" value="<?= esc($settings['slideshow_duration'] ?? '10') ?>" required>
                                        <span class="input-group-text fw-semibold">Detik</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 text-end mt-3 pt-2 border-top">
                            <button type="submit" class="btn btn-primary btn-sm px-4 rounded-pill fw-semibold shadow-sm">
                                <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Pengaturan Display TV
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- MONTH SELECTOR TABS -->
        <div class="d-flex flex-wrap gap-2 mb-4">
            <?php foreach ($nama_bulan as $num => $nama) : ?>
                <a href="<?= base_url("dashboard/jadwal-sholat?bulan={$num}") ?>" class="month-pill <?= $bulan_aktif === $num ? 'active' : '' ?>">
                    <?= $nama ?>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- MAIN TABLE PANEL -->
        <div class="panel-card">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <div>
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="fa-solid fa-calendar-days me-2 text-success"></i>
                        Jadwal Bulan <?= $nama_bulan[$bulan_aktif] ?>
                    </h5>
                    <small class="text-muted">Daftar waktu hisab shalat per hari untuk bulan <?= $nama_bulan[$bulan_aktif] ?>.</small>
                </div>
                <div class="d-flex gap-2">
                    <a href="<?= base_url('dashboard/jadwal-sholat/reset-tahunan') ?>" onclick="return confirm('Apakah Anda yakin ingin me-reset seluruh 366 hari ke default hisab rujukan resmi?');" class="btn btn-outline-secondary rounded-3 px-3 py-2 fw-semibold" style="font-size: 0.875rem;">
                        <i class="fa-solid fa-rotate me-1"></i> Reset / Re-generate
                    </a>
                    <a href="<?= base_url('dashboard/jadwal-sholat/create') ?>" class="btn btn-add">
                        <i class="fa-solid fa-plus me-1"></i> Tambah Manual
                    </a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr class="text-center">
                            <th class="text-start" style="width: 80px;">Tgl</th>
                            <th>Imsak</th>
                            <th class="text-success">Subuh</th>
                            <th>Terbit</th>
                            <th>Dhuha</th>
                            <th class="text-success">Dzuhur</th>
                            <th class="text-success">Ashar</th>
                            <th class="text-warning-emphasis">Maghrib</th>
                            <th class="text-success">Isya</th>
                            <th class="text-start">Keterangan</th>
                            <th style="width: 90px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($jadwal_list)) : ?>
                            <?php 
                            $currDay = (int) date('j');
                            $currMonth = (int) date('n');
                            ?>
                            <?php foreach ($jadwal_list as $row) : ?>
                                <?php $isToday = ($bulan_aktif === $currMonth && (int)$row['tanggal'] === $currDay); ?>
                                <tr class="<?= $isToday ? 'row-today' : '' ?>">
                                    <td class="text-start">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="badge <?= $isToday ? 'bg-success text-white' : 'bg-light text-dark border' ?> px-2 py-1 rounded">
                                                Tgl <?= sprintf('%02d', $row['tanggal']) ?>
                                            </span>
                                            <?php if ($isToday) : ?>
                                                <small class="text-success fw-bold">(Hari Ini)</small>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="text-center text-muted"><?= esc($row['imsak']) ?></td>
                                    <td class="text-center fw-bold text-success"><?= esc($row['subuh']) ?></td>
                                    <td class="text-center text-muted"><?= esc($row['terbit']) ?></td>
                                    <td class="text-center text-muted"><?= esc($row['dhuha']) ?></td>
                                    <td class="text-center fw-bold text-success"><?= esc($row['dzuhur']) ?></td>
                                    <td class="text-center fw-bold text-success"><?= esc($row['ashar']) ?></td>
                                    <td class="text-center fw-bold text-warning-emphasis"><?= esc($row['maghrib']) ?></td>
                                    <td class="text-center fw-bold text-success"><?= esc($row['isya']) ?></td>
                                    <td class="text-start">
                                        <small class="text-muted"><?= esc($row['keterangan'] ?: '-') ?></small>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <a href="<?= base_url('dashboard/jadwal-sholat/edit/' . $row['id']) ?>" class="btn-action btn-edit" title="Ubah">
                                                <i class="fa-solid fa-pencil"></i>
                                            </a>
                                            <a href="<?= base_url('dashboard/jadwal-sholat/delete/' . $row['id']) ?>" class="btn-action btn-delete" onclick="return confirm('Hapus jadwal tanggal <?= $row['tanggal'] ?> <?= $nama_bulan[$bulan_aktif] ?>?');" title="Hapus">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="11" class="text-center py-5 text-muted">
                                    <i class="fa-regular fa-calendar-xmark d-block fs-3 mb-2"></i>
                                    Belum ada data jadwal sholat untuk bulan ini.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
