<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Password Baru - Sistem Perpustakaan Digital</title>
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
                <i class="bi bi-lock-fill text-white"></i>
            </div>
            <h3 class="fw-bold text-dark">Password Baru</h3>
            <p class="text-muted small mb-4">Silakan tentukan password baru Anda yang kuat dan mudah diingat.</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger small mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('password.update') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-medium small">Password Baru</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" class="form-control" placeholder="minimal 6 karakter" required autofocus>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-medium small">Konfirmasi Password Baru</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-check-circle"></i></span>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="ulangi password baru" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                Update Password
            </button>
        </form>
    </div>

</body>
</html>
