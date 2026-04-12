@extends('layouts.admin')

@section('title', 'Detail User')
@section('page-title', 'Detail Kredensial User')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 fw-bold mb-1">Informasi Akun</h2>
        <p class="text-muted mb-0" style="font-size: 14px;">Detail kredensial untuk akses sistem</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-warning text-white shadow-sm">
            <i class="bi bi-pencil-square me-1"></i> Edit
        </a>
        <a href="{{ route('admin.user.index') }}" class="btn btn-outline-secondary shadow-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card shadow-sm border-0">
            <div class="card-body p-5 text-center position-relative">
                @if($user->id === auth()->id())
                    <span class="position-absolute top-0 end-0 m-4 badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 px-3 py-2 rounded-pill">
                        <i class="bi bi-person-check me-1"></i> Akun Anda
                    </span>
                @endif
                
                <div class="mx-auto rounded-circle d-flex align-items-center justify-content-center mb-4 text-white shadow-sm
                    {{ $user->role === 'admin' ? 'bg-primary' : 'bg-success' }}" 
                    style="width: 120px; height: 120px; font-size: 3rem;">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                
                <h3 class="fw-bold mb-1">{{ $user->name }}</h3>
                <div class="font-monospace text-muted mb-4 pb-3 border-bottom"><i class="bi bi-at"></i>{{ $user->username }}</div>
                
                <div class="row text-start g-4 mb-4">
                    <div class="col-sm-6">
                        <div class="text-muted small mb-1">Alamat Email</div>
                        <div class="fw-medium"><i class="bi bi-envelope text-primary me-2"></i>{{ $user->email }}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-muted small mb-1">Role / Hak Akses</div>
                        <div class="fw-medium">
                            @if($user->role === 'admin')
                                <i class="bi bi-shield-check text-primary me-2"></i>Administrator
                            @else
                                <i class="bi bi-person text-success me-2"></i>Siswa
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-muted small mb-1">Tanggal Bergabung</div>
                        <div class="fw-medium"><i class="bi bi-calendar-plus text-muted me-2"></i>{{ $user->created_at->format('d F Y') }}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-muted small mb-1">Status Keanggotaan</div>
                        <div class="fw-medium">
                            @if($user->role === 'admin')
                                <span class="text-muted"><i class="bi bi-dash-circle me-1"></i>Bukan Anggota</span>
                            @else
                                @if($user->anggota)
                                    <span class="text-success"><i class="bi bi-check-circle me-1"></i>Profil Tersedia</span>
                                @else
                                    <span class="text-warning"><i class="bi bi-exclamation-circle me-1"></i>Belum Lengkap</span>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>

                @if($user->role === 'siswa' && $user->anggota)
                    <div class="mt-4 pt-4 border-top">
                        <a href="{{ route('admin.anggota.show', $user->anggota->id) }}" class="btn btn-primary btn-lg w-100 rounded-pill fs-6 px-3">
                            <i class="bi bi-person-lines-fill me-2"></i>Lihat Profil Lengkap & Riwayat Pinjaman
                        </a>
                        <p class="text-muted mt-3 mb-0 text-center" style="font-size: 0.8rem;">
                            Untuk melihat aktivitas peminjaman buku beserta datanya, silakan kunjungi menu Kelola Anggota.
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
