<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PeminjamanController extends Controller
{
    // public function index()
    // {
    //     $peminjamans = Peminjaman::with(['user', 'barang'])->latest()->get();

    //     foreach ($peminjamans as $peminjaman) {
    //         if (!$peminjaman->barang) {
    //             // Jika tidak ada barang terkait, beri peringatan atau log
    //             Log::warning("Peminjaman dengan ID {$peminjaman->id} tidak memiliki barang terkait.");
    //         }
    //     }

    //     return view('dashboard.peminjaman', compact('peminjamans'));
    // }

    public function index()
    {
        $peminjamans = Peminjaman::with(['user', 'barang'])
            ->where('status', 'menunggu') 
            ->latest()
            ->get();

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
            'barang_id' => 'required',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
        ]);

        Peminjaman::create([
            'user_id' => auth()->id(),
            'barang_id' => $request->barang_id,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status' => 'menunggu', // ini penting!
        ]);

        return redirect()->back()->with('success', 'Peminjaman berhasil diajukan.');
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

    public function apiRiwayat()
    {
        $peminjamans = Peminjaman::with('barang')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return response()->json([
            'data' => $peminjamans
        ]);
    }
}
