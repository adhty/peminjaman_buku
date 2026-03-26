<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Admin Perpustakaan</title>

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
        .bg-primary { background-color: var(--primary) !important; }
        .text-primary { color: var(--primary) !important; }
        .btn-primary { 
            background-color: var(--primary); 
            border-color: var(--primary); 
            transition: all 0.2s ease;
        }
        .btn-primary:hover { 
            background-color: var(--primary-hover); 
            border-color: var(--primary-hover); 
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2), 0 2px 4px -1px rgba(79, 70, 229, 0.1);
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
        /* Top bubble effect */
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
        
        /* Cards */
        .card {
            border: 1px solid var(--border-color);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            border-radius: 12px;
            margin-bottom: 24px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            background: #fff;
        }

        .card-header {
            background-color: #fff;
            border-bottom: 1px solid var(--border-color);
            padding: 18px 24px;
            font-weight: 600;
            border-top-left-radius: 12px !important;
            border-top-right-radius: 12px !important;
            color: var(--text-dark);
        }
        
        /* Table Styles to ensure they look modern */
        .table {
            margin-bottom: 0;
            color: var(--text-dark);
        }
        .table > :not(caption) > * > * {
            padding: 1rem 1.25rem;
            border-bottom-color: var(--border-color);
        }
        .table th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            color: var(--text-muted);
            background-color: #f8fafc;
        }
        
        /* Interactive element transitions */
        a { color: var(--primary); text-decoration: none; transition: color 0.15s; }
        a:hover { color: var(--primary-hover); }
        
        /* Standardizing badges */
        .badge {
            font-weight: 500;
            padding: 0.35em 0.65em;
            border-radius: 6px;
        }
        
        /* Form Controls */
        .form-control, .form-select {
            border-color: #cbd5e1;
            padding: 0.5rem 0.75rem;
            border-radius: 6px;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.15);
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
                <i class="bi bi-book-half fs-4 flex-shrink-0"></i>
            </div>
            <div>
                <h5 class="m-0 fw-bold text-white" style="letter-spacing: 0px;">Perpustakaan</h5>
                <small style="color: #94a3b8;">Sistem Digital</small>
            </div>
        </div>

        <ul class="list-unstyled components flex-grow-1">
            <li class="px-4 mb-2 mt-2 text-uppercase" style="font-size: 0.7rem; font-weight: 600; color: #94a3b8; letter-spacing: 0.05em;">Menu Utama</li>
            <li>
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2"></i> <span>Dashboard</span>
                </a>
            </li>
            
            <li class="px-4 mt-4 mb-2 text-uppercase" style="font-size: 0.7rem; font-weight: 600; color: #94a3b8; letter-spacing: 0.05em;">Master Data</li>
            <li>
                <a href="{{ route('admin.buku.index') }}" class="{{ request()->routeIs('admin.buku.*') ? 'active' : '' }}">
                    <i class="bi bi-journal-text"></i> <span>Data Buku</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.anggota.index') }}" class="{{ request()->routeIs('admin.anggota.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i> <span>Kelola Anggota</span>
                </a>
            </li>

            <li class="px-4 mt-4 mb-2 text-uppercase" style="font-size: 0.7rem; font-weight: 600; color: #94a3b8; letter-spacing: 0.05em;">Sirkulasi</li>
            <li>
                <a href="{{ route('admin.transaksi.index') }}" class="{{ request()->routeIs('admin.transaksi.*') ? 'active' : '' }}">
                    <i class="bi bi-arrow-left-right"></i> <span>Transaksi Peminjaman</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pengembalian.index') }}" class="{{ request()->routeIs('admin.pengembalian.*') ? 'active' : '' }}">
                    <i class="bi bi-box-arrow-in-down"></i>
                    <span>Pengembalian Buku</span>
                    @php $pending = \App\Models\Peminjaman::whereIn('status', ['dipinjam','terlambat'])->count(); @endphp
                    @if($pending > 0)
                        <span class="badge bg-danger ms-auto" style="font-size:10px;">{{ $pending }}</span>
                    @endif
                </a>
            </li>
        </ul>

        <div class="sidebar-user mt-auto d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 38px; height: 38px; font-weight: 700; font-size: 1.1rem;">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
                <div>
                    <div class="fw-bold text-white lh-sm" style="font-size: 0.95rem;">{{ auth()->user()->name ?? 'Administrator' }}</div>
                    <small style="color: #94a3b8; font-size: 0.8rem;">Admin Panel</small>
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <div id="content">
        <!-- Topbar -->
        <nav class="navbar navbar-expand-lg navbar-light topbar d-flex justify-content-between align-items-center">
            <div>
                <h4 class="m-0 fw-bold" style="color: var(--text-dark);">@yield('page-title', 'Dashboard')</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0" style="font-size: 13px;">
                        <li class="breadcrumb-item text-muted">Aplikasi</li>
                        <li class="breadcrumb-item active" style="font-weight: 500; color: var(--primary);" aria-current="page">@yield('page-title')</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="bg-light py-1.5 px-3 rounded-pill text-muted d-none d-md-flex align-items-center gap-2 border" style="font-size: 0.85rem;">
                    <i class="bi bi-clock"></i> <span id="clock" class="fw-medium">Loading...</span>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-light rounded-circle shadow-sm d-flex align-items-center justify-content-center p-0" style="width: 40px; height: 40px; border: 1px solid #e2e8f0; color: #ef4444; transition: all 0.2s;" onmouseover="this.style.background='#fee2e2'" onmouseout="this.style.background=''">
                        <i class="bi bi-box-arrow-right"></i>
                    </button>
                </form>
            </div>
        </nav>

        <!-- Main Content Body -->
        <div class="main-container">
            <!-- Toast container -->
            <div class="toast-container position-fixed top-0 end-0 p-4" style="z-index: 1055;">
                @if(session('success'))
                <div class="toast align-items-center text-bg-success border-0 show shadow-lg" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body fw-medium py-3">
                            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-3 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
                @endif

                @if(session('error'))
                <div class="toast align-items-center text-bg-danger border-0 show shadow-lg" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body fw-medium py-3">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-3 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
                @endif
            </div>

            @yield('content')
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus Default -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
      <div class="modal-body text-center p-4">
        <div class="mb-3">
            <div class="mx-auto bg-danger bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                <i class="bi bi-exclamation-triangle-fill text-danger text-opacity-75" style="font-size: 2.5rem;"></i>
            </div>
        </div>
        <h5 class="fw-bold mb-2">Konfirmasi Hapus</h5>
        <p class="text-muted mb-4" style="font-size: 0.9rem;">Tindakan ini tidak dapat dibatalkan. Data akan dihapus secara permanen.</p>
        <div class="d-flex justify-content-center gap-2">
            <button type="button" class="btn btn-light fw-medium px-4" data-bs-dismiss="modal">Batal</button>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger fw-medium px-4">Ya, Hapus!</button>
            </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Realtime Clock
    function updateClock() {
        const now = new Date();
        const options = { weekday: 'short', day: 'numeric', month: 'short', year:'numeric', hour: '2-digit', minute: '2-digit' };
        document.getElementById('clock').textContent = now.toLocaleDateString('id-ID', options);
    }
    updateClock();
    setInterval(updateClock, 30000);

    // Auto hide toast
    setTimeout(function() {
        var toasts = document.querySelectorAll('.toast.show');
        toasts.forEach(function(toastNode) {
            var toast = new bootstrap.Toast(toastNode);
            toast.hide();
        });
    }, 4000);

    // Global Delete Confirmation Function
    function confirmDelete(actionUrl) {
        document.getElementById('deleteForm').action = actionUrl;
        var myModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        myModal.show();
    }
</script>

@stack('scripts')
</body>
</html>
