<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Panitia Kegiatan - <?= site_name() ?></title>
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

        /* Panel Card */
        .panel-card {
            background-color: var(--white);
            border-radius: 16px;
            padding: 30px;
            box-shadow: var(--shadow-sm);
            border: 1px solid rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        .panel-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* Tabs Styles */
        .nav-pills .nav-link {
            color: #4b5563;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 8px;
            transition: var(--transition);
        }

        .nav-pills .nav-link.active, .nav-pills .show > .nav-link {
            background-color: var(--primary);
            color: var(--white);
        }

        /* Table/Badges Styles */
        .custom-table {
            width: 100%;
            margin-bottom: 0;
            vertical-align: middle;
        }

        .custom-table th {
            background-color: #f9fafb;
            color: #4b5563;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 16px 20px;
            border-bottom: 1px solid #e5e7eb;
        }

        .custom-table td {
            padding: 16px 20px;
            color: #374151;
            border-bottom: 1px solid #f3f4f6;
            font-size: 0.925rem;
        }

        .badge-rencana {
            background-color: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 30px;
            font-size: 0.775rem;
        }

        .badge-berjalan {
            background-color: rgba(245, 158, 11, 0.1);
            color: #f59e0b;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 30px;
            font-size: 0.775rem;
        }

        .badge-selesai {
            background-color: rgba(16, 185, 129, 0.1);
            color: #10b981;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 30px;
            font-size: 0.775rem;
        }

        .badge-dibatalkan {
            background-color: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 30px;
            font-size: 0.775rem;
        }

        .btn-action {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: var(--transition);
            border: none;
            font-size: 0.875rem;
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

        /* Org Chart Tree CSS */
        .org-chart-container {
            display: flex;
            justify-content: center;
            overflow-x: auto;
            padding: 30px;
            background-color: var(--white);
            border-radius: 16px;
            border: 1px solid rgba(0, 0, 0, 0.05);
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
            padding: 20px 10px 0 10px;
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
            border: 1.5px solid #e5e7eb;
            padding: 14px 20px;
            text-decoration: none;
            color: #1f2937;
            font-size: 0.875rem;
            display: inline-block;
            border-radius: 14px;
            background-color: var(--white);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.04), 0 2px 4px -1px rgba(0, 0, 0, 0.02);
            transition: all 0.25s ease;
            min-width: 170px;
            position: relative;
            z-index: 10;
        }

        .org-tree-node:hover {
            border-color: var(--primary);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.08);
            transform: translateY(-2px);
        }

        .org-tree-node .node-title {
            font-weight: 700;
            font-family: 'Outfit', sans-serif;
            color: var(--primary);
            margin-bottom: 6px;
            font-size: 0.95rem;
        }

        .org-tree-node .node-names {
            display: flex;
            flex-direction: column;
            gap: 4px;
            border-top: 1px dashed #e5e7eb;
            padding-top: 6px;
            margin-top: 6px;
            text-align: left;
        }

        .org-tree-node .node-name {
            font-weight: 600;
            font-size: 0.8rem;
            color: #374151;
            display: flex;
            align-items: center;
            gap: 4px;
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
                <a href="<?= base_url('dashboard/kepanitiaan') ?>" class="menu-link active">
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
                <h1 class="h3 fw-bold mb-1 text-dark">Detail Kepanitiaan Kegiatan</h1>
                <p class="text-muted mb-0">Kelola jajaran panitia pelaksana kegiatan masjid.</p>
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
        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success d-flex align-items-center gap-2 mb-4 border-0 shadow-sm" role="alert">
                <i class="fa-solid fa-circle-check"></i>
                <div><?= session()->getFlashdata('success') ?></div>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger d-flex align-items-center gap-2 mb-4 border-0 shadow-sm" role="alert">
                <i class="fa-solid fa-circle-exclamation"></i>
                <div><?= session()->getFlashdata('error') ?></div>
            </div>
        <?php endif; ?>

        <!-- INFO DETAIL KEGIATAN -->
        <div class="panel-card mb-4 bg-white border-0 shadow-sm rounded-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="p-3 rounded-3 bg-success bg-opacity-10 text-success">
                        <i class="fa-solid fa-calendar-days fs-2"></i>
                    </div>
                    <div>
                        <h2 class="h4 fw-bold mb-1 text-dark"><?= esc($kegiatan['nama_kegiatan']) ?></h2>
                        <p class="text-muted mb-1 small">
                            <span class="fw-semibold text-dark">Waktu:</span> <?= date('d-m-Y', strtotime($kegiatan['tanggal_mulai'])) ?> s/d <?= date('d-m-Y', strtotime($kegiatan['tanggal_selesai'])) ?>
                            <span class="mx-2">|</span>
                            <span class="fw-semibold text-dark">Status:</span> 
                            <?php if ($kegiatan['status'] === 'rencana') : ?>
                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2.5 py-1 rounded-pill">Rencana</span>
                            <?php elseif ($kegiatan['status'] === 'berjalan') : ?>
                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2.5 py-1 rounded-pill">Berjalan</span>
                            <?php elseif ($kegiatan['status'] === 'selesai') : ?>
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1 rounded-pill">Selesai</span>
                            <?php else : ?>
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2.5 py-1 rounded-pill">Dibatalkan</span>
                            <?php endif; ?>
                        </p>
                        <p class="mb-0 text-muted small"><span class="fw-semibold text-dark">Keterangan:</span> <?= esc($kegiatan['deskripsi'] ?: 'Tidak ada deskripsi tambahan') ?></p>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <a href="<?= base_url('dashboard/kepanitiaan') ?>" class="btn btn-sm btn-outline-secondary px-3 py-2 fw-semibold" style="border-radius: 8px;">
                        <i class="fa-solid fa-arrow-left me-2"></i>Kembali
                    </a>
                    <a href="<?= base_url('dashboard/kepanitiaan/kegiatan/edit/' . esc($kegiatan['id'])) ?>" class="btn btn-sm btn-primary px-3 py-2 fw-semibold" style="background-color: var(--primary-light); border: none; border-radius: 8px;">
                        <i class="fa-solid fa-edit me-2"></i>Ubah Kegiatan
                    </a>
                </div>
            </div>
        </div>

        <?php
        if (!function_exists('buildKegiatanTree')) {
            function buildKegiatanTree(array $elements, $parentId = null) {
                $branch = array();
                foreach ($elements as $element) {
                    if ($element['parent_id'] === $parentId) {
                        $children = buildKegiatanTree($elements, $element['id']);
                        if ($children) {
                            $element['children'] = $children;
                        }
                        $branch[] = $element;
                    }
                }
                return $branch;
            }
        }

        if (!function_exists('renderKegiatanTreeHtml')) {
            function renderKegiatanTreeHtml($tree) {
                $html = '<ul>';
                foreach ($tree as $node) {
                    $html .= '<li>';
                    $html .= '<div class="org-tree-node">';
                    $html .= '<div class="node-title">' . esc($node['nama_jabatan']) . '</div>';
                    
                    if (!empty($node['panitia'])) {
                        $html .= '<div class="node-names">';
                        foreach ($node['panitia'] as $p) {
                            $html .= '<div class="node-name"><i class="fa-solid fa-user me-1 text-success small"></i>' . esc($p['nama']) . '</div>';
                        }
                        $html .= '</div>';
                    } else {
                        $html .= '<div class="text-muted small" style="font-size: 0.75rem; font-style: italic; margin-top: 4px;">Kosong</div>';
                    }
                    
                    $html .= '</div>';
                    
                    if (!empty($node['children'])) {
                        $html .= renderKegiatanTreeHtml($node['children']);
                    }
                    $html .= '</li>';
                }
                $html .= '</ul>';
                return $html;
            }
        }
        ?>

        <!-- Nav tabs -->
        <ul class="nav nav-pills mb-4 gap-2" id="kepanitiaanTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="struktur-tab" data-bs-toggle="tab" data-bs-target="#struktur" type="button" role="tab" aria-controls="struktur" aria-selected="true">
                    <i class="fa-solid fa-sitemap me-2"></i>Struktur Organisasi
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="chart-tab" data-bs-toggle="tab" data-bs-target="#chart" type="button" role="tab" aria-controls="chart" aria-selected="false">
                    <i class="fa-solid fa-diagram-project me-2"></i>Bagan Struktur (Org Chart)
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="kelompok-tab" data-bs-toggle="tab" data-bs-target="#kelompok" type="button" role="tab" aria-controls="kelompok" aria-selected="false">
                    <i class="fa-solid fa-users-viewfinder me-2"></i>Kelompok Kegiatan
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="keuangan-tab" data-bs-toggle="tab" data-bs-target="#keuangan" type="button" role="tab" aria-controls="keuangan" aria-selected="false">
                    <i class="fa-solid fa-wallet me-2"></i>Laporan Keuangan
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="rundown-tab" data-bs-toggle="tab" data-bs-target="#rundown" type="button" role="tab" aria-controls="rundown" aria-selected="false">
                    <i class="fa-solid fa-calendar-days me-2"></i>Rundown & Jadwal
                </button>
            </li>
        </ul>

        <!-- Tab content -->
        <div class="tab-content">
            <!-- TAB STRUKTUR ORGANISASI (JABATAN & PANITIA) -->
            <div class="tab-pane fade show active" id="struktur" role="tabpanel" aria-labelledby="struktur-tab">
                <div class="panel-card bg-white border-0 shadow-sm rounded-4 mb-4">
                    <div class="panel-title d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
                        <span class="fw-bold text-dark fs-5">Jajaran Kepanitiaan Berdasarkan Jabatan</span>
                        <div class="d-flex gap-2">
                            <a href="<?= base_url('dashboard/kepanitiaan/jabatan/create?kegiatan_id=' . esc($kegiatan['id'])) ?>" class="btn btn-sm btn-outline-success px-3 py-2 fw-semibold" style="border-radius: 8px;">
                                <i class="fa-solid fa-plus me-1"></i>Tambah Jabatan
                            </a>
                            <a href="<?= base_url('dashboard/kepanitiaan/panitia/create?kegiatan_id=' . esc($kegiatan['id'])) ?>" class="btn btn-sm btn-success px-3 py-2 fw-semibold" style="background-color: var(--primary); border: none; border-radius: 8px;">
                                <i class="fa-solid fa-user-plus me-1"></i>Tugaskan Panitia
                            </a>
                        </div>
                    </div>

                    <?php if (!empty($jabatan_list)) : ?>
                        <div class="row g-4">
                            <?php foreach ($jabatan_list as $jab) : ?>
                                <div class="col-md-6 col-lg-4">
                                    <div class="card h-100 border-0 shadow-sm rounded-4" style="background-color: #f9fafb; border: 1px solid #e5e7eb !important;">
                                        <!-- Card Header: Info Jabatan -->
                                        <div class="card-header bg-white border-bottom-0 pt-4 px-4 pb-2 rounded-top-4 d-flex justify-content-between align-items-start">
                                            <div class="overflow-hidden">
                                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-10 px-2 py-1 rounded-pill mb-2 d-inline-block small">
                                                    Urutan: <?= esc($jab['urutan']) ?>
                                                </span>
                                                <h3 class="h5 fw-bold text-dark mb-1 text-truncate" title="<?= esc($jab['nama_jabatan']) ?>"><?= esc($jab['nama_jabatan']) ?></h3>
                                                <?php if ($jab['nama_atasan']) : ?>
                                                    <small class="text-muted d-block text-truncate" title="Koordinator: <?= esc($jab['nama_atasan']) ?>">
                                                        <i class="fa-solid fa-turn-up fa-rotate-90 me-1 text-secondary"></i>
                                                        Koordinator: <span class="fw-semibold text-secondary"><?= esc($jab['nama_atasan']) ?></span>
                                                    </small>
                                                <?php else : ?>
                                                    <small class="text-muted d-block"><i class="fa-solid fa-crown me-1 text-warning"></i>Jabatan Puncak</small>
                                                <?php endif; ?>
                                            </div>
                                            <!-- Aksi Jabatan -->
                                            <div class="dropdown">
                                                <button class="btn btn-link text-muted p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa-solid fa-ellipsis-vertical fs-5"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3">
                                                    <li>
                                                        <a class="dropdown-item py-2 px-3 small" href="<?= base_url('dashboard/kepanitiaan/jabatan/edit/' . esc($jab['id']) . '?kegiatan_id=' . esc($kegiatan['id'])) ?>">
                                                            <i class="fa-solid fa-edit me-2 text-primary"></i>Ubah Jabatan
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item py-2 px-3 small text-danger" href="<?= base_url('dashboard/kepanitiaan/jabatan/delete/' . esc($jab['id'])) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus jabatan ini? Menghapus jabatan akan menghapus penugasan panitia terkait.')">
                                                            <i class="fa-solid fa-trash me-2"></i>Hapus Jabatan
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        
                                        <!-- Card Body: Daftar Panitia -->
                                        <div class="card-body px-4 pb-4">
                                            <hr class="mt-1 mb-3 text-muted opacity-25">
                                            
                                            <?php if (!empty($jab['panitia'])) : ?>
                                                <ul class="list-unstyled mb-0 d-flex flex-column gap-3">
                                                    <?php foreach ($jab['panitia'] as $pan) : ?>
                                                        <li class="p-3 bg-white rounded-3 shadow-xs border d-flex justify-content-between align-items-center">
                                                            <div class="overflow-hidden">
                                                                <strong class="text-dark d-block text-truncate" style="max-width: 170px;" title="<?= esc($pan['nama']) ?>"><?= esc($pan['nama']) ?></strong>
                                                                <?php if ($pan['no_hp']) : ?>
                                                                    <a href="https://api.whatsapp.com/send?phone=<?= esc($pan['no_hp']) ?>" target="_blank" class="text-decoration-none text-muted small d-inline-block mt-1">
                                                                        <i class="fa-brands fa-whatsapp text-success me-1"></i><?= esc($pan['no_hp']) ?>
                                                                    </a>
                                                                <?php else : ?>
                                                                    <small class="text-muted d-block mt-1"><i class="fa-solid fa-phone-slash me-1"></i>Tidak ada WA</small>
                                                                <?php endif; ?>
                                                                
                                                                <?php if ($pan['tugas']) : ?>
                                                                    <small class="text-muted d-block mt-1 bg-light p-1 rounded-2 border" style="font-size: 0.775rem;">
                                                                        <i class="fa-solid fa-list-check me-1 text-primary"></i><?= esc($pan['tugas']) ?>
                                                                    </small>
                                                                <?php endif; ?>
                                                            </div>
                                                            <!-- Aksi Anggota -->
                                                            <div class="d-flex gap-1 ms-2">
                                                                <a href="<?= base_url('dashboard/kepanitiaan/panitia/edit/' . esc($pan['id']) . '?kegiatan_id=' . esc($kegiatan['id'])) ?>" class="btn-action btn-edit" style="width: 28px; height: 28px; font-size: 0.8rem;" title="Edit Penugasan">
                                                                    <i class="fa-solid fa-pen"></i>
                                                                </a>
                                                                <a href="<?= base_url('dashboard/kepanitiaan/panitia/delete/' . esc($pan['id'])) ?>" class="btn-action btn-delete" style="width: 28px; height: 28px; font-size: 0.8rem;" onclick="return confirm('Apakah Anda yakin ingin menghapus panitia ini?')" title="Hapus Penugasan">
                                                                    <i class="fa-solid fa-trash"></i>
                                                                </a>
                                                            </div>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            <?php else : ?>
                                                <div class="text-center py-4 bg-white rounded-3 border border-dashed">
                                                    <i class="fa-solid fa-user-slash text-muted mb-2 d-block fs-4"></i>
                                                    <p class="text-muted small mb-3">Belum ditugaskan</p>
                                                    <a href="<?= base_url('dashboard/kepanitiaan/panitia/create?kegiatan_id=' . esc($kegiatan['id']) . '&jabatan_kegiatan_id=' . esc($jab['id'])) ?>" class="btn btn-xs btn-outline-success py-1 px-2.5 rounded-pill fw-semibold" style="font-size: 0.775rem;">
                                                        <i class="fa-solid fa-user-plus me-1"></i>Tugaskan
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else : ?>
                        <div class="text-center py-5 text-muted bg-light rounded-4 border border-dashed">
                            <i class="fa-solid fa-sitemap fs-1 mb-3 d-block text-secondary"></i>
                            Belum ada struktur jabatan dibuat pada kegiatan ini.
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- TAB BAGAN STRUKTUR (ORG CHART) -->
            <div class="tab-pane fade" id="chart" role="tabpanel" aria-labelledby="chart-tab">
                <div class="panel-card bg-white border-0 shadow-sm rounded-4 mb-4">
                    <div class="panel-title mb-4">
                        <span class="fw-bold text-dark fs-5">Bagan Struktur Organisasi Kepanitiaan</span>
                    </div>
                    
                    <?php if (!empty($jabatan_list)) : ?>
                        <div class="org-chart-container">
                            <div class="org-tree">
                                <?php 
                                    $treeData = buildKegiatanTree($jabatan_list, null);
                                    echo renderKegiatanTreeHtml($treeData);
                                ?>
                            </div>
                        </div>
                    <?php else : ?>
                        <div class="text-center py-5 text-muted bg-light rounded-4 border border-dashed">
                            <i class="fa-solid fa-sitemap fs-1 mb-3 d-block text-secondary"></i>
                            Belum ada struktur jabatan dibuat pada kegiatan ini.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="tab-pane fade" id="kelompok" role="tabpanel" aria-labelledby="kelompok-tab">
                <div class="panel-card bg-white border-0 shadow-sm rounded-4">
                    <div class="panel-title d-flex justify-content-between align-items-center mb-4">
                        <span class="fw-bold text-dark fs-5">Kelompok Kegiatan (Qurban / Penyedia Buka Puasa, dll)</span>
                        <a href="<?= base_url('dashboard/kepanitiaan/kelompok/create?kegiatan_id=' . esc($kegiatan['id'])) ?>" class="btn btn-sm btn-success" style="background-color: var(--primary); border: none; padding: 8px 16px; border-radius: 8px;">
                            <i class="fa-solid fa-plus me-2"></i>Tambah Kelompok
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table custom-table">
                            <thead>
                                <tr>
                                    <th style="width: 250px;">Nama Kelompok</th>
                                    <th>Keterangan / Catatan</th>
                                    <th>Anggota Kelompok (Jemaah)</th>
                                    <th style="width: 150px;" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($kelompok_list)) : ?>
                                    <?php foreach ($kelompok_list as $kel) : ?>
                                        <tr>
                                            <td>
                                                <strong class="text-dark d-block"><?= esc($kel['nama_kelompok']) ?></strong>
                                            </td>
                                            <td><?= esc($kel['keterangan'] ?: '-') ?></td>
                                            <td>
                                                <?php if (!empty($kel['anggota'])) : ?>
                                                    <div class="d-flex flex-wrap gap-2">
                                                        <?php foreach ($kel['anggota'] as $agt) : ?>
                                                            <span class="badge bg-light text-dark border px-2.5 py-1.5 rounded-pill" title="No WA: <?= esc($agt['no_hp'] ?: '-') ?>" style="font-size: 0.825rem;">
                                                                <i class="fa-solid fa-user me-1 text-success"></i>
                                                                <?= esc($agt['nama']) ?> 
                                                                <small class="text-muted fw-semibold">(<?= esc($agt['peran']) ?>)</small>
                                                            </span>
                                                        <?php endforeach; ?>
                                                    </div>
                                                <?php else : ?>
                                                    <span class="text-muted small"><i class="fa-solid fa-triangle-exclamation text-warning me-1"></i>Belum ada anggota. Silakan kelola anggota.</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex gap-2 justify-content-center">
                                                    <a href="<?= base_url('dashboard/kepanitiaan/kelompok/anggota/' . esc($kel['id'])) ?>" class="btn-action btn-edit" style="background-color: rgba(16, 185, 129, 0.1); color: #10b981;" title="Kelola Anggota Kelompok">
                                                        <i class="fa-solid fa-user-gear"></i>
                                                    </a>
                                                    <a href="<?= base_url('dashboard/kepanitiaan/kelompok/edit/' . esc($kel['id']) . '?kegiatan_id=' . esc($kegiatan['id'])) ?>" class="btn-action btn-edit" title="Edit Kelompok">
                                                        <i class="fa-solid fa-pen"></i>
                                                    </a>
                                                    <a href="<?= base_url('dashboard/kepanitiaan/kelompok/delete/' . esc($kel['id'])) ?>" class="btn-action btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus kelompok ini beserta semua anggotanya?')" title="Hapus Kelompok">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">
                                            <i class="fa-solid fa-users-viewfinder fs-1 mb-3 d-block text-secondary"></i>
                                            Belum ada kelompok kegiatan dibuat pada kegiatan ini.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- TAB LAPORAN KEUANGAN -->
            <div class="tab-pane fade" id="keuangan" role="tabpanel" aria-labelledby="keuangan-tab">
                <!-- Keuangan Summary Cards -->
                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm rounded-4 p-4" style="background-color: #f0fdf4; border: 1px solid #bbf7d0 !important;">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <span class="text-muted small fw-semibold d-block mb-1">Total Pemasukan</span>
                                    <strong class="fs-4 text-success font-heading">Rp <?= number_format($total_masuk, 0, ',', '.') ?></strong>
                                </div>
                                <div class="p-3 bg-success bg-opacity-10 text-success rounded-3">
                                    <i class="fa-solid fa-arrow-trend-up fs-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm rounded-4 p-4" style="background-color: #fef2f2; border: 1px solid #fecaca !important;">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <span class="text-muted small fw-semibold d-block mb-1">Total Pengeluaran</span>
                                    <strong class="fs-4 text-danger font-heading">Rp <?= number_format($total_keluar, 0, ',', '.') ?></strong>
                                </div>
                                <div class="p-3 bg-danger bg-opacity-10 text-danger rounded-3">
                                    <i class="fa-solid fa-arrow-trend-down fs-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm rounded-4 p-4" style="background-color: #f0f9ff; border: 1px solid #bae6fd !important;">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <span class="text-muted small fw-semibold d-block mb-1">Saldo Kas Bersih</span>
                                    <strong class="fs-4 text-primary font-heading">Rp <?= number_format($saldo_kegiatan, 0, ',', '.') ?></strong>
                                </div>
                                <div class="p-3 bg-primary bg-opacity-10 text-primary rounded-3">
                                    <i class="fa-solid fa-scale-balanced fs-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel-card bg-white border-0 shadow-sm rounded-4">
                    <div class="panel-title d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
                        <span class="fw-bold text-dark fs-5">Buku Kas & Transaksi Kegiatan</span>
                        <a href="<?= base_url('dashboard/keuangan/create?kegiatan_id=' . esc($kegiatan['id'])) ?>" class="btn btn-sm btn-success" style="background-color: var(--primary); border: none; padding: 8px 16px; border-radius: 8px;">
                            <i class="fa-solid fa-plus me-2"></i>Catat Kas Kegiatan
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table custom-table">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Kategori</th>
                                    <th>Keterangan</th>
                                    <th>P.Jawab</th>
                                    <th class="text-center" style="width: 80px;">Bukti</th>
                                    <th class="text-end">Nominal</th>
                                    <th class="text-center" style="width: 120px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($keuangan_list)) : ?>
                                    <?php foreach ($keuangan_list as $row) : ?>
                                        <tr>
                                            <td class="fw-semibold text-dark"><?= esc(date('d/m/Y', strtotime($row['tanggal']))) ?></td>
                                            <td>
                                                <span class="badge bg-light text-dark text-capitalize border px-2.5 py-1.5 rounded-3">
                                                    <?= esc($row['kategori']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="text-dark fw-semibold mb-1"><?= esc($row['keterangan']) ?></div>
                                                <small class="text-muted">
                                                    <?php if ($row['tipe'] === 'masuk') : ?>
                                                        <span class="text-success"><i class="fa-solid fa-circle-arrow-down me-1"></i> Masuk</span>
                                                    <?php else : ?>
                                                        <span class="text-danger"><i class="fa-solid fa-circle-arrow-up me-1"></i> Keluar</span>
                                                    <?php endif; ?>
                                                </small>
                                            </td>
                                            <td><?= esc($row['penanggung_jawab']) ?: '-' ?></td>
                                            <td class="text-center">
                                                <?php if (!empty($row['bukti_transaksi'])) : ?>
                                                    <a href="<?= base_url('uploads/keuangan/' . $row['bukti_transaksi']) ?>" target="_blank" class="btn-action btn-edit" title="Lihat Bukti Transaksi" style="background-color: rgba(16, 185, 129, 0.1); color: #10b981;">
                                                        <i class="fa-solid <?= str_ends_with($row['bukti_transaksi'], '.pdf') ? 'fa-file-pdf' : 'fa-image' ?>"></i>
                                                    </a>
                                                <?php else : ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-end fw-bold font-heading <?= $row['tipe'] === 'masuk' ? 'text-success' : 'text-danger' ?>">
                                                <?= $row['tipe'] === 'masuk' ? '+' : '-' ?> Rp <?= number_format($row['nominal'], 0, ',', '.') ?>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <a href="<?= base_url('dashboard/keuangan/edit/' . $row['id'] . '?kegiatan_id=' . esc($kegiatan['id'])) ?>" class="btn-action btn-edit" title="Ubah">
                                                        <i class="fa-solid fa-pencil"></i>
                                                    </a>
                                                    <a href="<?= base_url('dashboard/keuangan/delete/' . $row['id'] . '?kegiatan_id=' . esc($kegiatan['id'])) ?>" class="btn-action btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus catatan kas ini?');" title="Hapus">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="7" class="text-center py-5 text-muted">
                                            <i class="fa-solid fa-wallet fs-1 mb-3 d-block text-secondary"></i>
                                            Belum ada pencatatan kas untuk kegiatan ini.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- TAB RUNDOWN & JADWAL ACARA -->
            <div class="tab-pane fade" id="rundown" role="tabpanel" aria-labelledby="rundown-tab">
                <div class="panel-card bg-white border-0 shadow-sm rounded-4">
                    <div class="panel-title d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
                        <span class="fw-bold text-dark fs-5">Rundown & Jadwal Acara Kegiatan</span>
                        <a href="<?= base_url('dashboard/agenda/create?kegiatan_id=' . esc($kegiatan['id'])) ?>" class="btn btn-sm btn-success" style="background-color: var(--primary); border: none; padding: 8px 16px; border-radius: 8px;">
                            <i class="fa-solid fa-plus me-2"></i>Jadwalkan Acara Baru
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table custom-table">
                            <thead>
                                <tr>
                                    <th style="width: 100px;">Brosur</th>
                                    <th>Tema / Acara</th>
                                    <th>Narasumber/Ustadz</th>
                                    <th>Tanggal & Waktu</th>
                                    <th>Lokasi</th>
                                    <th class="text-center" style="width: 120px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($agenda_list)) : ?>
                                    <?php foreach ($agenda_list as $row) : ?>
                                        <tr>
                                            <td>
                                                <?php if ($row['banner']) : ?>
                                                    <img src="<?= base_url('uploads/images/' . $row['banner']) ?>" class="rounded" style="width: 70px; height: 45px; object-fit: cover;" alt="Brosur">
                                                <?php else : ?>
                                                    <span class="badge bg-light text-muted border py-1.5 px-2.5" style="font-size: 0.75rem;">No Image</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <strong class="text-dark d-block mb-1"><?= esc($row['judul']) ?></strong>
                                                <small class="text-muted d-block text-truncate" style="max-width: 250px;"><?= esc(strip_tags($row['deskripsi'])) ?></small>
                                            </td>
                                            <td>
                                                <?php if ($row['narasumber_id']) : ?>
                                                    <span class="text-dark fw-medium"><i class="fa-solid fa-user-tie text-success me-1"></i><?= esc($row['nama_ustadz']) ?></span>
                                                <?php else : ?>
                                                    <span class="text-dark"><i class="fa-regular fa-user text-muted me-1"></i><?= esc($row['narasumber'] ?: '-') ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="mb-1"><i class="fa-solid fa-calendar-day text-muted me-2" style="font-size: 0.8rem;"></i><?= esc(date('d/m/Y', strtotime($row['tanggal']))) ?></div>
                                                <div><i class="fa-solid fa-clock text-muted me-2" style="font-size: 0.8rem;"></i><?= esc(date('H:i', strtotime($row['waktu']))) ?> WITA</div>
                                            </td>
                                            <td>
                                                <i class="fa-solid fa-location-dot text-danger me-1"></i><?= esc($row['lokasi']) ?>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <a href="<?= base_url('dashboard/agenda/edit/' . $row['id'] . '?kegiatan_id=' . esc($kegiatan['id'])) ?>" class="btn-action btn-edit" title="Ubah">
                                                        <i class="fa-solid fa-pencil"></i>
                                                    </a>
                                                    <a href="<?= base_url('dashboard/agenda/delete/' . $row['id'] . '?kegiatan_id=' . esc($kegiatan['id'])) ?>" class="btn-action btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus jadwal acara ini?');" title="Hapus">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">
                                            <i class="fa-regular fa-calendar-minus fs-1 mb-3 d-block text-secondary"></i>
                                            Belum ada jadwal acara khusus kegiatan ini.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
