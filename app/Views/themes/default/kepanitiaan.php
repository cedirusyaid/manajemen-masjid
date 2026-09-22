<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panitia Pembangunan - <?= site_name() ?></title>
    <!-- Google Fonts: Outfit & Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
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
            --light-bg: #f4f7f5;
            --white: #ffffff;
            --shadow-sm: 0 4px 10px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 10px 30px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--light-bg);
            color: #374151;
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, h6, .font-heading {
            font-family: 'Outfit', sans-serif;
        }

        /* Navbar */
        .navbar {
            background-color: rgba(2, 44, 34, 0.96) !important;
            backdrop-filter: blur(10px);
            padding: 15px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.4rem;
            color: var(--white) !important;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar-brand i {
            color: var(--accent);
            font-size: 1.8rem;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.8) !important;
            font-weight: 500;
            font-size: 0.95rem;
            padding: 8px 16px !important;
            transition: var(--transition);
        }

        .nav-link:hover, .nav-link.active {
            color: var(--accent) !important;
        }

        .btn-login {
            background-color: var(--accent);
            color: var(--white) !important;
            border-radius: 30px;
            padding: 8px 24px !important;
            font-weight: 600;
            box-shadow: 0 4px 10px rgba(217, 119, 6, 0.3);
            transition: var(--transition);
        }

        .btn-login:hover {
            background-color: #b45309;
            transform: translateY(-2px);
        }

        /* Hero Header */
        .page-header {
            background: linear-gradient(135deg, rgba(2, 44, 34, 0.95) 0%, rgba(6, 78, 59, 0.92) 100%), 
                        url('https://images.unsplash.com/photo-1590076211186-638a84798a3b?auto=format&fit=crop&q=80&w=1920') no-repeat center center/cover;
            color: var(--white);
            padding: 80px 0 100px;
            position: relative;
        }

        .page-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 40px;
            background: linear-gradient(to top, var(--light-bg), transparent);
        }

        /* Stats Card */
        .stats-container {
            margin-top: -50px;
            position: relative;
            z-index: 10;
        }

        .stat-card {
            background: var(--white);
            border-radius: 18px;
            padding: 24px;
            box-shadow: var(--shadow-sm);
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: var(--transition);
            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
        }

        .stat-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        /* Nav Tabs */
        .nav-pills-custom {
            background: var(--white);
            padding: 8px;
            border-radius: 16px;
            box-shadow: var(--shadow-sm);
            border: 1px solid rgba(0, 0, 0, 0.05);
            display: inline-flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .nav-pills-custom .nav-link {
            color: #4b5563 !important;
            font-weight: 600;
            padding: 12px 22px !important;
            border-radius: 12px;
            transition: var(--transition);
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-pills-custom .nav-link.active {
            background-color: var(--primary) !important;
            color: var(--white) !important;
            box-shadow: 0 4px 12px rgba(6, 78, 59, 0.25);
        }

        .nav-pills-custom .nav-link:hover:not(.active) {
            background-color: #f3f4f6;
            color: var(--primary) !important;
        }

        /* Content Panel */
        .content-panel {
            background: var(--white);
            border-radius: 20px;
            padding: 35px;
            box-shadow: var(--shadow-sm);
            border: 1px solid rgba(0, 0, 0, 0.05);
            margin-bottom: 40px;
        }

        /* Card Jabatan */
        .jabatan-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            transition: var(--transition);
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .jabatan-card:hover {
            border-color: var(--primary-light);
            box-shadow: var(--shadow-md);
            transform: translateY(-3px);
        }

        .jabatan-header {
            background: #f9fafb;
            padding: 16px 20px;
            border-bottom: 1px solid #e5e7eb;
        }

        .jabatan-body {
            padding: 20px;
            flex-grow: 1;
        }

        .panitia-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary-light);
            flex-shrink: 0;
        }

        .panitia-avatar-placeholder {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background-color: #e0e7ff;
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        /* Org Chart Tree */
        .org-chart-container {
            display: flex;
            justify-content: center;
            overflow-x: auto;
            padding: 30px 10px;
            background-color: #fafbfc;
            border-radius: 16px;
            border: 1px solid #e5e7eb;
            min-height: 400px;
        }

        .org-tree {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .org-tree ul {
            padding-top: 20px; 
            position: relative;
            transition: all 0.5s;
            display: flex;
            justify-content: center;
            margin: 0;
            padding-left: 0;
        }

        .org-tree li {
            float: left; 
            text-align: center;
            list-style-type: none;
            position: relative;
            padding: 20px 8px 0 8px;
            transition: all 0.5s;
        }

        .org-tree li::before, .org-tree li::after {
            content: '';
            position: absolute; 
            top: 0; 
            right: 50%;
            border-top: 2px solid #cbd5e1;
            width: 50%; 
            height: 20px;
        }

        .org-tree li::after {
            right: auto; 
            left: 50%;
            border-left: 2px solid #cbd5e1;
        }

        .org-tree li:only-child::after, .org-tree li:only-child::before {
            display: none;
        }

        .org-tree li:only-child { 
            padding-top: 0;
        }

        .org-tree li:first-child::before, .org-tree li:last-child::after {
            border: 0 none;
        }

        .org-tree li:last-child::before {
            border-right: 2px solid #cbd5e1;
            border-radius: 0 5px 0 0;
        }

        .org-tree li:first-child::after {
            border-radius: 5px 0 0 0;
        }

        .org-tree ul ul::before {
            content: '';
            position: absolute; 
            top: 0; 
            left: 50%;
            border-left: 2px solid #cbd5e1;
            width: 0; 
            height: 20px;
        }

        .org-tree-node {
            border: 1.5px solid #e2e8f0;
            padding: 12px 16px;
            text-decoration: none;
            color: #1f2937;
            font-size: 0.85rem;
            display: inline-block;
            border-radius: 12px;
            background-color: var(--white);
            box-shadow: 0 2px 5px rgba(0,0,0,0.04);
            min-width: 150px;
            position: relative;
            z-index: 10;
        }

        .org-tree-node .node-title {
            font-weight: 700;
            font-family: 'Outfit', sans-serif;
            color: var(--primary);
            font-size: 0.9rem;
            margin-bottom: 4px;
        }

        .org-tree-node .node-name {
            font-size: 0.775rem;
            font-weight: 600;
            color: #4b5563;
        }

        /* Custom Table */
        .custom-table th {
            background-color: #f8fafc;
            color: #475569;
            font-weight: 700;
            font-size: 0.85rem;
            text-transform: uppercase;
            padding: 14px 18px;
            border-bottom: 2px solid #e2e8f0;
        }

        .custom-table td {
            padding: 14px 18px;
            vertical-align: middle;
            font-size: 0.925rem;
            border-bottom: 1px solid #f1f5f9;
        }

        /* Footer */
        footer {
            background-color: var(--dark-navy);
            color: rgba(255, 255, 255, 0.7);
            padding: 60px 0 30px;
            font-size: 0.9rem;
            border-top: 5px solid var(--accent);
        }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url() ?>">
                <i class="fa-solid fa-mosque"></i>
                <span><?= site_name() ?></span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center gap-1">
                    <li class="nav-item"><a class="nav-link" href="<?= base_url() ?>">Beranda</a></li>
                    
                    <!-- Dropdown Kepanitiaan -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle active" href="#" id="navbarKepanitiaan" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-people-group me-1 text-warning"></i> Kepanitiaan
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm rounded-3 py-2" aria-labelledby="navbarKepanitiaan" style="min-width: 240px;">
                            <li>
                                <a class="dropdown-item py-2 d-flex align-items-center gap-2 active" href="<?= base_url('pembangunan') ?>">
                                    <i class="fa-solid fa-helmet-safety text-warning"></i>
                                    <div>
                                        <strong class="d-block" style="font-size: 0.875rem;">Panitia Pembangunan</strong>
                                        <small class="text-muted" style="font-size: 0.75rem;">Proyek Renovasi & Fisik Masjid</small>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item"><a class="nav-link" href="<?= base_url() ?>#jadwal">Jadwal Sholat</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url() ?>#petugas-jumat">Pelaksana Shalat Jumat</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url() ?>#kajian">Kajian</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url() ?>#layanan">Layanan</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url() ?>#donasi">Donasi</a></li>
                    <li class="nav-item ms-lg-2">
                        <a class="nav-link btn-login text-center" href="<?= base_url('login') ?>">
                            <i class="fa-solid fa-arrow-right-to-bracket me-1"></i> Login Admin
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- HEADER / HERO -->
    <header class="page-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="d-inline-flex align-items-center gap-2 px-3 py-1.5 rounded-pill bg-warning bg-opacity-20 text-warning border border-warning border-opacity-30 mb-3 small fw-bold">
                        <i class="fa-solid fa-file-signature"></i> SK Resmi Yayasan No: 001./AU/YAYASAN.KEP/IX/2026
                    </div>
                    <h1 class="display-5 fw-extrabold mb-3 text-white"><?= esc($kegiatan['nama_kegiatan']) ?></h1>
                    <p class="lead text-white-50 mb-4" style="max-width: 750px; font-size: 1.05rem; line-height: 1.6;">
                        <?= esc($kegiatan['deskripsi'] ?: 'Portal resmi transparansi susunan panitia, pembukuan kas keuangan donasi, bantuan material, dan linimasa proyek pembangunan Masjid Agung Nujumul Ittihad Sinjai.') ?>
                    </p>
                    <div class="d-flex flex-wrap align-items-center gap-3">
                        <span class="badge bg-success bg-opacity-25 text-white border border-success border-opacity-40 px-3 py-2 rounded-pill font-heading fs-6">
                            <i class="fa-solid fa-calendar-check me-2 text-warning"></i> Masa Kerja: <?= date('d M Y', strtotime($kegiatan['tanggal_mulai'])) ?> s/d <?= date('d M Y', strtotime($kegiatan['tanggal_selesai'])) ?>
                        </span>
                        <a href="#rekening" class="btn btn-warning px-4 py-2 rounded-pill font-heading fw-bold" style="background-color: var(--accent); border: none; color: white;">
                            <i class="fa-solid fa-hand-holding-dollar me-1"></i> Salurkan Infaq Proyek
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- STATS CARDS -->
    <section class="stats-container container mb-5">
        <div class="row g-4">
            <div class="col-6 col-md-3">
                <div class="stat-card">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="stat-icon bg-primary bg-opacity-10 text-success">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <div>
                            <span class="text-muted small fw-semibold d-block">Personil Panitia</span>
                            <h3 class="fw-bold mb-0 text-dark"><?= count($panitia_list) ?></h3>
                        </div>
                    </div>
                    <small class="text-muted" style="font-size: 0.775rem;">Terbagi dalam <?= count($jabatan_list) ?> posisi jabatan</small>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="stat-card">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="stat-icon bg-success bg-opacity-10 text-success">
                            <i class="fa-solid fa-arrow-down-long"></i>
                        </div>
                        <div>
                            <span class="text-muted small fw-semibold d-block">Total Kas Donasi</span>
                            <h4 class="fw-bold mb-0 text-success" style="font-size: 1.25rem;">Rp <?= number_format($total_masuk, 0, ',', '.') ?></h4>
                        </div>
                    </div>
                    <small class="text-muted" style="font-size: 0.775rem;">Penerimaan kas proyek</small>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="stat-card">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="stat-icon bg-danger bg-opacity-10 text-danger">
                            <i class="fa-solid fa-arrow-up-long"></i>
                        </div>
                        <div>
                            <span class="text-muted small fw-semibold d-block">Pengeluaran Proyek</span>
                            <h4 class="fw-bold mb-0 text-danger" style="font-size: 1.25rem;">Rp <?= number_format($total_keluar, 0, ',', '.') ?></h4>
                        </div>
                    </div>
                    <small class="text-muted" style="font-size: 0.775rem;">Belanja fisik & logistik</small>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="stat-card">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                            <i class="fa-solid fa-vault"></i>
                        </div>
                        <div>
                            <span class="text-muted small fw-semibold d-block">Saldo Kas Proyek</span>
                            <h4 class="fw-bold mb-0 text-primary" style="font-size: 1.25rem;">Rp <?= number_format($saldo_kas, 0, ',', '.') ?></h4>
                        </div>
                    </div>
                    <small class="text-muted" style="font-size: 0.775rem;">Sisa kas aktif saat ini</small>
                </div>
            </div>
        </div>
    </section>

    <!-- MAIN TABS SECTION -->
    <main class="container mb-5">
        <!-- Tab Navigation Bar -->
        <div class="d-flex justify-content-center mb-4">
            <ul class="nav nav-pills-custom" id="publicKepanitiaanTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="tab-panitia-nav" data-bs-toggle="pill" data-bs-target="#tab-panitia" type="button" role="tab">
                        <i class="fa-solid fa-users"></i> Susunan Panitia
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tab-chart-nav" data-bs-toggle="pill" data-bs-target="#tab-chart" type="button" role="tab">
                        <i class="fa-solid fa-diagram-project"></i> Bagan Struktur
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tab-keuangan-nav" data-bs-toggle="pill" data-bs-target="#tab-keuangan" type="button" role="tab">
                        <i class="fa-solid fa-receipt"></i> Kas Keuangan
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tab-material-nav" data-bs-toggle="pill" data-bs-target="#tab-material" type="button" role="tab">
                        <i class="fa-solid fa-truck-ramp-box"></i> Bantuan Material
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tab-kelompok-nav" data-bs-toggle="pill" data-bs-target="#tab-kelompok" type="button" role="tab">
                        <i class="fa-solid fa-users-gear"></i> Tim Kerja
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tab-rekening-nav" data-bs-toggle="pill" data-bs-target="#tab-rekening" type="button" role="tab">
                        <i class="fa-solid fa-hand-holding-heart"></i> Rekening Infaq
                    </button>
                </li>
            </ul>
        </div>

        <!-- Tab Contents -->
        <div class="tab-content" id="publicKepanitiaanTabContent">
            
            <!-- 1. TAB SUSUNAN PANITIA -->
            <div class="tab-pane fade show active" id="tab-panitia" role="tabpanel">
                <div class="content-panel">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4 pb-3 border-bottom">
                        <div>
                            <h3 class="h4 fw-bold text-dark mb-1">Susunan Panitia Pembangunan</h3>
                            <p class="text-muted small mb-0">Jajaran pengurus panitia pelaksana berdasarkan Surat Keputusan Tahun 2026.</p>
                        </div>
                        <div class="d-flex align-items-center gap-2" style="min-width: 280px;">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                                <input type="text" id="searchPanitiaInput" class="form-control bg-light border-start-0" placeholder="Cari nama atau jabatan...">
                            </div>
                        </div>
                    </div>

                    <?php if (!empty($jabatan_list)) : ?>
                        <?php
                            $publicUnitGroups = [];
                            foreach ($jabatan_list as $j) {
                                $uName = !empty($j['kategori_unit']) ? trim($j['kategori_unit']) : 'Pelaksana Utama';
                                if (!isset($publicUnitGroups[$uName])) {
                                    $publicUnitGroups[$uName] = [];
                                }
                                $publicUnitGroups[$uName][] = $j;
                            }

                            $pubUnitOrder = [
                                'Pembina / Penasehat',
                                'Pengarah',
                                'Pelaksana Utama',
                                'Bidang Pembangunan dan Konstruksi',
                                'Bidang Penggalangan Dana',
                                'Bidang Logistik dan Material',
                                'Bidang Keamanan dan Ketertiban',
                                'Bidang Publikasi, Dokumentasi dan Humas',
                                'Bidang Perlengkapan dan Rumah Tangga',
                                'Bidang Sekretariat'
                            ];

                            $pubSortedUnits = [];
                            foreach ($pubUnitOrder as $u) {
                                if (isset($publicUnitGroups[$u])) {
                                    $pubSortedUnits[$u] = $publicUnitGroups[$u];
                                    unset($publicUnitGroups[$u]);
                                }
                            }
                            foreach ($publicUnitGroups as $u => $items) {
                                $pubSortedUnits[$u] = $items;
                            }

                            $pubUnitIcons = [
                                'Pembina / Penasehat' => 'fa-shield-halved text-info',
                                'Pengarah' => 'fa-compass text-warning',
                                'Pelaksana Utama' => 'fa-crown text-warning',
                                'Bidang Pembangunan dan Konstruksi' => 'fa-trowel-bricks text-danger',
                                'Bidang Penggalangan Dana' => 'fa-hand-holding-dollar text-success',
                                'Bidang Logistik dan Material' => 'fa-truck-ramp-box text-primary',
                                'Bidang Keamanan dan Ketertiban' => 'fa-shield text-danger',
                                'Bidang Publikasi, Dokumentasi dan Humas' => 'fa-bullhorn text-info',
                                'Bidang Perlengkapan dan Rumah Tangga' => 'fa-boxes-stacked text-secondary',
                                'Bidang Sekretariat' => 'fa-file-lines text-primary'
                            ];
                        ?>

                        <!-- Unit Quick Filter Nav -->
                        <div class="d-flex flex-wrap gap-2 mb-4 pb-3 border-bottom pub-unit-filter-container">
                            <button type="button" class="btn btn-sm btn-dark rounded-pill px-3 py-1.5 pub-unit-btn active" data-unit="all">Semua Unit (<?= count($pubSortedUnits) ?>)</button>
                            <?php foreach ($pubSortedUnits as $uName => $uList) : 
                                $uIcon = $pubUnitIcons[$uName] ?? 'fa-layer-group text-secondary';
                                $uSlug = preg_replace('/[^a-zA-Z0-9]/', '', $uName);
                            ?>
                                <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-1.5 pub-unit-btn" data-unit="<?= esc($uSlug) ?>">
                                    <i class="fa-solid <?= $uIcon ?> me-1"></i><?= esc($uName) ?>
                                    <span class="badge bg-light text-dark border ms-1" style="font-size: 0.7rem;"><?= count($uList) ?></span>
                                </button>
                            <?php endforeach; ?>
                        </div>

                        <div class="d-flex flex-column gap-5" id="jabatanListContainer">
                            <?php foreach ($pubSortedUnits as $uName => $uList) : 
                                $uSlug = preg_replace('/[^a-zA-Z0-9]/', '', $uName);
                                $uIcon = $pubUnitIcons[$uName] ?? 'fa-layer-group text-secondary';
                                $totalPanitiaInUnit = 0;
                                foreach ($uList as $uj) {
                                    $totalPanitiaInUnit += !empty($uj['panitia']) ? count($uj['panitia']) : 0;
                                }
                            ?>
                                <div class="pub-unit-section" data-unit-slug="<?= esc($uSlug) ?>">
                                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fa-solid <?= $uIcon ?> fs-5"></i>
                                            <h4 class="h5 fw-bold text-dark mb-0"><?= esc($uName) ?></h4>
                                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 small"><?= $totalPanitiaInUnit ?> Personil</span>
                                        </div>
                                        <span class="text-muted small"><?= count($uList) ?> Posisi</span>
                                    </div>

                                    <div class="row g-3">
                                        <?php foreach ($uList as $jab) : ?>
                                            <div class="col-md-6 col-lg-4 jabatan-item" data-title="<?= strtolower(esc($jab['nama_jabatan'])) ?>">
                                                <div class="jabatan-card">
                                                    <div class="jabatan-header d-flex justify-content-between align-items-center">
                                                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-20 px-2.5 py-1 rounded-pill small fw-bold">
                                                            No. <?= esc($jab['urutan']) ?>
                                                        </span>
                                                        <?php if (!empty($jab['nama_atasan'])) : ?>
                                                            <small class="text-muted text-truncate" style="max-width: 180px;" title="Atasan: <?= esc($jab['nama_atasan']) ?>">
                                                                <i class="fa-solid fa-turn-up fa-rotate-90 text-secondary me-1"></i><?= esc($jab['nama_atasan']) ?>
                                                            </small>
                                                        <?php else : ?>
                                                            <small class="text-muted"><i class="fa-solid fa-crown text-warning me-1"></i>Puncak</small>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="jabatan-body">
                                                        <h4 class="h6 fw-bold text-dark mb-3"><?= esc($jab['nama_jabatan']) ?></h4>
                                                        
                                                        <?php if (!empty($jab['panitia'])) : ?>
                                                            <div class="d-flex flex-column gap-2">
                                                                <?php foreach ($jab['panitia'] as $p) : ?>
                                                                    <div class="d-flex align-items-center gap-2.5 p-2 rounded-3 bg-light panitia-person" data-name="<?= strtolower(esc($p['nama'])) ?>">
                                                                        <?php if (!empty($p['foto'])) : ?>
                                                                            <img src="<?= base_url('uploads/images/' . esc($p['foto'])) ?>" class="panitia-avatar" style="width: 36px; height: 36px;" alt="Foto">
                                                                        <?php else : ?>
                                                                            <div class="panitia-avatar-placeholder" style="width: 36px; height: 36px; font-size: 0.9rem;">
                                                                                <i class="fa-solid fa-user"></i>
                                                                            </div>
                                                                        <?php endif; ?>
                                                                        <div class="overflow-hidden flex-grow-1">
                                                                            <strong class="text-dark d-block text-truncate small" title="<?= esc($p['nama']) ?>"><?= esc($p['nama']) ?></strong>
                                                                            <?php if (!empty($p['no_hp'])) : ?>
                                                                                <a href="https://api.whatsapp.com/send?phone=<?= esc($p['no_hp']) ?>" target="_blank" class="text-decoration-none text-muted small d-inline-flex align-items-center gap-1" style="font-size: 0.725rem;">
                                                                                    <i class="fa-brands fa-whatsapp text-success"></i> <?= esc($p['no_hp']) ?>
                                                                                </a>
                                                                            <?php endif; ?>
                                                                            <?php if (!empty($p['tugas'])) : ?>
                                                                                <small class="text-muted d-block text-truncate" style="font-size: 0.725rem;" title="<?= esc($p['tugas']) ?>">
                                                                                    — <?= esc($p['tugas']) ?>
                                                                                </small>
                                                                            <?php endif; ?>
                                                                        </div>
                                                                    </div>
                                                                <?php endforeach; ?>
                                                            </div>
                                                        <?php else : ?>
                                                            <div class="text-center py-2 text-muted small bg-light rounded-3" style="font-size: 0.775rem;">
                                                                Belum ada penugasan personil
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else : ?>
                        <div class="text-center py-5 text-muted">
                            <i class="fa-solid fa-sitemap fs-1 mb-2"></i>
                            <p>Data susunan panitia sedang dalam pembaruan.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- 2. TAB BAGAN STRUKTUR (ORG CHART) -->
            <div class="tab-pane fade" id="tab-chart" role="tabpanel">
                <div class="content-panel">
                    <div class="mb-4 pb-3 border-bottom">
                        <h3 class="h4 fw-bold text-dark mb-1">Bagan Struktur Hierarki Panitia</h3>
                        <p class="text-muted small mb-0">Diagram alur struktur organisasi Panitia Pelaksana Pembangunan Masjid Agung Sinjai.</p>
                    </div>

                    <?php
                    if (!function_exists('buildPublicKegiatanTree')) {
                        function buildPublicKegiatanTree(array $elements, $parentId = null) {
                            $branch = array();
                            foreach ($elements as $element) {
                                if ($element['parent_id'] === $parentId) {
                                    $children = buildPublicKegiatanTree($elements, $element['id']);
                                    if ($children) {
                                        $element['children'] = $children;
                                    }
                                    $branch[] = $element;
                                }
                            }
                            return $branch;
                        }
                    }

                    if (!function_exists('renderPublicKegiatanTreeHtml')) {
                        function renderPublicKegiatanTreeHtml($tree) {
                            $html = '<ul>';
                            foreach ($tree as $node) {
                                $html .= '<li>';
                                $html .= '<div class="org-tree-node">';
                                $html .= '<div class="node-title">' . esc($node['nama_jabatan']) . '</div>';
                                
                                if (!empty($node['panitia'])) {
                                    $html .= '<div class="mt-1">';
                                    foreach ($node['panitia'] as $p) {
                                        $html .= '<div class="node-name"><i class="fa-solid fa-user me-1 text-success" style="font-size: 0.7rem;"></i>' . esc($p['nama']) . '</div>';
                                    }
                                    $html .= '</div>';
                                }
                                
                                $html .= '</div>';
                                
                                if (!empty($node['children'])) {
                                    $html .= renderPublicKegiatanTreeHtml($node['children']);
                                }
                                $html .= '</li>';
                            }
                            $html .= '</ul>';
                            return $html;
                        }
                    }
                    ?>

                    <div class="org-chart-container">
                        <div class="org-tree">
                            <?php 
                                $treeData = buildPublicKegiatanTree($jabatan_list, null);
                                echo renderPublicKegiatanTreeHtml($treeData);
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. TAB KAS KEUANGAN -->
            <div class="tab-pane fade" id="tab-keuangan" role="tabpanel">
                <div class="content-panel">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4 pb-3 border-bottom">
                        <div>
                            <h3 class="h4 fw-bold text-dark mb-1">Transparansi Kas Pembangunan</h3>
                            <p class="text-muted small mb-0">Laporan pembukuan mutasi penerimaan dan pengeluaran kas pembangunan secara terbuka.</p>
                        </div>
                        <div class="d-flex gap-2">
                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-20 px-3 py-2 rounded-pill font-heading">
                                Saldo Kas: Rp <?= number_format($saldo_kas, 0, ',', '.') ?>
                            </span>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table custom-table">
                            <thead>
                                <tr>
                                    <th style="width: 120px;">Tanggal</th>
                                    <th>Keterangan Transaksi</th>
                                    <th>Donatur / Penerima</th>
                                    <th>Metode</th>
                                    <th class="text-end">Nominal (Rp)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($keuangan_list)) : ?>
                                    <?php foreach ($keuangan_list as $k) : ?>
                                        <tr>
                                            <td class="text-nowrap text-muted"><?= date('d/m/Y', strtotime($k['tanggal'])) ?></td>
                                            <td>
                                                <strong class="text-dark d-block"><?= esc($k['keterangan']) ?></strong>
                                                <span class="badge bg-light text-secondary border px-2 py-0.5 rounded-pill" style="font-size: 0.725rem; text-transform: uppercase;">
                                                    <?= esc($k['kategori']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?= esc($k['nama_donatur'] ?: ($k['penanggung_jawab'] ?: '-')) ?>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark border px-2 py-1 rounded-pill" style="font-size: 0.75rem;">
                                                    <?= esc(strtoupper(str_replace('_', ' ', $k['metode_pembayaran'] ?: 'Tunai'))) ?>
                                                </span>
                                            </td>
                                            <td class="text-end fw-bold <?= $k['tipe'] === 'masuk' ? 'text-success' : 'text-danger' ?>">
                                                <?= $k['tipe'] === 'masuk' ? '+' : '-' ?> Rp <?= number_format($k['nominal'], 0, ',', '.') ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">Belum ada catatan mutasi kas pembangunan.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- 4. TAB BANTUAN MATERIAL -->
            <div class="tab-pane fade" id="tab-material" role="tabpanel">
                <div class="content-panel">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4 pb-3 border-bottom">
                        <div>
                            <h3 class="h4 fw-bold text-dark mb-1">Rekapitulasi Bantuan Material (Nontunai)</h3>
                            <p class="text-muted small mb-0">Daftar bantuan fisik (semen, pasir, besi, batu bata) yang diserahkan para donatur.</p>
                        </div>
                        <div>
                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-20 px-3 py-2 rounded-pill font-heading">
                                Total Nilai Material: Rp <?= number_format($total_nilai_material, 0, ',', '.') ?>
                            </span>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table custom-table">
                            <thead>
                                <tr>
                                    <th style="width: 120px;">Tanggal</th>
                                    <th>Nama Donatur / Toko</th>
                                    <th>Uraian Material / Barang</th>
                                    <th>Kategori</th>
                                    <th class="text-center">Volume</th>
                                    <th class="text-end">Harga Satuan</th>
                                    <th class="text-end">Total Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($material_list)) : ?>
                                    <?php foreach ($material_list as $m) : ?>
                                        <tr>
                                            <td class="text-nowrap text-muted"><?= date('d/m/Y', strtotime($m['tanggal'])) ?></td>
                                            <td>
                                                <strong class="text-dark d-block"><?= esc($m['nama_donatur']) ?></strong>
                                                <?php if (!empty($m['nama_penerima'])): ?>
                                                    <small class="text-muted">Penerima: <?= esc($m['nama_penerima']) ?></small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <strong class="text-dark"><?= esc($m['uraian_material']) ?></strong>
                                                <?php if (!empty($m['keterangan'])) : ?>
                                                    <small class="text-muted d-block"><?= esc($m['keterangan']) ?></small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark border px-2.5 py-1 rounded-pill text-capitalize" style="font-size: 0.75rem;">
                                                    <?= str_replace('_', ' ', esc($m['kategori_material'])) ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-20 px-2.5 py-1 rounded-pill fw-bold">
                                                    <?= number_format($m['volume'], 0, ',', '.') ?> <?= esc($m['satuan']) ?>
                                                </span>
                                            </td>
                                            <td class="text-end text-muted">
                                                Rp <?= number_format($m['harga_satuan'], 0, ',', '.') ?>
                                            </td>
                                            <td class="text-end fw-bold text-dark font-heading">
                                                Rp <?= number_format($m['total_nilai'] ?: ($m['harga_satuan'] * $m['volume']), 0, ',', '.') ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">Belum ada bantuan material fisik yang dicatat.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- 5. TAB TIM / KELOMPOK KERJA -->
            <div class="tab-pane fade" id="tab-kelompok" role="tabpanel">
                <div class="content-panel">
                    <div class="mb-4 pb-3 border-bottom">
                        <h3 class="h4 fw-bold text-dark mb-1">Tim & Kelompok Kerja Lapangan</h3>
                        <p class="text-muted small mb-0">Pembagian regu kerja khusus jemaah dan panitia pelaksana di lapangan.</p>
                    </div>

                    <?php if (!empty($kelompok_list)) : ?>
                        <div class="row g-4">
                            <?php foreach ($kelompok_list as $kel) : ?>
                                <div class="col-md-6">
                                    <div class="card border-0 shadow-sm rounded-4 p-4 h-100" style="background: #f9fafb; border: 1px solid #e5e7eb !important;">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h4 class="h5 fw-bold text-dark mb-0"><?= esc($kel['nama_kelompok']) ?></h4>
                                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-20 px-2.5 py-1 rounded-pill small">
                                                <?= count($kel['anggota']) ?> Anggota
                                            </span>
                                        </div>
                                        <p class="text-muted small mb-3"><?= esc($kel['keterangan'] ?: 'Regu pelaksana operasional.') ?></p>
                                        
                                        <?php if (!empty($kel['anggota'])) : ?>
                                            <div class="d-flex flex-wrap gap-2">
                                                <?php foreach ($kel['anggota'] as $agt) : ?>
                                                    <span class="badge bg-white text-dark border px-3 py-2 rounded-pill shadow-xs" style="font-size: 0.85rem;">
                                                        <i class="fa-solid fa-user me-1 text-success"></i> <?= esc($agt['nama']) ?> 
                                                        <small class="text-muted fw-semibold">(<?= esc($agt['peran']) ?>)</small>
                                                    </span>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php else : ?>
                                            <div class="text-muted small italic">Belum ada anggota yang terdaftar di tim ini.</div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else : ?>
                        <div class="text-center py-5 text-muted">
                            <i class="fa-solid fa-users-viewfinder fs-1 mb-2"></i>
                            <p>Belum ada regu / kelompok kerja terdaftar.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- 6. TAB REKENING INFAQ -->
            <div class="tab-pane fade" id="tab-rekening" role="tabpanel">
                <div class="content-panel" id="rekening">
                    <div class="mb-4 pb-3 border-bottom text-center">
                        <span class="badge bg-warning bg-opacity-20 text-warning border border-warning border-opacity-30 px-3 py-1.5 rounded-pill fw-bold mb-2">
                            <i class="fa-solid fa-hand-holding-heart me-1"></i> Mari Berwakaf & Berinfaq
                        </span>
                        <h3 class="h3 fw-bold text-dark mb-2">Saluran Rekening Resmi Pembangunan</h3>
                        <p class="text-muted" style="max-width: 650px; margin: 0 auto;">Infaq dan sedekah jariyah Anda akan dialokasikan penuh untuk kelancaran pembangunan fisik Masjid Agung Nujumul Ittihad Sinjai.</p>
                    </div>

                    <div class="row g-4 justify-content-center">
                        <?php if (!empty($rekening_list)) : ?>
                            <?php foreach ($rekening_list as $rek) : ?>
                                <div class="col-md-6 col-lg-5">
                                    <div class="card h-100 border-0 shadow-sm rounded-4 p-4 text-center" style="background: linear-gradient(135deg, #064e3b 0%, #0f766e 100%); color: white;">
                                        <div class="mb-3">
                                            <span class="badge bg-warning text-dark px-3 py-1 rounded-pill fw-bold" style="font-size: 0.8rem;">
                                                <?= esc($rek['nama_bank']) ?>
                                            </span>
                                        </div>
                                        <h2 class="display-6 fw-bold tracking-wide mb-2 text-white font-monospace" id="rek-<?= esc($rek['id']) ?>">
                                            <?= esc($rek['nomor_rekening']) ?>
                                        </h2>
                                        <p class="text-white-50 mb-4">a.n. <strong class="text-white"><?= esc($rek['atas_nama']) ?></strong></p>
                                        <div>
                                            <button class="btn btn-light rounded-pill px-4 py-2 fw-bold text-success" onclick="copyToClipboard('<?= esc($rek['nomor_rekening']) ?>', this)">
                                                <i class="fa-regular fa-copy me-1"></i> Salin Nomor Rekening
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <div class="col-md-6 text-center py-4 text-muted">
                                Informasi rekening sedang dikonfigurasi panitia.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <!-- FOOTER -->
    <footer>
        <div class="container text-center">
            <div class="mb-3">
                <i class="fa-solid fa-mosque fs-2 text-warning mb-2"></i>
                <h5 class="text-white fw-bold mb-1"><?= site_name() ?></h5>
                <p class="text-white-50 small mb-0">Pusat Digitalisasi Keagamaan & Layanan Jamaah Kabupaten Sinjai</p>
            </div>
            <hr class="border-secondary opacity-25 my-4">
            <p class="small text-white-50 mb-0">&copy; <?= date('Y') ?> <?= site_name() ?>. Seluruh hak cipta dilindungi.</p>
        </div>
    </footer>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Unit Filter in Public Page
        const pubUnitBtns = document.querySelectorAll('.pub-unit-btn');
        const pubUnitSections = document.querySelectorAll('.pub-unit-section');

        pubUnitBtns.forEach(btn => {
            btn.addEventListener('click', function () {
                pubUnitBtns.forEach(b => {
                    b.classList.remove('active', 'btn-dark');
                    b.classList.add('btn-outline-secondary');
                });
                this.classList.add('active', 'btn-dark');
                this.classList.remove('btn-outline-secondary');

                const targetUnit = this.getAttribute('data-unit');
                pubUnitSections.forEach(sec => {
                    if (targetUnit === 'all' || sec.getAttribute('data-unit-slug') === targetUnit) {
                        sec.style.display = '';
                    } else {
                        sec.style.display = 'none';
                    }
                });
            });
        });

        // Live search panitia
        document.getElementById('searchPanitiaInput')?.addEventListener('keyup', function() {
            const query = this.value.toLowerCase().trim();
            const items = document.querySelectorAll('.jabatan-item');

            items.forEach(item => {
                const title = item.getAttribute('data-title') || '';
                const persons = item.querySelectorAll('.panitia-person');
                let foundPerson = false;

                persons.forEach(p => {
                    const name = p.getAttribute('data-name') || '';
                    if (name.includes(query)) {
                        foundPerson = true;
                        p.style.display = 'flex';
                    } else if (query.length > 0) {
                        p.style.display = 'none';
                    } else {
                        p.style.display = 'flex';
                    }
                });

                if (title.includes(query) || foundPerson || query === '') {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });

        // Copy to clipboard helper
        function copyToClipboard(text, btnElement) {
            navigator.clipboard.writeText(text).then(() => {
                const originalHtml = btnElement.innerHTML;
                btnElement.innerHTML = '<i class="fa-solid fa-check me-1"></i> Tersalin!';
                btnElement.classList.replace('text-success', 'text-primary');
                setTimeout(() => {
                    btnElement.innerHTML = originalHtml;
                    btnElement.classList.replace('text-primary', 'text-success');
                }, 2000);
            });
        }
    </script>
</body>
</html>
