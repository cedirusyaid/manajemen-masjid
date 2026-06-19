<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Panitia Kegiatan - <?= site_name() ?></title>
    <!-- Google Fonts: Inter & Outfit -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- jQuery (Wajib untuk Select2) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Select2 CSS & Bootstrap 5 Theme -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
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
                <h1 class="h3 fw-bold mb-1 text-dark">Tambah Panitia Baru</h1>
                <p class="text-muted mb-0">Daftarkan personel kepanitiaan untuk kegiatan masjid.</p>
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
            <div class="alert alert-danger d-flex align-items-center gap-2 mb-4 border-0 shadow-sm" role="alert">
                <i class="fa-solid fa-circle-exclamation"></i>
                <div><?= session()->getFlashdata('error') ?></div>
            </div>
        <?php endif; ?>

        <!-- FORM PANEL -->
        <div class="panel-card">
            <form action="<?= base_url('dashboard/kepanitiaan/panitia/store') ?>" method="post">
                <?= csrf_field() ?>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label for="personil_id" class="form-label">Nama Personel Panitia</label>
                        <div class="input-group">
                            <select class="form-select" id="personil_id" name="personil_id" required>
                                <option value="">-- Pilih Personel --</option>
                                <?php foreach ($personil_list as $personil) : ?>
                                    <option value="<?= esc($personil['id']) ?>" <?= old('personil_id') == $personil['id'] ? 'selected' : '' ?>>
                                        <?= esc($personil['nama']) ?> (<?= esc($personil['no_hp'] ?: 'Tidak ada No WA') ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <button class="btn btn-outline-success" type="button" data-bs-toggle="modal" data-bs-target="#modalTambahPersonil" title="Tambah Personel Baru">
                                <i class="fa-solid fa-user-plus"></i>
                            </button>
                        </div>
                        <small class="text-muted mt-1 d-block">Jika personel belum terdaftar, klik tombol hijau di samping kanan untuk menambahkan secara instan.</small>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label for="jabatan" class="form-label">Jabatan Kepanitiaan</label>
                        <input type="text" class="form-control" id="jabatan" name="jabatan" placeholder="Contoh: Ketua Panitia / Sekertaris / Anggota Acara" value="<?= old('jabatan') ?>" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label for="kegiatan_id" class="form-label">Kegiatan Pelaksanaan</label>
                        <select class="form-select" id="kegiatan_id" name="kegiatan_id" required>
                            <option value="">-- Pilih Kegiatan --</option>
                            <?php foreach ($kegiatan_list as $kegiatan) : ?>
                                <option value="<?= esc($kegiatan['id']) ?>" <?= old('kegiatan_id') == $kegiatan['id'] || (isset($selected_kegiatan) && $selected_kegiatan == $kegiatan['id']) ? 'selected' : '' ?>>
                                    <?= esc($kegiatan['nama_kegiatan']) ?> (<?= date('Y', strtotime($kegiatan['tanggal_mulai'])) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-3 mb-4">
                        <label for="urutan" class="form-label">Urutan Tampilan Visual</label>
                        <input type="number" class="form-control" id="urutan" name="urutan" placeholder="Contoh: 1" value="<?= old('urutan', 1) ?>">
                    </div>

                    <div class="col-md-3 mb-4">
                        <label for="parent_id" class="form-label">Koordinator / Atasan</label>
                        <select class="form-select" id="parent_id" name="parent_id">
                            <option value="">-- Tanpa Atasan (Pimpinan Kegiatan) --</option>
                            <?php foreach ($panitia_list as $p_parent) : ?>
                                <option value="<?= esc($p_parent['id']) ?>" <?= old('parent_id') == $p_parent['id'] ? 'selected' : '' ?>>
                                    <?= esc($p_parent['nama']) ?> (<?= esc($p_parent['jabatan']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="tugas" class="form-label">Tugas Khusus / Detail Jobdesk</label>
                    <textarea class="form-control" id="tugas" name="tugas" rows="4" placeholder="Tuliskan detail tanggung jawab atau tugas khusus panitia (opsional)"><?= old('tugas') ?></textarea>
                </div>

                <div class="d-flex gap-3 justify-content-end mt-4">
                    <a href="<?= base_url('dashboard/kepanitiaan' . (!empty($selected_kegiatan) ? '?kegiatan_id=' . esc($selected_kegiatan) : '')) ?>" class="btn btn-cancel">Batal</a>
                    <button type="submit" class="btn btn-submit">Simpan Anggota Panitia <i class="fa-solid fa-save ms-2"></i></button>
                </div>
            </form>
        </div>
    </main>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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

    <!-- AJAX Script untuk Simpan Personil -->
    <script>
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
                    'tipe_default': 'panitia'
                })
            })
            .then(response => response.json())
            .then(res => {
                this.disabled = false;
                this.innerHTML = 'Simpan';
                
                if (res.status) {
                    // Berhasil simpan
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
                    
                    // Gunakan bootstrap class untuk modal hide
                    const modalEl = document.getElementById('modalTambahPersonil');
                    const modalInstance = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                    modalInstance.hide();
                    
                    // Tampilkan notifikasi kecil
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

        // Inisialisasi Select2 Searchable Dropdown
        $(document).ready(function() {
            $('#personil_id').select2({
                theme: 'bootstrap-5',
                placeholder: '-- Pilih Personel --',
                width: '100%'
            });
            $('#parent_id').select2({
                theme: 'bootstrap-5',
                placeholder: '-- Pilih Koordinator (Jika Ada) --',
                allowClear: true,
                width: '100%'
            });
            $('#kegiatan_id').select2({
                theme: 'bootstrap-5',
                placeholder: '-- Pilih Kegiatan --',
                width: '100%'
            });
        });
    </script>
</body>
</html>
