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
                <div class="stat-icon" style="background:#fff7ed; color:#ea580c;">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-value" style="color:#ea580c;">
                        Rp {{ number_format($totalDenda, 0, ',', '.') }}
                    </div>
                    <div class="stat-label">Total Denda</div>
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
        <form action="{{ route('admin.pengembalian.index') }}" method="GET">
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
                                    <div class="small fw-bold text-danger mt-1">
                                        <i class="fas fa-money-bill-wave me-1"></i> 
                                        Rp {{ number_format($item->hitungDenda(), 0, ',', '.') }}
                                    </div>
                                @elseif($item->status === 'dikembalikan')
                                    <span class="badge-status badge-success">
                                        <i class="fas fa-check-circle"></i> Dikembalikan
                                    </span>
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
                                @if($item->status !== 'dikembalikan')
                                    <button type="button" class="btn-return"
                                        onclick="confirmKembali('{{ route('admin.transaksi.kembalikan', $item->id) }}', '{{ $item->anggota->nama }}', '{{ $item->buku->judul }}')">
                                        <i class="fas fa-undo-alt me-1"></i> Kembalikan
                                    </button>
                                @else
                                    <span class="text-muted small fw-bold">
                                        <i class="fas fa-check me-1"></i> Selesai
                                    </span>
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

<!-- MODAL PREMIUM -->
<div class="modal fade modal-premium" id="kembaliModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-white fw-semibold">
                    <i class="fas fa-book-return me-2"></i> Konfirmasi Pengembalian
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="text-center mb-4">
                    <div class="mx-auto bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                        <i class="fas fa-check-circle" style="font-size: 28px; color: var(--success);"></i>
                    </div>
                    <h6 class="fw-bold mb-1">Proses Pengembalian</h6>
                    <p class="text-muted small mb-0">Konfirmasi bahwa buku telah dikembalikan secara fisik</p>
                </div>

                <div class="bg-light rounded-3 p-3 mb-4">
                    <div class="small text-muted mb-1">
                        <i class="fas fa-user me-1"></i> Peminjam
                    </div>
                    <div class="fw-semibold" id="modalPeminjam" style="color: var(--primary-dark);">—</div>
                    <div class="small text-muted mt-2 mb-1">
                        <i class="fas fa-book me-1"></i> Buku
                    </div>
                    <div class="fw-semibold" id="modalBuku" style="color: var(--primary-dark);">—</div>
                </div>

                <form id="kembaliForm" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">
                            <i class="fas fa-calendar-alt me-2" style="color: var(--primary);"></i>Tanggal Aktual Pengembalian
                        </label>
                        <input type="date" name="tgl_kembali_aktual" class="form-control rounded-3" 
                            value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}" required
                            style="border: 2px solid #e2e8f0; padding: 10px;">
                        <div class="form-text text-muted small mt-1">
                            <i class="fas fa-info-circle me-1"></i> Denda akan dikalkulasi otomatis bila melewati batas jadwal.
                        </div>
                    </div>
                    <div class="d-flex gap-2 justify-content-end mt-4">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn rounded-pill px-4" style="background: linear-gradient(135deg, var(--success) 0%, #166534 100%); color: white; border: none;">
                            <i class="fas fa-check me-1"></i> Konfirmasi Kembali
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmKembali(action, peminjam, buku) {
        document.getElementById('kembaliForm').action = action;
        document.getElementById('modalPeminjam').innerHTML = peminjam;
        document.getElementById('modalBuku').innerHTML = buku;
        var myModal = new bootstrap.Modal(document.getElementById('kembaliModal'));
        myModal.show();
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