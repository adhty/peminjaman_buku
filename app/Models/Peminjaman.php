<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';

    protected $fillable = [
        'anggota_id',
        'buku_id',
        'tgl_pinjam',
        'tgl_kembali_rencana',
        'tgl_kembali_aktual',
        'alasan_ditolak',
        'status_bayar',
        'status',
        'kondisi_buku_kembali',
        'foto_kerusakan',
        'catatan_kerusakan',
        'denda',
    ];

    protected $casts = [
        'tgl_pinjam' => 'date',
        'tgl_kembali_rencana' => 'date',
        'tgl_kembali_aktual' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI
    |--------------------------------------------------------------------------
    */

    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }

    /*
    |--------------------------------------------------------------------------
    | HITUNG DENDA
    |--------------------------------------------------------------------------
    */

    public function hitungDenda(): int
    {
        // Jika sudah dikembalikan, nilai denda di database adalah TOTAL
        if ($this->status === 'dikembalikan') {
            return $this->denda;
        }

        // Hitung denda telat berjalan
        $dendaTelat = 0;
        if (today()->gt($this->tgl_kembali_rencana)) {
            $hari = $this->tgl_kembali_rencana->diffInDays(today());
            $dendaTelat = $hari * 5000;
        }

        // Total = Denda Manual (kerusakan dsb) + Denda Telat
        return $this->denda + $dendaTelat;
    }

    /*
    |--------------------------------------------------------------------------
    | STATUS HELPER
    |--------------------------------------------------------------------------
    */

    public function isTerlambat(): bool
    {
        return $this->status === 'terlambat' ||
               ($this->status === 'dipinjam' && today()->gt($this->tgl_kembali_rencana));
    }

    public function isDipinjam(): bool
    {
        return $this->status === 'dipinjam';
    }

    public function isDikembalikan(): bool
    {
        return $this->status === 'dikembalikan';
    }


    public function getDendaFormatAttribute(): string
    {
        return 'Rp ' . number_format($this->hitungDenda(), 0, ',', '.');
    }
}