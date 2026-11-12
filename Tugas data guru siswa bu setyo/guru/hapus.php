<?php
require_once __DIR__ . '/../config/database.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    // Ambil nama guru untuk pesan konfirmasi
    $cek = mysqli_query($koneksi, "SELECT nama FROM guru WHERE id = $id");
    if ($row = mysqli_fetch_assoc($cek)) {
        $nama_guru = $row['nama'];
        $hapus = mysqli_query($koneksi, "DELETE FROM guru WHERE id = $id");
        if ($hapus) {
            $_SESSION['pesan'] = "Data guru <strong>" . htmlspecialchars($nama_guru) . "</strong> berhasil dihapus.";
            $_SESSION['tipe_pesan'] = "success";
        } else {
            $_SESSION['pesan'] = "Gagal menghapus data guru: " . mysqli_error($koneksi);
            $_SESSION['tipe_pesan'] = "danger";
        }
    } else {
        $_SESSION['pesan'] = "Data guru tidak ditemukan.";
        $_SESSION['tipe_pesan'] = "warning";
    }
}

header("Location: " . BASE_URL . "/guru/index.php");
exit();

