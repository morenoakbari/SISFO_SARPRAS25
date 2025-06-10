<?php

namespace App\Exports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BarangExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Barang::with('kategori')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Barang',
            'Stok',
            'Kategori'
        ];
    }

    public function map($barang): array
    {
        static $i = 1;
        return [
            $i++,
            $barang->nama,
            $barang->stok,
            $barang->kategori->nama ?? 'Tidak ada',
        ];
    }
}
