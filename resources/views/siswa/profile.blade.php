@extends('layouts.siswa')

@section('title', 'Profile')
@section('page-title', 'Edit Profile')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">

        <!-- CARD -->
        <div class="card border-0 shadow-sm rounded-4 p-4 position-relative">

            <!-- 🔥 TOMBOL KEMBALI (KANAN ATAS) -->
            <div class="position-absolute top-0 end-0 m-3">
                <a href="{{ route('siswa.dashboard') }}"
                   class="btn btn-outline-secondary rounded-3 px-3 py-1 shadow-sm">
                    ← Kembali
                </a>
            </div>

            <!-- PROFILE HEADER -->
            <div class="text-center mb-4 mt-2">
                <div class="bg-primary text-white rounded-circle mx-auto d-flex align-items-center justify-content-center shadow"
                     style="width: 90px; height: 90px; font-size: 32px; font-weight: 600;">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>

                <h5 class="fw-bold mt-3 mb-1">{{ auth()->user()->name }}</h5>
                <small class="text-muted">{{ auth()->user()->email }}</small>
            </div>

            <form action="{{ route('siswa.profile.update') }}" method="POST">
                @csrf

                <!-- INFORMASI AKUN -->
                <div class="mb-4">
                    <h6 class="fw-semibold mb-3 text-primary">Informasi Akun</h6>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label small text-muted">Nama</label>
                            <input type="text" name="name"
                                value="{{ $user->name }}"
                                class="form-control rounded-3">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label small text-muted">Username</label>
                            <input type="text" name="username"
                                value="{{ $user->username }}"
                                class="form-control rounded-3">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label small text-muted">Email</label>
                            <input type="email" name="email"
                                value="{{ $user->email }}"
                                class="form-control rounded-3">
                        </div>
                    </div>
                </div>

                <!-- DATA ANGGOTA -->
                <div class="mb-4">
                    <h6 class="fw-semibold mb-3 text-primary">Data Anggota</h6>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small text-muted">NIS</label>
                            <input type="text" name="nis"
                                value="{{ $anggota->nis ?? '' }}"
                                class="form-control rounded-3">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small text-muted">Kelas</label>
                            <input type="text" name="kelas"
                                value="{{ $anggota->kelas ?? '' }}"
                                class="form-control rounded-3">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small text-muted">No Telp</label>
                            <input type="text" name="no_telp"
                                value="{{ $anggota->no_telp ?? '' }}"
                                class="form-control rounded-3">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small text-muted">Alamat</label>
                            <input type="text" name="alamat"
                                value="{{ $anggota->alamat ?? '' }}"
                                class="form-control rounded-3">
                        </div>
                    </div>
                </div>

                <!-- PASSWORD -->
                <div class="mb-4">
                    <h6 class="fw-semibold mb-3 text-primary">Keamanan</h6>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Password Baru</label>
                            <input type="password" name="password"
                                class="form-control rounded-3"
                                placeholder="Kosongkan jika tidak diubah">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small text-muted">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation"
                                class="form-control rounded-3">
                        </div>
                    </div>
                </div>

                <!-- BUTTON SIMPAN -->
                <div class="d-grid">
                    <button type="submit"
                        class="btn btn-primary rounded-3 py-2 fw-semibold">
                        Simpan Perubahan
                    </button>
                </div>

            </form>

        </div>

    </div>
</div>
@endsection