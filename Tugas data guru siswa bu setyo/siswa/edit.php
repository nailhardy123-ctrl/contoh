<?php
require_once __DIR__ . '/../config/database.php';

$page_title = 'Edit Data Siswa';
$error = '';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    header("Location: " . BASE_URL . "/siswa/index.php");
    exit();
}

$query = mysqli_query($koneksi, "SELECT * FROM siswa WHERE id = $id");
if (mysqli_num_rows($query) === 0) {
    $_SESSION['pesan'] = "Data siswa tidak ditemukan!";
    $_SESSION['tipe_pesan'] = "danger";
    header("Location: " . BASE_URL . "/siswa/index.php");
    exit();
}

$siswa = mysqli_fetch_assoc($query);

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
        // Cek duplikasi NISN pada siswa lain
        $nisn_escaped = mysqli_real_escape_string($koneksi, $nisn);
        $cek_nisn = mysqli_query($koneksi, "SELECT id FROM siswa WHERE nisn = '$nisn_escaped' AND id != $id");
        if (mysqli_num_rows($cek_nisn) > 0) {
            $error = 'NISN <strong>' . htmlspecialchars($nisn) . '</strong> sudah digunakan oleh siswa lain!';
        } else {
            // Cek duplikasi NIS pada siswa lain
            $nis_escaped = mysqli_real_escape_string($koneksi, $nis);
            $cek_nis = mysqli_query($koneksi, "SELECT id FROM siswa WHERE nis = '$nis_escaped' AND id != $id");
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

                $update_query = "UPDATE siswa SET
                    nisn = '$nisn_escaped',
                    nis = '$nisn_escaped',
                    nama = '$nama_escaped',
                    jenis_kelamin = '$jk_escaped',
                    kelas = '$kelas_escaped',
                    jurusan = '$jurusan_escaped',
                    tempat_lahir = '$tl_escaped',
                    tanggal_lahir = $tgl_escaped,
                    telepon = '$telp_escaped',
                    email = '$email_escaped',
                    alamat = '$alamat_escaped'
                    WHERE id = $id";

                if (mysqli_query($koneksi, $update_query)) {
                    $_SESSION['pesan'] = "Perubahan data siswa <strong>" . htmlspecialchars($nama) . "</strong> berhasil diperbarui!";
                    $_SESSION['tipe_pesan'] = "success";
                    header("Location: " . BASE_URL . "/siswa/index.php");
                    exit();
                } else {
                    $error = 'Gagal memperbarui data: ' . mysqli_error($koneksi);
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
        <span class="active">Edit Siswa</span>
    </div>
    <h3 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
        <span class="avatar-gradient avatar-gradient-2" style="width: 38px; height: 38px; font-size: 1.1rem;">
            <i class="bi bi-pencil-square"></i>
        </span>
        Edit Data Peserta Didik
    </h3>
    <p class="text-muted small mb-0">Perbarui data siswa: <strong><?= htmlspecialchars($siswa['nama']); ?></strong></p>
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
                            <input type="text" name="nisn" class="form-control form-control-modern" value="<?= htmlspecialchars($_POST['nisn'] ?? $siswa['nisn']); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-modern"><i class="bi bi-qr-code text-primary"></i> NIS Sekolah <span class="text-danger">*</span></label>
                            <input type="text" name="nis" class="form-control form-control-modern" value="<?= htmlspecialchars($_POST['nis'] ?? $siswa['nis']); ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-modern"><i class="bi bi-person-fill text-primary"></i> Nama Lengkap Siswa <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control form-control-modern" value="<?= htmlspecialchars($_POST['nama'] ?? $siswa['nama']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-modern"><i class="bi bi-gender-ambiguous text-primary"></i> Jenis Kelamin <span class="text-danger">*</span></label>
                        <?php $jk_val = $_POST['jenis_kelamin'] ?? $siswa['jenis_kelamin']; ?>
                        <div class="d-flex gap-3 pt-1">
                            <label class="card card-modern p-3 flex-fill text-center cursor-pointer border <?= ($jk_val == 'Laki-laki') ? 'border-primary bg-primary bg-opacity-10' : ''; ?>" style="cursor: pointer;">
                                <input class="form-check-input me-1 d-none" type="radio" name="jenis_kelamin" value="Laki-laki" <?= ($jk_val == 'Laki-laki') ? 'checked' : ''; ?> required>
                                <i class="bi bi-gender-male text-primary fs-5 d-block mb-1"></i>
                                <span class="fw-semibold small">Laki-laki</span>
                            </label>
                            <label class="card card-modern p-3 flex-fill text-center cursor-pointer border <?= ($jk_val == 'Perempuan') ? 'border-danger bg-danger bg-opacity-10' : ''; ?>" style="cursor: pointer;">
                                <input class="form-check-input me-1 d-none" type="radio" name="jenis_kelamin" value="Perempuan" <?= ($jk_val == 'Perempuan') ? 'checked' : ''; ?> required>
                                <i class="bi bi-gender-female text-danger fs-5 d-block mb-1"></i>
                                <span class="fw-semibold small">Perempuan</span>
                            </label>
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label class="form-label-modern"><i class="bi bi-geo-alt text-muted"></i> Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="form-control form-control-modern" value="<?= htmlspecialchars($_POST['tempat_lahir'] ?? $siswa['tempat_lahir']); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-modern"><i class="bi bi-calendar-event text-muted"></i> Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control form-control-modern" value="<?= htmlspecialchars($_POST['tanggal_lahir'] ?? $siswa['tanggal_lahir']); ?>">
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
                            <input type="text" name="kelas" class="form-control form-control-modern" value="<?= htmlspecialchars($_POST['kelas'] ?? $siswa['kelas']); ?>" required>
                        </div>
                        <div class="col-md-7">
                            <label class="form-label-modern"><i class="bi bi-code-slash text-primary"></i> Jurusan / Keahlian <span class="text-danger">*</span></label>
                            <?php $jur_val = $_POST['jurusan'] ?? $siswa['jurusan']; ?>
                            <select name="jurusan" class="form-select form-select-modern" required>
                                <option value="">-- Pilih Konsentrasi Keahlian --</option>
                                <option value="Rekayasa Perangkat Lunak" <?= ($jur_val == 'Rekayasa Perangkat Lunak') ? 'selected' : ''; ?>>Rekayasa Perangkat Lunak (RPL)</option>
                                <option value="Teknik Komputer dan Jaringan" <?= ($jur_val == 'Teknik Komputer dan Jaringan') ? 'selected' : ''; ?>>Teknik Komputer & Jaringan (TKJ)</option>
                                <option value="Desain Komunikasi Visual" <?= ($jur_val == 'Desain Komunikasi Visual') ? 'selected' : ''; ?>>Desain Komunikasi Visual (DKV)</option>
                                <option value="Manajemen Perkantoran" <?= ($jur_val == 'Manajemen Perkantoran') ? 'selected' : ''; ?>>Manajemen Perkantoran</option>
                                <option value="Akuntansi & Keuangan" <?= ($jur_val == 'Akuntansi & Keuangan') ? 'selected' : ''; ?>>Akuntansi & Keuangan</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label class="form-label-modern"><i class="bi bi-whatsapp text-success"></i> No. HP / WhatsApp</label>
                            <input type="text" name="telepon" class="form-control form-control-modern" value="<?= htmlspecialchars($_POST['telepon'] ?? $siswa['telepon']); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-modern"><i class="bi bi-envelope-at text-info"></i> Email Siswa</label>
                            <input type="email" name="email" class="form-control form-control-modern" value="<?= htmlspecialchars($_POST['email'] ?? $siswa['email']); ?>">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-modern"><i class="bi bi-geo-alt text-danger"></i> Alamat Rumah Domisili</label>
                        <textarea name="alamat" class="form-control form-control-modern" rows="3"><?= htmlspecialchars($_POST['alamat'] ?? $siswa['alamat']); ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                <a href="<?= BASE_URL ?>/siswa/index.php" class="btn btn-modern-outline">
                    <i class="bi bi-arrow-left"></i> Batal
                </a>
                <button type="submit" class="btn btn-modern-primary">
                    <i class="bi bi-check2-circle"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
