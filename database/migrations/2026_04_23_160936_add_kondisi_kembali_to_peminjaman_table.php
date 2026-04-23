<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->enum('kondisi_buku_kembali', ['baik', 'rusak_ringan', 'rusak_berat'])->default('baik')->after('alasan_ditolak');
            $table->string('foto_kerusakan')->nullable()->after('kondisi_buku_kembali');
            $table->text('catatan_kerusakan')->nullable()->after('foto_kerusakan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->dropColumn(['kondisi_buku_kembali', 'foto_kerusakan', 'catatan_kerusakan']);
        });
    }
};
