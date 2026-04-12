<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'buku';

    protected $fillable = [
        'kode_buku',
        'judul',
        'pengarang',
        'penerbit',
        'tahun_terbit',
        'kategori',
        'deskripsi',
        'cover',
        'stok',
    ];

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }

    public function isAvailable(): bool
    {
        return $this->stok > 0;
    }
}
