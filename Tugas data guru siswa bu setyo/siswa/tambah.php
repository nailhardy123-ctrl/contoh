<?php
require_once __DIR__ . '/../config/database.php';

$page_title = 'Tambah Siswa Baru';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nisn = trim($_POST['nisn'] ?? '');
    $nis = trim($_POST['nis'] ?? '');
    $nama = trim($_POST['nama'] ?? '');
    $jenis_kelamin = trim($_POST['jenis_kelamin'] ?? '');
    $kelas = trim($_POST['kelas'] ?? '');
    $jurusan = trim($_POST['jurusan'] ?? '');
    $tempat_lahir = trim($_POST['tempat_lahir'] ?? '');
    $tanggal_lahir = trim($_POST['tanggal_lahir'] ?? '');
    $telepon = trim($_POST['telepon'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $alamat = trim($_POST['alamat'] ?? '');

    // Validasi input
    if (empty($nisn) || empty($nis) || empty($nama) || empty($jenis_kelamin) || empty($kelas) || empty($jurusan)) {
        $error = 'Harap lengkapi semua bidang yang bertanda wajib (*)!';
    } else {
        // Cek duplikasi NISN
        $nisn_escaped = mysqli_real_escape_string($koneksi, $nisn);
        $cek_nisn = mysqli_query($koneksi, "SELECT id FROM siswa WHERE nisn = '$nisn_escaped'");
        if (mysqli_num_rows($cek_nisn) > 0) {
            $error = 'NISN <strong>' . htmlspecialchars($nisn) . '</strong> sudah terdaftar dalam sistem!';
        } else {
            // Cek duplikasi NIS
            $nis_escaped = mysqli_real_escape_string($koneksi, $nis);
            $cek_nis = mysqli_query($koneksi, "SELECT id FROM siswa WHERE nis = '$nis_escaped'");
            if (mysqli_num_rows($cek_nis) > 0) {
                $error = 'NIS <strong>' . htmlspecialchars($nis) . '</strong> sudah digunakan oleh siswa lain!';
            } else {
                // Escape input
                $nama_escaped = mysqli_real_escape_string($koneksi, $nama);
                $jk_escaped = mysqli_real_escape_string($koneksi, $jenis_kelamin);
                $kelas_escaped = mysqli_real_escape_string($koneksi, $kelas);
                $jurusan_escaped = mysqli_real_escape_string($koneksi, $jurusan);
                $tl_escaped = mysqli_real_escape_string($koneksi, $tempat_lahir);
                $tgl_escaped = !empty($tanggal_lahir) ? "'$tanggal_lahir'" : "NULL";
                $telp_escaped = mysqli_real_escape_string($koneksi, $telepon);
                $email_escaped = mysqli_real_escape_string($koneksi, $email);
                $alamat_escaped = mysqli_real_escape_string($koneksi, $alamat);

                $insert_query = "INSERT INTO siswa (nisn, nis, nama, jenis_kelamin, kelas, jurusan, tempat_lahir, tanggal_lahir, telepon, email, alamat)
                                 VALUES ('$nisn_escaped', '$nis_escaped', '$nama_escaped', '$jk_escaped', '$kelas_escaped', '$jurusan_escaped', '$tl_escaped', $tgl_escaped, '$telp_escaped', '$email_escaped', '$alamat_escaped')";

                if (mysqli_query($koneksi, $insert_query)) {
                    $_SESSION['pesan'] = "Data peserta didik <strong>" . htmlspecialchars($nama) . "</strong> berhasil ditambahkan!";
                    $_SESSION['tipe_pesan'] = "success";
                    header("Location: " . BASE_URL . "/siswa/index.php");
                    exit();
                } else {
                    $error = 'Gagal menyimpan data: ' . mysqli_error($koneksi);
                }
            }
        }
    }
}

require_once __DIR__ . '/../includes/header.php';
?>

<!-- Header Page -->
<div class="mb-4">
    <div class="breadcrumb-modern">
        <a href="<?= BASE_URL ?>/index.php"><i class="bi bi-house-door"></i> Dashboard</a>
        <span class="breadcrumb-separator">/</span>
        <a href="<?= BASE_URL ?>/siswa/index.php">Data Siswa</a>
        <span class="breadcrumb-separator">/</span>
        <span class="active">Tambah Siswa</span>
    </div>
    <h3 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
        <span class="avatar-gradient avatar-gradient-2" style="width: 38px; height: 38px; font-size: 1.1rem;">
            <i class="bi bi-person-plus-fill"></i>
        </span>
        Tambah Data Peserta Didik
    </h3>
    <p class="text-muted small mb-0">Lengkapi formulir di bawah ini untuk mendaftarkan siswa baru ke sistem sekolah</p>
</div>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4 py-3 px-4 d-flex align-items-center gap-3" role="alert">
        <i class="bi bi-exclamation-octagon-fill fs-4 text-danger"></i>
        <div><?= $error; ?></div>
        <button type="button" class="btn-close ms-auto shadow-none" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card card-modern">
    <div class="card-body p-4 p-md-5">
        <form method="POST" action="">
            <div class="row g-4">
                <!-- Kolom Kiri -->
                <div class="col-lg-6">
                    <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                        <span class="badge badge-soft-info rounded-circle p-2"><i class="bi bi-person-vcard"></i></span>
                        <h6 class="fw-bold text-dark mb-0">Identitas Peserta Didik</h6>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label class="form-label-modern"><i class="bi bi-upc text-primary"></i> NISN <span class="text-danger">*</span></label>
                            <input type="text" name="nisn" class="form-control form-control-modern" placeholder="10 digit nomor NISN" maxlength="20" value="<?= htmlspecialchars($_POST['nisn'] ?? ''); ?>" required>
                            <small class="text-muted">Nomor Induk Siswa Nasional</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-modern"><i class="bi bi-qr-code text-primary"></i> NIS Sekolah <span class="text-danger">*</span></label>
                            <input type="text" name="nis" class="form-control form-control-modern" placeholder="Nomor induk lokal" maxlength="20" value="<?= htmlspecialchars($_POST['nis'] ?? ''); ?>" required>
                            <small class="text-muted">Nomor Induk Siswa Lokal</small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-modern"><i class="bi bi-person-fill text-primary"></i> Nama Lengkap Siswa <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control form-control-modern" placeholder="Masukkan nama lengkap siswa..." value="<?= htmlspecialchars($_POST['nama'] ?? ''); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-modern"><i class="bi bi-gender-ambiguous text-primary"></i> Jenis Kelamin <span class="text-danger">*</span></label>
                        <div class="d-flex gap-3 pt-1">
                            <label class="card card-modern p-3 flex-fill text-center cursor-pointer border <?= (($_POST['jenis_kelamin'] ?? '') == 'Laki-laki') ? 'border-primary bg-primary bg-opacity-10' : ''; ?>" style="cursor: pointer;">
                                <input class="form-check-input me-1 d-none" type="radio" name="jenis_kelamin" value="Laki-laki" <?= (($_POST['jenis_kelamin'] ?? '') == 'Laki-laki') ? 'checked' : ''; ?> required>
                                <i class="bi bi-gender-male text-primary fs-5 d-block mb-1"></i>
                                <span class="fw-semibold small">Laki-laki</span>
                            </label>
                            <label class="card card-modern p-3 flex-fill text-center cursor-pointer border <?= (($_POST['jenis_kelamin'] ?? '') == 'Perempuan') ? 'border-danger bg-danger bg-opacity-10' : ''; ?>" style="cursor: pointer;">
                                <input class="form-check-input me-1 d-none" type="radio" name="jenis_kelamin" value="Perempuan" <?= (($_POST['jenis_kelamin'] ?? '') == 'Perempuan') ? 'checked' : ''; ?> required>
                                <i class="bi bi-gender-female text-danger fs-5 d-block mb-1"></i>
                                <span class="fw-semibold small">Perempuan</span>
                            </label>
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label class="form-label-modern"><i class="bi bi-geo-alt text-muted"></i> Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="form-control form-control-modern" placeholder="Contoh: Jakarta" value="<?= htmlspecialchars($_POST['tempat_lahir'] ?? ''); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-modern"><i class="bi bi-calendar-event text-muted"></i> Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control form-control-modern" value="<?= htmlspecialchars($_POST['tanggal_lahir'] ?? ''); ?>">
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan -->
                <div class="col-lg-6">
                    <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                        <span class="badge badge-soft-primary rounded-circle p-2"><i class="bi bi-mortarboard-fill"></i></span>
                        <h6 class="fw-bold text-dark mb-0">Akademik &amp; Kontak</h6>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-md-5">
                            <label class="form-label-modern"><i class="bi bi-backpack text-primary"></i> Kelas <span class="text-danger">*</span></label>
                            <input type="text" name="kelas" class="form-control form-control-modern" placeholder="Contoh: XII RPL 1" value="<?= htmlspecialchars($_POST['kelas'] ?? ''); ?>" required>
                        </div>
                        <div class="col-md-7">
                            <label class="form-label-modern"><i class="bi bi-code-slash text-primary"></i> Jurusan / Keahlian <span class="text-danger">*</span></label>
                            <select name="jurusan" class="form-select form-select-modern" required>
                                <option value="">-- Pilih Konsentrasi Keahlian --</option>
                                <option value="Rekayasa Perangkat Lunak" <?= (($_POST['jurusan'] ?? '') == 'Rekayasa Perangkat Lunak') ? 'selected' : ''; ?>>Rekayasa Perangkat Lunak (RPL)</option>
                                <option value="Teknik Komputer dan Jaringan" <?= (($_POST['jurusan'] ?? '') == 'Teknik Komputer dan Jaringan') ? 'selected' : ''; ?>>Teknik Komputer & Jaringan (TKJ)</option>
                                <option value="Desain Komunikasi Visual" <?= (($_POST['jurusan'] ?? '') == 'Desain Komunikasi Visual') ? 'selected' : ''; ?>>Desain Komunikasi Visual (DKV)</option>
                                <option value="Manajemen Perkantoran" <?= (($_POST['jurusan'] ?? '') == 'Manajemen Perkantoran') ? 'selected' : ''; ?>>Manajemen Perkantoran</option>
                                <option value="Akuntansi & Keuangan" <?= (($_POST['jurusan'] ?? '') == 'Akuntansi & Keuangan') ? 'selected' : ''; ?>>Akuntansi & Keuangan</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label class="form-label-modern"><i class="bi bi-whatsapp text-success"></i> No. HP / WhatsApp</label>
                            <input type="text" name="telepon" class="form-control form-control-modern" placeholder="08xxxxxxxxxx" value="<?= htmlspecialchars($_POST['telepon'] ?? ''); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-modern"><i class="bi bi-envelope-at text-info"></i> Email Siswa</label>
                            <input type="email" name="email" class="form-control form-control-modern" placeholder="siswa@gmail.com" value="<?= htmlspecialchars($_POST['email'] ?? ''); ?>">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-modern"><i class="bi bi-geo-alt text-danger"></i> Alamat Rumah Domisili</label>
                        <textarea name="alamat" class="form-control form-control-modern" rows="3" placeholder="Masukkan alamat lengkap rumah siswa..."><?= htmlspecialchars($_POST['alamat'] ?? ''); ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                <a href="<?= BASE_URL ?>/siswa/index.php" class="btn btn-modern-outline">
                    <i class="bi bi-arrow-left"></i> Batal
                </a>
                <button type="submit" class="btn btn-modern-primary">
                    <i class="bi bi-check2-circle"></i> Simpan Data Siswa
                </button>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
