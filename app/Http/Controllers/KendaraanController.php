<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class KendaraanController extends Controller
{
    public function index()
    {
        $kendaraans = Kendaraan::with('pelanggan')->latest()->get();
        $pelanggans = Pelanggan::with('kendaraans')->orderBy('nama')->get();

        return view('kendaraans.index', compact('kendaraans', 'pelanggans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pelanggan_id' => ['required', 'exists:pelanggans,id'],
            'plat_nomor' => ['required', 'string', 'max:20', 'unique:kendaraans,plat_nomor'],
            'merk' => 'required|string|max:100',
            'tipe' => 'required|string|max:100',
        ]);

        Kendaraan::create($request->only(['pelanggan_id', 'plat_nomor', 'merk', 'tipe']));

        return redirect()->back()->with('success', 'Kendaraan berhasil ditambahkan!');
    }

    public function update(Request $request, Kendaraan $kendaraan)
    {
        $request->validate([
            'pelanggan_id' => ['required', 'exists:pelanggans,id'],
            'plat_nomor' => ['required', 'string', 'max:20', 'unique:kendaraans,plat_nomor,'.$kendaraan->id],
            'merk' => 'required|string|max:100',
            'tipe' => 'required|string|max:100',
        ]);

        $kendaraan->update($request->only(['pelanggan_id', 'plat_nomor', 'merk', 'tipe']));

        return redirect()->back()->with('success', 'Data kendaraan berhasil diperbarui!');
    }

    public function destroy(Kendaraan $kendaraan)
    {
        $kendaraan->delete();

        return redirect()->back()->with('success', 'Kendaraan berhasil dihapus!');
    }
}
