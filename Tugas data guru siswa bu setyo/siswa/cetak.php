<?php
require_once __DIR__ . '/../config/database.php';

$jurusan_filter = isset($_GET['jurusan']) ? trim($_GET['jurusan']) : '';
$kelas_filter = isset($_GET['kelas']) ? trim($_GET['kelas']) : '';

$sql = "SELECT * FROM siswa WHERE 1=1";
if (!empty($jurusan_filter)) {
    $jurusan_escaped = mysqli_real_escape_string($koneksi, $jurusan_filter);
    $sql .= " AND jurusan = '$jurusan_escaped'";
}
if (!empty($kelas_filter)) {
    $kelas_escaped = mysqli_real_escape_string($koneksi, $kelas_filter);
    $sql .= " AND kelas LIKE '%$kelas_escaped%'";
}
$sql .= " ORDER BY kelas ASC, nama ASC";
$result = mysqli_query($koneksi, $sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Data Siswa - Tugas Bu Setyo</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8fafc;
            color: #0f172a;
            font-family: 'Plus Jakarta Sans', -apple-system, sans-serif;
            font-size: 11pt;
            padding: 30px;
        }

        .paper-sheet {
            background: white;
            max-width: 900px;
            margin: 0 auto;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            border-radius: 12px;
        }

        .kop-surat {
            border-bottom: 3px double #0f172a;
            padding-bottom: 15px;
            margin-bottom: 25px;
            position: relative;
        }

        .table-print {
            width: 100%;
            border-collapse: collapse;
        }

        .table-print th, .table-print td {
            border: 1px solid #334155;
            padding: 9px 12px;
            font-size: 10pt;
        }

        .table-print th {
            background-color: #f1f5f9 !important;
            color: #0f172a;
            font-weight: 700;
            text-align: center;
        }

        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background: white !important;
                padding: 0;
                margin: 0;
            }
            .paper-sheet {
                box-shadow: none !important;
                padding: 0 !important;
                max-width: 100% !important;
            }
        }
    </style>
</head>
<body>

<!-- Tombol Aksi di Layar -->
<div class="no-print max-w-900 mx-auto mb-4" style="max-width: 900px; margin: 0 auto 20px auto;">
    <div class="d-flex justify-content-between align-items-center bg-white p-3 rounded-4 shadow-sm border">
        <div class="d-flex align-items-center gap-2">
            <a href="<?= BASE_URL ?>/siswa/index.php" class="btn btn-outline-secondary rounded-pill px-3">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Data Siswa
            </a>
            <span class="text-muted small">Pratinjau Cetak Dokumen Resmi</span>
        </div>
        <div class="d-flex gap-2">
            <button onclick="window.print()" class="btn btn-primary rounded-pill px-4 shadow-sm">
                <i class="bi bi-printer-fill me-1"></i> Cetak / Simpan PDF
            </button>
        </div>
    </div>
</div>

<div class="paper-sheet">
    <!-- Kop Surat Resmi -->
    <div class="kop-surat text-center">
        <h5 class="fw-bold mb-1 text-uppercase text-secondary" style="letter-spacing: 1px; font-size: 11pt;">PEMERINTAH DAERAH PROVINSI &bull; DINAS PENDIDIKAN</h5>
        <h3 class="fw-bold mb-1 text-uppercase text-dark" style="letter-spacing: 0.5px;">SMK TEKNOLOGI NASIONAL INDONESIA</h3>
        <p class="mb-0 text-muted" style="font-size: 9pt;">
            Komplek Pendidikan Terpadu No. 45 &bull; Telepon: (021) 7891234 &bull; Email: akademik@smkteknas.sch.id &bull; Website: smkteknas.sch.id
        </p>
    </div>

    <!-- Judul Laporan -->
    <div class="text-center mb-4">
        <h5 class="fw-bold text-uppercase mb-1" style="text-decoration: underline; letter-spacing: 0.5px;">LAPORAN DATA PESERTA DIDIK / SISWA</h5>
        <small class="text-muted">
            Tanggal Cetak: <strong><?= date('d F Y'); ?></strong> <?= !empty($jurusan_filter) ? ' | Jurusan: <strong>' . htmlspecialchars($jurusan_filter) . '</strong>' : ''; ?>
        </small>
    </div>

    <!-- Tabel Cetak -->
    <table class="table-print mb-4">
        <thead>
            <tr>
                <th style="width: 35px;">No</th>
                <th style="width: 110px;">NISN</th>
                <th style="width: 70px;">NIS</th>
                <th>Nama Lengkap Siswa</th>
                <th style="width: 45px;">L/P</th>
                <th style="width: 80px;">Kelas</th>
                <th>Konsentrasi Keahlian</th>
                <th>No. Telepon</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php $no = 1; while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td class="text-center"><?= $no++; ?></td>
                        <td class="text-center font-monospace"><?= htmlspecialchars($row['nisn']); ?></td>
                        <td class="text-center font-monospace"><?= htmlspecialchars($row['nis']); ?></td>
                        <td class="fw-bold"><?= htmlspecialchars($row['nama']); ?></td>
                        <td class="text-center"><?= $row['jenis_kelamin'] == 'Laki-laki' ? 'L' : 'P'; ?></td>
                        <td class="text-center"><?= htmlspecialchars($row['kelas']); ?></td>
                        <td><?= htmlspecialchars($row['jurusan']); ?></td>
                        <td><?= !empty($row['telepon']) ? htmlspecialchars($row['telepon']) : '-'; ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center py-3">Tidak ada data siswa yang tercatat.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Kolom Tanda Tangan -->
    <div class="row mt-5 pt-4">
        <div class="col-7">
            <small class="text-muted d-block font-monospace">Dokumen dicetak otomatis oleh SIAKAD Pro &bull; <?= date('Y-m-d H:i:s'); ?></small>
        </div>
        <div class="col-5 text-center">
            <p class="mb-1">Mengetahui,</p>
            <p class="mb-5 fw-bold">Guru Pembimbing / Pengampu</p>
            <br><br>
            <p class="mb-0 fw-bold" style="text-decoration: underline; font-size: 11pt;">Dra. Setyo Rahayu, M.Pd.</p>
            <small class="d-block text-muted font-monospace">NIP. 19750815 200212 2 001</small>
        </div>
    </div>
</div>

</body>
</html>
