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

    .avatar-wrapper {
        position: relative;
        display: inline-block;
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
        transition: all 0.3s;
    }

    .avatar:hover {
        transform: scale(1.05);
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
        transition: all 0.2s;
    }

    .form-control-custom:focus {
        background: white;
        box-shadow: 0 0 0 3px rgba(44, 82, 130, 0.1);
        outline: none;
    }

    .input-group-custom {
        background: var(--primary-soft);
        border-radius: 12px;
        overflow: hidden;
    }

    .input-group-custom input {
        background: transparent;
        border: none;
        padding: 10px 14px;
        font-size: 13px;
    }

    .input-group-custom input:focus {
        background: white;
        box-shadow: none;
    }

    .input-group-custom button {
        background: transparent;
        border: none;
        color: var(--secondary);
        padding-right: 14px;
    }

    .input-group-custom button:hover {
        color: var(--primary);
    }

    .btn-save {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        border: none;
        padding: 12px;
        border-radius: 14px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s;
    }

    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(44, 82, 130, 0.3);
    }

    .btn-back {
        background: transparent;
        border: 1.5px solid var(--primary);
        color: var(--primary);
        padding: 6px 18px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 600;
        transition: all 0.2s;
    }

    .btn-back:hover {
        background: var(--primary);
        color: white;
        transform: translateY(-2px);
    }

    .divider {
        border-top: 1px solid #eef2f6;
        margin: 20px 0;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(15px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-in {
        animation: fadeInUp 0.4s ease forwards;
    }
</style>

<div class="row justify-content-center animate-in">
    <div class="col-lg-8 col-md-10">

        <!-- PROFILE CARD -->
        <div class="profile-card">
            <div class="card-body p-4">

                <!-- TOMBOL KEMBALI -->
                <div class="d-flex justify-content-end mb-3">
                    <a href="{{ route('siswa.dashboard') }}" class="btn-back text-decoration-none">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>

                <!-- PROFILE HEADER -->
                <div class="text-center mb-4">
                    <div class="avatar-wrapper">
                        <div class="avatar mx-auto">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    </div>
                    <h5 class="fw-bold mt-3 mb-1" style="color: var(--primary-dark);">{{ auth()->user()->name }}</h5>
                    <div class="d-flex justify-content-center gap-2">
                        <span class="badge px-3 py-1 rounded-pill" style="background: var(--primary-soft); color: var(--primary); font-size: 11px;">
                            <i class="fas fa-envelope me-1"></i> {{ auth()->user()->email }}
                        </span>
                    </div>
                </div>

                <div class="divider"></div>

                <form action="{{ route('siswa.profile.update') }}" method="POST" id="profileForm">
                    @csrf

                    <!-- INFORMASI AKUN -->
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="section-icon" style="background: var(--primary-soft);">
                                <i class="fas fa-user-circle" style="color: var(--primary); font-size: 14px;"></i>
                            </div>
                            <h6 class="section-title" style="color: var(--primary);">Informasi Akun</h6>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label-custom d-block">
                                    <i class="fas fa-user me-1"></i> Nama Lengkap
                                </label>
                                <input type="text" name="name" value="{{ $user->name }}"
                                    class="form-control-custom w-100">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label-custom d-block">
                                    <i class="fas fa-at me-1"></i> Username
                                </label>
                                <input type="text" name="username" value="{{ $user->username }}"
                                    class="form-control-custom w-100">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label-custom d-block">
                                    <i class="fas fa-envelope me-1"></i> Email
                                </label>
                                <input type="email" name="email" value="{{ $user->email }}"
                                    class="form-control-custom w-100">
                            </div>
                        </div>
                    </div>

                    <!-- DATA ANGGOTA -->
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="section-icon" style="background: #f0fdf4;">
                                <i class="fas fa-graduation-cap" style="color: #15803d; font-size: 14px;"></i>
                            </div>
                            <h6 class="section-title" style="color: #15803d;">Data Anggota</h6>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label-custom d-block">
                                    <i class="fas fa-id-card me-1"></i> NIS
                                </label>
                                <input type="text" name="nis" value="{{ $anggota->nis ?? '' }}"
                                    class="form-control-custom w-100">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom d-block">
                                    <i class="fas fa-users me-1"></i> Kelas
                                </label>
                                <select name="kelas" class="form-control-custom w-100" style="appearance: none; cursor: pointer;">
                                    <option value="">Pilih Kelas</option>
                                    <option value="10" {{ ($anggota->kelas ?? '') == '10' ? 'selected' : '' }}>Kelas 10</option>
                                    <option value="11" {{ ($anggota->kelas ?? '') == '11' ? 'selected' : '' }}>Kelas 11</option>
                                    <option value="12" {{ ($anggota->kelas ?? '') == '12' ? 'selected' : '' }}>Kelas 12</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom d-block">
                                    <i class="fas fa-phone me-1"></i> No Telepon
                                </label>
                                <input type="tel" name="no_telp" value="{{ $anggota->no_telp ?? '' }}"
                                    class="form-control-custom w-100" placeholder="08xx-xxxx-xxxx">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom d-block">
                                    <i class="fas fa-map-marker-alt me-1"></i> Alamat
                                </label>
                                <input type="text" name="alamat" value="{{ $anggota->alamat ?? '' }}"
                                    class="form-control-custom w-100">
                            </div>
                        </div>
                    </div>

                    <!-- PASSWORD -->
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="section-icon" style="background: #fffbeb;">
                                <i class="fas fa-lock" style="color: #d97706; font-size: 14px;"></i>
                            </div>
                            <h6 class="section-title" style="color: #d97706;">Keamanan</h6>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label-custom d-block">
                                    <i class="fas fa-key me-1"></i> Password Baru
                                </label>
                                <div class="input-group-custom d-flex align-items-center">
                                    <input type="password" name="password" id="password" placeholder="Kosongkan jika tidak diubah">
                                    <button type="button" class="toggle-password" data-target="password">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom d-block">
                                    <i class="fas fa-check-circle me-1"></i> Konfirmasi Password
                                </label>
                                <div class="input-group-custom d-flex align-items-center">
                                    <input type="password" name="password_confirmation" id="password_confirmation">
                                    <button type="button" class="toggle-password" data-target="password_confirmation">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2" id="passwordError" style="display: none;">
                            <small class="text-danger"><i class="fas fa-exclamation-circle me-1"></i> Password tidak cocok!</small>
                        </div>
                        <div class="mt-2" id="passwordLengthError" style="display: none;">
                            <small class="text-danger"><i class="fas fa-exclamation-circle me-1"></i> Password minimal 6 karakter!</small>
                        </div>
                    </div>

                    <div class="divider"></div>

                    <!-- BUTTON SIMPAN -->
                    <div class="d-grid mt-3">
                        <button type="submit" id="submitBtn" class="btn-save">
                            <i class="fas fa-save me-2"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Font Awesome & SweetAlert -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle password visibility
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);
            const icon = this.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });

    // Validasi password
    const form = document.getElementById('profileForm');
    const password = document.getElementById('password');
    const passwordConfirm = document.getElementById('password_confirmation');
    const passwordError = document.getElementById('passwordError');
    const passwordLengthError = document.getElementById('passwordLengthError');
    const submitBtn = document.getElementById('submitBtn');

    function validatePassword() {
        // Hide errors initially
        passwordError.style.display = 'none';
        passwordLengthError.style.display = 'none';

        if (password.value !== '' || passwordConfirm.value !== '') {
            // Check if passwords match
            if (password.value !== passwordConfirm.value) {
                passwordError.style.display = 'block';
                submitBtn.disabled = true;
                submitBtn.style.opacity = '0.5';
                return false;
            }
            // Check password length
            else if (password.value.length > 0 && password.value.length < 6) {
                passwordLengthError.style.display = 'block';
                submitBtn.disabled = true;
                submitBtn.style.opacity = '0.5';
                return false;
            }
            else {
                submitBtn.disabled = false;
                submitBtn.style.opacity = '1';
                return true;
            }
        } else {
            submitBtn.disabled = false;
            submitBtn.style.opacity = '1';
            return true;
        }
    }

    password.addEventListener('keyup', validatePassword);
    passwordConfirm.addEventListener('keyup', validatePassword);

    // Form submit validation
    form.addEventListener('submit', function(e) {
        if (!validatePassword()) {
            e.preventDefault();
            return false;
        }

        if (password.value !== '' && password.value === passwordConfirm.value) {
            if (!confirm('Apakah Anda yakin ingin mengubah password?')) {
                e.preventDefault();
                return false;
            }
        }

        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Menyimpan...';
        submitBtn.disabled = true;
    });
});

// Notifikasi
@if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        showConfirmButton: false,
        timer: 2500,
        background: 'white',
        confirmButtonColor: '#2c5282'
    });
@endif

@if($errors->any())
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        html: '{!! implode('<br>', $errors->all()) !!}',
        confirmButtonColor: '#2c5282'
    });
@endif
</script>
@endsection