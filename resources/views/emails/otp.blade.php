<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kode OTP Anda</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <div style="text-align: center; margin-bottom: 20px;">
            <h2 style="color: #4f46e5; margin: 0;">Perpustakaan Digital</h2>
        </div>
        <p style="font-size: 16px; color: #333333;">Halo,</p>
        <p style="font-size: 16px; color: #333333;">Anda meminta untuk login ke dalam aplikasi. Silakan gunakan kode OTP berikut untuk melanjutkan proses login Anda:</p>
        
        <div style="text-align: center; margin: 30px 0;">
            <div style="display: inline-block; background-color: #f8fafc; border: 2px dashed #4f46e5; padding: 15px 30px; font-size: 32px; font-weight: bold; letter-spacing: 5px; color: #1e293b; border-radius: 8px;">
                {{ $otpCode }}
            </div>
        </div>
        
        <p style="font-size: 14px; color: #666666;">Kode OTP ini hanya berlaku selama <strong>5 menit</strong>. Jangan berikan kode ini kepada siapapun termasuk pihak perpustakaan.</p>
        <p style="font-size: 14px; color: #666666; margin-top: 30px;">Terima kasih,<br>Tim Perpustakaan</p>
    </div>
</body>
</html>
