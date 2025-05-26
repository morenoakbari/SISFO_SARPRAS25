<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PengembalianController extends Controller
{
    /**
     * Menampilkan daftar pengembalian barang.
     */
    public function index()
    {
        // Ambil data dari model Peminjaman, bukan Pengembalian
        $pengembalian = Peminjaman::with(['user', 'barang'])
            ->whereIn('status', ['dipinjam', 'dikembalikan']) // tampilkan yang relevan
            ->get();

        return view('dashboard.pengembalian', compact('pengembalian'));
    }



    /**
     * Menangani proses pengembalian barang.
     */
    public function updateStatus(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($request->status === 'dikembalikan' && $peminjaman->status === 'dipinjam') {
            // Update status menjadi dikembalikan
            $peminjaman->status = 'dikembalikan';

            // Update stok barang (kembalikan jumlah)
            if ($peminjaman->barang) {
                $peminjaman->barang->stok += $peminjaman->jumlah;
                $peminjaman->barang->save();
            }

            // Simpan tanggal kembali
            $peminjaman->tanggal_kembali = now();
        }

        $peminjaman->save();

        return back()->with('success', 'Status pengembalian berhasil diperbarui.');
    }
}
