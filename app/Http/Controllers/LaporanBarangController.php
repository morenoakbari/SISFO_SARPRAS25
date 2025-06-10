<?php

namespace App\Http\Controllers;

use App\Models\Barang;

class LaporanBarangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Semua pengguna harus login
    }

    public function index()
    {
        $barangs = Barang::with('kategori')->get();
        return view('dashboard.laporan-barang', compact('barangs'));
    }
}
