<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - <?= site_name() ?></title>
    <!-- Google Fonts: Inter & Outfit -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #064e3b;      /* Emerald Green */
            --primary-light: #0f766e;
            --accent: #d97706;       /* Gold/Amber */
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

        /* ----------------------------------------------------------------------
         * Sidebar Navigation
         * ---------------------------------------------------------------------- */
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
            transition: var(--transition);
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

        /* ----------------------------------------------------------------------
         * Main Content Wrapper
         * ---------------------------------------------------------------------- */
        .main-content {
            margin-left: var(--sidebar-width);
            flex-grow: 1;
            padding: 40px;
            max-width: calc(100% - var(--sidebar-width));
        }

        /* ----------------------------------------------------------------------
         * Top Navbar / Profile Bar
         * ---------------------------------------------------------------------- */
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

        .profile-info {
            line-height: 1.2;
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

        /* ----------------------------------------------------------------------
         * Stats Cards
         * ---------------------------------------------------------------------- */
        .stat-card {
            background-color: var(--white);
            border-radius: 16px;
            padding: 24px;
            box-shadow: var(--shadow-sm);
            border: 1px solid rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: var(--transition);
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
        }

        .stat-info {
            display: flex;
            flex-direction: column;
        }

        .stat-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }

        .stat-value {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--dark-navy);
            line-height: 1.1;
        }

        .stat-icon {
            width: 54px;
            height: 54px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .icon-primary { background-color: rgba(6, 78, 59, 0.1); color: var(--primary); }
        .icon-accent { background-color: rgba(217, 119, 6, 0.1); color: var(--accent); }
        .icon-teal { background-color: rgba(15, 118, 110, 0.1); color: var(--primary-light); }
        .icon-blue { background-color: rgba(37, 99, 235, 0.1); color: #2563eb; }

        /* ----------------------------------------------------------------------
         * Content Panels
         * ---------------------------------------------------------------------- */
        .panel-card {
            background-color: var(--white);
            border-radius: 16px;
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: var(--shadow-sm);
            padding: 24px;
            margin-bottom: 30px;
        }

        .panel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 1px solid #f3f4f6;
        }

        .panel-title {
            font-weight: 700;
            font-size: 1.1rem;
            color: var(--dark-navy);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .panel-title i {
            color: var(--primary);
        }

        /* Audit Logs List */
        .log-item {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            padding: 14px 0;
            border-bottom: 1px solid #f3f4f6;
        }

        .log-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .log-badge {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            flex-shrink: 0;
        }

        .badge-insert { background-color: rgba(16, 185, 129, 0.1); color: #10b981; }
        .badge-update { background-color: rgba(59, 130, 246, 0.1); color: #3b82f6; }
        .badge-delete { background-color: rgba(239, 68, 68, 0.1); color: #ef4444; }
        .badge-auth { background-color: rgba(107, 114, 128, 0.1); color: #6b7280; }

        .log-details {
            flex-grow: 1;
            font-size: 0.875rem;
        }

        .log-text {
            color: #374151;
            margin-bottom: 3px;
        }

        .log-meta {
            font-size: 0.75rem;
            color: #9ca3af;
            display: flex;
            gap: 12px;
        }
    </style>
</head>
<body>

    <!-- SIDEBAR MENU UTAMA -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <a href="<?= base_url('dashboard') ?>" class="sidebar-brand">
                <i class="fa-solid fa-mosque me-2"></i>Masjid Agung
            </a>
        </div>
        
        <ul class="sidebar-menu">
            <li>
                <a href="<?= base_url('dashboard') ?>" class="menu-link active">
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

    <!-- KONTEN UTAMA -->
    <main class="main-content">
        <!-- TOPBAR PROFILE & INFO -->
        <div class="topbar">
            <div>
                <h1 class="h3 fw-bold mb-1 text-dark">Dashboard Ringkasan</h1>
                <p class="text-muted mb-0">Selamat datang kembali, <?= esc($username) ?>!</p>
            </div>
            
            <div class="profile-card">
                <img class="profile-avatar" src="<?= esc($avatar) ?>" alt="Avatar">
                <div class="profile-info">
                    <div class="profile-name"><?= esc($username) ?></div>
                    <div class="profile-role"><?= esc($role_name) ?></div>
                </div>
            </div>
        </div>

        <!-- STATS WIDGET GRID -->
        <div class="row g-4 mb-5">
            <!-- Widget 1: Kas Keuangan -->
            <div class="col-md-6 col-lg-3">
                <div class="stat-card">
                    <div class="stat-info">
                        <span class="stat-label">Saldo Kas</span>
                        <span class="stat-value">Rp <?= number_format($saldo_kas, 0, ',', '.') ?></span>
                    </div>
                    <div class="stat-icon icon-primary">
                        <i class="fa-solid fa-scale-balanced"></i>
                    </div>
                </div>
            </div>

            <!-- Widget 2: Infak Digital -->
            <div class="col-md-6 col-lg-3">
                <div class="stat-card">
                    <div class="stat-info">
                        <span class="stat-label">ZIS Terverifikasi</span>
                        <span class="stat-value">Rp <?= number_format($total_infak, 0, ',', '.') ?></span>
                    </div>
                    <div class="stat-icon icon-accent">
                        <i class="fa-solid fa-hand-holding-dollar"></i>
                    </div>
                </div>
            </div>

            <!-- Widget 3: Santri TPA -->
            <div class="col-md-6 col-lg-3">
                <div class="stat-card">
                    <div class="stat-info">
                        <span class="stat-label">Santri TPA</span>
                        <span class="stat-value"><?= esc($total_santri) ?> Anak</span>
                    </div>
                    <div class="stat-icon icon-teal">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                </div>
            </div>

            <!-- Widget 4: Pengurus Aktif -->
            <div class="col-md-6 col-lg-3">
                <div class="stat-card">
                    <div class="stat-info">
                        <span class="stat-label">Pengurus Aktif</span>
                        <span class="stat-value"><?= esc($total_pengurus) ?> Orang</span>
                    </div>
                    <div class="stat-icon icon-blue">
                        <i class="fa-solid fa-user-tie"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Kolom Kiri: Petugas Jumat & Informasi -->
            <div class="col-lg-6">
                <div class="panel-card">
                    <div class="panel-header">
                        <h5 class="panel-title"><i class="fa-solid fa-calendar-day"></i> Jadwal Jumat Terdekat</h5>
                        <a href="#" class="btn btn-sm btn-outline-success border-0 fw-bold">Detail</a>
                    </div>
                    <?php if (!empty($petugas_jumat)) : ?>
                        <div class="mb-3">
                            <span class="badge bg-amber text-dark font-heading fw-bold" style="background-color: #fef3c7; color: #92400e; padding: 8px 12px; border-radius: 8px;">
                                <i class="fa-solid fa-book-open me-1"></i> "<?= esc($petugas_jumat['judul_khotbah']) ?: 'Tanpa Judul' ?>"
                            </span>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent px-0 border-light-subtle">
                                <span class="text-muted"><i class="fa-solid fa-user-tie me-2"></i> Khatib</span>
                                <strong class="text-dark"><?= esc($petugas_jumat['khatib_nama']) ?></strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent px-0 border-light-subtle">
                                <span class="text-muted"><i class="fa-solid fa-user me-2"></i> Imam</span>
                                <strong class="text-dark"><?= esc($petugas_jumat['imam_nama']) ?></strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent px-0 border-0">
                                <span class="text-muted"><i class="fa-solid fa-microphone-lines me-2"></i> Muadzin</span>
                                <strong class="text-dark"><?= esc($petugas_jumat['muadzin_nama']) ?></strong>
                            </li>
                        </ul>
                    <?php else : ?>
                        <div class="text-center py-4 text-muted">
                            <i class="fa-regular fa-calendar-xmark d-block fs-3 mb-2"></i>
                            Jadwal Jumat mendatang belum dirilis.
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Kolom Kanan: Log Aktivitas Audit Trail -->
            <div class="col-lg-6">
                <div class="panel-card">
                    <div class="panel-header">
                        <h5 class="panel-title"><i class="fa-solid fa-clock-rotate-left"></i> Log Aktivitas Pengurus</h5>
                        <a href="#" class="btn btn-sm btn-outline-success border-0 fw-bold">Lihat Semua</a>
                    </div>

                    <div class="log-list">
                        <?php if (!empty($logs)) : ?>
                            <?php foreach ($logs as $log) : ?>
                                <?php 
                                    $actionClass = 'badge-auth';
                                    $icon = 'fa-lock';
                                    if ($log['action'] === 'INSERT') {
                                        $actionClass = 'badge-insert';
                                        $icon = 'fa-plus';
                                    } elseif ($log['action'] === 'UPDATE' || $log['action'] === 'UPDATE_OAUTH') {
                                        $actionClass = 'badge-update';
                                        $icon = 'fa-pen';
                                    } elseif ($log['action'] === 'DELETE') {
                                        $actionClass = 'badge-delete';
                                        $icon = 'fa-trash';
                                    }
                                ?>
                                <div class="log-item">
                                    <div class="log-badge <?= $actionClass ?>">
                                        <i class="fa-solid <?= $icon ?>"></i>
                                    </div>
                                    <div class="log-details">
                                        <div class="log-text">
                                            <strong><?= esc($log['username'] ?: 'System') ?></strong> melakukan aksi 
                                            <span class="badge bg-light text-dark fw-bold border border-light-subtle"><?= esc($log['action']) ?></span> 
                                            pada tabel <code><?= esc($log['table_name']) ?></code>
                                        </div>
                                        <div class="log-meta">
                                            <span><i class="fa-solid fa-clock me-1"></i> <?= esc(date('d/m/Y H:i', strtotime($log['created_at']))) ?></span>
                                            <span><i class="fa-solid fa-network-wired me-1"></i> <?= esc($log['ip_address']) ?></span>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <div class="text-center py-4 text-muted">
                                Belum ada aktivitas tercatat.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
