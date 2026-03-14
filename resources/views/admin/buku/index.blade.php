@extends('layouts.admin')

@section('title', 'Data Buku')
@section('page-title', 'Buku')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 fw-bold mb-1">Data Koleksi Buku</h2>
        <p class="text-muted mb-0" style="font-size: 14px;">Kelola semua katalog buku di perpustakaan</p>
    </div>
    <a href="{{ route('admin.buku.create') }}" class="btn btn-primary shadow-sm">
        <i class="bi bi-plus-lg me-1"></i> Tambah Buku
    </a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3">
        <form action="{{ route('admin.buku.index') }}" method="GET" class="d-flex" style="max-width: 350px;">
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Cari judul, pengarang, kode..." value="{{ request('search') }}">
                <button class="btn btn-outline-secondary" type="submit">Cari</button>
            </div>
        </form>
    </div>
    
    <div class="card-body p-0">
        @if($buku->isEmpty())
            <div class="text-center py-5 text-muted">
                <i class="bi bi-book display-4 opacity-50 mb-3 d-block"></i>
                <p>Belum ada data buku.</p>
                <a href="{{ route('admin.buku.create') }}" class="btn btn-outline-primary mt-2">Tambah Data Pertama</a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-secondary small">
                        <tr>
                            <th width="5%" class="ps-4">NO</th>
                            <th>KODE</th>
                            <th width="30%">JUDUL BUKU</th>
                            <th>PENGARANG</th>
                            <th>KATEGORI</th>
                            <th>STOK</th>
                            <th width="12%" class="text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($buku as $item)
                        <tr>
                            <td class="ps-4 text-muted">{{ $buku->firstItem() + $loop->index }}</td>
                            <td><span class="badge bg-light text-dark border font-monospace">{{ $item->kode_buku }}</span></td>
                            <td>
                                <div class="fw-bold">{{ $item->judul }}</div>
                                <div class="small text-muted">{{ $item->penerbit }} ({{ $item->tahun_terbit }})</div>
                            </td>
                            <td>{{ $item->pengarang }}</td>
                            <td><span class="badge bg-primary bg-opacity-10 text-primary">{{ $item->kategori }}</span></td>
                            <td>
                                @if($item->stok > 0)
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25">{{ $item->stok }} Tersedia</span>
                                @else
                                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25">Habis</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.buku.edit', $item->id) }}" class="btn btn-warning text-white" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger" onclick="confirmDelete(`{{ route('admin.buku.destroy', $item->id) }}`)" title="Hapus">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($buku->hasPages())
            <div class="card-footer bg-white py-3 border-top d-flex justify-content-end">
                {{ $buku->links('pagination::bootstrap-5') }}
            </div>
            @endif
        @endif
    </div>
</div>
@endsection
