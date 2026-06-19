<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Anggota Kelompok - <?= site_name() ?></title>
    <!-- Google Fonts: Inter & Outfit -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Select2 Bootstrap 5 Theme -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    
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

        .btn-submit {
            background-color: var(--primary);
            color: var(--white);
            font-weight: 600;
            padding: 10px 24px;
            border-radius: 8px;
            border: none;
            transition: var(--transition);
        }

        .btn-submit:hover {
            background-color: var(--primary-light);
            color: var(--white);
        }

        .btn-cancel {
            background-color: #f3f4f6;
            color: #4b5563;
            font-weight: 600;
            padding: 10px 24px;
            border-radius: 8px;
            text-decoration: none;
            transition: var(--transition);
            border: 1px solid #e5e7eb;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-cancel:hover {
            background-color: #e5e7eb;
            color: #1f2937;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.9rem;
            color: #374151;
            margin-bottom: 8px;
        }

        .form-control, .form-select {
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            padding: 10px 16px;
            font-size: 0.95rem;
            transition: var(--transition);
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-light);
            box-shadow: 0 0 0 4px rgba(15, 118, 110, 0.1);
            outline: none;
        }

        .select2-container--bootstrap-5 .select2-selection {
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            min-height: 45px;
            display: flex;
            align-items: center;
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
                <h1 class="h3 fw-bold mb-1 text-dark">Kelola Anggota Kelompok</h1>
                <p class="text-muted mb-0">Kelompok: <span class="text-success fw-bold"><?= esc($kelompok['nama_kelompok']) ?></span> | Kegiatan: <?= esc($kegiatan['nama_kegiatan']) ?></p>
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

        <!-- FORM TAMBAH ANGGOTA -->
        <div class="panel-card bg-white border-0 shadow-sm rounded-4 mb-4">
            <div class="panel-title mb-4">
                <span class="fs-5 fw-bold text-dark">Tambah Anggota Kelompok</span>
            </div>
            <form action="<?= base_url('dashboard/kepanitiaan/kelompok/anggota/store') ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="kelompok_id" value="<?= esc($kelompok['id']) ?>">

                <div class="row align-items-end">
                    <div class="col-md-5 mb-3">
                        <label for="personil_id" class="form-label">Nama Personel (Jemaah) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <select class="form-select" id="personil_id" name="personil_id" required>
                                <option value="">-- Cari/Pilih Personel --</option>
                                <?php foreach ($personil_list as $personil) : ?>
                                    <option value="<?= esc($personil['id']) ?>" <?= old('personil_id') == $personil['id'] ? 'selected' : '' ?>>
                                        <?= esc($personil['nama']) ?> (<?= esc($personil['no_hp'] ?: 'Tidak ada No WA') ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <button class="btn btn-outline-success px-3" type="button" data-bs-toggle="modal" data-bs-target="#modalTambahPersonil" title="Tambah Personel Baru Instan" style="border-radius: 0 10px 10px 0;">
                                <i class="fa-solid fa-user-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="peran" class="form-label">Peran / Tugas Kelompok <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="peran" name="peran" placeholder="Contoh: Ketua, Anggota, Penyedia Buka" value="<?= old('peran', 'Anggota') ?>" required style="height: 45px;">
                    </div>
                    <div class="col-md-3 mb-3 d-flex gap-2">
                        <button type="submit" class="btn btn-submit w-100 fw-bold" style="height: 45px;">
                            <i class="fa-solid fa-plus me-2"></i>Tambah
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- DAFTAR ANGGOTA -->
        <div class="panel-card bg-white border-0 shadow-sm rounded-4">
            <div class="panel-title d-flex justify-content-between align-items-center mb-4">
                <span class="fs-5 fw-bold text-dark">Anggota Kelompok Aktif</span>
                <a href="<?= base_url('dashboard/kepanitiaan/detail/' . esc($kegiatan['id'])) ?>" class="btn btn-cancel py-2 px-3 fw-semibold">
                    <i class="fa-solid fa-arrow-left me-2"></i>Kembali ke Detail Kegiatan
                </a>
            </div>

            <div class="table-responsive">
                <table class="table custom-table">
                    <thead>
                        <tr>
                            <th>Nama Anggota</th>
                            <th>Peran / Posisi</th>
                            <th>Kontak No HP/WA</th>
                            <th>Email</th>
                            <th style="width: 100px;" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($anggota_list)) : ?>
                            <?php foreach ($anggota_list as $agt) : ?>
                                <tr>
                                    <td><strong><?= esc($agt['nama']) ?></strong></td>
                                    <td><span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2.5 py-1.5 rounded-pill"><?= esc($agt['peran']) ?></span></td>
                                    <td>
                                        <?php if ($agt['no_hp']) : ?>
                                            <a href="https://api.whatsapp.com/send?phone=<?= esc($agt['no_hp']) ?>" target="_blank" class="text-decoration-none text-dark">
                                                <i class="fa-brands fa-whatsapp text-success me-1"></i> <?= esc($agt['no_hp']) ?>
                                            </a>
                                        <?php else : ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= esc($agt['email'] ?: '-') ?></td>
                                    <td class="text-center">
                                        <a href="<?= base_url('dashboard/kepanitiaan/kelompok/anggota/delete/' . esc($agt['id'])) ?>" class="btn-action btn-delete" onclick="return confirm('Apakah Anda yakin ingin mengeluarkan anggota ini dari kelompok?')" title="Keluarkan Anggota">
                                            <i class="fa-solid fa-user-minus"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-users fs-1 mb-3 d-block text-secondary"></i>
                                    Belum ada jemaah/anggota terdaftar di kelompok ini.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- MODAL TAMBAH PERSONIL INSTAN -->
    <div class="modal fade" id="modalTambahPersonil" tabindex="-1" aria-labelledby="modalTambahPersonilLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-4 border-0 shadow-lg">
                <div class="modal-header bg-success text-white rounded-top-4 py-3">
                    <h5 class="modal-title font-heading fw-bold" id="modalTambahPersonilLabel">
                        <i class="fa-solid fa-user-plus me-2"></i>Tambah Personel Baru
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div id="modalAlert" class="alert alert-danger d-none" role="alert"></div>
                    <form id="formPersonilInstan">
                        <div class="mb-3">
                            <label class="form-label" for="p_nama">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="p_nama" required placeholder="Nama lengkap beserta gelar jika ada">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="p_jenis_kelamin">Jenis Kelamin <span class="text-danger">*</span></label>
                            <select class="form-select" id="p_jenis_kelamin" required>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="p_no_hp">Nomor WhatsApp/HP (Opsional)</label>
                            <input type="text" class="form-control" id="p_no_hp" placeholder="Contoh: 08123456789">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="p_alamat">Alamat Rumah (Opsional)</label>
                            <textarea class="form-control" id="p_alamat" rows="2" placeholder="Alamat tempat tinggal"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer bg-light rounded-bottom-4 border-0">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal" style="border-radius: 10px;">Batal</button>
                    <button type="button" class="btn btn-success px-4" id="btnSimpanPersonil" style="border-radius: 10px; background-color: #064e3b; border: none;">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Script jQuery & Select2 JS Bundle -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#personil_id').select2({
                theme: 'bootstrap-5',
                placeholder: '-- Cari/Pilih Personel --',
                width: '100%'
            });
        });

        // AJAX Script untuk Simpan Personil Instan
        document.getElementById('btnSimpanPersonil').addEventListener('click', function() {
            const nama = document.getElementById('p_nama').value.trim();
            const jk = document.getElementById('p_jenis_kelamin').value;
            const noHp = document.getElementById('p_no_hp').value.trim();
            const alamat = document.getElementById('p_alamat').value.trim();
            const modalAlert = document.getElementById('modalAlert');

            if (nama.length < 3) {
                modalAlert.innerText = 'Nama lengkap minimal 3 karakter.';
                modalAlert.classList.remove('d-none');
                return;
            }

            modalAlert.classList.add('d-none');
            this.disabled = true;
            this.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Menyimpan...';

            fetch('<?= base_url('dashboard/personil/ajax-store') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: new URLSearchParams({
                    '<?= csrf_token() ?>': '<?= csrf_hash() ?>',
                    'nama': nama,
                    'jenis_kelamin': jk,
                    'no_hp': noHp,
                    'alamat': alamat,
                    'tipe_default': 'jemaah'
                })
            })
            .then(response => response.json())
            .then(res => {
                this.disabled = false;
                this.innerHTML = 'Simpan';
                
                if (res.status) {
                    const selectEl = document.getElementById('personil_id');
                    
                    // Buat option baru
                    const opt = document.createElement('option');
                    opt.value = res.data.id;
                    opt.text = res.data.nama + ' (WA: ' + (noHp || 'Tidak ada') + ')';
                    opt.selected = true;
                    
                    // Masukkan ke select
                    selectEl.add(opt, selectEl.options[1]);
                    
                    // Trigger update untuk Select2
                    $(selectEl).val(res.data.id).trigger('change');
                    
                    // Reset form & tutup modal
                    document.getElementById('formPersonilInstan').reset();
                    
                    const modalEl = document.getElementById('modalTambahPersonil');
                    const modalInstance = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                    modalInstance.hide();
                    
                    alert(res.message);
                } else {
                    modalAlert.innerText = res.message || 'Gagal menyimpan data.';
                    modalAlert.classList.remove('d-none');
                }
            })
            .catch(err => {
                this.disabled = false;
                this.innerHTML = 'Simpan';
                modalAlert.innerText = 'Terjadi kesalahan sistem, silakan coba lagi.';
                modalAlert.classList.remove('d-none');
                console.error(err);
            });
        });
    </script>
</body>
</html>
