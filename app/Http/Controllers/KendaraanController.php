<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use Illuminate\Http\Request;

class KendaraanController extends Controller
{
    public function index()
    {
        $kendaraans = Kendaraan::latest()->get();

        return view('kendaraans.index', compact('kendaraans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'plat_nomor' => ['required', 'string', 'max:20', 'unique:kendaraans,plat_nomor'],
            'nama_pemilik' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'merk_tipe' => 'required|string|max:255',
        ]);

        Kendaraan::create($request->all());

        return redirect()->back()->with('success', 'Kendaraan berhasil ditambahkan!');
    }

    public function update(Request $request, Kendaraan $kendaraan)
    {
        $request->validate([
            'plat_nomor' => ['required', 'string', 'max:20', 'unique:kendaraans,plat_nomor,'.$kendaraan->id],
            'nama_pemilik' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'merk_tipe' => 'required|string|max:255',
        ]);

        $kendaraan->update($request->all());

        return redirect()->back()->with('success', 'Data kendaraan berhasil diperbarui!');
    }

    public function destroy(Kendaraan $kendaraan)
    {
        $kendaraan->delete();

        return redirect()->back()->with('success', 'Kendaraan berhasil dihapus!');
    }
}
