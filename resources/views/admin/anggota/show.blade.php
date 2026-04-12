@extends('layouts.admin')

@section('title', 'Profil Anggota')
@section('page-title', 'Profil Anggota')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h4 fw-bold mb-1">Profil & Riwayat Pinjaman</h2>
        <p class="text-muted mb-0" style="font-size: 14px;">Detail informasi terkait anggota perpustakaan</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.anggota.edit', $anggota->id) }}" class="btn btn-warning text-white shadow-sm">
            <i class="bi bi-pencil-square me-1"></i> Edit
        </a>
        <a href="{{ route('admin.anggota.index') }}" class="btn btn-outline-secondary shadow-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card shadow-sm border-0 mb-4 h-100">
            <div class="card-body p-4 text-center">
                <div class="mx-auto bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 100px; height: 100px; font-size: 2.5rem;">
                    <i class="bi bi-person-bounding-box"></i>
                </div>
                <h4 class="fw-bold mb-1">{{ $anggota->nama }}</h4>
                <div class="text-muted mb-3"><i class="bi bi-mortarboard me-1"></i> Kelas {{ $anggota->kelas }}</div>
                
                <hr class="text-muted opacity-25 mx-3 mb-4">
                
                <div class="text-start px-2">
                    <div class="mb-3">
                        <div class="text-muted small">Nomor Induk Siswa (NIS)</div>
                        <div class="fw-semibold font-monospace" style="font-size: 1.1rem;">{{ $anggota->nis }}</div>
                    </div>
                    <div class="mb-3">
                        <div class="text-muted small">Nomor WhatsApp / Telp</div>
                        <div class="fw-semibold">{{ $anggota->no_telp ?: 'Belum ditambahkan' }}</div>
                    </div>
                    <div class="mb-0">
                        <div class="text-muted small">Alamat Tersimpan</div>
                        <div class="fw-medium text-dark">{{ $anggota->alamat ?: 'Belum ditambahkan' }}</div>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-light py-3 border-top-0 rounded-bottom">
                <div class="d-flex justify-content-between px-2 text-center text-muted small">
                    <div>
                        <div class="fw-bold text-dark fs-6">{{ $anggota->peminjaman->count() }}</div>
                        Total Transaksi
                    </div>
                    <div>
                        <div class="fw-bold text-danger fs-6">{{ $anggota->peminjaman->where('status', 'dipinjam')->count() }}</div>
                        Sedang Dipinjam
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0"><i class="bi bi-clock-history me-2 text-primary"></i>Riwayat Peminjaman Buku</h5>
            </div>
            <div class="card-body p-0">
                @if($anggota->peminjaman->isEmpty())
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-journal-x display-4 opacity-50 mb-3 d-block"></i>
                        <p>Anggota ini belum pernah meminjam buku.</p>
                    </div>
                @else
                    <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light text-secondary small sticky-top">
                                <tr>
                                    <th class="ps-4">BUKU</th>
                                    <th>WAKTU PINJAM</th>
                                    <th>STATUS</th>
                                    <th class="text-end pe-4">DENDA (Rp)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($anggota->peminjaman as $trx)
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="fw-bold text-dark text-truncate" style="max-width: 250px;" title="{{ $trx->buku->judul }}">{{ $trx->buku->judul }}</div>
                                        <div class="small text-muted font-monospace">{{ $trx->buku->kode_buku }}</div>
                                    </td>
                                    <td>
                                        <div class="small">
                                            <i class="bi bi-calendar-event text-muted me-1"></i> Pinjam: <span class="fw-medium">{{ $trx->tgl_pinjam->format('d M Y') }}</span>
                                        </div>
                                        <div class="small mt-1">
                                            <i class="bi bi-calendar-check text-muted me-1"></i> 
                                            @if($trx->status === 'dikembalikan')
                                                Kembali: <span class="fw-medium text-success">{{ $trx->tgl_kembali_aktual ? $trx->tgl_kembali_aktual->format('d M Y') : '-' }}</span>
                                            @else
                                                Deadline: <span class="fw-medium text-danger">{{ $trx->tgl_kembali_rencana->format('d M Y') }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if($trx->status === 'dipinjam')
                                            @if($trx->isTerlambat())
                                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25"><i class="bi bi-exclamation-triangle me-1"></i>Terlambat</span>
                                            @else
                                                <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 text-dark"><i class="bi bi-hourglass-split me-1"></i>Dipinjam</span>
                                            @endif
                                        @else
                                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25"><i class="bi bi-check-circle me-1"></i>Selesai</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4 fw-medium font-monospace {{ $trx->denda > 0 ? 'text-danger' : 'text-muted' }}">
                                        {{ $trx->denda > 0 ? number_format($trx->denda, 0, ',', '.') : '-' }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
