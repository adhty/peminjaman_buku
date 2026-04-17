<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordOtpMail;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;


class PasswordResetController extends Controller
{
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function sendResetOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
            'email.exists'   => 'Email tidak terdaftar di sistem kami.',
        ]);

        $user = User::where('email', $request->email)->first();

        // Generate 6 digit OTP
        $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $user->otp_code = $otp;
        $user->otp_expires_at = now()->addMinutes(5);
        $user->save();

        // Send Email
        Mail::to($user->email)->send(new ResetPasswordOtpMail($otp));

        // Store email in session for verification steps
        session(['reset_email' => $request->email]);

        return redirect()->route('password.verify-otp')->with('success', 'Kode OTP reset password telah dikirim ke email Anda.');
    }

    public function showVerifyOtp()
    {
        if (!session()->has('reset_email')) {
            return redirect()->route('password.request');
        }
        return view('auth.verify-reset-otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ], [
            'otp.required' => 'Kode OTP wajib diisi.',
            'otp.digits'   => 'Kode OTP harus berupa 6 digit angka.'
        ]);

        $email = session('reset_email');
        $user = User::where('email', $email)->first();

        if (!$user || $user->otp_code !== $request->otp) {
            return back()->withErrors(['otp' => 'Kode OTP salah.'])->withInput();
        }

        if (now()->greaterThan($user->otp_expires_at)) {
            return back()->withErrors(['otp' => 'Kode OTP sudah kedaluwarsa. Silakan minta kode baru.']);
        }

        // OTP Valid, store verification status in session
        session(['reset_verified' => true]);

        return redirect()->route('password.reset')->with('success', 'OTP Terverifikasi. Silakan masukkan password baru Anda.');
    }

    public function showResetPassword()
    {
        if (!session('reset_verified') || !session('reset_email')) {
            return redirect()->route('password.request');
        }
        return view('auth.reset-password');
    }

    public function resetPassword(Request $request)
    {
        if (!session('reset_verified') || !session('reset_email')) {
            return redirect()->route('password.request');
        }

        $request->validate([
            'password' => ['required', 'confirmed', Password::min(6)],
        ], [
            'password.required'  => 'Password baru wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min'       => 'Password minimal harus 6 karakter.',
        ]);

        $user = User::where('email', session('reset_email'))->first();
        
        $user->password = Hash::make($request->password);
        $user->otp_code = null;
        $user->otp_expires_at = null;
        $user->save();

        // Cleanup session
        session()->forget(['reset_email', 'reset_verified']);

        // Auto login
        Auth::login($user);
        $request->session()->regenerate();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard')->with('success', 'Password berhasil diatur ulang. Selamat datang kembali!');
        }
        
        return redirect()->route('siswa.dashboard')->with('success', 'Password berhasil diatur ulang. Selamat datang kembali!');

    }
}
