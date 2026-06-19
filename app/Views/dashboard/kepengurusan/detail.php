<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Periode Kepengurusan - <?= site_name() ?></title>
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

        .table-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #e5e7eb;
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
                <a href="<?= base_url('dashboard/kepengurusan') ?>" class="menu-link active">
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
                <h1 class="h3 fw-bold mb-1 text-dark">Detail Periode Kepengurusan</h1>
                <p class="text-muted mb-0">Kelola jajaran pengurus masjid dan pembagian pos jabatannya.</p>
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

        <!-- INFO DETAIL PERIODE -->
        <div class="panel-card mb-4 bg-white border-0 shadow-sm rounded-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="p-3 rounded-3 bg-success bg-opacity-10 text-success">
                        <i class="fa-solid fa-calendar-check fs-2"></i>
                    </div>
                    <div>
                        <h2 class="h4 fw-bold mb-1 text-dark"><?= esc($periode['nama_periode']) ?></h2>
                        <p class="text-muted mb-0 small">
                            <span class="fw-semibold text-dark">Masa Bakti:</span> <?= esc($periode['tahun_mulai']) ?> - <?= esc($periode['tahun_selesai']) ?>
                            <span class="mx-2">|</span>
                            <span class="fw-semibold text-dark">Status:</span> 
                            <?php if ($periode['status'] === 'aktif') : ?>
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1 rounded-pill">Aktif</span>
                            <?php else : ?>
                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2.5 py-1 rounded-pill">Tidak Aktif</span>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <a href="<?= base_url('dashboard/kepengurusan') ?>" class="btn btn-sm btn-outline-secondary px-3 py-2 fw-semibold" style="border-radius: 8px;">
                        <i class="fa-solid fa-arrow-left me-2"></i>Kembali
                    </a>
                    <a href="<?= base_url('dashboard/kepengurusan/periode/edit/' . esc($periode['id'])) ?>" class="btn btn-sm btn-primary px-3 py-2 fw-semibold" style="background-color: var(--primary-light); border: none; border-radius: 8px;">
                        <i class="fa-solid fa-edit me-2"></i>Ubah Periode
                    </a>
                </div>
            </div>
        </div>

        <!-- Nav tabs -->
        <ul class="nav nav-pills mb-4 gap-2" id="kepengurusanTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="struktur-tab" data-bs-toggle="tab" data-bs-target="#struktur" type="button" role="tab" aria-controls="struktur" aria-selected="true">
                    <i class="fa-solid fa-sitemap me-2"></i>Struktur Organisasi
                </button>
            </li>
        </ul>

        <!-- Tab content -->
        <div class="tab-content">
            <!-- TAB STRUKTUR ORGANISASI (JABATAN & PENGURUS) -->
            <div class="tab-pane fade show active" id="struktur" role="tabpanel" aria-labelledby="struktur-tab">
                <div class="panel-card bg-white border-0 shadow-sm rounded-4 mb-4">
                    <div class="panel-title d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
                        <span class="fw-bold text-dark fs-5">Jajaran Kepengurusan Berdasarkan Jabatan</span>
                        <div class="d-flex gap-2">
                            <a href="<?= base_url('dashboard/kepengurusan/jabatan/create?periode_id=' . esc($periode['id'])) ?>" class="btn btn-sm btn-outline-success px-3 py-2 fw-semibold" style="border-radius: 8px;">
                                <i class="fa-solid fa-plus me-1"></i>Tambah Jabatan
                            </a>
                            <a href="<?= base_url('dashboard/kepengurusan/pengurus/create?periode_id=' . esc($periode['id'])) ?>" class="btn btn-sm btn-success px-3 py-2 fw-semibold" style="background-color: var(--primary); border: none; border-radius: 8px;">
                                <i class="fa-solid fa-user-plus me-1"></i>Tugaskan Pengurus
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
                                                    <small class="text-muted d-block text-truncate" title="Atasan: <?= esc($jab['nama_atasan']) ?>">
                                                        <i class="fa-solid fa-turn-up fa-rotate-90 me-1 text-secondary"></i>
                                                        Atasan: <span class="fw-semibold text-secondary"><?= esc($jab['nama_atasan']) ?></span>
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
                                                        <a class="dropdown-item py-2 px-3 small" href="<?= base_url('dashboard/kepengurusan/jabatan/edit/' . esc($jab['id']) . '?periode_id=' . esc($periode['id'])) ?>">
                                                            <i class="fa-solid fa-edit me-2 text-primary"></i>Ubah Jabatan
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item py-2 px-3 small text-danger" href="<?= base_url('dashboard/kepengurusan/jabatan/delete/' . esc($jab['id'])) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus jabatan ini? Menghapus jabatan akan menghapus penugasan pengurus terkait.')">
                                                            <i class="fa-solid fa-trash me-2"></i>Hapus Jabatan
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        
                                        <!-- Card Body: Daftar Pengurus -->
                                        <div class="card-body px-4 pb-4">
                                            <hr class="mt-1 mb-3 text-muted opacity-25">
                                            
                                            <?php if (!empty($jab['pengurus'])) : ?>
                                                <ul class="list-unstyled mb-0 d-flex flex-column gap-3">
                                                    <?php foreach ($jab['pengurus'] as $peng) : ?>
                                                        <li class="p-3 bg-white rounded-3 shadow-xs border d-flex justify-content-between align-items-center">
                                                            <div class="d-flex align-items-center gap-3 overflow-hidden">
                                                                <?php if ($peng['foto']) : ?>
                                                                    <img src="<?= base_url('uploads/images/' . esc($peng['foto'])) ?>" class="rounded-circle object-fit-cover border" style="width: 40px; height: 40px; flex-shrink: 0;" alt="Foto">
                                                                <?php else : ?>
                                                                    <div class="rounded-circle d-flex align-items-center justify-content-center bg-light text-muted border" style="width: 40px; height: 40px; flex-shrink: 0;">
                                                                        <i class="fa-solid fa-user text-secondary"></i>
                                                                    </div>
                                                                <?php endif; ?>
                                                                
                                                                <div class="overflow-hidden">
                                                                    <strong class="text-dark d-block text-truncate" style="max-width: 120px;" title="<?= esc($peng['nama']) ?>"><?= esc($peng['nama']) ?></strong>
                                                                    <?php if ($peng['no_hp']) : ?>
                                                                        <a href="https://api.whatsapp.com/send?phone=<?= esc($peng['no_hp']) ?>" target="_blank" class="text-decoration-none text-muted small d-inline-block mt-0.5">
                                                                            <i class="fa-brands fa-whatsapp text-success me-1"></i><?= esc($peng['no_hp']) ?>
                                                                        </a>
                                                                    <?php else : ?>
                                                                        <small class="text-muted d-block mt-0.5"><i class="fa-solid fa-phone-slash me-1"></i>Tidak ada WA</small>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                            <!-- Aksi Anggota -->
                                                            <div class="d-flex gap-1 ms-2">
                                                                <a href="<?= base_url('dashboard/kepengurusan/pengurus/edit/' . esc($peng['id']) . '?periode_id=' . esc($periode['id'])) ?>" class="btn-action btn-edit" style="width: 28px; height: 28px; font-size: 0.8rem;" title="Edit Penugasan">
                                                                    <i class="fa-solid fa-pen"></i>
                                                                </a>
                                                                <a href="<?= base_url('dashboard/kepengurusan/pengurus/delete/' . esc($peng['id'])) ?>" class="btn-action btn-delete" style="width: 28px; height: 28px; font-size: 0.8rem;" onclick="return confirm('Apakah Anda yakin ingin menghapus pengurus ini?')" title="Hapus Penugasan">
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
                                                    <a href="<?= base_url('dashboard/kepengurusan/pengurus/create?periode_id=' . esc($periode['id']) . '&jabatan_periode_id=' . esc($jab['id'])) ?>" class="btn btn-xs btn-outline-success py-1 px-2.5 rounded-pill fw-semibold" style="font-size: 0.775rem;">
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
                            Belum ada struktur jabatan dibuat pada periode ini.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
