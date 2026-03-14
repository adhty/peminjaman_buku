@extends('layouts.admin')

@section('title', 'Edit Anggota')
@section('page-title', 'Edit Anggota')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 fw-bold mb-1">Edit Anggota</h2>
        <p class="text-muted mb-0" style="font-size: 14px;">Perbarui profil dan data peminjam</p>
    </div>
    <a href="{{ route('admin.anggota.index') }}" class="btn btn-outline-secondary shadow-sm">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="card shadow-sm border-0" style="max-width: 800px;">
    <div class="card-body p-4">
        <form action="{{ route('admin.anggota.update', $anggota->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nomor Induk Siswa (NIS) <span class="text-danger">*</span></label>
                    <input type="text" name="nis" class="form-control @error('nis') is-invalid @enderror" value="{{ old('nis', $anggota->nis) }}" required>
                    @error('nis')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Kelas <span class="text-danger">*</span></label>
                    <input type="text" name="kelas" class="form-control @error('kelas') is-invalid @enderror" value="{{ old('kelas', $anggota->kelas) }}" required>
                    @error('kelas')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Lengkap Siswa <span class="text-danger">*</span></label>
                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $anggota->nama) }}" required>
                @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Nomor WhatsApp / Telepon</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-telephone text-muted"></i></span>
                    <input type="text" name="no_telp" class="form-control border-start-0 ps-0 @error('no_telp') is-invalid @enderror" value="{{ old('no_telp', $anggota->no_telp) }}">
                </div>
                @error('no_telp')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Alamat Lengkap</label>
                <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="4">{{ old('alamat', $anggota->alamat) }}</textarea>
                @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <hr class="text-muted opacity-25">

            <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="btn btn-warning text-white px-4">
                    <i class="bi bi-save me-1"></i> Update Data Anggota
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
