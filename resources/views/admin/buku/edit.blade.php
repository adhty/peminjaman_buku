@extends('layouts.admin')

@section('title', 'Edit Buku')
@section('page-title', 'Edit Buku')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 fw-bold mb-1">Edit Buku</h2>
        <p class="text-muted mb-0" style="font-size: 14px;">Perbarui informasi detail untuk buku katalog</p>
    </div>
    <a href="{{ route('admin.buku.index') }}" class="btn btn-outline-secondary shadow-sm">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="card shadow-sm border-0" style="max-width: 800px;">
    <div class="card-body p-4">
        <form action="{{ route('admin.buku.update', $buku->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Kode Buku <span class="text-danger">*</span></label>
                    <input type="text" name="kode_buku" class="form-control @error('kode_buku') is-invalid @enderror" value="{{ old('kode_buku', $buku->kode_buku) }}" required>
                    @error('kode_buku')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                    <select name="kategori" class="form-select @error('kategori') is-invalid @enderror" required>
                        <option value="Novel" {{ old('kategori', $buku->kategori) == 'Novel' ? 'selected' : '' }}>Novel</option>
                        <option value="Teknologi" {{ old('kategori', $buku->kategori) == 'Teknologi' ? 'selected' : '' }}>Teknologi / IT</option>
                        <option value="Sains" {{ old('kategori', $buku->kategori) == 'Sains' ? 'selected' : '' }}>Sains & Alam</option>
                        <option value="Sejarah" {{ old('kategori', $buku->kategori) == 'Sejarah' ? 'selected' : '' }}>Sejarah</option>
                        <option value="Matematika" {{ old('kategori', $buku->kategori) == 'Matematika' ? 'selected' : '' }}>Matematika</option>
                        <option value="Bahasa" {{ old('kategori', $buku->kategori) == 'Bahasa' ? 'selected' : '' }}>Bahasa & Sastra</option>
                        <option value="Lainnya" {{ old('kategori', $buku->kategori) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('kategori')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-7">
                    <label class="form-label fw-semibold">Judul Buku <span class="text-danger">*</span></label>
                    <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul', $buku->judul) }}" required>
                    @error('judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-5">
                    <label class="form-label fw-semibold">Cover Buku</label>
                    <input type="file" name="cover" class="form-control @error('cover') is-invalid @enderror" accept="image/*">
                    <small class="text-muted" style="font-size: 0.75rem;">Biarkan kosong jika tidak ingin mengubah cover.</small>
                    @error('cover')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    
                    @if($buku->cover)
                        <div class="mt-2">
                            <span class="d-block text-muted small mb-1">Cover saat ini:</span>
                            <img src="{{ Storage::url($buku->cover) }}" alt="Cover Buku" class="img-thumbnail" style="max-height: 80px;">
                        </div>
                    @endif
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Pengarang <span class="text-danger">*</span></label>
                    <input type="text" name="pengarang" class="form-control @error('pengarang') is-invalid @enderror" value="{{ old('pengarang', $buku->pengarang) }}" required>
                    @error('pengarang')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Penerbit <span class="text-danger">*</span></label>
                    <input type="text" name="penerbit" class="form-control @error('penerbit') is-invalid @enderror" value="{{ old('penerbit', $buku->penerbit) }}" required>
                    @error('penerbit')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Tahun Terbit <span class="text-danger">*</span></label>
                    <input type="number" name="tahun_terbit" class="form-control @error('tahun_terbit') is-invalid @enderror" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}" required>
                    @error('tahun_terbit')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Jumlah Stok <span class="text-danger">*</span></label>
                    <input type="number" name="stok" class="form-control @error('stok') is-invalid @enderror" value="{{ old('stok', $buku->stok) }}" min="0" required>
                    @error('stok')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Deskripsi Buku</label>
                <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="3" placeholder="Masukkan deskripsi atau sinopsis singkat buku...">{{ old('deskripsi', $buku->deskripsi) }}</textarea>
                @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <hr class="text-muted opacity-25">

            <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="btn btn-warning px-4 text-white">
                    <i class="bi bi-save me-1"></i> Update Data Buku
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
