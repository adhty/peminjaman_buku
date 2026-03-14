<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        // Auto-update terlambat
        Peminjaman::where('status', 'dipinjam')
                  ->where('tgl_kembali_rencana', '<', today())
                  ->update(['status' => 'terlambat']);

        $query = Peminjaman::with(['anggota', 'buku']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('anggota', fn($q) => $q->where('nama', 'like', "%{$search}%")
                                                     ->orWhere('nis', 'like', "%{$search}%"))
                  ->orWhereHas('buku', fn($q) => $q->where('judul', 'like', "%{$search}%"));
        }

        $transaksi = $query->latest()->paginate(10)->withQueryString();

        return view('admin.transaksi.index', compact('transaksi'));
    }

    public function create()
    {
        $anggota = Anggota::orderBy('nama')->get();
        $buku    = Buku::where('stok', '>', 0)->orderBy('judul')->get();

        return view('admin.transaksi.create', compact('anggota', 'buku'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'anggota_id'          => 'required|exists:anggota,id',
            'buku_id'             => 'required|exists:buku,id',
            'tgl_pinjam'          => 'required|date',
            'tgl_kembali_rencana' => 'required|date|after:tgl_pinjam',
        ], [
            'tgl_kembali_rencana.after' => 'Tanggal rencana kembali harus setelah tanggal pinjam.',
        ]);

        $buku = Buku::findOrFail($request->buku_id);

        if ($buku->stok <= 0) {
            return back()->with('error', 'Stok buku tidak tersedia.')->withInput();
        }

        Peminjaman::create([
            'anggota_id'          => $request->anggota_id,
            'buku_id'             => $request->buku_id,
            'tgl_pinjam'          => $request->tgl_pinjam,
            'tgl_kembali_rencana' => $request->tgl_kembali_rencana,
            'status'              => 'dipinjam',
        ]);

        $buku->decrement('stok');

        return redirect()->route('admin.transaksi.index')->with('success', 'Peminjaman berhasil dicatat.');
    }

    public function kembalikan(Request $request, $id)
    {
        $peminjaman = Peminjaman::with('buku')->findOrFail($id);

        if ($peminjaman->status === 'dikembalikan') {
            return back()->with('error', 'Buku sudah dikembalikan.');
        }

        $tglKembali = $request->tgl_kembali_aktual ? Carbon::parse($request->tgl_kembali_aktual) : Carbon::today();
        $denda = 0;

        if ($tglKembali->gt($peminjaman->tgl_kembali_rencana)) {
            $hari  = $peminjaman->tgl_kembali_rencana->diffInDays($tglKembali);
            $denda = $hari * 1000;
        }

        $peminjaman->update([
            'tgl_kembali_aktual' => $tglKembali,
            'status'             => 'dikembalikan',
            'denda'              => $denda,
        ]);

        $peminjaman->buku->increment('stok');

        $pesan = 'Buku berhasil dikembalikan.';
        if ($denda > 0) {
            $pesan .= ' Denda keterlambatan: Rp ' . number_format($denda, 0, ',', '.');
        }

        return redirect()->route('admin.transaksi.index')->with('success', $pesan);
    }

    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status === 'dipinjam' || $peminjaman->status === 'terlambat') {
            // Kembalikan stok jika dihapus saat masih dipinjam
            $peminjaman->buku->increment('stok');
        }

        $peminjaman->delete();

        return redirect()->route('admin.transaksi.index')->with('success', 'Data transaksi berhasil dihapus.');
    }
}
