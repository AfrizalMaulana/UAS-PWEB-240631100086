<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../functions/functions.php';

$currentPage = basename($_SERVER['PHP_SELF'], '.php');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sistem Inventaris Barang</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Google Fonts (Inter) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />

    <style>
        /* ============================================================
               GLOBAL & RESET
            ============================================================ */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f0f4f9;
            display: flex;
            min-height: 100vh;
            color: #1e293b;
        }

        a {
            text-decoration: none;
        }

        /* ============================================================
               SIDEBAR
            ============================================================ */
        .sidebar {
            width: 270px;
            background: linear-gradient(180deg, #0f1724 0%, #1a3a6b 100%);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 1050;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.15);
            color: #e2e8f0;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 28px 24px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            font-weight: 700;
            font-size: 1.3rem;
            color: #ffffff;
        }

        .sidebar-brand i {
            font-size: 2rem;
            color: #60a5fa;
            filter: drop-shadow(0 0 6px rgba(96, 165, 250, 0.4));
        }

        .sidebar-brand span {
            letter-spacing: 0.5px;
        }

        .sidebar-nav {
            flex: 1;
            padding: 24px 16px;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 18px;
            border-radius: 12px;
            color: rgba(255, 255, 255, 0.7);
            font-weight: 500;
            transition: all 0.25s ease;
            font-size: 0.95rem;
            position: relative;
        }

        .sidebar-nav .nav-link i {
            font-size: 1.2rem;
            width: 26px;
            text-align: center;
        }

        .sidebar-nav .nav-link:hover {
            background: rgba(255, 255, 255, 0.08);
            color: #ffffff;
            transform: translateX(4px);
        }

        .sidebar-nav .nav-link.active {
            background: rgba(255, 255, 255, 0.15);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .sidebar-nav .nav-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 20%;
            height: 60%;
            width: 4px;
            background: #60a5fa;
            border-radius: 0 6px 6px 0;
        }

        .sidebar-footer {
            padding: 18px 24px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.4);
            text-align: center;
            letter-spacing: 0.5px;
        }

        /* ============================================================
               MAIN CONTENT
            ============================================================ */
        .main-content {
            flex: 1;
            margin-left: 270px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: #f0f4f9;
        }

        /* ============================================================
               NAVBAR TOP
            ============================================================ */
        .navbar-top {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            padding: 14px 32px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.04);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1040;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        }

        .navbar-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .btn-toggle-sidebar {
            background: none;
            border: none;
            font-size: 1.6rem;
            color: #1e293b;
            display: none;
            cursor: pointer;
            padding: 0 4px;
            transition: color 0.2s;
        }

        .btn-toggle-sidebar:hover {
            color: #2563eb;
        }

        .page-title {
            font-weight: 700;
            font-size: 1.2rem;
            margin: 0;
            color: #0f1724;
            letter-spacing: -0.3px;
        }

        .navbar-right .user-badge {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(37, 99, 235, 0.08);
            padding: 6px 18px 6px 12px;
            border-radius: 40px;
            color: #1e293b;
            font-weight: 600;
            font-size: 0.9rem;
            border: 1px solid rgba(37, 99, 235, 0.1);
        }

        .navbar-right .user-badge i {
            font-size: 1.4rem;
            color: #2563eb;
        }

        /* ============================================================
               PAGE CONTENT
            ============================================================ */
        .page-content {
            padding: 32px 32px 40px;
            flex: 1;
        }

        /* ============================================================
               STAT CARDS
            ============================================================ */
        .stat-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 24px 24px;
            display: flex;
            align-items: center;
            gap: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
            border: 1px solid rgba(0, 0, 0, 0.03);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: default;
            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 30px rgba(0, 0, 0, 0.08);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            flex-shrink: 0;
        }

        .stat-card-primary .stat-icon {
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            color: #2563eb;
        }
        .stat-card-success .stat-icon {
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            color: #059669;
        }
        .stat-card-info .stat-icon {
            background: linear-gradient(135deg, #e0f2fe, #bae6fd);
            color: #0284c7;
        }
        .stat-card-danger .stat-icon {
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            color: #dc2626;
        }

        .stat-info h3 {
            font-size: 2rem;
            font-weight: 800;
            margin: 0;
            color: #0f1724;
            line-height: 1.2;
        }

        .stat-info p {
            margin: 0;
            color: #64748b;
            font-weight: 500;
            font-size: 0.95rem;
        }

        /* ============================================================
               CARD MODERN
            ============================================================ */
        .card-modern {
            background: #ffffff;
            border-radius: 20px;
            border: 1px solid rgba(0, 0, 0, 0.03);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
            overflow: hidden;
            transition: box-shadow 0.3s ease;
        }

        .card-modern:hover {
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
        }

        .card-header-modern {
            padding: 18px 24px;
            border-bottom: 1px solid #f1f5f9;
            background: #fafcff;
        }

        .card-header-modern h5 {
            margin: 0;
            font-weight: 700;
            color: #0f1724;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.05rem;
        }

        .card-header-modern h5 i {
            color: #2563eb;
        }

        /* ============================================================
               TABLE MODERN
            ============================================================ */
        .table-modern {
            font-size: 0.9rem;
            color: #1e293b;
        }

        .table-modern thead th {
            background: #f8fafc;
            color: #334155;
            font-weight: 600;
            border-bottom: 2px solid #e9edf4;
            padding: 14px 18px;
            white-space: nowrap;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
        }

        .table-modern tbody td {
            padding: 14px 18px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }

        .table-modern tbody tr {
            transition: background 0.15s ease;
        }

        .table-modern tbody tr:hover {
            background: #f8fafc;
        }

        .badge-code {
            background: #eef2ff;
            color: #1e293b;
            padding: 4px 12px;
            border-radius: 30px;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.3px;
            border: 1px solid #c7d2fe;
        }

        .badge-baik {
            background: #dcfce7;
            color: #166534;
            font-weight: 600;
            padding: 5px 14px;
            border-radius: 40px;
            font-size: 0.75rem;
        }

        .badge-rusak {
            background: #fee2e2;
            color: #991b1b;
            font-weight: 600;
            padding: 5px 14px;
            border-radius: 40px;
            font-size: 0.75rem;
        }

        /* ============================================================
               BUTTONS
            ============================================================ */
        .btn-primary {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            border: none;
            padding: 8px 24px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.25s ease;
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.25);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.35);
            background: linear-gradient(135deg, #1d4ed8, #1e40af);
        }

        .btn-success {
            background: linear-gradient(135deg, #059669, #047857);
            border: none;
            border-radius: 12px;
            font-weight: 600;
            box-shadow: 0 4px 10px rgba(5, 150, 105, 0.25);
        }
        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(5, 150, 105, 0.35);
        }

        .btn-warning {
            background: #f59e0b;
            border: none;
            color: #ffffff;
            border-radius: 10px;
            font-weight: 600;
        }
        .btn-warning:hover {
            background: #d97706;
            transform: translateY(-2px);
        }

        .btn-danger {
            background: #ef4444;
            border: none;
            border-radius: 10px;
            font-weight: 600;
        }
        .btn-danger:hover {
            background: #dc2626;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: #e2e8f0;
            border: none;
            color: #1e293b;
            border-radius: 12px;
            font-weight: 600;
        }
        .btn-secondary:hover {
            background: #cbd5e1;
            color: #0f1724;
            transform: translateY(-2px);
        }

        .btn-sm {
            padding: 6px 14px;
            font-size: 0.8rem;
        }

        /* ============================================================
               FORM
            ============================================================ */
        .form-control, .form-select {
            border-radius: 12px;
            border: 1.5px solid #e2e8f0;
            padding: 12px 16px;
            font-size: 0.95rem;
            background: #ffffff;
            transition: all 0.25s ease;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.02);
        }

        .form-control:focus, .form-select:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12), inset 0 1px 2px rgba(0, 0, 0, 0.02);
        }

        .form-control:hover, .form-select:hover {
            border-color: #94a3b8;
        }

        .form-label {
            font-weight: 600;
            color: #334155;
            font-size: 0.85rem;
            margin-bottom: 6px;
            letter-spacing: 0.3px;
        }

        .form-label .text-danger {
            color: #ef4444;
        }

        /* Floating label effect (optional) – but we keep standard */
        .form-group-floating {
            position: relative;
        }

        .form-group-floating .form-control {
            padding-top: 20px;
            padding-bottom: 8px;
        }

        .form-group-floating .form-label {
            position: absolute;
            top: 6px;
            left: 16px;
            font-size: 0.7rem;
            color: #64748b;
            pointer-events: none;
            transition: all 0.2s;
        }

        /* ============================================================
               RESPONSIVE
            ============================================================ */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
            }
            .btn-toggle-sidebar {
                display: inline-block;
            }
            .stat-card {
                padding: 20px 18px;
            }
        }

        @media (max-width: 768px) {
            .navbar-top {
                padding: 12px 16px;
            }
            .page-content {
                padding: 16px;
            }
            .stat-card h3 {
                font-size: 1.5rem;
            }
            .stat-icon {
                width: 48px;
                height: 48px;
                font-size: 1.4rem;
            }
            .table-modern {
                font-size: 0.8rem;
            }
            .table-modern thead th,
            .table-modern tbody td {
                padding: 10px 12px;
            }
            .card-header-modern {
                padding: 14px 16px;
                flex-wrap: wrap;
            }
            .card-header-modern h5 {
                font-size: 0.95rem;
            }
        }

        @media (max-width: 576px) {
            .sidebar-brand {
                padding: 20px 16px;
                font-size: 1.1rem;
            }
            .sidebar-nav .nav-link {
                font-size: 0.85rem;
                padding: 10px 14px;
            }
            .stat-card {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }
            .stat-info h3 {
                font-size: 1.8rem;
            }
        }

        /* ============================================================
               ANIMATIONS
            ============================================================ */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade {
            animation: fadeInUp 0.5s ease forwards;
        }

        .stat-card {
            animation: fadeInUp 0.6s ease forwards;
        }
        .stat-card:nth-child(2) {
            animation-delay: 0.1s;
        }
        .stat-card:nth-child(3) {
            animation-delay: 0.2s;
        }
        .stat-card:nth-child(4) {
            animation-delay: 0.3s;
        }

        .card-modern {
            animation: fadeInUp 0.7s ease forwards;
        }
    </style>
</head>
<body>

    <!-- ===== SIDEBAR ===== -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <i class="bi bi-box-seam"></i>
            <span>Inventaris</span>
        </div>
        <nav class="sidebar-nav">
            <a href="index.php" class="nav-link <?= ($currentPage === 'index') ? 'active' : '' ?>">
                <i class="bi bi-grid-1x2-fill"></i> Dashboard
            </a>
            <a href="daftar.php" class="nav-link <?= ($currentPage === 'daftar') ? 'active' : '' ?>">
                <i class="bi bi-table"></i> Daftar Barang
            </a>
            <a href="tambah.php" class="nav-link <?= ($currentPage === 'tambah') ? 'active' : '' ?>">
                <i class="bi bi-plus-circle"></i> Tambah Barang
            </a>
        </nav>
        <div class="sidebar-footer">
            <span>UAS PWEB 2026</span>
        </div>
    </aside>

    <!-- ===== MAIN CONTENT ===== -->
    <main class="main-content" id="mainContent">

        <!-- ===== NAVBAR ===== -->
        <nav class="navbar-top">
            <div class="navbar-left">
                <button class="btn-toggle-sidebar" id="btnToggleSidebar">
                    <i class="bi bi-list"></i>
                </button>
                <h5 class="page-title">
                    <?php
                        switch ($currentPage) {
                            case 'index':  echo 'Dashboard'; break;
                            case 'daftar': echo 'Daftar Barang'; break;
                            case 'tambah': echo 'Tambah Barang'; break;
                            case 'edit':   echo 'Edit Barang'; break;
                            default:       echo 'Inventaris';
                        }
                    ?>
                </h5>
            </div>
            <div class="navbar-right">
                <span class="user-badge">
                    <i class="bi bi-person-circle"></i> Admin
                </span>
            </div>
        </nav>

        <!-- ===== PAGE CONTENT ===== -->
        <div class="page-content">
            <!-- Notifikasi flash -->
            <?php if (isset($_SESSION['flash'])): ?>
                <div class="alert alert-<?= $_SESSION['flash']['type'] ?> alert-dismissible fade show animate-fade" role="alert" style="border-radius: 16px; border: none; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                    <i class="bi bi-<?= $_SESSION['flash']['type'] === 'success' ? 'check-circle' : 'exclamation-circle' ?> me-2"></i>
                    <?= $_SESSION['flash']['message'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['flash']); ?>
            <?php endif; ?>
