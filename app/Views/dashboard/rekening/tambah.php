<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Rekening Infaq - <?= site_name() ?></title>
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
            margin-bottom: 32px;
        }

        .topbar-title h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: #111827;
            margin: 0;
        }

        .topbar-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            background-color: var(--white);
            padding: 8px 16px;
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

        .panel-card {
            background-color: var(--white);
            border-radius: 16px;
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: var(--shadow-sm);
            padding: 30px;
        }

        .form-label {
            font-weight: 600;
            color: #374151;
            font-size: 0.9rem;
            margin-bottom: 8px;
        }

        .form-control, .form-select {
            border-radius: 10px;
            padding: 10px 16px;
            border: 1px solid #d1d5db;
            font-size: 0.95rem;
            transition: var(--transition);
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-light);
            box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.15);
        }

        .btn-save {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: var(--white);
            border: none;
            font-weight: 600;
            padding: 12px 28px;
            border-radius: 10px;
            transition: var(--transition);
        }

        .btn-save:hover {
            opacity: 0.95;
            box-shadow: 0 4px 12px rgba(6, 78, 59, 0.25);
            color: var(--white);
        }

        .btn-cancel {
            background-color: #f3f4f6;
            color: #4b5563;
            border: 1px solid #e5e7eb;
            font-weight: 600;
            padding: 12px 28px;
            border-radius: 10px;
            transition: var(--transition);
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
                <a href="<?= base_url('dashboard/rekening') ?>" class="menu-link active">
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
                <h1>Tambah Rekening Infaq</h1>
                <p class="text-muted mb-0">Mendaftarkan nomor rekening bank baru atau QRIS infaq masjid.</p>
            </div>
            <div class="topbar-profile">
                <img src="<?= $avatar ?? base_url('assets/images/default-avatar.png') ?>" alt="Avatar" class="profile-avatar">
                <div>
                    <div class="profile-name"><?= esc($username) ?></div>
                    <div class="profile-role"><?= esc($role_name) ?></div>
                </div>
            </div>
        </div>

        <!-- FORM CARD -->
        <div class="panel-card">
            <h5 class="fw-bold mb-4 text-success"><i class="fa-solid fa-plus-circle me-2"></i>Form Metode Infaq</h5>
            
            <form action="<?= base_url('dashboard/rekening/store') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                
                <div class="row g-4">
                    <!-- Nama Bank/Metode -->
                    <div class="col-md-6">
                        <label for="nama_bank" class="form-label">Nama Bank / Metode Pembayaran</label>
                        <input type="text" class="form-control <?= session('errors.nama_bank') ? 'is-invalid' : '' ?>" id="nama_bank" name="nama_bank" placeholder="Contoh: BSI, Bank Mandiri, QRIS" value="<?= old('nama_bank') ?>" required>
                        <?php if (session('errors.nama_bank')) : ?>
                            <div class="invalid-feedback"><?= session('errors.nama_bank') ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Jenis Metode -->
                    <div class="col-md-6">
                        <label for="jenis" class="form-label">Jenis Metode Pembayaran</label>
                        <select class="form-select <?= session('errors.jenis') ? 'is-invalid' : '' ?>" id="jenis" name="jenis" required>
                            <option value="transfer" <?= old('jenis') === 'transfer' ? 'selected' : '' ?>>Transfer Bank</option>
                            <option value="qris" <?= old('jenis') === 'qris' ? 'selected' : '' ?>>QRIS (Barcode Infaq)</option>
                        </select>
                        <?php if (session('errors.jenis')) : ?>
                            <div class="invalid-feedback"><?= session('errors.jenis') ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Nomor Rekening / Payload QRIS -->
                    <div class="col-md-6" id="no_rek_container">
                        <label for="nomor_rekening" class="form-label" id="label_no_rek">Nomor Rekening</label>
                        <input type="text" class="form-control <?= session('errors.nomor_rekening') ? 'is-invalid' : '' ?>" id="nomor_rekening" name="nomor_rekening" placeholder="Masukkan nomor rekening bank" value="<?= old('nomor_rekening') ?>">
                        <small class="text-muted d-block mt-1" id="help_no_rek">Nomor rekening tanpa spasi atau tanda hubung.</small>
                        <?php if (session('errors.nomor_rekening')) : ?>
                            <div class="invalid-feedback"><?= session('errors.nomor_rekening') ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Atas Nama Pemilik -->
                    <div class="col-md-6" id="atas_nama_container">
                        <label for="atas_nama" class="form-label">Atas Nama Pemilik</label>
                        <input type="text" class="form-control <?= session('errors.atas_nama') ? 'is-invalid' : '' ?>" id="atas_nama" name="atas_nama" placeholder="Contoh: Kas Masjid Agung" value="<?= old('atas_nama') ?>">
                        <?php if (session('errors.atas_nama')) : ?>
                            <div class="invalid-feedback"><?= session('errors.atas_nama') ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Upload Logo Bank / Barcode QRIS -->
                    <div class="col-md-6">
                        <label for="logo" class="form-label" id="label_logo">Logo Bank (Opsional)</label>
                        <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
                        <small class="text-muted d-block mt-1" id="help_logo">Format gambar JPEG, PNG, atau WebP (Maks 2MB). Sistem otomatis mengonversi ke format WebP.</small>
                    </div>

                    <!-- Status -->
                    <div class="col-md-6">
                        <label for="status" class="form-label">Status Aktif</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="active" <?= old('status') === 'active' ? 'selected' : '' ?>>Aktif (Tampil di Depan)</option>
                            <option value="inactive" <?= old('status') === 'inactive' ? 'selected' : '' ?>>Nonaktif (Disembunyikan)</option>
                        </select>
                    </div>
                </div>

                <!-- BUTTONS -->
                <div class="d-flex gap-3 justify-content-end mt-5">
                    <a href="<?= base_url('dashboard/rekening') ?>" class="btn btn-cancel">
                        <i class="fa-solid fa-xmark me-2"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-save">
                        <i class="fa-solid fa-floppy-disk me-2"></i>Simpan Rekening
                    </button>
                </div>
            </form>
        </div>
    </main>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Dynamic Form Fields Helper JS -->
    <script>
        const jenisSelect = document.getElementById('jenis');
        const labelNoRek = document.getElementById('label_no_rek');
        const helpNoRek = document.getElementById('help_no_rek');
        const nomorRekeningInput = document.getElementById('nomor_rekening');
        const labelLogo = document.getElementById('label_logo');
        const helpLogo = document.getElementById('help_logo');

        function adjustFormFields() {
            if (jenisSelect.value === 'qris') {
                labelNoRek.innerText = 'Payload / Teks String QRIS (Opsional jika upload gambar)';
                nomorRekeningInput.placeholder = 'Contoh: MasjidAgungSinjaiInfaqDigital';
                helpNoRek.innerText = 'Teks payload QRIS resmi (misal format string QRIS) untuk auto-generate QR Code dinamis.';
                labelLogo.innerText = 'Upload Barcode/Gambar QRIS (Sangat Disarankan)';
                helpLogo.innerText = 'Unggah gambar QRIS masjid Anda. Sistem otomatis mengonversi ke format WebP.';
            } else {
                labelNoRek.innerText = 'Nomor Rekening';
                nomorRekeningInput.placeholder = 'Masukkan nomor rekening bank';
                helpNoRek.innerText = 'Nomor rekening tanpa spasi atau tanda hubung.';
                labelLogo.innerText = 'Logo Bank (Opsional)';
                helpLogo.innerText = 'Format gambar JPEG, PNG, atau WebP (Maks 2MB). Sistem otomatis mengonversi ke format WebP.';
            }
        }

        jenisSelect.addEventListener('change', adjustFormFields);
        document.addEventListener('DOMContentLoaded', adjustFormFields);
    </script>
</body>
</html>
