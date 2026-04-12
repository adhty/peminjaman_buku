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

        $query = Buku::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('pengarang', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $buku = $query->latest()->paginate(12)->withQueryString();
        $kategori = Buku::select('kategori')->distinct()->pluck('kategori');

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
            'tgl_kembali_rencana' => 'required|date|after_or_equal:tomorrow',
        ], [
            'tgl_kembali_rencana.required' => 'Tanggal pengembalian wajib ditentukan.',
            'tgl_kembali_rencana.after_or_equal' => 'Tanggal pengembalian minimal adalah hari esok.',
        ]);

        $user = auth()->user();
        if (!$user->anggota) {
            return redirect()->route('siswa.profil.create');
        }

        $buku = Buku::findOrFail($id);

        if ($buku->stok <= 0) {
            return back()->with('error', 'Maaf, stok buku sedang kosong.');
        }

        // Cek apakah siswa masih meminjam buku yang sama
        $sedangDipinjam = Peminjaman::where('anggota_id', $user->anggota->id)
                                    ->where('buku_id', $buku->id)
                                    ->whereIn('status', ['dipinjam', 'terlambat'])
                                    ->exists();

        if ($sedangDipinjam) {
            return back()->with('error', 'Anda masih meminjam buku ini. Selesaikan peminjaman sebelumnya terlebih dahulu.');
        }

        // Buat transaksi peminjaman (Batas Tanggal Kustom)
        Peminjaman::create([
            'anggota_id'          => $user->anggota->id,
            'buku_id'             => $buku->id,
            'tgl_pinjam'          => today(),
            'tgl_kembali_rencana' => $request->tgl_kembali_rencana,
            'status'              => 'dipinjam',
        ]);

        $buku->decrement('stok');

        return redirect()->route('siswa.transaksi.index')->with('success', 'Buku berhasil dipinjam! Pastikan kembalikan tepat waktu.');
    }
}
