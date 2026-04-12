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
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --bs-primary: #4f46e5;
            --bs-primary-rgb: 79, 70, 229;
            --sidebar-bg-from: #1e3a8a;
            --sidebar-bg-to: #312e81;
            --sidebar-active: rgba(255, 255, 255, 0.15);
            --sidebar-hover: rgba(255, 255, 255, 0.08);
            --bg-body: #f8fafc;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-dark);
        }
        /* Global Overrides */
        .btn-primary { 
            background-color: var(--primary); 
            border-color: var(--primary); 
            transition: all 0.2s ease;
        }
        .btn-primary:hover { 
            background-color: var(--primary-hover); 
            border-color: var(--primary-hover); 
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(5, 150, 105, 0.2), 0 2px 4px -1px rgba(5, 150, 105, 0.1);
        }
        .btn-outline-primary {
            color: var(--primary);
            border-color: var(--primary);
            transition: all 0.2s ease;
        }
        .btn-outline-primary:hover {
            background-color: var(--primary);
            color: white;
            transform: translateY(-1px);
        }

        /* Sidebar Styling */
        #sidebar {
            min-width: 260px;
            max-width: 260px;
            min-height: 100vh;
            background: linear-gradient(180deg, var(--sidebar-bg-from) 0%, var(--sidebar-bg-to) 100%);
            color: #f1f5f9;
            transition: all 0.3s;
            box-shadow: 4px 0 15px rgba(0,0,0,0.05);
            position: relative;
            overflow: hidden;
            z-index: 10;
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

        #sidebar .sidebar-header {
            padding: 25px 20px;
            background: rgba(0,0,0,0.15);
            border-bottom: 1px solid rgba(255,255,255,0.05);
            position: relative;
            z-index: 1;
        }
        
        #sidebar ul.components {
            padding: 20px 0;
            position: relative;
            z-index: 1;
        }

        #sidebar ul li a {
            padding: 12px 20px;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            color: #cbd5e1;
            text-decoration: none;
            transition: all 0.2s ease;
            margin: 4px 12px;
            border-radius: 8px;
            font-weight: 500;
        }
        #sidebar ul li a i { 
            margin-right: 12px;
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }

        #sidebar ul li a:hover {
            color: #fff;
            background: var(--sidebar-hover);
            transform: translateX(3px);
        }
        
        #sidebar ul li a.active {
            color: #fff;
            background: var(--sidebar-active);
            box-shadow: inset 3px 0 0 white;
        }

        .sidebar-user {
            padding: 15px 20px;
            border-top: 1px solid rgba(255,255,255,0.05);
            background: rgba(0,0,0,0.15);
            position: relative;
            z-index: 1;
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
            background: #fff;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05), 0 1px 2px rgba(0,0,0,0.03);
            padding: 15px 30px;
            z-index: 5;
        }
        
        .main-container { padding: 30px; flex: 1; }
        
        .card {
            border: 1px solid var(--border-color);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            border-radius: 12px;
            margin-bottom: 24px;
            background: #fff;
        }
    </style>
    @stack('styles')
</head>
<body>

<div class="d-flex">
    <!-- Sidebar -->
    <nav id="sidebar" class="d-flex flex-column">
        <div class="sidebar-header d-flex align-items-center gap-3">
            <div class="bg-white text-primary rounded p-2 shadow-sm d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                <i class="bi bi-book fs-4 flex-shrink-0"></i>
            </div>
            <div>
                <h5 class="m-0 fw-bold text-white" style="letter-spacing: 0px;">Perpustakaan</h5>
                <small style="color: #94a3b8;">Portal Siswa</small>
            </div>
        </div>

        <ul class="list-unstyled components flex-grow-1">
            <li class="px-4 mb-2 mt-2 text-uppercase" style="font-size: 0.7rem; font-weight: 600; color: #94a3b8; letter-spacing: 0.05em;">Menu Utama</li>
            <li>
                <a href="{{ route('siswa.dashboard') }}" class="{{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-house-door"></i> <span>Beranda</span>
                </a>
            </li>
            
            <li class="px-4 mt-4 mb-2 text-uppercase" style="font-size: 0.7rem; font-weight: 600; color: #94a3b8; letter-spacing: 0.05em;">Layanan</li>
            <li>
                <a href="{{ route('siswa.buku.index') }}" class="{{ request()->routeIs('siswa.buku.*') ? 'active' : '' }}">
                    <i class="bi bi-search"></i> <span>Katalog Buku</span>
                </a>
            </li>
            <li>
                <a href="{{ route('siswa.transaksi.index') }}" class="{{ request()->routeIs('siswa.transaksi.*') ? 'active' : '' }}">
                    <i class="bi bi-journal-bookmark-fill"></i> <span>Riwayat Peminjaman</span>
                </a>
            </li>
        </ul>

        <div class="sidebar-user mt-auto d-flex align-items-center gap-3">
            <div class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 38px; height: 38px; font-weight: 700; font-size: 1.1rem;">
                {{ strtoupper(substr(auth()->user()->name ?? 'S', 0, 1)) }}
            </div>
            <div class="overflow-hidden">
                <div class="fw-bold text-white lh-sm text-truncate" style="font-size: 0.95rem;">{{ auth()->user()->name ?? 'Siswa' }}</div>
                <small style="color: #94a3b8; font-size: 0.8rem;">Siswa</small>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <div id="content">
        <nav class="navbar navbar-expand-lg navbar-light topbar d-flex justify-content-between align-items-center">
            <div>
                <h4 class="m-0 fw-bold" style="color: var(--text-dark);">@yield('page-title', 'Beranda')</h4>
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
                <div class="toast align-items-center text-bg-success border-0 show shadow-lg" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body fw-medium py-3">
                            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-3 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
                @endif
                @if(session('error'))
                <div class="toast align-items-center text-bg-danger border-0 show shadow-lg" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body fw-medium py-3">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-3 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
                @endif
                @if(session('warning'))
                <div class="toast align-items-center text-bg-warning border-0 show shadow-lg" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body fw-medium py-3">
                            <i class="bi bi-exclamation-circle-fill me-2"></i> {{ session('warning') }}
                        </div>
                        <button type="button" class="btn-close me-3 m-auto" data-bs-dismiss="toast"></button>
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
    setTimeout(function() {
        var toasts = document.querySelectorAll('.toast.show');
        toasts.forEach(function(toastNode) {
            var toast = new bootstrap.Toast(toastNode);
            toast.hide();
        });
    }, 4000);
</script>
@stack('scripts')
</body>
</html>
