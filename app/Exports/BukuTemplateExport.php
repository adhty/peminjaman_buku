<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BukuTemplateExport implements FromArray, WithHeadings, WithStyles
{
    public function array(): array
    {
        // Contoh data sesuai kolom wajib
        return [
            ['BK001', 'Laskar Pelangi', 'Andrea Hirata', 'Bentang Pustaka', 2005, 'Novel', 'Novel inspiratif dari Belitung', 5],
            ['BK002', 'Bumi Manusia',   'Pramoedya Ananta Toer', 'Lentera Dipantara', 1980, 'Sastra', '', 3],
        ];
    }

    public function headings(): array
    {
        return [
            'kode_buku',
            'judul',
            'pengarang',
            'penerbit',
            'tahun_terbit',
            'kategori',
            'deskripsi',
            'stok',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill'      => ['fillType' => 'solid', 'startColor' => ['rgb' => '4f46e5']],
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }
}
