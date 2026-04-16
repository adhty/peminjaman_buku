<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Sistem Perpustakaan Digital</title>
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
            overflow-y: auto;
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
        .register-link {
            text-align: center;
            margin-top: 1.5rem;
            color: #64748b;
            font-size: 0.95rem;
        }
        .register-link a {
            color: #4f46e5;
            text-decoration: none;
            font-weight: 600;
        }
        .register-link a:hover {
            text-decoration: underline;
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
                    Daftar sekarang untuk meminjam buku secara digital dan mengatur histori peminjaman dengan mudah.
                </p>
                
                <ul class="feature-list">
                    <li class="feature-item">
                        <div class="feature-icon"><i class="bi bi-book"></i></div>
                        <span>Akses Ribuan Katalog Buku</span>
                    </li>
                    <li class="feature-item">
                        <div class="feature-icon"><i class="bi bi-phone"></i></div>
                        <span>Akses Dimana Saja dan Kapan Saja</span>
                    </li>
                    <li class="feature-item">
                        <div class="feature-icon"><i class="bi bi-journal-check"></i></div>
                        <span>Lacak Riwayat Pinjaman Lebih Mudah</span>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Right Panel -->
        <div class="login-right">
            <div class="login-right-inner">
                <h2 class="right-title">Daftar Akun Baru 📝</h2>
                <p class="right-subtitle">Buat akun Anda dengan melengkapi form di bawah ini.</p>

                <form method="POST" action="{{ route('register.post') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person-vcard"></i></span>
                            <input type="text" name="name" class="form-control shadow-none @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required autofocus>
                        </div>
                        @error('name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>



                    <div class="mb-3">
                        <label class="form-label">Email Aktif</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" name="email" class="form-control shadow-none @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="contoh@email.com" required>
                        </div>
                        @error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" name="password" class="form-control shadow-none @error('password') is-invalid @enderror" placeholder="Buat password baru (Min. 6 Karakter)" required>
                        </div>
                        @error('password')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Konfirmasi Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                            <input type="password" name="password_confirmation" class="form-control shadow-none" placeholder="Ulangi password Anda" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-person-plus me-2"></i> Buat Akun Siswa
                    </button>
                    
                    <div class="register-link border-top pt-3 mt-4">
                        Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
