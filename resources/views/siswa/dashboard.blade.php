@extends('layouts.siswa')

@section('title', 'Beranda')
@section('page-title', 'Beranda')

@section('content')
<div class="row g-4 mb-4">
    <!-- Sedang Dipinjam -->
    <div class="col-xl-3 col-md-6">
        <div class="card h-100 border-0 bg-primary text-white text-center p-3" style="box-shadow: 0 10px 15px -3px rgba(5, 150, 105, 0.3);">
            <div class="card-body">
                <i class="bi bi-book-half display-4 mb-2 opacity-75"></i>
                <h2 class="fw-bold text-white mb-0">{{ $sedangDipinjam }}</h2>
                <span class="text-white-50">Sedang Dipinjam</span>
            </div>
        </div>
    </div>

    <!-- Terlambat -->
    <div class="col-xl-3 col-md-6">
        <div class="card h-100 border-0 bg-danger text-white text-center p-3" style="box-shadow: 0 10px 15px -3px rgba(220, 38, 38, 0.3);">
            <div class="card-body">
                <i class="bi bi-exclamation-octagon display-4 mb-2 opacity-75"></i>
                <h2 class="fw-bold text-white mb-0">{{ $terlambat }}</h2>
                <span class="text-white-50">Buku Terlambat</span>
            </div>
        </div>
    </div>

    <!-- Denda -->
    <div class="col-xl-3 col-md-6">
        <div class="card h-100 border-0 bg-warning text-dark text-center p-3" style="box-shadow: 0 10px 15px -3px rgba(217, 119, 6, 0.2);">
            <div class="card-body">
                <i class="bi bi-cash-coin display-4 mb-2 opacity-50"></i>
                <h3 class="fw-bold text-dark mb-0 mt-2">Rp {{ number_format($dendaBelumDibayar, 0, ',', '.') }}</h3>
                <span class="text-dark-50 opacity-75">Denda Berjalan</span>
            </div>
        </div>
    </div>

    <!-- Total Pinjaman -->
    <div class="col-xl-3 col-md-6">
        <div class="card h-100 border-0 text-center p-3" style="background-color: #d1fae5; color: #065f46;">
            <div class="card-body">
                <i class="bi bi-journal-check display-4 mb-2 opacity-50"></i>
                <h2 class="fw-bold mb-0">{{ $totalPinjaman }}</h2>
                <span class="opacity-75">Total Riwayat Pinjam</span>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="m-0 fw-bold" style="color: var(--primary);">Pinjaman Terbaru Anda</h5>
                <a href="{{ route('siswa.transaksi.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                @if($riwayatTerbaru->isEmpty())
                    <div class="text-center py-5">
                        <i class="bi bi-inbox text-muted display-4 opacity-25"></i>
                        <p class="text-muted mt-3 mb-0">Belum ada riwayat peminjaman.</p>
                        <a href="{{ route('siswa.buku.index') }}" class="btn btn-primary mt-3">Mulai Cari Buku</a>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light text-secondary small">
                                <tr>
                                    <th class="ps-4">JUDUL BUKU</th>
                                    <th>TANGGAL PINJAM</th>
                                    <th>BATAS KEMBALI</th>
                                    <th>STATUS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($riwayatTerbaru as $p)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bold text-dark">{{ $p->buku->judul }}</div>
                                            <small class="text-muted">{{ $p->buku->kategori }}</small>
                                        </td>
                                        <td>{{ $p->tgl_pinjam->format('d M Y') }}</td>
                                        <td>
                                            <span class="{{ $p->status === 'terlambat' ? 'text-danger fw-bold' : '' }}">
                                                {{ $p->tgl_kembali_rencana->format('d M Y') }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($p->status === 'dipinjam')
                                                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-2 py-1"><i class="bi bi-clock"></i> Dipinjam</span>
                                            @elseif($p->status === 'dikembalikan')
                                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1"><i class="bi bi-check2"></i> Selesai</span>
                                            @elseif($p->status === 'terlambat')
                                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-1"><i class="bi bi-exclamation-triangle"></i> Terlambat</span>
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
    </div>
</div>
@endsection
