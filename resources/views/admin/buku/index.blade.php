@extends('layouts.admin')

@section('title', 'Data Buku')
@section('page-title', 'Buku')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 fw-bold mb-1">Data Koleksi Buku</h2>
        <p class="text-muted mb-0" style="font-size: 14px;">Kelola semua katalog buku di perpustakaan</p>
    </div>
    <div class="d-flex gap-2">
        <button type="button" class="btn btn-success shadow-sm" data-bs-toggle="modal" data-bs-target="#importModal">
            <i class="bi bi-file-earmark-arrow-up me-1"></i> Import Excel
        </button>
        <a href="{{ route('admin.buku.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> Tambah Buku
        </a>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 border-bottom">
        <form action="{{ route('admin.buku.index') }}" method="GET" id="filterForm">
            <div class="row g-2 align-items-end">
                {{-- Search --}}
                <div class="col-12 col-md-4">
                    <label class="form-label small text-muted mb-1 fw-semibold">Cari Buku</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" name="search" class="form-control border-start-0 ps-0"
                            placeholder="Judul, pengarang, kode, penerbit..."
                            value="{{ request('search') }}">
                    </div>
                </div>

                {{-- Kategori --}}
                <div class="col-12 col-md-3">
                    <label class="form-label small text-muted mb-1 fw-semibold">Kategori</label>
                    <select name="kategori" class="form-select">
                        <option value="">-- Semua Kategori --</option>
                        @foreach($kategoriList as $kat)
                            <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>
                                {{ $kat }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Stok Status --}}
                <div class="col-12 col-md-2">
                    <label class="form-label small text-muted mb-1 fw-semibold">Status Stok</label>
                    <select name="stok_status" class="form-select">
                        <option value="">-- Semua --</option>
                        <option value="tersedia" {{ request('stok_status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="habis" {{ request('stok_status') == 'habis' ? 'selected' : '' }}>Habis</option>
                    </select>
                </div>

                {{-- Per Page --}}
                <div class="col-6 col-md-1">
                    <label class="form-label small text-muted mb-1 fw-semibold">Tampil</label>
                    <select name="per_page" class="form-select">
                        @foreach([10, 25, 50] as $n)
                            <option value="{{ $n }}" {{ request('per_page', 10) == $n ? 'selected' : '' }}>{{ $n }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Buttons --}}
                <div class="col-6 col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-funnel-fill me-1"></i> Filter
                    </button>
                    <a href="{{ route('admin.buku.index') }}" class="btn btn-outline-secondary" title="Reset">
                        <i class="bi bi-x-lg"></i>
                    </a>
                </div>
            </div>

            {{-- Active Filter Badges --}}
            @if(request('search') || request('kategori') || request('stok_status'))
            <div class="mt-2 d-flex flex-wrap gap-1 align-items-center">
                <small class="text-muted me-1">Filter aktif:</small>
                @if(request('search'))
                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-2 py-1">
                        <i class="bi bi-search me-1"></i>{{ request('search') }}
                    </span>
                @endif
                @if(request('kategori'))
                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1">
                        <i class="bi bi-tag me-1"></i>{{ request('kategori') }}
                    </span>
                @endif
                @if(request('stok_status'))
                    <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-2 py-1">
                        <i class="bi bi-box me-1"></i>{{ ucfirst(request('stok_status')) }}
                    </span>
                @endif
            </div>
            @endif
        </form>
    </div>
    
    <div class="card-body p-0">
        @if($buku->isEmpty())
            <div class="text-center py-5 text-muted">
                <i class="bi bi-book display-4 opacity-50 mb-3 d-block"></i>
                <p>Tidak ada buku yang sesuai filter.</p>
                <a href="{{ route('admin.buku.index') }}" class="btn btn-outline-secondary mt-2">Reset Filter</a>
            </div>
        @else
            {{-- Result info --}}
            <div class="px-3 py-2 border-bottom bg-light d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    Menampilkan <strong>{{ $buku->firstItem() }}–{{ $buku->lastItem() }}</strong>
                    dari <strong>{{ $buku->total() }}</strong> buku
                </small>
                <div class="d-flex gap-3">
                    <small class="text-success"><i class="bi bi-check-circle-fill me-1"></i>{{ $totalTersedia }} Tersedia</small>
                    <small class="text-danger"><i class="bi bi-x-circle-fill me-1"></i>{{ $totalHabis }} Habis</small>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-secondary small">
                        <tr>
                            <th width="5%" class="ps-4">NO</th>
                            <th>KODE</th>
                            <th width="35%">DETAIL BUKU</th>
                            <th>PENGARANG</th>
                            <th>KATEGORI</th>
                            <th>STOK</th>
                            <th width="12%" class="text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($buku as $item)
                        <tr>
                            <td class="ps-4 text-muted">{{ $buku->firstItem() + $loop->index }}</td>
                            <td><span class="badge bg-light text-dark border font-monospace">{{ $item->kode_buku }}</span></td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    @if($item->cover)
                                        <img src="{{ Storage::url($item->cover) }}" alt="Cover" class="rounded shadow-sm object-fit-cover" style="width: 45px; height: 60px;">
                                    @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center flex-shrink-0 shadow-sm border" style="width: 45px; height: 60px;">
                                            <i class="bi bi-book text-muted opacity-50"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="fw-bold text-dark">{{ $item->judul }}</div>
                                        <div class="small text-muted">{{ $item->penerbit }} ({{ $item->tahun_terbit }})</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $item->pengarang }}</td>
                            <td>
                                <a href="{{ route('admin.buku.index', array_merge(request()->query(), ['kategori' => $item->kategori])) }}"
                                   class="badge bg-primary bg-opacity-10 text-primary text-decoration-none"
                                   title="Filter kategori ini">
                                    {{ $item->kategori }}
                                </a>
                            </td>
                            <td>
                                @if($item->stok > 0)
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25">{{ $item->stok }} Tersedia</span>
                                @else
                                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25">Habis</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.buku.show', $item->id) }}" class="btn btn-info text-white" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.buku.edit', $item->id) }}" class="btn btn-warning text-white" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger" onclick="confirmDelete(`{{ route('admin.buku.destroy', $item->id) }}`)" title="Hapus">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($buku->hasPages())
            <div class="card-footer bg-white py-3 border-top d-flex justify-content-end">
                {{ $buku->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
            @endif
        @endif
    </div>
</div>
@endsection

{{-- Modal Import Excel --}}
@push('scripts')
<div class="modal fade" id="importModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg" style="border-radius:16px;">
      <div class="modal-body p-4">
        <div class="text-center mb-4">
            <div class="mx-auto bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mb-3" style="width:80px;height:80px;">
                <i class="bi bi-file-earmark-excel text-success" style="font-size:2.5rem;"></i>
            </div>
            <h5 class="fw-bold mb-1">Import Data Buku</h5>
            <p class="text-muted small mb-0">Upload file Excel untuk menambahkan banyak buku sekaligus</p>
        </div>

        <div class="bg-light rounded-3 p-3 mb-4">
            <div class="d-flex align-items-start gap-2 mb-2">
                <i class="bi bi-info-circle-fill text-primary mt-1"></i>
                <div class="small">
                    <strong>Format kolom yang diperlukan:</strong><br>
                    <code>kode_buku, judul, pengarang, penerbit, tahun_terbit, kategori, deskripsi, stok</code>
                </div>
            </div>
            <div class="d-flex align-items-start gap-2">
                <i class="bi bi-exclamation-triangle-fill text-warning mt-1"></i>
                <div class="small">Jika <strong>kode_buku</strong> sudah ada, data buku tersebut akan <strong>diperbarui</strong>, bukan digandakan.</div>
            </div>
        </div>

        <form action="{{ route('admin.buku.import') }}" method="POST" enctype="multipart/form-data" id="importForm">
            @csrf
            <div class="mb-4">
                <label class="form-label fw-semibold">Pilih File Excel <span class="text-danger">*</span></label>
                <input type="file" name="file_excel" id="file_excel" class="form-control @error('file_excel') is-invalid @enderror"
                    accept=".xlsx,.xls,.csv" required>
                @error('file_excel')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text text-muted small mt-1"><i class="bi bi-info-circle"></i> Format: .xlsx, .xls, .csv — Maks 5MB</div>
            </div>
            <div class="d-flex gap-2 justify-content-between align-items-center">
                <a href="{{ route('admin.buku.template') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-download me-1"></i> Unduh Template
                </a>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-light px-4 fw-medium" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success px-4 fw-medium text-white" id="importBtn">
                        <i class="bi bi-upload me-1"></i> Import Sekarang
                    </button>
                </div>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
    // Show loading state on submit
    document.getElementById('importForm').addEventListener('submit', function() {
        const btn = document.getElementById('importBtn');
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Mengimport...';
        btn.disabled = true;
    });

    // Auto-open modal if there's a validation error on file_excel
    @if($errors->has('file_excel'))
        var importModal = new bootstrap.Modal(document.getElementById('importModal'));
        importModal.show();
    @endif
</script>
@endpush
