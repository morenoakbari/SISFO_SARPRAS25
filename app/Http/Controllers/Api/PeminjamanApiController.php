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
        return Peminjaman::with(['barang', 'user'])
            ->where('user_id', Auth::id())
            ->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'barang_id' => 'required|exists:barangs,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'nullable|date|after_or_equal:tanggal_pinjam',
            'jumlah' => 'required|integer|min:1',
        ]);

        $barang = Barang::findOrFail($request->barang_id);

        if ($request->jumlah > $barang->stok) {
            return response()->json(['message' => 'Jumlah melebihi stok yang tersedia'], 400);
        }

        $peminjaman = Peminjaman::create([
            'user_id' => $request->user_id,
            'barang_id' => $request->barang_id,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali, // pastikan ini ada
            'jumlah' => $request->jumlah,
            'status' => 'dipinjam'
        ]);

        return response()->json(['message' => 'Peminjaman berhasil dibuat', 'data' => $peminjaman], 201);
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
