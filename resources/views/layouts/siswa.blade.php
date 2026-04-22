<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Portal Siswa</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-dark: #1e3a5f;
            --primary: #2c5282;
            --primary-light: #3182ce;
            --primary-soft: #ebf4ff;
            --sidebar-bg-from: #1e3a5f;
            --sidebar-bg-to: #2c5282;
            --sidebar-active: rgba(255, 255, 255, 0.12);
            --sidebar-hover: rgba(255, 255, 255, 0.06);
            --bg-body: #f8fafc;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --border-color: #eef2f6;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-dark);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #e2e8f0;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-dark);
        }

        /* Global Overrides */
        .btn-primary { 
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border: none;
            transition: all 0.3s ease;
            font-weight: 600;
            padding: 8px 20px;
            border-radius: 10px;
        }
        .btn-primary:hover { 
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(44, 82, 130, 0.3);
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
        }
        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-outline-primary {
            border: 2px solid var(--primary);
            color: var(--primary);
            font-weight: 600;
            transition: all 0.3s ease;
            border-radius: 10px;
            background: transparent;
        }
        .btn-outline-primary:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(44, 82, 130, 0.2);
        }

        /* Sidebar Styling */
        #sidebar {
            min-width: 270px;
            max-width: 270px;
            min-height: 100vh;
            background: linear-gradient(180deg, var(--sidebar-bg-from) 0%, var(--sidebar-bg-to) 100%);
            color: #f1f5f9;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 4px 0 20px rgba(0,0,0,0.08);
            position: fixed;
            overflow-y: auto;
            overflow-x: hidden;
            z-index: 1000;
        }

        #sidebar::-webkit-scrollbar {
            width: 4px;
        }
        #sidebar::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.1);
        }
        #sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.3);
        }

        #content {
            margin-left: 270px;
            min-height: 100vh;
            transition: all 0.3s;
        }
        
        #sidebar::before {
            content: '';
            position: absolute;
            top: -50px;
            left: -50px;
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            z-index: 0;
        }

        #sidebar::after {
            content: '';
            position: absolute;
            bottom: -30px;
            right: -30px;
            width: 120px;
            height: 120px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 50%;
            z-index: 0;
        }

        #sidebar .sidebar-header {
            padding: 24px 20px;
            background: rgba(0,0,0,0.2);
            border-bottom: 1px solid rgba(255,255,255,0.08);
            position: relative;
            z-index: 1;
        }
        
        .logo-icon {
            width: 42px;
            height: 42px;
            background: white;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        }

        .logo-icon i {
            font-size: 22px;
            color: var(--primary);
        }

        .logo-text h5 {
            font-size: 18px;
            font-weight: 800;
            letter-spacing: -0.3px;
            margin: 0;
            color: white;
        }

        .logo-text small {
            font-size: 10px;
            color: rgba(255,255,255,0.65);
            font-weight: 500;
        }

        #sidebar ul.components {
            padding: 20px 0;
            position: relative;
            z-index: 1;
        }

        .nav-section {
            padding: 0 20px;
            margin-top: 24px;
            margin-bottom: 12px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255,255,255,0.45);
        }

        .nav-section:first-of-type {
            margin-top: 0;
        }

        #sidebar ul li a {
            padding: 10px 20px;
            margin: 4px 12px;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 12px;
            color: rgba(255,255,255,0.75);
            text-decoration: none;
            transition: all 0.25s ease;
            border-radius: 12px;
        }

        #sidebar ul li a i, 
        #sidebar ul li a .bi {
            font-size: 18px;
            width: 24px;
            text-align: center;
        }

        #sidebar ul li a span {
            flex: 1;
        }

        #sidebar ul li a:hover {
            color: white;
            background: var(--sidebar-hover);
            transform: translateX(4px);
        }
        
        #sidebar ul li a.active {
            color: white;
            background: var(--sidebar-active);
            box-shadow: inset 3px 0 0 white;
        }

        /* Sidebar User Profile */
        .sidebar-user {
            margin: 16px;
            padding: 12px 16px;
            background: rgba(255,255,255,0.08);
            border-radius: 14px;
            transition: all 0.3s;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            border: 1px solid rgba(255,255,255,0.1);
            position: relative;
            z-index: 1;
        }

        .sidebar-user:hover {
            background: rgba(255,255,255,0.12);
            transform: translateY(-2px);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, white 0%, #e2e8f0 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 16px;
            color: var(--primary);
        }

        .user-info .user-name {
            font-size: 13px;
            font-weight: 700;
            color: white;
            margin-bottom: 2px;
        }

        .user-info .user-role {
            font-size: 10px;
            color: rgba(255,255,255,0.6);
            font-weight: 500;
        }

        /* Main Content Styling */
        #content {
            width: 100%;
            min-height: 100vh;
            transition: all 0.3s;
            display: flex;
            flex-direction: column;
        }
        
        .topbar {
            background: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            padding: 16px 28px;
            z-index: 99;
            position: sticky;
            top: 0;
            border-bottom: 1px solid var(--border-color);
        }

        .page-title {
            font-size: 22px;
            font-weight: 800;
            color: var(--primary-dark);
            margin: 0;
            letter-spacing: -0.3px;
        }

        .page-title i {
            color: var(--primary);
            margin-right: 10px;
        }

        .btn-logout {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-logout:hover {
            background: #dc2626;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
        }
        
        .main-container { 
            padding: 28px; 
            flex: 1; 
        }
        
        .card {
            border: 1px solid var(--border-color);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border-radius: 20px;
            margin-bottom: 24px;
            background: #fff;
            transition: all 0.3s;
        }

        .card:hover {
            box-shadow: 0 10px 25px -12px rgba(30, 58, 95, 0.15);
        }

        /* Toast Custom */
        .toast-custom {
            border-radius: 14px;
            border: none;
            box-shadow: 0 15px 30px -10px rgba(0,0,0,0.15);
        }

        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .fade-in {
            animation: fadeIn 0.3s ease forwards;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            #sidebar {
                margin-left: -270px;
                position: fixed;
                z-index: 1050;
            }
            #sidebar.active {
                margin-left: 0;
            }
            #content {
                margin-left: 0;
            }
            .topbar {
                padding: 12px 20px;
            }
            .main-container {
                padding: 20px;
            }
            .page-title {
                font-size: 18px;
            }
        }
    </style>
    @stack('styles')
</head>
<body>

<div class="d-flex">
    <!-- Sidebar -->
    <nav id="sidebar" class="d-flex flex-column">
        <div class="sidebar-header">
            <div class="d-flex align-items-center gap-3">
                <div class="logo-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="logo-text">
                    <h5>Perpustakaan</h5>
                    <small>Digital Library System</small>
                </div>
            </div>
        </div>

        <ul class="list-unstyled components flex-grow-1">
            <li class="nav-section">
                <i class="fas fa-compass me-1"></i> Menu Utama
            </li>
            <li>
                <a href="{{ route('siswa.dashboard') }}" class="{{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i> <span>Beranda</span>
                </a>
            </li>
            
            <li class="nav-section">
                <i class="fas fa-cubes me-1"></i> Layanan
            </li>
            <li>
                <a href="{{ route('siswa.buku.index') }}" class="{{ request()->routeIs('siswa.buku.*') ? 'active' : '' }}">
                    <i class="fas fa-book-open"></i> <span>Katalog Buku</span>
                </a>
            </li>
            <li>
                <a href="{{ route('siswa.transaksi.index') }}" class="{{ request()->routeIs('siswa.transaksi.*') ? 'active' : '' }}">
                    <i class="fas fa-history"></i> <span>Riwayat Peminjaman</span>
                </a>
            </li>
        </ul>

        <!-- Profile Section -->
        <a href="{{ route('siswa.profile') }}" class="sidebar-user mt-auto">
            <div class="user-avatar">
                {{ strtoupper(substr(auth()->user()->name ?? 'S', 0, 1)) }}
            </div>
            <div class="user-info">
                <div class="user-name">{{ auth()->user()->name ?? 'Siswa' }}</div>
                <div class="user-role">
                    <i class="fas fa-user-graduate me-1" style="font-size: 9px;"></i> Akun Siswa
                </div>
            </div>
            <i class="fas fa-chevron-right ms-auto" style="font-size: 11px; opacity: 0.5;"></i>
        </a>
    </nav>

    <!-- Page Content -->
    <div id="content">
        <nav class="topbar d-flex justify-content-between align-items-center">
            <div>
                <h4 class="page-title">
                    @yield('page-title', 'Beranda')
                </h4>
            </div>
            <div class="d-flex align-items-center gap-3">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-light rounded-circle shadow-sm d-flex align-items-center justify-content-center p-0" style="width: 40px; height: 40px; border: 1px solid #e2e8f0; color: #ef4444;" title="Keluar">
                        <i class="bi bi-box-arrow-right"></i>
                    </button>
                </form>
            </div>
        </nav>

        <div class="main-container">
            <div class="toast-container position-fixed top-0 end-0 p-4" style="z-index: 1055;">
                @if(session('success'))
                <div class="toast align-items-center border-0 show shadow-lg fade-in" role="alert" style="background: linear-gradient(135deg, #15803d 0%, #166534 100%); border-radius: 12px;">
                    <div class="d-flex">
                        <div class="toast-body text-white fw-medium py-3">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-3 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
                @endif
                @if(session('error'))
                <div class="toast align-items-center border-0 show shadow-lg fade-in" role="alert" style="background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); border-radius: 12px;">
                    <div class="d-flex">
                        <div class="toast-body text-white fw-medium py-3">
                            <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-3 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
                @endif
                @if(session('warning'))
                <div class="toast align-items-center border-0 show shadow-lg fade-in" role="alert" style="background: linear-gradient(135deg, #d97706 0%, #b45309 100%); border-radius: 12px;">
                    <div class="d-flex">
                        <div class="toast-body text-white fw-medium py-3">
                            <i class="fas fa-info-circle me-2"></i> {{ session('warning') }}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-3 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
                @endif
            </div>

            @yield('content')
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Auto hide toasts after 4 seconds
    setTimeout(function() {
        var toasts = document.querySelectorAll('.toast.show');
        toasts.forEach(function(toastNode) {
            var toast = bootstrap.Toast.getInstance(toastNode);
            if (toast) toast.hide();
        });
    }, 4000);

    // Mobile sidebar toggle
    var sidebarToggle = document.getElementById('sidebarToggle');
    var sidebar = document.getElementById('sidebar');
    
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('active');
        });
    }

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(event) {
        if (window.innerWidth <= 768) {
            if (sidebar && !sidebar.contains(event.target) && sidebarToggle && !sidebarToggle.contains(event.target)) {
                sidebar.classList.remove('active');
            }
        }
    });
</script>
@stack('scripts')
</body>
</html>