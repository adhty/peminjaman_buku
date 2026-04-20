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

        $data = [
            'kode_buku'    => $row['kode_buku'],
            'judul'        => $row['judul'],
            'pengarang'    => $row['pengarang']    ?? '-',
            'penerbit'     => $row['penerbit']     ?? '-',
            'tahun_terbit' => $row['tahun_terbit'] ?? date('Y'),
            'deskripsi'    => $row['deskripsi']    ?? null,
            'stok'         => $row['stok']         ?? 1,
        ];

        // Handle string kategori (kompatibilitas lama)
        $kategoriRaw = $row['kategori'] ?? 'Umum';
        $data['kategori'] = $kategoriRaw; // Simpan as-is di kolom kategori

        $buku = Buku::where('kode_buku', $row['kode_buku'])->first();
        
        if ($existing = $buku) {
            $existing->update($data);
            $this->skipped++;
            $buku = $existing;
        } else {
            $buku = Buku::create($data);
            $this->imported++;
        }

        // --- SYNC MANY TO MANY CATEGORIES ---
        // Split kategori by comma/semicolon (e.g., "Novel, Sains; Horor")
        $names = preg_split('/[,;]/', $kategoriRaw);
        $kategoriIds = [];

        foreach ($names as $name) {
            $name = trim($name);
            if ($name !== '') {
                $kat = \App\Models\Kategori::firstOrCreate(
                    ['nama' => $name],
                    ['slug' => \Illuminate\Support\Str::slug($name)]
                );
                $kategoriIds[] = $kat->id;
            }
        }

        if (!empty($kategoriIds)) {
            $buku->kategoris()->sync($kategoriIds);
        }

        return null; // Return null karena kita sudah handle create/update secara manual
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
