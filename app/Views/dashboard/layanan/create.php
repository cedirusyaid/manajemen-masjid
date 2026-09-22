<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Layanan Baru - <?= site_name() ?></title>
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

        .panel-card {
            background-color: var(--white);
            border-radius: 16px;
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: var(--shadow-sm);
            padding: 30px;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.875rem;
            color: #374151;
            margin-bottom: 8px;
        }

        .form-control, .form-select {
            padding: 10px 16px;
            border-radius: 10px;
            border: 1.5px solid #d1d5db;
            font-size: 0.95rem;
            transition: var(--transition);
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-light);
            box-shadow: 0 0 0 4px rgba(15, 118, 110, 0.15);
        }

        .btn-submit {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: var(--white);
            border: none;
            padding: 10px 24px;
            border-radius: 10px;
            font-weight: 600;
            transition: var(--transition);
        }

        .btn-submit:hover {
            opacity: 0.9;
            box-shadow: 0 4px 12px rgba(6, 78, 59, 0.25);
            color: var(--white);
        }

        .btn-cancel {
            background-color: #f3f4f6;
            color: #4b5563;
            border: 1px solid #d1d5db;
            padding: 10px 24px;
            border-radius: 10px;
            font-weight: 600;
            transition: var(--transition);
            text-decoration: none;
        }

        .btn-cancel:hover {
            background-color: #e5e7eb;
            color: #1f2937;
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
                <a href="<?= base_url('dashboard/pelayanan') ?>" class="menu-link">
                    <i class="fa-solid fa-hand-holding-hand"></i> Pelayanan Jamaah
                </a>
            </li>
            <li>
                <a href="<?= base_url('dashboard/layanan') ?>" class="menu-link active">
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
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 fw-bold mb-1 text-dark">Tambah Layanan Jamaah</h1>
                <p class="text-muted mb-0">Definisikan jenis layanan publik baru di masjid.</p>
            </div>
            <a href="<?= base_url('dashboard/layanan') ?>" class="btn btn-outline-secondary rounded-3">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger d-flex align-items-center gap-2 mb-4 border-0 shadow-sm" role="alert">
                <i class="fa-solid fa-circle-exclamation"></i>
                <div><?= session()->getFlashdata('error') ?></div>
            </div>
        <?php endif; ?>

        <div class="panel-card">
            <form action="<?= base_url('dashboard/layanan/store') ?>" method="post">
                <?= csrf_field() ?>

                <div class="row">
                    <div class="col-md-8 mb-4">
                        <label for="nama_layanan" class="form-label">Nama Layanan Jamaah</label>
                        <input type="text" class="form-control" id="nama_layanan" name="nama_layanan" placeholder="Contoh: Konsultasi Hukum Waris / Bimbingan Zakat" value="<?= old('nama_layanan') ?>" required>
                    </div>

                    <div class="col-md-4 mb-4">
                        <label for="warna_tema" class="form-label">Warna Tema Tampilan</label>
                        <select class="form-select" id="warna_tema" name="warna_tema" required>
                            <option value="success" <?= old('warna_tema') === 'success' ? 'selected' : '' ?>>Hijau (Success)</option>
                            <option value="primary" <?= old('warna_tema') === 'primary' ? 'selected' : '' ?>>Biru (Primary)</option>
                            <option value="warning" <?= old('warna_tema') === 'warning' ? 'selected' : '' ?>>Kuning / Emas (Warning)</option>
                            <option value="danger" <?= old('warna_tema') === 'danger' ? 'selected' : '' ?>>Merah (Danger)</option>
                            <option value="info" <?= old('warna_tema') === 'info' ? 'selected' : '' ?>>Cyan / Biru Muda (Info)</option>
                            <option value="secondary" <?= old('warna_tema') === 'secondary' ? 'selected' : '' ?>>Abu-abu (Secondary)</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-4">
                        <label for="deskripsi" class="form-label">Deskripsi Ringkas Layanan</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" placeholder="Jelaskan fasilitas dan bantuan apa yang diberikan dalam layanan ini kepada jemaah..."><?= old('deskripsi') ?></textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-4">
                        <label for="icon" class="form-label">Icon FontAwesome</label>
                        <input type="text" class="form-control" id="icon" name="icon" placeholder="fa-solid fa-hand-holding-heart" value="<?= old('icon', 'fa-solid fa-hand-holding-heart') ?>">
                        <small class="text-muted" style="font-size: 0.775rem;">Contoh: `fa-solid fa-hand-holding-dollar`, `fa-solid fa-truck-medical`</small>
                    </div>

                    <div class="col-md-4 mb-4">
                        <label for="kontak_wa" class="form-label">Nomor WhatsApp Petugas</label>
                        <input type="text" class="form-control" id="kontak_wa" name="kontak_wa" placeholder="Contoh: 081234567890" value="<?= old('kontak_wa') ?>">
                    </div>

                    <div class="col-md-4 mb-4">
                        <label for="pj_personil_id" class="form-label">Penanggung Jawab (Personil)</label>
                        <select class="form-select" id="pj_personil_id" name="pj_personil_id">
                            <option value="">-- Pilih Penanggung Jawab (Opsional) --</option>
                            <?php foreach ($personil_list as $p) : ?>
                                <option value="<?= esc($p['id']) ?>" <?= old('pj_personil_id') == $p['id'] ? 'selected' : '' ?>>
                                    <?= esc($p['nama']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8 mb-4">
                        <label for="pesan_wa_default" class="form-label">Template Pesan WhatsApp Otomatis</label>
                        <input type="text" class="form-control" id="pesan_wa_default" name="pesan_wa_default" placeholder="Assalamu'alaikum Pengurus, saya ingin konsultasi..." value="<?= old('pesan_wa_default') ?>">
                    </div>

                    <div class="col-md-2 mb-4">
                        <label for="urutan" class="form-label">Urutan</label>
                        <input type="number" class="form-control" id="urutan" name="urutan" value="<?= old('urutan', 1) ?>">
                    </div>

                    <div class="col-md-2 mb-4">
                        <label for="status" class="form-label">Status Web</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="aktif" <?= old('status', 'aktif') === 'aktif' ? 'selected' : '' ?>>Aktif</option>
                            <option value="nonaktif" <?= old('status') === 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex gap-3 justify-content-end mt-4">
                    <a href="<?= base_url('dashboard/layanan') ?>" class="btn btn-cancel">Batal</a>
                    <button type="submit" class="btn btn-submit">Simpan Layanan <i class="fa-solid fa-save ms-2"></i></button>
                </div>
            </form>
        </div>
    </main>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
