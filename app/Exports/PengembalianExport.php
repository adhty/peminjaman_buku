<?php

namespace App\Exports;

use App\Models\Peminjaman;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class PengembalianExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithTitle, ShouldAutoSize
{
    public function title(): string
    {
        return 'Data Pengembalian';
    }

    public function query()
    {
        return Peminjaman::with(['anggota', 'buku'])
            ->where('status', 'dikembalikan')
            ->orderByDesc('tgl_kembali_aktual');
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Peminjam',
            'NIS',
            'Judul Buku',
            'Kode Buku',
            'Tanggal Pinjam',
            'Batas Kembali',
            'Tgl Dikembalikan',
            'Keterlambatan (Hari)',
            'Denda (Rp)',
        ];
    }

    public function map($row): array
    {
        static $no = 0;
        $no++;
        $terlambat = 0;
        if ($row->tgl_kembali_aktual && $row->tgl_kembali_aktual->gt($row->tgl_kembali_rencana)) {
            $terlambat = $row->tgl_kembali_rencana->diffInDays($row->tgl_kembali_aktual);
        }
        return [
            $no,
            $row->anggota->nama ?? '-',
            $row->anggota->nis ?? '-',
            $row->buku->judul ?? '-',
            $row->buku->kode_buku ?? '-',
            $row->tgl_pinjam ? $row->tgl_pinjam->format('d/m/Y') : '-',
            $row->tgl_kembali_rencana ? $row->tgl_kembali_rencana->format('d/m/Y') : '-',
            $row->tgl_kembali_aktual ? $row->tgl_kembali_aktual->format('d/m/Y') : '-',
            $terlambat,
            $row->denda ?? 0,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF22C55E']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }
}
