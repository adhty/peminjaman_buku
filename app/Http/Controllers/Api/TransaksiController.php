<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Buku;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        
        if (!$user->anggota) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak terdaftar sebagai anggota.'
            ], 403);
        }

        $transaksi = Peminjaman::with(['buku', 'anggota'])
            ->where('anggota_id', $user->anggota->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar Transaksi Peminjaman Saya',
            'data'    => $transaksi
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'buku_id'    => 'required|exists:buku,id',
            'lama_pinjam'=> 'nullable|integer'
        ]);

        $user = $request->user();
        
        // Cari data anggota yang terhubung dengan user ini secara eksplisit
        $anggota = \App\Models\Anggota::where('user_id', $user->id)->first();

        if (!$anggota) {
            return response()->json([
                'success' => false,
                'message' => 'User ini tidak terdaftar sebagai Anggota Perpustakaan.'
            ], 403);
        }

        $anggotaId = $anggota->id;
        $buku = \App\Models\Buku::find($request->buku_id);

        if (!$buku) {
            return response()->json([
                'success' => false,
                'message' => 'Buku tidak ditemukan.'
            ], 404);
        }

        if ($buku->stok < 1) {
            return response()->json([
                'success' => false,
                'message' => 'Stok buku habis.'
            ], 400);
        }

        // Cek apakah anggota masih meminjam buku ini dan belum dikembalikan
        $sudahPinjam = \App\Models\Peminjaman::where('anggota_id', $anggotaId)
            ->where('buku_id', $request->buku_id)
            ->where('status', 'dipinjam')
            ->exists();

        if ($sudahPinjam) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sedang meminjam buku ini dan belum dikembalikan.'
            ], 400);
        }

        $lamaPinjam = $request->lama_pinjam ?? 7;

        $peminjaman = \App\Models\Peminjaman::create([
            'anggota_id'          => $anggotaId,
            'buku_id'             => $request->buku_id,
            'tgl_pinjam'          => now()->toDateString(),
            'tgl_kembali_rencana' => now()->addDays($lamaPinjam)->toDateString(),
            'status'              => 'dipinjam'
        ]);

        // Kurangi stok buku
        $buku->decrement('stok');

        return response()->json([
            'success' => true,
            'message' => 'Buku berhasil dipinjam',
            'data'    => $peminjaman
        ]);
    }

    public function kembali(Request $request, $id)
    {
        $user = $request->user();
        $anggota = \App\Models\Anggota::where('user_id', $user->id)->first();

        if (!$anggota) {
            return response()->json([
                'success' => false,
                'message' => 'User ini tidak terdaftar sebagai Anggota Perpustakaan.'
            ], 403);
        }

        $peminjaman = \App\Models\Peminjaman::where('id', $id)
            ->where('anggota_id', $anggota->id)
            ->where('status', 'dipinjam')
            ->first();

        if (!$peminjaman) {
            return response()->json([
                'success' => false,
                'message' => 'Data peminjaman tidak ditemukan atau sudah dikembalikan.'
            ], 404);
        }

        $peminjaman->update([
            'tgl_kembali_aktual' => now()->toDateString(),
            'status'              => 'dikembalikan'
        ]);

        // Tambah stok buku
        $peminjaman->buku->increment('stok');

        return response()->json([
            'success' => true,
            'message' => 'Buku berhasil dikembalikan',
            'data'    => $peminjaman
        ]);
    }
}
