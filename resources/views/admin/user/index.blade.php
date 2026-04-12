@extends('layouts.admin')

@section('title', 'Kelola User')
@section('page-title', 'User')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 fw-bold mb-1">Kelola Akun User</h2>
        <p class="text-muted mb-0" style="font-size: 14px;">Manajemen akun admin dan siswa yang dapat mengakses sistem</p>
    </div>
    <a href="{{ route('admin.user.create') }}" class="btn btn-primary shadow-sm">
        <i class="bi bi-person-plus me-1"></i> Tambah User
    </a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3">
        <form action="{{ route('admin.user.index') }}" method="GET" class="d-flex gap-2 flex-wrap align-items-center">
            <div class="input-group" style="max-width: 320px;">
                <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                <input type="text" name="search" class="form-control border-start-0 ps-0"
                    placeholder="Cari nama, username, email..." value="{{ request('search') }}">
            </div>
            <select name="role" class="form-select" style="max-width: 160px;">
                <option value="">Semua Role</option>
                <option value="admin"  {{ request('role') === 'admin'  ? 'selected' : '' }}>Admin</option>
                <option value="siswa"  {{ request('role') === 'siswa'  ? 'selected' : '' }}>Siswa</option>
            </select>
            <button class="btn btn-outline-secondary" type="submit">Filter</button>
            @if(request()->hasAny(['search', 'role']))
                <a href="{{ route('admin.user.index') }}" class="btn btn-light">
                    <i class="bi bi-x-circle me-1"></i> Reset
                </a>
            @endif
        </form>
    </div>

    <div class="card-body p-0">
        @if($users->isEmpty())
            <div class="text-center py-5 text-muted">
                <i class="bi bi-person-x display-4 opacity-50 mb-3 d-block"></i>
                <p>Belum ada data user.</p>
                <a href="{{ route('admin.user.create') }}" class="btn btn-outline-primary mt-2">Tambah User Pertama</a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-secondary small">
                        <tr>
                            <th width="5%" class="ps-4">NO</th>
                            <th>NAMA LENGKAP</th>
                            <th>USERNAME</th>
                            <th>EMAIL</th>
                            <th>ROLE</th>
                            <th>DIBUAT</th>
                            <th width="12%" class="text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td class="ps-4 text-muted">{{ $users->firstItem() + $loop->index }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center fw-bold flex-shrink-0"
                                        style="width: 38px; height: 38px; font-size: 1rem;">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{ $user->name }}</div>
                                        @if($user->id === auth()->id())
                                            <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25" style="font-size: 10px;">Anda</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td><span class="font-monospace text-secondary">{{ $user->username }}</span></td>
                            <td class="small text-muted">{{ $user->email }}</td>
                            <td>
                                @if($user->role === 'admin')
                                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25">
                                        <i class="bi bi-shield-check me-1"></i> Admin
                                    </span>
                                @else
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25">
                                        <i class="bi bi-person me-1"></i> Siswa
                                    </span>
                                @endif
                            </td>
                            <td class="small text-muted">{{ $user->created_at->format('d M Y') }}</td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.user.show', $user->id) }}" class="btn btn-info text-white" title="Detail">
                                        <i class="bi bi-person-vcard"></i>
                                    </a>
                                    <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-warning text-white" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    @if($user->id !== auth()->id())
                                        <button type="button" class="btn btn-danger"
                                            onclick="confirmDelete('{{ route('admin.user.destroy', $user->id) }}')" title="Hapus">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-danger" disabled title="Tidak bisa hapus akun sendiri">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($users->hasPages())
            <div class="card-footer bg-white py-3 border-top d-flex justify-content-end">
                {{ $users->links('pagination::bootstrap-5') }}
            </div>
            @endif
        @endif
    </div>
</div>
@endsection
