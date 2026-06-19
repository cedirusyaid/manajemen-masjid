<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Jadwal Kajian - Panel Admin</title>
    <!-- Google Fonts: Inter & Outfit -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- JQuery (Wajib untuk Summernote) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Summernote WYSIWYG CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <!-- Summernote WYSIWYG JS -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

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
            margin-bottom: 40px;
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

        .panel-card {
            background-color: var(--white);
            border-radius: 16px;
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: var(--shadow-sm);
            padding: 30px;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.85rem;
            color: #374151;
        }

        .form-control, .form-select {
            padding: 12px 16px;
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
            font-weight: 600;
            padding: 12px 24px;
            border-radius: 10px;
            transition: var(--transition);
        }

        .btn-submit:hover {
            opacity: 0.95;
            box-shadow: 0 4px 12px rgba(6, 78, 59, 0.25);
            color: var(--white);
        }

        .btn-cancel {
            background-color: #f3f4f6;
            color: #4b5563;
            border: 1px solid #d1d5db;
            font-weight: 600;
            padding: 12px 24px;
            border-radius: 10px;
            transition: var(--transition);
            text-decoration: none;
        }

        .btn-cancel:hover {
            background-color: #e5e7eb;
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
                <a href="<?= base_url('dashboard/agenda') ?>" class="menu-link active">
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
            <div>
                <h1 class="h3 fw-bold mb-1 text-dark">Ubah Jadwal Kajian</h1>
                <p class="text-muted mb-0">Perbarui rincian tema, ustadz, waktu, dan lokasi pengajian rutin.</p>
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
        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger d-flex align-items-center gap-2 mb-4 border-0" role="alert">
                <i class="fa-solid fa-circle-exclamation"></i>
                <div><?= session()->getFlashdata('error') ?></div>
            </div>
        <?php endif; ?>

        <!-- FORM CARD -->
        <div class="panel-card">
            <form action="<?= base_url('dashboard/agenda/update/' . $agenda['id']) ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                
                <div class="row g-4 mb-4">
                    <!-- Judul Agenda -->
                    <div class="col-md-12">
                        <label for="judul" class="form-label mb-2">Tema / Judul Kajian <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?= ($validation->hasError('judul')) ? 'is-invalid' : '' ?>" id="judul" name="judul" value="<?= old('judul', $agenda['judul']) ?>" placeholder="Tema pengajian" required>
                        <div class="invalid-feedback"><?= $validation->getError('judul') ?></div>
                    </div>

                    <!-- Narasumber / Ustadz (Hybrid) -->
                    <div class="col-md-6">
                        <label for="narasumber_id" class="form-label mb-2">Pilih Ustadz / Narasumber Internal</label>
                        <select class="form-select <?= ($validation->hasError('narasumber_id')) ? 'is-invalid' : '' ?>" id="narasumber_id" name="narasumber_id">
                            <option value="">-- Pilih Ustadz Terdaftar --</option>
                            <?php foreach ($personil_list as $personil) : ?>
                                <option value="<?= esc($personil['id']) ?>" <?= old('narasumber_id', $agenda['narasumber_id']) == $personil['id'] ? 'selected' : '' ?>>
                                    <?= esc($personil['nama']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small class="text-muted mt-1 d-block">Pilih jika penceramah sudah terdaftar di Master Personel.</small>
                    </div>

                    <div class="col-md-6">
                        <label for="narasumber" class="form-label mb-2">Narasumber Eksternal (Fallback Teks)</label>
                        <input type="text" class="form-control <?= ($validation->hasError('narasumber')) ? 'is-invalid' : '' ?>" id="narasumber" name="narasumber" value="<?= old('narasumber', $agenda['narasumber']) ?>" placeholder="Nama ustadz tamu">
                        <small class="text-muted mt-1 d-block">Isi nama penceramah di sini jika merupakan ustadz tamu.</small>
                    </div>

                    <!-- Tanggal & Waktu -->
                    <div class="col-md-4">
                        <label for="tanggal" class="form-label mb-2">Tanggal Pelaksanaan <span class="text-danger">*</span></label>
                        <input type="date" class="form-control <?= ($validation->hasError('tanggal')) ? 'is-invalid' : '' ?>" id="tanggal" name="tanggal" value="<?= old('tanggal', $agenda['tanggal']) ?>" required>
                        <div class="invalid-feedback"><?= $validation->getError('tanggal') ?></div>
                    </div>

                    <div class="col-md-4">
                        <label for="waktu" class="form-label mb-2">Waktu Mulai <span class="text-danger">*</span></label>
                        <input type="time" class="form-control <?= ($validation->hasError('waktu')) ? 'is-invalid' : '' ?>" id="waktu" name="waktu" value="<?= old('waktu', $agenda['waktu']) ?>" required>
                        <div class="invalid-feedback"><?= $validation->getError('waktu') ?></div>
                    </div>

                    <div class="col-md-4">
                        <label for="lokasi" class="form-label mb-2">Lokasi Pengajian</label>
                        <input type="text" class="form-control <?= ($validation->hasError('lokasi')) ? 'is-invalid' : '' ?>" id="lokasi" name="lokasi" value="<?= old('lokasi', $agenda['lokasi']) ?>" placeholder="Lokasi kegiatan">
                        <div class="invalid-feedback"><?= $validation->getError('lokasi') ?></div>
                    </div>

                    <!-- Deskripsi Detail / Materi Kajian -->
                    <div class="col-md-12">
                        <label for="deskripsi" class="form-label mb-2">Deskripsi / Detail Acara <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5" required><?= old('deskripsi', $agenda['deskripsi']) ?></textarea>
                        <div class="invalid-feedback"><?= $validation->getError('deskripsi') ?></div>
                    </div>

                    <!-- Banner / Brosur Kajian -->
                    <div class="col-md-12">
                        <label for="banner" class="form-label mb-2">Brosur / Banner Kegiatan (Biarkan kosong jika tidak ingin mengubah)</label>
                        <div class="d-flex align-items-start gap-4 mb-3">
                            <?php if ($agenda['banner']) : ?>
                                <img src="<?= base_url('uploads/images/' . $agenda['banner']) ?>" class="rounded" style="width: 120px; height: 80px; object-fit: cover;" alt="Banner Saat Ini">
                            <?php else : ?>
                                <div class="bg-light text-muted border border-light-subtle rounded d-flex align-items-center justify-content-center" style="width: 120px; height: 80px;">
                                    <span class="fs-6">No Image</span>
                                </div>
                            <?php endif; ?>
                            
                            <div class="flex-grow-1">
                                <input type="file" class="form-control <?= ($validation->hasError('banner')) ? 'is-invalid' : '' ?>" id="banner" name="banner" accept="image/*">
                                <small class="text-muted mt-1 d-block">Format berkas: JPG, JPEG, PNG, WEBP. Maksimal ukuran: 2MB.</small>
                                <div class="invalid-feedback"><?= $validation->getError('banner') ?></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Aksi Form -->
                <div class="d-flex justify-content-end gap-3 border-top pt-4">
                    <a href="<?= base_url('dashboard/agenda') ?>" class="btn btn-cancel">
                        <i class="fa-solid fa-arrow-left me-2"></i> Batal / Kembali
                    </a>
                    <button type="submit" class="btn btn-submit">
                        <i class="fa-solid fa-floppy-disk me-2"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </main>

    <script>
        $(document).ready(function() {
            $('#deskripsi').summernote({
                placeholder: 'Tuliskan deskripsi lengkap kajian...',
                tabsize: 2,
                height: 200,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });
    </script>
</body>
</html>
