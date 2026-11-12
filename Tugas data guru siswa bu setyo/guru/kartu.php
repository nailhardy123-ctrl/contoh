<?php
require_once __DIR__ . '/../config/database.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    header("Location: " . BASE_URL . "/guru/index.php");
    exit();
}

$query = mysqli_query($koneksi, "SELECT * FROM guru WHERE id = $id");
if (mysqli_num_rows($query) === 0) {
    header("Location: " . BASE_URL . "/guru/index.php");
    exit();
}

$guru = mysqli_fetch_assoc($query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Tenaga Pendidik - <?= htmlspecialchars($guru['nama']); ?></title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=Libre+Barcode+39+Text&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f1f5f9;
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .id-card {
            width: 440px;
            height: 275px;
            background: #ffffff;
            border-radius: 18px;
            box-shadow: 0 20px 40px -10px rgba(15, 23, 42, 0.2);
            position: relative;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .id-card-header {
            background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4338ca 100%);
            color: white;
            padding: 12px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 3px solid #10b981;
        }

        .id-card-body {
            padding: 14px 18px;
            display: flex;
            gap: 16px;
            align-items: center;
            flex-grow: 1;
        }

        .photo-box {
            width: 90px;
            height: 115px;
            background: linear-gradient(135deg, #4f46e5 0%, #059669 100%);
            border-radius: 12px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: white;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
            border: 2px solid #ffffff;
            flex-shrink: 0;
        }

        .id-card-footer {
            background-color: #f8fafc;
            border-top: 1px solid #e2e8f0;
            padding: 8px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.72rem;
            color: #64748b;
        }

        .barcode {
            font-family: 'Libre Barcode 39 Text', cursive;
            font-size: 26px;
            letter-spacing: 2px;
            color: #1e293b;
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
            .id-card {
                box-shadow: none !important;
                border: 1px solid #ccc;
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>

<div class="no-print mb-4 d-flex gap-2">
    <a href="<?= BASE_URL ?>/guru/detail.php?id=<?= $guru['id']; ?>" class="btn btn-secondary rounded-pill px-4">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Profil
    </a>
    <button onclick="window.print()" class="btn btn-primary rounded-pill px-4 shadow">
        <i class="bi bi-printer-fill me-1"></i> Cetak Kartu Pendidik
    </button>
</div>

<div class="id-card">
    <!-- Header -->
    <div class="id-card-header">
        <div class="d-flex align-items-center gap-2">
            <div style="width: 32px; height: 32px; background: rgba(255,255,255,0.2); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                <i class="bi bi-person-workspace text-white fs-6"></i>
            </div>
            <div>
                <div style="font-weight: 800; font-size: 0.85rem; letter-spacing: 0.02em;">SMK TEKNOLOGI NASIONAL</div>
                <div style="font-size: 0.65rem; color: #a7f3d0; font-weight: 600; text-transform: uppercase;">KARTU TENAGA PENDIDIK / GURU</div>
            </div>
        </div>
        <div class="text-end">
            <span class="badge bg-success text-white fw-bold rounded-pill" style="font-size: 0.65rem;">GURU</span>
        </div>
    </div>

    <!-- Body -->
    <div class="id-card-body">
        <div class="photo-box">
            <div class="display-6 fw-bold mb-1"><?= strtoupper(substr($guru['nama'], 0, 1)); ?></div>
            <span style="font-size: 0.6rem; opacity: 0.9;">GURU</span>
        </div>
        <div style="flex-grow: 1;">
            <div class="fw-bold text-dark text-truncate" style="font-size: 1.05rem; max-width: 260px;">
                <?= htmlspecialchars($guru['nama']); ?><?= !empty($guru['gelar']) ? ', ' . htmlspecialchars($guru['gelar']) : ''; ?>
            </div>
            <div class="text-primary fw-semibold small mb-2 font-monospace">
                NIP. <?= htmlspecialchars($guru['nip']); ?>
            </div>

            <table style="font-size: 0.75rem; width: 100%; color: #334155;">
                <tr>
                    <td style="width: 85px; color: #64748b;">Mata Pelajaran</td>
                    <td style="width: 10px;">:</td>
                    <td class="fw-bold text-dark"><?= htmlspecialchars($guru['mata_pelajaran']); ?></td>
                </tr>
                <tr>
                    <td style="color: #64748b;">Status</td>
                    <td>:</td>
                    <td class="fw-semibold text-success"><?= htmlspecialchars($guru['status_kepegawaian']); ?></td>
                </tr>
                <tr>
                    <td style="color: #64748b;">Jenis Kelamin</td>
                    <td>:</td>
                    <td><?= htmlspecialchars($guru['jenis_kelamin']); ?></td>
                </tr>
                <tr>
                    <td style="color: #64748b;">No. Telepon</td>
                    <td>:</td>
                    <td><?= !empty($guru['telepon']) ? htmlspecialchars($guru['telepon']) : '-'; ?></td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Footer -->
    <div class="id-card-footer">
        <div>
            <span class="d-block text-muted" style="font-size: 0.62rem;">Identitas Resmi Tenaga Pendidik</span>
            <div class="barcode">*<?= htmlspecialchars($guru['nip']); ?>*</div>
        </div>
        <div class="text-end" style="line-height: 1.2;">
            <span class="d-block" style="font-size: 0.62rem;">Pengesahan:</span>
            <strong style="font-size: 0.72rem; color: #1e293b;">Dra. Setyo Rahayu, M.Pd.</strong>
        </div>
    </div>
</div>

</body>
</html>

