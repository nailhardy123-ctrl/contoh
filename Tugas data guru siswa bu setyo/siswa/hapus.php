<?php
require_once __DIR__ . '/../config/database.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    $cek = mysqli_query($koneksi, "SELECT nama FROM siswa WHERE id = $id");
    if ($row = mysqli_fetch_assoc($cek)) {
        $nama_siswa = $row['nama'];
        $hapus = mysqli_query($koneksi, "DELETE FROM siswa WHERE id = $id");
        if ($hapus) {
            $_SESSION['pesan'] = "Data siswa <strong>" . htmlspecialchars($nama_siswa) . "</strong> berhasil dihapus.";
            $_SESSION['tipe_pesan'] = "success";
        } else {
            $_SESSION['pesan'] = "Gagal menghapus data siswa: " . mysqli_error($koneksi);
            $_SESSION['tipe_pesan'] = "danger";
        }
    } else {
        $_SESSION['pesan'] = "Data siswa tidak ditemukan.";
        $_SESSION['tipe_pesan'] = "warning";
    }
}

header("Location: " . BASE_URL . "/siswa/index.php");
exit();

