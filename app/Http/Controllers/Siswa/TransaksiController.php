<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        if (!$user->anggota) {
            return redirect()->route('siswa.profil.create');
        }

        // Auto update terlambat
        Peminjaman::where('anggota_id', $user->anggota->id)
            ->where('status', 'dipinjam')
            ->where('tgl_kembali_rencana', '<', today())
            ->update(['status' => 'terlambat']);

        $query = Peminjaman::with('buku')
            ->where('anggota_id', $user->anggota->id);

        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }

        $transaksi = $query->latest('updated_at')
            ->paginate(10)
            ->withQueryString();

        return view('siswa.transaksi.index', compact('transaksi'));
    }

    public function kembalikan($id)
    {
        $user = auth()->user();

        if (!$user->anggota) {
            return back()->with('error', 'Akses ditolak.');
        }

        $peminjaman = Peminjaman::where('anggota_id', $user->anggota->id)
            ->with('buku')
            ->findOrFail($id);

        if ($peminjaman->status === 'dikembalikan') {
            return back()->with('warning', 'Buku sudah dikembalikan.');
        }

        if ($peminjaman->status === 'menunggu_verifikasi') {
            return back()->with('warning', 'Sudah diajukan, tunggu admin.');
        }

        // hitung denda sementara
        $denda = $peminjaman->hitungDenda();

        // ✅ FIX FINAL (SAMAKAN DENGAN ADMIN)
        $peminjaman->update([
            'status' => 'menunggu_pengembalian',
            'tgl_kembali_aktual' => today(),
            'denda' => $denda,
        ]);

        return redirect()
            ->route('siswa.transaksi.index')
            ->with('success', 'Permintaan pengembalian dikirim ke admin.');
    }
}