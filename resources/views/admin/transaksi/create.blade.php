@extends('layouts.admin')

@section('title', 'Pinjam Buku')
@section('page-title', 'Form Peminjaman')

@push('styles')
<!-- Select2 CSS for Bootstrap 5 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 fw-bold mb-1">Catat Peminjaman Baru</h2>
        <p class="text-muted mb-0" style="font-size: 14px;">Proses peminjaman buku oleh anggota perpustakaan</p>
    </div>
    <a href="{{ route('admin.transaksi.index') }}" class="btn btn-outline-secondary shadow-sm">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="card shadow-sm border-0" style="max-width: 800px;">
    <div class="card-body p-4">
        <form action="{{ route('admin.transaksi.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="form-label fw-semibold">Pilih Anggota / Peminjam <span class="text-danger">*</span></label>
                <select name="anggota_id" id="anggota_id" class="form-select select2" data-placeholder="Cari Nama atau NIS Anggota" required>
                    <option value=""></option>
                    @foreach($anggota as $a)
                        <option value="{{ $a->id }}" {{ old('anggota_id') == $a->id ? 'selected' : '' }}>
                            {{ $a->nis }} — {{ $a->nama }} (Kelas: {{ $a->kelas }})
                        </option>
                    @endforeach
                </select>
                @error('anggota_id')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Pilih Buku Katalog <span class="text-danger">*</span></label>
                <select name="buku_id" id="buku_id" class="form-select select2" data-placeholder="Cari Judul atau Kode Buku" required>
                    <option value=""></option>
                    @foreach($buku as $b)
                        <option value="{{ $b->id }}" {{ old('buku_id') == $b->id ? 'selected' : '' }}>
                            {{ $b->kode_buku }} — {{ $b->judul }} (Sisa Stok: {{ $b->stok }})
                        </option>
                    @endforeach
                </select>
                @error('buku_id')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                @if($buku->isEmpty())
                    <div class="form-text text-danger mt-2"><i class="bi bi-exclamation-triangle"></i> Semua stok buku perpustakaan sedang habis/kosong.</div>
                @endif
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Tanggal Pinjam <span class="text-danger">*</span></label>
                    <input type="date" name="tgl_pinjam" id="tgl_pinjam" class="form-control bg-light @error('tgl_pinjam') is-invalid @enderror" value="{{ old('tgl_pinjam', date('Y-m-d')) }}" required>
                    @error('tgl_pinjam')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Batas Rencana Kembali <span class="text-danger">*</span></label>
                    <input type="date" name="tgl_kembali_rencana" id="tgl_kembali_rencana" class="form-control bg-light @error('tgl_kembali_rencana') is-invalid @enderror" value="{{ old('tgl_kembali_rencana', date('Y-m-d', strtotime('+7 days'))) }}" required>
                    @error('tgl_kembali_rencana')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <div class="form-text text-muted small"><i class="bi bi-info-circle"></i> Default sistem: 7 hari peminjaman</div>
                </div>
            </div>

            <hr class="text-muted opacity-25">

            <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="btn btn-primary px-4 shadow-sm" {{ $buku->isEmpty() ? 'disabled' : '' }}>
                    <i class="bi bi-box-arrow-right me-1"></i> Proses Peminjaman
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap-5',
            width: '100%',
        });

        // Auto calculate return date (+7 days)
        $('#tgl_pinjam').on('change', function() {
            let pinjam = new Date($(this).val());
            if(!isNaN(pinjam.getTime())) {
                pinjam.setDate(pinjam.getDate() + 7);
                let day = ("0" + pinjam.getDate()).slice(-2);
                let month = ("0" + (pinjam.getMonth() + 1)).slice(-2);
                let dateStr = pinjam.getFullYear() + "-" + (month) + "-" + (day);
                $('#tgl_kembali_rencana').val(dateStr);
            }
        });
    });
</script>
@endpush
