<?php

// app/Http/Controllers/Api/PengembalianApiController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PengembalianApiController extends Controller
{
    public function kembalikan($id)
    {
        Log::info("Mencari peminjaman dengan ID: " . $id);

        $peminjaman = Peminjaman::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('status', 'diterima')
            ->first();

        if (!$peminjaman) {
            Log::error("Peminjaman dengan ID $id tidak ditemukan atau statusnya bukan 'diterima'.");
            return response()->json(['message' => 'Barang tidak ditemukan atau status tidak sesuai.'], 404);
        }

        // kembalikan stok
        $peminjaman->barang->increment('stok', $peminjaman->jumlah);

        // Membuat catatan pengembalian di tabel pengembalians
        Pengembalian::create([
            'peminjaman_id' => $peminjaman->id,
            'user_id' => Auth::id(),
            'barang_id' => $peminjaman->barang_id,
            'jumlah' => $peminjaman->jumlah,
            'tanggal_kembali' => now(),
        ]);

        // update status & tanggal_kembali
        $peminjaman->update([
            'status' => 'dikembalikan',
            'tanggal_kembali' => now(),
        ]);

        Log::info("Barang berhasil dikembalikan: " . $id);

        return response()->json(['message' => 'Barang berhasil dikembalikan.']);
    }
}
