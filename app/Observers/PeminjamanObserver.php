<?php
// app/Observers/PeminjamanObserver.php
namespace App\Observers;

use App\Models\Peminjaman;

class PeminjamanObserver
{
    public function updated(Peminjaman $peminjaman)
    {
        // Cek kalau status berubah ke 'diterima'
        if ($peminjaman->isDirty('status') && $peminjaman->status === 'diterima') {
            $barang = $peminjaman->barang;

            if ($barang && $barang->stok >= $peminjaman->jumlah) {
                $barang->stok -= $peminjaman->jumlah;
                $barang->save();
            } else {
                // Optional: Lempar error kalau stok tidak cukup
                throw new \Exception('Stok tidak mencukupi saat peminjaman disetujui.');
            }
        }
    }
}
