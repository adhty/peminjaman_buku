@extends('layouts.admin')

@section('title', 'Pengembalian Buku')
@section('page-title', 'Pengembalian')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 fw-bold mb-1">Pengembalian Buku</h2>
        <p class="text-muted mb-0" style="font-size: 14px;">Proses pengembalian buku yang sedang dipinjam</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.pengembalian.export', ['type' => 'excel']) }}" class="btn btn-success shadow-sm">
            <i class="bi bi-file-earmark-excel me-1"></i> Excel
        </a>
        <a href="{{ route('admin.pengembalian.export', ['type' => 'pdf']) }}" class="btn btn-danger shadow-sm">
            <i class="bi bi-file-earmark-pdf me-1"></i> PDF
        </a>
        <a href="{{ route('admin.transaksi.index') }}" class="btn btn-outline-secondary shadow-sm">
            <i class="bi bi-arrow-left-right me-1"></i> Lihat Semua Transaksi
        </a>
    </div>
</div>

{{-- Stats Cards --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #3b82f6 !important;">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="bg-primary bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center" style="width:52px;height:52px;">
                    <i class="bi bi-book-half text-primary fs-4"></i>
                </div>
                <div>
                    <div class="fs-2 fw-bold">{{ $dipinjam }}</div>
                    <div class="text-muted small">Sedang Dipinjam</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #ef4444 !important;">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="bg-danger bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center" style="width:52px;height:52px;">
                    <i class="bi bi-exclamation-circle text-danger fs-4"></i>
                </div>
                <div>
                    <div class="fs-2 fw-bold text-danger">{{ $terlambat }}</div>
                    <div class="text-muted small">Terlambat Kembali</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #22c55e !important;">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="bg-success bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center" style="width:52px;height:52px;">
                    <i class="bi bi-check-circle text-success fs-4"></i>
                </div>
                <div>
                    <div class="fs-2 fw-bold text-success">{{ $kembaliHariIni }}</div>
                    <div class="text-muted small">Dikembalikan Hari Ini</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Table --}}
<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
        <span class="fw-semibold">Daftar Buku Belum Dikembalikan</span>
        <form action="{{ route('admin.pengembalian.index') }}" method="GET" class="d-flex" style="width:250px;">
            <div class="input-group input-group-sm">
                <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Cari anggota / buku..." value="{{ request('search') }}">
            </div>
        </form>
    </div>
    <div class="card-body p-0">
        @if($transaksi->isEmpty())
            <div class="text-center py-5 text-muted">
                <i class="bi bi-check2-circle display-4 opacity-50 mb-3 d-block text-success"></i>
                <p class="fw-medium">Semua buku sudah dikembalikan! Tidak ada peminjaman aktif.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-secondary small">
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
                        <tr class="{{ $item->status === 'terlambat' ? 'table-danger bg-opacity-25' : '' }}">
                            <td class="ps-4 text-muted">{{ $transaksi->firstItem() + $loop->index }}</td>
                            <td>
                                <div class="fw-bold">{{ $item->anggota->nama }}</div>
                                <div class="small text-muted">NIS: {{ $item->anggota->nis }}</div>
                            </td>
                            <td>
                                <div class="fw-bold">{{ $item->buku->judul }}</div>
                                <div class="small text-muted">Kode: {{ $item->buku->kode_buku }}</div>
                            </td>
                            <td>{{ $item->tgl_pinjam->format('d M Y') }}</td>
                            <td>
                                <span class="fw-semibold {{ $item->status === 'terlambat' ? 'text-danger' : '' }}">
                                    {{ $item->tgl_kembali_rencana->format('d M Y') }}
                                </span>
                                @if($item->status === 'terlambat')
                                    @php
                                        $terlambatHari = $item->tgl_kembali_rencana->diffInDays(\Carbon\Carbon::today());
                                    @endphp
                                    <div class="small text-danger">{{ $terlambatHari }} hari terlambat</div>
                                @endif
                            </td>
                            <td>
                                @if($item->status === 'dipinjam')
                                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-2 py-1">
                                        <i class="bi bi-clock"></i> Aktif
                                    </span>
                                @elseif($item->status === 'terlambat')
                                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-1">
                                        <i class="bi bi-exclamation-circle"></i> Terlambat
                                    </span>
                                    <div class="small fw-bold text-danger mt-1" style="font-size:11px;">
                                        Denda: Rp{{ number_format($item->hitungDenda(), 0, ',', '.') }}
                                    </div>
                                @endif
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-success text-white px-3"
                                    onclick="confirmKembali('{{ route('admin.transaksi.kembalikan', $item->id) }}', '{{ $item->anggota->nama }}', '{{ $item->buku->judul }}')">
                                    <i class="bi bi-box-arrow-in-down me-1"></i> Kembalikan
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($transaksi->hasPages())
            <div class="card-footer bg-white py-3 border-top d-flex justify-content-end">
                {{ $transaksi->links('pagination::bootstrap-5') }}
            </div>
            @endif
        @endif
    </div>
</div>

{{-- Modal Pengembalian --}}
<div class="modal fade" id="kembaliModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg" style="border-radius:16px;">
      <div class="modal-body p-4">
        <div class="text-center mb-4">
            <div class="mx-auto bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mb-3" style="width:80px;height:80px;">
                <i class="bi bi-box-arrow-in-down text-success" style="font-size:2.5rem;"></i>
            </div>
            <h5 class="fw-bold mb-1">Proses Pengembalian</h5>
            <p class="text-muted small mb-0">Konfirmasi bahwa buku telah dikembalikan secara fisik</p>
        </div>

        <div class="bg-light rounded-3 p-3 mb-4">
            <div class="small text-muted mb-1">Peminjam</div>
            <div class="fw-semibold" id="modalPeminjam">—</div>
            <div class="small text-muted mt-2 mb-1">Buku</div>
            <div class="fw-semibold" id="modalBuku">—</div>
        </div>

        <form id="kembaliForm" method="POST">
            @csrf
            <div class="mb-4">
                <label class="form-label fw-semibold">Tanggal Aktual Pengembalian</label>
                <input type="date" name="tgl_kembali_aktual" class="form-control"
                    value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}" required>
                <div class="form-text text-muted small mt-1">
                    <i class="bi bi-info-circle"></i> Denda akan dikalkulasi otomatis bila melewati batas jadwal.
                </div>
            </div>
            <div class="d-flex gap-2 justify-content-end">
                <button type="button" class="btn btn-light px-4 fw-medium" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success px-4 fw-medium text-white">
                    <i class="bi bi-check2 me-1"></i> Konfirmasi Kembali
                </button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
    function confirmKembali(action, peminjam, buku) {
        document.getElementById('kembaliForm').action = action;
        document.getElementById('modalPeminjam').textContent = peminjam;
        document.getElementById('modalBuku').textContent = buku;
        var myModal = new bootstrap.Modal(document.getElementById('kembaliModal'));
        myModal.show();
    }
</script>
@endpush
