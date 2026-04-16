<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class StatistikController extends Controller
{
    public function index()
    {
        $user    = auth()->user();
        $anggota = $user->anggota;

        if (!$anggota) {
            return redirect()->route('siswa.profil.create')
                ->with('error', 'Lengkapi profil Anda terlebih dahulu.');
        }

        $totalPinjam     = Peminjaman::where('anggota_id', $anggota->id)->count();
        $totalKembali    = Peminjaman::where('anggota_id', $anggota->id)->where('status', 'dikembalikan')->count();
        $totalTerlambat  = Peminjaman::where('anggota_id', $anggota->id)->where('status', 'terlambat')->count();
        $totalAktif      = Peminjaman::where('anggota_id', $anggota->id)->whereIn('status', ['dipinjam', 'terlambat'])->count();

        $riwayat = Peminjaman::with('buku')
            ->where('anggota_id', $anggota->id)
            ->latest()
            ->paginate(10);

        return view('siswa.statistik', compact(
            'totalPinjam', 'totalKembali', 'totalTerlambat', 'totalAktif', 'riwayat'
        ));
    }
}
