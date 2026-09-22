<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Jabatan Kepanitiaan - <?= site_name() ?></title>
    <!-- Google Fonts: Inter & Outfit -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Select2 CSS & Bootstrap 5 Theme -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">
    
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
            margin-bottom: 40px;
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

        /* Form Styles */
        .panel-card {
            background-color: var(--white);
            border-radius: 16px;
            padding: 30px;
            box-shadow: var(--shadow-sm);
            border: 1px solid rgba(0, 0, 0, 0.05);
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
                <h1 class="h3 fw-bold mb-1 text-dark">Tambah Jabatan Kegiatan</h1>
                <p class="text-muted mb-0">Definisikan posisi jabatan struktur kepanitiaan baru.</p>
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
        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger d-flex align-items-center gap-2 mb-4 border-0 shadow-sm" role="alert">
                <i class="fa-solid fa-circle-exclamation"></i>
                <div><?= session()->getFlashdata('error') ?></div>
            </div>
        <?php endif; ?>

        <!-- FORM PANEL -->
        <div class="panel-card">
            <form action="<?= base_url('dashboard/kepanitiaan/jabatan/store') ?>" method="post">
                <?= csrf_field() ?>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label for="kegiatan_id" class="form-label">Kegiatan Masjid</label>
                        <select class="form-select" id="kegiatan_id" name="kegiatan_id" required>
                            <option value="">-- Pilih Kegiatan --</option>
                            <?php foreach ($kegiatan_list as $kegiatan) : ?>
                                <option value="<?= esc($kegiatan['id']) ?>" <?= old('kegiatan_id', $selected_kegiatan) == $kegiatan['id'] ? 'selected' : '' ?>>
                                    <?= esc($kegiatan['nama_kegiatan']) ?> (<?= date('d/m/Y', strtotime($kegiatan['tanggal_mulai'])) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label for="nama_jabatan" class="form-label">Nama Jabatan</label>
                        <input type="text" class="form-control" id="nama_jabatan" name="nama_jabatan" placeholder="Contoh: Ketua Panitia / Sekertaris / Anggota Humas" value="<?= old('nama_jabatan') ?>" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label for="kategori_unit" class="form-label">Unit / Kelompok Struktur</label>
                        <select class="form-select" id="kategori_unit" name="kategori_unit">
                            <option value="Pembina / Penasehat" <?= old('kategori_unit') === 'Pembina / Penasehat' ? 'selected' : '' ?>>Pembina / Penasehat</option>
                            <option value="Pengarah" <?= old('kategori_unit') === 'Pengarah' ? 'selected' : '' ?>>Pengarah</option>
                            <option value="Pelaksana Utama" <?= old('kategori_unit', 'Pelaksana Utama') === 'Pelaksana Utama' ? 'selected' : '' ?>>Pelaksana Utama</option>
                            <option value="Bidang Pembangunan dan Konstruksi" <?= old('kategori_unit') === 'Bidang Pembangunan dan Konstruksi' ? 'selected' : '' ?>>Bidang Pembangunan dan Konstruksi</option>
                            <option value="Bidang Penggalangan Dana" <?= old('kategori_unit') === 'Bidang Penggalangan Dana' ? 'selected' : '' ?>>Bidang Penggalangan Dana</option>
                            <option value="Bidang Logistik dan Material" <?= old('kategori_unit') === 'Bidang Logistik dan Material' ? 'selected' : '' ?>>Bidang Logistik dan Material</option>
                            <option value="Bidang Keamanan dan Ketertiban" <?= old('kategori_unit') === 'Bidang Keamanan dan Ketertiban' ? 'selected' : '' ?>>Bidang Keamanan dan Ketertiban</option>
                            <option value="Bidang Publikasi, Dokumentasi dan Humas" <?= old('kategori_unit') === 'Bidang Publikasi, Dokumentasi dan Humas' ? 'selected' : '' ?>>Bidang Publikasi, Dokumentasi dan Humas</option>
                            <option value="Bidang Perlengkapan dan Rumah Tangga" <?= old('kategori_unit') === 'Bidang Perlengkapan dan Rumah Tangga' ? 'selected' : '' ?>>Bidang Perlengkapan dan Rumah Tangga</option>
                            <option value="Bidang Sekretariat" <?= old('kategori_unit') === 'Bidang Sekretariat' ? 'selected' : '' ?>>Bidang Sekretariat</option>
                        </select>
                        <small class="text-muted" style="font-size: 0.775rem;">Kelompok blok unit untuk mengelompokkan struktur kepanitiaan.</small>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label for="urutan" class="form-label">Urutan Tampilan Visual</label>
                        <input type="number" class="form-control" id="urutan" name="urutan" placeholder="Contoh: 1" value="<?= old('urutan', 1) ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-4">
                        <label for="parent_id" class="form-label">Jabatan Atasan (Parent)</label>
                        <select class="form-select" id="parent_id" name="parent_id">
                            <option value="">-- Tanpa Atasan (Puncak Pimpinan/Koordinator) --</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-4">
                        <label for="tugas" class="form-label">Tugas Khusus Utama</label>
                        <textarea class="form-control" id="tugas" name="tugas" rows="3" placeholder="Deskripsikan secara singkat tugas pokok posisi jabatan ini (Opsional)"><?= old('tugas') ?></textarea>
                    </div>
                </div>

                <div class="d-flex gap-3 justify-content-end mt-4">
                    <a href="<?= base_url('dashboard/kepanitiaan' . (!empty($selected_kegiatan) ? '/detail/' . esc($selected_kegiatan) : '')) ?>" class="btn btn-cancel">Batal</a>
                    <button type="submit" class="btn btn-submit">Simpan Jabatan <i class="fa-solid fa-save ms-2"></i></button>
                </div>
            </form>
        </div>
    </main>

    <!-- jQuery and Bootstrap 5.3 JS Bundle -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- JavaScript Filter Dinamis Jabatan Atasan dengan Select2 Search -->
    <script>
        const rawJabatanList = <?= json_encode($jabatan_list) ?>;
        const oldParentId = "<?= old('parent_id') ?>";

        function filterParentJabatan() {
            const selectedKegiatan = document.getElementById('kegiatan_id').value;
            const parentSelect = document.getElementById('parent_id');
            
            let currentVal = $(parentSelect).val() || oldParentId;

            parentSelect.innerHTML = '<option value="">-- Tanpa Atasan (Puncak Pimpinan/Koordinator) --</option>';
            
            const filtered = rawJabatanList.filter(j => j.kegiatan_id === selectedKegiatan);
            filtered.forEach(j => {
                const opt = document.createElement('option');
                opt.value = j.id;
                opt.textContent = (j.urutan ? ('[' + j.urutan + '] ') : '') + j.nama_jabatan;
                if (j.id === currentVal) {
                    opt.selected = true;
                }
                parentSelect.appendChild(opt);
            });

            $('#parent_id').select2({
                theme: 'bootstrap-5',
                placeholder: '-- Pilih / Cari Jabatan Atasan --',
                allowClear: true,
                width: '100%'
            });
        }

        $(document).ready(function() {
            $('#kegiatan_id').select2({
                theme: 'bootstrap-5',
                placeholder: '-- Pilih Kegiatan --',
                width: '100%'
            });

            filterParentJabatan();

            $('#kegiatan_id').on('change', function() {
                filterParentJabatan();
            });
        });
    </script>
</body>
</html>
