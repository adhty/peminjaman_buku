<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Redirect ke lengkapi profil jika anggota belum ada
        if (!$user->anggota) {
            return redirect()->route('siswa.profil.create')
                ->with('warning', 'Silakan lengkapi data profil (Anggota) Anda terlebih dahulu sebelum menggunakan layanan perpustakaan.');
        }

        $anggotaId = $user->anggota->id;

        $totalPinjaman = Peminjaman::where('anggota_id', $anggotaId)->count();
        $sedangDipinjam = Peminjaman::where('anggota_id', $anggotaId)
                                    ->where('status', 'dipinjam')
                                    ->count();
        $terlambat = Peminjaman::where('anggota_id', $anggotaId)
                               ->where('status', 'terlambat')
                               ->count();

        $dendaBelumDibayar = Peminjaman::where('anggota_id', $anggotaId)
                                       ->where('status', 'terlambat')
                                       ->get()
                                       ->sum(function($p) {
                                            return $p->hitungDenda();
                                       });

        // Tagihan terbayar dihitung dari yang sudah dikembalikan dan ada nominal denda
        $dendaDibayar = Peminjaman::where('anggota_id', $anggotaId)
                                       ->where('status', 'dikembalikan')
                                       ->sum('denda');

        $riwayatTerbaru = Peminjaman::with('buku')
                                    ->where('anggota_id', $anggotaId)
                                    ->latest('tgl_pinjam')
                                    ->take(5)
                                    ->get();

        return view('siswa.dashboard', compact(
            'totalPinjaman', 
            'sedangDipinjam', 
            'terlambat', 
            'dendaBelumDibayar',
            'dendaDibayar',
            'riwayatTerbaru'
        ));
    }
}
