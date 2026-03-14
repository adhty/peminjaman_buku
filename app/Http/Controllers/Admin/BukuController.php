<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $query = Buku::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('pengarang', 'like', "%{$search}%")
                  ->orWhere('kode_buku', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%");
            });
        }

        $buku = $query->latest()->paginate(10)->withQueryString();

        return view('admin.buku.index', compact('buku'));
    }

    public function create()
    {
        return view('admin.buku.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_buku'    => 'required|unique:buku,kode_buku|max:20',
            'judul'        => 'required|max:200',
            'pengarang'    => 'required|max:100',
            'penerbit'     => 'required|max:100',
            'tahun_terbit' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'kategori'     => 'required|max:50',
            'stok'         => 'required|integer|min:0',
        ], [
            'kode_buku.unique' => 'Kode buku sudah digunakan.',
        ]);

        Buku::create($request->all());

        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit(Buku $buku)
    {
        return view('admin.buku.edit', compact('buku'));
    }

    public function update(Request $request, Buku $buku)
    {
        $request->validate([
            'kode_buku'    => 'required|max:20|unique:buku,kode_buku,' . $buku->id,
            'judul'        => 'required|max:200',
            'pengarang'    => 'required|max:100',
            'penerbit'     => 'required|max:100',
            'tahun_terbit' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'kategori'     => 'required|max:50',
            'stok'         => 'required|integer|min:0',
        ]);

        $buku->update($request->all());

        return redirect()->route('admin.buku.index')->with('success', 'Data buku berhasil diperbarui.');
    }

    public function destroy(Buku $buku)
    {
        if ($buku->peminjaman()->where('status', 'dipinjam')->exists()) {
            return back()->with('error', 'Buku tidak dapat dihapus karena sedang dipinjam.');
        }

        $buku->delete();

        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil dihapus.');
    }
}
