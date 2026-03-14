<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBuku     = Buku::count();
        $totalAnggota  = Anggota::count();
        $dipinjam      = Peminjaman::where('status', 'dipinjam')->count();
        $terlambat     = Peminjaman::where('status', 'terlambat')->count();
        $dikembalikan  = Peminjaman::where('status', 'dikembalikan')
                                   ->whereDate('tgl_kembali_aktual', today())->count();

        $peminjamanTerbaru = Peminjaman::with(['anggota', 'buku'])
                                        ->latest()
                                        ->take(5)
                                        ->get();

        // Update status yang sudah terlambat
        Peminjaman::where('status', 'dipinjam')
                  ->where('tgl_kembali_rencana', '<', today())
                  ->update(['status' => 'terlambat']);

        return view('admin.dashboard', compact(
            'totalBuku', 'totalAnggota', 'dipinjam', 'terlambat', 'dikembalikan', 'peminjamanTerbaru'
        ));
    }
}
