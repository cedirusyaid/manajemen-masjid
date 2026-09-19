<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LPJ Penerimaan Bantuan - <?= esc($kegiatan['nama_kegiatan']) ?></title>
    <!-- Google Fonts: Inter & Outfit -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            color: #111827;
            background-color: #f3f4f6;
            padding: 40px 20px;
        }

        .paper-container {
            max-width: 850px;
            margin: 0 auto;
            background: #ffffff;
            padding: 50px 60px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .report-header {
            text-align: center;
            border-bottom: 3px double #1f2937;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .report-title-main {
            font-family: 'Outfit', sans-serif;
            font-size: 1.4rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .report-title-sub {
            font-size: 1.15rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 2px;
            text-transform: uppercase;
        }

        .report-title-org {
            font-size: 1.1rem;
            font-weight: 700;
            color: #064e3b;
            text-transform: uppercase;
        }

        .report-date {
            font-size: 0.95rem;
            color: #4b5563;
            margin-top: 10px;
            font-style: italic;
        }

        .section-title {
            font-size: 1.05rem;
            font-weight: 700;
            color: #111827;
            margin-top: 25px;
            margin-bottom: 12px;
            padding-bottom: 6px;
            border-bottom: 1px solid #e5e7eb;
        }

        .table-custom {
            width: 100%;
            margin-bottom: 25px;
            border: 1px solid #374151;
        }

        .table-custom th {
            background-color: #f9fafb;
            color: #111827;
            font-weight: 600;
            text-align: center;
            vertical-align: middle;
            border: 1px solid #374151;
            padding: 8px 10px;
            font-size: 0.875rem;
        }

        .table-custom td {
            border: 1px solid #374151;
            padding: 8px 10px;
            font-size: 0.875rem;
            vertical-align: middle;
        }

        .table-custom .total-row {
            background-color: #f9fafb;
            font-weight: 700;
        }

        .grand-total-box {
            background-color: #f0fdf4;
            border: 2px solid #059669;
            border-radius: 8px;
            padding: 16px 20px;
            text-align: center;
            margin: 30px 0;
        }

        .grand-total-val {
            font-size: 1.6rem;
            font-weight: 800;
            color: #064e3b;
        }

        .grand-total-terbilang {
            font-style: italic;
            color: #374151;
            font-size: 0.95rem;
            margin-top: 4px;
        }

        .signature-section {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .signature-box {
            text-align: center;
            width: 250px;
        }

        .signature-space {
            height: 70px;
        }

        .signature-name {
            font-weight: 700;
            text-decoration: underline;
            margin-bottom: 2px;
        }

        .signature-role {
            font-size: 0.875rem;
            color: #4b5563;
        }

        .no-print {
            margin-bottom: 20px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        @media print {
            body {
                background: #ffffff;
                padding: 0;
            }
            .paper-container {
                box-shadow: none;
                padding: 0;
                max-width: 100%;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>

    <div class="paper-container">
        <!-- Action Toolbar (No Print) -->
        <div class="no-print">
            <a href="<?= base_url('dashboard/kepanitiaan/detail/' . $kegiatan['id']) ?>" class="btn btn-outline-secondary btn-sm">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Kegiatan
            </a>
            <button onclick="window.print()" class="btn btn-primary btn-sm">
                <i class="fa-solid fa-print me-1"></i> Cetak / Simpan PDF
            </button>
        </div>

        <!-- Header Laporan -->
        <div class="report-header">
            <div class="report-title-main">LAPORAN PERTANGGUNGJAWABAN</div>
            <div class="report-title-sub">PENERIMAAN BANTUAN KEUANGAN DAN MATERIAL</div>
            <div class="report-title-org"><?= strtoupper(esc($kegiatan['nama_kegiatan'])) ?></div>
            <div class="report-date">
                <strong>Per Tanggal:</strong> <?= date('d F Y', strtotime($tanggal_cetak)) ?>
            </div>
        </div>

        <!-- I. Bantuan Material (Nontunai) -->
        <div class="section-title">
            I. Rincian Penerimaan Bantuan Material (Nontunai)
        </div>
        <table class="table-custom">
            <thead>
                <tr>
                    <th style="width: 5%;">No.</th>
                    <th style="width: 32%;">Uraian Material / Barang</th>
                    <th style="width: 18%;">Volume / Satuan</th>
                    <th style="width: 18%;">Harga Satuan (Rp)</th>
                    <th style="width: 18%;">Total Nilai (Rp)</th>
                    <th style="width: 25%;">Keterangan / Sumber</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($material_list)): ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-3">Belum ada catatan bantuan material/barang.</td>
                    </tr>
                <?php else: ?>
                    <?php $no = 1; foreach ($material_list as $m): ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?>.</td>
                            <td><strong><?= esc($m['uraian_material']) ?></strong></td>
                            <td class="text-center"><?= number_format($m['volume'], 0, ',', '.') ?> <?= esc($m['satuan']) ?></td>
                            <td class="text-end"><?= number_format($m['harga_satuan'], 0, ',', '.') ?></td>
                            <td class="text-end"><strong><?= number_format($m['total_nilai'], 0, ',', '.') ?></strong></td>
                            <td><?= esc($m['nama_donatur']) ?><?= !empty($m['keterangan']) ? ' (' . esc($m['keterangan']) . ')' : '' ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                <tr class="total-row">
                    <td colspan="4" class="text-center"><strong>TOTAL NILAI MATERIAL & BARANG</strong></td>
                    <td class="text-end"><strong>Rp<?= number_format($total_nilai_material, 0, ',', '.') ?></strong></td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <!-- II. Bantuan Keuangan (Dana Masuk) -->
        <div class="section-title">
            II. Rincian Penerimaan Bantuan Keuangan (Dana Masuk)
        </div>
        <table class="table-custom">
            <thead>
                <tr>
                    <th style="width: 5%;">No.</th>
                    <th style="width: 50%;">Sumber / Rincian Penerimaan</th>
                    <th style="width: 25%;">Kanal Pembayaran / Media</th>
                    <th style="width: 20%;">Jumlah Nominal (Rp)</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($keuangan_masuk)): ?>
                    <tr>
                        <td colspan="4" class="text-center text-muted py-3">Belum ada catatan penerimaan uang masuk.</td>
                    </tr>
                <?php else: ?>
                    <?php $no = 1; foreach ($keuangan_masuk as $km): ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?>.</td>
                            <td>
                                <strong><?= esc($km['nama_donatur'] ?: $km['keterangan']) ?></strong>
                                <?php if (!empty($km['nama_donatur']) && $km['nama_donatur'] !== $km['keterangan']): ?>
                                    <br><small class="text-muted"><?= esc($km['keterangan']) ?></small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!empty($km['nama_bank'])): ?>
                                    Rekening <?= esc($km['nama_bank']) ?>
                                <?php elseif ($km['metode_pembayaran'] === 'tunai'): ?>
                                    Tunai (Kas Langsung)
                                <?php elseif ($km['metode_pembayaran'] === 'qris'): ?>
                                    QRIS
                                <?php else: ?>
                                    Transfer Bank
                                <?php endif; ?>
                            </td>
                            <td class="text-end"><strong>Rp<?= number_format($km['nominal'], 0, ',', '.') ?></strong></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                <tr class="total-row">
                    <td colspan="3" class="text-center"><strong>TOTAL DANA UANG MASUK</strong></td>
                    <td class="text-end"><strong>Rp<?= number_format($total_dana_masuk, 0, ',', '.') ?></strong></td>
                </tr>
            </tbody>
        </table>

        <!-- III. Grand Total Box -->
        <div class="grand-total-box">
            <div style="font-weight: 600; text-transform: uppercase; font-size: 0.95rem; color: #064e3b; margin-bottom: 2px;">
                III. Total Nilai Keseluruhan (Material & Dana Masuk)
            </div>
            <div class="grand-total-val">
                Rp<?= number_format($grand_total, 0, ',', '.') ?>
            </div>
            <div class="grand-total-terbilang">
                (<?= esc($grand_total_terbilang) ?> Rupiah)
            </div>
        </div>

        <!-- Tanda Tangan LPJ -->
        <div class="signature-section">
            <div class="signature-box">
                <div>Mengetahui,</div>
                <div class="fw-semibold">Ketua Panitia Pembangunan</div>
                <div class="signature-space"></div>
                <div class="signature-name"><?= esc($ketua_panitia['nama_personil'] ?? 'Andi Alfian') ?></div>
                <div class="signature-role"><?= esc($kegiatan['nama_kegiatan']) ?></div>
            </div>

            <div class="signature-box">
                <div>Sinjai, <?= date('d F Y', strtotime($tanggal_cetak)) ?></div>
                <div class="fw-semibold">Bendahara Umum Pembangunan</div>
                <div class="signature-space"></div>
                <div class="signature-name"><?= esc($bendahara_panitia['nama_personil'] ?? 'Jumuati Syuyuti, S.Kep., Ns.') ?></div>
                <div class="signature-role"><?= esc($kegiatan['nama_kegiatan']) ?></div>
            </div>
        </div>
    </div>

</body>
</html>
