<?php

namespace App\Http\Controllers;

use App\Models\Sparepart;
use Illuminate\Http\Request;

class SparepartController extends Controller
{
    public function index()
    {
        $spareparts = Sparepart::latest()->get();
        return view('spareparts.index', compact('spareparts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required|unique:spareparts',
            'nama_barang' => 'required',
            'stok' => 'required|numeric',
            'harga_jual' => 'required|numeric',
        ]);

        Sparepart::create($request->all());

        return redirect()->back()->with('success', 'Sparepart berhasil ditambahkan!');
    }

    public function update(Request $request, Sparepart $sparepart)
    {
        $request->validate([
            'nama_barang' => 'required',
            'stok' => 'required|numeric',
            'harga_jual' => 'required|numeric',
        ]);

        $sparepart->update($request->all());

        return redirect()->back()->with('success', 'Sparepart berhasil diperbarui!');
    }

    public function destroy(Sparepart $sparepart)
    {
        $sparepart->delete();
        return redirect()->back()->with('success', 'Sparepart berhasil dihapus!');
    }
}