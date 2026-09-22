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

        /* Hierarchical Accordion Styles */
        .accordion-hierarchy .accordion-header {
            display: flex;
            align-items: stretch;
            justify-content: space-between;
            background-color: #f9fafb;
        }

        .accordion-hierarchy .accordion-button {
            flex-grow: 1;
            background-color: transparent !important;
            box-shadow: none !important;
            border-radius: 0 !important;
        }

        .accordion-hierarchy .accordion-button:not(.collapsed) {
            color: var(--primary);
        }

        .accordion-hierarchy .accordion-actions {
            display: flex;
            align-items: center;
            padding: 0 16px;
            background-color: #ffffff;
            border-left: 1px solid #e5e7eb;
            z-index: 10;
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
                    <a href="<?= base_url('dashboard/kepanitiaan/lpj/' . esc($kegiatan['id'])) ?>" target="_blank" class="btn btn-sm btn-success px-3 py-2 fw-semibold" style="background-color: var(--primary); border: none; border-radius: 8px;">
                        <i class="fa-solid fa-file-invoice-dollar me-2"></i>Cetak LPJ Proyek
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

        if (!function_exists('renderKegiatanTreeListHtml')) {
            function renderKegiatanTreeListHtml($tree, $kegiatanId, $level = 0) {
                $html = '';
                foreach ($tree as $node) {
                    $cleanId = preg_replace('/[^a-zA-Z0-9_-]/', '', $node['id']);
                    $collapseId = 'collapse-tree-' . $cleanId;
                    $hasChildren = !empty($node['children']);
                    $hasPanitia = !empty($node['panitia']);
                    $panitiaCount = $hasPanitia ? count($node['panitia']) : 0;
                    $childrenCount = $hasChildren ? count($node['children']) : 0;
                    $indentPadding = ($level * 28 + 16);

                    $html .= '<div class="tree-node-item border-bottom jabatan-tree-node" data-name="' . strtolower(esc($node['nama_jabatan'])) . '">';
                    
                    // Baris Jabatan (Clean Row)
                    $html .= '<div class="d-flex align-items-center justify-content-between py-2.5 px-3 hover-row" style="padding-left: ' . $indentPadding . 'px; background-color: ' . ($level === 0 ? '#f8fafc' : '#ffffff') . ';">';
                    
                    // Kolom Kiri: Toggle + No Urut + Nama Jabatan + (Atasan)
                    $html .= '<div class="d-flex align-items-center gap-2 overflow-hidden flex-grow-1 me-3">';
                    
                    if ($hasChildren || $hasPanitia) {
                        $html .= '<button class="btn btn-sm btn-link text-secondary p-0 border-0 text-decoration-none btn-tree-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#' . $collapseId . '" aria-expanded="true" style="width: 20px; font-size: 0.85rem;">';
                        $html .= '<i class="fa-solid fa-chevron-down tree-arrow"></i>';
                        $html .= '</button>';
                    } else {
                        $html .= '<span style="width: 20px; display: inline-block; text-align: center; color: #cbd5e1;">•</span>';
                    }
                    
                    $html .= '<span class="badge bg-light text-secondary border small font-monospace" style="font-size: 0.75rem;">' . esc($node['urutan']) . '</span>';
                    
                    if ($level === 0) {
                        $html .= '<strong class="text-dark fs-6 text-truncate" title="' . esc($node['nama_jabatan']) . '">' . esc($node['nama_jabatan']) . '</strong>';
                    } else {
                        $html .= '<span class="text-dark fw-semibold text-truncate" title="' . esc($node['nama_jabatan']) . '" style="font-size: 0.925rem;">' . esc($node['nama_jabatan']) . '</span>';
                    }
                    
                    if (!empty($node['nama_atasan'])) {
                        $html .= '<small class="text-muted d-none d-xl-inline text-truncate" style="max-width: 220px;">(Atasan: ' . esc($node['nama_atasan']) . ')</small>';
                    }
                    $html .= '</div>';
                    
                    // Kolom Tengah: Info Ringkas (Badge Jumlah Panitia & Sub)
                    $html .= '<div class="d-flex align-items-center gap-2 flex-shrink-0 me-3">';
                    if ($panitiaCount > 0) {
                        $html .= '<span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2.5 py-0.5 rounded-pill" style="font-size: 0.775rem;">';
                        $html .= '<i class="fa-solid fa-user me-1"></i>' . $panitiaCount . ' Orang';
                        $html .= '</span>';
                    } else {
                        $html .= '<span class="text-muted small" style="font-size: 0.775rem;">Belum ada panitia</span>';
                    }
                    
                    if ($childrenCount > 0) {
                        $html .= '<span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 px-2 py-0.5 rounded-pill" style="font-size: 0.775rem;">';
                        $html .= $childrenCount . ' Sub-Seksi';
                        $html .= '</span>';
                    }
                    $html .= '</div>';
                    
                    // Kolom Kanan: Tombol Aksi Cepat
                    $html .= '<div class="d-flex align-items-center gap-1.5 flex-shrink-0">';
                    $html .= '<a href="' . base_url('dashboard/kepanitiaan/panitia/create?kegiatan_id=' . esc($kegiatanId) . '&jabatan_kegiatan_id=' . esc($node['id'])) . '" class="btn btn-sm btn-outline-success py-1 px-2.5 rounded-2" style="font-size: 0.775rem;" title="Tambah Panitia"><i class="fa-solid fa-user-plus me-1"></i>+ Panitia</a>';
                    $html .= '<a href="' . base_url('dashboard/kepanitiaan/jabatan/create?kegiatan_id=' . esc($kegiatanId) . '&parent_id=' . esc($node['id'])) . '" class="btn btn-sm btn-outline-primary py-1 px-2.5 rounded-2" style="font-size: 0.775rem;" title="Tambah Sub-Jabatan"><i class="fa-solid fa-plus me-1"></i>+ Sub</a>';
                    $html .= '<a href="' . base_url('dashboard/kepanitiaan/jabatan/edit/' . esc($node['id']) . '?kegiatan_id=' . esc($kegiatanId)) . '" class="btn btn-sm btn-outline-warning py-1 px-2 rounded-2" style="font-size: 0.775rem;" title="Ubah Jabatan"><i class="fa-solid fa-pencil"></i></a>';
                    $html .= '<a href="' . base_url('dashboard/kepanitiaan/jabatan/delete/' . esc($node['id'])) . '" class="btn btn-sm btn-outline-danger py-1 px-2 rounded-2" style="font-size: 0.775rem;" onclick="return confirm(\'Hapus jabatan ini? Penugasan panitia terkait juga akan dihapus.\')" title="Hapus Jabatan"><i class="fa-solid fa-trash"></i></a>';
                    $html .= '</div>';
                    
                    $html .= '</div>'; // End baris jabatan
                    
                    // Collapsible Container untuk personil & sub-jabatan
                    $html .= '<div id="' . $collapseId . '" class="collapse show tree-child-collapse">';
                    
                    // Daftar Personil di bawah jabatan ini
                    if ($hasPanitia) {
                        $panitiaIndent = $indentPadding + 28;
                        $html .= '<div class="tree-panitia-container py-1" style="background-color: rgba(248, 250, 252, 0.6);">';
                        foreach ($node['panitia'] as $pIndex => $pan) {
                            $html .= '<div class="d-flex align-items-center justify-content-between py-1.5 px-3 border-bottom border-light hover-row panitia-person-row" style="padding-left: ' . $panitiaIndent . 'px;" data-name="' . strtolower(esc($pan['nama'])) . '">';
                            
                            $html .= '<div class="d-flex align-items-center gap-2 overflow-hidden flex-grow-1 me-3">';
                            $html .= '<span class="text-muted small" style="min-width: 18px;">' . ($pIndex + 1) . '.</span>';
                            $html .= '<i class="fa-solid fa-user text-success small" style="font-size: 0.75rem;"></i>';
                            $html .= '<strong class="text-dark small">' . esc($pan['nama']) . '</strong>';
                            
                            if (!empty($pan['no_hp'])) {
                                $html .= '<a href="https://api.whatsapp.com/send?phone=' . esc($pan['no_hp']) . '" target="_blank" class="text-success small ms-2 text-decoration-none" style="font-size: 0.775rem;">';
                                $html .= '<i class="fa-brands fa-whatsapp"></i> ' . esc($pan['no_hp']);
                                $html .= '</a>';
                            }
                            
                            if (!empty($pan['tugas'])) {
                                $html .= '<span class="text-muted small ms-2 text-truncate" style="max-width: 320px; font-size: 0.75rem;" title="' . esc($pan['tugas']) . '">';
                                $html .= '— ' . esc($pan['tugas']);
                                $html .= '</span>';
                            }
                            $html .= '</div>';
                            
                            // Tombol Edit/Hapus Personil
                            $html .= '<div class="d-flex align-items-center gap-2 flex-shrink-0">';
                            $html .= '<a href="' . base_url('dashboard/kepanitiaan/panitia/edit/' . esc($pan['id']) . '?kegiatan_id=' . esc($kegiatanId)) . '" class="text-primary small text-decoration-none px-1" title="Edit Personil"><i class="fa-solid fa-pen"></i></a>';
                            $html .= '<a href="' . base_url('dashboard/kepanitiaan/panitia/delete/' . esc($pan['id'])) . '" class="text-danger small text-decoration-none px-1" onclick="return confirm(\'Hapus penugasan panitia ini?\')" title="Hapus Personil"><i class="fa-solid fa-trash"></i></a>';
                            $html .= '</div>';
                            
                            $html .= '</div>';
                        }
                        $html .= '</div>';
                    }
                    
                    // Sub-jabatan anak (rekursif)
                    if ($hasChildren) {
                        $html .= renderKegiatanTreeListHtml($node['children'], $kegiatanId, $level + 1);
                    }
                    
                    $html .= '</div>'; // End collapsible
                    $html .= '</div>'; // End tree-node-item
                }
                return $html;
            }
        }
        ?>

        <!-- Nav tabs -->
        <ul class="nav nav-pills mb-4 gap-2" id="kepanitiaanTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="struktur-tab" data-bs-toggle="tab" data-bs-target="#struktur" type="button" role="tab" aria-controls="struktur" aria-selected="true">
                    <i class="fa-solid fa-sitemap me-2"></i>Struktur Organisasi (Hirarki)
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
                <button class="nav-link" id="material-tab" data-bs-toggle="tab" data-bs-target="#material" type="button" role="tab" aria-controls="material" aria-selected="false">
                    <i class="fa-solid fa-truck-ramp-box me-2"></i>Bantuan Material (Nontunai)
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="keuangan-tab" data-bs-toggle="tab" data-bs-target="#keuangan" type="button" role="tab" aria-controls="keuangan" aria-selected="false">
                    <i class="fa-solid fa-wallet me-2"></i>Laporan Kas Uang
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
            <!-- TAB STRUKTUR ORGANISASI (JABATAN & PANITIA - TREE LIST VIEW) -->
            <div class="tab-pane fade show active" id="struktur" role="tabpanel" aria-labelledby="struktur-tab">
                <div class="bg-white border rounded-3 p-4 mb-4 shadow-sm">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4 pb-3 border-bottom">
                        <div>
                            <span class="fw-bold text-dark fs-5 d-block">Struktur Hirarki Kepanitiaan</span>
                            <small class="text-muted">Daftar hirarki struktur jabatan dan susunan personil panitia pelaksana.</small>
                        </div>
                        <div class="d-flex flex-wrap align-items-center gap-2">
                            <div class="input-group input-group-sm" style="width: 220px;">
                                <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-search text-muted"></i></span>
                                <input type="text" id="searchTreeInput" class="form-control bg-light border-start-0" placeholder="Cari jabatan/nama...">
                            </div>
                            <button type="button" id="btnExpandAllTree" class="btn btn-sm btn-outline-secondary px-2.5 py-1.5 fw-semibold" style="border-radius: 8px;">
                                <i class="fa-solid fa-angles-down me-1"></i>Buka Semua
                            </button>
                            <button type="button" id="btnCollapseAllTree" class="btn btn-sm btn-outline-secondary px-2.5 py-1.5 fw-semibold" style="border-radius: 8px;">
                                <i class="fa-solid fa-angles-up me-1"></i>Tutup Semua
                            </button>
                            <a href="<?= base_url('dashboard/kepanitiaan/jabatan/create?kegiatan_id=' . esc($kegiatan['id'])) ?>" class="btn btn-sm btn-outline-success px-3 py-1.5 fw-semibold" style="border-radius: 8px;">
                                <i class="fa-solid fa-plus me-1"></i>Tambah Jabatan Utama
                            </a>
                            <a href="<?= base_url('dashboard/kepanitiaan/panitia/create?kegiatan_id=' . esc($kegiatan['id'])) ?>" class="btn btn-sm btn-success px-3 py-1.5 fw-semibold" style="background-color: var(--primary); border: none; border-radius: 8px;">
                                <i class="fa-solid fa-user-plus me-1"></i>Tugaskan Panitia
                            </a>
                        </div>
                    </div>

                    <?php if (!empty($jabatan_list)) : ?>
                        <?php
                            // Kelompokkan jabatan berdasarkan kategori_unit
                            $unitGroups = [];
                            foreach ($jabatan_list as $j) {
                                $unitName = !empty($j['kategori_unit']) ? trim($j['kategori_unit']) : 'Pelaksana Utama';
                                if (!isset($unitGroups[$unitName])) {
                                    $unitGroups[$unitName] = [];
                                }
                                $unitGroups[$unitName][] = $j;
                            }

                            // Urutan standar unit
                            $unitOrder = [
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

                            // Susun urutan unit
                            $sortedUnits = [];
                            foreach ($unitOrder as $u) {
                                if (isset($unitGroups[$u])) {
                                    $sortedUnits[$u] = $unitGroups[$u];
                                    unset($unitGroups[$u]);
                                }
                            }
                            foreach ($unitGroups as $u => $items) {
                                $sortedUnits[$u] = $items;
                            }
                        ?>

                        <!-- Unit Navigation Pills -->
                        <div class="d-flex flex-wrap gap-1.5 mb-3 pb-2 border-bottom unit-filter-nav">
                            <button type="button" class="btn btn-sm btn-dark rounded-pill px-3 py-1 btn-unit-filter active" data-unit="all">Semua Unit (<?= count($sortedUnits) ?>)</button>
                            <?php 
                                $unitIcons = [
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
                                foreach ($sortedUnits as $unitName => $uJabatan) : 
                                    $iconClass = $unitIcons[$unitName] ?? 'fa-layer-group text-secondary';
                                    $countPanitiaUnit = 0;
                                    foreach ($uJabatan as $uj) {
                                        $countPanitiaUnit += !empty($uj['panitia']) ? count($uj['panitia']) : 0;
                                    }
                            ?>
                                <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-2.5 py-1 btn-unit-filter" data-unit="<?= esc(preg_replace('/[^a-zA-Z0-9]/', '', $unitName)) ?>">
                                    <i class="fa-solid <?= $iconClass ?> me-1"></i><?= esc($unitName) ?>
                                    <span class="badge bg-light text-dark border ms-1" style="font-size: 0.7rem;"><?= count($uJabatan) ?> pos</span>
                                </button>
                            <?php endforeach; ?>
                        </div>

                        <!-- Tree Container Grouped by Unit -->
                        <div class="d-flex flex-column gap-3" id="treePanitiaContainer">
                            <?php foreach ($sortedUnits as $unitName => $uJabatan) : 
                                $unitSlug = preg_replace('/[^a-zA-Z0-9]/', '', $unitName);
                                $unitIcon = $unitIcons[$unitName] ?? 'fa-layer-group text-secondary';
                                $totalUnitPanitia = 0;
                                foreach ($uJabatan as $uj) {
                                    $totalUnitPanitia += !empty($uj['panitia']) ? count($uj['panitia']) : 0;
                                }
                            ?>
                                <div class="unit-group-wrapper border rounded-3 overflow-hidden shadow-2xs" data-unit-slug="<?= esc($unitSlug) ?>">
                                    <!-- Unit Header Banner -->
                                    <div class="d-flex align-items-center justify-content-between px-3 py-2.5 bg-light border-bottom">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fa-solid <?= $unitIcon ?> fs-6"></i>
                                            <strong class="text-dark" style="font-size: 0.95rem;"><?= esc($unitName) ?></strong>
                                            <span class="badge bg-white text-secondary border small ms-1"><?= count($uJabatan) ?> Jabatan</span>
                                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 small"><?= $totalUnitPanitia ?> Panitia</span>
                                        </div>
                                        <div class="text-end text-muted small d-none d-sm-block">
                                            <i class="fa-solid fa-folder-tree me-1"></i>Unit Blok
                                        </div>
                                    </div>

                                    <!-- Table Head -->
                                    <div class="d-flex align-items-center justify-content-between py-2 px-3 bg-white border-bottom fw-bold text-secondary" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                        <div class="flex-grow-1">Nama Jabatan & Personil</div>
                                        <div style="width: 130px;" class="text-center d-none d-md-block">Status Panitia</div>
                                        <div style="width: 220px;" class="text-end">Aksi</div>
                                    </div>

                                    <!-- Tree Rows within this Unit -->
                                    <div class="tree-rows-body bg-white">
                                        <?php 
                                            $uTree = buildKegiatanTree($uJabatan, null);
                                            // Jika ada jabatan yang parent-nya di luar unit atau tidak null di uTree, cari yang parent_id tidak ada di daftar unit ini
                                            if (empty($uTree)) {
                                                // Fallback: render baris langsung
                                                $uTree = $uJabatan;
                                            }
                                            echo renderKegiatanTreeListHtml($uTree, $kegiatan['id'], 0);
                                        ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else : ?>
                        <div class="text-center py-5 text-muted bg-light rounded-3 border border-dashed">
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

            <!-- TAB BANTUAN MATERIAL / BARANG (NONTUNAI) -->
            <div class="tab-pane fade" id="material" role="tabpanel" aria-labelledby="material-tab">
                <!-- Summary Card Material -->
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm rounded-4 p-4" style="background-color: #fffbeb; border: 1px solid #fde68a !important;">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <span class="text-muted small fw-semibold d-block mb-1">Total Nilai Material & Barang (Nontunai)</span>
                                    <strong class="fs-4 text-warning font-heading" style="color: #b45309 !important;">Rp <?= number_format($total_nilai_material, 0, ',', '.') ?></strong>
                                </div>
                                <div class="p-3 rounded-3" style="background-color: rgba(245, 158, 11, 0.15); color: #d97706;">
                                    <i class="fa-solid fa-truck-ramp-box fs-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm rounded-4 p-4" style="background-color: #f0fdf4; border: 1px solid #bbf7d0 !important;">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <span class="text-muted small fw-semibold d-block mb-1">Grand Total (Material + Kas Masuk)</span>
                                    <strong class="fs-4 text-success font-heading">Rp <?= number_format($grand_total_penerimaan, 0, ',', '.') ?></strong>
                                </div>
                                <div class="p-3 bg-success bg-opacity-10 text-success rounded-3">
                                    <i class="fa-solid fa-calculator fs-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel-card bg-white border-0 shadow-sm rounded-4">
                    <div class="panel-title d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
                        <span class="fw-bold text-dark fs-5">Daftar Bantuan Material & Barang Proyek</span>
                        <button type="button" class="btn btn-sm btn-warning text-dark fw-semibold" data-bs-toggle="modal" data-bs-target="#modalTambahMaterial" style="border: none; padding: 8px 16px; border-radius: 8px;">
                            <i class="fa-solid fa-plus me-2"></i>Catat Bantuan Material
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table custom-table">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Donatur / Sumber</th>
                                    <th>Uraian Material / Barang</th>
                                    <th>Kategori</th>
                                    <th class="text-center">Volume</th>
                                    <th class="text-end">Harga Satuan</th>
                                    <th class="text-end">Total Nilai</th>
                                    <th class="text-center" style="width: 100px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($material_list)) : ?>
                                    <?php foreach ($material_list as $m) : ?>
                                        <tr>
                                            <td class="fw-semibold text-dark"><?= esc(date('d/m/Y', strtotime($m['tanggal']))) ?></td>
                                            <td>
                                                <strong class="text-dark d-block"><?= esc($m['nama_donatur']) ?></strong>
                                                <?php if (!empty($m['keterangan'])): ?>
                                                    <small class="text-muted"><?= esc($m['keterangan']) ?></small>
                                                <?php endif; ?>
                                            </td>
                                            <td><strong class="text-dark"><?= esc($m['uraian_material']) ?></strong></td>
                                            <td>
                                                <span class="badge bg-light text-dark text-capitalize border px-2.5 py-1.5 rounded-3">
                                                    <?= str_replace('_', ' ', esc($m['kategori_material'])) ?>
                                                </span>
                                            </td>
                                            <td class="text-center fw-semibold">
                                                <?= number_format($m['volume'], 0, ',', '.') ?> <?= esc($m['satuan']) ?>
                                            </td>
                                            <td class="text-end text-muted">
                                                Rp <?= number_format($m['harga_satuan'], 0, ',', '.') ?>
                                            </td>
                                            <td class="text-end fw-bold font-heading text-dark">
                                                Rp <?= number_format($m['total_nilai'], 0, ',', '.') ?>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <button type="button" class="btn-action btn-edit" title="Ubah"
                                                        data-bs-toggle="modal" data-bs-target="#modalEditMaterial"
                                                        data-id="<?= esc($m['id']) ?>"
                                                        data-tanggal="<?= esc($m['tanggal']) ?>"
                                                        data-nama_donatur="<?= esc($m['nama_donatur']) ?>"
                                                        data-uraian_material="<?= esc($m['uraian_material']) ?>"
                                                        data-kategori_material="<?= esc($m['kategori_material']) ?>"
                                                        data-volume="<?= esc($m['volume']) ?>"
                                                        data-satuan="<?= esc($m['satuan']) ?>"
                                                        data-harga_satuan="<?= esc($m['harga_satuan']) ?>"
                                                        data-keterangan="<?= esc($m['keterangan'] ?? '') ?>">
                                                        <i class="fa-solid fa-pencil"></i>
                                                    </button>
                                                    <a href="<?= base_url('dashboard/kepanitiaan/material/delete/' . $m['id']) ?>" class="btn-action btn-delete" onclick="return confirm('Hapus catatan bantuan material ini?');" title="Hapus">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="8" class="text-center py-5 text-muted">
                                            <i class="fa-solid fa-truck-ramp-box fs-1 mb-3 d-block text-secondary"></i>
                                            Belum ada pencatatan bantuan material/barang untuk kegiatan ini.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- MODAL TAMBAH BANTUAN MATERIAL -->
            <div class="modal fade" id="modalTambahMaterial" tabindex="-1" aria-labelledby="modalTambahMaterialLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow-lg rounded-4">
                        <form action="<?= base_url('dashboard/kepanitiaan/material/store') ?>" method="post">
                            <?= csrf_field() ?>
                            <input type="hidden" name="kegiatan_id" value="<?= esc($kegiatan['id']) ?>">
                            
                            <div class="modal-header border-bottom-0 pb-0 pt-4 px-4">
                                <h5 class="modal-title fw-bold text-dark" id="modalTambahMaterialLabel">
                                    <i class="fa-solid fa-truck-ramp-box me-2 text-warning"></i>Catat Bantuan Material / Barang
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            
                            <div class="modal-body p-4">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small text-dark">Tanggal Penerimaan <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal" class="form-control" value="<?= date('Y-m-d') ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small text-dark">Nama Donatur / Sumber</label>
                                    <input type="text" name="nama_donatur" class="form-control" placeholder="Contoh: Ibu Jumuati Syuyuti / Jamaah Masjid" value="Hamba Allah">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small text-dark">Uraian Material / Barang <span class="text-danger">*</span></label>
                                    <input type="text" name="uraian_material" class="form-control" placeholder="Contoh: Batu Gunung / Pasir / LED TV 55 Inc (LG)" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small text-dark">Kategori Material <span class="text-danger">*</span></label>
                                    <select name="kategori_material" class="form-select" required>
                                        <option value="material_konstruksi">Material Konstruksi (Batu, Pasir, Semen, Besi)</option>
                                        <option value="inventaris_elektronik">Inventaris & Elektronik (TV, Sound, AC, Lampu)</option>
                                        <option value="perlengkapan_ibadah">Perlengkapan Ibadah (Karpet, Al-Quran, Mimbar)</option>
                                        <option value="lainnya">Lainnya</option>
                                    </select>
                                </div>
                                <div class="row g-3 mb-3">
                                    <div class="col-6">
                                        <label class="form-label fw-semibold small text-dark">Volume / Jumlah <span class="text-danger">*</span></label>
                                        <input type="number" step="0.01" name="volume" id="mat_volume" class="form-control" placeholder="55" required oninput="calcMatTotal()">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label fw-semibold small text-dark">Satuan <span class="text-danger">*</span></label>
                                        <input type="text" name="satuan" class="form-control" placeholder="Truk / Sak / Buah" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small text-dark">Estimasi Harga Satuan (Rp)</label>
                                    <input type="number" name="harga_satuan" id="mat_harga" class="form-control" placeholder="1000000" oninput="calcMatTotal()">
                                </div>
                                <div class="p-3 bg-light rounded-3 mb-3 text-center">
                                    <small class="text-muted d-block">Estimasi Total Nilai Valuasi</small>
                                    <strong class="fs-5 text-dark" id="mat_total_preview">Rp 0</strong>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small text-dark">Keterangan Tambahan</label>
                                    <textarea name="keterangan" class="form-control" rows="2" placeholder="Catatan opsional spesifikasi atau lokasi penyimpanan material"></textarea>
                                </div>
                            </div>
                            
                            <div class="modal-footer border-top-0 pt-0 pb-4 px-4">
                                <button type="button" class="btn btn-light px-4 py-2" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-warning text-dark fw-semibold px-4 py-2">Simpan Catatan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- MODAL EDIT BANTUAN MATERIAL -->
            <div class="modal fade" id="modalEditMaterial" tabindex="-1" aria-labelledby="modalEditMaterialLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow-lg rounded-4">
                        <form id="formEditMaterial" action="" method="post">
                            <?= csrf_field() ?>
                            
                            <div class="modal-header border-bottom-0 pb-0 pt-4 px-4">
                                <h5 class="modal-title fw-bold text-dark" id="modalEditMaterialLabel">
                                    <i class="fa-solid fa-pencil me-2 text-warning"></i>Ubah Catatan Bantuan Material
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            
                            <div class="modal-body p-4">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small text-dark">Tanggal Penerimaan <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal" id="edit_mat_tanggal" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small text-dark">Nama Donatur / Sumber</label>
                                    <input type="text" name="nama_donatur" id="edit_mat_donatur" class="form-control" placeholder="Contoh: Ibu Jumuati Syuyuti / Jamaah Masjid">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small text-dark">Uraian Material / Barang <span class="text-danger">*</span></label>
                                    <input type="text" name="uraian_material" id="edit_mat_uraian" class="form-control" placeholder="Contoh: Batu Gunung / Pasir / LED TV 55 Inc (LG)" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small text-dark">Kategori Material <span class="text-danger">*</span></label>
                                    <select name="kategori_material" id="edit_mat_kategori" class="form-select" required>
                                        <option value="material_konstruksi">Material Konstruksi (Batu, Pasir, Semen, Besi)</option>
                                        <option value="inventaris_elektronik">Inventaris & Elektronik (TV, Sound, AC, Lampu)</option>
                                        <option value="perlengkapan_ibadah">Perlengkapan Ibadah (Karpet, Al-Quran, Mimbar)</option>
                                        <option value="lainnya">Lainnya</option>
                                    </select>
                                </div>
                                <div class="row g-3 mb-3">
                                    <div class="col-6">
                                        <label class="form-label fw-semibold small text-dark">Volume / Jumlah <span class="text-danger">*</span></label>
                                        <input type="number" step="0.01" name="volume" id="edit_mat_volume" class="form-control" placeholder="55" required oninput="calcEditMatTotal()">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label fw-semibold small text-dark">Satuan <span class="text-danger">*</span></label>
                                        <input type="text" name="satuan" id="edit_mat_satuan" class="form-control" placeholder="Truk / Sak / Buah" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small text-dark">Estimasi Harga Satuan (Rp)</label>
                                    <input type="number" name="harga_satuan" id="edit_mat_harga" class="form-control" placeholder="1000000" oninput="calcEditMatTotal()">
                                </div>
                                <div class="p-3 bg-light rounded-3 mb-3 text-center">
                                    <small class="text-muted d-block">Estimasi Total Nilai Valuasi</small>
                                    <strong class="fs-5 text-dark" id="edit_mat_total_preview">Rp 0</strong>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small text-dark">Keterangan Tambahan</label>
                                    <textarea name="keterangan" id="edit_mat_keterangan" class="form-control" rows="2" placeholder="Catatan opsional spesifikasi atau lokasi penyimpanan material"></textarea>
                                </div>
                            </div>
                            
                            <div class="modal-footer border-top-0 pt-0 pb-4 px-4">
                                <button type="button" class="btn btn-light px-4 py-2" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-warning text-dark fw-semibold px-4 py-2">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <script>
            function calcMatTotal() {
                var vol = parseFloat(document.getElementById('mat_volume').value) || 0;
                var hrg = parseFloat(document.getElementById('mat_harga').value) || 0;
                var tot = vol * hrg;
                document.getElementById('mat_total_preview').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(tot);
            }

            function calcEditMatTotal() {
                var vol = parseFloat(document.getElementById('edit_mat_volume').value) || 0;
                var hrg = parseFloat(document.getElementById('edit_mat_harga').value) || 0;
                var tot = vol * hrg;
                document.getElementById('edit_mat_total_preview').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(tot);
            }

            document.addEventListener('DOMContentLoaded', function() {
                var modalEditMaterial = document.getElementById('modalEditMaterial');
                if (modalEditMaterial) {
                    modalEditMaterial.addEventListener('show.bs.modal', function (event) {
                        var button = event.relatedTarget;
                        var id = button.getAttribute('data-id');
                        var tanggal = button.getAttribute('data-tanggal');
                        var donatur = button.getAttribute('data-nama_donatur');
                        var uraian = button.getAttribute('data-uraian_material');
                        var kategori = button.getAttribute('data-kategori_material');
                        var volume = button.getAttribute('data-volume');
                        var satuan = button.getAttribute('data-satuan');
                        var harga = button.getAttribute('data-harga_satuan');
                        var keterangan = button.getAttribute('data-keterangan');

                        document.getElementById('formEditMaterial').action = '<?= base_url('dashboard/kepanitiaan/material/update') ?>/' + id;
                        document.getElementById('edit_mat_tanggal').value = tanggal;
                        document.getElementById('edit_mat_donatur').value = donatur;
                        document.getElementById('edit_mat_uraian').value = uraian;
                        document.getElementById('edit_mat_kategori').value = kategori;
                        document.getElementById('edit_mat_volume').value = volume;
                        document.getElementById('edit_mat_satuan').value = satuan;
                        document.getElementById('edit_mat_harga').value = harga ? Math.round(parseFloat(harga)) : '';
                        document.getElementById('edit_mat_keterangan').value = keterangan || '';
                        calcEditMatTotal();
                    });
                }
            });
            </script>

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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // 0. Unit Group Filter Navigation
            const unitFilterBtns = document.querySelectorAll('.btn-unit-filter');
            const unitWrappers = document.querySelectorAll('.unit-group-wrapper');

            unitFilterBtns.forEach(btn => {
                btn.addEventListener('click', function () {
                    unitFilterBtns.forEach(b => {
                        b.classList.remove('active', 'btn-dark');
                        b.classList.add('btn-outline-secondary');
                    });
                    this.classList.add('active', 'btn-dark');
                    this.classList.remove('btn-outline-secondary');

                    const targetUnit = this.getAttribute('data-unit');
                    unitWrappers.forEach(w => {
                        if (targetUnit === 'all' || w.getAttribute('data-unit-slug') === targetUnit) {
                            w.style.display = '';
                        } else {
                            w.style.display = 'none';
                        }
                    });
                });
            });

            // 1. Expand All Tree Nodes
            document.getElementById('btnExpandAllTree')?.addEventListener('click', function () {
                const collapses = document.querySelectorAll('#treePanitiaContainer .tree-child-collapse');
                collapses.forEach(el => {
                    const bsCollapse = bootstrap.Collapse.getOrCreateInstance(el, { toggle: false });
                    bsCollapse.show();
                });
            });

            // 2. Collapse All Tree Nodes
            document.getElementById('btnCollapseAllTree')?.addEventListener('click', function () {
                const collapses = document.querySelectorAll('#treePanitiaContainer .tree-child-collapse');
                collapses.forEach(el => {
                    const bsCollapse = bootstrap.Collapse.getOrCreateInstance(el, { toggle: false });
                    bsCollapse.hide();
                });
            });

            // 3. Live Search Filter for Tree Nodes & Panitia Names
            document.getElementById('searchTreeInput')?.addEventListener('input', function () {
                const query = this.value.toLowerCase().trim();
                const nodes = document.querySelectorAll('#treePanitiaContainer .jabatan-tree-node');

                if (query === '') {
                    nodes.forEach(node => {
                        node.style.display = '';
                    });
                    const personRows = document.querySelectorAll('#treePanitiaContainer .panitia-person-row');
                    personRows.forEach(row => {
                        row.style.display = '';
                    });
                    return;
                }

                nodes.forEach(node => {
                    const nodeName = node.getAttribute('data-name') || '';
                    const personRows = node.querySelectorAll('.panitia-person-row');
                    let personMatched = false;

                    personRows.forEach(p => {
                        const pName = p.getAttribute('data-name') || '';
                        if (pName.includes(query)) {
                            p.style.display = '';
                            personMatched = true;
                        } else {
                            p.style.display = 'none';
                        }
                    });

                    if (nodeName.includes(query) || personMatched) {
                        node.style.display = '';
                        // Show all matching person rows if node title matched
                        if (nodeName.includes(query)) {
                            personRows.forEach(p => p.style.display = '');
                        }
                        // Auto-expand this node and its parent collapses
                        let parentCollapse = node.closest('.tree-child-collapse');
                        while (parentCollapse) {
                            const bsCollapse = bootstrap.Collapse.getOrCreateInstance(parentCollapse, { toggle: false });
                            bsCollapse.show();
                            parentCollapse = parentCollapse.parentElement?.closest('.tree-child-collapse');
                        }
                        const myCollapse = node.querySelector('.tree-child-collapse');
                        if (myCollapse) {
                            bootstrap.Collapse.getOrCreateInstance(myCollapse, { toggle: false }).show();
                        }
                    } else {
                        // Check if any child node matches
                        const hasMatchingChild = node.querySelector('.jabatan-tree-node[data-name*="' + query + '"]');
                        if (!hasMatchingChild) {
                            node.style.display = 'none';
                        } else {
                            node.style.display = '';
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>
