@extends('layouts.admin')

@section('title', 'Tambah Buku')
@section('page-title', 'Tambah Buku')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 fw-bold mb-1">Form Tambah Buku</h2>
        <p class="text-muted mb-0" style="font-size: 14px;">Masukkan detail informasi buku baru ke katalog</p>
    </div>
    <a href="{{ route('admin.buku.index') }}" class="btn btn-outline-secondary shadow-sm">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="alert alert-warning bg-warning bg-opacity-10 border border-warning border-opacity-50 shadow-sm d-flex align-items-center mb-4" role="alert" style="max-width: 800px;">
    <i class="bi bi-exclamation-triangle-fill text-warning flex-shrink-0 me-3" style="font-size: 1.5rem;"></i>
    <div class="text-dark">
        <strong>Aturan Denda Perpustakaan:</strong> Membawa buku melewati batas peminjaman dikenakan otomatis <strong>Rp 5.000 / Hari</strong>. Terdapat fitur baru per hari ini Admin dapat mengatur jumlah denda manual tertentu jika siswa menghilangkan, menghilangkan halaman, atau merusak buku.
    </div>
</div>

<div class="card shadow-sm border-0" style="max-width: 800px;">
    <div class="card-body p-4">
        <form action="{{ route('admin.buku.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Kode Buku <span class="text-danger">*</span></label>
                    <input type="text" name="kode_buku" class="form-control @error('kode_buku') is-invalid @enderror" value="{{ old('kode_buku') }}" placeholder="Contoh: BK001" required>
                    @error('kode_buku')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                    <select name="kategori" class="form-select @error('kategori') is-invalid @enderror" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Novel" {{ old('kategori') == 'Novel' ? 'selected' : '' }}>Novel</option>
                        <option value="Teknologi" {{ old('kategori') == 'Teknologi' ? 'selected' : '' }}>Teknologi / IT</option>
                        <option value="Sains" {{ old('kategori') == 'Sains' ? 'selected' : '' }}>Sains & Alam</option>
                        <option value="Sejarah" {{ old('kategori') == 'Sejarah' ? 'selected' : '' }}>Sejarah</option>
                        <option value="Matematika" {{ old('kategori') == 'Matematika' ? 'selected' : '' }}>Matematika</option>
                        <option value="Bahasa" {{ old('kategori') == 'Bahasa' ? 'selected' : '' }}>Bahasa & Sastra</option>
                        <option value="Lainnya" {{ old('kategori') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('kategori')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-8">
                    <label class="form-label fw-semibold">Judul Buku <span class="text-danger">*</span></label>
                    <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul') }}" placeholder="Masukkan judul lengkap buku" required>
                    @error('judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Cover Buku</label>
                    <input type="file" name="cover" class="form-control @error('cover') is-invalid @enderror" accept="image/*">
                    <small class="text-muted" style="font-size: 0.75rem;">Maks 2MB (JPG/PNG)</small>
                    @error('cover')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Pengarang <span class="text-danger">*</span></label>
                    <input type="text" name="pengarang" class="form-control @error('pengarang') is-invalid @enderror" value="{{ old('pengarang') }}" placeholder="Nama pengarang penulis" required>
                    @error('pengarang')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Penerbit <span class="text-danger">*</span></label>
                    <input type="text" name="penerbit" class="form-control @error('penerbit') is-invalid @enderror" value="{{ old('penerbit') }}" placeholder="Nama penerbit buku" required>
                    @error('penerbit')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Tahun Terbit <span class="text-danger">*</span></label>
                    <input type="number" name="tahun_terbit" class="form-control @error('tahun_terbit') is-invalid @enderror" value="{{ old('tahun_terbit', date('Y')) }}" placeholder="Contoh: 2023" required>
                    @error('tahun_terbit')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Jumlah Stok <span class="text-danger">*</span></label>
                    <input type="number" name="stok" class="form-control @error('stok') is-invalid @enderror" value="{{ old('stok', 1) }}" min="0" required>
                    @error('stok')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Deskripsi Buku</label>
                <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="3" placeholder="Masukkan deskripsi atau sinopsis singkat buku...">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <hr class="text-muted opacity-25">

            <div class="d-flex justify-content-end gap-2 mt-4">
                <button type="reset" class="btn btn-light">Reset Form</button>
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-save me-1"></i> Simpan Buku
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
