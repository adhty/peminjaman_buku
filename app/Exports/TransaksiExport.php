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

class TransaksiExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithTitle, ShouldAutoSize
{
    protected string $status;

    public function __construct(string $status = 'all')
    {
        $this->status = $status;
    }

    public function title(): string
    {
        return 'Data Peminjaman';
    }

    public function query()
    {
        $q = Peminjaman::with(['anggota', 'buku'])->latest();
        if ($this->status !== 'all') {
            $q->where('status', $this->status);
        }
        return $q;
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
            'Tgl Kembali Aktual',
            'Status',
            'Denda (Rp)',
        ];
    }

    public function map($row): array
    {
        static $no = 0;
        $no++;
        return [
            $no,
            $row->anggota->nama ?? '-',
            $row->anggota->nis ?? '-',
            $row->buku->judul ?? '-',
            $row->buku->kode_buku ?? '-',
            $row->tgl_pinjam ? $row->tgl_pinjam->format('d/m/Y') : '-',
            $row->tgl_kembali_rencana ? $row->tgl_kembali_rencana->format('d/m/Y') : '-',
            $row->tgl_kembali_aktual ? $row->tgl_kembali_aktual->format('d/m/Y') : '-',
            ucfirst($row->status),
            $row->denda ?? 0,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF4F46E5']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }
}
