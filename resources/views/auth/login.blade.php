<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Perpustakaan Digital</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8fafc;
        }
        .login-container {
            min-height: 100vh;
            display: flex;
        }
        .login-left {
            background-color: #1e3a8a; /* Dark Blue */
            color: white;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 4rem;
            position: relative;
            overflow: hidden;
        }
        /* Background circles */
        .bg-circle-1 {
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            top: 40%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .bg-circle-2 {
            position: absolute;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            bottom: -100px;
            right: -100px;
        }
        .login-left-content {
            position: relative;
            z-index: 10;
            max-width: 480px;
            margin: 0 auto;
        }
        .logo-icon {
            width: 64px;
            height: 64px;
            background: #4f46e5;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            margin-bottom: 2rem;
            box-shadow: 0 10px 25px rgba(79, 70, 229, 0.5);
        }
        .left-title {
            font-size: 2.5rem;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 1rem;
        }
        .text-light-blue {
            color: #93c5fd;
        }
        .left-subtitle {
            color: #94a3b8;
            font-size: 1.1rem;
            margin-bottom: 3rem;
            line-height: 1.6;
            max-width: 400px;
        }
        .feature-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 1.25rem;
            color: #cbd5e1;
            font-size: 0.95rem;
        }
        .feature-icon {
            width: 32px;
            height: 32px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
        }
        .login-right {
            background-color: #f8fafc;
            width: 500px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 4rem;
        }
        .login-right-inner {
            width: 100%;
            max-width: 380px;
            margin: 0 auto;
        }
        @media (max-width: 991.98px) {
            .login-left {
                display: none;
            }
            .login-right {
                width: 100%;
                align-items: center;
            }
        }
        .right-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }
        .right-subtitle {
            color: #64748b;
            margin-bottom: 2rem;
            font-size: 0.95rem;
        }
        .form-label {
            font-weight: 500;
            color: #334155;
            font-size: 0.9rem;
        }
        .input-group-text {
            background-color: transparent;
            border-right: none;
            color: #94a3b8;
            padding-left: 1rem;
        }
        .form-control {
            border-left: none;
            padding-left: 0.5rem;
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #dee2e6;
        }
        .input-group {
            background: white;
            border-radius: 0.5rem;
            border: 1px solid #dee2e6;
            overflow: hidden;
        }
        .input-group .form-control {
            border: none;
            background: transparent;
        }
        .input-group:focus-within {
            box-shadow: 0 0 0 0.25rem rgba(79, 70, 229, 0.15);
            border-color: #4f46e5;
        }
        .btn-primary {
            background-color: #4f46e5;
            border-color: #4f46e5;
            padding: 0.75rem;
            font-weight: 600;
            border-radius: 0.5rem;
        }
        .btn-primary:hover {
            background-color: #4338ca;
            border-color: #4338ca;
        }
        .admin-hint {
            color: #94a3b8;
            font-size: 0.85rem;
            text-align: center;
            margin-top: 1.5rem;
        }

        .user-hint {
            color: #94a3b8;
            font-size: 0.85rem;
            text-align: center;
            margin-top: 1.5rem;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <!-- Left Panel -->
        <div class="login-left">
            <div class="bg-circle-1"></div>
            <div class="bg-circle-2"></div>
            
            <div class="login-left-content">
                <div class="logo-icon">
                    <i class="bi bi-book text-white"></i>
                </div>
                
                <h1 class="left-title">
                    Sistem <span class="text-light-blue">Perpustakaan<br>Digital</span>
                </h1>
                
                <p class="left-subtitle">
                    Kelola data buku, anggota, dan transaksi peminjaman dengan mudah dan efisien.
                </p>
                
                <ul class="feature-list">
                    <li class="feature-item">
                        <div class="feature-icon"><i class="bi bi-book"></i></div>
                        <span>CRUD Data Buku & Stok</span>
                    </li>
                    <li class="feature-item">
                        <div class="feature-icon"><i class="bi bi-people"></i></div>
                        <span>Kelola Data Anggota</span>
                    </li>
                    <li class="feature-item">
                        <div class="feature-icon"><i class="bi bi-arrow-left-right"></i></div>
                        <span>Manajemen Transaksi Peminjaman</span>
                    </li>
                    <li class="feature-item">
                        <div class="feature-icon"><i class="bi bi-graph-up"></i></div>
                        <span>Dashboard Statistik Real-time</span>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Right Panel -->
        <div class="login-right">
            <div class="login-right-inner">
                <h2 class="right-title">Selamat Datang 👋</h2>
                <p class="right-subtitle">Silakan login untuk mengakses sistem perpustakaan</p>

                @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ $errors->first() }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <form method="POST" action="{{ route('login.post') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Email Aktif</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" name="email" class="form-control shadow-none @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Masukkan email aktif Anda" required autofocus>
                        </div>
                        @error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" name="password" class="form-control shadow-none @error('password') is-invalid @enderror" placeholder="Masukkan password" required>
                        </div>
                        @error('password')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4 d-flex justify-content-between align-items-center">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label text-muted small" for="remember">Ingat saya</label>
                        </div>
                        <a href="{{ route('password.request') }}" class="text-decoration-none small fw-semibold" style="color: #4f46e5;">Lupa password?</a>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-box-arrow-in-right me-2"></i> Masuk ke Sistem
                    </button>
                    
                    <div class="admin-hint">
                        <i class="bi bi-shield-check me-1"></i> Admin: admin@perpustakaan.com / admin123
                    </div>

                    <div class="user-hint mb-4">
                        <i class="bi bi-person-check me-1"></i> User: ahmad@sekolah.com / siswa123
                    </div>

                    <div class="text-center mt-4 pt-3 border-top" style="font-size: 0.95rem; color: #64748b;">
                        Belum punya akun? <a href="{{ route('register') }}" style="color: #4f46e5; text-decoration: none; font-weight: 600;">Daftar di sini</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
