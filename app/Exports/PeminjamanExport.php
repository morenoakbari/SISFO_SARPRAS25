<?php

namespace App\Exports;

use App\Models\Peminjaman;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PeminjamanExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Peminjaman::with(['user', 'barang'])->whereIn('status', ['diterima', 'ditolak'])->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Peminjam',
            'Nama Barang',
            'Jumlah',
            'Tanggal Pinjam',
            'Tanggal Kembali',
            'Status'
        ];
    }

    public function map($peminjaman): array
    {
        static $i = 1;
        return [
            $i++,
            $peminjaman->user->name ?? 'Tidak diketahui',
            $peminjaman->barang->nama ?? 'Tidak diketahui',
            $peminjaman->jumlah,
            $peminjaman->tanggal_pinjam,
            $peminjaman->tanggal_kembali,
            ucfirst($peminjaman->status),
        ];
    }
}
