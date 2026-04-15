@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

<!-- STATS -->
<div class="row g-4 mb-4">

    <!-- Total Buku -->
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-1">Total Buku</h6>
                        <h2 class="fw-bold mb-0">{{ number_format($totalBuku) }}</h2>
                    </div>
                    <i class="bi bi-book stat-icon"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Anggota -->
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-1">Total Anggota</h6>
                        <h2 class="fw-bold mb-0">{{ number_format($totalAnggota) }}</h2>
                    </div>
                    <i class="bi bi-people stat-icon"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Dipinjam -->
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card bg-warning text-dark">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="opacity-75 mb-1">Sedang Dipinjam</h6>
                        <h2 class="fw-bold mb-0">{{ number_format($dipinjam) }}</h2>
                    </div>
                    <i class="bi bi-clock-history stat-icon text-dark"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Terlambat -->
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card bg-danger text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-1">Terlambat</h6>
                        <h2 class="fw-bold mb-0">{{ number_format($terlambat) }}</h2>
                    </div>
                    <i class="bi bi-exclamation-triangle stat-icon"></i>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- 🔥 GRAFIK MINI -->
<div class="card border-0 shadow-sm rounded-4 mb-4" style="max-height: 260px;">
    <div class="card-body py-3">
        <h6 class="fw-bold mb-2">Statistik Peminjaman</h6>
        <canvas id="chartPeminjaman" height="60"></canvas>
    </div>
</div>

<!-- TABLE -->
<div class="card border-0 shadow-sm rounded-4 overflow-hidden">

    <div class="card-header bg-white d-flex justify-content-between align-items-center px-4 py-3 border-bottom">
        <h5 class="fw-bold mb-0">Peminjaman Terbaru</h5>
        <a href="{{ route('admin.transaksi.index') }}" class="btn btn-sm btn-primary px-3 rounded-pill">
            Lihat Semua
        </a>
    </div>

    <div class="card-body p-0">

        @if($peminjamanTerbaru->isEmpty())
            <div class="text-center py-5 text-muted">
                <i class="bi bi-inbox display-5 opacity-50"></i>
                <p class="mt-3 mb-0">Belum ada transaksi terbaru.</p>
            </div>
        @else

        <div class="table-responsive">
            <table class="table align-middle mb-0 custom-table">

                <thead>
                    <tr>
                        <th class="ps-4">Peminjam</th>
                        <th>Buku</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($peminjamanTerbaru as $p)
                    <tr>

                        <td class="ps-4">
                            <div class="fw-semibold">{{ $p->anggota->nama }}</div>
                            <div class="small text-muted">NIS: {{ $p->anggota->nis }}</div>
                        </td>

                        <td class="fw-medium">{{ $p->buku->judul }}</td>

                        <td class="text-muted">
                            {{ $p->tgl_pinjam->format('d M Y') }}
                        </td>

                        <td>
                            @if($p->status === 'dipinjam')
                                <span class="badge badge-soft-primary">
                                    <i class="bi bi-clock me-1"></i> Dipinjam
                                </span>
                            @elseif($p->status === 'dikembalikan')
                                <span class="badge badge-soft-success">
                                    <i class="bi bi-check2 me-1"></i> Selesai
                                </span>
                            @elseif($p->status === 'terlambat')
                                <span class="badge badge-soft-danger">
                                    <i class="bi bi-exclamation-triangle me-1"></i> Terlambat
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

@endsection


@push('styles')
<style>
.stat-card {
    border: none;
    border-radius: 16px;
    padding: 10px;
    transition: 0.3s;
}
.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

.stat-icon {
    font-size: 2.5rem;
    opacity: 0.3;
}

.custom-table thead {
    background: #f8fafc;
    font-size: 0.8rem;
    text-transform: uppercase;
    color: #64748b;
}

.custom-table tbody tr:hover {
    background: #f1f5f9;
}

.badge-soft-primary {
    background: rgba(59,130,246,0.1);
    color: #2563eb;
    padding: 6px 10px;
    border-radius: 999px;
}

.badge-soft-success {
    background: rgba(34,197,94,0.1);
    color: #16a34a;
    padding: 6px 10px;
    border-radius: 999px;
}

.badge-soft-danger {
    background: rgba(239,68,68,0.1);
    color: #dc2626;
    padding: 6px 10px;
    border-radius: 999px;
}
</style>
@endpush


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('chartPeminjaman').getContext('2d');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: @json($bulan ?? []),
        datasets: [{
            data: @json($total ?? []),
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false // 🔥 biar minimalis
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    precision: 0,
                    font: { size: 10 }
                }
            },
            x: {
                ticks: {
                    font: { size: 10 }
                }
            }
        }
    }
});
</script>
@endpush