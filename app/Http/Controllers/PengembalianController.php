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
        $pengembalian = Pengembalian::with(['user', 'barang', 'peminjaman'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard.pengembalian', compact('pengembalian'));
    }



    /**
     * Menangani proses pengembalian barang.
     */
    public function updateStatus(Request $request, $id)
    {
        $pengembalian = Pengembalian::findOrFail($id);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $path = $file->store('pengembalian', 'public'); // folder storage/app/public/pengembalian
            $pengembalian->foto = $path;
        }

        $status = $request->input('status');

        if ($status === 'diterima') {
            $pengembalian->status = 'diterima';
            $pengembalian->tanggal_kembali = now();

            // Update stok barang
            $pengembalian->barang->increment('stok', $pengembalian->jumlah);

            // Update juga status di peminjaman
            $pengembalian->peminjaman->update([
                'status' => 'dikembalikan',
                'tanggal_kembali' => now(),
            ]);
        } elseif ($status === 'ditolak') {
            $pengembalian->status = 'ditolak';
        }

        $pengembalian->save();

        return back()->with('success', 'Status pengembalian berhasil diperbarui.');
    }

    public function setuju($id)
    {
        $pengembalian = Pengembalian::findOrFail($id);
        $pengembalian->status = 'diterima';
        $pengembalian->tanggal_kembali = now(); // opsional

        // Update status peminjaman juga
        if ($pengembalian->peminjaman) {
            $pengembalian->peminjaman->update([
                'status' => 'dikembalikan',
                'tanggal_kembali' => now(),
            ]);
        }

        // Update stok barang
        $pengembalian->barang->increment('stok', $pengembalian->jumlah);

        $pengembalian->save();

        return redirect()->back()->with('success', 'Pengembalian telah disetujui.');
    }

    public function tolak($id)
    {
        $pengembalian = Pengembalian::findOrFail($id);
        $pengembalian->status = 'ditolak';
        $pengembalian->save();

        return redirect()->back()->with('success', 'Pengembalian telah ditolak.');
    }
}
