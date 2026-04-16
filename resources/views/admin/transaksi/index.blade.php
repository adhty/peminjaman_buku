@extends('layouts.admin')

@section('title', 'Transaksi Peminjaman')
@section('page-title', 'Transaksi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 fw-bold mb-1">Sirkulasi Peminjaman</h2>
        <p class="text-muted mb-0" style="font-size: 14px;">Kelola peminjaman dan pengembalian buku</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.transaksi.export', ['type' => 'excel', 'status' => request('status')]) }}" class="btn btn-success shadow-sm">
            <i class="bi bi-file-earmark-excel me-1"></i> Excel
        </a>
        <a href="{{ route('admin.transaksi.export', ['type' => 'pdf', 'status' => request('status')]) }}" class="btn btn-danger shadow-sm">
            <i class="bi bi-file-earmark-pdf me-1"></i> PDF
        </a>
        <a href="{{ route('admin.transaksi.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> Pinjam Buku
        </a>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3">
        <div class="d-flex flex-wrap gap-3 p-3 bg-light rounded align-items-center w-100">
            <form action="{{ route('admin.transaksi.index') }}" method="GET" class="d-flex flex-wrap gap-2 w-100" id="filterForm">
                @if(request('status')) <input type="hidden" name="status" value="{{ request('status') }}"> @endif
                
                <div class="input-group" style="width: 250px;">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control border-start-0 ps-0 form-control-sm" placeholder="Cari peminjam, buku..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-arrow-right"></i></button>
                </div>

                <div class="input-group" style="width: auto;">
                    <span class="input-group-text bg-white border-end-0 btn-sm" title="Filter Tanggal (Harian)"><i class="bi bi-calendar-event text-primary"></i></span>
                    <input type="date" name="filter_date" class="form-control border-start-0 ps-0 form-control-sm" value="{{ request('filter_date') }}" onchange="document.getElementById('filterForm').submit()">
                </div>

                <div class="input-group" style="width: auto;">
                    <span class="input-group-text bg-white border-end-0 btn-sm" title="Filter Bulan (Bulanan)"><i class="bi bi-calendar-month text-success"></i></span>
                    <input type="month" name="filter_month" class="form-control border-start-0 ps-0 form-control-sm" value="{{ request('filter_month') }}" onchange="document.getElementById('filterForm').submit()">
                </div>
                
                @if(request('search') || request('filter_date') || request('filter_month'))
                    <a href="{{ route('admin.transaksi.index', ['status' => request('status')]) }}" class="btn btn-outline-danger btn-sm" title="Reset Pencarian & Filter">
                        <i class="bi bi-x-lg"></i> Reset
                    </a>
                @endif
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
                <a href="{{ route('admin.transaksi.index', ['status' => 'menunggu_persetujuan', 'search' => request('search')]) }}" 
                   class="nav-link px-3 py-1 btn-sm border {{ request('status') == 'menunggu_persetujuan' ? 'active bg-warning border-warning text-dark' : 'text-dark border-secondary bg-white' }}">
                   Menunggu
                </a>
                <a href="{{ route('admin.transaksi.index', ['status' => 'terlambat', 'search' => request('search')]) }}" 
                   class="nav-link px-3 py-1 btn-sm border {{ request('status') == 'terlambat' ? 'active bg-danger border-danger' : 'text-dark border-secondary bg-white' }}">
                   Terlambat
                </a>
                <a href="{{ route('admin.transaksi.index', ['status' => 'dikembalikan', 'search' => request('search')]) }}" 
                   class="nav-link px-3 py-1 btn-sm border {{ request('status') == 'dikembalikan' ? 'active bg-success border-success' : 'text-dark border-secondary bg-white' }}">
                   Selesai
                </a>
                <a href="{{ route('admin.transaksi.index', ['status' => 'ditolak', 'search' => request('search')]) }}" 
                   class="nav-link px-3 py-1 btn-sm border {{ request('status') == 'ditolak' ? 'active bg-dark border-dark text-white' : 'text-dark border-secondary bg-white' }}">
                   Ditolak
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
                                @if($item->status === 'menunggu_persetujuan')
                                    <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-2 py-1"><i class="bi bi-hourglass-split"></i> Pending</span>
                                @elseif($item->status === 'dipinjam')
                                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-2 py-1"><i class="bi bi-clock"></i> Aktif</span>
                                @elseif($item->status === 'dikembalikan')
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1"><i class="bi bi-check2-all"></i> Selesai</span>
                                    @if($item->denda > 0)
                                        <div class="small fw-bold text-danger mt-1" style="font-size: 11px;">Denda: Rp{{ number_format($item->denda, 0, ',', '.') }}</div>
                                    @endif
                                @elseif($item->status === 'terlambat')
                                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-1"><i class="bi bi-exclamation-circle"></i> Terlambat</span>
                                    <div class="small fw-bold text-danger mt-1" style="font-size: 11px;">Denda berjalan: Rp{{ number_format($item->hitungDenda(), 0, ',', '.') }}</div>
                                @elseif($item->status === 'ditolak')
                                    <span class="badge bg-dark bg-opacity-10 text-dark border border-dark border-opacity-25 px-2 py-1"><i class="bi bi-x-circle"></i> Ditolak</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    @if($item->status === 'menunggu_persetujuan')
                                        <form action="{{ route('admin.transaksi.approve', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success text-white" title="Terima Peminjaman"><i class="bi bi-check-lg"></i></button>
                                        </form>
                                        <form action="{{ route('admin.transaksi.reject', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tolak permintaan pinjam ini?');">
                                            @csrf
                                            <button type="submit" class="btn btn-dark text-white" title="Tolak Peminjaman"><i class="bi bi-x-lg"></i></button>
                                        </form>
                                    @elseif($item->status !== 'dikembalikan' && $item->status !== 'ditolak')
                                        <button type="button" class="btn btn-primary text-white" onclick="confirmKembali(`{{ route('admin.transaksi.kembalikan', $item->id) }}`)" title="Proses Pengembalian">
                                            <i class="bi bi-box-arrow-in-down"></i>
                                        </button>
                                    @endif
                                    
                                    @if($item->status !== 'ditolak' && $item->status !== 'menunggu_persetujuan')
                                        <button type="button" class="btn btn-warning text-dark border-0" onclick="editTransaksi(`{{ route('admin.transaksi.update', $item->id) }}`, `{{ $item->tgl_kembali_rencana->format('Y-m-d') }}`, `{{ $item->denda }}`)" title="Edit Tanggal & Denda Manual">
                                            <i class="bi bi-pencil-square"></i>
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

<!-- Modal Edit Transaksi -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header border-bottom-0 pb-0">
        <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square text-warning me-2"></i> Edit Peminjaman</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="editForm" method="POST">
          @csrf
          @method('PUT')
          <div class="modal-body pt-3 pb-4">
            <p class="text-muted mb-4 small">Sesuaikan tanggal kembali atau terapkan denda kustom (misal: buku hilang/rusak).</p>
            <div class="mb-3">
                <label class="form-label fw-semibold">Tanggal Batas Pengembalian</label>
                <input type="date" name="tgl_kembali_rencana" id="edit_tgl_kembali_rencana" class="form-control bg-light" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Ganti Denda Manual (Rp)</label>
                <div class="input-group">
                    <span class="input-group-text border-end-0">Rp</span>
                    <input type="number" name="denda" id="edit_denda" class="form-control border-start-0" min="0" placeholder="0">
                </div>
                <div class="form-text text-muted" style="font-size: 11px;">Isi angka denda jika terjadi kerusakan/hilang. Isi 0 agar sistem menggunakan denda telat otomatis (5000/hari).</div>
            </div>
          </div>
          <div class="modal-footer border-top-0 bg-light rounded-bottom">
              <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-warning px-4 text-dark fw-bold">
                  <i class="bi bi-check2"></i> Simpan
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

    function editTransaksi(action, tgl, denda) {
        document.getElementById('editForm').action = action;
        document.getElementById('edit_tgl_kembali_rencana').value = tgl;
        document.getElementById('edit_denda').value = denda || 0;
        var myModal = new bootstrap.Modal(document.getElementById('editModal'));
        myModal.show();
    }
</script>
@endpush
