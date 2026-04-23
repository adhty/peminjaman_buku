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
                                    @if($item->alasan_ditolak)
                                        <div class="small text-muted mt-1" style="font-size: 11px;">Alasan: {{ $item->alasan_ditolak }}</div>
                                    @endif
                                @endif
                            </td>

                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    @if($item->status === 'menunggu_persetujuan')
                                        <form action="{{ route('admin.transaksi.approve', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success text-white" title="Terima Peminjaman"><i class="bi bi-check-lg"></i></button>
                                        </form>
                                        <button type="button" class="btn btn-dark text-white" title="Tolak Peminjaman" onclick="confirmReject(`{{ route('admin.transaksi.reject', $item->id) }}`)">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    @elseif($item->status !== 'dikembalikan' && $item->status !== 'ditolak')
                                        <button type="button" class="btn btn-success text-white" title="Kembalikan Buku" onclick="confirmKembali(`{{ route('admin.transaksi.kembalikan', $item->id) }}`, `{{ $item->anggota->nama }}`, `{{ $item->buku->judul }}`, `{{ $item->tgl_kembali_rencana->format('Y-m-d') }}`)">
                                            <i class="bi bi-arrow-return-left"></i>
                                        </button>
                                    @endif
                                    
                                    @if($item->status !== 'ditolak' && $item->status !== 'menunggu_persetujuan')
                                        <button type="button" class="btn btn-warning text-dark border-0" onclick="editTransaksi(`{{ route('admin.transaksi.update', $item->id) }}`, `{{ $item->tgl_kembali_rencana->format('Y-m-d') }}`, `{{ $item->denda }}`)" title="Edit Batas Kembali & Denda Manual">
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

<!-- Modal Pengembalian Detil -->
<div class="modal fade" id="kembaliModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header border-bottom-0 pb-0">
        <h5 class="modal-title fw-bold text-success"><i class="bi bi-clipboard-check me-2"></i> Laporan Kondisi Buku Kembali</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="kembaliForm" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="modal-body pt-3 pb-4">
            <div class="row g-3">
                <div class="col-12">
                    <div class="p-3 bg-light rounded border">
                        <div class="row">
                            <div class="col-md-6">
                                <small class="text-muted d-block">Buku:</small>
                                <strong id="modalBuku" class="text-primary">Judul Buku</strong>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <small class="text-muted d-block">Peminjam:</small>
                                <strong id="modalPeminjam">Nama Peminjam</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <label class="form-label fw-bold">Kondisi Buku Saat Kembali</label>
                    <div class="d-flex gap-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="kondisi_buku_kembali" id="kondisiBaik" value="baik" checked onchange="updateDendaUI()">
                            <label class="form-check-label text-success fw-semibold" for="kondisiBaik">Baik</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="kondisi_buku_kembali" id="kondisiRusak" value="rusak" onchange="updateDendaUI()">
                            <label class="form-check-label text-warning fw-semibold" for="kondisiRusak">Rusak</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="kondisi_buku_kembali" id="kondisiHilang" value="hilang" onchange="updateDendaUI()">
                            <label class="form-check-label text-danger fw-semibold" for="kondisiHilang">Hilang</label>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Bukti Foto Kerusakan</label>
                    <input type="file" name="foto_kerusakan" class="form-control form-control-sm">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Denda Kerusakan (Rp)</label>
                    <input type="number" name="denda_kerusakan" id="dendaKerusakan" class="form-control form-control-sm" value="0" min="0" oninput="updateDendaUI()">
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold small">Catatan Kerusakan</label>
                    <textarea name="catatan_kerusakan" class="form-control form-control-sm" rows="2" placeholder="Opsional..."></textarea>
                </div>

                <div class="col-12">
                    <div class="p-3 rounded bg-success bg-opacity-10 border border-success border-opacity-20">
                        <div class="d-flex justify-content-between small mb-1">
                            <span>Denda Keterlambatan:</span>
                            <span id="uiDendaTelat" class="fw-bold">Rp 0</span>
                        </div>
                        <div class="d-flex justify-content-between small mb-2">
                            <span>Denda Kerusakan:</span>
                            <span id="uiDendaRusak" class="fw-bold">+ Rp 0</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center border-top pt-2">
                            <span class="fw-bold">Total Denda:</span>
                            <h5 id="uiTotalDenda" class="fw-bold text-danger mb-0">Rp 0</h5>
                        </div>
                    </div>
                </div>
            </div>
          </div>
          <div class="modal-footer border-top-0 bg-light rounded-bottom">
              <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-success px-4 text-white fw-bold">
                  Proses Pengembalian
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
                <label class="form-label fw-semibold small text-muted">Tanggal Batas Pengembalian</label>
                <div id="display_tgl_kembali_rencana" class="fw-bold p-2 bg-light rounded border"></div>
                <input type="hidden" name="tgl_kembali_rencana" id="edit_tgl_kembali_rencana">
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Denda Kerusakan/Lainnya (Rp)</label>
                <div class="input-group">
                    <span class="input-group-text border-end-0">Rp</span>
                    <input type="number" name="denda" id="edit_denda" class="form-control border-start-0" min="0" placeholder="0">
                </div>
                <div class="form-text text-muted" style="font-size: 11px;">Isi angka denda jika terjadi kerusakan atau buku hilang.</div>
            </div>
            <div class="mb-3">
                <div class="alert alert-info py-2 px-3 mb-0" style="font-size: 11px; border-radius: 12px;">
                    <i class="bi bi-info-circle-fill me-1"></i> Denda keterlambatan tetap dihitung otomatis (Rp 5.000/hari) dan akan ditambahkan ke denda kerusakan di atas.
                </div>
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
<!-- Modal Tolak Peminjaman -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header border-bottom-0 pb-0">
        <h5 class="modal-title fw-bold text-danger"><i class="bi bi-x-circle me-2"></i> Tolak Peminjaman</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="rejectForm" method="POST">
          @csrf
          <div class="modal-body pt-3 pb-4">
            <p class="text-muted mb-3">Berikan alasan mengapa permintaan peminjaman ini ditolak.</p>
            <div class="mb-0">
                <label class="form-label fw-semibold small">Alasan Penolakan</label>
                <textarea name="alasan_ditolak" class="form-control" rows="3" placeholder="Misal: Stok buku sedang dalam perbaikan, anggota memiliki denda yang belum dibayar, dll." required></textarea>
            </div>
          </div>
          <div class="modal-footer border-top-0 bg-light rounded-bottom">
              <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-danger px-4 text-white fw-bold">
                  <i class="bi bi-x-circle me-1"></i> Konfirmasi Tolak
              </button>
          </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
    let currentTglKembaliRencana = null;

    function confirmKembali(action, peminjam, buku, tglKembaliRencana) {
        document.getElementById('kembaliForm').action = action;
        document.getElementById('modalPeminjam').innerHTML = peminjam;
        document.getElementById('modalBuku').innerHTML = buku;
        currentTglKembaliRencana = tglKembaliRencana;
        
        document.getElementById('kembaliForm').reset();
        updateDendaUI();

        var myModal = new bootstrap.Modal(document.getElementById('kembaliModal'));
        myModal.show();
    }

    function updateDendaUI() {
        if (!currentTglKembaliRencana) return;

        const tglRencana = new Date(currentTglKembaliRencana);
        const tglHariIni = new Date();
        tglHariIni.setHours(0,0,0,0);
        tglRencana.setHours(0,0,0,0);

        let dendaTelat = 0;
        if (tglHariIni > tglRencana) {
            const diffTime = Math.abs(tglHariIni - tglRencana);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            dendaTelat = diffDays * 5000;
        }

        const dendaRusak = parseInt(document.getElementById('dendaKerusakan').value) || 0;
        const totalDenda = dendaTelat + dendaRusak;

        document.getElementById('uiDendaTelat').innerText = 'Rp ' + dendaTelat.toLocaleString('id-ID');
        document.getElementById('uiDendaRusak').innerText = '+ Rp ' + dendaRusak.toLocaleString('id-ID');
        document.getElementById('uiTotalDenda').innerText = 'Rp ' + totalDenda.toLocaleString('id-ID');
    }

    function editTransaksi(action, tgl, denda) {
        document.getElementById('editForm').action = action;
        document.getElementById('edit_tgl_kembali_rencana').value = tgl;
        
        // Format tanggal untuk tampilan (YYYY-MM-DD -> DD MMM YYYY)
        const date = new Date(tgl);
        const options = { day: 'numeric', month: 'short', year: 'numeric' };
        document.getElementById('display_tgl_kembali_rencana').innerText = date.toLocaleDateString('id-ID', options);
        
        document.getElementById('edit_denda').value = denda || 0;
        var myModal = new bootstrap.Modal(document.getElementById('editModal'));
        myModal.show();
    }
    function confirmReject(action) {
        document.getElementById('rejectForm').action = action;
        var myModal = new bootstrap.Modal(document.getElementById('rejectModal'));
        myModal.show();
    }
</script>
@endpush
