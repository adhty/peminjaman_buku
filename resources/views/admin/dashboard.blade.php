@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="row g-3 mb-4">
    <!-- Total Buku -->
    <div class="col-xl-3 col-md-6">
        <div class="card h-100 bg-primary text-white text-center p-3">
            <div class="card-body">
                <i class="bi bi-book display-4 mb-2 opacity-50"></i>
                <h2 class="fw-bold text-white mb-0">{{ number_format($totalBuku) }}</h2>
                <span class="text-white-50">Total Buku Katalog</span>
            </div>
        </div>
    </div>

    <!-- Total Anggota -->
    <div class="col-xl-3 col-md-6">
        <div class="card h-100 bg-success text-white text-center p-3">
            <div class="card-body">
                <i class="bi bi-people display-4 mb-2 opacity-50"></i>
                <h2 class="fw-bold text-white mb-0">{{ number_format($totalAnggota) }}</h2>
                <span class="text-white-50">Total Anggota</span>
            </div>
        </div>
    </div>

    <!-- Peminjaman Aktif -->
    <div class="col-xl-3 col-md-6">
        <div class="card h-100 bg-warning text-dark text-center p-3">
            <div class="card-body">
                <i class="bi bi-clock-history display-4 mb-2 opacity-50"></i>
                <h2 class="fw-bold text-dark mb-0">{{ number_format($dipinjam) }}</h2>
                <span class="text-dark-50 opacity-75">Sedang Dipinjam</span>
            </div>
        </div>
    </div>

    <!-- Pengembalian Terlambat -->
    <div class="col-xl-3 col-md-6">
        <div class="card h-100 bg-danger text-white text-center p-3">
            <div class="card-body">
                <i class="bi bi-exclamation-triangle display-4 mb-2 opacity-50"></i>
                <h2 class="fw-bold text-white mb-0">{{ number_format($terlambat) }}</h2>
                <span class="text-white-50">Buku Terlambat</span>
            </div>
        </div>
    </div>
</div>

<div class="card p-0">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="m-0 fw-bold">Peminjaman Terbaru</h5>
        <a href="{{ route('admin.transaksi.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
    </div>
    <div class="card-body p-0">
        @if($peminjamanTerbaru->isEmpty())
            <div class="text-center py-5 text-muted">
                <i class="bi bi-inbox fs-1"></i>
                <p class="mt-2">Belum ada transaksi terbaru.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-secondary">
                        <tr>
                            <th class="ps-4">PEMINJAM</th>
                            <th>BUKU DIPINJAM</th>
                            <th>TGL PINJAM</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($peminjamanTerbaru as $p)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold">{{ $p->anggota->nama }}</div>
                                    <div class="small text-muted">NIS: {{ $p->anggota->nis }}</div>
                                </td>
                                <td>{{ $p->buku->judul }}</td>
                                <td>{{ $p->tgl_pinjam->format('d M Y') }}</td>
                                <td>
                                    @if($p->status === 'dipinjam')
                                        <span class="badge bg-primary px-2 py-1"><i class="bi bi-clock"></i> Dipinjam</span>
                                    @elseif($p->status === 'dikembalikan')
                                        <span class="badge bg-success px-2 py-1"><i class="bi bi-check2"></i> Selesai</span>
                                    @elseif($p->status === 'terlambat')
                                        <span class="badge bg-danger px-2 py-1"><i class="bi bi-exclamation-triangle"></i> Terlambat</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
