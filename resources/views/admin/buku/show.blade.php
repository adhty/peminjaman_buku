@extends('layouts.admin')

@section('title', 'Detail Buku')
@section('page-title', 'Detail Buku')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 fw-bold mb-1">Detail Buku</h2>
        <p class="text-muted mb-0" style="font-size: 14px;">Informasi lengkap mengenai buku katalog</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.buku.edit', $buku->id) }}" class="btn btn-warning text-white shadow-sm">
            <i class="bi bi-pencil-square me-1"></i> Edit
        </a>
        <a href="{{ route('admin.buku.index') }}" class="btn btn-outline-secondary shadow-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <div class="row">
            <div class="col-md-4 col-lg-3 text-center mb-4 mb-md-0">
                @if($buku->cover)
                    <img src="{{ Storage::url($buku->cover) }}" alt="Cover Buku" class="img-fluid rounded shadow-sm" style="max-height: 400px; object-fit: cover;">
                @else
                    <div class="bg-light rounded d-flex align-items-center justify-content-center mx-auto shadow-sm" style="width: 100%; aspect-ratio: 3/4; max-width: 250px;">
                        <div class="text-center text-muted opacity-50">
                            <i class="bi bi-book display-1"></i>
                            <div class="mt-2">Tidak ada cover</div>
                        </div>
                    </div>
                @endif
            </div>
            
            <div class="col-md-8 col-lg-9">
                <h3 class="fw-bold mb-3">{{ $buku->judul }}</h3>
                
                <div class="mb-4">
                    <span class="badge bg-primary bg-opacity-10 text-primary me-2">{{ $buku->kategori }}</span>
                    @if($buku->stok > 0)
                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25">{{ $buku->stok }} Tersedia</span>
                    @else
                        <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25">Habis</span>
                    @endif
                </div>

                <div class="row mb-4">
                    <div class="col-sm-6 mb-3">
                        <div class="text-muted small">Kode Buku</div>
                        <div class="fw-semibold font-monospace">{{ $buku->kode_buku }}</div>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <div class="text-muted small">Pengarang</div>
                        <div class="fw-semibold">{{ $buku->pengarang }}</div>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <div class="text-muted small">Penerbit</div>
                        <div class="fw-semibold">{{ $buku->penerbit }}</div>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <div class="text-muted small">Tahun Terbit</div>
                        <div class="fw-semibold">{{ $buku->tahun_terbit }}</div>
                    </div>
                </div>

                <div class="mb-0">
                    <div class="text-muted small mb-1">Deskripsi / Sinopsis</div>
                    <div class="p-3 bg-light rounded text-dark" style="white-space: pre-line;">{{ $buku->deskripsi ?? 'Tidak ada deskripsi untuk buku ini.' }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
