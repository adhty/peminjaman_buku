@extends('layouts.siswa')

@section('title', 'Lengkapi Profil')
@section('page-title', 'Lengkapi Profil Anggota')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm" style="border-radius: 16px;">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <div class="mx-auto bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="bi bi-person-vcard text-primary display-4"></i>
                    </div>
                    <h3 class="fw-bold mb-1">Pendaftaran Anggota Perpustakaan</h3>
                    <p class="text-muted">Halo, {{ auth()->user()->name }}! Silakan lengkapi data berikut sebelum Anda dapat meminjam buku.</p>
                </div>

                <form action="{{ route('siswa.profil.store') }}" method="POST">
                    @csrf
                    
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nomor Induk Siswa (NIS) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-123 text-muted"></i></span>
                                <input type="text" name="nis" class="form-control border-start-0 ps-0 @error('nis') is-invalid @enderror" value="{{ old('nis') }}" placeholder="Contoh: 100123" required>
                            </div>
                            @error('nis')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Kelas <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-mortarboard text-muted"></i></span>
                                <input type="text" name="kelas" class="form-control border-start-0 ps-0 @error('kelas') is-invalid @enderror" value="{{ old('kelas') }}" placeholder="Contoh: X RPL 1" required>
                            </div>
                            @error('kelas')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nomor WhatsApp / Telepon</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-whatsapp text-muted"></i></span>
                            <input type="text" name="no_telp" class="form-control border-start-0 ps-0 @error('no_telp') is-invalid @enderror" value="{{ old('no_telp') }}" placeholder="Contoh: 08123456789 (Opsional)">
                        </div>
                        @error('no_telp')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Alamat Lengkap</label>
                        <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3" placeholder="Alamat tempat tinggal (Opsional)">{{ old('alamat') }}</textarea>
                        @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold" style="font-size: 1.1rem; border-radius: 10px;">
                        <i class="bi bi-check2-circle me-1"></i> Daftar Sekarang
                    </button>
                    <div class="text-center mt-3 text-muted" style="font-size: 0.85rem;">
                        Dengan mendaftar, Anda menyetujui peraturan perpustakaan yang berlaku.
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
