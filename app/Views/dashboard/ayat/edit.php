<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Ayat Pilihan Display - <?= site_name() ?></title>
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

        .sidebar-brand i { color: var(--accent); }

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

        .btn-logout:hover { background-color: #ef4444; color: var(--white); }

        .main-content {
            margin-left: var(--sidebar-width);
            flex-grow: 1;
            padding: 30px 40px;
        }

        .card-panel {
            background: var(--white);
            border-radius: 16px;
            box-shadow: var(--shadow-sm);
            border: 1px solid rgba(0, 0, 0, 0.05);
            padding: 30px;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.85rem;
            color: #374151;
        }

        .arabic-input {
            font-family: 'Amiri', serif;
            font-size: 1.4rem;
            direction: rtl;
            text-align: right;
            line-height: 1.8;
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
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 fw-bold mb-1 text-dark">Edit Ayat Pilihan</h1>
                <p class="text-muted mb-0">Ubah teks ayat Al-Qur'an, terjemahan, atau status aktif display.</p>
            </div>
            <a href="<?= base_url('dashboard/ayat') ?>" class="btn btn-outline-secondary rounded-pill px-4 py-2">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <div class="card-panel">
            <form action="<?= base_url('dashboard/ayat/update/' . $ayat['id']) ?>" method="POST">
                <?= csrf_field() ?>

                <div class="row g-3 mb-3">
                    <div class="col-md-5">
                        <label for="surah" class="form-label">Nama Surah <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="surah" name="surah" value="<?= old('surah', $ayat['surah']) ?>" required>
                    </div>
                    <div class="col-md-3">
                        <label for="nomor_ayat" class="form-label">Nomor Ayat <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nomor_ayat" name="nomor_ayat" value="<?= old('nomor_ayat', $ayat['nomor_ayat']) ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label for="tema" class="form-label">Tema / Pokok Bahasan</label>
                        <input type="text" class="form-control" id="tema" name="tema" value="<?= old('tema', $ayat['tema']) ?>">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="teks_arab" class="form-label">Teks Arab / Ayat Suci Al-Qur'an <span class="text-danger">*</span></label>
                    <textarea class="form-control arabic-input" id="teks_arab" name="teks_arab" rows="3" required><?= old('teks_arab', $ayat['teks_arab']) ?></textarea>
                </div>

                <div class="mb-4">
                    <label for="terjemahan" class="form-label">Terjemahan Bahasa Indonesia <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="terjemahan" name="terjemahan" rows="3" required><?= old('terjemahan', $ayat['terjemahan']) ?></textarea>
                </div>

                <div class="row g-3 mb-4 align-items-center">
                    <div class="col-md-3">
                        <label for="urutan" class="form-label">Urutan Tampil (Opsional)</label>
                        <input type="number" class="form-control" id="urutan" name="urutan" value="<?= old('urutan', $ayat['urutan']) ?>">
                    </div>
                    <div class="col-md-6">
                        <div class="form-check form-switch mt-4">
                            <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" <?= old('is_active', $ayat['is_active']) == 1 ? 'checked' : '' ?>>
                            <label class="form-check-label fw-semibold text-dark" for="is_active">Aktifkan pada TV Display</label>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                    <a href="<?= base_url('dashboard/ayat') ?>" class="btn btn-light px-4 py-2">Batal</a>
                    <button type="submit" class="btn btn-primary px-4 py-2" style="background-color: var(--primary); border-color: var(--primary);">
                        <i class="fa-solid fa-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
