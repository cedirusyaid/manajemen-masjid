<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengguna Sistem - <?= site_name() ?></title>
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

        .stat-card {
            background-color: var(--white);
            border-radius: 16px;
            padding: 20px;
            box-shadow: var(--shadow-sm);
            border: 1px solid rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: var(--transition);
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .stat-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--dark-navy);
            line-height: 1.1;
        }

        .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .icon-primary { background-color: rgba(6, 78, 59, 0.1); color: var(--primary); }
        .icon-success { background-color: rgba(16, 185, 129, 0.1); color: #10b981; }
        .icon-warning { background-color: rgba(217, 119, 6, 0.1); color: var(--accent); }
        .icon-danger { background-color: rgba(239, 68, 68, 0.1); color: #ef4444; }

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
            text-decoration: none;
            display: inline-flex;
            align-items: center;
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

        .btn-edit { background-color: rgba(59, 130, 246, 0.1); color: #3b82f6; }
        .btn-edit:hover { background-color: #3b82f6; color: var(--white); }

        .btn-toggle { background-color: rgba(217, 119, 6, 0.1); color: #d97706; }
        .btn-toggle:hover { background-color: #d97706; color: var(--white); }

        .btn-delete { background-color: rgba(239, 68, 68, 0.1); color: #ef4444; }
        .btn-delete:hover { background-color: #ef4444; color: var(--white); }

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
            padding: 14px 12px;
            vertical-align: middle;
            font-size: 0.9rem;
            border-bottom: 1px solid #f3f4f6;
        }

        .user-avatar-sm {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #e5e7eb;
        }

        .badge-role-1 { background-color: rgba(220, 38, 38, 0.1); color: #dc2626; border: 1px solid rgba(220, 38, 38, 0.2); }
        .badge-role-2 { background-color: rgba(16, 185, 129, 0.1); color: #059669; border: 1px solid rgba(16, 185, 129, 0.2); }
        .badge-role-3 { background-color: rgba(14, 165, 233, 0.1); color: #0284c7; border: 1px solid rgba(14, 165, 233, 0.2); }
        .badge-role-4 { background-color: rgba(147, 51, 234, 0.1); color: #7e22ce; border: 1px solid rgba(147, 51, 234, 0.2); }
        .badge-role-5 { background-color: rgba(107, 114, 128, 0.1); color: #4b5563; border: 1px solid rgba(107, 114, 128, 0.2); }
        .badge-role-6 { background-color: rgba(217, 119, 6, 0.1); color: #b45309; border: 1px solid rgba(217, 119, 6, 0.2); }
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
                <h1 class="h3 fw-bold mb-1 text-dark">Manajemen Pengguna Sistem</h1>
                <p class="text-muted mb-0">Kelola akun administrator, bendahara pengurus, panitia pembangunan, dan hak akses pengguna.</p>
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

        <!-- KPI STATS CARDS -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="stat-card">
                    <div>
                        <div class="stat-label">Total Pengguna</div>
                        <div class="stat-value text-dark"><?= $stats['total'] ?></div>
                    </div>
                    <div class="stat-icon icon-primary">
                        <i class="fa-solid fa-users"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card">
                    <div>
                        <div class="stat-label">Akun Aktif</div>
                        <div class="stat-value text-success"><?= $stats['active'] ?></div>
                    </div>
                    <div class="stat-icon icon-success">
                        <i class="fa-solid fa-user-check"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card">
                    <div>
                        <div class="stat-label">Non-Aktif / Terkunci</div>
                        <div class="stat-value text-danger"><?= $stats['inactive'] ?></div>
                    </div>
                    <div class="stat-icon icon-danger">
                        <i class="fa-solid fa-user-xmark"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card">
                    <div>
                        <div class="stat-label">Super Administrator</div>
                        <div class="stat-value text-warning"><?= $stats['super'] ?></div>
                    </div>
                    <div class="stat-icon icon-warning">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- MAIN USER TABLE PANEL -->
        <div class="panel-card">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <div>
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="fa-solid fa-user-shield me-2 text-success"></i>Daftar Pengguna Terdaftar
                    </h5>
                    <small class="text-muted">Daftar akun login pengurus & staf pengelola sistem masjid.</small>
                </div>
                <a href="<?= base_url('dashboard/users/create') ?>" class="btn btn-add">
                    <i class="fa-solid fa-user-plus me-2"></i> Tambah Pengguna
                </a>
            </div>

            <!-- FILTER & SEARCH BAR -->
            <form action="<?= base_url('dashboard/users') ?>" method="GET" class="row g-2 mb-4">
                <div class="col-md-4">
                    <input type="text" name="q" class="form-control" placeholder="Cari username, email, atau personil..." value="<?= esc($filter_keyword) ?>">
                </div>
                <div class="col-md-3">
                    <select name="role_id" class="form-select">
                        <option value="">-- Semua Hak Akses (Role) --</option>
                        <?php foreach ($roles as $r) : ?>
                            <option value="<?= $r['id'] ?>" <?= (string)$filter_role === (string)$r['id'] ? 'selected' : '' ?>>
                                <?= esc($r['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">-- Semua Status --</option>
                        <option value="active" <?= $filter_status === 'active' ? 'selected' : '' ?>>Aktif (Active)</option>
                        <option value="inactive" <?= $filter_status === 'inactive' ? 'selected' : '' ?>>Non-Aktif (Inactive)</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-1">
                    <button type="submit" class="btn btn-dark w-100 fw-semibold">
                        <i class="fa-solid fa-magnifying-glass me-1"></i> Filter
                    </button>
                    <?php if (!empty($filter_role) || !empty($filter_status) || !empty($filter_keyword)) : ?>
                        <a href="<?= base_url('dashboard/users') ?>" class="btn btn-outline-secondary" title="Reset Filter">
                            <i class="fa-solid fa-xmark"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th style="width: 60px;">Avatar</th>
                            <th>Pengguna (Username / Email)</th>
                            <th>Personil / Pengurus Terkait</th>
                            <th>Role / Hak Akses</th>
                            <th class="text-center">Status</th>
                            <th>Terdaftar</th>
                            <th class="text-center" style="width: 120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($users)) : ?>
                            <?php foreach ($users as $u) : ?>
                                <?php $isSelf = ($u['id'] === $current_user_id); ?>
                                <tr>
                                    <td>
                                        <img src="<?= esc($u['avatar'] ?: 'https://ui-avatars.com/api/?name=' . urlencode($u['username']) . '&background=064e3b&color=fff') ?>" alt="Avatar" class="user-avatar-sm">
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark d-flex align-items-center gap-1">
                                            <?= esc($u['username']) ?>
                                            <?php if ($isSelf) : ?>
                                                <span class="badge bg-primary text-white rounded-pill px-2 py-0.5" style="font-size: 0.65rem;">Anda</span>
                                            <?php endif; ?>
                                        </div>
                                        <small class="text-muted"><i class="fa-regular fa-envelope me-1"></i><?= esc($u['email']) ?></small>
                                    </td>
                                    <td>
                                        <?php if (!empty($u['nama_personil'])) : ?>
                                            <div class="fw-semibold text-dark"><i class="fa-solid fa-user-tie text-success me-1"></i><?= esc($u['nama_personil']) ?></div>
                                            <?php if (!empty($u['no_hp_personil'])) : ?>
                                                <small class="text-muted"><i class="fa-brands fa-whatsapp me-1 text-success"></i><?= esc($u['no_hp_personil']) ?></small>
                                            <?php endif; ?>
                                        <?php else : ?>
                                            <span class="text-muted italic small"><i class="fa-solid fa-link-slash me-1"></i>Belum ditautkan</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php 
                                        $roleClass = 'badge-role-' . ($u['role_id'] ?? 5);
                                        ?>
                                        <div class="mb-1">
                                            <span class="badge <?= $roleClass ?> rounded-pill px-3 py-1.5 fw-bold font-heading">
                                                <?= esc($u['role_name'] ?? 'User') ?>
                                            </span>
                                        </div>
                                        <?php if (!empty($u['kepanitiaan_list'])) : ?>
                                            <div class="d-flex flex-wrap gap-1 mt-1">
                                                <?php foreach ($u['kepanitiaan_list'] as $keg) : ?>
                                                    <span class="badge bg-warning bg-opacity-10 text-warning-emphasis border border-warning border-opacity-25 rounded font-heading px-2 py-0.5" style="font-size: 0.7rem;" title="<?= esc($keg['nama_kegiatan']) ?>">
                                                        <i class="fa-solid fa-people-group me-1"></i><?= esc(mb_strimwidth($keg['nama_kegiatan'], 0, 24, '...')) ?>
                                                    </span>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($u['status'] === 'active') : ?>
                                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3 py-1">
                                                <i class="fa-solid fa-circle-check me-1"></i> Aktif
                                            </span>
                                        <?php else : ?>
                                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill px-3 py-1">
                                                <i class="fa-solid fa-circle-xmark me-1"></i> Non-Aktif
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <small class="text-muted"><?= date('d/m/Y H:i', strtotime($u['created_at'])) ?></small>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <a href="<?= base_url('dashboard/users/edit/' . $u['id']) ?>" class="btn-action btn-edit" title="Ubah Profil / Reset Password">
                                                <i class="fa-solid fa-pencil"></i>
                                            </a>
                                            <?php if (!$isSelf) : ?>
                                                <a href="<?= base_url('dashboard/users/toggle-status/' . $u['id']) ?>" class="btn-action btn-toggle" title="<?= $u['status'] === 'active' ? 'Nonaktifkan Akun' : 'Aktifkan Akun' ?>" onclick="return confirm('Apakah Anda yakin ingin <?= $u['status'] === 'active' ? 'menonaktifkan' : 'mengaktifkan' ?> akun ini?');">
                                                    <i class="fa-solid <?= $u['status'] === 'active' ? 'fa-user-lock' : 'fa-user-check' ?>"></i>
                                                </a>
                                                <a href="<?= base_url('dashboard/users/delete/' . $u['id']) ?>" class="btn-action btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus akun <?= esc($u['username']) ?>?');" title="Hapus Akun">
                                                    <i class="fa-solid fa-trash"></i>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-users-slash d-block fs-2 mb-2"></i>
                                    Tidak ada data pengguna yang sesuai dengan filter pencarian.
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
