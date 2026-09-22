<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buku Catatan Pelayanan Jamaah - <?= site_name() ?></title>
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
            max-width: calc(100vw - var(--sidebar-width));
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 35px;
        }

        .topbar-title h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--dark-navy);
            margin-bottom: 4px;
        }

        .topbar-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            background: var(--white);
            padding: 8px 16px;
            border-radius: 30px;
            box-shadow: var(--shadow-sm);
        }

        .profile-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
        }

        .profile-name {
            font-weight: 600;
            font-size: 0.875rem;
        }

        .profile-role {
            font-size: 0.75rem;
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

        .table-responsive {
            border-radius: 12px;
            overflow: hidden;
        }

        .table {
            margin-bottom: 0;
        }

        .table th {
            background-color: #f9fafb;
            color: #374151;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 16px;
            border-bottom: 1.5px solid #e5e7eb;
        }

        .table td {
            padding: 16px;
            vertical-align: middle;
            font-size: 0.9rem;
            border-bottom: 1px solid #f3f4f6;
        }

        .btn-add {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: var(--white);
            border: none;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 10px;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
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
                <a href="<?= base_url('dashboard/pelayanan') ?>" class="menu-link active">
                    <i class="fa-solid fa-hand-holding-hand"></i> Pelayanan Jamaah
                </a>
            </li>
            <li>
                <a href="<?= base_url('dashboard/layanan') ?>" class="menu-link">
                    <i class="fa-solid fa-layer-group"></i> Master Layanan
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
            <div class="topbar-title">
                <h1>Buku Pelayanan Jamaah</h1>
                <p class="text-muted mb-0">Catatan transaksi penerimaan layanan, konsultasi ZISWAF, nikah, dan bantuan sosial.</p>
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

        <!-- MAIN PANEL -->
        <div class="panel-card">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4 pb-3 border-bottom">
                <div class="d-flex align-items-center gap-2">
                    <form action="" method="get" class="d-flex align-items-center gap-2">
                        <select name="layanan_id" class="form-select form-select-sm" onchange="this.form.submit()" style="min-width: 220px;">
                            <option value="">-- Semua Jenis Layanan --</option>
                            <?php foreach ($layanan_list as $lay) : ?>
                                <option value="<?= esc($lay['id']) ?>" <?= ($selected_layanan === $lay['id']) ? 'selected' : '' ?>>
                                    <?= esc($lay['nama_layanan']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (!empty($selected_layanan)) : ?>
                            <a href="<?= base_url('dashboard/pelayanan') ?>" class="btn btn-sm btn-outline-secondary">Reset</a>
                        <?php endif; ?>
                    </form>
                </div>
                <div class="d-flex gap-2">
                    <a href="<?= base_url('dashboard/layanan') ?>" class="btn btn-outline-secondary px-3 py-2 rounded-3 fw-semibold">
                        <i class="fa-solid fa-gear me-1"></i> Kelola Master Layanan
                    </a>
                    <a href="<?= base_url('dashboard/pelayanan/create' . (!empty($selected_layanan) ? '?layanan_id=' . esc($selected_layanan) : '')) ?>" class="btn-add">
                        <i class="fa-solid fa-plus"></i> Catat Pelayanan Baru
                    </a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 110px;">Tanggal</th>
                            <th>Pemohon / Jamaah</th>
                            <th>Layanan & Rincian Kebutuhan</th>
                            <th>Petugas / Dicatat Oleh</th>
                            <th class="text-center">Status</th>
                            <th class="text-center" style="width: 90px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($pelayanan_list)) : ?>
                            <?php foreach ($pelayanan_list as $pel) : ?>
                                <tr>
                                    <td class="text-nowrap fw-semibold text-dark">
                                        <?= date('d/m/Y', strtotime($pel['tanggal'])) ?>
                                    </td>
                                    <td>
                                        <strong class="text-dark d-block fs-6"><?= esc($pel['nama_pemohon']) ?></strong>
                                        <?php if (!empty($pel['no_hp_pemohon'])) : ?>
                                            <a href="https://api.whatsapp.com/send?phone=<?= preg_replace('/[^0-9]/', '', $pel['no_hp_pemohon']) ?>" target="_blank" class="text-success small text-decoration-none d-inline-flex align-items-center gap-1">
                                                <i class="fa-brands fa-whatsapp"></i> <?= esc($pel['no_hp_pemohon']) ?>
                                            </a>
                                        <?php endif; ?>
                                        <?php if (!empty($pel['alamat_pemohon'])) : ?>
                                            <small class="text-muted d-block text-truncate" style="max-width: 250px;">
                                                <i class="fa-solid fa-location-dot me-1 text-secondary"></i><?= esc($pel['alamat_pemohon']) ?>
                                            </small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?= esc($pel['warna_tema']) ?> bg-opacity-10 text-<?= esc($pel['warna_tema']) ?> border border-<?= esc($pel['warna_tema']) ?> border-opacity-25 px-2.5 py-1 rounded-pill mb-1">
                                            <i class="<?= esc($pel['layanan_icon']) ?> me-1"></i><?= esc($pel['nama_layanan']) ?>
                                        </span>
                                        <div class="text-dark small fw-medium mt-1"><?= nl2br(esc($pel['rincian_kebutuhan'])) ?></div>
                                        <?php if (!empty($pel['tindakan_petugas'])) : ?>
                                            <small class="text-muted d-block mt-1"><span class="fw-semibold text-secondary">Tindakan:</span> <?= esc($pel['tindakan_petugas']) ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (!empty($pel['nama_petugas'])) : ?>
                                            <strong class="text-dark d-block small"><i class="fa-solid fa-user-tie text-secondary me-1"></i><?= esc($pel['nama_petugas']) ?></strong>
                                        <?php endif; ?>
                                        <small class="text-muted" style="font-size: 0.775rem;">
                                            <i class="fa-solid fa-user-pen me-1"></i>User: @<?= esc($pel['input_by_user']) ?>
                                        </small>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($pel['status_layanan'] === 'selesai') : ?>
                                            <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1 rounded-pill">Selesai</span>
                                        <?php elseif ($pel['status_layanan'] === 'diproses') : ?>
                                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2.5 py-1 rounded-pill">Diproses</span>
                                        <?php elseif ($pel['status_layanan'] === 'diajukan') : ?>
                                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2.5 py-1 rounded-pill">Diajukan</span>
                                        <?php else : ?>
                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2.5 py-1 rounded-pill">Ditolak</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex align-items-center justify-content-center gap-1.5">
                                            <a href="<?= base_url('dashboard/pelayanan/edit/' . $pel['id']) ?>" class="btn-action btn-edit" title="Ubah Catatan">
                                                <i class="fa-solid fa-pencil"></i>
                                            </a>
                                            <a href="<?= base_url('dashboard/pelayanan/delete/' . $pel['id']) ?>" class="btn-action btn-delete" onclick="return confirm('Hapus catatan pelayanan ini?')" title="Hapus">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-clipboard-question fs-1 mb-2 d-block text-secondary"></i>
                                    Belum ada transaksi pelayanan yang dicatat.
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
