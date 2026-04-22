@extends('layouts.siswa')

@section('title', 'Beranda')
@section('page-title', '🏠 Beranda')

@section('content')
<style>
    :root {
        --primary-dark: #1e3a5f;
        --primary: #2c5282;
        --primary-light: #3182ce;
        --primary-soft: #ebf4ff;
        --secondary: #4a5568;
        --gray-bg: #f8fafc;
    }

    /* Header Welcome Section */
    .welcome-section {
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
        border-radius: 24px;
        padding: 32px;
        margin-bottom: 32px;
        position: relative;
        overflow: hidden;
    }

    .welcome-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 300px;
        height: 300px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }

    .welcome-section::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -10%;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,0.03);
        border-radius: 50%;
    }

    .welcome-greeting {
        color: white;
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .welcome-message {
        color: rgba(255,255,255,0.8);
        font-size: 14px;
    }

    .welcome-date {
        color: rgba(255,255,255,0.7);
        font-size: 13px;
        margin-top: 8px;
    }

    /* Stat Cards */
    .stat-card {
        background: white;
        border-radius: 20px;
        padding: 20px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid #eef2f6;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary) 0%, var(--primary-light) 100%);
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }

    .stat-card:hover::before {
        transform: scaleX(1);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px -12px rgba(30, 58, 95, 0.15);
        border-color: transparent;
    }

    .stat-title {
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--secondary);
        margin-bottom: 8px;
    }

    .stat-value {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .stat-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 12px;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 600;
    }

    .icon-box {
        width: 52px;
        height: 52px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }

    .stat-card:hover .icon-box {
        transform: scale(1.05);
    }

    .icon-box i {
        font-size: 24px;
    }

    /* Soft Colors */
    .bg-primary-soft { background: var(--primary-soft); color: var(--primary); }
    .bg-danger-soft { background: #fef2f2; color: #dc2626; }
    .bg-warning-soft { background: #fffbeb; color: #d97706; }
    .bg-success-soft { background: #f0fdf4; color: #15803d; }

    .text-primary-custom { color: var(--primary); }
    .text-danger-custom { color: #dc2626; }
    .text-warning-custom { color: #d97706; }
    .text-success-custom { color: #15803d; }

    /* Table Card */
    .table-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #eef2f6;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .table-card:hover {
        box-shadow: 0 10px 25px -12px rgba(30, 58, 95, 0.1);
    }

    .table-card .card-header {
        background: white;
        border-bottom: 2px solid #f1f5f9;
        padding: 18px 24px;
    }

    .table-card .card-header h6 {
        font-size: 16px;
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
        box-shadow: 0 4px 10px rgba(44, 82, 130, 0.2);
    }

    /* Table Styles */
    .transaction-table thead th {
        background: var(--gray-bg);
        font-size: 12px;
        font-weight: 600;
        color: var(--secondary);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 14px 16px;
        border-bottom: 2px solid #e2e8f0;
    }

    .transaction-table tbody td {
        padding: 16px;
        font-size: 13px;
        border-bottom: 1px solid #f1f5f9;
    }

    .transaction-row {
        transition: all 0.2s ease;
    }

    .transaction-row:hover {
        background: var(--primary-soft);
    }

    .book-title-small {
        font-weight: 700;
        color: var(--primary-dark);
        margin-bottom: 4px;
        font-size: 14px;
    }

    .book-category {
        font-size: 11px;
        color: var(--secondary);
    }

    /* Badge Styles */
    .badge-custom {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 14px;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 600;
    }

    .badge-borrowed { background: var(--primary-soft); color: var(--primary); }
    .badge-returned { background: #f0fdf4; color: #15803d; }
    .badge-late { background: #fef2f2; color: #dc2626; }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        background: var(--primary-soft);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
    }

    .empty-icon i {
        font-size: 32px;
        color: var(--primary);
        opacity: 0.5;
    }

    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-in {
        animation: fadeInUp 0.5s ease forwards;
    }

    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }
    .delay-3 { animation-delay: 0.3s; }
    .delay-4 { animation-delay: 0.4s; }
</style>

<!-- WELCOME SECTION -->
<div class="welcome-section animate-in">
    <div class="row align-items-center">
        <div class="col-lg-8">
            <div class="welcome-greeting">
                Selamat Datang, {{ auth()->user()->name }}! 👋
            </div>
            <div class="welcome-message">
                Teruslah membaca dan tingkatkan pengetahuanmu melalui koleksi buku yang tersedia.
            </div>
            <div class="welcome-date">
                <i class="fas fa-calendar-alt me-2"></i> {{ now()->isoFormat('dddd, D MMMM Y') }}
            </div>
        </div>
        <div class="col-lg-4 text-end d-none d-lg-block">
            <i class="fas fa-book-reader" style="font-size: 80px; color: rgba(255,255,255,0.15);"></i>
        </div>
    </div>
</div>

<!-- STATISTICS CARDS -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6 animate-in delay-1">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-title">
                        <i class="fas fa-book-open me-1"></i> Sedang Dipinjam
                    </div>
                    <div class="stat-value text-primary-custom">{{ $sedangDipinjam }}</div>
                    <span class="stat-badge bg-primary-soft">
                        <i class="fas fa-clock me-1"></i> Aktif
                    </span>
                </div>
                <div class="icon-box bg-primary-soft">
                    <i class="fas fa-book"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 animate-in delay-2">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-title">
                        <i class="fas fa-exclamation-triangle me-1"></i> Terlambat
                    </div>
                    <div class="stat-value text-danger-custom">{{ $terlambat }}</div>
                    <span class="stat-badge bg-danger-soft">
                        <i class="fas fa-bell me-1"></i> Perhatian
                    </span>
                </div>
                <div class="icon-box bg-danger-soft">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 animate-in delay-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-title">
                        <i class="fas fa-coins me-1"></i> Denda Berjalan
                    </div>
                    <div class="stat-value text-warning-custom">
                        Rp {{ number_format($dendaBelumDibayar, 0, ',', '.') }}
                    </div>
                    <span class="stat-badge bg-warning-soft">
                        <i class="fas fa-hourglass-half me-1"></i> Belum Bayar
                    </span>
                </div>
                <div class="icon-box bg-warning-soft">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 animate-in delay-4">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-title">
                        <i class="fas fa-history me-1"></i> Total Riwayat
                    </div>
                    <div class="stat-value text-success-custom">{{ $totalPinjaman }}</div>
                    <span class="stat-badge bg-success-soft">
                        <i class="fas fa-check-circle me-1"></i> Riwayat
                    </span>
                </div>
                <div class="icon-box bg-success-soft">
                    <i class="fas fa-journal-whills"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- RECENT TRANSACTIONS TABLE -->
<div class="table-card animate-in" style="animation-delay: 0.5s;">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-3">
        <h6>
            <i class="fas fa-clock me-2" style="color: var(--primary);"></i>
            Pinjaman Terbaru
        </h6>
        <a href="{{ route('siswa.transaksi.index') }}" class="btn-view-all">
            <i class="fas fa-arrow-right me-1"></i> Lihat Semua
        </a>
    </div>

    <div class="card-body p-0">
        @if($riwayatTerbaru->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-book-open"></i>
                </div>
                <h6 class="fw-semibold mb-2" style="color: var(--primary-dark);">Belum Ada Riwayat</h6>
                <p class="text-muted small mb-0">Anda belum memiliki riwayat peminjaman buku.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table transaction-table mb-0">
                    <thead>
                        <tr>
                            <th><i class="fas fa-book me-1"></i> Buku</th>
                            <th><i class="fas fa-calendar-alt me-1"></i> Tgl Pinjam</th>
                            <th><i class="fas fa-hourglass-end me-1"></i> Batas Kembali</th>
                            <th><i class="fas fa-tag me-1"></i> Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($riwayatTerbaru as $p)
                        <tr class="transaction-row">
                            <td>
                                <div class="book-title-small">{{ $p->buku->judul }}</div>
                                <div class="book-category">
                                    <i class="fas fa-folder-open me-1"></i> {{ $p->buku->kategori }}
                                </div>
                            </td>
                            <td>
                                <span class="fw-medium">{{ $p->tgl_pinjam->format('d M Y') }}</span>
                            </td>
                            <td class="{{ $p->status === 'terlambat' ? 'text-danger fw-semibold' : '' }}">
                                {{ $p->tgl_kembali_rencana->format('d M Y') }}
                                @if($p->status === 'terlambat')
                                    @php $hariTelat = $p->tgl_kembali_rencana->diffInDays(today()); @endphp
                                    <div class="small text-danger mt-1">
                                        <i class="fas fa-exclamation-circle me-1"></i> Telat {{ $hariTelat }} hari
                                    </div>
                                @endif
                            </td>
                            <td>
                                @if($p->status === 'dipinjam')
                                    <span class="badge-custom badge-borrowed">
                                        <i class="fas fa-book-reader"></i> Dipinjam
                                    </span>
                                @elseif($p->status === 'dikembalikan')
                                    <span class="badge-custom badge-returned">
                                        <i class="fas fa-check-double"></i> Selesai
                                    </span>
                                @elseif($p->status === 'terlambat')
                                    <span class="badge-custom badge-late">
                                        <i class="fas fa-exclamation-triangle"></i> Terlambat
                                    </span>
                                @else
                                    <span class="badge-custom" style="background: #f1f5f9; color: #64748b;">
                                        <i class="fas fa-clock"></i> {{ ucfirst($p->status) }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($riwayatTerbaru->count() > 0)
                <div class="card-footer bg-white border-0 py-3 text-center">
                    <a href="{{ route('siswa.transaksi.index') }}" class="small text-decoration-none" style="color: var(--primary);">
                        <i class="fas fa-chevron-right me-1"></i> Lihat semua transaksi
                    </a>
                </div>
            @endif
        @endif
    </div>
</div>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<script>
    // Animasi tambahan saat load
    document.addEventListener('DOMContentLoaded', function() {
        // Efek smooth untuk semua card
        const cards = document.querySelectorAll('.stat-card');
        cards.forEach((card, index) => {
            card.style.animationDelay = `${0.1 + (index * 0.05)}s`;
        });
    });
</script>

@endsection