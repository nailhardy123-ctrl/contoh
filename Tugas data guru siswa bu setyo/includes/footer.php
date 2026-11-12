    </div> <!-- .container -->
</div> <!-- .main-content -->

<!-- Modern Footer -->
<footer class="mt-5 pt-4 pb-3" style="background-color: #ffffff; border-top: 1px solid #e2e8f0;">
    <div class="container">
        <div class="row align-items-center gy-3">
            <div class="col-md-6 text-center text-md-start">
                <div class="d-flex align-items-center justify-content-center justify-content-md-start gap-2 mb-1">
                    <span class="fw-bold text-dark">SIAKAD Pro &bull; Data Guru & Siswa</span>
                    <span class="badge bg-primary bg-opacity-10 text-primary fw-semibold rounded-pill px-2">v2.0 Modern</span>
                </div>
                <p class="text-muted small mb-0">
                    Proyek Tugas Pemrograman Web &amp; Basis Data &bull; Dosen / Guru Pengampu: <strong>Dra. Setyo Rahayu, M.Pd.</strong>
                </p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-end gap-2">
                    <span class="badge bg-light text-secondary border px-3 py-2 rounded-pill small">
                        <i class="bi bi-code-slash text-primary me-1"></i> PHP 8.1
                    </span>
                    <span class="badge bg-light text-secondary border px-3 py-2 rounded-pill small">
                        <i class="bi bi-database text-info me-1"></i> MySQL 8
                    </span>
                    <span class="badge bg-light text-secondary border px-3 py-2 rounded-pill small">
                        <i class="bi bi-bootstrap-fill text-purple me-1" style="color: #7952b3;"></i> Bootstrap 5.3
                    </span>
                    <span class="badge bg-light text-secondary border px-3 py-2 rounded-pill small">
                        <i class="bi bi-pie-chart-fill text-success me-1"></i> Chart.js
                    </span>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Bootstrap 5 Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.8/dist/sweetalert2.all.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Inisialisasi Tooltip Bootstrap jika ada
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Konfirmasi Hapus Data dengan SweetAlert2 Modern
        const deleteButtons = document.querySelectorAll('.btn-hapus-konfirmasi');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const url = this.getAttribute('href');
                const nama = this.getAttribute('data-nama') || 'data ini';

                Swal.fire({
                    title: 'Konfirmasi Penghapusan',
                    html: `Apakah Anda yakin ingin menghapus data <strong class="text-danger">${nama}</strong>?<br><small class="text-muted">Tindakan ini tidak dapat dibatalkan.</small>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: '<i class="bi bi-trash3-fill me-1"></i> Ya, Hapus Data',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    customClass: {
                        popup: 'rounded-4 shadow-lg border-0 p-4',
                        confirmButton: 'rounded-pill px-4 py-2 fw-semibold',
                        cancelButton: 'rounded-pill px-4 py-2 fw-semibold'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            });
        });
    });
</script>
</body>
</html>
