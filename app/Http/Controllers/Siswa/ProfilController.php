<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function create()
    {
        // Jika sudah ada profil, balik ke dashboard
        if (auth()->user()->anggota) {
            return redirect()->route('siswa.dashboard');
        }

        return view('siswa.profil.create');
    }

    public function store(Request $request)
    {
        if (auth()->user()->anggota) {
            return redirect()->route('siswa.dashboard');
        }

        $request->validate([
            'nis'     => 'required|max:20|unique:anggota,nis',
            'kelas'   => 'required|max:20',
            'alamat'  => 'nullable|max:255',
            'no_telp' => 'nullable|max:15',
        ], [
            'nis.unique' => 'NIS ini sudah terdaftar pada anggota lain.',
        ]);

        Anggota::create([
            'user_id' => auth()->id(),
            'nis'     => $request->nis,
            'nama'    => auth()->user()->name, // Mengambil otomatis dari nama user
            'kelas'   => $request->kelas,
            'alamat'  => $request->alamat,
            'no_telp' => $request->no_telp,
        ]);

        return redirect()->route('siswa.dashboard')->with('success', 'Profil Anda berhasil disimpan! Sekarang Anda dapat mengakses layanan perpustakaan.');
    }
}
