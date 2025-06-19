<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PengembalianApiController extends Controller
{
    public function kembalikan(Request $request, $id)
    {
        Log::info("Mencari peminjaman dengan ID: " . $id);

        // Ambil data peminjaman yang valid
        $peminjaman = Peminjaman::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('status', 'diterima') // hanya bisa kembalikan yang disetujui
            ->first();

        if (!$peminjaman) {
            Log::error("Peminjaman ID $id tidak ditemukan atau tidak valid.");
            return response()->json(['message' => 'Peminjaman tidak ditemukan atau tidak valid.'], 404);
        }

        // Validasi request
        $validated = $request->validate([
            'keterangan' => 'nullable|string|max:255',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Proses upload foto jika ada
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('pengembalian', 'public');
            Log::info('Foto berhasil diupload ke: ' . $fotoPath);
        } else {
            Log::info('Tidak ada foto yang dikirim.');
        }

        // Buat data pengembalian
        $pengembalian = Pengembalian::create([
            'peminjaman_id'   => $peminjaman->id,
            'user_id'         => Auth::id(),
            'barang_id'       => $peminjaman->barang_id,
            'jumlah'          => $peminjaman->jumlah,
            'tanggal_kembali' => now(),
            'keterangan'      => $validated['keterangan'] ?? null,
            'foto'            => $fotoPath,
            'status'          => 'menunggu',
        ]);

        Log::info('Pengembalian berhasil dibuat dengan ID: ' . $pengembalian->id);

        return response()->json([
            'message' => 'Permintaan pengembalian berhasil dikirim. Menunggu persetujuan.',
            'data' => $pengembalian,
        ]);
    }
}
