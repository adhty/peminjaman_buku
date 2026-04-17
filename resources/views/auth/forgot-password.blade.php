<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Sistem Perpustakaan Digital</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            width: 100%;
            max-width: 450px;
        }
        .logo-icon {
            width: 48px;
            height: 48px;
            background: #4f46e5;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 1.5rem;
        }
        .btn-primary {
            background-color: #4f46e5;
            border-color: #4f46e5;
            padding: 0.75rem;
            font-weight: 600;
        }
        .btn-primary:hover {
            background-color: #4338ca;
        }
        .input-group-text {
            background-color: transparent;
            border-right: none;
            color: #94a3b8;
        }
        .form-control {
            border-left: none;
            padding: 0.75rem;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #dee2e6;
        }
        .input-group:focus-within {
            border-color: #4f46e5;
            box-shadow: 0 0 0 0.25rem rgba(79, 70, 229, 0.15);
        }
    </style>
</head>
<body>

    <div class="card p-4 mx-3">
        <div class="text-center d-flex flex-column align-items-center">
            <div class="logo-icon">
                <i class="bi bi-key text-white"></i>
            </div>
            <h3 class="fw-bold text-dark">Lupa Password?</h3>
            <p class="text-muted small mb-4">Masukkan email Anda dan kami akan mengirimkan kode OTP untuk mereset password.</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success small mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger small mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="form-label fw-medium small">Email Terdaftar</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="email" name="email" class="form-control" placeholder="nama@email.com" required autofocus>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 mb-3">
                Kirim Kode OTP
            </button>

            <div class="text-center">
                <a href="{{ route('login') }}" class="text-decoration-none small fw-semibold" style="color: #4f46e5;">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Login
                </a>
            </div>
        </form>
    </div>

</body>
</html>
