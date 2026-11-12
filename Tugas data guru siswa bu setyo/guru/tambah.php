<?php
require_once __DIR__ . '/../config/database.php';

$page_title = 'Tambah Guru Baru';
$error = '';

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
        // Cek duplikasi NIP
        $nip_escaped = mysqli_real_escape_string($koneksi, $nip);
        $cek_nip = mysqli_query($koneksi, "SELECT id FROM guru WHERE nip = '$nip_escaped'");
        if (mysqli_num_rows($cek_nip) > 0) {
            $error = 'NIP <strong>' . htmlspecialchars($nip) . '</strong> sudah terdaftar dalam sistem!';
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

            $insert_query = "INSERT INTO guru (nip, nama, gelar, mata_pelajaran, jenis_kelamin, status_kepegawaian, telepon, email, alamat)
                             VALUES ('$nip_escaped', '$nama_escaped', '$gelar_escaped', '$mapel_escaped', '$jk_escaped', '$status_escaped', '$telp_escaped', '$email_escaped', '$alamat_escaped')";

            if (mysqli_query($koneksi, $insert_query)) {
                $_SESSION['pesan'] = "Data tenaga pendidik <strong>" . htmlspecialchars($nama) . "</strong> berhasil disimpan ke sistem.";
                $_SESSION['tipe_pesan'] = "success";
                header("Location: " . BASE_URL . "/guru/index.php");
                exit();
            } else {
                $error = 'Gagal menyimpan data: ' . mysqli_error($koneksi);
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
        <span class="active">Tambah Guru</span>
    </div>
    <h3 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
        <span class="avatar-gradient avatar-gradient-1" style="width: 38px; height: 38px; font-size: 1.1rem;">
            <i class="bi bi-person-plus-fill"></i>
        </span>
        Tambah Data Tenaga Pendidik
    </h3>
    <p class="text-muted small mb-0">Lengkapi formulir berikut dengan data resmi tenaga pengajar sekolah</p>
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
                        <input type="text" name="nip" class="form-control form-control-modern" placeholder="Contoh: 198501152010011003" value="<?= htmlspecialchars($_POST['nip'] ?? ''); ?>" required>
                        <small class="text-muted">Nomor identitas unik PNS / PPPK / Yayasan</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-modern"><i class="bi bi-person-fill text-primary"></i> Nama Lengkap Guru <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control form-control-modern" placeholder="Contoh: Budi Santoso" value="<?= htmlspecialchars($_POST['nama'] ?? ''); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-modern"><i class="bi bi-mortarboard text-primary"></i> Gelar Akademik</label>
                        <input type="text" name="gelar" class="form-control form-control-modern" placeholder="Contoh: S.Pd., M.Kom." value="<?= htmlspecialchars($_POST['gelar'] ?? ''); ?>">
                        <small class="text-muted">Gelar sarjana / magister (boleh dikosongkan)</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-modern"><i class="bi bi-gender-ambiguous text-primary"></i> Jenis Kelamin <span class="text-danger">*</span></label>
                        <div class="d-flex gap-3 pt-1">
                            <label class="card card-modern p-3 flex-fill text-center cursor-pointer border <?= (($_POST['jenis_kelamin'] ?? '') == 'Laki-laki') ? 'border-primary bg-primary bg-opacity-10' : ''; ?>" style="cursor: pointer;">
                                <input class="form-check-input me-1 d-none" type="radio" name="jenis_kelamin" value="Laki-laki" <?= (($_POST['jenis_kelamin'] ?? '') == 'Laki-laki') ? 'checked' : ''; ?> required onchange="document.querySelectorAll('.card-gender').forEach(c => c.classList.remove('border-primary', 'bg-primary', 'bg-opacity-10')); this.closest('label').classList.add('border-primary', 'bg-primary', 'bg-opacity-10');">
                                <i class="bi bi-gender-male text-primary fs-5 d-block mb-1"></i>
                                <span class="fw-semibold small">Laki-laki</span>
                            </label>
                            <label class="card card-modern p-3 flex-fill text-center cursor-pointer border <?= (($_POST['jenis_kelamin'] ?? '') == 'Perempuan') ? 'border-danger bg-danger bg-opacity-10' : ''; ?>" style="cursor: pointer;">
                                <input class="form-check-input me-1 d-none" type="radio" name="jenis_kelamin" value="Perempuan" <?= (($_POST['jenis_kelamin'] ?? '') == 'Perempuan') ? 'checked' : ''; ?> required onchange="document.querySelectorAll('.card-gender').forEach(c => c.classList.remove('border-danger', 'bg-danger', 'bg-opacity-10')); this.closest('label').classList.add('border-danger', 'bg-danger', 'bg-opacity-10');">
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
                        <input type="text" name="mata_pelajaran" class="form-control form-control-modern" placeholder="Contoh: Pemrograman Web & Bergerak" value="<?= htmlspecialchars($_POST['mata_pelajaran'] ?? ''); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-modern"><i class="bi bi-award text-info"></i> Status Kepegawaian <span class="text-danger">*</span></label>
                        <select name="status_kepegawaian" class="form-select form-select-modern" required>
                            <option value="">-- Pilih Status Kepegawaian --</option>
                            <option value="PNS" <?= (($_POST['status_kepegawaian'] ?? '') == 'PNS') ? 'selected' : ''; ?>>PNS (Pegawai Negeri Sipil)</option>
                            <option value="PPPK" <?= (($_POST['status_kepegawaian'] ?? '') == 'PPPK') ? 'selected' : ''; ?>>PPPK</option>
                            <option value="Guru Tetap" <?= (($_POST['status_kepegawaian'] ?? '') == 'Guru Tetap') ? 'selected' : ''; ?>>Guru Tetap Yayasan</option>
                            <option value="Guru Honorer" <?= (($_POST['status_kepegawaian'] ?? '') == 'Guru Honorer') ? 'selected' : ''; ?>>Guru Honorer</option>
                        </select>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label class="form-label-modern"><i class="bi bi-whatsapp text-success"></i> No. HP / WhatsApp</label>
                            <input type="text" name="telepon" class="form-control form-control-modern" placeholder="08xxxxxxxxxx" value="<?= htmlspecialchars($_POST['telepon'] ?? ''); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-modern"><i class="bi bi-envelope-at text-info"></i> Email Guru</label>
                            <input type="email" name="email" class="form-control form-control-modern" placeholder="guru@sekolah.sch.id" value="<?= htmlspecialchars($_POST['email'] ?? ''); ?>">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-modern"><i class="bi bi-geo-alt text-danger"></i> Alamat Tempat Tinggal</label>
                        <textarea name="alamat" class="form-control form-control-modern" rows="3" placeholder="Masukkan alamat lengkap rumah..."><?= htmlspecialchars($_POST['alamat'] ?? ''); ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                <a href="<?= BASE_URL ?>/guru/index.php" class="btn btn-modern-outline">
                    <i class="bi bi-arrow-left"></i> Batal
                </a>
                <button type="submit" class="btn btn-modern-primary">
                    <i class="bi bi-check2-circle"></i> Simpan Data Guru
                </button>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
