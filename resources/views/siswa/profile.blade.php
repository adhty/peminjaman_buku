@extends('layouts.siswa')

@section('title', 'Profile')
@section('page-title', '👤 Edit Profile')

@section('content')
<style>
    :root {
        --primary-dark: #1e3a5f;
        --primary: #2c5282;
        --primary-light: #3182ce;
        --primary-soft: #ebf4ff;
        --secondary: #4a5568;
    }

    .profile-card {
        background: white;
        border-radius: 24px;
        border: 1px solid #eef2f6;
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .profile-card:hover {
        box-shadow: 0 20px 35px -12px rgba(30, 58, 95, 0.15);
    }

    .avatar {
        width: 90px;
        height: 90px;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 36px;
        font-weight: 700;
        color: white;
        box-shadow: 0 10px 25px -5px rgba(44, 82, 130, 0.3);
    }

    .section-icon {
        width: 28px;
        height: 28px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-right: 10px;
    }

    .section-title {
        font-size: 14px;
        font-weight: 700;
        margin: 0;
    }

    .form-label-custom {
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--secondary);
        margin-bottom: 6px;
    }

    .form-control-custom {
        background: var(--primary-soft);
        border: none;
        border-radius: 12px;
        padding: 10px 14px;
        font-size: 13px;
    }

    .btn-save {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        border: none;
        padding: 12px;
        border-radius: 14px;
        font-weight: 600;
        font-size: 14px;
        color: white;
    }

    .btn-back {
        background: transparent;
        border: 1.5px solid var(--primary);
        color: var(--primary);
        padding: 6px 18px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 600;
    }

    .divider {
        border-top: 1px solid #eef2f6;
        margin: 20px 0;
    }
</style>

<div class="row justify-content-center">
    <div class="col-lg-8 col-md-10">

        <div class="profile-card">
            <div class="card-body p-4">

                <!-- BACK -->
                <div class="d-flex justify-content-end mb-3">
                    <a href="{{ route('siswa.dashboard') }}" class="btn-back text-decoration-none">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>

                <!-- HEADER -->
                <div class="text-center mb-4">
                    <div class="avatar mx-auto">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <h5 class="fw-bold mt-3 mb-1" style="color: var(--primary-dark);">
                        {{ auth()->user()->name }}
                    </h5>
                    <span class="badge px-3 py-1 rounded-pill"
                        style="background: var(--primary-soft); color: var(--primary); font-size: 11px;">
                        {{ auth()->user()->email }}
                    </span>
                </div>

                <div class="divider"></div>

                <form action="{{ route('siswa.profile.update') }}" method="POST" id="profileForm">
                    @csrf

                    <!-- INFORMASI AKUN -->
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="section-icon" style="background: var(--primary-soft);">
                                <i class="fas fa-user-circle" style="color: var(--primary);"></i>
                            </div>
                            <h6 class="section-title" style="color: var(--primary);">Informasi Akun</h6>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label-custom">Nama</label>
                                <input type="text" name="name" value="{{ $user->name }}"
                                    class="form-control-custom w-100">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label-custom">Username</label>
                                <input type="text" name="username" value="{{ $user->username }}"
                                    class="form-control-custom w-100">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label-custom">Email</label>
                                <input type="email" name="email" value="{{ $user->email }}"
                                    class="form-control-custom w-100">
                            </div>
                        </div>
                    </div>

                    <!-- DATA ANGGOTA -->
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="section-icon" style="background: #f0fdf4;">
                                <i class="fas fa-graduation-cap" style="color: #15803d;"></i>
                            </div>
                            <h6 class="section-title" style="color: #15803d;">Data Anggota</h6>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label-custom">NIS</label>
                                <input type="text" name="nis" value="{{ $anggota->nis ?? '' }}"
                                    class="form-control-custom w-100">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom">Kelas</label>
                                <select name="kelas" class="form-control-custom w-100">
                                    <option value="">Pilih</option>
                                    <option value="10" {{ ($anggota->kelas ?? '') == '10' ? 'selected' : '' }}>10</option>
                                    <option value="11" {{ ($anggota->kelas ?? '') == '11' ? 'selected' : '' }}>11</option>
                                    <option value="12" {{ ($anggota->kelas ?? '') == '12' ? 'selected' : '' }}>12</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom">No Telp</label>
                                <input type="text" name="no_telp" value="{{ $anggota->no_telp ?? '' }}"
                                    class="form-control-custom w-100">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom">Alamat</label>
                                <input type="text" name="alamat" value="{{ $anggota->alamat ?? '' }}"
                                    class="form-control-custom w-100">
                            </div>
                        </div>
                    </div>

                    <div class="divider"></div>

                    <div class="d-grid">
                        <button type="submit" id="submitBtn" class="btn-save">
                            <i class="fas fa-save me-2"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- SWEET ALERT -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.getElementById('profileForm').addEventListener('submit', function() {
    const btn = document.getElementById('submitBtn');
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Menyimpan...';
    btn.disabled = true;
});

// NOTIF
@if(session('success'))
Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: '{{ session('success') }}',
    timer: 2000,
    showConfirmButton: false
});
@endif

@if($errors->any())
Swal.fire({
    icon: 'error',
    title: 'Error',
    html: '{!! implode('<br>', $errors->all()) !!}'
});
@endif
</script>
@endsection