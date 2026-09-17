<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Jadwal Jumat - <?= site_name() ?></title>
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

        /* Sidebar Styles (Same as Dashboard) */
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
                <a href="<?= base_url('dashboard/jadwal-jumat') ?>" class="menu-link active">
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
                <h1 class="h3 fw-bold mb-1 text-dark">Ubah Jadwal Jumat</h1>
                <p class="text-muted mb-0">Ubah rincian petugas salat Jumat mingguan.</p>
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

        <!-- FORM PANEL -->
        <div class="panel-card">
            <form action="<?= base_url('dashboard/jadwal-jumat/update/' . $jadwal['id']) ?>" method="post">
                <?= csrf_field() ?>

                <div class="row">
                    <!-- Tanggal -->
                    <div class="col-md-6 mb-4">
                        <label for="tanggal" class="form-label">Tanggal Hari Jumat</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= old('tanggal', $jadwal['tanggal']) ?>" required>
                    </div>

                    <!-- Judul Khotbah -->
                    <div class="col-md-6 mb-4">
                        <label for="judul_khotbah" class="form-label">Rencana Judul Khotbah <span class="text-muted fw-normal">(Opsional)</span></label>
                        <input type="text" class="form-control" id="judul_khotbah" name="judul_khotbah" placeholder="Masukkan judul/tema khotbah (opsional)" value="<?= old('judul_khotbah', $jadwal['judul_khotbah']) ?>">
                    </div>
                </div>

                <div class="row">
                    <!-- Khatib -->
                    <div class="col-md-4 mb-4">
                        <label for="khatib_id" class="form-label">Khatib <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <select class="form-select select2-petugas" id="khatib_id" name="khatib_id" required>
                                <option value="">-- Pilih / Cari Khatib --</option>
                                <?php foreach ($khatib_list as $khatib) : ?>
                                    <option value="<?= esc($khatib['id']) ?>" <?= old('khatib_id', $jadwal['khatib_id']) == $khatib['id'] ? 'selected' : '' ?>>
                                        <?= esc($khatib['nama']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <button type="button" class="btn btn-outline-success btn-quick-add" data-target="khatib_id" data-jabatan="khatib" title="Tambah Khatib Baru">
                                <i class="fa-solid fa-user-plus"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Imam -->
                    <div class="col-md-4 mb-4">
                        <label for="imam_id" class="form-label">Imam Salat <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <select class="form-select select2-petugas" id="imam_id" name="imam_id" required>
                                <option value="">-- Pilih / Cari Imam --</option>
                                <?php foreach ($imam_list as $imam) : ?>
                                    <option value="<?= esc($imam['id']) ?>" <?= old('imam_id', $jadwal['imam_id']) == $imam['id'] ? 'selected' : '' ?>>
                                        <?= esc($imam['nama']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <button type="button" class="btn btn-outline-success btn-quick-add" data-target="imam_id" data-jabatan="imam" title="Tambah Imam Baru">
                                <i class="fa-solid fa-user-plus"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Muadzin (Opsional) -->
                    <div class="col-md-4 mb-4">
                        <label for="muadzin_id" class="form-label">Muadzin <span class="text-muted fw-normal">(Opsional)</span></label>
                        <div class="input-group">
                            <select class="form-select select2-petugas" id="muadzin_id" name="muadzin_id">
                                <option value="">-- Pilih / Cari Muadzin (Opsional) --</option>
                                <?php foreach ($muadzin_list as $muadzin) : ?>
                                    <option value="<?= esc($muadzin['id']) ?>" <?= old('muadzin_id', $jadwal['muadzin_id']) == $muadzin['id'] ? 'selected' : '' ?>>
                                        <?= esc($muadzin['nama']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <button type="button" class="btn btn-outline-success btn-quick-add" data-target="muadzin_id" data-jabatan="muadzin" title="Tambah Muadzin Baru">
                                <i class="fa-solid fa-user-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Keterangan -->
                <div class="mb-4">
                    <label for="keterangan" class="form-label">Keterangan Tambahan</label>
                    <textarea class="form-control" id="keterangan" name="keterangan" rows="4" placeholder="Tuliskan pengumuman atau catatan tambahan (opsional)"><?= old('keterangan', $jadwal['keterangan']) ?></textarea>
                </div>

                <!-- Buttons -->
                <div class="d-flex gap-3 justify-content-end">
                    <a href="<?= base_url('dashboard/jadwal-jumat') ?>" class="btn btn-cancel">Batal</a>
                    <button type="submit" class="btn btn-submit">Simpan Perubahan <i class="fa-solid fa-save ms-2"></i></button>
                </div>
            </form>
        </div>
    </main>

    <!-- MODAL TAMBAH PETUGAS BARU (QUICK ADD) -->
    <div class="modal fade" id="modalQuickAddPetugas" tabindex="-1" aria-labelledby="modalQuickAddLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content style-modal" style="border-radius: 16px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title font-heading fw-bold" id="modalQuickAddLabel"><i class="fa-solid fa-user-plus text-success me-2"></i>Tambah Petugas Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <form id="formQuickAddPetugas">
                        <input type="hidden" id="target_select_id" value="">
                        
                        <div class="mb-3">
                            <label for="new_nama_petugas" class="form-label">Nama Lengkap Petugas <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="new_nama_petugas" placeholder="Contoh: Ust. H. Abd. Kadir, Lc." required>
                        </div>

                        <div class="mb-3">
                            <label for="new_jabatan_petugas" class="form-label">Peran Utama Petugas <span class="text-danger">*</span></label>
                            <select class="form-select" id="new_jabatan_petugas" required>
                                <option value="khatib">Khatib</option>
                                <option value="imam">Imam Salat</option>
                                <option value="muadzin">Muadzin</option>
                                <option value="imam_khatib">Imam & Khatib</option>
                            </select>
                        </div>

                        <div id="quickAddAlert" class="alert alert-danger d-none mb-0" role="alert"></div>
                    </form>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal" style="border-radius: 10px;">Batal</button>
                    <button type="button" class="btn btn-success px-4" id="btnSaveQuickAdd" style="border-radius: 10px;">Simpan & Pilih <i class="fa-solid fa-check ms-1"></i></button>
                </div>
            </div>
        </div>
    </div>

    <!-- Select2 CSS & JS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            // Inisialisasi Select2 dengan fitur pencarian
            $('#khatib_id, #imam_id, #muadzin_id').select2({
                theme: 'bootstrap-5',
                placeholder: '-- Pilih / Cari Petugas --',
                allowClear: true,
                width: '100%'
            });

            // Buka modal Quick Add Petugas
            $('.btn-quick-add').on('click', function() {
                const target = $(this).data('target');
                const defaultRole = $(this).data('jabatan');
                
                $('#target_select_id').val(target);
                $('#new_nama_petugas').val('');
                $('#new_jabatan_petugas').val(defaultRole || 'khatib');
                $('#quickAddAlert').addClass('d-none').text('');
                
                const modal = new bootstrap.Modal(document.getElementById('modalQuickAddPetugas'));
                modal.show();
            });

            // Simpan Petugas Baru via AJAX
            $('#btnSaveQuickAdd').on('click', function() {
                const nama = $('#new_nama_petugas').val().trim();
                const jabatan = $('#new_jabatan_petugas').val();
                const targetSelectId = $('#target_select_id').val();

                if (!nama) {
                    $('#quickAddAlert').removeClass('d-none').text('Nama petugas wajib diisi.');
                    return;
                }

                const btn = $(this);
                btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin me-1"></i> Menyimpan...');

                $.ajax({
                    url: '<?= base_url('dashboard/jadwal-jumat/ajax-add-petugas') ?>',
                    type: 'POST',
                    data: {
                        '<?= csrf_token() ?>': '<?= csrf_hash() ?>',
                        nama: nama,
                        jabatan: jabatan
                    },
                    dataType: 'json',
                    success: function(res) {
                        btn.prop('disabled', false).html('Simpan & Pilih <i class="fa-solid fa-check ms-1"></i>');
                        if (res.status) {
                            const newOption = new Option(res.data.nama, res.data.id, true, true);
                            
                            // Tambahkan ke target select dan pilih
                            $('#' + targetSelectId).append(newOption).trigger('change');
                            
                            // Tambahkan juga ke select petugas lainnya jika belum ada
                            ['khatib_id', 'imam_id', 'muadzin_id'].forEach(function(sId) {
                                if (sId !== targetSelectId && $('#' + sId + ' option[value="' + res.data.id + '"]').length === 0) {
                                    $('#' + sId).append(new Option(res.data.nama, res.data.id, false, false)).trigger('change.select2');
                                }
                            });

                            const modalEl = document.getElementById('modalQuickAddPetugas');
                            const modal = bootstrap.Modal.getInstance(modalEl);
                            if (modal) modal.hide();
                        } else {
                            $('#quickAddAlert').removeClass('d-none').text(res.message || 'Gagal menyimpan data.');
                        }
                    },
                    error: function() {
                        btn.prop('disabled', false).html('Simpan & Pilih <i class="fa-solid fa-check ms-1"></i>');
                        $('#quickAddAlert').removeClass('d-none').text('Terjadi kesalahan koneksi server.');
                    }
                });
            });
        });
    </script>
</body>
</html>
