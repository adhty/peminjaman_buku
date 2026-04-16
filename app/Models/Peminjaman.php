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
        // Prioritaskan denda manual atau denda yang sudah permanen/lunas (sudah dikembalikan)
        if ($this->denda > 0) {
            return $this->denda;
        }

        // Jika buku sudah dikembalikan secara telat (tapi sistem denda nya 0 sebelumnya)
        if ($this->tgl_kembali_aktual && $this->tgl_kembali_aktual->gt($this->tgl_kembali_rencana)) {
            $hari = $this->tgl_kembali_rencana->diffInDays($this->tgl_kembali_aktual);
            return $hari * 5000;
        }

        // Jika buku belum dikembalikan (denda sementara masih berjalan)
        if (!$this->tgl_kembali_aktual && today()->gt($this->tgl_kembali_rencana)) {
            $hari = $this->tgl_kembali_rencana->diffInDays(today());
            return $hari * 5000;
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
