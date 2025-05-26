<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class BarangController extends Controller
{
    public function __construct()
    {
        // Semua method memerlukan autentikasi
        $this->middleware('auth');

        // Hanya admin yang boleh store, update, destroy
        $this->middleware('admin')->only(['store', 'edit', 'update', 'destroy']);
    }

    public function index()
    {
        $barangs = Barang::with('kategori')->latest()->get();
        $kategoris = Kategori::all();
        return view('dashboard.barang', compact('barangs', 'kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'        => 'required',
            'stok'        => 'required|integer',
            'kategori_id' => 'required|exists:kategoris,id',
            'foto'        => 'nullable|image|max:2048',
        ]);

        $data = $request->only('nama', 'stok', 'kategori_id');

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('foto-barang', 'public');
        }

        Barang::create($data);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan!');
    }

    public function edit(Barang $barang)
    {
        $kategoris = Kategori::all(); // Mengambil semua kategori
        return view('dashboard.edit-barang', compact('barang', 'kategoris'));
    }


    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'nama' => 'nullable|string',
            'stok' => 'required|integer',
            'kategori_id' => 'required|exists:kategoris,id',
            'foto' => 'nullable|image|max:2048',
        ]);

        $data = $request->only('nama', 'stok', 'kategori_id');

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($barang->foto) {
                Storage::disk('public')->delete($barang->foto);
            }

            // Simpan foto baru
            $data['foto'] = $request->file('foto')->store('foto-barang', 'public');
        }

        // Update barang
        $barang->update($data);

        // Redirect ke halaman daftar barang dengan pesan sukses
        return redirect()->route('barang.index')->with('success', 'Barang berhasil diubah!');
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);

        // Cek apakah masih ada peminjaman yang BELUM dikembalikan
        if ($barang->peminjamans()->whereNull('tanggal_kembali')->exists()) {
            return redirect()->route('barang.index')->with('error', 'Barang tidak bisa dihapus karena masih sedang dipinjam.');
        }

        // Hapus foto jika ada
        if ($barang->foto) {
            Storage::disk('public')->delete($barang->foto);
        }

        $barang->delete();

        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus.');
    }
}
