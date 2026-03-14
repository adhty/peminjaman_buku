@extends('layouts.admin')

@section('title', 'Transaksi Peminjaman')
@section('page-title', 'Transaksi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 fw-bold mb-1">Sirkulasi Peminjaman</h2>
        <p class="text-muted mb-0" style="font-size: 14px;">Kelola peminjaman dan pengembalian buku</p>
    </div>
    <a href="{{ route('admin.transaksi.create') }}" class="btn btn-primary shadow-sm">
        <i class="bi bi-plus-lg me-1"></i> Pinjam Buku
    </a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3">
        <div class="d-flex flex-wrap gap-3 align-items-center">
            <form action="{{ route('admin.transaksi.index') }}" method="GET" class="d-flex" style="width: 280px;">
                @if(request('status')) <input type="hidden" name="status" value="{{ request('status') }}"> @endif
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Cari peminjam, buku..." value="{{ request('search') }}">
                </div>
            </form>

            <div class="nav nav-pills gap-2">
                <a href="{{ route('admin.transaksi.index', ['search' => request('search')]) }}" 
                   class="nav-link px-3 py-1 btn-sm border {{ !request('status') ? 'active bg-secondary border-secondary' : 'text-dark border-secondary bg-white' }}">
                   Semua
                </a>
                <a href="{{ route('admin.transaksi.index', ['status' => 'dipinjam', 'search' => request('search')]) }}" 
                   class="nav-link px-3 py-1 btn-sm border {{ request('status') == 'dipinjam' ? 'active bg-primary border-primary' : 'text-dark border-secondary bg-white' }}">
                   Dipinjam
                </a>
                <a href="{{ route('admin.transaksi.index', ['status' => 'terlambat', 'search' => request('search')]) }}" 
                   class="nav-link px-3 py-1 btn-sm border {{ request('status') == 'terlambat' ? 'active bg-danger border-danger' : 'text-dark border-secondary bg-white' }}">
                   Terlambat
                </a>
                <a href="{{ route('admin.transaksi.index', ['status' => 'dikembalikan', 'search' => request('search')]) }}" 
                   class="nav-link px-3 py-1 btn-sm border {{ request('status') == 'dikembalikan' ? 'active bg-success border-success' : 'text-dark border-secondary bg-white' }}">
                   Selesai
                </a>
            </div>
        </div>
    </div>
    
    <div class="card-body p-0">
        @if($transaksi->isEmpty())
            <div class="text-center py-5 text-muted">
                <i class="bi bi-journal-x display-4 opacity-50 mb-3 d-block"></i>
                <p>Tidak ada data transaksi ditemukan.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-secondary small">
                        <tr>
                            <th width="5%" class="ps-4">NO</th>
                            <th width="22%">PEMINJAM</th>
                            <th width="25%">BUKU</th>
                            <th>TGL PINJAM</th>
                            <th>BATAS KEMBALI</th>
                            <th>STATUS</th>
                            <th width="15%" class="text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksi as $item)
                        <tr>
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
                                <span class="{{ $item->isTerlambat() && $item->status != 'dikembalikan' ? 'text-danger fw-bold' : '' }}">
                                    {{ $item->tgl_kembali_rencana->format('d M Y') }}
                                </span>
                            </td>
                            <td>
                                @if($item->status === 'dipinjam')
                                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-2 py-1"><i class="bi bi-clock"></i> Aktif</span>
                                @elseif($item->status === 'dikembalikan')
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1"><i class="bi bi-check2-all"></i> Selesai</span>
                                    @if($item->denda > 0)
                                        <div class="small fw-bold text-danger mt-1" style="font-size: 11px;">Denda: Rp{{ number_format($item->denda, 0, ',', '.') }}</div>
                                    @endif
                                @elseif($item->status === 'terlambat')
                                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-1"><i class="bi bi-exclamation-circle"></i> Terlambat</span>
                                    <div class="small fw-bold text-danger mt-1" style="font-size: 11px;">Denda berjalan: Rp{{ number_format($item->hitungDenda(), 0, ',', '.') }}</div>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    @if($item->status !== 'dikembalikan')
                                        <button type="button" class="btn btn-success text-white" onclick="confirmKembali(`{{ route('admin.transaksi.kembalikan', $item->id) }}`)" title="Proses Pengembalian">
                                            <i class="bi bi-box-arrow-in-down"></i>
                                        </button>
                                    @endif
                                    <button type="button" class="btn btn-danger" onclick="confirmDelete(`{{ route('admin.transaksi.destroy', $item->id) }}`)" title="Hapus Data">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </div>
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

<!-- Modal Pengembalian (Bootstrap Modal) -->
<div class="modal fade" id="kembaliModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0">
      <div class="modal-header border-bottom-0 pb-0">
        <h5 class="modal-title fw-bold"><i class="bi bi-check-circle text-success me-2"></i> Proses Pengembalian</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="kembaliForm" method="POST">
          @csrf
          <div class="modal-body pt-3 pb-4">
            <p class="text-muted mb-4">Apakah Anda yakin buku ini telah dikembalikan oleh siswa secara fisik?</p>
            
            <div class="mb-3">
                <label class="form-label fw-semibold">Tanggal Aktual Pengembalian</label>
                <input type="date" name="tgl_kembali_aktual" class="form-control bg-light" value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}" required>
                <div class="form-text text-muted small mt-2"><i class="bi bi-info-circle"></i> Denda akan otomatis dikalkulasi sesuai aturan jika pengembalian melewati batas jadwal.</div>
            </div>
          </div>
          <div class="modal-footer border-top-0 bg-light rounded-bottom">
              <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-success px-4 text-white">
                  <i class="bi bi-check2"></i> Konfirmasi Kembali
              </button>
          </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
    function confirmKembali(action) {
        document.getElementById('kembaliForm').action = action;
        var myModal = new bootstrap.Modal(document.getElementById('kembaliModal'));
        myModal.show();
    }
</script>
@endpush
