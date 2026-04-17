<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP - Sistem Perpustakaan Digital</title>
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
        .otp-input {
            letter-spacing: 0.5rem;
            font-size: 1.5rem;
            text-align: center;
            font-weight: 700;
            padding: 0.75rem;
        }
    </style>
</head>
<body>

    <div class="card p-4 mx-3">
        <div class="text-center d-flex flex-column align-items-center">
            <div class="logo-icon">
                <i class="bi bi-shield-lock text-white"></i>
            </div>
            <h3 class="fw-bold text-dark">Verifikasi OTP</h3>
            <p class="text-muted small mb-4">Masukkan 6 digit kode OTP yang telah dikirim ke email <strong>{{ session('reset_email') }}</strong></p>
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

        <form action="{{ route('password.verify-otp.post') }}" method="POST" id="verifyForm">
            @csrf
            <div class="mb-4">
                <input type="text" name="otp" class="form-control otp-input shadow-none" maxlength="6" placeholder="000000" pattern="\d*" inputmode="numeric" required autofocus>
                <div class="text-center mt-2">
                    <span class="text-muted small">Tidak menerima kode?</span>
                    <button type="button" onclick="document.getElementById('resendForm').submit();" class="btn btn-link p-0 small fw-semibold text-decoration-none" style="color: #4f46e5; font-size: 0.875rem;">Kirim Ulang</button>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 mb-3">
                Verifikasi OTP
            </button>

            <div class="text-center">
                <a href="{{ route('password.request') }}" class="text-decoration-none small fw-semibold" style="color: #64748b;">
                    Ganti Email
                </a>
            </div>
        </form>

        {{-- Hidden Resend Form --}}
        <form id="resendForm" action="{{ route('password.email') }}" method="POST" class="d-none">
            @csrf
            <input type="hidden" name="email" value="{{ session('reset_email') }}">
        </form>
    </div>

</body>
</html>
