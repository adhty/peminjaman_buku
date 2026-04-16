<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Mail;
use App\Mail\LoginOtpMail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('siswa.dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // Bypass OTP & validasi DNS untuk Admin
            if ($user->role === 'admin') {
                Auth::login($user, $request->boolean('remember'));
                $request->session()->regenerate();
                return redirect()->route('admin.dashboard')->with('success', 'Selamat datang, ' . Auth::user()->name . '!');
            }

            // Untuk Siswa/User biasa, validasi apakah emailnya benar-benar valid (aktif) secara DNS/Formatnya
            $request->validate([
                'email' => 'email:dns'
            ], [
                'email.email' => 'Domain email tidak aktif/ditemukan. Gunakan email sungguhan.'
            ]);

            // Generate 6 digit OTP acak
            $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
            $user->otp_code = $otp;
            $user->otp_expires_at = now()->addMinutes(5); // OTP berlaku 5 menit
            $user->save();

            // Kirim email
            Mail::to($user->email)->send(new LoginOtpMail($otp));

            // Simpan intent login ke session untuk diverifikasi di langkah berikutnya
            $request->session()->put('otp_user_id', $user->id);
            $request->session()->put('otp_remember', $request->boolean('remember'));

            return redirect()->route('login.verify-otp')->with('success', 'Kode OTP telah dikirim ke email Anda. Periksa kotak masuk atau spam.');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput($request->only('email'));
    }

    public function showVerifyOtp()
    {
        if (!session()->has('otp_user_id')) {
            return redirect()->route('login');
        }
        return view('auth.verify-otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ], [
            'otp.required' => 'Kode OTP wajib diisi.',
            'otp.digits'   => 'Kode OTP harus berupa 6 digit angka.'
        ]);

        $userId = session('otp_user_id');
        if (!$userId) return redirect()->route('login');

        $user = User::find($userId);
        if (!$user) return redirect()->route('login');

        if ($user->otp_code !== $request->otp) {
            return back()->withErrors(['otp' => 'Kode OTP salah.'])->withInput();
        }

        if (now()->greaterThan($user->otp_expires_at)) {
            return back()->withErrors(['otp' => 'Kode OTP sudah kedaluwarsa. Silakan login kembali.']);
        }

        // Jika OTP Benar
        $user->otp_code = null;
        $user->otp_expires_at = null;
        $user->save();

        Auth::login($user, session('otp_remember', false));
        $request->session()->regenerate();
        session()->forget(['otp_user_id', 'otp_remember']);

        return redirect()->route('siswa.dashboard')->with('success', 'Selamat datang, ' . $user->name . '!');
    }

    public function showRegister()
    {
        if (Auth::check()) {
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('siswa.dashboard');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email:dns|max:100|unique:users,email',
            'password' => ['required', 'confirmed', Password::min(6)],
        ], [
            'email.email'       => 'Domain email yang dimasukkan tidak aktif / valid.',
            'email.unique'      => 'Email sudah terdaftar.',
            'password.min'      => 'Password minimal 6 karakter.',
            'password.confirmed'=> 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'username' => 'u_' . uniqid(),
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'siswa',
        ]);

        Auth::login($user);

        return redirect()->route('siswa.profil.create')->with('success', 'Akun berhasil dibuat! Silakan lengkapi profil Anda terlebih dahulu.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Anda berhasil logout.');
    }
}
