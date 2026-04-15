@extends('layouts.siswa')

@section('title', 'Beranda')
@section('page-title', 'Beranda')

@section('content')

<!-- STATS -->
<div class="row g-4 mb-4 fade-in">

    <div class="col-xl-3 col-md-6">
        <div class="card border-0 text-white h-100 stat-card" style="background: linear-gradient(135deg,#3b82f6,#2563eb);">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h2 class="fw-bold mb-0">{{ $sedangDipinjam }}</h2>
                    <small class="opacity-75">Sedang Dipinjam</small>
                </div>
                <i class="bi bi-book-half"></i>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card border-0 text-white h-100 stat-card" style="background: linear-gradient(135deg,#ef4444,#dc2626);">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h2 class="fw-bold mb-0">{{ $terlambat }}</h2>
                    <small class="opacity-75">Buku Terlambat</small>
                </div>
                <i class="bi bi-exclamation-octagon"></i>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card border-0 h-100 stat-card text-dark" style="background: linear-gradient(135deg,#facc15,#eab308);">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="fw-bold mb-0">Rp {{ number_format($dendaBelumDibayar, 0, ',', '.') }}</h5>
                    <small class="opacity-75">Denda Berjalan</small>
                </div>
                <i class="bi bi-cash-coin"></i>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card border-0 h-100 stat-card text-white" style="background: linear-gradient(135deg,#10b981,#059669);">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h2 class="fw-bold mb-0">{{ $totalPinjaman }}</h2>
                    <small class="opacity-75">Total Riwayat</small>
                </div>
                <i class="bi bi-journal-check"></i>
            </div>
        </div>
    </div>

</div>

<!-- TABLE -->
<div class="card border-0 shadow-sm rounded-4 fade-in">
    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center py-3 px-4">
        <h5 class="fw-bold mb-0">📚 Pinjaman Terbaru</h5>
        <a href="{{ route('siswa.transaksi.index') }}" class="btn btn-sm btn-primary rounded-pill px-3">
            Lihat Semua
        </a>
    </div>

    <div class="card-body p-0">

        @if($riwayatTerbaru->isEmpty())
            <div class="text-center py-5 empty-state">
                <i class="bi bi-inbox display-1 text-muted"></i>
                <h6 class="mt-3 text-muted">Belum ada riwayat peminjaman</h6>
                <a href="{{ route('siswa.buku.index') }}" class="btn btn-primary rounded-pill mt-3 px-4">
                    Cari Buku
                </a>
            </div>
        @else

        <div class="table-responsive px-3 pb-3">
            <table class="table align-middle mb-0">

                <thead>
                    <tr class="text-muted small">
                        <th class="ps-3">BUKU</th>
                        <th>TGL PINJAM</th>
                        <th>BATAS</th>
                        <th>STATUS</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($riwayatTerbaru as $p)
                    <tr>

                        <td class="ps-3">
                            <div class="fw-semibold text-dark">{{ $p->buku->judul }}</div>
                            <small class="text-muted">📖 {{ $p->buku->kategori }}</small>
                        </td>

                        <td>{{ $p->tgl_pinjam->format('d M Y') }}</td>

                        <td>
                            <span class="{{ $p->status === 'terlambat' ? 'text-danger fw-bold' : '' }}">
                                {{ $p->tgl_kembali_rencana->format('d M Y') }}
                            </span>
                        </td>

                        <td>
                            @if($p->status === 'dipinjam')
                                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">
                                    <i class="bi bi-clock"></i> Dipinjam
                                </span>
                            @elseif($p->status === 'dikembalikan')
                                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">
                                    <i class="bi bi-check2"></i> Selesai
                                </span>
                            @elseif($p->status === 'terlambat')
                                <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill">
                                    <i class="bi bi-exclamation-triangle"></i> Terlambat
                                </span>
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

<!-- STYLE -->
<style>

/* BACKGROUND */
body {
    background: #f1f5f9;
}

/* ANIMATION */
.fade-in {
    animation: fadeIn 0.6s ease;
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px);}
    to { opacity: 1; transform: translateY(0);}
}

/* STAT CARD */
.stat-card {
    border-radius: 20px;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
    position: relative;
    overflow: hidden;
}
.stat-card::after {
    content: '';
    position: absolute;
    width: 120%;
    height: 120%;
    top: -50%;
    left: -50%;
    background: rgba(255,255,255,0.1);
    transform: rotate(25deg);
}
.stat-card:hover {
    transform: translateY(-6px) scale(1.02);
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
}
.stat-card i {
    font-size: 42px;
    opacity: 0.3;
}

/* CARD */
.card {
    border-radius: 20px !important;
}

/* TABLE */
.table {
    border-collapse: separate;
    border-spacing: 0 10px;
}
.table tbody tr {
    background: white;
    border-radius: 12px;
    transition: 0.25s;
}
.table tbody tr:hover {
    transform: scale(1.01);
    box-shadow: 0 8px 20px rgba(0,0,0,0.05);
}
.table td, .table th {
    border: none !important;
    vertical-align: middle;
}

/* BADGE */
.badge {
    font-size: 12px;
    font-weight: 500;
}

/* EMPTY */
.empty-state i {
    font-size: 70px;
    opacity: 0.2;
}

/* BUTTON */
.btn-primary {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    border: none;
}
.btn-primary:hover {
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
}

</style>

@endsection