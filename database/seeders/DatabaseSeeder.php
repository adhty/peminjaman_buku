<?php

namespace Database\Seeders;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::create([
            'username' => 'admin',
            'name'     => 'Administrator',
            'email'    => 'admin@perpustakaan.com',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
        ]);

        // Siswa user
        $siswa = User::create([
            'username' => 'siswa1',
            'name'     => 'Budi Santoso',
            'email'    => 'budi@sekolah.com',
            'password' => Hash::make('siswa123'),
            'role'     => 'siswa',
        ]);

        // Data Buku
        $buku = [
            ['kode_buku' => 'BK001', 'judul' => 'Laskar Pelangi', 'pengarang' => 'Andrea Hirata', 'penerbit' => 'Bentang Pustaka', 'tahun_terbit' => 2005, 'kategori' => 'Novel', 'stok' => 5],
            ['kode_buku' => 'BK002', 'judul' => 'Bumi Manusia', 'pengarang' => 'Pramoedya Ananta Toer', 'penerbit' => 'Lentera Dipantara', 'tahun_terbit' => 1980, 'kategori' => 'Novel', 'stok' => 3],
            ['kode_buku' => 'BK003', 'judul' => 'Algoritma dan Pemrograman', 'pengarang' => 'Rinaldi Munir', 'penerbit' => 'Informatika', 'tahun_terbit' => 2016, 'kategori' => 'Teknologi', 'stok' => 8],
            ['kode_buku' => 'BK004', 'judul' => 'Fisika Dasar', 'pengarang' => 'Halliday & Resnick', 'penerbit' => 'Erlangga', 'tahun_terbit' => 2010, 'kategori' => 'Sains', 'stok' => 4],
            ['kode_buku' => 'BK005', 'judul' => 'Matematika Diskrit', 'pengarang' => 'Susanna S. Epp', 'penerbit' => 'Cengage', 'tahun_terbit' => 2011, 'kategori' => 'Matematika', 'stok' => 6],
            ['kode_buku' => 'BK006', 'judul' => 'Pemrograman Web', 'pengarang' => 'Agus Saputra', 'penerbit' => 'Lokomedia', 'tahun_terbit' => 2018, 'kategori' => 'Teknologi', 'stok' => 5],
            ['kode_buku' => 'BK007', 'judul' => 'Sejarah Indonesia Modern', 'pengarang' => 'M.C. Ricklefs', 'penerbit' => 'Serambi', 'tahun_terbit' => 2008, 'kategori' => 'Sejarah', 'stok' => 2],
            ['kode_buku' => 'BK008', 'judul' => 'Kalkulus', 'pengarang' => 'James Stewart', 'penerbit' => 'Erlangga', 'tahun_terbit' => 2012, 'kategori' => 'Matematika', 'stok' => 7],
            ['kode_buku' => 'BK009', 'judul' => 'Kimia Organik', 'pengarang' => 'L.G. Wade', 'penerbit' => 'Pearson', 'tahun_terbit' => 2013, 'kategori' => 'Sains', 'stok' => 3],
            ['kode_buku' => 'BK010', 'judul' => 'Bahasa Indonesia', 'pengarang' => 'Gorys Keraf', 'penerbit' => 'Nusa Indah', 'tahun_terbit' => 2000, 'kategori' => 'Bahasa', 'stok' => 10],
        ];

        foreach ($buku as $b) {
            Buku::create($b);
        }

        // Data Anggota
        $anggota = [
            ['user_id' => $siswa->id, 'nis' => '10001', 'nama' => 'Ahmad Fauzi', 'kelas' => 'X IPA 1', 'alamat' => 'Jl. Merdeka No.10', 'no_telp' => '081234567890'],
            ['nis' => '10002', 'nama' => 'Siti Nuraini', 'kelas' => 'X IPA 2', 'alamat' => 'Jl. Sudirman No.5', 'no_telp' => '082345678901'],
            ['nis' => '10003', 'nama' => 'Budi Prasetyo', 'kelas' => 'XI IPS 1', 'alamat' => 'Jl. Diponegoro No.15', 'no_telp' => '083456789012'],
            ['nis' => '10004', 'nama' => 'Dewi Rahayu', 'kelas' => 'XI IPA 1', 'alamat' => 'Jl. Gatot Subroto No.7', 'no_telp' => '084567890123'],
            ['nis' => '10005', 'nama' => 'Eko Wahyudi', 'kelas' => 'XII IPS 2', 'alamat' => 'Jl. Ahmad Yani No.20', 'no_telp' => '085678901234'],
        ];

        foreach ($anggota as $a) {
            Anggota::create($a);
        }

        // Data Peminjaman
        Peminjaman::create([
            'anggota_id'          => 1,
            'buku_id'             => 1,
            'tgl_pinjam'          => now()->subDays(10),
            'tgl_kembali_rencana' => now()->subDays(3),
            'status'              => 'terlambat',
            'denda'               => 3000,
        ]);

        Peminjaman::create([
            'anggota_id'          => 2,
            'buku_id'             => 3,
            'tgl_pinjam'          => now()->subDays(5),
            'tgl_kembali_rencana' => now()->addDays(2),
            'status'              => 'dipinjam',
        ]);

        Peminjaman::create([
            'anggota_id'          => 3,
            'buku_id'             => 5,
            'tgl_pinjam'          => now()->subDays(14),
            'tgl_kembali_rencana' => now()->subDays(7),
            'tgl_kembali_aktual'  => now()->subDays(6),
            'status'              => 'dikembalikan',
            'denda'               => 1000,
        ]);
    }
}
