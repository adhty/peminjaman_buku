<?php

namespace App\Imports;

use App\Models\Buku;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\WithSkipDuplicates;

class BukuImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError
{
    use SkipsErrors;

    private int $imported = 0;
    private int $skipped  = 0;

    public function model(array $row): ?Buku
    {
        // Lewati baris kosong
        if (empty($row['judul']) && empty($row['kode_buku'])) {
            return null;
        }

        // Jika kode sudah ada, update stok saja (upsert style)
        $existing = Buku::where('kode_buku', $row['kode_buku'])->first();
        if ($existing) {
            $existing->update([
                'judul'        => $row['judul']        ?? $existing->judul,
                'pengarang'    => $row['pengarang']    ?? $existing->pengarang,
                'penerbit'     => $row['penerbit']     ?? $existing->penerbit,
                'tahun_terbit' => $row['tahun_terbit'] ?? $existing->tahun_terbit,
                'kategori'     => $row['kategori']     ?? $existing->kategori,
                'deskripsi'    => $row['deskripsi']    ?? $existing->deskripsi,
                'stok'         => $row['stok']         ?? $existing->stok,
            ]);
            $this->skipped++;
            return null;
        }

        $this->imported++;

        return new Buku([
            'kode_buku'    => $row['kode_buku'],
            'judul'        => $row['judul'],
            'pengarang'    => $row['pengarang']    ?? '-',
            'penerbit'     => $row['penerbit']     ?? '-',
            'tahun_terbit' => $row['tahun_terbit'] ?? date('Y'),
            'kategori'     => $row['kategori']     ?? 'Umum',
            'deskripsi'    => $row['deskripsi']    ?? null,
            'stok'         => $row['stok']         ?? 1,
        ]);
    }

    public function rules(): array
    {
        return [
            'kode_buku' => 'required',
            'judul'     => 'required',
            'stok'      => 'nullable|integer|min:0',
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            'kode_buku.required' => 'Kolom kode_buku wajib diisi.',
            'judul.required'     => 'Kolom judul wajib diisi.',
        ];
    }

    public function getImportedCount(): int { return $this->imported; }
    public function getSkippedCount(): int  { return $this->skipped;  }
}
