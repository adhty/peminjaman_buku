<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Kategori extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'slug'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($kategori) {
            if (!$kategori->slug) {
                $kategori->slug = Str::slug($kategori->nama);
            }
        });
    }

    public function buku()
    {
        return $this->belongsToMany(Buku::class, 'buku_kategori', 'kategori_id', 'buku_id');
    }
}
