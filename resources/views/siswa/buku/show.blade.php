@extends('layouts.siswa')

@section('title', 'Detail Buku')
@section('page-title', 'Informasi Detail Buku')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('siswa.buku.index') }}" class="btn btn-light rounded-circle shadow-sm d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div>
            <h2 class="h4 fw-bold mb-0">Detail Buku</h2>
            <p class="text-muted mb-0" style="font-size: 14px;">Baca sinopsis atau detail dari buku ini</p>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0 rounded-4 overflow-hidden mb-5">
    <div class="row g-0">
        <div class="col-md-5 col-lg-4 bg-light position-relative text-center d-flex align-items-center justify-content-center p-4 border-end">
            @if($buku->cover)
                <img src="{{ Storage::url($buku->cover) }}" alt="Cover Buku" class="img-fluid rounded shadow-sm" style="max-height: 450px; object-fit: cover; width: 100%; max-width: 300px;">
            @else
                <div class="bg-white rounded d-flex align-items-center justify-content-center shadow-sm" style="width: 100%; aspect-ratio: 3/4; max-width: 250px;">
                    <div class="text-center text-muted opacity-50">
                        <i class="bi bi-book display-1"></i>
                        <div class="mt-2">Tidak ada cover</div>
                    </div>
                </div>
            @endif
        </div>
        
        <div class="col-md-7 col-lg-8">
            <div class="card-body p-4 p-lg-5">
                <div class="d-flex flex-wrap gap-2 mb-3">
                    <span class="badge bg-primary px-3 py-2 rounded-pill fs-6 fw-normal">{{ $buku->kategori }}</span>
                    @if($buku->stok > 0)
                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2 rounded-pill fs-6 fw-normal"><i class="bi bi-check2-circle me-1"></i>Tersedia ({{ $buku->stok }})</span>
                    @else
                        <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-3 py-2 rounded-pill fs-6 fw-normal"><i class="bi bi-x-circle me-1"></i>Stok Habis</span>
                    @endif
                </div>

                <h2 class="fw-bold text-dark mb-2">{{ $buku->judul }}</h2>
                <p class="text-muted fs-5 mb-4"><i class="bi bi-pen me-2"></i>{{ $buku->pengarang }}</p>

                <div class="row g-4 mb-4 pb-4 border-bottom">
                    <div class="col-6 col-sm-4">
                        <div class="text-muted small mb-1">Kode Buku</div>
                        <div class="fw-semibold font-monospace">{{ $buku->kode_buku }}</div>
                    </div>
                    <div class="col-6 col-sm-4">
                        <div class="text-muted small mb-1">Penerbit</div>
                        <div class="fw-semibold">{{ $buku->penerbit }}</div>
                    </div>
                    <div class="col-6 col-sm-4">
                        <div class="text-muted small mb-1">Tahun Terbit</div>
                        <div class="fw-semibold">{{ $buku->tahun_terbit }}</div>
                    </div>
                </div>

                <div class="mb-5">
                    <h5 class="fw-bold mb-3">Deskripsi / Sinopsis</h5>
                    <div class="text-muted lh-lg" style="white-space: pre-line;">
                        {{ $buku->deskripsi ?? 'Buku ini belum memiliki deskripsi atau sinopsis yang ditulis oleh administrator.' }}
                    </div>
                </div>

                <div class="">
                    @if($buku->stok > 0)
                        <form action="{{ route('siswa.buku.pinjam', $buku->id) }}" method="POST" id="formPinjamDetail">
                            @csrf
                            <button type="button" class="btn btn-primary btn-lg rounded-pill px-5 fw-bold shadow-sm" onclick="confirmPinjam(document.getElementById('formPinjamDetail'), '{{ addslashes($buku->judul) }}')">
                                <i class="bi bi-journal-plus me-2"></i> Pinjam Buku Ini Sekarang
                            </button>
                        </form>
                    @else
                        <button class="btn btn-secondary btn-lg rounded-pill px-5 fw-bold" disabled>
                            <i class="bi bi-journal-x me-2"></i> Maaf, Buku Sedang Kosong
                        </button>
                        <p class="text-muted small mt-2 d-inline-block ms-0 ms-sm-3">Siswa lain masih meminjam buku ini.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

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
