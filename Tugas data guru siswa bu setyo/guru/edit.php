<?php
require_once __DIR__ . '/../config/database.php';

$page_title = 'Edit Data Guru';
$error = '';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    header("Location: " . BASE_URL . "/guru/index.php");
    exit();
}

// Ambil data guru saat ini
$query_guru = mysqli_query($koneksi, "SELECT * FROM guru WHERE id = $id");
if (mysqli_num_rows($query_guru) === 0) {
    $_SESSION['pesan'] = "Data guru tidak ditemukan!";
    $_SESSION['tipe_pesan'] = "danger";
    header("Location: " . BASE_URL . "/guru/index.php");
    exit();
}

$guru = mysqli_fetch_assoc($query_guru);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nip = trim($_POST['nip'] ?? '');
    $nama = trim($_POST['nama'] ?? '');
    $gelar = trim($_POST['gelar'] ?? '');
    $mata_pelajaran = trim($_POST['mata_pelajaran'] ?? '');
    $jenis_kelamin = trim($_POST['jenis_kelamin'] ?? '');
    $status_kepegawaian = trim($_POST['status_kepegawaian'] ?? '');
    $telepon = trim($_POST['telepon'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $alamat = trim($_POST['alamat'] ?? '');

    // Validasi input
    if (empty($nip) || empty($nama) || empty($mata_pelajaran) || empty($jenis_kelamin) || empty($status_kepegawaian)) {
        $error = 'Harap lengkapi semua bidang yang bertanda wajib (*)!';
    } else {
        // Cek duplikasi NIP pada data lain
        $nip_escaped = mysqli_real_escape_string($koneksi, $nip);
        $cek_nip = mysqli_query($koneksi, "SELECT id FROM guru WHERE nip = '$nip_escaped' AND id != $id");
        if (mysqli_num_rows($cek_nip) > 0) {
            $error = 'NIP <strong>' . htmlspecialchars($nip) . '</strong> sudah digunakan oleh guru lain!';
        } else {
            // Escape input
            $nama_escaped = mysqli_real_escape_string($koneksi, $nama);
            $gelar_escaped = mysqli_real_escape_string($koneksi, $gelar);
            $mapel_escaped = mysqli_real_escape_string($koneksi, $mata_pelajaran);
            $jk_escaped = mysqli_real_escape_string($koneksi, $jenis_kelamin);
            $status_escaped = mysqli_real_escape_string($koneksi, $status_kepegawaian);
            $telp_escaped = mysqli_real_escape_string($koneksi, $telepon);
            $email_escaped = mysqli_real_escape_string($koneksi, $email);
            $alamat_escaped = mysqli_real_escape_string($koneksi, $alamat);

            $update_query = "UPDATE guru SET
                nip = '$nip_escaped',
                nama = '$nama_escaped',
                gelar = '$gelar_escaped',
                mata_pelajaran = '$mapel_escaped',
                jenis_kelamin = '$jk_escaped',
                status_kepegawaian = '$status_escaped',
                telepon = '$telp_escaped',
                email = '$email_escaped',
                alamat = '$alamat_escaped'
                WHERE id = $id";

            if (mysqli_query($koneksi, $update_query)) {
                $_SESSION['pesan'] = "Perubahan data guru <strong>" . htmlspecialchars($nama) . "</strong> berhasil disimpan.";
                $_SESSION['tipe_pesan'] = "success";
                header("Location: " . BASE_URL . "/guru/index.php");
                exit();
            } else {
                $error = 'Gagal memperbarui data: ' . mysqli_error($koneksi);
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
        <a href="<?= BASE_URL ?>/guru/index.php">Data Guru</a>
        <span class="breadcrumb-separator">/</span>
        <span class="active">Edit Guru</span>
    </div>
    <h3 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
        <span class="avatar-gradient avatar-gradient-1" style="width: 38px; height: 38px; font-size: 1.1rem;">
            <i class="bi bi-pencil-square"></i>
        </span>
        Edit Data Tenaga Pendidik
    </h3>
    <p class="text-muted small mb-0">Perbarui data: <strong><?= htmlspecialchars($guru['nama']); ?></strong></p>
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
                        <span class="badge badge-soft-primary rounded-circle p-2"><i class="bi bi-person-badge"></i></span>
                        <h6 class="fw-bold text-dark mb-0">Identitas Tenaga Pendidik</h6>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-modern"><i class="bi bi-upc-scan text-primary"></i> Nomor Induk Pegawai (NIP) <span class="text-danger">*</span></label>
                        <input type="text" name="nip" class="form-control form-control-modern" value="<?= htmlspecialchars($_POST['nip'] ?? $guru['nip']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-modern"><i class="bi bi-person-fill text-primary"></i> Nama Lengkap Guru <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control form-control-modern" value="<?= htmlspecialchars($_POST['nama'] ?? $guru['nama']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-modern"><i class="bi bi-mortarboard text-primary"></i> Gelar Akademik</label>
                        <input type="text" name="gelar" class="form-control form-control-modern" value="<?= htmlspecialchars($_POST['gelar'] ?? $guru['gelar']); ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label-modern"><i class="bi bi-gender-ambiguous text-primary"></i> Jenis Kelamin <span class="text-danger">*</span></label>
                        <?php $jk_val = $_POST['jenis_kelamin'] ?? $guru['jenis_kelamin']; ?>
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
                </div>

                <!-- Kolom Kanan -->
                <div class="col-lg-6">
                    <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                        <span class="badge badge-soft-info rounded-circle p-2"><i class="bi bi-briefcase-fill"></i></span>
                        <h6 class="fw-bold text-dark mb-0">Kepegawaian &amp; Kontak</h6>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-modern"><i class="bi bi-book-half text-info"></i> Mata Pelajaran yang Diampu <span class="text-danger">*</span></label>
                        <input type="text" name="mata_pelajaran" class="form-control form-control-modern" value="<?= htmlspecialchars($_POST['mata_pelajaran'] ?? $guru['mata_pelajaran']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-modern"><i class="bi bi-award text-info"></i> Status Kepegawaian <span class="text-danger">*</span></label>
                        <?php $status_val = $_POST['status_kepegawaian'] ?? $guru['status_kepegawaian']; ?>
                        <select name="status_kepegawaian" class="form-select form-select-modern" required>
                            <option value="">-- Pilih Status Kepegawaian --</option>
                            <option value="PNS" <?= ($status_val == 'PNS') ? 'selected' : ''; ?>>PNS (Pegawai Negeri Sipil)</option>
                            <option value="PPPK" <?= ($status_val == 'PPPK') ? 'selected' : ''; ?>>PPPK</option>
                            <option value="Guru Tetap" <?= ($status_val == 'Guru Tetap') ? 'selected' : ''; ?>>Guru Tetap</option>
                            <option value="Guru Honorer" <?= ($status_val == 'Guru Honorer') ? 'selected' : ''; ?>>Guru Honorer</option>
                        </select>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label class="form-label-modern"><i class="bi bi-whatsapp text-success"></i> No. HP / WhatsApp</label>
                            <input type="text" name="telepon" class="form-control form-control-modern" value="<?= htmlspecialchars($_POST['telepon'] ?? $guru['telepon']); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-modern"><i class="bi bi-envelope-at text-info"></i> Email Guru</label>
                            <input type="email" name="email" class="form-control form-control-modern" value="<?= htmlspecialchars($_POST['email'] ?? $guru['email']); ?>">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-modern"><i class="bi bi-geo-alt text-danger"></i> Alamat Domisili</label>
                        <textarea name="alamat" class="form-control form-control-modern" rows="3"><?= htmlspecialchars($_POST['alamat'] ?? $guru['alamat']); ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                <a href="<?= BASE_URL ?>/guru/index.php" class="btn btn-modern-outline">
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
