<?php
require_once __DIR__ . '/../config/database.php';

$page_title = 'Detail Peserta Didik';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    header("Location: " . BASE_URL . "/siswa/index.php");
    exit();
}

$query = mysqli_query($koneksi, "SELECT * FROM siswa WHERE id = $id");
if (mysqli_num_rows($query) === 0) {
    $_SESSION['pesan'] = "Data siswa tidak ditemukan!";
    $_SESSION['tipe_pesan'] = "warning";
    header("Location: " . BASE_URL . "/siswa/index.php");
    exit();
}

$siswa = mysqli_fetch_assoc($query);

require_once __DIR__ . '/../includes/header.php';
?>

<div class="mb-4">
    <div class="breadcrumb-modern">
        <a href="<?= BASE_URL ?>/index.php"><i class="bi bi-house-door"></i> Dashboard</a>
        <span class="breadcrumb-separator">/</span>
        <a href="<?= BASE_URL ?>/siswa/index.php">Data Siswa</a>
        <span class="breadcrumb-separator">/</span>
        <span class="active">Detail Profil</span>
    </div>
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
        <h3 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
            <span class="avatar-gradient avatar-gradient-2" style="width: 38px; height: 38px; font-size: 1.1rem;">
                <i class="bi bi-person-badge"></i>
            </span>
            Profil Lengkap Peserta Didik
        </h3>
        <div class="d-flex flex-wrap gap-2">
            <a href="<?= BASE_URL ?>/siswa/index.php" class="btn btn-modern-outline">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            <a href="<?= BASE_URL ?>/siswa/kartu.php?id=<?= $siswa['id']; ?>" target="_blank" class="btn btn-modern-outline">
                <i class="bi bi-person-vcard text-primary"></i> Cetak Kartu Pelajar
            </a>
            <a href="<?= BASE_URL ?>/siswa/edit.php?id=<?= $siswa['id']; ?>" class="btn btn-warning text-dark fw-semibold px-3 py-2 rounded-3 border-0 d-inline-flex align-items-center gap-2" style="border-radius: 12px;">
                <i class="bi bi-pencil-square"></i> Edit Data
            </a>
            <button onclick="window.print()" class="btn btn-modern-primary">
                <i class="bi bi-printer"></i> Cetak Biodata
            </button>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Profil Card Utama -->
    <div class="col-lg-4">
        <div class="card card-modern text-center p-4">
            <div class="avatar-gradient <?= $siswa['jenis_kelamin'] == 'Laki-laki' ? 'avatar-gradient-2' : 'avatar-gradient-3'; ?> mx-auto mb-3 shadow" style="width: 100px; height: 100px; font-size: 2.8rem; border-radius: 28px;">
                <?= strtoupper(substr($siswa['nama'], 0, 1)); ?>
            </div>
            <h5 class="fw-bold text-dark mb-1"><?= htmlspecialchars($siswa['nama']); ?></h5>
            <p class="text-muted small mb-3 font-monospace">NISN. <?= htmlspecialchars($siswa['nisn']); ?> / NIS. <?= htmlspecialchars($siswa['nis']); ?></p>
            
            <div class="mb-3">
                <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                    <i class="bi bi-backpack me-1 text-primary"></i> <?= htmlspecialchars($siswa['kelas']); ?>
                </span>
            </div>

            <div class="d-flex justify-content-center gap-2 mb-4">
                <span class="badge badge-soft-primary px-3 py-2 rounded-pill">
                    <?= htmlspecialchars($siswa['jurusan']); ?>
                </span>
                <span class="badge bg-light text-secondary border px-3 py-2 rounded-pill">
                    <?= $siswa['jenis_kelamin'] == 'Laki-laki' ? '<i class="bi bi-gender-male text-primary"></i> Laki-laki' : '<i class="bi bi-gender-female text-danger"></i> Perempuan'; ?>
                </span>
            </div>

            <?php if (!empty($siswa['telepon'])): ?>
                <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $siswa['telepon']); ?>" target="_blank" class="btn btn-success rounded-pill w-100 py-2 d-inline-flex align-items-center justify-content-center gap-2 fw-semibold shadow-sm mb-2">
                    <i class="bi bi-whatsapp"></i> Hubungi WhatsApp
                </a>
            <?php endif; ?>

            <hr class="my-3">

            <div class="text-start small text-muted">
                <div class="d-flex justify-content-between mb-1">
                    <span>Terdaftar Pada:</span>
                    <strong class="text-dark"><?= date('d F Y', strtotime($siswa['created_at'])); ?></strong>
                </div>
            </div>
        </div>
    </div>

    <!-- Informasi Rinci -->
    <div class="col-lg-8">
        <div class="card card-modern h-100">
            <div class="card-header bg-white py-3 px-4 border-bottom">
                <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                    <i class="bi bi-person-lines-fill text-info"></i> Biodata Lengkap Peserta Didik
                </h6>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-borderless align-middle mb-0">
                        <tbody>
                            <tr>
                                <th style="width: 220px;" class="text-muted fw-semibold py-3 border-bottom"><i class="bi bi-upc text-primary me-2"></i> Nomor NISN</th>
                                <td class="fw-bold font-monospace text-dark py-3 border-bottom"><?= htmlspecialchars($siswa['nisn']); ?></td>
                            </tr>
                            <tr>
                                <th class="text-muted fw-semibold py-3 border-bottom"><i class="bi bi-qr-code text-primary me-2"></i> NIS Sekolah</th>
                                <td class="fw-bold font-monospace text-dark py-3 border-bottom"><?= htmlspecialchars($siswa['nis']); ?></td>
                            </tr>
                            <tr>
                                <th class="text-muted fw-semibold py-3 border-bottom"><i class="bi bi-person text-primary me-2"></i> Nama Lengkap</th>
                                <td class="fw-semibold text-dark py-3 border-bottom"><?= htmlspecialchars($siswa['nama']); ?></td>
                            </tr>
                            <tr>
                                <th class="text-muted fw-semibold py-3 border-bottom"><i class="bi bi-gender-ambiguous text-primary me-2"></i> Jenis Kelamin</th>
                                <td class="text-dark py-3 border-bottom"><?= htmlspecialchars($siswa['jenis_kelamin']); ?></td>
                            </tr>
                            <tr>
                                <th class="text-muted fw-semibold py-3 border-bottom"><i class="bi bi-backpack text-primary me-2"></i> Kelas</th>
                                <td class="py-3 border-bottom"><span class="badge bg-light text-dark border"><?= htmlspecialchars($siswa['kelas']); ?></span></td>
                            </tr>
                            <tr>
                                <th class="text-muted fw-semibold py-3 border-bottom"><i class="bi bi-mortarboard text-primary me-2"></i> Jurusan / Keahlian</th>
                                <td class="fw-bold text-primary py-3 border-bottom"><?= htmlspecialchars($siswa['jurusan']); ?></td>
                            </tr>
                            <tr>
                                <th class="text-muted fw-semibold py-3 border-bottom"><i class="bi bi-calendar-event text-primary me-2"></i> Tempat, Tanggal Lahir</th>
                                <td class="text-dark py-3 border-bottom">
                                    <?= !empty($siswa['tempat_lahir']) ? htmlspecialchars($siswa['tempat_lahir']) . ', ' : '-'; ?>
                                    <?= !empty($siswa['tanggal_lahir']) ? date('d F Y', strtotime($siswa['tanggal_lahir'])) : ''; ?>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-muted fw-semibold py-3 border-bottom"><i class="bi bi-telephone text-primary me-2"></i> No. HP / WhatsApp</th>
                                <td class="text-dark py-3 border-bottom">
                                    <?php if (!empty($siswa['telepon'])): ?>
                                        <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $siswa['telepon']); ?>" target="_blank" class="text-decoration-none fw-semibold">
                                            <i class="bi bi-whatsapp text-success me-1"></i> <?= htmlspecialchars($siswa['telepon']); ?>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-muted fw-semibold py-3 border-bottom"><i class="bi bi-envelope text-primary me-2"></i> Alamat Email</th>
                                <td class="text-dark py-3 border-bottom">
                                    <?php if (!empty($siswa['email'])): ?>
                                        <a href="mailto:<?= htmlspecialchars($siswa['email']); ?>" class="text-decoration-none">
                                            <i class="bi bi-envelope-at text-info me-1"></i> <?= htmlspecialchars($siswa['email']); ?>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-muted fw-semibold py-3 align-top"><i class="bi bi-geo-alt text-primary me-2"></i> Alamat Rumah</th>
                                <td class="text-dark py-3"><?= !empty($siswa['alamat']) ? nl2br(htmlspecialchars($siswa['alamat'])) : '<span class="text-muted">-</span>'; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 pt-3 border-top d-flex justify-content-between align-items-center">
                    <a href="<?= BASE_URL ?>/siswa/hapus.php?id=<?= $siswa['id']; ?>" class="btn btn-outline-danger rounded-pill px-3 py-2 btn-hapus-konfirmasi d-inline-flex align-items-center gap-1" data-nama="<?= htmlspecialchars($siswa['nama']); ?>">
                        <i class="bi bi-trash3"></i> Hapus Data Siswa
                    </a>
                    <a href="<?= BASE_URL ?>/siswa/index.php" class="btn btn-modern-outline">
                        <i class="bi bi-arrow-left"></i> Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
