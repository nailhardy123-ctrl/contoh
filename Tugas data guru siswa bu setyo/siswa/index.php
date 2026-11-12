<?php
require_once __DIR__ . '/../config/database.php';

$page_title = 'Data Siswa';

// Parameter Pencarian dan Filter
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$jurusan_filter = isset($_GET['jurusan']) ? trim($_GET['jurusan']) : '';
$kelas_filter = isset($_GET['kelas']) ? trim($_GET['kelas']) : '';

// Susun Query SQL
$sql = "SELECT * FROM siswa WHERE 1=1";

if (!empty($search)) {
    $search_escaped = mysqli_real_escape_string($koneksi, $search);
    $sql .= " AND (nama LIKE '%$search_escaped%' OR nisn LIKE '%$search_escaped%' OR nis LIKE '%$search_escaped%' OR kelas LIKE '%$search_escaped%')";
}

if (!empty($jurusan_filter)) {
    $jurusan_escaped = mysqli_real_escape_string($koneksi, $jurusan_filter);
    $sql .= " AND jurusan = '$jurusan_escaped'";
}

if (!empty($kelas_filter)) {
    $kelas_escaped = mysqli_real_escape_string($koneksi, $kelas_filter);
    $sql .= " AND kelas LIKE '%$kelas_escaped%'";
}

$sql .= " ORDER BY id DESC";
$result = mysqli_query($koneksi, $sql);
$total_data = mysqli_num_rows($result);

// Ambil daftar jurusan unik untuk opsi filter
$q_jurusan = mysqli_query($koneksi, "SELECT DISTINCT jurusan FROM siswa ORDER BY jurusan ASC");

require_once __DIR__ . '/../includes/header.php';
?>

<!-- Header Page -->
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
    <div>
        <div class="breadcrumb-modern">
            <a href="<?= BASE_URL ?>/index.php"><i class="bi bi-house-door"></i> Dashboard</a>
            <span class="breadcrumb-separator">/</span>
            <span class="active">Data Siswa</span>
        </div>
        <h3 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
            <span class="avatar-gradient avatar-gradient-2" style="width: 38px; height: 38px; font-size: 1.1rem;">
                <i class="bi bi-people-fill"></i>
            </span>
            Peserta Didik / Siswa
        </h3>
        <p class="text-muted small mb-0">Kelola identitas peserta didik, NISN, kelas, dan data jurusan sekolah</p>
    </div>
    <div class="d-flex flex-wrap gap-2">
        <a href="<?= BASE_URL ?>/siswa/export_excel.php" class="btn btn-modern-outline">
            <i class="bi bi-file-earmark-excel text-success"></i> Export Excel
        </a>
        <a href="<?= BASE_URL ?>/siswa/cetak.php<?= !empty($jurusan_filter) ? '?jurusan=' . urlencode($jurusan_filter) : ''; ?>" target="_blank" class="btn btn-modern-outline">
            <i class="bi bi-printer text-info"></i> Cetak Laporan
        </a>
        <a href="<?= BASE_URL ?>/siswa/tambah.php" class="btn btn-modern-primary">
            <i class="bi bi-plus-lg"></i> Tambah Siswa Baru
        </a>
    </div>
</div>

<!-- Filter dan Pencarian -->
<div class="card card-modern mb-4">
    <div class="card-body p-3">
        <form method="GET" action="" class="row g-2 align-items-center">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted ps-3">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" name="search" class="form-control form-control-modern border-start-0" placeholder="Cari nama, NISN, NIS, atau kelas..." value="<?= htmlspecialchars($search); ?>">
                </div>
            </div>
            <div class="col-md-4">
                <select name="jurusan" class="form-select form-select-modern">
                    <option value="">-- Semua Konsentrasi Keahlian / Jurusan --</option>
                    <?php while ($j = mysqli_fetch_assoc($q_jurusan)): ?>
                        <option value="<?= htmlspecialchars($j['jurusan']); ?>" <?= $jurusan_filter == $j['jurusan'] ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($j['jurusan']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-modern-primary flex-grow-1 justify-content-center">
                    <i class="bi bi-funnel"></i> Terapkan Filter
                </button>
                <?php if (!empty($search) || !empty($jurusan_filter) || !empty($kelas_filter)): ?>
                    <a href="<?= BASE_URL ?>/siswa/index.php" class="btn btn-modern-outline" title="Reset Filter">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>

<!-- Tabel Data Siswa -->
<div class="card card-modern">
    <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-2">
            <span class="badge badge-soft-info px-3 py-2 rounded-pill fw-semibold">
                Total Siswa: <?= $total_data; ?>
            </span>
            <?php if (!empty($search) || !empty($jurusan_filter)): ?>
                <span class="badge bg-light text-muted border">Filter Aktif</span>
            <?php endif; ?>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-modern mb-0">
                <thead>
                    <tr>
                        <th style="width: 50px;" class="text-center">No</th>
                        <th>NISN &amp; NIS</th>
                        <th>Nama Siswa</th>
                        <th>L/P</th>
                        <th>Kelas &amp; Jurusan</th>
                        <th>Kontak &amp; Alamat</th>
                        <th class="text-center" style="width: 170px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($total_data > 0): ?>
                        <?php $no = 1; while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td class="text-center fw-bold text-muted"><?= $no++; ?></td>
                                <td>
                                    <span class="fw-bold font-monospace text-dark d-block"><?= htmlspecialchars($row['nisn']); ?></span>
                                    <small class="text-muted font-monospace">NIS: <?= htmlspecialchars($row['nis']); ?></small>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar-gradient <?= $row['jenis_kelamin'] == 'Laki-laki' ? 'avatar-gradient-2' : 'avatar-gradient-3'; ?>">
                                            <?= strtoupper(substr($row['nama'], 0, 1)); ?>
                                        </div>
                                        <div>
                                            <a href="<?= BASE_URL ?>/siswa/detail.php?id=<?= $row['id']; ?>" class="fw-bold text-dark text-decoration-none">
                                                <?= htmlspecialchars($row['nama']); ?>
                                            </a>
                                            <small class="text-muted d-block">
                                                <?= !empty($row['tempat_lahir']) ? htmlspecialchars($row['tempat_lahir']) . ', ' : ''; ?>
                                                <?= !empty($row['tanggal_lahir']) ? date('d/m/Y', strtotime($row['tanggal_lahir'])) : ''; ?>
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?php if ($row['jenis_kelamin'] == 'Laki-laki'): ?>
                                        <span class="badge badge-soft-primary" title="Laki-laki">L</span>
                                    <?php else: ?>
                                        <span class="badge badge-soft-danger" title="Perempuan">P</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border d-inline-block mb-1">
                                        <?= htmlspecialchars($row['kelas']); ?>
                                    </span>
                                    <small class="text-muted d-block fw-semibold"><?= htmlspecialchars($row['jurusan']); ?></small>
                                </td>
                                <td>
                                    <small class="text-muted d-block"><i class="bi bi-telephone text-primary me-1"></i> <?= !empty($row['telepon']) ? htmlspecialchars($row['telepon']) : '-'; ?></small>
                                    <small class="text-muted d-block"><i class="bi bi-geo-alt text-danger me-1"></i> <?= !empty($row['alamat']) ? htmlspecialchars(mb_strimwidth($row['alamat'], 0, 24, '...')) : '-'; ?></small>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="<?= BASE_URL ?>/siswa/detail.php?id=<?= $row['id']; ?>" class="btn-action-icon view" title="Lihat Profil Siswa">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= BASE_URL ?>/siswa/kartu.php?id=<?= $row['id']; ?>" target="_blank" class="btn-action-icon card-btn" title="Cetak Kartu Siswa">
                                            <i class="bi bi-person-vcard"></i>
                                        </a>
                                        <a href="<?= BASE_URL ?>/siswa/edit.php?id=<?= $row['id']; ?>" class="btn-action-icon edit" title="Edit Data Siswa">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="<?= BASE_URL ?>/siswa/hapus.php?id=<?= $row['id']; ?>" class="btn-action-icon delete btn-hapus-konfirmasi" data-nama="<?= htmlspecialchars($row['nama']); ?>" title="Hapus Data Siswa">
                                            <i class="bi bi-trash3"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <div class="py-4">
                                    <i class="bi bi-search fs-1 d-block mb-3 text-secondary opacity-50"></i>
                                    <h6 class="fw-bold text-dark mb-1">Data siswa tidak ditemukan</h6>
                                    <p class="small text-muted mb-3">Tidak ada data yang cocok dengan kriteria pencarian Anda.</p>
                                    <a href="<?= BASE_URL ?>/siswa/index.php" class="btn btn-sm btn-modern-outline">Reset Filter</a>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
