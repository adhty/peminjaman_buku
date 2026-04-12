@extends('layouts.admin')

@section('title', 'Kelola Anggota')
@section('page-title', 'Anggota')

@section('content')


<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3">
        <form action="{{ route('admin.anggota.index') }}" method="GET" class="d-flex" style="max-width: 350px;">
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Cari nama, NIS, kelas..." value="{{ request('search') }}">
                <button class="btn btn-outline-secondary" type="submit">Cari</button>
            </div>
        </form>
    </div>
    
    <div class="card-body p-0">
        @if($anggota->isEmpty())
            <div class="text-center py-5 text-muted">
                <i class="bi bi-people display-4 opacity-50 mb-3 d-block"></i>
                <p 
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-secondary small">
                        <tr>
                            <th width="5%" class="ps-4">NO</th>
                            <th>NIS</th>
                            <th width="25%">NAMA LENGKAP</th>
                            <th>KELAS</th>
                            <th>KONTAK & ALAMAT</th>
                            <th>STATUS PINJAMAN</th>
                            <th width="12%" class="text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($anggota as $item)
                        <tr>
                            <td class="ps-4 text-muted">{{ $anggota->firstItem() + $loop->index }}</td>
                            <td><span class="font-monospace fw-bold text-primary">{{ $item->nis }}</span></td>
                            <td>
                                <div class="fw-bold">{{ $item->nama }}</div>
                            </td>
                            <td><span class="badge bg-light text-dark border">{{ $item->kelas }}</span></td>
                            <td>
                                <div class="small"><i class="bi bi-telephone text-muted me-1"></i> {{ $item->no_telp ?: '-' }}</div>
                                <div class="small text-muted mt-1"><i class="bi bi-geo-alt me-1"></i> {{ Str::limit($item->alamat, 25) ?: '-' }}</div>
                            </td>
                            <td>
                                @if($item->aktif_count > 0)
                                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25">{{ $item->aktif_count }} Buku Dipinjam</span>
                                @else
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25">Bebas Pinjaman</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.anggota.show', $item->id) }}" class="btn btn-info text-white" title="Detail">
                                        <i class="bi bi-person-lines-fill"></i>
                                    </a>
                                    <a href="{{ route('admin.anggota.edit', $item->id) }}" class="btn btn-warning text-white" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger" onclick="confirmDelete(`{{ route('admin.anggota.destroy', $item->id) }}`)" title="Hapus">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($anggota->hasPages())
            <div class="card-footer bg-white py-3 border-top d-flex justify-content-end">
                {{ $anggota->links('pagination::bootstrap-5') }}
            </div>
            @endif
        @endif
    </div>
</div>
@endsection
