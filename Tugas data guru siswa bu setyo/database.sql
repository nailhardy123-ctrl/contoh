-- Database: `db_sekolah_bu_setyo`
-- Tugas Data Guru dan Siswa Bu Setyo

CREATE DATABASE IF NOT EXISTS `db_sekolah_bu_setyo` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `db_sekolah_bu_setyo`;

-- --------------------------------------------------------
-- Struktur dari tabel `siswa`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `siswa`;
CREATE TABLE `siswa` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Data awal untuk tabel `siswa`
-- --------------------------------------------------------
INSERT INTO `siswa` (`id`, `nisn`, `nis`, `nama`, `jenis_kelamin`, `kelas`, `jurusan`, `tempat_lahir`, `tanggal_lahir`, `telepon`, `email`, `alamat`) VALUES
(1, '0071234501', '21001', 'Ahmad Rizky Pratama', 'Laki-laki', 'XII RPL 1', 'Rekayasa Perangkat Lunak', 'Jakarta', '2007-04-12', '081234567801', 'ahmad.rizky@gmail.com', 'Jl. Merdeka No. 10, Jakarta'),
(2, '0071234502', '21002', 'Annisa Putri Cahyani', 'Perempuan', 'XII RPL 1', 'Rekayasa Perangkat Lunak', 'Bandung', '2007-08-25', '081234567802', 'annisa.putri@gmail.com', 'Jl. Sukajadi No. 45, Bandung'),
(3, '0081234503', '22015', 'Bima Arya Nugraha', 'Laki-laki', 'XI RPL 2', 'Rekayasa Perangkat Lunak', 'Semarang', '2008-01-15', '081234567803', 'bima.arya@gmail.com', 'Jl. Pahlawan No. 12, Semarang'),
(4, '0081234504', '22016', 'Dewi Anggraini', 'Perempuan', 'XI TKJ 1', 'Teknik Komputer dan Jaringan', 'Surabaya', '2008-06-19', '081234567804', 'dewi.ang@gmail.com', 'Jl. Pemuda No. 88, Surabaya'),
(5, '0091234505', '23030', 'Dimas Prasetyo', 'Laki-laki', 'X DKV 1', 'Desain Komunikasi Visual', 'Yogyakarta', '2009-11-03', '081234567805', 'dimas.prasetyo@gmail.com', 'Jl. Malioboro No. 5, Yogyakarta'),
(6, '0071234506', '21003', 'Fadhil Ramadhan', 'Laki-laki', 'XII RPL 1', 'Rekayasa Perangkat Lunak', 'Bogor', '2007-09-09', '081234567806', 'fadhil.r@gmail.com', 'Jl. Pajajaran No. 23, Bogor'),
(7, '0081234507', '22017', 'Nadia Syahla Maharani', 'Perempuan', 'XI RPL 1', 'Rekayasa Perangkat Lunak', 'Solo', '2008-03-30', '081234567807', 'nadia.syahla@gmail.com', 'Jl. Slamet Riyadi No. 71, Solo');

-- --------------------------------------------------------
-- Struktur dari tabel `guru`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `guru`;
CREATE TABLE `guru` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Data awal untuk tabel `guru`
-- --------------------------------------------------------
INSERT INTO `guru` (`id`, `nip`, `nama`, `gelar`, `mata_pelajaran`, `jenis_kelamin`, `status_kepegawaian`, `telepon`, `email`, `alamat`) VALUES
(1, '197508152002122001', 'Dra. Setyo Rahayu', 'M.Pd.', 'Pemrograman Web & Perangkat Bergerak', 'Perempuan', 'PNS', '081198765432', 'bu.setyo@sekolah.sch.id', 'Jl. Melati Raya No. 15, Blok C'),
(2, '198203102008011005', 'Budi Santoso', 'S.Kom., M.Cs.', 'Basis Data & Pemodelan RPL', 'Laki-laki', 'PNS', '081223344556', 'budi.santoso@sekolah.sch.id', 'Jl. Cendrawasih No. 22'),
(3, '199011242015032008', 'Siti Nurhaliza', 'S.Pd.', 'Matematika Terapan', 'Perempuan', 'PPPK', '081334455667', 'siti.nurhaliza@sekolah.sch.id', 'Jl. Flamboyan No. 8A'),
(4, '198705192010011012', 'Hendro Wicaksono', 'S.T., M.Kom.', 'Jaringan Komputer & Cyber Security', 'Laki-laki', 'PNS', '081445566778', 'hendro.w@sekolah.sch.id', 'Jl. Anggrek No. 104'),
(5, '199407182020122004', 'Ratna Kartika Dewi', 'S.Pd., M.Hum.', 'Bahasa Indonesia & Komunikasi Bisnis', 'Perempuan', 'Guru Tetap', '081556677889', 'ratna.kartika@sekolah.sch.id', 'Jl. Kenanga No. 19');

