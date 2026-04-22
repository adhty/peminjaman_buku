@extends('layouts.siswa')

@section('title', 'Katalog Buku')
@section('page-title', '📚 Katalog Buku')

@section('content')
<style>
    :root {
        --primary-dark: #1e3a5f;
        --primary: #2c5282;
        --primary-light: #3182ce;
        --primary-soft: #ebf4ff;
    }

    .search-section {
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
        border-radius: 24px;
        padding: 32px;
        margin-bottom: 32px;
    }

    .search-title {
        color: white;
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .search-subtitle {
        color: rgba(255,255,255,0.8);
        font-size: 14px;
    }

    .search-input-group {
        background: white;
        border-radius: 16px;
        padding: 4px;
    }

    .search-input-group .form-control {
        border: none;
        padding: 12px 20px;
        border-radius: 14px;
    }

    .search-input-group .btn {
        border-radius: 12px;
        padding: 10px 24px;
        background: var(--primary);
        color: white;
    }

    .filter-select {
        background: rgba(255,255,255,0.15);
        border: 1px solid rgba(255,255,255,0.3);
        color: white;
        padding: 10px 16px;
        border-radius: 12px;
    }

    .filter-select option {
        background: var(--primary-dark);
        color: white;
    }

    /* BOOK CARD - RAPIH */
    .book-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.3s;
        border: 1px solid #eef2f6;
        height: 100%;
        position: relative;
        display: flex;
        flex-direction: column;
    }

    .book-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 30px -12px rgba(30, 58, 95, 0.15);
    }

    .book-cover {
        height: 200px;
        background-size: cover;
        background-position: center;
        background-color: #f1f5f9;
        flex-shrink: 0;
    }

    .book-cover-placeholder {
        height: 200px;
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .category-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        background: rgba(44, 82, 130, 0.95);
        color: white;
        padding: 4px 12px;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 600;
        z-index: 2;
    }

    .book-info {
        padding: 16px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .book-code {
        font-size: 10px;
        color: #94a3b8;
        background: #f1f5f9;
        padding: 3px 8px;
        border-radius: 6px;
        display: inline-block;
        margin-bottom: 10px;
        width: fit-content;
    }

    .book-title {
        font-size: 16px;
        font-weight: 700;
        color: var(--primary-dark);
        margin-bottom: 6px;
        line-height: 1.3;
    }

    .book-author {
        font-size: 12px;
        color: #64748b;
        margin-bottom: 12px;
    }

    .stock-info {
        margin-bottom: 12px;
    }

    .stock-available {
        background: #f0fdf4;
        color: #15803d;
        padding: 4px 10px;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 600;
        display: inline-block;
    }

    .stock-empty {
        background: #fef2f2;
        color: #dc2626;
        padding: 4px 10px;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 600;
        display: inline-block;
    }

    .action-buttons {
        display: flex;
        gap: 8px;
        margin-top: auto;
    }

    .btn-detail {
        flex: 1;
        border: 1.5px solid var(--primary);
        color: var(--primary);
        padding: 8px 0;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 600;
        background: transparent;
        text-decoration: none;
        text-align: center;
        transition: all 0.2s;
    }

    .btn-detail:hover {
        background: var(--primary);
        color: white;
    }

    .btn-borrow {
        flex: 1;
        background: var(--primary);
        color: white;
        padding: 8px 0;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 600;
        border: none;
        text-align: center;
        transition: all 0.2s;
    }

    .btn-borrow:hover {
        background: var(--primary-dark);
    }

    .btn-borrow:disabled {
        background: #cbd5e1;
        cursor: not-allowed;
    }

    /* Pagination */
    .pagination-custom .page-link {
        border-radius: 10px;
        margin: 0 4px;
        border: 1px solid #e2e8f0;
        color: #4a5568;
    }

    .pagination-custom .page-item.active .page-link {
        background: var(--primary);
        border-color: var(--primary);
        color: white;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .search-section {
            padding: 20px;
        }
        .search-title {
            font-size: 20px;
        }
        .book-cover, .book-cover-placeholder {
            height: 180px;
        }
    }
</style>

<!-- SEARCH SECTION -->
<div class="search-section">
    <div class="row align-items-center">
        <div class="col-lg-5 mb-4 mb-lg-0">
            <div class="search-title">Temukan Buku Favoritmu</div>
            <div class="search-subtitle">Lebih dari 1000+ koleksi buku tersedia untuk Anda baca</div>
        </div>
        <div class="col-lg-7">
            <form action="{{ route('siswa.buku.index') }}" method="GET">
                <div class="row g-2">
                    <div class="col-md-4">
                        <select name="kategori_id" class="filter-select w-100" onchange="this.form.submit()">
                            <option value="">Semua Kategori</option>
                            @foreach($kategori as $kat)
                                <option value="{{ $kat->id }}" {{ request('kategori_id') == $kat->id ? 'selected' : '' }}>{{ $kat->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-8">
                        <div class="search-input-group">
                            <div class="d-flex">
                                <input type="text" name="search" class="form-control" placeholder="Cari judul buku, pengarang..." value="{{ request('search') }}">
                                <button class="btn" type="submit">
                                    <i class="fas fa-search me-1"></i> Cari
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            @if(request()->hasAny(['search', 'kategori_id']))
                <div class="mt-3 text-end">
                    <a href="{{ route('siswa.buku.index') }}" class="text-white text-decoration-none small">
                        <i class="fas fa-times-circle me-1"></i> Reset Filter
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- RESULT INFO -->
@if(!$buku->isEmpty())
    <div class="mb-3">
        <div class="small text-muted">
            <i class="fas fa-chart-line me-1"></i>
            Menampilkan {{ $buku->firstItem() }} - {{ $buku->lastItem() }} dari {{ $buku->total() }} buku
        </div>
    </div>
@endif

<!-- BOOK GRID -->
@if($buku->isEmpty())
    <div class="text-center py-5 bg-white rounded-4">
        <i class="fas fa-book-open" style="font-size: 64px; color: var(--primary); opacity: 0.3;"></i>
        <h5 class="fw-bold mt-3" style="color: var(--primary-dark);">Buku Tidak Ditemukan</h5>
        <p class="text-muted small">Maaf, buku yang Anda cari tidak tersedia.</p>
    </div>
@else
    <div class="row g-4">
        @foreach($buku as $item)
        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="book-card">
                <!-- Category Badge -->
                <div class="category-badge">
                    @if($item->kategoris->isNotEmpty())
                        {{ $item->kategoris->first()->nama }}
                    @else
                        Novel
                    @endif
                </div>

                <!-- Cover -->
                @if($item->cover)
                    <div class="book-cover" style="background-image: url('{{ Storage::url($item->cover) }}');"></div>
                @else
                    <div class="book-cover-placeholder">
                        <i class="fas fa-book" style="font-size: 48px; color: var(--primary); opacity: 0.3;"></i>
                    </div>
                @endif

                <!-- Info -->
                <div class="book-info">
                    <div class="book-code">
                        <i class="fas fa-barcode me-1"></i> {{ $item->kode_buku }}
                    </div>
                    <div class="book-title">{{ $item->judul }}</div>
                    <div class="book-author">
                        <i class="fas fa-user-edit me-1"></i> {{ $item->pengarang }}
                    </div>
                    
                    <div class="stock-info">
                        @if($item->stok > 0)
                            <span class="stock-available">
                                <i class="fas fa-check-circle"></i> Tersedia {{ $item->stok }}
                            </span>
                        @else
                            <span class="stock-empty">
                                <i class="fas fa-times-circle"></i> Stok Habis
                            </span>
                        @endif
                    </div>

                    <div class="action-buttons">
                        <a href="{{ route('siswa.buku.show', $item->id) }}" class="btn-detail">
                            <i class="fas fa-eye me-1"></i> Detail
                        </a>

                        @if($item->stok > 0)
                            <form action="{{ route('siswa.buku.pinjam', $item->id) }}" method="POST" style="flex: 1;">
                                @csrf
                                <button type="button" class="btn-borrow w-100" onclick="confirmPinjam(this.form, '{{ $item->judul }}')">
                                    <i class="fas fa-book-open me-1"></i> Pinjam
                                </button>
                            </form>
                        @else
                            <button class="btn-borrow w-100" disabled>
                                <i class="fas fa-ban me-1"></i> Habis
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- PAGINATION -->
    <div class="d-flex justify-content-center mt-5">
        <div class="pagination-custom">
            {{ $buku->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endif

<!-- MODAL PINJAM -->
<div class="modal fade" id="pinjamModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0" style="background: linear-gradient(135deg, var(--primary-dark), var(--primary));">
                <h5 class="modal-title text-white fw-semibold">
                    <i class="fas fa-book-reader me-2"></i> Konfirmasi Peminjaman
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="text-center mb-4">
                    <div class="mx-auto bg-light rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                        <i class="fas fa-question" style="font-size: 28px; color: var(--primary);"></i>
                    </div>
                    <p class="text-muted mb-2">Anda akan meminjam buku:</p>
                    <strong id="judulBukuPinjam" class="text-dark fs-6">-</strong>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold small">
                        <i class="fas fa-calendar-alt me-2" style="color: var(--primary);"></i>Tanggal Pengembalian
                    </label>
                    <input type="date" id="inputTglKembali" class="form-control rounded-3" 
                           min="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d') }}"
                           style="border: 2px solid #e2e8f0; padding: 12px;">
                </div>

                <div class="alert alert-info py-2 small mb-0" style="background: var(--primary-soft); border: none; border-radius: 12px;">
                    <i class="fas fa-info-circle me-2"></i> Maksimal peminjaman 7 hari. Denda Rp 5.000/hari jika terlambat.
                </div>
            </div>
            <div class="modal-footer border-0 pt-0 pb-4 px-4">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                <button type="button" id="btnProsesPinjam" class="btn rounded-pill px-4" style="background: var(--primary); color: white;">
                    <i class="fas fa-check me-2"></i> Ya, Pinjam
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let formPinjamActive = null;

    function confirmPinjam(form, judul) {
        formPinjamActive = form;
        document.getElementById('judulBukuPinjam').innerHTML = judul;
        document.getElementById('inputTglKembali').value = '';
        var modal = new bootstrap.Modal(document.getElementById('pinjamModal'));
        modal.show();
    }

    document.getElementById('btnProsesPinjam').addEventListener('click', function() {
        if(formPinjamActive) {
            var tglKembali = document.getElementById('inputTglKembali').value;
            if(!tglKembali) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: 'Silakan pilih tanggal pengembalian terlebih dahulu!',
                    confirmButtonColor: '#2c5282'
                });
                return;
            }
            var hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'tgl_kembali_rencana';
            hiddenInput.value = tglKembali;
            formPinjamActive.appendChild(hiddenInput);
            this.disabled = true;
            this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memproses...';
            formPinjamActive.submit();
        }
    });
</script>
@endsection