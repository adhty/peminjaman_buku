@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', '📊 Dashboard')

@section('content')
<style>
    :root {
        --primary-dark: #1e3a5f;
        --primary: #2c5282;
        --primary-light: #3182ce;
        --primary-soft: #ebf4ff;
        --secondary: #4a5568;
        --success: #15803d;
        --warning: #d97706;
        --danger: #dc2626;
    }

    /* PREMIUM STAT CARDS ATAS */
    .stat-card {
        background: white;
        border-radius: 20px;
        padding: 16px;
        border: 1px solid #eef2f6;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px -12px rgba(30, 58, 95, 0.15);
        border-color: transparent;
    }

    .stat-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;
    }

    .stat-title {
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--secondary);
    }

    .stat-value {
        font-size: 1.8rem;
        font-weight: 800;
        margin-bottom: 4px;
    }

    .stat-value.text-primary { color: var(--primary); }
    .stat-value.text-success { color: var(--success); }
    .stat-value.text-warning { color: var(--warning); }
    .stat-value.text-danger { color: var(--danger); }

    .icon-box {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    .icon-box.primary { background: var(--primary-soft); color: var(--primary); }
    .icon-box.success { background: #f0fdf4; color: var(--success); }
    .icon-box.warning { background: #fffbeb; color: var(--warning); }
    .icon-box.danger { background: #fef2f2; color: var(--danger); }

    .stat-badge {
        display: inline-block;
        padding: 2px 10px;
        border-radius: 30px;
        font-size: 9px;
        font-weight: 600;
        margin-top: 4px;
    }

    .stat-badge.primary { background: var(--primary-soft); color: var(--primary); }
    .stat-badge.success { background: #f0fdf4; color: var(--success); }
    .stat-badge.warning { background: #fffbeb; color: var(--warning); }
    .stat-badge.danger { background: #fef2f2; color: var(--danger); }

    /* MAIN CONTENT - KIRI DONUT, KANAN TABLE */
    .dashboard-row {
        display: flex;
        gap: 24px;
        flex-wrap: wrap;
    }

    /* LEFT SIDE - DONUT CHART */
    .left-donut-card {
        flex: 1;
        min-width: 350px;
        background: white;
        border-radius: 24px;
        border: 1px solid #eef2f6;
        overflow: hidden;
        transition: all 0.3s;
    }

    .left-donut-card:hover {
        box-shadow: 0 10px 25px -12px rgba(30, 58, 95, 0.1);
    }

    .donut-header {
        padding: 18px 24px;
        border-bottom: 1px solid #eef2f6;
    }

    .donut-header h6 {
        font-size: 15px;
        font-weight: 700;
        color: var(--primary-dark);
        margin: 0;
    }

    .donut-body {
        padding: 24px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .donut-chart-container {
        position: relative;
        width: 260px;
        height: 260px;
        margin: 0 auto;
    }

    .donut-center-text {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
    }

    .donut-total {
        font-size: 36px;
        font-weight: 800;
        color: var(--primary-dark);
    }

    .donut-label {
        font-size: 11px;
        color: var(--secondary);
        margin-top: 4px;
    }

    .donut-legend {
        margin-top: 24px;
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .legend-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 8px 12px;
        background: #f8fafc;
        border-radius: 12px;
        transition: all 0.2s;
    }

    .legend-item:hover {
        background: var(--primary-soft);
        transform: translateX(5px);
    }

    .legend-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .legend-color {
        width: 14px;
        height: 14px;
        border-radius: 4px;
    }

    .legend-color.dipinjam { background: var(--primary); }
    .legend-color.terlambat { background: var(--danger); }
    .legend-color.selesai { background: var(--success); }

    .legend-text {
        font-size: 13px;
        font-weight: 500;
        color: var(--secondary);
    }

    .legend-value {
        font-size: 16px;
        font-weight: 700;
        color: var(--primary-dark);
    }

    .legend-percent {
        font-size: 12px;
        color: #94a3b8;
        margin-left: 8px;
        font-weight: 500;
    }

    /* RIGHT SIDE - TABLE */
    .right-table-card {
        flex: 1.2;
        min-width: 400px;
        background: white;
        border-radius: 24px;
        border: 1px solid #eef2f6;
        overflow: hidden;
        transition: all 0.3s;
        display: flex;
        flex-direction: column;
    }

    .right-table-card:hover {
        box-shadow: 0 10px 25px -12px rgba(30, 58, 95, 0.1);
    }

    .table-header-custom {
        padding: 18px 24px;
        border-bottom: 1px solid #eef2f6;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }

    .table-header-custom h6 {
        font-size: 15px;
        font-weight: 700;
        color: var(--primary-dark);
        margin: 0;
    }

    .btn-view-all {
        background: transparent;
        border: 1.5px solid var(--primary);
        color: var(--primary);
        padding: 6px 18px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 600;
        transition: all 0.2s;
    }

    .btn-view-all:hover {
        background: var(--primary);
        color: white;
        transform: translateY(-2px);
    }

    .compact-table {
        width: 100%;
    }

    .compact-table thead th {
        background: #f8fafc;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--secondary);
        padding: 12px 16px;
        border-bottom: 2px solid #eef2f6;
    }

    .compact-table tbody td {
        padding: 12px 16px;
        font-size: 12px;
        border-bottom: 1px solid #f1f5f9;
    }

    .compact-table tbody tr {
        transition: all 0.2s;
        cursor: pointer;
    }

    .compact-table tbody tr:hover {
        background: var(--primary-soft);
    }

    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 10px;
        border-radius: 30px;
        font-size: 10px;
        font-weight: 600;
    }

    .badge-borrowed { background: var(--primary-soft); color: var(--primary); }
    .badge-returned { background: #f0fdf4; color: var(--success); }
    .badge-late { background: #fef2f2; color: var(--danger); }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
    }

    .empty-icon {
        width: 60px;
        height: 60px;
        background: var(--primary-soft);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
    }

    .empty-icon i {
        font-size: 24px;
        color: var(--primary);
        opacity: 0.5;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-in {
        animation: fadeInUp 0.4s ease forwards;
    }

    .delay-1 { animation-delay: 0.05s; }
    .delay-2 { animation-delay: 0.1s; }
    .delay-3 { animation-delay: 0.15s; }
    .delay-4 { animation-delay: 0.2s; }
</style>

<!-- STATISTICS CARDS ATAS -->
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6 animate-in">
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-title">TOTAL BUKU</span>
                <div class="icon-box primary">
                    <i class="fas fa-book"></i>
                </div>
            </div>
            <div class="stat-value text-primary">
                {{ number_format($totalBuku ?? 0) }}
            </div>
            <span class="stat-badge primary">
                <i class="fas fa-database me-1"></i> Koleksi
            </span>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 animate-in delay-1">
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-title">TOTAL ANGGOTA</span>
                <div class="icon-box success">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <div class="stat-value text-success">
                {{ number_format($totalAnggota ?? 0) }}
            </div>
            <span class="stat-badge success">
                <i class="fas fa-user-check me-1"></i> Terdaftar
            </span>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 animate-in delay-2">
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-title">SEDANG DIPINJAM</span>
                <div class="icon-box warning">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
            <div class="stat-value text-warning">
                {{ number_format($dipinjam ?? 0) }}
            </div>
            <span class="stat-badge warning">
                <i class="fas fa-book-reader me-1"></i> Aktif
            </span>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 animate-in delay-3">
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-title">TERLAMBAT</span>
                <div class="icon-box danger">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
            </div>
            <div class="stat-value text-danger">
                {{ number_format($terlambat ?? 0) }}
            </div>
            <span class="stat-badge danger">
                <i class="fas fa-bell me-1"></i> Perhatian
            </span>
        </div>
    </div>
</div>

<!-- MAIN CONTENT: KIRI DONUT CHART | KANAN TABLE -->
<div class="dashboard-row animate-in delay-4">
    <!-- LEFT SIDE - DONUT CHART STATISTIK -->
    <div class="left-donut-card">
        <div class="donut-header">
            <h6>
                <i class="fas fa-chart-pie me-2" style="color: var(--primary);"></i>
                Statistik Peminjaman
            </h6>
        </div>
        <div class="donut-body">
            <div class="donut-chart-container">
                <canvas id="donutChart" width="260" height="260"></canvas>
                <div class="donut-center-text">
                    @php
                        $totalSemua = ($dipinjam ?? 0) + ($terlambat ?? 0) + ($dikembalikan ?? 0);
                    @endphp
                    <div class="donut-total">{{ $totalSemua }}</div>
                    <div class="donut-label">Total Transaksi</div>
                </div>
            </div>
            <div class="donut-legend">
                @php
                    $totalAll = ($dipinjam ?? 0) + ($terlambat ?? 0) + ($dikembalikan ?? 0);
                    $persenDipinjam = $totalAll > 0 ? round(($dipinjam ?? 0) / $totalAll * 100) : 0;
                    $persenTerlambat = $totalAll > 0 ? round(($terlambat ?? 0) / $totalAll * 100) : 0;
                    $persenDikembalikan = $totalAll > 0 ? round(($dikembalikan ?? 0) / $totalAll * 100) : 0;
                @endphp
                <div class="legend-item">
                    <div class="legend-left">
                        <div class="legend-color dipinjam"></div>
                        <span class="legend-text">Sedang Dipinjam</span>
                    </div>
                    <div>
                        <span class="legend-value">{{ $dipinjam ?? 0 }}</span>
                        <span class="legend-percent">({{ $persenDipinjam }}%)</span>
                    </div>
                </div>
                <div class="legend-item">
                    <div class="legend-left">
                        <div class="legend-color terlambat"></div>
                        <span class="legend-text">Terlambat</span>
                    </div>
                    <div>
                        <span class="legend-value">{{ $terlambat ?? 0 }}</span>
                        <span class="legend-percent">({{ $persenTerlambat }}%)</span>
                    </div>
                </div>
                <div class="legend-item">
                    <div class="legend-left">
                        <div class="legend-color selesai"></div>
                        <span class="legend-text">Selesai</span>
                    </div>
                    <div>
                        <span class="legend-value">{{ $dikembalikan ?? 0 }}</span>
                        <span class="legend-percent">({{ $persenDikembalikan }}%)</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- RIGHT SIDE - TABLE PEMINJAMAN TERBARU -->
    <div class="right-table-card">
        <div class="table-header-custom">
            <h6>
                <i class="fas fa-history me-2" style="color: var(--primary);"></i>
                Peminjaman Terbaru
            </h6>
            <a href="{{ route('admin.transaksi.index') }}" class="btn-view-all">
                <i class="fas fa-arrow-right me-1"></i> Lihat Semua
            </a>
        </div>

        <div class="card-body p-0" style="flex: 1;">
            @if($peminjamanTerbaru->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <h6 class="fw-semibold mb-2" style="color: var(--primary-dark);">Belum Ada Data</h6>
                    <p class="text-muted small mb-0">Belum ada peminjaman buku yang tercatat.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="compact-table">
                        <thead>
                            <tr>
                                <th>Peminjam</th>
                                <th>Buku</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($peminjamanTerbaru as $p)
                            <tr>
                                <td>
                                    <div class="fw-semibold" style="color: var(--primary-dark);">{{ $p->anggota->nama ?? '-' }}</div>
                                    <div class="small text-muted">NIS: {{ $p->anggota->nis ?? '-' }}</div>
                                </td>
                                <td>
                                    <div class="fw-medium">{{ Str::limit($p->buku->judul ?? '-', 30) }}</div>
                                    <div class="small text-muted">{{ $p->buku->kode_buku ?? '-' }}</div>
                                </td>
                                <td>{{ optional($p->tgl_pinjam)->format('d/m/Y') }}</td>
                                <td>
                                    @if($p->status === 'dipinjam')
                                        <span class="badge-status badge-borrowed">
                                            <i class="fas fa-book-reader"></i> Dipinjam
                                        </span>
                                    @elseif($p->status === 'dikembalikan')
                                        <span class="badge-status badge-returned">
                                            <i class="fas fa-check-double"></i> Selesai
                                        </span>
                                    @else
                                        <span class="badge-status badge-late">
                                            <i class="fas fa-exclamation-triangle"></i> Terlambat
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
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// DATA DARI PHP
const dipinjam = {{ $dipinjam ?? 0 }};
const terlambat = {{ $terlambat ?? 0 }};
const dikembalikan = {{ $dikembalikan ?? 0 }};
const totalAll = dipinjam + terlambat + dikembalikan;

// DONUT CHART
const ctx = document.getElementById('donutChart').getContext('2d');
new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Sedang Dipinjam', 'Terlambat', 'Selesai'],
        datasets: [{
            data: [dipinjam, terlambat, dikembalikan],
            backgroundColor: ['#2c5282', '#dc2626', '#15803d'],
            borderWidth: 0,
            cutout: '65%',
            borderRadius: 10,
            spacing: 8,
            hoverOffset: 15
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: '#1e293b',
                titleColor: '#ffffff',
                bodyColor: '#cbd5e1',
                padding: 10,
                cornerRadius: 8,
                callbacks: {
                    label: function(context) {
                        const label = context.label || '';
                        const value = context.raw || 0;
                        const percent = totalAll > 0 ? Math.round((value / totalAll) * 100) : 0;
                        return `${label}: ${value} (${percent}%)`;
                    }
                }
            }
        },
        cutout: '65%',
        layout: {
            padding: 10
        }
    }
});
</script>
@endpush