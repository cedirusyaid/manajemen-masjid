<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= site_name() ?> - Pusat Informasi & Pelayanan Jamaah</title>
    <!-- Google Fonts: Outfit & Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #064e3b;      /* Hijau Islami Premium */
            --primary-light: #0f766e;
            --accent: #d97706;       /* Gold/Amber */
            --dark-navy: #022c22;
            --light-bg: #f4f7f5;
            --white: #ffffff;
            --shadow-sm: 0 4px 10px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 10px 30px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--light-bg);
            color: #374151;
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, .font-heading {
            font-family: 'Outfit', sans-serif;
        }

        /* ----------------------------------------------------------------------
         * Navigation Header
         * ---------------------------------------------------------------------- */
        .navbar {
            background-color: rgba(2, 44, 34, 0.95) !important;
            backdrop-filter: blur(10px);
            padding: 15px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.4rem;
            color: var(--white) !important;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar-brand i {
            color: var(--accent);
            font-size: 1.8rem;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.8) !important;
            font-weight: 500;
            font-size: 0.95rem;
            padding: 8px 16px !important;
            transition: var(--transition);
        }

        .nav-link:hover, .nav-link.active {
            color: var(--accent) !important;
        }

        .btn-login {
            background-color: var(--accent);
            color: var(--white) !important;
            border-radius: 30px;
            padding: 8px 24px !important;
            font-weight: 600;
            box-shadow: 0 4px 10px rgba(217, 119, 6, 0.3);
            transition: var(--transition);
        }

        .btn-login:hover {
            background-color: #b45309;
            transform: translateY(-2px);
        }

        /* ----------------------------------------------------------------------
         * Hero Section
         * ---------------------------------------------------------------------- */
        .hero {
            background: linear-gradient(135deg, rgba(2, 44, 34, 0.95) 0%, rgba(6, 78, 59, 0.9) 100%), 
                        url('https://images.unsplash.com/photo-1590076211186-638a84798a3b?auto=format&fit=crop&q=80&w=1920') no-repeat center center/cover;
            min-height: 80vh;
            display: flex;
            align-items: center;
            position: relative;
            color: var(--white);
            padding: 100px 0 160px;
        }

        .hero::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100px;
            background: linear-gradient(to top, var(--light-bg), transparent);
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.15;
            margin-bottom: 20px;
        }

        .hero-title span {
            color: var(--accent);
        }

        .hero-desc {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.85);
            margin-bottom: 35px;
            max-width: 600px;
            line-height: 1.6;
        }

        /* ----------------------------------------------------------------------
         * Jadwal Sholat Section
         * ---------------------------------------------------------------------- */
        .sholat-container {
            margin-top: -100px;
            position: relative;
            z-index: 10;
        }

        .sholat-card {
            background: var(--white);
            border-radius: 20px;
            box-shadow: var(--shadow-md);
            padding: 30px;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .sholat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1.5px dashed #e5e7eb;
            padding-bottom: 20px;
            margin-bottom: 25px;
        }

        .sholat-header h4 {
            font-weight: 700;
            color: var(--dark-navy);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sholat-header h4 i {
            color: var(--primary);
        }

        .sholat-header .date {
            font-size: 0.9rem;
            color: #6b7280;
            font-weight: 500;
        }

        .sholat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
            gap: 15px;
        }

        .sholat-item {
            background-color: var(--light-bg);
            border-radius: 12px;
            padding: 15px 10px;
            text-align: center;
            transition: var(--transition);
            border: 1px solid transparent;
        }

        .sholat-item:hover {
            transform: translateY(-5px);
            background-color: #ecfdf5;
            border-color: rgba(15, 118, 110, 0.2);
            box-shadow: var(--shadow-sm);
        }

        .sholat-name {
            font-weight: 600;
            font-size: 0.85rem;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }

        .sholat-time {
            font-family: 'Outfit', sans-serif;
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--dark-navy);
        }

        /* ----------------------------------------------------------------------
         * Petugas Jumat Section
         * ---------------------------------------------------------------------- */
        .jumat-section {
            padding: 80px 0;
        }

        .section-header {
            text-align: center;
            margin-bottom: 50px;
        }

        .section-header h2 {
            font-weight: 800;
            color: var(--dark-navy);
            font-size: 2.2rem;
            position: relative;
            display: inline-block;
            padding-bottom: 15px;
        }

        .section-header h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background-color: var(--accent);
            border-radius: 2px;
        }

        .section-header p {
            color: #6b7280;
            margin-top: 10px;
            font-size: 1.05rem;
        }

        .jumat-card {
            background: var(--white);
            border-radius: 20px;
            box-shadow: var(--shadow-md);
            padding: 40px;
            border: 1px solid rgba(0, 0, 0, 0.03);
        }

        .khotbah-box {
            background-color: #fef3c7;
            border-left: 5px solid var(--accent);
            padding: 20px;
            border-radius: 0 15px 15px 0;
            margin-bottom: 35px;
        }

        .khotbah-title {
            font-weight: 700;
            color: #92400e;
            font-size: 1.15rem;
            margin-bottom: 5px;
        }

        .petugas-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 30px;
        }

        .petugas-item {
            text-align: center;
            padding: 20px;
            border-radius: 15px;
            transition: var(--transition);
        }

        .petugas-item:hover {
            background-color: var(--light-bg);
        }

        .petugas-avatar {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--primary);
            box-shadow: var(--shadow-sm);
            margin-bottom: 15px;
        }

        .petugas-role {
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--accent);
            letter-spacing: 1px;
            margin-bottom: 5px;
        }

        .petugas-nama {
            font-weight: 700;
            color: var(--dark-navy);
            font-size: 1.1rem;
        }

        /* ----------------------------------------------------------------------
         * Infak Section
         * ---------------------------------------------------------------------- */
        .infak-section {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: var(--white);
            padding: 80px 0;
            border-radius: 30px;
            margin-bottom: 80px;
            box-shadow: var(--shadow-md);
        }

        .qris-card {
            background: var(--white);
            border-radius: 20px;
            padding: 20px;
            width: 100%;
            max-width: 280px;
            margin: 0 auto;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }

        .qris-img {
            width: 100%;
            border-radius: 10px;
        }

        /* ----------------------------------------------------------------------
         * Footer
         * ---------------------------------------------------------------------- */
        footer {
            background-color: var(--dark-navy);
            color: rgba(255, 255, 255, 0.7);
            padding: 60px 0 30px;
            font-size: 0.9rem;
            border-top: 5px solid var(--accent);
        }

        footer h5 {
            color: var(--white);
            font-weight: 700;
            margin-bottom: 20px;
        }

        footer a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: var(--transition);
        }

        footer a:hover {
            color: var(--accent);
            padding-left: 5px;
        }
    </style>
</head>
<body>

    <!-- NAVIGASI HEADER -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url() ?>">
                <i class="fa-solid fa-mosque"></i>
                <span><?= site_name() ?></span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center gap-2">
                    <li class="nav-item"><a class="nav-link active" href="<?= base_url() ?>">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="#jadwal">Jadwal Sholat</a></li>
                    <li class="nav-item"><a class="nav-link" href="#petugas-jumat">Petugas Jumat</a></li>
                    <li class="nav-item"><a class="nav-link" href="#layanan">Layanan</a></li>
                    <li class="nav-item"><a class="nav-link" href="#donasi">Donasi</a></li>
                    <li class="nav-item ms-lg-2">
                        <a class="nav-link btn-login text-center" href="<?= base_url('login') ?>">
                            <i class="fa-solid fa-arrow-right-to-bracket me-1"></i> Login Admin
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <header class="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <h1 class="hero-title">Pusat Digitalisasi Keagamaan <span><?= site_name() ?></span></h1>
                    <p class="hero-desc">Mewujudkan pelayanan jamaah yang transparan, profesional, dan inklusif berbasis kemudahan akses informasi keagamaan digital untuk kemaslahatan umat.</p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="#donasi" class="btn btn-warning btn-lg text-white font-heading" style="background-color: var(--accent); border: none; padding: 12px 30px; border-radius: 30px; font-weight: 600;">
                            <i class="fa-solid fa-hand-holding-heart me-2"></i> Infaq Digital
                        </a>
                        <a href="#layanan" class="btn btn-outline-light btn-lg font-heading" style="padding: 12px 30px; border-radius: 30px; font-weight: 600;">
                            Layanan Jamaah <i class="fa-solid fa-circle-chevron-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>
 
    <!-- JADWAL SHOLAT SECTION -->
    <section class="container sholat-container" id="jadwal">
        <div class="sholat-card">
            <div class="sholat-header">
                <h4><i class="fa-solid fa-clock"></i> Jadwal Sholat Hari Ini (Wilayah Setempat)</h4>
                <div class="date font-heading"><i class="fa-solid fa-calendar-days me-1"></i> <?= esc($jadwal_sholat['tanggal']) ?></div>
            </div>
            <div class="sholat-grid">
                <div class="sholat-item">
                    <div class="sholat-name">Imsak</div>
                    <div class="sholat-time"><?= esc($jadwal_sholat['imsak']) ?></div>
                </div>
                <div class="sholat-item">
                    <div class="sholat-name">Subuh</div>
                    <div class="sholat-time"><?= esc($jadwal_sholat['subuh']) ?></div>
                </div>
                <div class="sholat-item">
                    <div class="sholat-name">Terbit</div>
                    <div class="sholat-time"><?= esc($jadwal_sholat['terbit']) ?></div>
                </div>
                <div class="sholat-item">
                    <div class="sholat-name">Dzuhur</div>
                    <div class="sholat-time"><?= esc($jadwal_sholat['dzuhur']) ?></div>
                </div>
                <div class="sholat-item">
                    <div class="sholat-name">Ashar</div>
                    <div class="sholat-time"><?= esc($jadwal_sholat['ashar']) ?></div>
                </div>
                <div class="sholat-item">
                    <div class="sholat-name">Maghrib</div>
                    <div class="sholat-time"><?= esc($jadwal_sholat['maghrib']) ?></div>
                </div>
                <div class="sholat-item">
                    <div class="sholat-name">Isya</div>
                    <div class="sholat-time"><?= esc($jadwal_sholat['isya']) ?></div>
                </div>
            </div>
        </div>
    </section>

    <!-- PETUGAS JUMAT SECTION -->
    <section class="jumat-section container" id="petugas-jumat">
        <div class="section-header">
            <h2>Petugas Salat Jumat Pekan Ini</h2>
            <p>Jadwal Khatib, Imam, dan Muadzin Salat Jumat <?= site_name() ?></p>
        </div>

        <div class="jumat-card">
            <?php if (!empty($petugas_jumat)) : ?>
                <!-- Judul Khotbah -->
                <div class="khotbah-box">
                    <div class="petugas-role"><i class="fa-solid fa-book-open me-1"></i> Rencana Judul Khotbah</div>
                    <div class="khotbah-title">"<?= esc($petugas_jumat['judul_khotbah']) ?: 'Tema belum ditentukan' ?>"</div>
                    <small class="text-muted"><i class="fa-solid fa-calendar-day me-1"></i> Hari Jumat, <?= esc(date('d-m-Y', strtotime($petugas_jumat['tanggal']))) ?></small>
                </div>

                <!-- Petugas Grid -->
                <div class="petugas-grid">
                    <div class="petugas-item">
                        <img class="petugas-avatar" src="<?= $petugas_jumat['khatib_foto'] ? base_url('uploads/images/' . $petugas_jumat['khatib_foto']) : 'https://img.icons8.com/bubbles/100/000000/user-male-circle.png' ?>" alt="Khatib">
                        <div class="petugas-role">Khatib</div>
                        <div class="petugas-nama"><?= esc($petugas_jumat['khatib_nama']) ?></div>
                    </div>
                    <div class="petugas-item">
                        <img class="petugas-avatar" src="<?= $petugas_jumat['imam_foto'] ? base_url('uploads/images/' . $petugas_jumat['imam_foto']) : 'https://img.icons8.com/bubbles/100/000000/user-male-circle.png' ?>" alt="Imam">
                        <div class="petugas-role">Imam</div>
                        <div class="petugas-nama"><?= esc($petugas_jumat['imam_nama']) ?></div>
                    </div>
                    <div class="petugas-item">
                        <img class="petugas-avatar" src="<?= $petugas_jumat['muadzin_foto'] ? base_url('uploads/images/' . $petugas_jumat['muadzin_foto']) : 'https://img.icons8.com/bubbles/100/000000/user-male-circle.png' ?>" alt="Muadzin">
                        <div class="petugas-role">Muadzin</div>
                        <div class="petugas-nama"><?= esc($petugas_jumat['muadzin_nama']) ?></div>
                    </div>
                </div>
            <?php else : ?>
                <!-- Tampilan Indah Jika Data Kosong -->
                <div class="text-center py-5">
                    <i class="fa-regular fa-calendar-times text-muted fs-1 mb-3 d-block"></i>
                    <h5 class="fw-bold text-dark">Jadwal Jumat Pekan Ini Belum Dirilis</h5>
                    <p class="text-muted">Hubungi sekretariat pengurus <?= site_name() ?> untuk info terupdate.</p>
                </div>
             <?php endif; ?>
        </div>
    </section>

    <!-- JADWAL PENGAJIAN & KAJIAN SECTION -->
    <section class="container my-5 py-4" id="kajian">
        <div class="text-center mb-5">
            <div class="petugas-role text-success fw-bold mb-2">Agenda Masjid</div>
            <h2 class="fw-bold font-heading">Jadwal Pengajian & Kajian Rutin</h2>
            <p class="text-muted mb-0">Ikuti kajian keagamaan, majelis ta'lim, dan tabligh akbar di masjid kami.</p>
        </div>

        <div class="row g-4 justify-content-center">
            <?php if (!empty($agenda_list)) : ?>
                <?php foreach ($agenda_list as $agenda) : ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden" style="transition: transform 0.2s ease;">
                            <div style="height: 180px; overflow: hidden; position: relative; background-color: var(--primary);">
                                <?php if (isset($agenda['banner']) && $agenda['banner']) : ?>
                                    <img src="<?= base_url('uploads/images/' . $agenda['banner']) ?>" class="w-100 h-100 object-fit-cover" alt="<?= esc($agenda['judul']) ?>">
                                <?php else : ?>
                                    <div class="w-100 h-100 d-flex flex-column align-items-center justify-content-center text-white-50">
                                        <i class="fa-solid fa-book-open-reader fs-1 mb-2 text-warning"></i>
                                        <small class="font-heading">Kajian <?= site_name() ?></small>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="card-body p-4">
                                <h5 class="fw-bold text-dark font-heading mb-3" style="font-size: 1.15rem;"><?= esc($agenda['judul']) ?></h5>
                                <ul class="list-unstyled mb-0 d-grid gap-2">
                                    <li class="d-flex align-items-start gap-2">
                                        <i class="fa-solid fa-user-tie text-success fs-6 mt-1" style="width: 20px;"></i>
                                        <div>
                                            <small class="text-muted d-block" style="font-size: 0.75rem;">Narasumber</small>
                                            <span class="fw-semibold text-dark" style="font-size: 0.9rem;"><?= esc($agenda['narasumber'] ?: '-') ?></span>
                                        </div>
                                    </li>
                                    <li class="d-flex align-items-start gap-2">
                                        <i class="fa-solid fa-calendar-day text-success fs-6 mt-1" style="width: 20px;"></i>
                                        <div>
                                            <small class="text-muted d-block" style="font-size: 0.75rem;">Waktu Pelaksanaan</small>
                                            <span class="text-dark" style="font-size: 0.9rem;"><?= esc(date('d/m/Y', strtotime($agenda['tanggal']))) ?> pukul <?= esc(date('H:i', strtotime($agenda['waktu']))) ?> WITA</span>
                                        </div>
                                    </li>
                                    <li class="d-flex align-items-start gap-2">
                                        <i class="fa-solid fa-location-dot text-danger fs-6 mt-1" style="width: 20px;"></i>
                                        <div>
                                            <small class="text-muted d-block" style="font-size: 0.75rem;">Tempat/Lokasi</small>
                                            <span class="text-dark" style="font-size: 0.9rem;"><?= esc($agenda['lokasi']) ?></span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="col-12 text-center py-5 text-muted">
                    <i class="fa-regular fa-calendar-minus fs-1 mb-3 text-muted"></i>
                    <p>Belum ada jadwal kajian terbaru saat ini.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- INFAK/DONASI SECTION -->
    <section class="container" id="donasi">
        <div class="infak-section">
            <div class="row align-items-center px-4 px-md-5">
                <div class="col-lg-7 mb-4 mb-lg-0">
                    <div class="petugas-role text-warning fw-bold mb-2">Penyaluran Amal</div>
                    <h2 class="fw-bold mb-3 font-heading">Kemudahan Berdonasi & Infak Digital</h2>
                    <p class="mb-4 opacity-90">Salurkan infak, shadaqah, dan zakat terbaik Anda secara praktis untuk mendukung operasional dakwah dan pemeliharaan fasilitas <?= site_name() ?>.</p>
                    <div class="d-flex flex-wrap gap-4">
                        <?php 
                        $hasTransfer = false;
                        if (!empty($rekening_list)): 
                            $borderIdx = 0;
                            foreach ($rekening_list as $rek): 
                                if ($rek['jenis'] !== 'transfer') continue;
                                $hasTransfer = true;
                                $borderStyle = ($borderIdx > 0) ? 'border-left: 1px solid rgba(255,255,255,0.2); padding-left: 20px;' : '';
                                $borderIdx++;
                        ?>
                            <div style="<?= $borderStyle ?>">
                                <i class="fa-solid fa-building-columns text-warning fs-3 mb-2 d-block"></i>
                                <strong><?= esc($rek['nama_bank']) ?></strong><br>
                                <span class="fs-5 font-heading"><?= esc($rek['nomor_rekening']) ?></span><br>
                                <small class="opacity-75">a.n. <?= esc($rek['atas_nama']) ?></small>
                            </div>
                        <?php 
                            endforeach; 
                        endif; 
                        
                        if (!$hasTransfer): // Fallback jika DB kosong
                        ?>
                            <div>
                                <i class="fa-solid fa-building-columns text-warning fs-3 mb-2 d-block"></i>
                                <strong>Bank Syariah Indonesia</strong><br>
                                <span class="fs-5 font-heading"><?= donation_bsi_number() ?></span><br>
                                <small class="opacity-75">a.n. <?= donation_bsi_holder() ?></small>
                            </div>
                            <div style="border-left: 1px solid rgba(255,255,255,0.2); padding-left: 20px;">
                                <i class="fa-solid fa-money-check-dollar text-warning fs-3 mb-2 d-block"></i>
                                <strong>Bank Sulselbar</strong><br>
                                <span class="fs-5 font-heading"><?= donation_sulselbar_number() ?></span><br>
                                <small class="opacity-75">a.n. <?= donation_sulselbar_holder() ?></small>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-lg-5 text-center">
                    <?php
                    $qrisChannel = null;
                    if (!empty($rekening_list)) {
                        foreach ($rekening_list as $rek) {
                            if ($rek['jenis'] === 'qris') {
                                $qrisChannel = $rek;
                                break;
                            }
                        }
                    }
                    
                    // Fallback values
                    $qrisImageUrl = qris_url();
                    $qrisTitle = 'QRIS INFAK MASJID';
                    
                    if ($qrisChannel) {
                        $qrisTitle = esc($qrisChannel['atas_nama']);
                        if (!empty($qrisChannel['logo']) && is_file(FCPATH . 'uploads/rekening/' . $qrisChannel['logo'])) {
                            // Jika ada file gambar QRIS di-upload oleh pengurus
                            $qrisImageUrl = base_url('uploads/rekening/' . $qrisChannel['logo']);
                        } else {
                            // Dinamis generate dari string payload QRIS di database
                            $payload = $qrisChannel['nomor_rekening'];
                            $qrisImageUrl = "https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=" . urlencode($payload);
                        }
                    }
                    ?>
                    <div class="qris-card">
                        <small class="text-muted fw-bold d-block mb-2 font-heading"><i class="fa-solid fa-qrcode me-1"></i> <?= esc($qrisTitle) ?></small>
                        <img class="qris-img" src="<?= $qrisImageUrl ?>" alt="QRIS Infaq">
                        <small class="text-muted d-block mt-2">Dukung Semua Aplikasi Dompet Digital</small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <h5 class="navbar-brand"><i class="fa-solid fa-mosque"></i> <?= site_name() ?></h5>
                    <p class="mt-3 opacity-75">Pusat digitalisasi keagamaan dan sarana transparansi publik untuk kemaslahatan jamaah.</p>
                    <div class="d-flex gap-3 fs-5 mt-4">
                        <a href="#"><i class="fa-brands fa-facebook"></i></a>
                        <a href="#"><i class="fa-brands fa-youtube"></i></a>
                        <a href="#"><i class="fa-brands fa-instagram"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <h5>Navigasi Halaman</h5>
                    <ul class="list-unstyled d-grid gap-2">
                        <li><a href="#jadwal"><i class="fa-solid fa-angle-right me-2 text-warning"></i>Jadwal Sholat</a></li>
                        <li><a href="#petugas-jumat"><i class="fa-solid fa-angle-right me-2 text-warning"></i>Petugas Salat Jumat</a></li>
                        <li><a href="#layanan"><i class="fa-solid fa-angle-right me-2 text-warning"></i>Pelayanan TPA / ZIS</a></li>
                        <li><a href="#donasi"><i class="fa-solid fa-angle-right me-2 text-warning"></i>QRIS Infak Digital</a></li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h5>Hubungi Kami</h5>
                    <p class="mb-2"><i class="fa-solid fa-location-dot me-2 text-warning"></i> <?= site_address() ?>.</p>
                    <p class="mb-2"><i class="fa-solid fa-phone me-2 text-warning"></i> <?= contact_phone() ?></p>
                    <p><i class="fa-solid fa-envelope me-2 text-warning"></i> <?= esc(contact_email()) ?></p>
                </div>
            </div>
            <hr class="mt-5 mb-4 border-secondary opacity-25">
            <div class="row text-center text-md-start">
                <div class="col-md-6 mb-2 mb-md-0">
                    &copy; 2026 <?= site_name() ?>. Hak Cipta Dilindungi.
                </div>
                <div class="col-md-6 text-md-end">
                    Dikembangkan oleh Pengurus <?= site_name() ?>.
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
