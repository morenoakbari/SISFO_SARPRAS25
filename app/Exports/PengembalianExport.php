<?php

namespace App\Exports;

use App\Models\Peminjaman;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class PengembalianExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Peminjaman::with(['user', 'barang'])
            ->where('status', 'dikembalikan')
            ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Peminjam',
            'Nama Barang',
            'Jumlah',
            'Tanggal Kembali',
        ];
    }

    public function map($peminjaman): array
    {
        return [
            '', // No akan otomatis diisi Excel
            $peminjaman->user->name ?? 'User tidak tersedia',
            $peminjaman->barang->nama ?? 'Barang tidak tersedia',
            $peminjaman->jumlah,
            $peminjaman->tanggal_kembali
                ? Carbon::parse($peminjaman->tanggal_kembali)->format('Y-m-d')
                : '-',
        ];
    }
}
