<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SiswaMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->role === 'siswa') {
            $user = Auth::user();

            // Allow access to profile completion routes
            if ($request->routeIs('siswa.profil.create') || $request->routeIs('siswa.profil.store')) {
                return $next($request);
            }

            // Redirect to profile completion if user doesn't have an anggota record
            if (!$user->anggota) {
                return redirect()->route('siswa.profil.create')
                    ->with('warning', 'Silakan lengkapi data profil (Anggota) Anda terlebih dahulu sebelum menggunakan layanan perpustakaan.');
            }

            return $next($request);
        }

        return redirect('/')->with('error', 'Akses ditolak. Anda bukan siswa.');
    }
}
