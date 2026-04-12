@extends('layouts.admin')

@section('title', 'Edit User')
@section('page-title', 'Edit User')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 fw-bold mb-1">Form Edit User</h2>
        <p class="text-muted mb-0" style="font-size: 14px;">Perbarui informasi akun untuk <strong>{{ $user->name }}</strong></p>
    </div>
    <a href="{{ route('admin.user.index') }}" class="btn btn-outline-secondary shadow-sm">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="card shadow-sm border-0" style="max-width: 800px;">
    <div class="card-body p-4">
        <form action="{{ route('admin.user.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $user->name) }}" placeholder="Masukkan nama lengkap" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Username <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-at text-muted"></i></span>
                        <input type="text" name="username" class="form-control border-start-0 ps-0 @error('username') is-invalid @enderror"
                            value="{{ old('username', $user->username) }}" placeholder="Contoh: user123" required>
                    </div>
                    @error('username')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope text-muted"></i></span>
                    <input type="email" name="email" class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror"
                        value="{{ old('email', $user->email) }}" placeholder="Contoh: user@email.com" required>
                </div>
                @error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Role <span class="text-danger">*</span></label>
                <select name="role" class="form-select @error('role') is-invalid @enderror" required
                    {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>
                        🛡️ Admin
                    </option>
                    <option value="siswa" {{ old('role', $user->role) === 'siswa' ? 'selected' : '' }}>
                        👤 Siswa
                    </option>
                </select>
                @if($user->id === auth()->id())
                    {{-- Kirim value via hidden jika disabled --}}
                    <input type="hidden" name="role" value="{{ $user->role }}">
                    <div class="form-text text-warning"><i class="bi bi-info-circle me-1"></i>Role tidak dapat diubah pada akun sendiri.</div>
                @endif
                @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="alert alert-info border-0 py-2 px-3 mb-3" style="font-size: 0.875rem; background: #eff6ff;">
                <i class="bi bi-info-circle-fill text-info me-2"></i>
                Kosongkan kolom password jika tidak ingin menggantinya.
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Password Baru</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock text-muted"></i></span>
                        <input type="password" name="password" id="password"
                            class="form-control border-start-0 border-end-0 ps-0 @error('password') is-invalid @enderror"
                            placeholder="Min. 6 karakter (opsional)">
                        <button class="btn btn-light border border-start-0" type="button" onclick="togglePassword('password', 'eye1')">
                            <i class="bi bi-eye" id="eye1"></i>
                        </button>
                    </div>
                    @error('password')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Konfirmasi Password Baru</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock-fill text-muted"></i></span>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="form-control border-start-0 border-end-0 ps-0"
                            placeholder="Ulangi password baru">
                        <button class="btn btn-light border border-start-0" type="button" onclick="togglePassword('password_confirmation', 'eye2')">
                            <i class="bi bi-eye" id="eye2"></i>
                        </button>
                    </div>
                </div>
            </div>

            <hr class="text-muted opacity-25">

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('admin.user.index') }}" class="btn btn-light">Batal</a>
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-check2-circle me-1"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function togglePassword(fieldId, eyeId) {
        const field = document.getElementById(fieldId);
        const eye   = document.getElementById(eyeId);
        if (field.type === 'password') {
            field.type = 'text';
            eye.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            field.type = 'password';
            eye.classList.replace('bi-eye-slash', 'bi-eye');
        }
    }
</script>
@endpush
