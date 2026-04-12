@extends('layouts.siswa')

@section('title', 'Katalog Buku')
@section('page-title', 'Katalog Buku')

@section('content')
<div class="row align-items-center mb-4 g-3">
    <div class="col-lg-6">
        <p class="text-muted mb-0">Temukan buku yang ingin Anda baca. Lebih dari ratusan koleksi tersedia.</p>
    </div>
    <div class="col-lg-6">
        <form action="{{ route('siswa.buku.index') }}" method="GET" class="d-flex gap-2">
            <select name="kategori" class="form-select border-0 shadow-sm" style="max-width: 150px;">
                <option value="">Semua Kategori</option>
                @foreach($kategori as $kat)
                    <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                @endforeach
            </select>
            <div class="input-group shadow-sm border-0 rounded">
                <input type="text" name="search" class="form-control border-0" placeholder="Pencarian judul, pengarang..." value="{{ request('search') }}">
                <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
            </div>
            @if(request()->hasAny(['search', 'kategori']))
                <a href="{{ route('siswa.buku.index') }}" class="btn btn-light shadow-sm" title="Reset Filter"><i class="bi bi-x-lg"></i></a>
            @endif
        </form>
    </div>
</div>

@if($buku->isEmpty())
    <div class="card border-0 shadow-sm">
        <div class="card-body text-center py-5">
            <i class="bi bi-search display-1 text-muted opacity-25"></i>
            <h4 class="mt-4 mb-2">Buku Tidak Ditemukan</h4>
            <p class="text-muted mb-0">Maaf, kami tidak dapat menemukan buku yang Anda cari. Coba kata kunci atau kategori lain.</p>
        </div>
    </div>
@else
    <div class="row g-4">
        @foreach($buku as $item)
        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="card h-100 border-0 shadow-sm hover-elevate position-relative" style="transition: transform 0.2s, box-shadow 0.2s; overflow: hidden;">
                <!-- Kategori Badge -->
                <div class="position-absolute top-0 end-0 m-3 z-index-1">
                    <span class="badge bg-primary bg-opacity-90 px-3 py-2 rounded-pill shadow-sm">{{ $item->kategori }}</span>
                </div>

                <!-- Cover Buku -->
                @if($item->cover)
                    <div style="height: 200px; background-image: url('{{ Storage::url($item->cover) }}'); background-size: cover; background-position: center; border-bottom: 1px solid #e2e8f0;"></div>
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center border-bottom" style="height: 200px;">
                        <i class="bi bi-book text-muted opacity-25" style="font-size: 5rem;"></i>
                    </div>
                @endif
                
                <div class="card-body d-flex flex-column p-4">
                    <div class="mb-auto">
                        <small class="text-muted font-monospace d-block mb-2"><i class="bi bi-upc-scan me-1"></i> {{ $item->kode_buku }}</small>
                        <h5 class="fw-bold mb-1 lh-base">{{ $item->judul }}</h5>
                        <p class="text-muted small mb-3"><i class="bi bi-pen me-1"></i> {{ $item->pengarang }}</p>
                    </div>
                    
                    <div class="mt-3 pt-3 border-top d-flex justify-content-between align-items-center">
                        <div>
                            @if($item->stok > 0)
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25">Tersedia: {{ $item->stok }}</span>
                            @else
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25">Stok Habis</span>
                            @endif
                        </div>
                        
                        @if($item->stok > 0)
                            <div class="d-flex gap-2">
                                <a href="{{ route('siswa.buku.show', $item->id) }}" class="btn btn-outline-primary btn-sm rounded-pill px-3 fw-semibold">
                                    Detail
                                </a>
                                <form action="{{ route('siswa.buku.pinjam', $item->id) }}" method="POST">
                                    @csrf
                                    <button type="button" class="btn btn-primary btn-sm rounded-pill px-3 fw-semibold" onclick="confirmPinjam(this.form, '{{ addslashes($item->judul) }}')">
                                        Pinjam <i class="bi bi-arrow-right-short"></i>
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="d-flex gap-2">
                                <a href="{{ route('siswa.buku.show', $item->id) }}" class="btn btn-outline-primary btn-sm rounded-pill px-3 fw-semibold">
                                    Detail
                                </a>
                                <button class="btn btn-secondary btn-sm rounded-pill px-3 fw-semibold" disabled>Kosong</button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-5">
        {{ $buku->links('pagination::bootstrap-5') }}
    </div>
@endif

<!-- Modal Konfirmasi Pinjam -->
<div class="modal fade" id="pinjamModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
      <div class="modal-header border-bottom-0 pb-0">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center p-4 pt-0">
        <div class="mb-4">
            <div class="mx-auto bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                <i class="bi bi-journal-check text-primary" style="font-size: 2.5rem;"></i>
            </div>
        </div>
        <h4 class="fw-bold mb-3">Konfirmasi Peminjaman</h4>
        <p class="text-muted mb-4 d-flex flex-column gap-1">
            <span>Anda akan meminjam buku:</span>
            <strong id="judulBukuPinjam" class="text-dark fs-5">Judul Buku</strong>
        </p>
        
        <div class="mb-4 text-start bg-light p-3 rounded-3 border">
            <label class="form-label fw-semibold text-dark small mb-2"><i class="bi bi-calendar-event text-primary me-2"></i>Pilih Tanggal Pengembalian</label>
            <input type="date" name="tgl_kembali_rencana" id="inputTglKembali" class="form-control form-control-lg shadow-sm" required min="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d') }}">
            <div class="form-text mt-2" style="font-size: 0.8rem;"><i class="bi bi-info-circle me-1"></i>Pilih tanggal Anda akan mengembalikan buku ke perpustakaan. Minimal esok hari.</div>
        </div>

        <div class="d-flex justify-content-center gap-2 mt-4 mt-sm-5">
            <button type="button" class="btn btn-light fw-medium px-4" data-bs-dismiss="modal">Batal</button>
            <button type="button" id="btnProsesPinjam" class="btn btn-primary fw-medium px-4">Ya, Pinjam Sekarang</button>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('styles')
<style>
    .hover-elevate:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1) !important;
    }
</style>
@endpush

@push('scripts')
<script>
    let formPinjamActive = null;

    function confirmPinjam(form, judul) {
        formPinjamActive = form;
        document.getElementById('judulBukuPinjam').textContent = judul;
        
        // Reset input date
        document.getElementById('inputTglKembali').value = '';
        
        var myModal = new bootstrap.Modal(document.getElementById('pinjamModal'));
        myModal.show();
    }

    document.getElementById('btnProsesPinjam').addEventListener('click', function() {
        if(formPinjamActive) {
            const tglKembali = document.getElementById('inputTglKembali').value;
            if(!tglKembali) {
                alert('Silakan pilih tanggal pengembalian terlebih dahulu.');
                document.getElementById('inputTglKembali').focus();
                return;
            }

            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'tgl_kembali_rencana';
            hiddenInput.value = tglKembali;
            formPinjamActive.appendChild(hiddenInput);

            this.disabled = true;
            this.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Memproses...';
            formPinjamActive.submit();
        }
    });
</script>
@endpush
