<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;

class LaporanPengembalianController extends Controller
{
    /**
     * Menampilkan laporan pengembalian.
     */
    public function index()
    {
        // Ambil data peminjaman yang sudah dikembalikan
        $pengembalian = Peminjaman::with(['user', 'barang'])
            ->where('status', 'dikembalikan')
            ->get();

        return view('dashboard.laporan-pengembalian', compact('pengembalian'));
    }
}
