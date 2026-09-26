<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Rekening Infaq - <?= site_name() ?></title>
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

        .current-logo {
            width: 120px;
            height: 120px;
            object-fit: contain;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 8px;
            background-color: #f9fafb;
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
                <h1>Ubah Rekening Infaq</h1>
                <p class="text-muted mb-0">Memperbarui data nomor rekening bank atau QRIS infaq masjid.</p>
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

        <!-- FORM CARD -->
        <div class="panel-card">
            <h5 class="fw-bold mb-4 text-success"><i class="fa-solid fa-pen-to-square me-2"></i>Ubah Metode Infaq</h5>
            
            <form action="<?= base_url('dashboard/rekening/update/' . $rekening['id']) ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                
                <div class="row g-4">
                    <!-- Nama Bank/Metode -->
                    <div class="col-md-6">
                        <label for="nama_bank" class="form-label">Nama Bank / Metode Pembayaran</label>
                        <input type="text" class="form-control <?= session('errors.nama_bank') ? 'is-invalid' : '' ?>" id="nama_bank" name="nama_bank" placeholder="Contoh: BSI, Bank Mandiri, QRIS" value="<?= old('nama_bank', $rekening['nama_bank']) ?>" required>
                        <?php if (session('errors.nama_bank')) : ?>
                            <div class="invalid-feedback"><?= session('errors.nama_bank') ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Jenis Metode -->
                    <div class="col-md-6">
                        <label for="jenis" class="form-label">Jenis Metode Pembayaran</label>
                        <select class="form-select <?= session('errors.jenis') ? 'is-invalid' : '' ?>" id="jenis" name="jenis" required>
                            <option value="transfer" <?= old('jenis', $rekening['jenis']) === 'transfer' ? 'selected' : '' ?>>Transfer Bank</option>
                            <option value="qris" <?= old('jenis', $rekening['jenis']) === 'qris' ? 'selected' : '' ?>>QRIS (Barcode Infaq)</option>
                        </select>
                        <?php if (session('errors.jenis')) : ?>
                            <div class="invalid-feedback"><?= session('errors.jenis') ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Nomor Rekening / Payload QRIS -->
                    <div class="col-md-6" id="no_rek_container">
                        <label for="nomor_rekening" class="form-label" id="label_no_rek">Nomor Rekening</label>
                        <input type="text" class="form-control <?= session('errors.nomor_rekening') ? 'is-invalid' : '' ?>" id="nomor_rekening" name="nomor_rekening" placeholder="Masukkan nomor rekening bank" value="<?= old('nomor_rekening', $rekening['nomor_rekening']) ?>">
                        <small class="text-muted d-block mt-1" id="help_no_rek">Nomor rekening tanpa spasi atau tanda hubung.</small>
                        <?php if (session('errors.nomor_rekening')) : ?>
                            <div class="invalid-feedback"><?= session('errors.nomor_rekening') ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Atas Nama Pemilik -->
                    <div class="col-md-6" id="atas_nama_container">
                        <label for="atas_nama" class="form-label">Atas Nama Pemilik</label>
                        <input type="text" class="form-control <?= session('errors.atas_nama') ? 'is-invalid' : '' ?>" id="atas_nama" name="atas_nama" placeholder="Contoh: Kas Masjid Agung" value="<?= old('atas_nama', $rekening['atas_nama']) ?>">
                        <?php if (session('errors.atas_nama')) : ?>
                            <div class="invalid-feedback"><?= session('errors.atas_nama') ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Logo Bank / Barcode QRIS Saat Ini & Preview Ganti -->
                    <div class="col-md-6">
                        <label class="form-label d-block" id="label_current_logo">Gambar / QRIS Saat Ini</label>
                        <div class="d-flex align-items-center gap-3 p-3 bg-light rounded-3 border">
                            <div id="current_logo_wrapper">
                                <?php if (!empty($rekening['logo']) && is_file(FCPATH . 'uploads/rekening/' . $rekening['logo'])) : ?>
                                    <img src="<?= base_url('uploads/rekening/' . $rekening['logo']) ?>" class="current-logo" id="current_logo_img" alt="Logo/QRIS">
                                <?php else : ?>
                                    <div class="current-logo d-flex align-items-center justify-content-center bg-white text-muted" id="current_logo_img">
                                        <i class="fa-solid <?= $rekening['jenis'] === 'qris' ? 'fa-qrcode' : 'fa-building-columns' ?> fs-1"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div>
                                <span class="badge bg-success-subtle text-success border border-success-subtle mb-1" id="badge_preview_status">File Tersimpan</span>
                                <p class="text-muted small mb-0" id="desc_current_logo">Gambar barcode QRIS atau logo yang sedang aktif digunakan.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Upload Logo Bank / Barcode QRIS Baru -->
                    <div class="col-md-6">
                        <label for="logo" class="form-label" id="label_logo"><i class="fa-solid fa-arrow-up-from-bracket me-1"></i>Ganti QR Code / Logo Baru</label>
                        <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
                        <small class="text-muted d-block mt-1" id="help_logo">Format gambar JPEG, PNG, atau WebP (Maks 2MB). Pilih file untuk mengganti QR Code / Logo saat ini.</small>
                    </div>

                    <!-- Status -->
                    <div class="col-md-6">
                        <label for="status" class="form-label">Status Aktif</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="active" <?= old('status', $rekening['status']) === 'active' ? 'selected' : '' ?>>Aktif (Tampil di Depan & TV)</option>
                            <option value="inactive" <?= old('status', $rekening['status']) === 'inactive' ? 'selected' : '' ?>>Nonaktif (Disembunyikan)</option>
                        </select>
                    </div>
                </div>

                <!-- BUTTONS -->
                <div class="d-flex gap-3 justify-content-end mt-5">
                    <a href="<?= base_url('dashboard/rekening') ?>" class="btn btn-cancel">
                        <i class="fa-solid fa-xmark me-2"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-save">
                        <i class="fa-solid fa-floppy-disk me-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </main>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Dynamic Form Fields & Image Preview Helper JS -->
    <script>
        const jenisSelect = document.getElementById('jenis');
        const labelNoRek = document.getElementById('label_no_rek');
        const helpNoRek = document.getElementById('help_no_rek');
        const nomorRekeningInput = document.getElementById('nomor_rekening');
        const labelLogo = document.getElementById('label_logo');
        const helpLogo = document.getElementById('help_logo');
        const labelCurrentLogo = document.getElementById('label_current_logo');
        const logoInput = document.getElementById('logo');
        const currentLogoWrapper = document.getElementById('current_logo_wrapper');
        const badgePreviewStatus = document.getElementById('badge_preview_status');
        const descCurrentLogo = document.getElementById('desc_current_logo');

        function adjustFormFields() {
            if (jenisSelect.value === 'qris') {
                labelNoRek.innerText = 'Payload / Teks String QRIS (Opsional jika upload barcode)';
                nomorRekeningInput.placeholder = 'Contoh: MasjidAgungSinjaiInfaqDigital';
                helpNoRek.innerText = 'Teks payload QRIS resmi untuk auto-generate QR Code jika gambar tidak diupload.';
                labelCurrentLogo.innerHTML = '<i class="fa-solid fa-qrcode me-1 text-success"></i>Barcode QRIS Saat Ini';
                labelLogo.innerHTML = '<i class="fa-solid fa-cloud-arrow-up me-1 text-success"></i>Ganti Barcode QRIS Baru (Upload Gambar)';
                helpLogo.innerText = 'Pilih file gambar QR Code baru dari galeri/komputer (JPG, PNG, WebP). Akan otomatis dioptimasi.';
            } else {
                labelNoRek.innerText = 'Nomor Rekening';
                nomorRekeningInput.placeholder = 'Masukkan nomor rekening bank';
                helpNoRek.innerText = 'Nomor rekening tanpa spasi atau tanda hubung.';
                labelCurrentLogo.innerHTML = '<i class="fa-solid fa-building-columns me-1 text-success"></i>Logo Bank Saat Ini';
                labelLogo.innerHTML = '<i class="fa-solid fa-cloud-arrow-up me-1 text-success"></i>Ganti Logo Bank Baru (Opsional)';
                helpLogo.innerText = 'Pilih file logo bank baru jika ingin mengganti logo lama.';
            }
        }

        // Live preview when file selected
        if (logoInput) {
            logoInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        currentLogoWrapper.innerHTML = '<img src="' + event.target.result + '" class="current-logo border-primary" style="box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.25);" alt="Preview">';
                        badgePreviewStatus.className = 'badge bg-primary text-white mb-1';
                        badgePreviewStatus.innerText = 'Pratinjau Gambar Baru';
                        descCurrentLogo.innerText = 'File baru dipilih: ' + file.name + ' (' + (file.size / 1024).toFixed(1) + ' KB). Klik Simpan untuk menerapkan.';
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        jenisSelect.addEventListener('change', adjustFormFields);
        document.addEventListener('DOMContentLoaded', adjustFormFields);
    </script>
</body>
</html>
