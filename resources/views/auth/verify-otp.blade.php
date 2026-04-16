<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP - Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; height: 100vh; display: flex; align-items: center; justify-content: center; overflow: hidden; }
        .glass-card { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 24px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1); padding: 40px; width: 100%; max-width: 440px; }
        .icon-box { width: 80px; height: 80px; background: linear-gradient(135deg, #4f46e5, #3b82f6); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; color: white; font-size: 36px; box-shadow: 0 10px 25px -5px rgba(79, 70, 229, 0.4); }
        .form-control { border-radius: 12px; padding: 14px 20px; font-size: 24px; font-weight: 700; letter-spacing: 15px; text-align: center; border: 2px solid #e2e8f0; transition: all 0.3s; color: #1e293b; background: #f8fafc; }
        .form-control:focus { border-color: #4f46e5; box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1); background: white; }
        .btn-primary { background: linear-gradient(135deg, #4f46e5, #3b82f6); border: none; padding: 14px; border-radius: 12px; font-weight: 600; font-size: 16px; transition: all 0.3s; box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3); }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 15px 20px -3px rgba(79, 70, 229, 0.4); }
        .back-link { color: #64748b; text-decoration: none; font-size: 14px; font-weight: 500; transition: color 0.2s; }
        .back-link:hover { color: #1e293b; }
    </style>
</head>
<body>

    <div class="glass-card">
        <div class="text-center mb-4">
            <div class="icon-box">
                <i class="bi bi-shield-lock-fill"></i>
            </div>
            <h3 class="fw-bold text-dark mb-1">Verifikasi Keamanan</h3>
            <p class="text-muted small">Kami telah mengirimkan 6-digit kode OTP ke email Anda. Kode ini berlaku selama 5 menit.</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success border-0 bg-success bg-opacity-10 text-success rounded-3 small fw-medium mb-4">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger border-0 bg-danger bg-opacity-10 text-danger rounded-3 small fw-medium mb-4">
                @foreach($errors->all() as $error)
                    <div><i class="bi bi-exclamation-triangle-fill me-2"></i>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('login.verify-otp.post') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="form-label fw-semibold text-dark small text-center w-100">Masukkan 6-Digit Kode OTP</label>
                <input type="text" name="otp" class="form-control" autocomplete="off" placeholder="------" maxlength="6" autofocus required>
            </div>

            <button type="submit" class="btn btn-primary w-100 mb-4">
                Verifikasi & Lanjutkan <i class="bi bi-arrow-right ms-2"></i>
            </button>
        </form>

        <div class="text-center">
            <a href="{{ route('login') }}" class="back-link"><i class="bi bi-arrow-left me-1"></i> Kembali ke halaman Login</a>
        </div>
    </div>

</body>
</html>
