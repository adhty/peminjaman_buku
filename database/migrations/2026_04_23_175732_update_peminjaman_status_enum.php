<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // MySQL specific raw query to update ENUM
        DB::statement("ALTER TABLE peminjaman MODIFY COLUMN status ENUM('menunggu_persetujuan', 'dipinjam', 'terlambat', 'menunggu_pengembalian', 'dikembalikan', 'ditolak') DEFAULT 'menunggu_persetujuan'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE peminjaman MODIFY COLUMN status ENUM('menunggu_persetujuan', 'dipinjam', 'terlambat', 'dikembalikan', 'ditolak') DEFAULT 'menunggu_persetujuan'");
    }
};
