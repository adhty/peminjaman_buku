<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Support\Str;

class MigrateKategoriSeeder extends Seeder
{
    public function run(): void
    {
        $books = Buku::all();

        foreach ($books as $book) {
            if ($book->kategori) {
                // Find or create category based on the string name
                $kategori = Kategori::firstOrCreate(
                    ['nama' => $book->kategori],
                    ['slug' => Str::slug($book->kategori)]
                );

                // Attach if not already attached
                if (!$book->kategoris()->where('kategoris.id', $kategori->id)->exists()) {
                    $book->kategoris()->attach($kategori->id);
                }
            }
        }
    }
}
