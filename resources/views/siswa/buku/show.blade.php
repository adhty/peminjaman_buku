@extends('layouts.siswa')

@section('title', 'Detail Buku')
@section('page-title', '📖 Detail Buku')

@section('content')
<style>
    :root {
        --primary-dark: #1e3a5f;
        --primary: #2c5282;
        --primary-light: #3182ce;
        --primary-soft: #ebf4ff;
        --secondary: #4a5568;
    }

    .back-btn {
        width: 42px;
        height: 42px;
        border-radius: 14px;
        background: white;
        border: 1px solid #eef2f6;
        color: var(--primary);
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .back-btn:hover {
        background: var(--primary);
        color: white;
        transform: translateX(-3px);
        box-shadow: 0 4px 12px rgba(44, 82, 130, 0.2);
    }

    .detail-card {
        background: white;
        border-radius: 28px;
        border: 1px solid #eef2f6;
        overflow: hidden;
        transition: all 0.3s;
    }

    .detail-card:hover {
        box-shadow: 0 25px 40px -15px rgba(30, 58, 95, 0.2);
    }

    .cover-section {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        padding: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .book-cover-img {
        border-radius: 16px;
        box-shadow: 0 20px 35px -10px rgba(0,0,0,0.2);
        transition: all 0.3s;
        max-height: 400px;
        width: auto;
        max-width: 100%;
    }

    .book-cover-img:hover {
        transform: scale(1.02);
    }

    .cover-placeholder {
        background: white;
        border-radius: 20px;
        padding: 40px;
        text-align: center;
        box-shadow: 0 10px 25px -5px rgba(0,0,0,0.05);
    }

    .category-badge {
        background: var(--primary-soft);
        color: var(--primary);
        padding: 6px 16px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 600;
    }

    .stock-badge {
        padding: 6px 16px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 600;
    }

    .stock-available {
        background: #f0fdf4;
        color: #15803d;
        border: 1px solid #bbf7d0;
    }

    .stock-empty {
        background: #fef2f2;
        color: #dc2626;
        border: 1px solid #fecaca;
    }

    .info-label {
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--secondary);
        margin-bottom: 4px;
    }

    .info-value {
        font-size: 14px;
        font-weight: 600;
        color: var(--primary-dark);
    }

    .info-value-mono {
        font-size: 13px;
        font-weight: 600;
        font-family: monospace;
        background: var(--primary-soft);
        padding: 4px 12px;
        border-radius: 8px;
        display: inline-block;
    }

    .synopsis {
        background: var(--primary-soft);
        border-radius: 20px;
        padding: 24px;
        line-height: 1.8;
        font-size: 14px;
        color: var(--secondary);
    }

    .btn-borrow {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        border: none;
        padding: 14px 32px;
        border-radius: 40px;
        font-weight: 700;
        font-size: 15px;
        transition: all 0.3s;
        color: white;
    }

    .btn-borrow:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px -5px rgba(44, 82, 130, 0.4);
    }

    .btn-borrow:disabled {
        background: #cbd5e1;
        transform: none;
        cursor: not-allowed;
    }

    .modal-premium .modal-content {
        border-radius: 28px;
        border: none;
        overflow: hidden;
    }

    .modal-premium .modal-header {
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
        padding: 20px 24px;
        border: none;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-in {
        animation: fadeIn 0.5s ease forwards;
    }
</style>

<div class="animate-in">
    <!-- BACK BUTTON -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('siswa.buku.index') }}" class="back-btn">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="h4 fw-bold mb-0" style="color: var(--primary-dark);">Detail Buku</h2>
                <p class="text-muted mb-0" style="font-size: 13px;">Baca sinopsis atau detail lengkap dari buku ini</p>
            </div>
        </div>
    </div>

    <!-- MAIN CARD -->
    <div class="detail-card">
        <div class="row g-0">
            <!-- COVER SECTION -->
            <div class="col-md-5 col-lg-4 cover-section">
                @if($buku->cover)
                    <img src="{{ Storage::url($buku->cover) }}" alt="Cover Buku" class="book-cover-img">
                @else
                    <div class="cover-placeholder">
                        <i class="fas fa-book" style="font-size: 80px; color: var(--primary); opacity: 0.3;"></i>
                        <div class="mt-3 text-muted small">Tidak ada cover</div>
                    </div>
                @endif
            </div>
            
            <!-- INFO SECTION -->
            <div class="col-md-7 col-lg-8">
                <div class="card-body p-4 p-lg-5">
                    <!-- BADGES -->
                    <div class="d-flex flex-wrap gap-2 mb-4">
                        @forelse($buku->kategoris as $kat)
                            <span class="category-badge">
                                <i class="fas fa-tag me-1"></i> {{ $kat->nama }}
                            </span>
                        @empty
                            <span class="category-badge">
                                <i class="fas fa-tag me-1"></i> {{ $buku->kategori ?: 'Lainnya' }}
                            </span>
                        @endforelse
                        
                        @if($buku->stok > 0)
                            <span class="stock-badge stock-available">
                                <i class="fas fa-check-circle me-1"></i> Tersedia ({{ $buku->stok }})
                            </span>
                        @else
                            <span class="stock-badge stock-empty">
                                <i class="fas fa-times-circle me-1"></i> Stok Habis
                            </span>
                        @endif
                    </div>

                    <!-- TITLE & AUTHOR -->
                    <h2 class="fw-bold mb-2" style="color: var(--primary-dark);">{{ $buku->judul }}</h2>
                    <p class="text-muted mb-4">
                        <i class="fas fa-user-edit me-2"></i> {{ $buku->pengarang }}
                    </p>

                    <!-- DETAIL INFO -->
                    <div class="row g-4 mb-4 pb-3" style="border-bottom: 1px solid #eef2f6;">
                        <div class="col-6 col-sm-4">
                            <div class="info-label">
                                <i class="fas fa-barcode me-1"></i> Kode Buku
                            </div>
                            <div class="info-value-mono">{{ $buku->kode_buku }}</div>
                        </div>
                        <div class="col-6 col-sm-4">
                            <div class="info-label">
                                <i class="fas fa-building me-1"></i> Penerbit
                            </div>
                            <div class="info-value">{{ $buku->penerbit ?: '-' }}</div>
                        </div>
                        <div class="col-6 col-sm-4">
                            <div class="info-label">
                                <i class="fas fa-calendar-alt me-1"></i> Tahun Terbit
                            </div>
                            <div class="info-value">{{ $buku->tahun_terbit ?: '-' }}</div>
                        </div>
                    </div>

                    <!-- SYNOPSIS -->
                    <div class="mb-4">
                        <h5 class="fw-bold mb-3" style="color: var(--primary-dark);">
                            <i class="fas fa-align-left me-2" style="color: var(--primary);"></i> Sinopsis
                        </h5>
                        <div class="synopsis">
                            {!! nl2br(e($buku->deskripsi ?? 'Buku ini belum memiliki deskripsi atau sinopsis yang ditulis oleh administrator.')) !!}
                        </div>
                    </div>

                    <!-- BORROW BUTTON -->
                    <div>
                        @if($buku->stok > 0)
                            <form action="{{ route('siswa.buku.pinjam', $buku->id) }}" method="POST" id="formPinjamDetail">
                                @csrf
                                <button type="button" class="btn-borrow" onclick="confirmPinjam(document.getElementById('formPinjamDetail'), '{{ addslashes($buku->judul) }}')">
                                    <i class="fas fa-book-open me-2"></i> Pinjam Buku Ini Sekarang
                                </button>
                            </form>
                        @else
                            <button class="btn-borrow" disabled>
                                <i class="fas fa-ban me-2"></i> Maaf, Buku Sedang Kosong
                            </button>
                            <p class="text-muted small mt-3">
                                <i class="fas fa-info-circle me-1"></i> Siswa lain masih meminjam buku ini.
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL KONFIRMASI PINJAM -->
<div class="modal fade modal-premium" id="pinjamModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
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
                    <strong id="judulBukuPinjam" class="text-dark fs-6 d-block" style="color: var(--primary-dark) !important;">-</strong>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold small mb-2">
                        <i class="fas fa-calendar-alt me-2" style="color: var(--primary);"></i>Tanggal Pengembalian
                    </label>
                    <input type="date" id="inputTglKembali" class="form-control rounded-3" 
                           min="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d') }}"
                           style="border: 2px solid #e2e8f0; padding: 12px;">
                    <div class="form-text mt-2 small">
                        <i class="fas fa-info-circle me-1" style="color: var(--primary);"></i>
                        Pilih tanggal Anda akan mengembalikan buku. Minimal esok hari.
                    </div>
                </div>

                <div class="alert alert-info py-2 px-3 small mb-0" style="background: var(--primary-soft); border: none; border-radius: 12px;">
                    <i class="fas fa-clock me-2"></i>
                    Maksimal peminjaman adalah 7 hari. Denda Rp 5.000/hari jika terlambat.
                </div>
            </div>
            <div class="modal-footer border-0 pt-0 pb-4 px-4">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                <button type="button" id="btnProsesPinjam" class="btn rounded-pill px-4" style="background: var(--primary); color: white;">
                    <i class="fas fa-check me-2"></i> Ya, Pinjam Sekarang
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Font Awesome & SweetAlert -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let formPinjamActive = null;

    function confirmPinjam(form, judul) {
        formPinjamActive = form;
        document.getElementById('judulBukuPinjam').innerHTML = judul;
        document.getElementById('inputTglKembali').value = '';
        var myModal = new bootstrap.Modal(document.getElementById('pinjamModal'));
        myModal.show();
    }

    document.getElementById('btnProsesPinjam').addEventListener('click', function() {
        if(formPinjamActive) {
            const tglKembali = document.getElementById('inputTglKembali').value;
            if(!tglKembali) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: 'Silakan pilih tanggal pengembalian terlebih dahulu!',
                    confirmButtonColor: '#2c5282'
                });
                document.getElementById('inputTglKembali').focus();
                return;
            }

            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'tgl_kembali_rencana';
            hiddenInput.value = tglKembali;
            formPinjamActive.appendChild(hiddenInput);

            this.disabled = true;
            this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memproses...';
            formPinjamActive.submit();
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