<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Perpustakaan Digital | Kelola Perpustakaan Lebih Cerdas</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-dark: #1e3a5f;
            --primary: #2c5282;
            --primary-light: #3182ce;
            --primary-soft: #ebf4ff;
            --secondary: #4a5568;
            --accent: #0ea5e9;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #eef2ff 100%);
            color: #1e293b;
            overflow-x: hidden;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
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

        /* Navbar */
        .navbar {
            padding: 1rem 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(30, 58, 95, 0.08);
            transition: all 0.3s;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: -0.3px;
        }

        .logo-icon {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 8px rgba(44, 82, 130, 0.2);
        }

        .logo-icon i {
            font-size: 18px;
            color: white;
        }

        .nav-link {
            font-weight: 600;
            color: var(--secondary);
            transition: all 0.2s;
        }

        .nav-link:hover {
            color: var(--primary);
            transform: translateY(-1px);
        }

        /* Buttons */
        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border: none;
            color: white;
            padding: 0.75rem 1.75rem;
            font-weight: 700;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(44, 82, 130, 0.25);
            transition: all 0.3s ease;
        }

        .btn-primary-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(44, 82, 130, 0.35);
            color: white;
        }

        .btn-outline-custom {
            background: transparent;
            color: var(--primary);
            border: 2px solid var(--primary);
            padding: 0.75rem 1.75rem;
            font-weight: 700;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .btn-outline-custom:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(44, 82, 130, 0.2);
        }

        /* Hero Section */
        .hero-section {
            padding: 140px 0 100px;
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .hero-title {
            font-size: 3.8rem;
            font-weight: 900;
            line-height: 1.2;
            color: var(--primary-dark);
            margin-bottom: 1.5rem;
            letter-spacing: -0.02em;
        }

        .text-gradient {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-subtitle {
            font-size: 1.2rem;
            color: var(--secondary);
            margin-bottom: 2rem;
            line-height: 1.6;
            max-width: 500px;
        }

        /* Background Circles */
        .bg-circles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
            pointer-events: none;
        }

        .circle-1 {
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(44, 82, 130, 0.08) 0%, rgba(255,255,255,0) 70%);
            top: -150px;
            right: -100px;
            border-radius: 50%;
        }

        .circle-2 {
            position: absolute;
            width: 350px;
            height: 350px;
            background: radial-gradient(circle, rgba(49, 130, 206, 0.06) 0%, rgba(255,255,255,0) 70%);
            bottom: -80px;
            left: -80px;
            border-radius: 50%;
        }

        .circle-3 {
            position: absolute;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(44, 82, 130, 0.05) 0%, rgba(255,255,255,0) 70%);
            top: 40%;
            left: 30%;
            border-radius: 50%;
        }

        /* Feature Cards */
        .feature-card {
            background: white;
            border-radius: 24px;
            padding: 32px;
            border: 1px solid #eef2f6;
            box-shadow: 0 10px 25px -5px rgba(0,0,0,0.05);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-8px);
            border-color: var(--primary-light);
            box-shadow: 0 20px 35px -12px rgba(44, 82, 130, 0.15);
        }

        .icon-box {
            width: 65px;
            height: 65px;
            border-radius: 18px;
            background: linear-gradient(135deg, var(--primary-soft) 0%, #e0e7ff 100%);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin-bottom: 1.5rem;
            transition: all 0.3s;
        }

        .feature-card:hover .icon-box {
            transform: scale(1.05);
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
        }

        .feature-card h4 {
            font-size: 1.3rem;
            font-weight: 800;
            color: var(--primary-dark);
            margin-bottom: 0.75rem;
        }

        .feature-card p {
            color: var(--secondary);
            line-height: 1.6;
        }

        /* Stats Section */
        .stats-section {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
            border-radius: 40px;
            padding: 60px 40px;
            margin: 60px 0;
            position: relative;
            overflow: hidden;
        }

        .stats-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 300px;
            height: 300px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
        }

        .stat-number {
            font-size: 2.8rem;
            font-weight: 900;
            color: white;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 0.9rem;
            color: rgba(255,255,255,0.8);
            font-weight: 500;
        }

        /* Footer */
        footer {
            background: white;
            border-top: 1px solid #eef2f6;
            padding: 40px 0;
        }

        /* Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-in {
            animation: fadeInUp 0.6s ease forwards;
        }

        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.2rem;
            }
            .hero-subtitle {
                font-size: 1rem;
            }
            .stats-section {
                padding: 40px 20px;
            }
            .stat-number {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="#">
                <div class="logo-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <span>Perpustakaan<span style="color: var(--primary);">Digital</span></span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center gap-3">
                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item">
                                <a href="{{ url('/admin/dashboard') }}" class="btn btn-primary-custom px-4 py-2">
                                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                                </a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a href="{{ route('login') }}" class="nav-link px-3">
                                    <i class="fas fa-sign-in-alt me-1"></i> Masuk
                                </a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a href="{{ route('register') }}" class="btn btn-primary-custom px-4 py-2">
                                        <i class="fas fa-user-plus me-2"></i>Daftar
                                    </a>
                                </li>
                            @endif
                        @endauth
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="bg-circles">
            <div class="circle-1"></div>
            <div class="circle-2"></div>
            <div class="circle-3"></div>
        </div>
        <div class="container position-relative z-1">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0 animate-in">
                    <span class="badge mb-3 px-3 py-2 rounded-pill" style="background: var(--primary-soft); color: var(--primary); font-weight: 600;">
                        <i class="fas fa-star me-1"></i> Sistem Manajemen Modern v2.0
                    </span>
                    <h1 class="hero-title">
                        Kelola <span class="text-gradient">Perpustakaan</span><br>dengan Lebih Cerdas
                    </h1>
                    <p class="hero-subtitle">
                        Platform digital modern untuk mengelola katalog buku, anggota, dan transaksi sirkulasi perpustakaan secara mudah, cepat, dan efisien.
                    </p>
                    <div class="d-flex flex-column flex-sm-row gap-3">
                        @auth
                            <a href="{{ url('/admin/dashboard') }}" class="btn btn-primary-custom">
                                <i class="fas fa-tachometer-alt me-2"></i>Buka Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary-custom">
                                Mulai Sekarang <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        @endauth
                        <a href="#features" class="btn btn-outline-custom">
                            <i class="fas fa-info-circle me-2"></i>Pelajari Fitur
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 text-center animate-in delay-1">
                    <img src="https://illustrations.popsy.co/blue/freelancer.svg" alt="Library Illustration" class="img-fluid" style="max-height: 450px;">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5">
        <div class="container py-4">
            <div class="text-center mb-5 animate-in">
                <span class="badge mb-3 px-3 py-2 rounded-pill" style="background: var(--primary-soft); color: var(--primary);">
                    <i class="fas fa-crown me-1"></i> Layanan Unggulan
                </span>
                <h2 class="fw-bold mb-3" style="font-size: 2.2rem; color: var(--primary-dark);">
                    Fitur <span class="text-gradient">Terbaik</span> untuk Perpustakaan Anda
                </h2>
                <p class="text-muted" style="font-size: 1rem; max-width: 600px; margin: 0 auto;">
                    Semua yang Anda butuhkan untuk menjalankan dan memonitor perpustakaan secara optimal.
                </p>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4 animate-in delay-1">
                    <div class="feature-card">
                        <div class="icon-box">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <h4>Manajemen Buku</h4>
                        <p>Kelola katalog buku, stok, kategori, dan pencarian koleksi dengan mudah melalui antarmuka yang intuitif.</p>
                    </div>
                </div>
                <div class="col-md-4 animate-in delay-2">
                    <div class="feature-card">
                        <div class="icon-box">
                            <i class="fas fa-users"></i>
                        </div>
                        <h4>Database Anggota</h4>
                        <p>Catat dan pantau data anggota perpustakaan secara rapi dengan sistem keanggotaan terpusat.</p>
                    </div>
                </div>
                <div class="col-md-4 animate-in delay-3">
                    <div class="feature-card">
                        <div class="icon-box">
                            <i class="fas fa-exchange-alt"></i>
                        </div>
                        <h4>Sirkulasi Transaksi</h4>
                        <p>Lacak peminjaman, pengembalian, dan denda secara otomatis tanpa perlu pencatatan manual.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <div class="container">
        <div class="stats-section animate-in">
            <div class="row text-center g-4">
                <div class="col-md-3 col-6">
                    <div class="stat-number">5000+</div>
                    <div class="stat-label">Koleksi Buku</div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-number">1000+</div>
                    <div class="stat-label">Anggota Aktif</div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-number">10000+</div>
                    <div class="stat-label">Transaksi</div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-number">24/7</div>
                    <div class="stat-label">Akses Online</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <div class="d-flex align-items-center justify-content-center justify-content-md-start gap-2 mb-2">
                        <div class="logo-icon" style="width: 32px; height: 32px;">
                            <i class="fas fa-graduation-cap" style="font-size: 14px;"></i>
                        </div>
                        <span class="fw-bold" style="color: var(--primary-dark);">PerpustakaanDigital</span>
                    </div>
                    <p class="text-muted small mb-0">&copy; {{ date('Y') }} Sistem Perpustakaan Digital. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <div class="d-flex gap-3 justify-content-center justify-content-md-end">
                        <a href="#" class="text-muted text-decoration-none small">Tentang</a>
                        <a href="#" class="text-muted text-decoration-none small">Kebijakan Privasi</a>
                        <a href="#" class="text-muted text-decoration-none small">Bantuan</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.boxShadow = '0 4px 20px rgba(0,0,0,0.05)';
                navbar.style.background = 'rgba(255, 255, 255, 0.98)';
            } else {
                navbar.style.boxShadow = 'none';
                navbar.style.background = 'rgba(255, 255, 255, 0.95)';
            }
        });
    </script>
</body>
</html>