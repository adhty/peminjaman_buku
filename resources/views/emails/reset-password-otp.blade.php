<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f7fa;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }
        .header {
            background-color: #4f46e5;
            color: #ffffff;
            padding: 30px;
            text-align: center;
        }
        .content {
            padding: 30px;
            text-align: center;
        }
        .otp-box {
            font-size: 32px;
            font-weight: bold;
            letter-spacing: 5px;
            color: #4f46e5;
            background: #f0f0ff;
            padding: 20px;
            border-radius: 8px;
            display: inline-block;
            margin: 20px 0;
            border: 2px dashed #4f46e5;
        }
        .footer {
            background-color: #f9fafb;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #6b7280;
        }
        .warning {
            color: #ef4444;
            font-size: 14px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Reset Password</h1>
        </div>
        <div class="content">
            <p>Halo,</p>
            <p>Kami menerima permintaan untuk mereset password akun Anda di <strong>Sistem Perpustakaan Digital</strong>.</p>
            <p>Gunakan kode OTP di bawah ini untuk melanjutkan proses reset password:</p>
            
            <div class="otp-box">
                {{ $otp }}
            </div>
            
            <p>Kode ini hanya berlaku selama <strong>5 menit</strong>.</p>
            
            <div class="warning">
                Jika Anda tidak merasa melakukan permintaan ini, silakan abaikan email ini atau hubungi admin.
            </div>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Sistem Perpustakaan Digital. All rights reserved.
        </div>
    </div>
</body>
</html>
