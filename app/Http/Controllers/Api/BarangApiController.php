<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class BarangApiController extends Controller
{
    public function index()
    {
        $barangs = Barang::with('kategori')->latest()->get();
        return response()->json($barangs);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'        => 'required|string',
            'stok'        => 'required|integer',
            'kategori_id' => 'required|exists:kategoris,id',
            'foto'        => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('foto-barang', 'public');
        }

        $barang = Barang::create($validated);

        return response()->json([
            'message' => 'Barang berhasil dibuat!',
            'data' => $barang
        ], 201);
    }

    public function show(Barang $barang)
    {
        return response()->json($barang->load('kategori'));
    }

    public function update(Request $request, Barang $barang)
    {

        $validated = $request->validate([
            'nama'        => 'sometimes|required|string',
            'stok'        => 'sometimes|required|integer',
            'kategori_id' => 'sometimes|required|exists:kategoris,id',
            'foto'        => 'nullable|image|max:2048',
        ]);

        // Simpan foto baru kalau ada file
        if ($request->hasFile('foto')) {
            // Hapus foto lama kalau ada
            if ($barang->foto && Storage::disk('public')->exists($barang->foto)) {
                Storage::disk('public')->delete($barang->foto);
            }

            // Simpan foto baru
            $validated['foto'] = $request->file('foto')->store('foto-barang', 'public');
        }

        $barang->update($validated);

        return response()->json([
            'message' => 'Barang berhasil diupdate!',
            'validated' => $validated,
            'data' => $barang->fresh()
        ]);
    }


    public function destroy(Barang $barang)
    {
        $barang->delete();

        return response()->json([
            'message' => 'Barang berhasil dihapus!'
        ]);
    }
}
