<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::all();
        return view('dashboard.kategori', compact('kategori'));
    }

    public function store(Request $request)
    {
        
        // Validasi input dari pengguna
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        // Buat kategori baru di database
        Kategori::create([
            'nama' => $request->nama,
        ]);

        // Redirect ke halaman index kategori dengan pesan sukses
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function show(Kategori $kategori)
    {
        // Muat relasi barangs
        $kategori->load('barangs');
        return view('dashboard.kategori_show', compact('kategori'));
    }

    // Hapus kategori
    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }


    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('dashboard.kategori_edit', compact('kategori'));
    }

    // Update kategori
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $kategori = Kategori::findOrFail($id);
        $kategori->update([
            'nama' => $request->nama,
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }
}
