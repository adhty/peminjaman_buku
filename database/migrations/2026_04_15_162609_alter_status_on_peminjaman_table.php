<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE peminjaman 
            MODIFY status ENUM(
                'menunggu_persetujuan',
                'dipinjam',
                'menunggu_pengembalian',
                'dikembalikan',
                'terlambat',
                'ditolak'
            ) DEFAULT 'menunggu_persetujuan'
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE peminjaman 
            MODIFY status ENUM(
                'dipinjam',
                'dikembalikan',
                'terlambat'
            ) DEFAULT 'dipinjam'
        ");
    }
};