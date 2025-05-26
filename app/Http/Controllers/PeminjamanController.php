<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with(['user', 'barang'])->latest()->get();

        foreach ($peminjamans as $peminjaman) {
            if (!$peminjaman->barang) {
                // Jika tidak ada barang terkait, beri peringatan atau log
                Log::warning("Peminjaman dengan ID {$peminjaman->id} tidak memiliki barang terkait.");
            }
        }

        return view('dashboard.peminjaman', compact('peminjamans'));
    }

    public function form()
    {
        $barangs = Barang::where('stok', '>', 0)->get(); // hanya barang dengan stok
        return view('dashboard.peminjaman_form', compact('barangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'tanggal_pinjam' => 'required|date|after_or_equal:today',
            'jumlah' => 'required|integer|min:1',
        ]);

        $barang = Barang::findOrFail($request->barang_id);

        if ($barang->stok < $request->jumlah) {
            return back()->with('error', 'Jumlah melebihi stok tersedia.');
        }

        // Tidak mengurangi stok di sini — hanya simpan permintaan
        Peminjaman::create([
            'user_id' => Auth::id(),
            'barang_id' => $barang->id,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'status' => 'dipinjam', // Menunggu persetujuan
            'jumlah' => $request->jumlah,
        ]);

        return redirect()->route('peminjaman.index')->with('success', 'Permintaan peminjaman berhasil dikirim.');
    }

    public function updateStatus(Request $request, Peminjaman $peminjaman)
    {
        $request->validate(['status' => 'required|in:diterima,ditolak']);

        if ($request->status === 'diterima') {
            $barang = $peminjaman->barang;

            if ($barang->stok < $peminjaman->jumlah) {
                return back()->with('error', 'Stok barang tidak mencukupi untuk menyetujui peminjaman ini.');
            }

            // Kurangi stok hanya saat disetujui
            $barang->stok -= $peminjaman->jumlah;
            $barang->save();
        }

        $peminjaman->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status berhasil diperbarui.');
    }
}
