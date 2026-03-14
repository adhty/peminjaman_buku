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

    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }

    public function hitungDenda(): int
    {
        if ($this->tgl_kembali_aktual && $this->tgl_kembali_aktual->gt($this->tgl_kembali_rencana)) {
            $hari = $this->tgl_kembali_rencana->diffInDays($this->tgl_kembali_aktual);
            return $hari * 1000; // Rp 1.000 per hari
        }
        return 0;
    }

    public function isTerlambat(): bool
    {
        if ($this->status === 'dipinjam') {
            return Carbon::today()->gt($this->tgl_kembali_rencana);
        }
        return false;
    }
}
