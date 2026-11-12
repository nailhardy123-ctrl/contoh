<?php
// Pastikan database sudah terhubung
if (!isset($koneksi)) {
    require_once __DIR__ . '/../config/database.php';
}

// Deteksi halaman aktif untuk penanda navbar
$current_page = basename($_SERVER['PHP_SELF']);
$current_dir = basename(dirname($_SERVER['PHP_SELF']));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($page_title) ? htmlspecialchars($page_title) . ' - ' : ''; ?>SIAKAD &bull; Data Guru & Siswa Bu Setyo</title>
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.8/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>

    <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --primary-light: #eef2ff;
            --secondary: #0ea5e9;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --dark: #0f172a;
            --dark-card: #1e293b;
            --surface: #ffffff;
            --bg-page: #f8fafc;
            --border-color: #e2e8f0;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --radius-sm: 8px;
            --radius-md: 14px;
            --radius-lg: 20px;
            --radius-xl: 28px;
            --shadow-subtle: 0 1px 3px 0 rgba(0, 0, 0, 0.05), 0 1px 2px -1px rgba(0, 0, 0, 0.05);
            --shadow-card: 0 10px 25px -5px rgba(15, 23, 42, 0.05), 0 8px 10px -6px rgba(15, 23, 42, 0.03);
            --shadow-hover: 0 20px 35px -10px rgba(79, 70, 229, 0.12), 0 10px 15px -3px rgba(15, 23, 42, 0.05);
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: var(--bg-page);
            background-image: 
                radial-gradient(at 0% 0%, rgba(99, 102, 241, 0.07) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(14, 165, 233, 0.06) 0px, transparent 50%),
                radial-gradient(at 50% 100%, rgba(244, 63, 94, 0.04) 0px, transparent 50%);
            background-attachment: fixed;
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            letter-spacing: -0.01em;
            -webkit-font-smoothing: antialiased;
        }

        .main-content {
            flex: 1 0 auto;
        }

        /* ---------------- NAVBAR ---------------- */
        .navbar-premium {
            background: rgba(15, 23, 42, 0.92);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            padding: 0.9rem 0;
            transition: all 0.3s ease;
        }

        .navbar-brand-modern {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: #ffffff;
        }

        .brand-logo-glow {
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, #6366f1 0%, #3b82f6 50%, #06b6d4 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.25rem;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.45);
            transition: transform 0.3s ease;
        }

        .navbar-brand-modern:hover .brand-logo-glow {
            transform: scale(1.05) rotate(-3deg);
        }

        .brand-title {
            font-weight: 800;
            font-size: 1.15rem;
            color: #ffffff;
            line-height: 1.2;
            letter-spacing: -0.02em;
        }

        .brand-subtitle {
            font-size: 0.72rem;
            color: #94a3b8;
            font-weight: 500;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .nav-pill-modern {
            color: #94a3b8 !important;
            font-weight: 600;
            font-size: 0.9rem;
            padding: 0.55rem 1.1rem !important;
            border-radius: 12px;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            margin: 0 3px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .nav-pill-modern:hover {
            color: #ffffff !important;
            background-color: rgba(255, 255, 255, 0.08);
            transform: translateY(-1px);
        }

        .nav-pill-modern.active {
            color: #ffffff !important;
            background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%) !important;
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.45);
        }

        /* ---------------- CARDS ---------------- */
        .card-modern {
            background-color: var(--surface);
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-card);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
        }

        .card-modern:hover {
            box-shadow: var(--shadow-hover);
        }

        .card-interactive {
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .card-interactive:hover {
            transform: translateY(-4px);
        }

        /* ---------------- STAT CARDS ---------------- */
        .stat-card-gradient {
            border-radius: var(--radius-lg);
            border: none;
            padding: 1.6rem 1.5rem;
            position: relative;
            overflow: hidden;
            color: white;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .stat-card-gradient:hover {
            transform: translateY(-4px);
        }

        .stat-card-gradient::after {
            content: '';
            position: absolute;
            top: -40px;
            right: -40px;
            width: 140px;
            height: 140px;
            background: rgba(255, 255, 255, 0.12);
            border-radius: 50%;
            pointer-events: none;
        }

        .stat-card-gradient .icon-bubble {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .gradient-indigo {
            background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);
            box-shadow: 0 10px 25px -5px rgba(79, 70, 229, 0.4);
        }

        .gradient-cyan {
            background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
            box-shadow: 0 10px 25px -5px rgba(2, 132, 199, 0.4);
        }

        .gradient-rose {
            background: linear-gradient(135deg, #e11d48 0%, #be123c 100%);
            box-shadow: 0 10px 25px -5px rgba(225, 29, 72, 0.4);
        }

        .gradient-emerald {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            box-shadow: 0 10px 25px -5px rgba(5, 150, 105, 0.4);
        }

        /* ---------------- MODERN BUTTONS ---------------- */
        .btn-modern-primary {
            background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
            color: #ffffff;
            border: none;
            font-weight: 600;
            padding: 0.65rem 1.35rem;
            border-radius: 12px;
            box-shadow: 0 4px 14px rgba(79, 70, 229, 0.35);
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-modern-primary:hover {
            color: #ffffff;
            background: linear-gradient(135deg, #4338ca 0%, #3730a3 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(79, 70, 229, 0.45);
        }

        .btn-modern-outline {
            background: #ffffff;
            color: var(--text-main);
            border: 1px solid var(--border-color);
            font-weight: 600;
            padding: 0.65rem 1.25rem;
            border-radius: 12px;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-modern-outline:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
            color: var(--primary);
            transform: translateY(-1px);
        }

        .btn-action-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--border-color);
            background: white;
            color: var(--text-muted);
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .btn-action-icon:hover {
            transform: scale(1.08);
            border-color: currentColor;
        }

        .btn-action-icon.view:hover { color: #0284c7; background: #e0f2fe; }
        .btn-action-icon.edit:hover { color: #d97706; background: #fef3c7; }
        .btn-action-icon.delete:hover { color: #dc2626; background: #fee2e2; }
        .btn-action-icon.card-btn:hover { color: #7c3aed; background: #ede9fe; }

        /* ---------------- MODERN TABLE ---------------- */
        .table-modern {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin: 0;
        }

        .table-modern thead th {
            background-color: #f8fafc;
            color: #475569;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            padding: 1rem 1.25rem;
            border-bottom: 2px solid #e2e8f0;
            white-space: nowrap;
        }

        .table-modern tbody tr {
            transition: all 0.2s ease;
        }

        .table-modern tbody tr:hover {
            background-color: #f8fafc;
        }

        .table-modern tbody td {
            padding: 1.1rem 1.25rem;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
            font-size: 0.925rem;
        }

        /* ---------------- BADGES & AVATARS ---------------- */
        .badge-soft {
            font-weight: 600;
            padding: 0.45rem 0.85rem;
            border-radius: 8px;
            font-size: 0.8rem;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .badge-soft-primary { background-color: #eef2ff; color: #4338ca; }
        .badge-soft-success { background-color: #ecfdf5; color: #047857; }
        .badge-soft-warning { background-color: #fffbeb; color: #b45309; }
        .badge-soft-info { background-color: #e0f2fe; color: #0369a1; }
        .badge-soft-purple { background-color: #f5f3ff; color: #6d28d9; }
        .badge-soft-danger { background-color: #fef2f2; color: #b91c1c; }

        .avatar-gradient {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1rem;
            color: white;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
            flex-shrink: 0;
        }

        .avatar-gradient-1 { background: linear-gradient(135deg, #6366f1, #4f46e5); }
        .avatar-gradient-2 { background: linear-gradient(135deg, #06b6d4, #0284c7); }
        .avatar-gradient-3 { background: linear-gradient(135deg, #ec4899, #be185d); }
        .avatar-gradient-4 { background: linear-gradient(135deg, #10b981, #059669); }
        .avatar-gradient-5 { background: linear-gradient(135deg, #8b5cf6, #6d28d9); }

        /* ---------------- FORM STYLING ---------------- */
        .form-control-modern, .form-select-modern {
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            color: var(--text-main);
            background-color: #ffffff;
            transition: all 0.2s ease;
        }

        .form-control-modern:focus, .form-select-modern:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15);
            outline: none;
            background-color: #ffffff;
        }

        .form-label-modern {
            font-weight: 600;
            font-size: 0.875rem;
            color: #334155;
            margin-bottom: 0.45rem;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* ---------------- BREADCRUMB ---------------- */
        .breadcrumb-modern {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 0.5rem;
            font-size: 0.85rem;
        }

        .breadcrumb-modern a {
            color: #64748b;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.15s ease;
        }

        .breadcrumb-modern a:hover {
            color: var(--primary);
        }

        .breadcrumb-modern .active {
            color: #1e293b;
            font-weight: 600;
        }

        .breadcrumb-separator {
            color: #cbd5e1;
            font-size: 0.75rem;
        }

        /* ---------------- HERO / BANNER ---------------- */
        .hero-banner-modern {
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #172554 100%);
            border-radius: var(--radius-xl);
            padding: 2.25rem;
            color: white;
            position: relative;
            overflow: hidden;
            box-shadow: 0 15px 35px -5px rgba(15, 23, 42, 0.25);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .hero-banner-modern::before {
            content: '';
            position: absolute;
            top: -60px;
            right: -60px;
            width: 260px;
            height: 260px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.3) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .hero-banner-modern::after {
            content: '';
            position: absolute;
            bottom: -60px;
            left: 20%;
            width: 220px;
            height: 220px;
            background: radial-gradient(circle, rgba(14, 165, 233, 0.25) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        /* ---------------- PULSE LIVE BADGE ---------------- */
        .live-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: #10b981;
            display: inline-block;
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
            animation: pulse-green 2s infinite;
        }

        @keyframes pulse-green {
            0% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
            }
            70% {
                transform: scale(1);
                box-shadow: 0 0 0 8px rgba(16, 185, 129, 0);
            }
            100% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
            }
        }
    </style>
</head>
<body>

<!-- Modern Floating Navbar -->
<nav class="navbar navbar-expand-lg navbar-premium sticky-top">
    <div class="container">
        <a class="navbar-brand-modern" href="<?= BASE_URL ?>/index.php">
            <div class="brand-logo-glow">
                <i class="bi bi-mortarboard-fill"></i>
            </div>
            <div>
                <div class="brand-title">SIAKAD <span class="badge bg-primary bg-opacity-75 text-white fw-semibold rounded-pill px-2 py-0 ms-1" style="font-size: 0.68rem;">Pro</span></div>
                <div class="brand-subtitle"><span class="live-dot me-1"></span> Tugas Bu Setyo</div>
            </div>
        </a>

        <button class="navbar-toggler text-white border-0 shadow-none p-1" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <i class="bi bi-grid-fill fs-3 text-white"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0 py-2 py-lg-0">
                <li class="nav-item">
                    <a class="nav-pill-modern <?= ($current_page == 'index.php' && $current_dir != 'siswa' && $current_dir != 'guru') ? 'active' : ''; ?>" href="<?= BASE_URL ?>/index.php">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-pill-modern <?= ($current_dir == 'guru') ? 'active' : ''; ?>" href="<?= BASE_URL ?>/guru/index.php">
                        <i class="bi bi-person-workspace"></i> Data Guru
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-pill-modern <?= ($current_dir == 'siswa') ? 'active' : ''; ?>" href="<?= BASE_URL ?>/siswa/index.php">
                        <i class="bi bi-people-fill"></i> Data Siswa
                    </a>
                </li>
            </ul>

            <div class="d-flex align-items-center gap-2 pt-2 pt-lg-0">
                <div class="d-none d-xl-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small me-1">
                    <i class="bi bi-calendar2-check text-info"></i>
                    <span><?= date('l, d M Y'); ?></span>
                </div>
                <a href="<?= BASE_URL ?>/database.sql" download class="btn btn-sm btn-outline-light rounded-pill px-3 py-1 d-inline-flex align-items-center gap-1">
                    <i class="bi bi-database-down"></i> <span class="small fw-semibold">SQL Backup</span>
                </a>
            </div>
        </div>
    </div>
</nav>

<div class="main-content py-4">
    <div class="container">
        <?php if (isset($_SESSION['pesan'])): ?>
            <div class="alert alert-<?= $_SESSION['tipe_pesan'] ?? 'info'; ?> alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4 py-3 px-4 d-flex align-items-center justify-content-between" role="alert">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: rgba(255, 255, 255, 0.4);">
                        <?php if (($_SESSION['tipe_pesan'] ?? '') == 'success'): ?>
                            <i class="bi bi-check-lg fs-5 text-success"></i>
                        <?php elseif (($_SESSION['tipe_pesan'] ?? '') == 'danger'): ?>
                            <i class="bi bi-x-lg fs-5 text-danger"></i>
                        <?php else: ?>
                            <i class="bi bi-info-lg fs-5 text-primary"></i>
                        <?php endif; ?>
                    </div>
                    <div>
                        <div class="fw-bold mb-0">
                            <?= ($_SESSION['tipe_pesan'] ?? '') == 'success' ? 'Berhasil Disimpan' : 'Pemberitahuan'; ?>
                        </div>
                        <div class="small opacity-75"><?= $_SESSION['pesan']; ?></div>
                    </div>
                </div>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php 
                unset($_SESSION['pesan']);
                unset($_SESSION['tipe_pesan']);
            ?>
        <?php endif; ?>
