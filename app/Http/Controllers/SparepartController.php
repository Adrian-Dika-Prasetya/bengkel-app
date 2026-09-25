<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Sparepart;
use Illuminate\Http\Request;

class SparepartController extends Controller
{
    public function index()
    {
        $spareparts = Sparepart::with('kategori')->latest()->get();

        return view('spareparts.index', compact('spareparts'));
    }

    public function create()
    {
        $kategoris = Kategori::orderBy('nama')->get();

        return view('spareparts.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required|unique:spareparts',
            'kategori_id' => 'nullable|exists:kategoris,id',
            'nama_barang' => 'required',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'stok_minimal' => 'required|integer|min:0',
        ]);

        Sparepart::create($request->only([
            'kode_barang',
            'kategori_id',
            'nama_barang',
            'harga_beli',
            'harga_jual',
            'stok',
            'stok_minimal',
        ]));

        return redirect()->route('spareparts.index')->with('success', 'Sparepart berhasil ditambahkan!');
    }

    public function edit(Sparepart $sparepart)
    {
        $kategoris = Kategori::orderBy('nama')->get();

        return view('spareparts.edit', compact('sparepart', 'kategoris'));
    }

    public function update(Request $request, Sparepart $sparepart)
    {
        $request->validate([
            'kategori_id' => 'nullable|exists:kategoris,id',
            'nama_barang' => 'required',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'stok_minimal' => 'required|integer|min:0',
        ]);

        $sparepart->update($request->only([
            'kategori_id',
            'nama_barang',
            'harga_beli',
            'harga_jual',
            'stok',
            'stok_minimal',
        ]));

        return redirect()->route('spareparts.index')->with('success', 'Sparepart berhasil diperbarui!');
    }

    public function destroy(Sparepart $sparepart)
    {
        $sparepart->delete();

        return redirect()->back()->with('success', 'Sparepart berhasil dihapus!');
    }
}
