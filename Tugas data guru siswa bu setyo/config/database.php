<?php
// Konfigurasi Database
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'db_sekolah_bu_setyo';

// Nonaktifkan pelaporan error bawaan mysqli agar bisa kita tangani dengan rapi
mysqli_report(MYSQLI_REPORT_OFF);

// Koneksi awal ke server MySQL
$koneksi = @mysqli_connect($db_host, $db_user, $db_pass);

if (!$koneksi) {
    // Tampilan pesan error yang informatif dan elegan jika MySQL belum menyala di Laragon
    $error_msg = mysqli_connect_error();
    ?>
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Koneksi Database Gagal - Tugas Bu Setyo</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    </head>
    <body class="bg-light d-flex align-items-center min-vh-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7 col-lg-6">
                    <div class="card shadow-lg border-0 rounded-4">
                        <div class="card-body p-5 text-center">
                            <div class="display-1 text-danger mb-3">
                                <i class="bi bi-database-fill-slash"></i>
                            </div>
                            <h3 class="fw-bold text-dark mb-2">MySQL Belum Berjalan</h3>
                            <p class="text-muted mb-4">
                                Aplikasi tidak dapat terhubung ke server database MySQL.<br>
                                Detail error: <code class="text-danger"><?= htmlspecialchars($error_msg); ?></code>
                            </p>
                            <div class="alert alert-info text-start small mb-4">
                                <strong class="d-block mb-1"><i class="bi bi-lightbulb-fill"></i> Cara Mengatasi di Laragon:</strong>
                                <ol class="mb-0 ps-3">
                                    <li>Buka aplikasi <strong>Laragon</strong> di laptop/komputer Anda.</li>
                                    <li>Klik tombol <strong>"Start All"</strong> untuk menyalakan Apache dan MySQL.</li>
                                    <li>Muat ulang (refresh) halaman ini di browser.</li>
                                </ol>
                            </div>
                            <button onclick="window.location.reload();" class="btn btn-primary px-4 py-2 rounded-pill shadow-sm">
                                <i class="bi bi-arrow-clockwise me-1"></i> Coba Refresh Halaman
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    </html>
    <?php
    exit();
}

// Cek apakah database sudah ada, jika belum otomatis buatkan
$db_check = @mysqli_select_db($koneksi, $db_name);
if (!$db_check) {
    // Buat database jika belum ada
    $create_db = mysqli_query($koneksi, "CREATE DATABASE IF NOT EXISTS `$db_name` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    if ($create_db) {
        mysqli_select_db($koneksi, $db_name);
        
        // Buat tabel siswa
        $sql_siswa = "CREATE TABLE IF NOT EXISTS `siswa` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `nisn` VARCHAR(20) NOT NULL UNIQUE,
            `nis` VARCHAR(20) NOT NULL UNIQUE,
            `nama` VARCHAR(100) NOT NULL,
            `jenis_kelamin` ENUM('Laki-laki', 'Perempuan') NOT NULL,
            `kelas` VARCHAR(20) NOT NULL,
            `jurusan` VARCHAR(50) NOT NULL,
            `tempat_lahir` VARCHAR(50) DEFAULT NULL,
            `tanggal_lahir` DATE DEFAULT NULL,
            `telepon` VARCHAR(20) DEFAULT NULL,
            `email` VARCHAR(100) DEFAULT NULL,
            `alamat` TEXT DEFAULT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        mysqli_query($koneksi, $sql_siswa);

        // Buat tabel guru
        $sql_guru = "CREATE TABLE IF NOT EXISTS `guru` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `nip` VARCHAR(30) NOT NULL UNIQUE,
            `nama` VARCHAR(100) NOT NULL,
            `gelar` VARCHAR(30) DEFAULT NULL,
            `mata_pelajaran` VARCHAR(100) NOT NULL,
            `jenis_kelamin` ENUM('Laki-laki', 'Perempuan') NOT NULL,
            `status_kepegawaian` ENUM('PNS', 'PPPK', 'Guru Tetap', 'Guru Honorer') NOT NULL DEFAULT 'Guru Tetap',
            `telepon` VARCHAR(20) DEFAULT NULL,
            `email` VARCHAR(100) DEFAULT NULL,
            `alamat` TEXT DEFAULT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        mysqli_query($koneksi, $sql_guru);

        // Masukkan data awal siswa jika kosong
        $cek_siswa = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM `siswa`");
        $row_s = mysqli_fetch_assoc($cek_siswa);
        if ($row_s['total'] == 0) {
            $insert_siswa = "INSERT INTO `siswa` (`nisn`, `nis`, `nama`, `jenis_kelamin`, `kelas`, `jurusan`, `tempat_lahir`, `tanggal_lahir`, `telepon`, `email`, `alamat`) VALUES
            ('0071234501', '21001', 'Ahmad Rizky Pratama', 'Laki-laki', 'XII RPL 1', 'Rekayasa Perangkat Lunak', 'Jakarta', '2007-04-12', '081234567801', 'ahmad.rizky@gmail.com', 'Jl. Merdeka No. 10, Jakarta'),
            ('0071234502', '21002', 'Annisa Putri Cahyani', 'Perempuan', 'XII RPL 1', 'Rekayasa Perangkat Lunak', 'Bandung', '2007-08-25', '081234567802', 'annisa.putri@gmail.com', 'Jl. Sukajadi No. 45, Bandung'),
            ('0081234503', '22015', 'Bima Arya Nugraha', 'Laki-laki', 'XI RPL 2', 'Rekayasa Perangkat Lunak', 'Semarang', '2008-01-15', '081234567803', 'bima.arya@gmail.com', 'Jl. Pahlawan No. 12, Semarang'),
            ('0081234504', '22016', 'Dewi Anggraini', 'Perempuan', 'XI TKJ 1', 'Teknik Komputer dan Jaringan', 'Surabaya', '2008-06-19', '081234567804', 'dewi.ang@gmail.com', 'Jl. Pemuda No. 88, Surabaya'),
            ('0091234505', '23030', 'Dimas Prasetyo', 'Laki-laki', 'X DKV 1', 'Desain Komunikasi Visual', 'Yogyakarta', '2009-11-03', '081234567805', 'dimas.prasetyo@gmail.com', 'Jl. Malioboro No. 5, Yogyakarta'),
            ('0071234506', '21003', 'Fadhil Ramadhan', 'Laki-laki', 'XII RPL 1', 'Rekayasa Perangkat Lunak', 'Bogor', '2007-09-09', '081234567806', 'fadhil.r@gmail.com', 'Jl. Pajajaran No. 23, Bogor'),
            ('0081234507', '22017', 'Nadia Syahla Maharani', 'Perempuan', 'XI RPL 1', 'Rekayasa Perangkat Lunak', 'Solo', '2008-03-30', '081234567807', 'nadia.syahla@gmail.com', 'Jl. Slamet Riyadi No. 71, Solo');";
            mysqli_query($koneksi, $insert_siswa);
        }

        // Masukkan data awal guru jika kosong
        $cek_guru = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM `guru`");
        $row_g = mysqli_fetch_assoc($cek_guru);
        if ($row_g['total'] == 0) {
            $insert_guru = "INSERT INTO `guru` (`nip`, `nama`, `gelar`, `mata_pelajaran`, `jenis_kelamin`, `status_kepegawaian`, `telepon`, `email`, `alamat`) VALUES
            ('197508152002122001', 'Dra. Setyo Rahayu', 'M.Pd.', 'Pemrograman Web & Perangkat Bergerak', 'Perempuan', 'PNS', '081198765432', 'bu.setyo@sekolah.sch.id', 'Jl. Melati Raya No. 15, Blok C'),
            ('198203102008011005', 'Budi Santoso', 'S.Kom., M.Cs.', 'Basis Data & Pemodelan RPL', 'Laki-laki', 'PNS', '081223344556', 'budi.santoso@sekolah.sch.id', 'Jl. Cendrawasih No. 22'),
            ('199011242015032008', 'Siti Nurhaliza', 'S.Pd.', 'Matematika Terapan', 'Perempuan', 'PPPK', '081334455667', 'siti.nurhaliza@sekolah.sch.id', 'Jl. Flamboyan No. 8A'),
            ('198705192010011012', 'Hendro Wicaksono', 'S.T., M.Kom.', 'Jaringan Komputer & Cyber Security', 'Laki-laki', 'PNS', '081445566778', 'hendro.w@sekolah.sch.id', 'Jl. Anggrek No. 104'),
            ('199407182020122004', 'Ratna Kartika Dewi', 'S.Pd., M.Hum.', 'Bahasa Indonesia & Komunikasi Bisnis', 'Perempuan', 'Guru Tetap', '081556677889', 'ratna.kartika@sekolah.sch.id', 'Jl. Kenanga No. 19');";
            mysqli_query($koneksi, $insert_guru);
        }
    }
}

// Mulai session jika belum dimulai (untuk flash alert sukses/gagal)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Base URL helper dinamis yang mendukung localhost/subfolder maupun virtual host Laragon (.test)
$project_dir = 'Tugas data guru siswa bu setyo';
$script_path = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
$pos = stripos($script_path, '/' . $project_dir);

if ($pos !== false) {
    $base_url = substr($script_path, 0, $pos + strlen($project_dir) + 1);
} else {
    $base_url = '';
}

if (!defined('BASE_URL')) {
    define('BASE_URL', rtrim($base_url, '/'));
}
?>
