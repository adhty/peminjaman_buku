@extends('layouts.admin')

@section('title', 'Pengembalian Buku')
@section('page-title', '📚 Pengembalian Buku')

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

    /* Header Section */
    .header-section {
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
        border-radius: 20px;
        padding: 20px 28px;
        margin-bottom: 28px;
        position: relative;
        overflow: hidden;
    }

    .header-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 250px;
        height: 250px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }

    .header-section h2 {
        color: white;
        font-size: 1.4rem;
        font-weight: 700;
        margin-bottom: 4px;
    }

    .header-section p {
        color: rgba(255,255,255,0.75);
        font-size: 0.8rem;
        margin: 0;
    }

    /* Stat Cards */
    .stat-card {
        background: white;
        border-radius: 20px;
        padding: 0;
        overflow: hidden;
        transition: all 0.3s;
        border: 1px solid #eef2f6;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px -12px rgba(30, 58, 95, 0.15);
    }

    .stat-card-inner {
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .stat-icon {
        width: 55px;
        height: 55px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .stat-icon.primary { background: var(--primary-soft); color: var(--primary); }
    .stat-icon.danger { background: #fef2f2; color: var(--danger); }
    .stat-icon.success { background: #f0fdf4; color: var(--success); }

    .stat-icon i {
        font-size: 24px;
    }

    .stat-info .stat-value {
        font-size: 28px;
        font-weight: 800;
        line-height: 1.2;
    }

    .stat-info .stat-label {
        font-size: 12px;
        color: var(--secondary);
        font-weight: 500;
    }

    /* Buttons */
    .btn-excel {
        background: linear-gradient(135deg, #15803d 0%, #166534 100%);
        border: none;
        padding: 8px 20px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 13px;
        color: white;
        transition: all 0.2s;
    }

    .btn-excel:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(21, 128, 61, 0.3);
        color: white;
    }

    .btn-pdf {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        border: none;
        padding: 8px 20px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 13px;
        color: white;
        transition: all 0.2s;
    }

    .btn-pdf:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
        color: white;
    }

    /* TOMBOL PUTIH - OUTLINE (UNTUK HEADER GRADIENT) */
    .btn-white-outline {
        background: transparent;
        border: 1.5px solid white;
        color: white;
        padding: 8px 20px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
    }

    .btn-white-outline:hover {
        background: white;
        color: var(--primary);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        text-decoration: none;
    }

    .btn-white-outline i {
        font-size: 13px;
    }

    /* Table Card */
    .table-card {
        background: white;
        border-radius: 24px;
        border: 1px solid #eef2f6;
        overflow: hidden;
    }

    .table-header {
        padding: 18px 24px;
        border-bottom: 1px solid #eef2f6;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        background: white;
    }

    .table-header h6 {
        font-size: 15px;
        font-weight: 700;
        color: var(--primary-dark);
        margin: 0;
    }

    .search-input {
        background: #f8fafc;
        border: 1px solid #eef2f6;
        border-radius: 12px;
        padding: 8px 16px;
        font-size: 13px;
        width: 250px;
        transition: all 0.2s;
    }

    .search-input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(44, 82, 130, 0.1);
    }

    .admin-table {
        width: 100%;
    }

    .admin-table thead th {
        background: #f8fafc;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--secondary);
        padding: 14px 16px;
        border-bottom: 2px solid #eef2f6;
    }

    .admin-table tbody td {
        padding: 14px 16px;
        font-size: 13px;
        border-bottom: 1px solid #f1f5f9;
    }

    .admin-table tbody tr {
        transition: all 0.2s;
    }

    .admin-table tbody tr:hover {
        background: var(--primary-soft);
    }

    .admin-table tbody tr.table-danger-row {
        background: #fef2f2;
    }

    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 12px;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 600;
    }

    .badge-active { background: var(--primary-soft); color: var(--primary); }
    .badge-late { background: #fef2f2; color: var(--danger); }
    .badge-success { background: #f0fdf4; color: var(--success); }

    .btn-return {
        background: linear-gradient(135deg, var(--success) 0%, #166534 100%);
        border: none;
        padding: 6px 16px;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 600;
        color: white;
        transition: all 0.2s;
    }

    .btn-return:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(21, 128, 61, 0.3);
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        background: #f0fdf4;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
    }

    .empty-icon i {
        font-size: 32px;
        color: var(--success);
        opacity: 0.5;
    }

    /* Pagination */
    .pagination-custom .page-link {
        border-radius: 10px;
        margin: 0 4px;
        border: 1px solid #e2e8f0;
        color: var(--secondary);
        font-size: 13px;
        padding: 8px 14px;
    }

    .pagination-custom .page-item.active .page-link {
        background: var(--primary);
        border-color: var(--primary);
        color: white;
    }

    /* Modal */
    .modal-premium .modal-content {
        border-radius: 24px;
        border: none;
        overflow: hidden;
    }

    .modal-premium .modal-header {
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
        padding: 20px 24px;
        border: none;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-in {
        animation: fadeInUp 0.4s ease forwards;
    }
</style>

<!-- HEADER SECTION -->
<div class="header-section animate-in">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h2>
                Pengembalian Buku
            </h2>
            <p>Proses pengembalian buku yang sedang dipinjam oleh anggota</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.pengembalian.export', ['type' => 'excel']) }}" class="btn-excel">
                <i class="fas fa-file-excel me-1"></i> Excel
            </a>
            <a href="{{ route('admin.pengembalian.export', ['type' => 'pdf']) }}" class="btn-pdf">
                <i class="fas fa-file-pdf me-1"></i> PDF
            </a>
            <a href="{{ route('admin.transaksi.index') }}" class="btn-white-outline">
                <i class="fas fa-exchange-alt me-1"></i> Lihat Semua Transaksi
            </a>
        </div>
    </div>
</div>

<!-- STATISTICS CARDS -->
<div class="row g-4 mb-4">

    <div class="col-6 col-lg-3 animate-in" style="animation-delay: 0.05s;">
        <div class="stat-card">
            <div class="stat-card-inner">
                <div class="stat-icon primary">
                    <i class="fas fa-book-open"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-value" style="color: var(--primary);">{{ $dipinjam }}</div>
                    <div class="stat-label">Sedang Dipinjam</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-3 animate-in" style="animation-delay: 0.1s;">
        <div class="stat-card">
            <div class="stat-card-inner">
                <div class="stat-icon danger">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-value" style="color: var(--danger);">{{ $terlambat }}</div>
                    <div class="stat-label">Terlambat Kembali</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-3 animate-in" style="animation-delay: 0.15s;">
        <div class="stat-card">
            <div class="stat-card-inner">
                <div class="stat-icon success">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-value" style="color: var(--success);">{{ $kembaliHariIni }}</div>
                    <div class="stat-label">Dikembalikan Hari Ini</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-3 animate-in" style="animation-delay: 0.2s;">
        <div class="stat-card">
            <div class="stat-card-inner">
                <div class="stat-icon success">
                    <i class="fas fa-coins"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-value" style="color: var(--success);">
                        Rp {{ number_format($dendaDibayar, 0, ',', '.') }}
                    </div>
                    <div class="stat-label">Denda Terbayar</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-3 animate-in" style="animation-delay: 0.25s;">
        <div class="stat-card">
            <div class="stat-card-inner">
                <div class="stat-icon" style="background:#fff7ed; color:#ea580c;">
                    <i class="fas fa-file-invoice-dollar"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-value" style="color:#ea580c;">
                        Rp {{ number_format($dendaBelumDibayar, 0, ',', '.') }}
                    </div>
                    <div class="stat-label">Tagihan Denda</div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- MAIN TABLE -->
<div class="table-card animate-in" style="animation-delay: 0.2s;">
    <div class="table-header">
        <h6>
            <i class="fas fa-list me-2" style="color: var(--primary);"></i>
            Daftar Transaksi & Riwayat Pengembalian
        </h6>
        <form action="{{ route('admin.pengembalian.index') }}" method="GET" class="d-flex flex-wrap gap-2">
            <select name="status" class="search-input" style="width: 150px;" onchange="this.form.submit()">
                <option value="">-- Status Pinjam --</option>
                <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>📖 Dipinjam</option>
                <option value="terlambat" {{ request('status') == 'terlambat' ? 'selected' : '' }}>⚠️ Terlambat</option>
                <option value="dikembalikan" {{ request('status') == 'dikembalikan' ? 'selected' : '' }}>✅ Selesai</option>
            </select>

            <select name="status_bayar" class="search-input" style="width: 150px;" onchange="this.form.submit()">
                <option value="">-- Pembayaran --</option>
                <option value="belum_bayar" {{ request('status_bayar') == 'belum_bayar' ? 'selected' : '' }}>❌ Belum Lunas</option>
                <option value="lunas" {{ request('status_bayar') == 'lunas' ? 'selected' : '' }}>✅ Lunas</option>
            </select>

            <div class="position-relative">
                <i class="fas fa-search position-absolute text-muted" style="top: 50%; left: 14px; transform: translateY(-50%); font-size: 12px;"></i>
                <input type="text" name="search" class="search-input ps-5" placeholder="Cari anggota atau buku..." value="{{ request('search') }}">
            </div>
        </form>
    </div>

    <div class="card-body p-0">
        @if($transaksi->isEmpty())
            <div class="empty-state">
                <div class="empty-icon" style="background: var(--primary-soft);">
                    <i class="fas fa-{{ request('search') ? 'search' : 'clipboard-list' }}" style="color: var(--primary);"></i>
                </div>
                <h6 class="fw-semibold mb-2" style="color: var(--primary-dark);">
                    {{ request('search') ? 'Data Tidak Ditemukan' : 'Belum Ada Data Transaksi' }}
                </h6>
                <p class="text-muted small mb-0">
                    {{ request('search') 
                        ? 'Tidak ada hasil untuk "' . request('search') . '". Coba kata kunci lain.' 
                        : 'Riwayat peminjaman dan pengembalian akan muncul di tabel ini.' }}
                </p>
            </div>
        @else
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th class="ps-4" width="5%">NO</th>
                            <th width="22%">PEMINJAM</th>
                            <th width="25%">BUKU</th>
                            <th>TGL PINJAM</th>
                            <th>BATAS KEMBALI</th>
                            <th>STATUS</th>
                            <th>PEMBAYARAN</th>
                            <th class="text-center" width="15%">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksi as $item)
                        <tr class="{{ $item->status === 'terlambat' ? 'table-danger-row' : '' }}">
                            <td class="ps-4 text-muted">{{ $transaksi->firstItem() + $loop->index }}</td>
                            <td>
                                <div class="fw-semibold" style="color: var(--primary-dark);">{{ $item->anggota->nama }}</div>
                                <div class="small text-muted">
                                    <i class="fas fa-id-card me-1"></i> NIS: {{ $item->anggota->nis }}
                                </div>
                            </td>
                            <td>
                                <div class="fw-medium">{{ $item->buku->judul }}</div>
                                <div class="small text-muted">
                                    <i class="fas fa-barcode me-1"></i> {{ $item->buku->kode_buku }}
                                </div>
                            </td>
                            <td>
                                <span class="fw-medium">{{ $item->tgl_pinjam->format('d M Y') }}</span>
                            </td>
                            <td>
                                <div class="fw-semibold {{ $item->status === 'terlambat' ? 'text-danger' : '' }}">
                                    {{ $item->tgl_kembali_rencana->format('d M Y') }}
                                </div>
                                @if($item->status === 'terlambat')
                                    @php
                                        $terlambatHari = $item->tgl_kembali_rencana->diffInDays(\Carbon\Carbon::today());
                                    @endphp
                                    <div class="small text-danger mt-1">
                                        <i class="fas fa-exclamation-circle me-1"></i> {{ $terlambatHari }} hari terlambat
                                    </div>
                                @endif
                            </td>
                            <td>
                                @if($item->status === 'dipinjam')
                                    <span class="badge-status badge-active">
                                        <i class="fas fa-clock"></i> Aktif
                                    </span>
                                @elseif($item->status === 'terlambat')
                                    <span class="badge-status badge-late">
                                        <i class="fas fa-exclamation-triangle"></i> Terlambat
                                    </span>
                                @elseif($item->status === 'menunggu_pengembalian')
                                    <span class="badge-status" style="background: #fff7ed; color: #ea580c;">
                                        <i class="fas fa-hourglass-half"></i> Menunggu Verifikasi
                                    </span>
                                    <div class="small fw-bold text-danger mt-1">
                                        <i class="fas fa-money-bill-wave me-1"></i> 
                                        Rp {{ number_format($item->hitungDenda(), 0, ',', '.') }}
                                    </div>
                                @elseif($item->status === 'dikembalikan')
                                    <span class="badge-custom badge-returned">
                                        <i class="fas fa-check-double"></i> Selesai
                                    </span>
                                    @if($item->kondisi_buku_kembali !== 'baik')
                                        <div class="small text-danger mt-1" style="font-size: 11px;">
                                            <i class="fas fa-exclamation-circle me-1"></i> Kondisi: {{ ucfirst($item->kondisi_buku_kembali) }}
                                        </div>
                                    @endif
                                    <div class="small text-success mt-1">
                                        <i class="fas fa-calendar-check me-1"></i>
                                        {{ $item->tgl_kembali_aktual->format('d M Y') }}
                                    </div>
                                    @if($item->denda > 0)
                                        <div class="small fw-bold text-danger mt-1">
                                            <i class="fas fa-money-bill-wave me-1"></i> 
                                            Rp {{ number_format($item->denda, 0, ',', '.') }}
                                        </div>
                                    @endif
                                @endif
                            </td>
                            <td class="text-center">
                                @if($item->status === 'dikembalikan')
                                    @if($item->status_bayar === 'lunas' || $item->denda == 0)
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1" style="font-size: 11px;">
                                            <i class="fas fa-check-circle me-1"></i> Lunas
                                         </span>
                                    @else
                                        <form action="{{ route('admin.transaksi.lunas', $item->id) }}" method="POST" class="d-inline" id="form-lunas-{{ $item->id }}">
                                            @csrf
                                            <button type="button" class="btn btn-sm btn-primary rounded-pill px-3" style="font-size: 11px;"
                                                onclick="confirmLunas('{{ $item->id }}', '{{ number_format($item->denda, 0, ',', '.') }}')">
                                                <i class="fas fa-money-bill-wave me-1"></i> Bayar
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($item->status !== 'dikembalikan')
                                    <button type="button" class="btn-return"
                                        onclick="confirmKembali('{{ route('admin.transaksi.kembalikan', $item->id) }}', '{{ $item->anggota->nama }}', '{{ $item->buku->judul }}', '{{ $item->tgl_kembali_rencana->format('Y-m-d') }}')">
                                        <i class="fas fa-undo-alt me-1"></i> Kembalikan
                                    </button>
                                @else
                                    <div class="d-flex flex-column gap-1 align-items-center">
                                        <span class="text-muted small fw-bold">
                                            <i class="fas fa-check me-1"></i> Selesai
                                        </span>
                                        @if($item->status_bayar === 'belum_bayar')
                                            <button type="button" class="btn btn-link text-warning p-0" style="font-size: 11px; text-decoration: none;"
                                                onclick="editDenda('{{ route('admin.transaksi.update', $item->id) }}', '{{ $item->denda }}')">
                                                <i class="fas fa-edit me-1"></i> Edit Denda
                                            </button>
                                        @endif
                                    </div>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($transaksi->hasPages())
            <div class="card-footer bg-white border-0 py-3 d-flex justify-content-end">
                <div class="pagination-custom">
                    {{ $transaksi->links('pagination::bootstrap-4') }}
                </div>
            </div>
            @endif
        @endif
    </div>
</div>

<!-- MODAL PENGEMBALIAN DETIL -->
<div class="modal fade modal-premium" id="kembaliModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-0">
                <h5 class="modal-title text-white fw-bold">
                    <i class="fas fa-clipboard-check me-2"></i> Laporan Kondisi Buku Kembali
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="kembaliForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-4">
                        <!-- Info Buku -->
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded-4 border border-dashed border-primary border-opacity-25">
                                <div>
                                    <div class="small text-muted mb-1">Buku yang dikembalikan:</div>
                                    <h5 class="fw-bold mb-0 text-primary" id="modalBuku">Judul Buku</h5>
                                </div>
                                <div class="text-end">
                                    <div class="small text-muted mb-1">Peminjam:</div>
                                    <div class="fw-semibold text-dark" id="modalPeminjam">Nama Peminjam</div>
                                </div>
                            </div>
                        </div>

                        <!-- Kondisi Radio -->
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <label class="fw-bold mb-0">Kondisi Buku</label>
                                <div class="d-flex gap-3">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="kondisi_buku_kembali" id="kondisibaik" value="baik" checked onchange="updateDendaUI()">
                                        <label class="form-check-label badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2 rounded-pill" for="kondisibaik">
                                            Baik
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="kondisi_buku_kembali" id="kondisirusak" value="rusak" onchange="updateDendaUI()">
                                        <label class="form-check-label badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-3 py-2 rounded-pill" for="kondisirusak">
                                            Rusak 
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="kondisi_buku_kembali" id="kondisiHilang" value="hilang" onchange="updateDendaUI()">
                                        <label class="form-check-label badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-3 py-2 rounded-pill" for="kondisiHilang">
                                            Hilang
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Bukti & Denda Row -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-muted">BUKTI FOTO KERUSAKAN</label>
                            <div class="input-group">
                                <input type="file" name="foto_kerusakan" class="form-control" id="fotoKerusakan">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-muted">DENDA KERUSAKAN (RP)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">Rp</span>
                                <input type="number" name="denda_kerusakan" id="dendaKerusakan" class="form-control border-start-0" value="0" min="0" oninput="updateDendaUI()">
                            </div>
                        </div>

                        <!-- Catatan -->
                        <div class="col-12">
                            <label class="form-label fw-semibold small text-muted">CATATAN KERUSAKAN</label>
                            <textarea name="catatan_kerusakan" class="form-control" rows="3" placeholder="Jelaskan kondisi kerusakan jika ada..."></textarea>
                        </div>

                        <!-- Summary Denda -->
                        <div class="col-12">
                            <div class="p-4 rounded-4" style="background: #f0fdfa; border: 1px solid #ccfbf1;">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Denda Keterlambatan:</span>
                                    <span class="fw-semibold" id="uiDendaTelat">Rp 0</span>
                                </div>
                                <div class="d-flex justify-content-between mb-3">
                                    <span class="text-muted">Total Denda Kerusakan:</span>
                                    <span class="fw-semibold text-warning" id="uiDendaRusak">+ Rp 0</span>
                                </div>
                                <hr class="my-3 opacity-10">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="fw-bold mb-0">Total Denda:</h5>
                                    <h4 class="fw-bold mb-0 text-danger" id="uiTotalDenda">Rp 0</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light px-4 py-3">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold shadow-sm" style="background: #0d9488; border: none;">
                        Proses Pengembalian
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL EDIT DENDA -->
<div class="modal fade modal-premium" id="editDendaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-0 p-4">
                <h5 class="modal-title text-white fw-bold">
                    <i class="fas fa-edit me-2"></i> Edit Nominal Denda
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="editDendaForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted text-uppercase tracking-wider">Nominal Denda (Rp)</label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-light border-end-0 text-muted fw-bold">Rp</span>
                            <input type="number" name="denda" id="inputEditDenda" class="form-control border-start-0 bg-light fw-bold" min="0" required placeholder="0" style="color: var(--primary-dark);">
                        </div>
                        <div class="mt-3 p-3 rounded-3" style="background: var(--primary-soft); border-left: 4px solid var(--primary);">
                            <div class="small text-muted d-flex align-items-start">
                                <i class="fas fa-info-circle me-2 mt-1" style="color: var(--primary);"></i>
                                <span>Ubah nominal denda jika ada penyesuaian manual (misal: denda telat + denda rusak).</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light px-4 py-3 d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold shadow-sm" style="background: var(--primary); border: none;">
                        <i class="fas fa-save me-2"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let currentTglKembaliRencana = null;

    function confirmKembali(action, peminjam, buku, tglKembaliRencana) {
        document.getElementById('kembaliForm').action = action;
        document.getElementById('modalPeminjam').innerHTML = peminjam;
        document.getElementById('modalBuku').innerHTML = buku;
        currentTglKembaliRencana = tglKembaliRencana;
        
        // Reset form
        document.getElementById('kembaliForm').reset();
        
        updateDendaUI();
        
        var myModal = new bootstrap.Modal(document.getElementById('kembaliModal'));
        myModal.show();
    }

    function confirmLunas(id, nominal) {
        Swal.fire({
            title: 'Konfirmasi Pembayaran',
            text: "Apakah Anda yakin ingin menandai denda Rp " + nominal + " ini sebagai LUNAS?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#2c5282',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Sudah Bayar',
            cancelButtonText: 'Batal',
            border: 'none',
            borderRadius: '20px'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-lunas-' + id).submit();
            }
        });
    }

    function editDenda(action, denda) {
        document.getElementById('editDendaForm').action = action;
        document.getElementById('inputEditDenda').value = denda;
        var myModal = new bootstrap.Modal(document.getElementById('editDendaModal'));
        myModal.show();
    }

    function updateDendaUI() {
        if (!currentTglKembaliRencana) return;

        const tglRencana = new Date(currentTglKembaliRencana);
        const tglHariIni = new Date();
        tglHariIni.setHours(0,0,0,0);
        tglRencana.setHours(0,0,0,0);

        let dendaTelat = 0;
        if (tglHariIni > tglRencana) {
            const diffTime = Math.abs(tglHariIni - tglRencana);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            dendaTelat = diffDays * 5000;
        }

        const dendaRusak = parseInt(document.getElementById('dendaKerusakan').value) || 0;
        const totalDenda = dendaTelat + dendaRusak;

        document.getElementById('uiDendaTelat').innerText = 'Rp ' + dendaTelat.toLocaleString('id-ID');
        document.getElementById('uiDendaRusak').innerText = '+ Rp ' + dendaRusak.toLocaleString('id-ID');
        document.getElementById('uiTotalDenda').innerText = 'Rp ' + totalDenda.toLocaleString('id-ID');
    }

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 2500,
            confirmButtonColor: '#2c5282'
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}',
            confirmButtonColor: '#2c5282'
        });
    @endif
</script>
@endsection