<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi Peminjaman</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; color: #1e293b; margin: 0; padding: 20px; }
        .header { text-align: center; border-bottom: 2px solid #4f46e5; padding-bottom: 12px; margin-bottom: 20px; }
        .header h2 { margin: 0; font-size: 16px; color: #4f46e5; }
        .header p { margin: 4px 0 0; color: #64748b; font-size: 10px; }
        .meta { margin-bottom: 16px; font-size: 10px; color: #64748b; }
        table { width: 100%; border-collapse: collapse; }
        thead tr { background-color: #4f46e5; color: #fff; }
        thead th { padding: 8px 10px; text-align: left; font-size: 10px; }
        tbody tr:nth-child(even) { background-color: #f1f5f9; }
        tbody td { padding: 7px 10px; border-bottom: 1px solid #e2e8f0; }
        .badge { padding: 2px 8px; border-radius: 4px; font-size: 9px; font-weight: bold; }
        .badge-primary { background:#dbeafe; color:#1d4ed8; }
        .badge-danger  { background:#fee2e2; color:#dc2626; }
        .badge-success { background:#dcfce7; color:#16a34a; }
        .footer { text-align: right; margin-top: 16px; font-size: 9px; color: #94a3b8; }
    </style>
</head>
<body>
    <div class="header">
        <h2>📚 Laporan Transaksi Peminjaman Buku</h2>
        <p>Sistem Manajemen Perpustakaan &bull; Dicetak: {{ now()->format('d M Y, H:i') }} WIB</p>
    </div>
    <div class="meta">
        Total Data: <strong>{{ $transaksi->count() }}</strong>
        @if($status !== 'all') &bull; Filter Status: <strong>{{ ucfirst($status) }}</strong> @endif
    </div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Peminjam</th>
                <th>Buku</th>
                <th>Tgl Pinjam</th>
                <th>Batas Kembali</th>
                <th>Tgl Kembali</th>
                <th>Status</th>
                <th>Denda</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi as $i => $item)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>
                    <strong>{{ $item->anggota->nama ?? '-' }}</strong><br>
                    <span style="color:#64748b;">{{ $item->anggota->nis ?? '' }}</span>
                </td>
                <td>
                    <strong>{{ $item->buku->judul ?? '-' }}</strong><br>
                    <span style="color:#64748b;">{{ $item->buku->kode_buku ?? '' }}</span>
                </td>
                <td>{{ $item->tgl_pinjam ? $item->tgl_pinjam->format('d/m/Y') : '-' }}</td>
                <td>{{ $item->tgl_kembali_rencana ? $item->tgl_kembali_rencana->format('d/m/Y') : '-' }}</td>
                <td>{{ $item->tgl_kembali_aktual ? $item->tgl_kembali_aktual->format('d/m/Y') : '-' }}</td>
                <td>
                    @if($item->status === 'dipinjam')
                        <span class="badge badge-primary">Aktif</span>
                    @elseif($item->status === 'terlambat')
                        <span class="badge badge-danger">Terlambat</span>
                    @else
                        <span class="badge badge-success">Selesai</span>
                    @endif
                </td>
                <td>{{ $item->denda > 0 ? 'Rp '.number_format($item->denda,0,',','.') : '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer">Dokumen ini digenerate otomatis oleh Sistem Perpustakaan</div>
</body>
</html>
