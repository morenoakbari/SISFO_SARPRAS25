<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;

class LaporanPeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with(['user', 'barang'])
            ->whereIn('status', ['diterima', 'ditolak'])
            ->latest()
            ->get();

        return view('dashboard.laporan-peminjaman', compact('peminjamans'));
    }
}
