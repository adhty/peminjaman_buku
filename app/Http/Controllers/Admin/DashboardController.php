<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\DB; // 🔥 tambahan

class DashboardController extends Controller
{
    public function index()
    {
        // 🔥 UPDATE STATUS TERLAMBAT (Pindahkan ke atas agar statistik akurat)
        Peminjaman::where('status', 'dipinjam')
                  ->where('tgl_kembali_rencana', '<', today())
                  ->update(['status' => 'terlambat']);

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

        // ======================
        // 📊 STATISTIK BULANAN
        // ======================
        $statistik = DB::table('peminjaman')
            ->select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $bulan = [];
        $total = [];

        foreach ($statistik as $s) {
            $bulan[] = date("M", mktime(0, 0, 0, $s->bulan, 1));
            $total[] = $s->total;
        }

        return view('admin.dashboard', compact(
            'totalBuku',
            'totalAnggota',
            'dipinjam',
            'terlambat',
            'dikembalikan',
            'peminjamanTerbaru',
            'bulan',   // 🔥 kirim ke view
            'total'    // 🔥 kirim ke view
        ));
    }
}