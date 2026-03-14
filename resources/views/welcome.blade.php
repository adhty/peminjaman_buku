<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Perpustakaan Digital</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
        }
        .navbar {
            padding: 1rem 0;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        .hero-section {
            padding: 100px 0 80px;
            background: linear-gradient(135deg, #f8fafc 0%, #e0e7ff 100%);
            position: relative;
            overflow: hidden;
        }
        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.2;
            color: #1e293b;
            margin-bottom: 1.5rem;
        }
        .hero-subtitle {
            font-size: 1.25rem;
            color: #475569;
            margin-bottom: 2.5rem;
            line-height: 1.6;
        }
        .btn-primary-custom {
            background-color: #4f46e5;
            border-color: #4f46e5;
            color: white;
            padding: 0.75rem 2rem;
            font-weight: 600;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);
            transition: all 0.3s ease;
        }
        .btn-primary-custom:hover {
            background-color: #4338ca;
            transform: translateY(-2px);
            box-shadow: 0 6px 8px -1px rgba(79, 70, 229, 0.3);
            color: white;
        }
        .btn-outline-custom {
            background-color: #ffffff;
            color: #4f46e5;
            border: 1px solid #e2e8f0;
            padding: 0.75rem 2rem;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        .btn-outline-custom:hover {
            background-color: #f8fafc;
            border-color: #cbd5e1;
            transform: translateY(-2px);
            color: #4338ca;
        }
        .feature-card {
            background: white;
            border-radius: 16px;
            padding: 30px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
            height: 100%;
        }
        .feature-card:hover {
            transform: translateY(-5px);
            border-color: #c7d2fe;
        }
        .icon-box {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            background: #eef2ff;
            color: #4f46e5;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
        }
        .bg-circles {
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
            pointer-events: none;
        }
        .circle-1 {
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(79,70,229,0.1) 0%, rgba(255,255,255,0) 70%);
            top: -200px;
            right: -100px;
            border-radius: 50%;
        }
        .circle-2 {
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(56,189,248,0.1) 0%, rgba(255,255,255,0) 70%);
            bottom: -100px;
            left: -100px;
            border-radius: 50%;
        }
        .text-gradient {
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-image: linear-gradient(90deg, #4f46e5, #0ea5e9);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg fixed-top z-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2 fw-bold text-dark" href="#">
                <div class="bg-primary text-white rounded p-1 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background-color: #4f46e5 !important;">
                    <i class="bi bi-book-half"></i>
                </div>
                <span>Perpustakaan<span style="color: #4f46e5;">Digital</span></span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center gap-3">
                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item">
                                <a href="{{ url('/admin/dashboard') }}" class="btn btn-primary-custom px-4 py-2">Dashboard</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a href="{{ route('login') }}" class="nav-link fw-medium text-dark px-3">Log in</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a href="{{ route('register') }}" class="btn btn-primary-custom px-4 py-2">Mendaftar</a>
                                </li>
                            @endif
                        @endauth
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <section class="hero-section text-center text-lg-start d-flex align-items-center min-vh-100">
        <div class="bg-circles">
            <div class="circle-1"></div>
            <div class="circle-2"></div>
        </div>
        <div class="container position-relative z-1">
            <div class="row align-items-center mb-5">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <span class="badge bg-primary bg-opacity-10 text-primary mb-3 px-3 py-2 rounded-pill fw-semibold border border-primary border-opacity-25">Sistem Manajemen Baru v2.0</span>
                    <h1 class="hero-title">Kelola <span class="text-gradient">Perpustakaan</span> dengan Lebih Cerdas</h1>
                    <p class="hero-subtitle">Platform digital modern untuk mengelola katalog buku, anggota, dan transaksi sirkulasi perpustakaan secara mudah, cepat, dan efisien.</p>
                    <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center justify-content-lg-start">
                        @auth
                            <a href="{{ url('/admin/dashboard') }}" class="btn btn-primary-custom"><i class="bi bi-grid-1x2 me-2"></i>Buka Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary-custom d-inline-flex align-items-center justify-content-center">
                                Mulai Sekarang <i class="bi bi-arrow-right ms-2"></i>
                            </a>
                        @endauth
                        <a href="#features" class="btn btn-outline-custom">Pelajari Fitur</a>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <img src="https://illustrations.popsy.co/blue/freelancer.svg" alt="Library Web Illustration" class="img-fluid" style="max-height: 480px;">
                </div>
            </div>
        </div>
    </section>

    <section id="features" class="py-5" style="background-color: white;">
        <div class="container py-5">
            <div class="text-center mb-5 max-w-2xl mx-auto" style="max-width: 600px; margin: 0 auto;">
                <h2 class="fw-bold mb-3" style="font-size: 2.25rem; color: #1e293b;">Fitur Unggulan</h2>
                <p class="text-muted" style="font-size: 1.1rem;">Semua yang Anda butuhkan untuk menjalankan dan memonitor perpustakaan secara optimal.</p>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="icon-box">
                            <i class="bi bi-journal-check"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Manajemen Buku</h4>
                        <p class="text-muted mb-0">Kelola katalog buku, stok, kategori, dan pencarian koleksi dengan mudah melalui antarmuka yang intuitif.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="icon-box">
                            <i class="bi bi-people"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Database Anggota</h4>
                        <p class="text-muted mb-0">Catat dan pantau data anggota perpustakaan secara rapi dengan sistem keanggotaan terpusat.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="icon-box">
                            <i class="bi bi-arrow-left-right"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Sirkulasi Transaksi</h4>
                        <p class="text-muted mb-0">Lacak peminjaman, pengembalian, dan denda secara otomatis tanpa perlu pencatatan manual.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="py-4 text-center border-top">
        <div class="container">
            <p class="text-muted mb-0">&copy; {{ date('Y') }} Sistem Perpustakaan Digital. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
