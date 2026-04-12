<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    public function index(Request $request)
    {
        $query = Anggota::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('kelas', 'like', "%{$search}%");
            });
        }

        $anggota = $query->withCount(['peminjamanAktif as aktif_count'])->latest()->paginate(10)->withQueryString();

        return view('admin.anggota.index', compact('anggota'));
    }

    public function show(Anggota $anggota)
    {
        $anggota->load(['peminjaman' => function($query) {
            $query->with('buku')->latest('tgl_pinjam');
        }]);
        
        return view('admin.anggota.show', compact('anggota'));
    }

    public function create()
    {
        return view('admin.anggota.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis'     => 'required|unique:anggota,nis|max:20',
            'nama'    => 'required|max:100',
            'kelas'   => 'required|max:20',
            'alamat'  => 'nullable|max:255',
            'no_telp' => 'nullable|max:15',
        ], [
            'nis.unique' => 'NIS sudah terdaftar.',
        ]);

        Anggota::create($request->all());

        return redirect()->route('admin.anggota.index')->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function edit(Anggota $anggota)
    {
        return view('admin.anggota.edit', compact('anggota'));
    }

    public function update(Request $request, Anggota $anggota)
    {
        $request->validate([
            'nis'     => 'required|max:20|unique:anggota,nis,' . $anggota->id,
            'nama'    => 'required|max:100',
            'kelas'   => 'required|max:20',
            'alamat'  => 'nullable|max:255',
            'no_telp' => 'nullable|max:15',
        ]);

        $anggota->update($request->all());

        return redirect()->route('admin.anggota.index')->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function destroy(Anggota $anggota)
    {
        if ($anggota->peminjamanAktif()->exists()) {
            return back()->with('error', 'Anggota tidak dapat dihapus karena masih memiliki peminjaman aktif.');
        }

        $anggota->delete();

        return redirect()->route('admin.anggota.index')->with('success', 'Anggota berhasil dihapus.');
    }
}
