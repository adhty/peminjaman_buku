@extends('layouts.siswa')

@section('title', 'Pinjamanku')
@section('page-title', 'Pinjamanku')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
    <div>
        <p class="text-muted mb-0">Kelola dan pantau riwayat peminjaman buku Anda di sini.</p>
    </div>
    <form action="{{ route('siswa.transaksi.index') }}" method="GET" class="d-flex gap-2">
        <select name="status" class="form-select border-0 shadow-sm" onchange="this.form.submit()">
            <option value="semua" {{ request('status') == 'semua' ? 'selected' : '' }}>Semua Status</option>
            <option value="menunggu_persetujuan" {{ request('status') == 'menunggu_persetujuan' ? 'selected' : '' }}>Menunggu Persetujuan</option>
            <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>Sedang Dipinjam</option>
            <option value="terlambat" {{ request('status') == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
            <option value="dikembalikan" {{ request('status') == 'dikembalikan' ? 'selected' : '' }}>Selesai</option>
            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
        </select>
    </form>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        @if($transaksi->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-journal-x text-muted opacity-25" style="font-size: 5rem;"></i>
                <h4 class="mt-4 mb-2">Belum Ada Transaksi</h4>
                <p class="text-muted mb-0">Anda belum pernah meminjam buku. Silakan cari buku di katalog.</p>
                <a href="{{ route('siswa.buku.index') }}" class="btn btn-primary mt-4 px-3 py-2 btn-sm w-auto" style="border-radius: 10px;"> Lihat Katalog Buku</a>            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-secondary small">
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
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center gap-3">
                                    @if($item->buku->cover)
                                        <img src="{{ Storage::url($item->buku->cover) }}" alt="Cover" class="rounded shadow-sm flex-shrink-0 object-fit-cover" style="width: 45px; height: 60px;">
                                    @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center flex-shrink-0" style="width: 45px; height: 60px;">
                                            <i class="bi bi-book text-muted opacity-50"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="fw-bold text-dark" style="font-size: 1.05rem;">{{ $item->buku->judul }}</div>
                                        <div class="small text-muted">{{ $item->buku->kategori }}</div>
                                        <div class="small font-monospace opacity-50 mt-1">{{ $item->buku->kode_buku }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>{{ $item->tgl_pinjam->format('d M Y') }}</div>
                                <div class="small text-muted opacity-75">Hari {{ $item->tgl_pinjam->isoFormat('dddd') }}</div>
                            </td>
                            <td>
                                @if($item->status === 'dikembalikan')
                                    <div class="text-muted text-decoration-line-through">{{ $item->tgl_kembali_rencana->format('d M Y') }}</div>
                                    <div class="small text-success mt-1">Dikembalikan: {{ $item->tgl_kembali_aktual->format('d M Y') }}</div>
                                @else
                                    <div class="{{ $item->status === 'terlambat' ? 'text-danger fw-bold' : 'text-dark fw-medium' }}">
                                        {{ $item->tgl_kembali_rencana->format('d M Y') }}
                                    </div>
                                    @if($item->status === 'terlambat')
                                        @php $hariTelat = $item->tgl_kembali_rencana->diffInDays(today()); @endphp
                                        <div class="small text-danger mt-1">Terlewat {{ $hariTelat }} hari</div>
                                    @else
                                        @php $sisaHari = today()->diffInDays($item->tgl_kembali_rencana, false); @endphp
                                        @if($sisaHari == 0)
                                            <div class="small text-warning fw-bold mt-1">Hari terakhir!</div>
                                        @elseif($sisaHari > 0)
                                            <div class="small text-muted mt-1">Sisa {{ $sisaHari }} hari</div>
                                        @endif
                                    @endif
                                @endif
                            </td>
                            <td>
                                @if($item->status === 'menunggu_persetujuan')
                                    <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-2 py-1"><i class="bi bi-hourglass-split me-1"></i> Menunggu...</span>
                                @elseif($item->status === 'dipinjam')
                                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-2 py-1"><i class="bi bi-clock me-1"></i> Dipinjam</span>
                                @elseif($item->status === 'dikembalikan')
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1"><i class="bi bi-check2-all me-1"></i> Selesai</span>
                                @elseif($item->status === 'terlambat')
                                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-1"><i class="bi bi-exclamation-octagon me-1"></i> Terlambat</span>
                                @elseif($item->status === 'ditolak')
                                    <span class="badge bg-dark bg-opacity-10 text-dark border border-dark border-opacity-25 px-2 py-1"><i class="bi bi-x-circle me-1"></i> Ditolak</span>
                                @endif

                                @if($item->denda > 0)
                                    <div class="small text-danger fw-semibold mt-2">Denda: Rp {{ number_format($item->denda, 0, ',', '.') }}</div>
                                @elseif($item->status === 'terlambat')
                                    @php $dendaSementara = $item->tgl_kembali_rencana->diffInDays(today()) * 5000; @endphp
                                    <div class="small text-danger fw-semibold mt-2" title="Denda terus berjalan hingga dikembalikan">Denda: Rp {{ number_format($dendaSementara, 0, ',', '.') }}*</div>
                                @endif
                            </td>
                            <td class="text-center pe-4">
                                @if(in_array($item->status, ['dipinjam', 'terlambat']))
                                    <form action="{{ route('siswa.transaksi.kembalikan', $item->id) }}" method="POST">
                                        @csrf
                                        <button type="button" onclick="confirmKembali(this.form, '{{ addslashes($item->buku->judul) }}')" class="btn btn-outline-success btn-sm rounded-pill fw-semibold px-3" title="Akhiri peminjaman">
                                            Kembalikan
                                        </button>
                                    </form>
                                @elseif($item->status === 'dikembalikan')
                                    <button class="btn btn-light btn-sm rounded-pill px-3 text-muted disabled" style="background-color: transparent; border: 1px dashed #cbd5e1;">Tuntas</button>
                                @elseif($item->status === 'menunggu_persetujuan')
                                    <span class="small text-muted fst-italic">Menunggu...</span>
                                @elseif($item->status === 'ditolak')
                                    <span class="small text-danger fst-italic">Ditolak</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($transaksi->hasPages())
                <div class="card-footer bg-white border-top py-3 d-flex justify-content-end">
                    {{ $transaksi->links('pagination::bootstrap-5') }}
                </div>
            @endif
        @endif
    </div>
</div>

<!-- Modal Konfirmasi Kembali -->
<div class="modal fade" id="kembaliModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
      <div class="modal-header border-bottom-0 pb-0">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center p-4 pt-0">
        <div class="mb-4">
            <div class="mx-auto bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                <i class="bi bi-box-arrow-in-down text-success" style="font-size: 2.5rem;"></i>
            </div>
        </div>
        <h4 class="fw-bold mb-3">Kembalikan Buku</h4>
        <p class="text-muted mb-4 d-flex flex-column gap-1">
            <span>Anda akan mengembalikan buku:</span>
            <strong id="judulBukuKembali" class="text-dark fs-5">Judul Buku</strong>
            <span class="mt-2 text-warning" style="font-size: 0.85rem;"><i class="bi bi-info-circle me-1"></i>Pastikan kondisi buku sama seperti saat dipinjam.</span>
        </p>
        <div class="d-flex justify-content-center gap-2 mt-4">
            <button type="button" class="btn btn-light fw-medium px-4" data-bs-dismiss="modal">Batal</button>
            <button type="button" id="btnProsesKembali" class="btn btn-success fw-medium px-4">Ya, Kembalikan</button>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
    let formKembaliActive = null;

    function confirmKembali(form, judul) {
        formKembaliActive = form;
        document.getElementById('judulBukuKembali').textContent = judul;
        var myModal = new bootstrap.Modal(document.getElementById('kembaliModal'));
        myModal.show();
    }

    document.getElementById('btnProsesKembali').addEventListener('click', function() {
        if(formKembaliActive) {
            this.disabled = true;
            this.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Memproses...';
            formKembaliActive.submit();
        }
    });
</script>
@endpush
