<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $anggota = $user->anggota;

        return view('siswa.profile', compact('user', 'anggota'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'     => 'required|max:255',
            'username' => 'required|max:50', // 🔥 WAJIB (karena login pakai username)
            'email'    => 'required|email|max:255',

            'nis'     => 'required|max:20',
            'kelas'   => 'required|max:20',
            'alamat'  => 'nullable|max:255',
            'no_telp' => 'nullable|max:15',

            'password' => 'nullable|min:5|confirmed',
        ]);

        // ✅ UPDATE USER
        $user->name     = $request->name;
        $user->username = $request->username; // 🔥 INI PENTING BANGET
        $user->email    = $request->email;

        // ✅ UPDATE PASSWORD
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // ✅ UPDATE / CREATE ANGGOTA
        Anggota::updateOrCreate(
            ['user_id' => $user->id],
            [
                'nis'     => $request->nis,
                'nama'    => $request->name,
                'kelas'   => $request->kelas,
                'alamat'  => $request->alamat,
                'no_telp' => $request->no_telp,
            ]
        );

        return back()->with('success', 'Profile berhasil diupdate');
    }
}