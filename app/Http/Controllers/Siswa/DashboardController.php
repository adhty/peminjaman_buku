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
        
        // Auto update terlambat agar denda terhitung
        Peminjaman::where('anggota_id', $anggotaId)
            ->where('status', 'dipinjam')
            ->where('tgl_kembali_rencana', '<', today())
            ->update(['status' => 'terlambat']);

        $totalPinjaman = Peminjaman::where('anggota_id', $anggotaId)->count();
        $sedangDipinjam = Peminjaman::where('anggota_id', $anggotaId)
                                    ->where('status', 'dipinjam')
                                    ->count();
        $terlambat = Peminjaman::where('anggota_id', $anggotaId)
                               ->where('status', 'terlambat')
                               ->count();

        // Denda yang BELUM dibayar (Status bayar 'belum_bayar')
        // Termasuk denda berjalan (terlambat) dan denda tetap (dikembalikan tapi belum bayar)
        $dendaBelumDibayar = Peminjaman::where('anggota_id', $anggotaId)
            ->where('status_bayar', 'belum_bayar')
            ->get()
            ->sum(function($p) {
                // Jika masih terlambat, hitung denda berjalannya
                if ($p->status === 'terlambat') {
                    return $p->hitungDenda();
                }
                // Jika sudah kembali tapi belum bayar, ambil nilai denda yang tersimpan
                return $p->denda;
            });

        // Denda yang SUDAH dibayar (Status bayar 'lunas')
        $dendaDibayar = Peminjaman::where('anggota_id', $anggotaId)
            ->where('status_bayar', 'lunas')
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
