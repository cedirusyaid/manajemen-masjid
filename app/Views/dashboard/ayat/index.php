<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Ayat-Ayat Pilihan Display - <?= site_name() ?></title>
    <!-- Google Fonts: Inter & Outfit -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Outfit:wght@400;500;600;700&family=Amiri:wght@400;700&display=swap" rel="stylesheet">
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
            overflow-y: auto;
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

        .menu-link i {
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }

        .menu-link.active {
            background: linear-gradient(90deg, var(--primary-light) 0%, rgba(15, 118, 110, 0.4) 100%);
            color: var(--white);
            font-weight: 600;
        }

        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .btn-logout {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #ef4444;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            padding: 10px 14px;
            border-radius: 8px;
            background-color: rgba(239, 68, 68, 0.1);
            transition: var(--transition);
        }

        .btn-logout:hover {
            background-color: #ef4444;
            color: var(--white);
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            flex-grow: 1;
            padding: 30px 40px;
        }

        /* Topbar */
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .user-dropdown {
            background: var(--white);
            padding: 8px 16px;
            border-radius: 30px;
            box-shadow: var(--shadow-sm);
            cursor: pointer;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--primary);
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        /* Card & Table */
        .card-panel {
            background: var(--white);
            border-radius: 16px;
            box-shadow: var(--shadow-sm);
            border: 1px solid rgba(0, 0, 0, 0.05);
            padding: 25px;
        }

        .arabic-text {
            font-family: 'Amiri', serif;
            font-size: 1.4rem;
            direction: rtl;
            text-align: right;
            line-height: 1.8;
            color: #064e3b;
        }

        .btn-action {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none;
            transition: var(--transition);
            text-decoration: none;
        }

        .btn-edit { background: rgba(59, 130, 246, 0.1); color: #3b82f6; }
        .btn-edit:hover { background: #3b82f6; color: #fff; }
        .btn-toggle { background: rgba(245, 158, 11, 0.1); color: #f59e0b; }
        .btn-toggle:hover { background: #f59e0b; color: #fff; }
        .btn-delete { background: rgba(239, 68, 68, 0.1); color: #ef4444; }
        .btn-delete:hover { background: #ef4444; color: #fff; }
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
                <a href="<?= base_url('dashboard/users') ?>" class="menu-link">
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
                <a href="<?= base_url('dashboard/ayat') ?>" class="menu-link active">
                    <i class="fa-solid fa-quran"></i> Ayat Pilihan Display
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

    <!-- MAIN CONTENT -->
    <main class="main-content">
        <!-- TOPBAR -->
        <div class="topbar">
            <div>
                <h1 class="h3 fw-bold mb-1 text-dark">Ayat-Ayat Pilihan TV Display</h1>
                <p class="text-muted mb-0">Kelola kumpulan ayat suci Al-Qur'an dan mutiara tadabbur yang tampil bergilir di layar display.</p>
            </div>
            
            <div class="d-flex align-items-center gap-3">
                <a href="<?= base_url('display/slideshow.html') ?>" target="_blank" class="btn btn-outline-primary btn-sm d-flex align-items-center gap-2 rounded-pill px-3 py-2 fw-semibold shadow-sm bg-white text-decoration-none">
                    <i class="fa-solid fa-tv text-primary"></i>
                    <span>Buka TV Display</span>
                    <i class="fa-solid fa-arrow-up-right-from-square text-muted" style="font-size: 0.7rem;"></i>
                </a>

                <div class="dropdown">
                    <div class="user-dropdown d-flex align-items-center gap-2" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-avatar"><?= strtoupper(substr($username ?? 'U', 0, 1)) ?></div>
                        <div>
                            <div class="fw-bold text-dark" style="font-size: 0.875rem;"><?= esc($username ?? 'Pengguna') ?></div>
                            <small class="text-muted" style="font-size: 0.75rem;"><?= esc($role_name ?? 'Admin') ?></small>
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

        <!-- CARD PANEL -->
        <div class="card-panel">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="text-muted small">
                    Total Ayat Tersimpan: <strong class="text-dark"><?= count($ayat_list) ?> Ayat</strong>
                </div>
                <a href="<?= base_url('dashboard/ayat/create') ?>" class="btn btn-primary d-inline-flex align-items-center gap-2 rounded-pill px-4 py-2" style="background-color: var(--primary); border-color: var(--primary);">
                    <i class="fa-solid fa-plus"></i> Tambah Ayat Pilihan
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 60px;">No</th>
                            <th style="width: 180px;">Surah & Ayat</th>
                            <th style="width: 140px;">Tema</th>
                            <th>Teks Arab & Terjemahan</th>
                            <th style="width: 110px;" class="text-center">Status</th>
                            <th style="width: 130px;" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($ayat_list)) : ?>
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-quran fa-2x mb-3 text-muted opacity-50"></i>
                                    <div>Belum ada ayat pilihan yang ditambahkan.</div>
                                </td>
                            </tr>
                        <?php else : ?>
                            <?php $no = 1; foreach ($ayat_list as $a) : ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td>
                                        <div class="fw-bold text-dark">QS. <?= esc($a['surah']) ?></div>
                                        <small class="text-muted">Ayat <?= esc($a['nomor_ayat']) ?></small>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border px-2 py-1 rounded-pill">
                                            <?= esc($a['tema'] ?: 'Umum') ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="arabic-text mb-2"><?= esc($a['teks_arab']) ?></div>
                                        <div class="text-muted small fst-italic">"<?= esc($a['terjemahan']) ?>"</div>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($a['is_active'] == 1) : ?>
                                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1 rounded-pill">Aktif di TV</span>
                                        <?php else : ?>
                                            <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 px-2 py-1 rounded-pill">Nonaktif</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <a href="<?= base_url('dashboard/ayat/edit/' . $a['id']) ?>" class="btn-action btn-edit" title="Edit Ayat">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>
                                            <a href="<?= base_url('dashboard/ayat/toggle-status/' . $a['id']) ?>" class="btn-action btn-toggle" title="<?= $a['is_active'] == 1 ? 'Sembunyikan dari Display' : 'Tampilkan di Display' ?>">
                                                <i class="fa-solid <?= $a['is_active'] == 1 ? 'fa-eye-slash' : 'fa-eye' ?>"></i>
                                            </a>
                                            <a href="<?= base_url('dashboard/ayat/delete/' . $a['id']) ?>" class="btn-action btn-delete" title="Hapus Ayat" onclick="return confirm('Apakah Anda yakin ingin menghapus ayat ini?');">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
