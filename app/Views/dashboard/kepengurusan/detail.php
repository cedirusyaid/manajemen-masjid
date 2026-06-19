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
                <button class="nav-link active" id="pengurus-tab" data-bs-toggle="tab" data-bs-target="#pengurus" type="button" role="tab" aria-controls="pengurus" aria-selected="true">
                    <i class="fa-solid fa-users-line me-2"></i>Jajaran Pengurus
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="jabatan-tab" data-bs-toggle="tab" data-bs-target="#jabatan" type="button" role="tab" aria-controls="jabatan" aria-selected="false">
                    <i class="fa-solid fa-sitemap me-2"></i>Struktur Jabatan
                </button>
            </li>
        </ul>

        <!-- Tab content -->
        <div class="tab-content">
            <!-- TAB DAFTAR PENGURUS -->
            <div class="tab-pane fade show active" id="pengurus" role="tabpanel" aria-labelledby="pengurus-tab">
                <div class="panel-card">
                    <div class="panel-title">
                        <span>Anggota Jajaran Pengurus</span>
                        <a href="<?= base_url('dashboard/kepengurusan/pengurus/create?periode_id=' . esc($periode['id'])) ?>" class="btn btn-sm btn-success" style="background-color: var(--primary); border: none; padding: 8px 16px; border-radius: 8px;">
                            <i class="fa-solid fa-plus me-2"></i>Tambah Anggota
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table custom-table">
                            <thead>
                                <tr>
                                    <th style="width: 80px;">Foto</th>
                                    <th>Nama Pengurus</th>
                                    <th>Jabatan</th>
                                    <th>Atasan / Induk</th>
                                    <th>Kontak WA</th>
                                    <th style="width: 120px;" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($pengurus_list)) : ?>
                                    <?php foreach ($pengurus_list as $pengurus) : ?>
                                        <tr>
                                            <td>
                                                <?php if ($pengurus['foto']) : ?>
                                                    <img src="<?= base_url('uploads/images/' . esc($pengurus['foto'])) ?>" class="table-avatar" alt="Foto">
                                                <?php else : ?>
                                                    <div class="table-avatar d-flex align-items-center justify-content-center bg-light text-muted">
                                                        <i class="fa-solid fa-user fs-5"></i>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td><strong><?= esc($pengurus['nama']) ?></strong><br><small class="text-muted"><?= esc($pengurus['email'] ?: '-') ?></small></td>
                                            <td><span class="badge bg-light text-dark px-3 py-2 border"><?= esc($pengurus['nama_jabatan']) ?></span></td>
                                            <td>
                                                <?php if ($pengurus['jabatan_atasan']) : ?>
                                                    <strong><?= esc($pengurus['jabatan_atasan']) ?></strong>
                                                <?php else : ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= esc($pengurus['no_hp'] ?: '-') ?></td>
                                            <td class="text-center">
                                                <div class="d-flex gap-2 justify-content-center">
                                                    <a href="<?= base_url('dashboard/kepengurusan/pengurus/edit/' . esc($pengurus['id']) . '?periode_id=' . esc($periode['id'])) ?>" class="btn-action btn-edit" title="Edit">
                                                        <i class="fa-solid fa-pen"></i>
                                                    </a>
                                                    <a href="<?= base_url('dashboard/kepengurusan/pengurus/delete/' . esc($pengurus['id'])) ?>" class="btn-action btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus pengurus ini?')" title="Hapus">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">
                                            <i class="fa-solid fa-users fs-1 mb-3 d-block text-secondary"></i>
                                            Belum ada data pengurus terdaftar pada periode ini.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- TAB STRUKTUR JABATAN -->
            <div class="tab-pane fade" id="jabatan" role="tabpanel" aria-labelledby="jabatan-tab">
                <div class="panel-card">
                    <div class="panel-title">
                        <span>Struktur Posisi Jabatan</span>
                        <a href="<?= base_url('dashboard/kepengurusan/jabatan/create?periode_id=' . esc($periode['id'])) ?>" class="btn btn-sm btn-success" style="background-color: var(--primary); border: none; padding: 8px 16px; border-radius: 8px;">
                            <i class="fa-solid fa-plus me-2"></i>Tambah Jabatan
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table custom-table">
                            <thead>
                                <tr>
                                    <th>Nama Jabatan</th>
                                    <th>Membawahi (Parent)</th>
                                    <th style="width: 80px;">Urutan</th>
                                    <th style="width: 120px;" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($jabatan_list)) : ?>
                                    <?php foreach ($jabatan_list as $jab) : ?>
                                        <tr>
                                            <td><strong><?= esc($jab['nama_jabatan']) ?></strong></td>
                                            <td>
                                                <?php if ($jab['nama_atasan']) : ?>
                                                    <span class="badge bg-light text-dark border px-3 py-2"><?= esc($jab['nama_atasan']) ?></span>
                                                <?php else : ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= esc($jab['urutan']) ?></td>
                                            <td class="text-center">
                                                <div class="d-flex gap-2 justify-content-center">
                                                    <a href="<?= base_url('dashboard/kepengurusan/jabatan/edit/' . esc($jab['id']) . '?periode_id=' . esc($periode['id'])) ?>" class="btn-action btn-edit" title="Edit">
                                                        <i class="fa-solid fa-pen"></i>
                                                    </a>
                                                    <a href="<?= base_url('dashboard/kepengurusan/jabatan/delete/' . esc($jab['id'])) ?>" class="btn-action btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus jabatan ini? Menghapus jabatan akan menghapus penugasan pengurus terkait.')" title="Hapus">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">
                                            <i class="fa-solid fa-sitemap fs-1 mb-3 d-block text-secondary"></i>
                                            Belum ada struktur jabatan dibuat pada periode ini.
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
