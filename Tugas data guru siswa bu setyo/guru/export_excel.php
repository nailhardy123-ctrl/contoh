<?php
require_once __DIR__ . '/../config/database.php';

$filename = "Data_Guru_Bu_Setyo_" . date('Ymd_His') . ".xls";

header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Pragma: no-cache");
header("Expires: 0");

$sql = "SELECT * FROM guru ORDER BY nama ASC";
$result = mysqli_query($koneksi, $sql);
?>
<table border="1">
    <thead>
        <tr style="background-color: #4f46e5; color: #ffffff; font-weight: bold; text-align: center;">
            <th colspan="8" style="font-size: 14pt; padding: 10px;">LAPORAN DATA TENAGA PENDIDIK (GURU)</th>
        </tr>
        <tr style="background-color: #f1f5f9; font-weight: bold;">
            <th>No</th>
            <th>NIP</th>
            <th>Nama Lengkap</th>
            <th>Gelar</th>
            <th>Mata Pelajaran</th>
            <th>Jenis Kelamin</th>
            <th>Status Kepegawaian</th>
            <th>No. Telepon</th>
            <th>Email</th>
            <th>Alamat</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td style="text-align: center;"><?= $no++; ?></td>
                <td style="mso-number-format:'\@';"><?= htmlspecialchars($row['nip']); ?></td>
                <td><?= htmlspecialchars($row['nama']); ?></td>
                <td><?= htmlspecialchars($row['gelar'] ?? ''); ?></td>
                <td><?= htmlspecialchars($row['mata_pelajaran']); ?></td>
                <td><?= htmlspecialchars($row['jenis_kelamin']); ?></td>
                <td><?= htmlspecialchars($row['status_kepegawaian']); ?></td>
                <td style="mso-number-format:'\@';"><?= htmlspecialchars($row['telepon'] ?? ''); ?></td>
                <td><?= htmlspecialchars($row['email'] ?? ''); ?></td>
                <td><?= htmlspecialchars($row['alamat'] ?? ''); ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

