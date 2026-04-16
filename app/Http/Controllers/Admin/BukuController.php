<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\BukuImport;
use App\Exports\BukuTemplateExport;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $query = Buku::query();

        // Text search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('pengarang', 'like', "%{$search}%")
                  ->orWhere('kode_buku', 'like', "%{$search}%")
                  ->orWhere('penerbit', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Stock status filter
        if ($request->filled('stok_status')) {
            if ($request->stok_status === 'tersedia') {
                $query->where('stok', '>', 0);
            } elseif ($request->stok_status === 'habis') {
                $query->where('stok', 0);
            }
        }

        $perPage = $request->input('per_page', 10);
        $buku = $query->latest()->paginate($perPage)->withQueryString();

        // Get distinct categories for filter dropdown
        $kategoriList = Buku::select('kategori')->distinct()->orderBy('kategori')->pluck('kategori');

        // Count stats
        $totalBuku = Buku::count();
        $totalTersedia = Buku::where('stok', '>', 0)->count();
        $totalHabis = Buku::where('stok', 0)->count();

        return view('admin.buku.index', compact('buku', 'kategoriList', 'totalBuku', 'totalTersedia', 'totalHabis'));
    }

    public function show(Buku $buku)
    {
        return view('admin.buku.show', compact('buku'));
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
            'deskripsi'    => 'nullable|string',
            'stok'         => 'required|integer|min:0',
            'cover'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'kode_buku.unique' => 'Kode buku sudah digunakan.',
        ]);

        $data = $request->all();

        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('buku_covers', 'public');
        }

        Buku::create($data);

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
            'deskripsi'    => 'nullable|string',
            'stok'         => 'required|integer|min:0',
            'cover'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('cover')) {
            if ($buku->cover) {
                Storage::disk('public')->delete($buku->cover);
            }
            $data['cover'] = $request->file('cover')->store('buku_covers', 'public');
        }

        $buku->update($data);

        return redirect()->route('admin.buku.index')->with('success', 'Data buku berhasil diperbarui.');
    }

    public function destroy(Buku $buku)
    {
        if ($buku->peminjaman()->where('status', 'dipinjam')->exists()) {
            return back()->with('error', 'Buku tidak dapat dihapus karena sedang dipinjam.');
        }

        if ($buku->cover) {
            Storage::disk('public')->delete($buku->cover);
        }

        $buku->delete();

        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil dihapus.');
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|file|mimes:xlsx,xls,csv|max:5120',
        ], [
            'file_excel.required' => 'Pilih file Excel terlebih dahulu.',
            'file_excel.mimes'    => 'Format file harus .xlsx, .xls, atau .csv.',
            'file_excel.max'      => 'Ukuran file maksimal 5MB.',
        ]);

        $import = new BukuImport();
        Excel::import($import, $request->file('file_excel'));

        $errors = $import->errors();
        $imported = $import->getImportedCount();
        $updated  = $import->getSkippedCount();
        $errorCount = count($errors);

        $message = "Import selesai: {$imported} buku baru ditambahkan";
        if ($updated > 0) $message .= ", {$updated} diperbarui";
        if ($errorCount > 0) $message .= ", {$errorCount} baris gagal";
        $message .= '.';

        return redirect()->route('admin.buku.index')->with(
            $errorCount > 0 && ($imported + $updated === 0) ? 'error' : 'success',
            $message
        );
    }

    public function downloadTemplate()
    {
        return Excel::download(new BukuTemplateExport(), 'template-import-buku.xlsx');
    }
}
