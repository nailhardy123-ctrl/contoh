<?php
require_once __DIR__ . '/config/database.php';

$page_title = 'Dashboard';

// Hitung total data guru
$q_total_guru = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM guru");
$total_guru = mysqli_fetch_assoc($q_total_guru)['total'] ?? 0;

// Hitung total data siswa
$q_total_siswa = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM siswa");
$total_siswa = mysqli_fetch_assoc($q_total_siswa)['total'] ?? 0;

// Hitung siswa laki-laki dan perempuan
$q_siswa_l = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM siswa WHERE jenis_kelamin = 'Laki-laki'");
$siswa_l = mysqli_fetch_assoc($q_siswa_l)['total'] ?? 0;

$q_siswa_p = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM siswa WHERE jenis_kelamin = 'Perempuan'");
$siswa_p = mysqli_fetch_assoc($q_siswa_p)['total'] ?? 0;

// Hitung persentase siswa
$persen_l = $total_siswa > 0 ? round(($siswa_l / $total_siswa) * 100) : 0;
$persen_p = $total_siswa > 0 ? round(($siswa_p / $total_siswa) * 100) : 0;

// Ambil data untuk Chart Distribusi Siswa per Jurusan
$q_chart_jurusan = mysqli_query($koneksi, "SELECT jurusan, COUNT(*) as jumlah FROM siswa GROUP BY jurusan");
$jurusan_labels = [];
$jurusan_data = [];
while ($row = mysqli_fetch_assoc($q_chart_jurusan)) {
    $jurusan_labels[] = $row['jurusan'];
    $jurusan_data[] = (int)$row['jumlah'];
}

// Ambil data untuk Chart Guru per Status Kepegawaian
$q_chart_status = mysqli_query($koneksi, "SELECT status_kepegawaian, COUNT(*) as jumlah FROM guru GROUP BY status_kepegawaian");
$status_labels = [];
$status_data = [];
while ($row = mysqli_fetch_assoc($q_chart_status)) {
    $status_labels[] = $row['status_kepegawaian'];
    $status_data[] = (int)$row['jumlah'];
}

// Ambil 5 data guru terbaru
$q_guru_terbaru = mysqli_query($koneksi, "SELECT * FROM guru ORDER BY id DESC LIMIT 5");

// Ambil 5 data siswa terbaru
$q_siswa_terbaru = mysqli_query($koneksi, "SELECT * FROM siswa ORDER BY id DESC LIMIT 5");

// Salam berdasarkan waktu
$jam = (int)date('H');
if ($jam >= 3 && $jam < 11) {
    $salam = "Selamat Pagi";
} elseif ($jam >= 11 && $jam < 15) {
    $salam = "Selamat Siang";
} elseif ($jam >= 15 && $jam < 18) {
    $salam = "Selamat Sore";
} else {
    $salam = "Selamat Malam";
}

require_once __DIR__ . '/includes/header.php';
?>

<!-- Modern Hero Welcome Banner -->
<div class="hero-banner-modern mb-4">
    <div class="row align-items-center position-relative" style="z-index: 2;">
        <div class="col-lg-8">
            <div class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill mb-3 border border-white border-opacity-10">
                <span class="live-dot"></span>
                <span class="small fw-semibold text-white-50">Sistem Informasi Akademik Sekolah</span>
            </div>
            <h2 class="fw-bold mb-2 text-white display-6" style="letter-spacing: -0.03em;">
                <?= $salam; ?>, <span style="background: linear-gradient(135deg, #a5b4fc 0%, #38bdf8 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Bu Setyo &amp; Siswa</span> 👋
            </h2>
            <p class="text-white-50 mb-4" style="max-width: 620px; font-size: 0.98rem; line-height: 1.6;">
                Selamat datang di portal pengelolaan data guru dan peserta didik. Sistem ini menyediakan rekapitulasi data akademik secara realtime, pencatatan lengkap, cetak laporan resmi, serta kartu identitas pelajar.
            </p>
            <div class="d-flex flex-wrap gap-2">
                <a href="<?= BASE_URL ?>/guru/tambah.php" class="btn btn-modern-primary">
                    <i class="bi bi-person-plus-fill"></i> Tambah Guru Baru
                </a>
                <a href="<?= BASE_URL ?>/siswa/tambah.php" class="btn btn-outline-light rounded-3 px-3 py-2 fw-semibold d-inline-flex align-items-center gap-2 border-opacity-25" style="border-radius: 12px;">
                    <i class="bi bi-person-badge"></i> Tambah Siswa Baru
                </a>
                <a href="<?= BASE_URL ?>/siswa/cetak.php" target="_blank" class="btn btn-dark bg-white bg-opacity-10 text-white rounded-3 px-3 py-2 fw-semibold d-inline-flex align-items-center gap-2 border-0" style="border-radius: 12px;">
                    <i class="bi bi-printer"></i> Cetak Laporan
                </a>
            </div>
        </div>
        <div class="col-lg-4 text-center d-none d-lg-block">
            <div class="position-relative d-inline-block">
                <div style="width: 140px; height: 140px; background: radial-gradient(circle, rgba(99, 102, 241, 0.4) 0%, rgba(14, 165, 233, 0.1) 70%, transparent 100%); border-radius: 50%; filter: blur(20px); position: absolute; top: 10px; left: 10px;"></div>
                <div class="card p-3 rounded-4 bg-white bg-opacity-10 border border-white border-opacity-10 text-start text-white shadow-lg backdrop-blur" style="backdrop-filter: blur(12px);">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="avatar-gradient avatar-gradient-1" style="width: 40px; height: 40px; font-size: 1rem;">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <div>
                            <div class="fw-bold small">Status Database</div>
                            <div class="text-success small fw-semibold"><i class="bi bi-check-circle-fill me-1"></i> Terkoneksi Aktif</div>
                        </div>
                    </div>
                    <div class="small text-white-50 border-top border-white border-opacity-10 pt-2 mt-2">
                        Database: <code>db_sekolah_bu_setyo</code>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistik Cards -->
<div class="row g-3 mb-4">
    <!-- Stat Guru -->
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card-gradient gradient-indigo h-100">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <span class="text-white-50 text-uppercase fw-bold" style="font-size: 0.75rem; letter-spacing: 0.05em;">Total Guru</span>
                    <h2 class="display-6 fw-bold mb-0 mt-1"><?= number_format($total_guru); ?></h2>
                </div>
                <div class="icon-bubble">
                    <i class="bi bi-person-workspace"></i>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2 border-top border-white border-opacity-20 small">
                <span class="text-white-50"><i class="bi bi-award me-1"></i> Tenaga Pendidik</span>
                <a href="<?= BASE_URL ?>/guru/index.php" class="text-white text-decoration-none fw-semibold">Kelola <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </div>

    <!-- Stat Siswa -->
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card-gradient gradient-cyan h-100">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <span class="text-white-50 text-uppercase fw-bold" style="font-size: 0.75rem; letter-spacing: 0.05em;">Total Siswa</span>
                    <h2 class="display-6 fw-bold mb-0 mt-1"><?= number_format($total_siswa); ?></h2>
                </div>
                <div class="icon-bubble">
                    <i class="bi bi-people-fill"></i>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2 border-top border-white border-opacity-20 small">
                <span class="text-white-50"><i class="bi bi-backpack me-1"></i> Peserta Didik</span>
                <a href="<?= BASE_URL ?>/siswa/index.php" class="text-white text-decoration-none fw-semibold">Kelola <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </div>

    <!-- Stat Laki-laki -->
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card-gradient gradient-emerald h-100">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <span class="text-white-50 text-uppercase fw-bold" style="font-size: 0.75rem; letter-spacing: 0.05em;">Siswa Laki-laki</span>
                    <h2 class="display-6 fw-bold mb-0 mt-1"><?= number_format($siswa_l); ?></h2>
                </div>
                <div class="icon-bubble">
                    <i class="bi bi-gender-male"></i>
                </div>
            </div>
            <div class="pt-2 border-top border-white border-opacity-20">
                <div class="d-flex justify-content-between align-items-center small mb-1">
                    <span class="text-white-50">Proporsi</span>
                    <span class="fw-bold"><?= $persen_l; ?>%</span>
                </div>
                <div class="progress" style="height: 5px; background: rgba(255, 255, 255, 0.2);">
                    <div class="progress-bar bg-white" style="width: <?= $persen_l; ?>%;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stat Perempuan -->
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card-gradient gradient-rose h-100">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <span class="text-white-50 text-uppercase fw-bold" style="font-size: 0.75rem; letter-spacing: 0.05em;">Siswa Perempuan</span>
                    <h2 class="display-6 fw-bold mb-0 mt-1"><?= number_format($siswa_p); ?></h2>
                </div>
                <div class="icon-bubble">
                    <i class="bi bi-gender-female"></i>
                </div>
            </div>
            <div class="pt-2 border-top border-white border-opacity-20">
                <div class="d-flex justify-content-between align-items-center small mb-1">
                    <span class="text-white-50">Proporsi</span>
                    <span class="fw-bold"><?= $persen_p; ?>%</span>
                </div>
                <div class="progress" style="height: 5px; background: rgba(255, 255, 255, 0.2);">
                    <div class="progress-bar bg-white" style="width: <?= $persen_p; ?>%;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Interactive Charts Section -->
<div class="row g-4 mb-4">
    <!-- Chart Jurusan -->
    <div class="col-lg-6">
        <div class="card card-modern h-100">
            <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <div class="avatar-gradient avatar-gradient-2" style="width: 34px; height: 34px; font-size: 0.9rem;">
                        <i class="bi bi-pie-chart-fill"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold text-dark mb-0">Distribusi Siswa per Jurusan</h6>
                        <small class="text-muted">Komposisi peserta didik tiap kejuruan</small>
                    </div>
                </div>
                <span class="badge badge-soft-info">Realtime</span>
            </div>
            <div class="card-body p-4 d-flex align-items-center justify-content-center" style="min-height: 280px;">
                <?php if (!empty($jurusan_data)): ?>
                    <div style="position: relative; width: 100%; max-width: 320px; max-height: 250px;">
                        <canvas id="chartJurusan"></canvas>
                    </div>
                <?php else: ?>
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-pie-chart fs-1 d-block mb-2"></i> Belum ada data jurusan.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Chart Status Kepegawaian Guru -->
    <div class="col-lg-6">
        <div class="card card-modern h-100">
            <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <div class="avatar-gradient avatar-gradient-1" style="width: 34px; height: 34px; font-size: 0.9rem;">
                        <i class="bi bi-bar-chart-line-fill"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold text-dark mb-0">Komposisi Guru Pengajar</h6>
                        <small class="text-muted">Berdasarkan status kepegawaian resmi</small>
                    </div>
                </div>
                <span class="badge badge-soft-primary">Terverifikasi</span>
            </div>
            <div class="card-body p-4" style="min-height: 280px;">
                <?php if (!empty($status_data)): ?>
                    <canvas id="chartStatus" style="max-height: 240px;"></canvas>
                <?php else: ?>
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-bar-chart fs-1 d-block mb-2"></i> Belum ada data guru.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Modern Tables Preview Section -->
<div class="row g-4">
    <!-- 5 Guru Terbaru -->
    <div class="col-lg-6">
        <div class="card card-modern h-100">
            <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-person-workspace text-primary me-2"></i> Tenaga Pendidik Terbaru
                    </h6>
                    <small class="text-muted">5 data guru yang baru ditambahkan</small>
                </div>
                <a href="<?= BASE_URL ?>/guru/index.php" class="btn btn-sm btn-modern-outline py-1 px-3">
                    Lihat Semua (<?= $total_guru; ?>) <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-modern mb-0">
                        <thead>
                            <tr>
                                <th>Guru Pengajar</th>
                                <th>Mata Pelajaran</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($q_guru_terbaru) > 0): ?>
                                <?php $color_idx = 1; while ($g = mysqli_fetch_assoc($q_guru_terbaru)): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="avatar-gradient avatar-gradient-<?= ($color_idx++ % 5) + 1; ?>">
                                                    <?= strtoupper(substr($g['nama'], 0, 1)); ?>
                                                </div>
                                                <div>
                                                    <a href="<?= BASE_URL ?>/guru/detail.php?id=<?= $g['id']; ?>" class="fw-bold text-dark text-decoration-none">
                                                        <?= htmlspecialchars($g['nama']); ?><?= !empty($g['gelar']) ? ', ' . htmlspecialchars($g['gelar']) : ''; ?>
                                                    </a>
                                                    <small class="text-muted d-block font-monospace">NIP. <?= htmlspecialchars($g['nip']); ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-info">
                                                <?= htmlspecialchars($g['mata_pelajaran']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php
                                            $st_badge = 'badge-soft-primary';
                                            if ($g['status_kepegawaian'] == 'PNS') $st_badge = 'badge-soft-success';
                                            elseif ($g['status_kepegawaian'] == 'PPPK') $st_badge = 'badge-soft-primary';
                                            elseif ($g['status_kepegawaian'] == 'Guru Tetap') $st_badge = 'badge-soft-purple';
                                            else $st_badge = 'badge-soft-warning';
                                            ?>
                                            <span class="badge <?= $st_badge; ?>">
                                                <?= htmlspecialchars($g['status_kepegawaian']); ?>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-1">
                                                <a href="<?= BASE_URL ?>/guru/detail.php?id=<?= $g['id']; ?>" class="btn-action-icon view" title="Lihat Profil">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="<?= BASE_URL ?>/guru/edit.php?id=<?= $g['id']; ?>" class="btn-action-icon edit" title="Edit Data">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox fs-2 d-block mb-1"></i> Belum ada data guru.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- 5 Siswa Terbaru -->
    <div class="col-lg-6">
        <div class="card card-modern h-100">
            <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-people-fill text-info me-2"></i> Peserta Didik Terbaru
                    </h6>
                    <small class="text-muted">5 data siswa yang baru didaftarkan</small>
                </div>
                <a href="<?= BASE_URL ?>/siswa/index.php" class="btn btn-sm btn-modern-outline py-1 px-3">
                    Lihat Semua (<?= $total_siswa; ?>) <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-modern mb-0">
                        <thead>
                            <tr>
                                <th>Peserta Didik</th>
                                <th>Kelas</th>
                                <th>Jurusan</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($q_siswa_terbaru) > 0): ?>
                                <?php while ($s = mysqli_fetch_assoc($q_siswa_terbaru)): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="avatar-gradient <?= $s['jenis_kelamin'] == 'Laki-laki' ? 'avatar-gradient-2' : 'avatar-gradient-3'; ?>">
                                                    <?= strtoupper(substr($s['nama'], 0, 1)); ?>
                                                </div>
                                                <div>
                                                    <a href="<?= BASE_URL ?>/siswa/detail.php?id=<?= $s['id']; ?>" class="fw-bold text-dark text-decoration-none">
                                                        <?= htmlspecialchars($s['nama']); ?>
                                                    </a>
                                                    <small class="text-muted d-block font-monospace">NISN. <?= htmlspecialchars($s['nisn']); ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark border">
                                                <?= htmlspecialchars($s['kelas']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-primary">
                                                <?= htmlspecialchars($s['jurusan']); ?>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-1">
                                                <a href="<?= BASE_URL ?>/siswa/detail.php?id=<?= $s['id']; ?>" class="btn-action-icon view" title="Lihat Profil">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="<?= BASE_URL ?>/siswa/kartu.php?id=<?= $s['id']; ?>" target="_blank" class="btn-action-icon card-btn" title="Cetak Kartu Siswa">
                                                    <i class="bi bi-person-vcard"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox fs-2 d-block mb-1"></i> Belum ada data siswa.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Chart Donut Jurusan Siswa
    const ctxJurusan = document.getElementById('chartJurusan');
    if (ctxJurusan) {
        new Chart(ctxJurusan, {
            type: 'doughnut',
            data: {
                labels: <?= json_encode($jurusan_labels); ?>,
                datasets: [{
                    data: <?= json_encode($jurusan_data); ?>,
                    backgroundColor: [
                        '#4f46e5',
                        '#0ea5e9',
                        '#10b981',
                        '#f59e0b',
                        '#ec4899',
                        '#8b5cf6'
                    ],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 12,
                            padding: 15,
                            font: { family: "'Plus Jakarta Sans', sans-serif", size: 12 }
                        }
                    }
                },
                cutout: '70%'
            }
        });
    }

    // 2. Chart Bar Status Kepegawaian Guru
    const ctxStatus = document.getElementById('chartStatus');
    if (ctxStatus) {
        new Chart(ctxStatus, {
            type: 'bar',
            data: {
                labels: <?= json_encode($status_labels); ?>,
                datasets: [{
                    label: 'Jumlah Guru',
                    data: <?= json_encode($status_data); ?>,
                    backgroundColor: 'rgba(79, 70, 229, 0.85)',
                    borderRadius: 8,
                    borderSkipped: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1, font: { family: "'Plus Jakarta Sans', sans-serif" } },
                        grid: { color: 'rgba(226, 232, 240, 0.6)' }
                    },
                    x: {
                        ticks: { font: { family: "'Plus Jakarta Sans', sans-serif" } },
                        grid: { display: false }
                    }
                }
            }
        });
    }
});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
