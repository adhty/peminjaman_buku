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
        'status',
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
        // ✅ 1. Prioritas denda manual (sudah disimpan di database)
        if ($this->denda > 0) {
            return $this->denda;
        }

        // ✅ 2. Jika sudah dikembalikan dan terlambat
        if ($this->tgl_kembali_aktual) {
            if ($this->tgl_kembali_aktual->gt($this->tgl_kembali_rencana)) {
                $hari = $this->tgl_kembali_rencana->diffInDays($this->tgl_kembali_aktual);
                return $hari * 5000;
            }
            return 0;
        }

        // ✅ 3. Jika BELUM dikembalikan (denda berjalan)
        if (today()->gt($this->tgl_kembali_rencana)) {
            $hari = $this->tgl_kembali_rencana->diffInDays(today());
            return $hari * 5000;
        }

        return 0;
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