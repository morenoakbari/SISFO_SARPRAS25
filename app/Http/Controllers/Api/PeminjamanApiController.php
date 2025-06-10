<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Barang;
use Illuminate\Support\Facades\Auth;

class PeminjamanApiController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with('barang')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return response()->json([
            'data' => $peminjamans
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'tanggal_kembali' => 'nullable|date|after_or_equal:today',
            'jumlah' => 'required|integer|min:1',
        ]);

        $barang = Barang::findOrFail($request->barang_id);

        if ($request->jumlah > $barang->stok) {
            return response()->json(['message' => 'Jumlah melebihi stok yang tersedia'], 400);
        }

        $peminjaman = Peminjaman::create([
            'user_id' => Auth::id(),
            'barang_id' => $request->barang_id,
            'tanggal_pinjam' => now(), 
            'tanggal_kembali' => $request->tanggal_kembali,
            'jumlah' => $request->jumlah,
            'status' => 'menunggu',
        ]);

        $peminjaman->load('barang');

        return response()->json([
            'message' => 'Peminjaman berhasil dibuat',
            'data' => $peminjaman
        ], 201);
    }


    public function kembalikan($id)
    {
        $peminjaman = Peminjaman::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $peminjaman->update([
            'tanggal_kembali' => now(),
            'status' => 'dikembalikan',
        ]);

        return response()->json(['message' => 'Barang dikembalikan']);
    }
}
