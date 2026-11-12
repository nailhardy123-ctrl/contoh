<?php
require_once __DIR__ . '/../config/database.php';

$filename = "Data_Siswa_Bu_Setyo_" . date('Ymd_His') . ".xls";

header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Pragma: no-cache");
header("Expires: 0");

$sql = "SELECT * FROM siswa ORDER BY kelas ASC, nama ASC";
$result = mysqli_query($koneksi, $sql);
?>
<table border="1">
    <thead>
        <tr style="background-color: #0284c7; color: #ffffff; font-weight: bold; text-align: center;">
            <th colspan="10" style="font-size: 14pt; padding: 10px;">LAPORAN DATA PESERTA DIDIK (SISWA)</th>
        </tr>
        <tr style="background-color: #f1f5f9; font-weight: bold;">
            <th>No</th>
            <th>NISN</th>
            <th>NIS</th>
            <th>Nama Lengkap</th>
            <th>Jenis Kelamin</th>
            <th>Kelas</th>
            <th>Jurusan</th>
            <th>Tempat Lahir</th>
            <th>Tanggal Lahir</th>
            <th>No. Telepon</th>
            <th>Email</th>
            <th>Alamat</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td style="text-align: center;"><?= $no++; ?></td>
                <td style="mso-number-format:'\@';"><?= htmlspecialchars($row['nisn']); ?></td>
                <td style="mso-number-format:'\@';"><?= htmlspecialchars($row['nis']); ?></td>
                <td><?= htmlspecialchars($row['nama']); ?></td>
                <td><?= htmlspecialchars($row['jenis_kelamin']); ?></td>
                <td><?= htmlspecialchars($row['kelas']); ?></td>
                <td><?= htmlspecialchars($row['jurusan']); ?></td>
                <td><?= htmlspecialchars($row['tempat_lahir'] ?? ''); ?></td>
                <td><?= !empty($row['tanggal_lahir']) ? date('d/m/Y', strtotime($row['tanggal_lahir'])) : ''; ?></td>
                <td style="mso-number-format:'\@';"><?= htmlspecialchars($row['telepon'] ?? ''); ?></td>
                <td><?= htmlspecialchars($row['email'] ?? ''); ?></td>
                <td><?= htmlspecialchars($row['alamat'] ?? ''); ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

