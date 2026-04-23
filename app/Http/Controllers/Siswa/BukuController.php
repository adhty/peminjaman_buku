<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        if (!$user->anggota) {
            return redirect()->route('siswa.profil.create')->with('warning', 'Silakan lengkapi profil Anda.');
        }

        $query = Buku::with('kategoris');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('pengarang', 'like', "%{$search}%")
                  ->orWhereHas('kategoris', function($sub) use ($search) {
                      $sub->where('nama', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('kategori_id')) {
            $query->whereHas('kategoris', function($q) use ($request) {
                $q->where('kategoris.id', $request->kategori_id);
            });
        }

        $buku = $query->latest()->paginate(12)->withQueryString();
        $kategori = \App\Models\Kategori::orderBy('nama')->get();

        return view('siswa.buku.index', compact('buku', 'kategori'));
    }

    public function show($id)
    {
        $user = auth()->user();
        if (!$user->anggota) {
            return redirect()->route('siswa.profil.create');
        }

        $buku = Buku::findOrFail($id);
        return view('siswa.buku.show', compact('buku'));
    }

    public function pinjam(Request $request, $id)
    {
        $request->validate([
            'tgl_kembali_rencana' => 'required|date|after:today|before_or_equal:' . today()->addDays(7)->format('Y-m-d'),
        ]);

        $user = auth()->user();
        if (!$user->anggota) {
            return redirect()->route('siswa.profil.create');
        }

        $buku = Buku::findOrFail($id);

        if ($buku->stok <= 0) {
            return back()->with('error', 'Maaf, stok buku sedang kosong.');
        }

        // Cek total peminjaman aktif (termasuk yang menunggu persetujuan)
        $totalAktif = Peminjaman::where('anggota_id', $user->anggota->id)
                                ->whereIn('status', ['menunggu_persetujuan', 'dipinjam', 'terlambat'])
                                ->count();
        
        if ($totalAktif >= 3) {
            return back()->with('error', 'Maaf, batas maksimal peminjaman adalah 3 buku. Selesaikan peminjaman Anda sebelumnya terlebih dahulu.');
        }

        // Cek apakah siswa masih meminjam buku yang sama
        $sedangDipinjam = Peminjaman::where('anggota_id', $user->anggota->id)
                                    ->where('buku_id', $buku->id)
                                    ->whereIn('status', ['menunggu_persetujuan', 'dipinjam', 'terlambat'])
                                    ->exists();

        if ($sedangDipinjam) {
            return back()->with('error', 'Anda masih memiliki permintaan atau peminjaman aktif untuk buku ini.');
        }

        // Buat transaksi peminjaman
        Peminjaman::create([
            'anggota_id'          => $user->anggota->id,
            'buku_id'             => $buku->id,
            'tgl_pinjam'          => today(),
            'tgl_kembali_rencana' => $request->tgl_kembali_rencana,
            'status'              => 'menunggu_persetujuan',
        ]);

        $buku->decrement('stok');

        return redirect()->route('siswa.transaksi.index')->with('success', 'Permintaan buku berhasil dikirim! Harap tunggu persetujuan dari Admin.');
    }
}
