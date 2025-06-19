<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kategori;
use App\Models\Barang;
use App\Models\Peminjaman;

class DashboardController extends Controller
{
    public function index()
    {
        // Mengambil data jumlah users, kategori, dan barang
        $users = User::all();
        $kategoris = Kategori::all();
        $barangs = Barang::all();
        $totalPeminjam = Peminjaman::where('status', 'menunggu')
            ->select('user_id')
            ->distinct()
            ->count();


        // Kirim data ke view dashboard
        return view('dashboard', compact('users', 'kategoris', 'barangs', 'totalPeminjam'));
    }
}
