@extends('layouts.siswa')

@section('title', 'Pinjamanku')
@section('page-title', '📋 Pinjamanku')

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

    /* Header Section */
    .header-section {
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
        border-radius: 24px;
        padding: 28px 32px;
        margin-bottom: 32px;
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

    .header-section::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -10%;
        width: 180px;
        height: 180px;
        background: rgba(255,255,255,0.03);
        border-radius: 50%;
    }

    .header-title {
        color: white;
        font-size: 22px;
        font-weight: 700;
        margin-bottom: 6px;
    }

    .header-subtitle {
        color: rgba(255,255,255,0.8);
        font-size: 13px;
    }

    /* Filter Section */
    .filter-card {
        background: white;
        border-radius: 20px;
        padding: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        margin-bottom: 24px;
    }

    .filter-select-custom {
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 10px 32px 10px 16px;
        font-size: 13px;
        font-weight: 500;
        color: var(--secondary);
        background: white;
        cursor: pointer;
        transition: all 0.2s;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%234a5568' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 16px;
    }

    .filter-select-custom:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(44, 82, 130, 0.1);
    }

    /* Stat Cards */
    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 16px;
        transition: all 0.3s ease;
        border: 1px solid #eef2f6;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px -5px rgba(30, 58, 95, 0.1);
        border-color: var(--primary-light);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--primary-soft);
        color: var(--primary);
    }

    .stat-value {
        font-size: 28px;
        font-weight: 700;
        color: var(--primary-dark);
    }

    .stat-label {
        font-size: 12px;
        color: var(--secondary);
        font-weight: 500;
    }

    /* Table Styles */
    .transaction-table {
        border-radius: 20px;
        overflow: hidden;
    }

    .transaction-table thead th {
        background: var(--gray-bg);
        font-size: 12px;
        font-weight: 600;
        color: var(--secondary);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e2e8f0;
    }

    .transaction-row {
        transition: all 0.2s ease;
        border-bottom: 1px solid #f1f5f9;
    }

    .transaction-row:hover {
        background: var(--primary-soft);
    }

    .book-cover-small {
        width: 48px;
        height: 62px;
        object-fit: cover;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.08);
        transition: all 0.2s;
    }

    .book-cover-small:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 12px rgba(0,0,0,0.12);
    }

    .book-title {
        font-size: 14px;
        font-weight: 700;
        color: var(--primary-dark);
        margin-bottom: 4px;
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

    .badge-waiting { background: #fff7ed; color: #ea580c; border: 1px solid #fed7aa; }
    .badge-borrowed { background: var(--primary-soft); color: var(--primary); border: 1px solid #bfdbfe; }
    .badge-returned { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
    .badge-late { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
    .badge-rejected { background: #f8fafc; color: #64748b; border: 1px solid #e2e8f0; }

    /* Button Styles */
    .btn-return {
        background: transparent;
        border: 1.5px solid var(--primary);
        color: var(--primary);
        padding: 6px 18px;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 600;
        transition: all 0.2s;
    }

    .btn-return:hover {
        background: var(--primary);
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(44, 82, 130, 0.2);
    }

    .btn-completed {
        background: #f1f5f9;
        color: #94a3b8;
        padding: 6px 18px;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 600;
        border: 1px dashed #cbd5e1;
        cursor: default;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 20px;
    }

    .empty-icon {
        width: 100px;
        height: 100px;
        background: var(--primary-soft);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 24px;
    }

    /* Pagination */
    .pagination-custom {
        display: flex;
        justify-content: flex-end;
        margin-top: 16px;
    }

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

    .pagination-custom .page-link:hover {
        background: var(--primary-soft);
        border-color: var(--primary-light);
        color: var(--primary);
    }

    /* Modal Premium */
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

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-in {
        animation: fadeIn 0.4s ease forwards;
    }
</style>

<!-- HEADER SECTION -->
<div class="header-section animate-in">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <div class="header-title">
                <i class="fas fa-history me-2"></i> Riwayat Peminjaman
            </div>
            <div class="header-subtitle">Kelola dan pantau semua peminjaman buku Anda</div>
        </div>
        <div class="text-end">
            <div class="text-white opacity-75 small">
                <i class="fas fa-clock me-1"></i> Pastikan mengembalikan tepat waktu
            </div>
        </div>
    </div>
</div>

<!-- STATISTIK CARDS -->
<div class="row g-3 mb-4 animate-in" style="animation-delay: 0.05s;">
    <div class="col-md-3 col-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-label mb-1">Total Pinjaman</div>
                    <div class="stat-value">{{ $transaksi->total() }}</div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-book"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-label mb-1">Sedang Dipinjam</div>
                    <div class="stat-value">{{ $transaksi->where('status', 'dipinjam')->count() }}</div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-book-reader"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-label mb-1">Terlambat</div>
                    <div class="stat-value">{{ $transaksi->where('status', 'terlambat')->count() }}</div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-label mb-1">Selesai</div>
                    <div class="stat-value">{{ $transaksi->where('status', 'dikembalikan')->count() }}</div>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FILTER SECTION -->
<div class="filter-card animate-in" style="animation-delay: 0.1s;">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div class="d-flex align-items-center gap-2">
            <i class="fas fa-filter" style="color: var(--primary); font-size: 13px;"></i>
            <span class="text-muted small fw-semibold">Filter Status:</span>
        </div>
        <form action="{{ route('siswa.transaksi.index') }}" method="GET">
            <select name="status" class="filter-select-custom" onchange="this.form.submit()" style="min-width: 200px;">
                <option value="semua" {{ request('status') == 'semua' ? 'selected' : '' }}>📋 Semua Status</option>
                <option value="menunggu_persetujuan" {{ request('status') == 'menunggu_persetujuan' ? 'selected' : '' }}>⏳ Menunggu Persetujuan</option>
                <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>📖 Sedang Dipinjam</option>
                <option value="terlambat" {{ request('status') == 'terlambat' ? 'selected' : '' }}>⚠️ Terlambat</option>
                <option value="dikembalikan" {{ request('status') == 'dikembalikan' ? 'selected' : '' }}>✅ Selesai</option>
                <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>❌ Ditolak</option>
            </select>
        </form>
    </div>
</div>

<!-- MAIN TABLE CARD -->
<div class="card border-0 shadow-sm rounded-3 animate-in" style="animation-delay: 0.15s;">
    <div class="card-body p-0">
        @if($transaksi->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-book-open" style="font-size: 40px; color: var(--primary); opacity: 0.5;"></i>
                </div>
                <h5 class="fw-bold mb-2" style="color: var(--primary-dark);">Belum Ada Transaksi</h5>
                <p class="text-muted small mb-3">Anda belum pernah meminjam buku.<br>Silakan cari buku di katalog.</p>
                <a href="{{ route('siswa.buku.index') }}" class="btn" style="background: var(--primary); color: white; border-radius: 30px; padding: 8px 24px; font-size: 13px;">
                    <i class="fas fa-search me-1"></i> Lihat Katalog Buku
                </a>
            </div>
        @else
            <div class="table-responsive transaction-table">
                <table class="table align-middle mb-0" style="min-width: 750px;">
                    <thead>
                        <tr>
                            <th class="ps-4 py-3">DETAIL BUKU</th>
                            <th class="py-3">TGL PINJAM</th>
                            <th class="py-3">BATAS KEMBALI</th>
                            <th class="py-3">STATUS & DENDA</th>
                            <th class="py-3 text-center pe-4">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksi as $item)
                        <tr class="transaction-row">
                            <td class="ps-4 py-3">
                                <div class="d-flex align-items-center gap-3">
                                    @if($item->buku->cover)
                                        <img src="{{ Storage::url($item->buku->cover) }}" alt="Cover" class="book-cover-small">
                                    @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 48px; height: 62px;">
                                            <i class="fas fa-book" style="color: var(--primary); opacity: 0.4;"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="book-title">{{ $item->buku->judul }}</div>
                                        <div class="small text-muted">{{ $item->buku->kategori }}</div>
                                        <div class="small text-muted opacity-50 mt-1" style="font-size: 10px;">
                                            <i class="fas fa-barcode me-1"></i>{{ $item->buku->kode_buku }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3">
                                <div class="fw-semibold" style="font-size: 13px;">{{ $item->tgl_pinjam->format('d M Y') }}</div>
                                <div class="small text-muted">{{ $item->tgl_pinjam->isoFormat('dddd') }}</div>
                            </td>
                            <td class="py-3">
                                @if($item->status === 'dikembalikan')
                                    <div class="text-muted text-decoration-line-through" style="font-size: 13px;">{{ $item->tgl_kembali_rencana->format('d M Y') }}</div>
                                    <div class="small text-success mt-1">
                                        <i class="fas fa-check-circle me-1"></i> {{ $item->tgl_kembali_aktual->format('d M Y') }}
                                    </div>
                                @else
                                    <div class="{{ $item->status === 'terlambat' ? 'text-danger fw-bold' : 'fw-semibold' }}" style="font-size: 13px;">
                                        {{ $item->tgl_kembali_rencana->format('d M Y') }}
                                    </div>
                                    @if($item->status === 'terlambat')
                                        @php $hariTelat = $item->tgl_kembali_rencana->diffInDays(today()); @endphp
                                        <div class="small text-danger mt-1">
                                            <i class="fas fa-exclamation-circle me-1"></i> Terlewat {{ $hariTelat }} hari
                                        </div>
                                    @else
                                        @php $sisaHari = today()->diffInDays($item->tgl_kembali_rencana, false); @endphp
                                        @if($sisaHari == 0)
                                            <div class="small text-warning fw-bold mt-1">
                                                <i class="fas fa-hourglass-half me-1"></i> Hari terakhir!
                                            </div>
                                        @elseif($sisaHari > 0 && $sisaHari <= 3)
                                            <div class="small text-warning mt-1">
                                                <i class="fas fa-clock me-1"></i> Sisa {{ $sisaHari }} hari
                                            </div>
                                        @elseif($sisaHari > 0)
                                            <div class="small text-muted mt-1">
                                                <i class="fas fa-calendar-day me-1"></i> Sisa {{ $sisaHari }} hari
                                            </div>
                                        @endif
                                    @endif
                                @endif
                            </td>
                            <td class="py-3">
                                @if($item->status === 'menunggu_persetujuan')
                                    <span class="badge-custom badge-waiting">
                                        <i class="fas fa-hourglass-half"></i> Menunggu
                                    </span>
                                @elseif($item->status === 'dipinjam')
                                    <span class="badge-custom badge-borrowed">
                                        <i class="fas fa-book-reader"></i> Dipinjam
                                    </span>
                                @elseif($item->status === 'dikembalikan')
                                    <span class="badge-custom badge-returned">
                                        <i class="fas fa-check-double"></i> Selesai
                                    </span>
                                @elseif($item->status === 'terlambat')
                                    <span class="badge-custom badge-late">
                                        <i class="fas fa-exclamation-triangle"></i> Terlambat
                                    </span>
                                @elseif($item->status === 'ditolak')
                                    <span class="badge-custom badge-rejected">
                                        <i class="fas fa-times-circle"></i> Ditolak
                                    </span>
                                @endif

                                @if($item->denda > 0)
                                    <div class="mt-2">
                                        <span class="small text-danger fw-semibold">
                                            <i class="fas fa-money-bill-wave me-1"></i> Rp {{ number_format($item->denda, 0, ',', '.') }}
                                        </span>
                                    </div>
                                @elseif($item->status === 'terlambat')
                                    @php $dendaSementara = $item->tgl_kembali_rencana->diffInDays(today()) * 5000; @endphp
                                    <div class="mt-2">
                                        <span class="small text-danger">
                                            <i class="fas fa-coins me-1"></i> Rp {{ number_format($dendaSementara, 0, ',', '.') }}*
                                        </span>
                                    </div>
                                @endif
                            </td>
                            <td class="text-center pe-4 py-3">
                                @if(in_array($item->status, ['dipinjam', 'terlambat']))
                                    <form action="{{ route('siswa.transaksi.kembalikan', $item->id) }}" method="POST">
                                        @csrf
                                        <button type="button" 
                                                onclick="confirmKembali(this.form, '{{ addslashes($item->buku->judul) }}')" 
                                                class="btn-return">
                                            <i class="fas fa-undo-alt me-1"></i> Kembalikan
                                        </button>
                                    </form>
                                @elseif($item->status === 'dikembalikan')
                                    <button class="btn-completed" disabled>
                                        <i class="fas fa-check-circle me-1"></i> Selesai
                                    </button>

                                @elseif($item->status === 'menunggu_persetujuan')
                                    <span class="small text-muted">
                                        <i class="fas fa-spinner fa-pulse me-1"></i> Menunggu
                                    </span>

                                @elseif($item->status === 'menunggu_pengembalian')
                                    <span class="small text-muted">
                                        <i class="fas fa-spinner fa-pulse me-1"></i> Menunggu Pengembalian
                                    </span>

                                @elseif($item->status === 'ditolak')
                                    <span class="small text-muted">
                                        <i class="fas fa-ban me-1"></i> Ditolak
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($transaksi->hasPages())
                <div class="card-footer bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div class="small text-muted">
                            <i class="fas fa-chart-line me-1" style="color: var(--primary);"></i>
                            Menampilkan {{ $transaksi->firstItem() }} - {{ $transaksi->lastItem() }} dari {{ $transaksi->total() }} transaksi
                        </div>
                        <div class="pagination-custom">
                            {{ $transaksi->links('pagination::bootstrap-4') }}
                        </div>
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
                    <div class="mx-auto bg-light rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                        <i class="fas fa-question" style="font-size: 28px; color: var(--primary);"></i>
                    </div>
                    <p class="text-muted mb-2">Anda akan mengembalikan buku:</p>
                    <strong id="judulBukuKembali" class="text-dark fs-6 d-block" style="color: var(--primary-dark) !important;">-</strong>
                </div>

                <div class="alert alert-warning py-2 px-3 small mb-0" style="background: #fffbeb; border: 1px solid #fde68a; border-radius: 12px;">
                    <i class="fas fa-info-circle me-2"></i>
                    Pastikan kondisi buku sama seperti saat dipinjam.
                </div>
            </div>
            <div class="modal-footer border-0 pt-0 pb-4 px-4">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                <button type="button" id="btnProsesKembali" class="btn rounded-pill px-4" style="background: var(--primary); color: white;">
                    <i class="fas fa-check me-2"></i> Ya, Kembalikan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let formKembaliActive = null;

    function confirmKembali(form, judul) {
    formKembaliActive = form;
    document.getElementById('judulBukuKembali').textContent = judul;

    // reset tombol modal setiap buka
    const btn = document.getElementById('btnProsesKembali');
    btn.disabled = false;
    btn.innerHTML = '<i class="fas fa-check me-2"></i> Ya, Kembalikan';

    var myModal = new bootstrap.Modal(document.getElementById('kembaliModal'));
    myModal.show();
}

    document.getElementById('btnProsesKembali').addEventListener('click', function() {
    if (formKembaliActive) {

        // loading tombol modal (tidak ubah style)
        this.disabled = true;
        this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memproses...';

        formKembaliActive.submit();
    }
});

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