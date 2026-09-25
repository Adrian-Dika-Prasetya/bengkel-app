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

    public function create()
    {
        $pelanggans = Pelanggan::orderBy('nama')->get();

        return view('kendaraans.create', compact('pelanggans'));
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

        return redirect()->route('kendaraans.index')->with('success', 'Kendaraan berhasil ditambahkan!');
    }

    public function edit(Kendaraan $kendaraan)
    {
        $pelanggans = Pelanggan::orderBy('nama')->get();

        return view('kendaraans.edit', compact('kendaraan', 'pelanggans'));
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

        return redirect()->route('kendaraans.index')->with('success', 'Data kendaraan berhasil diperbarui!');
    }

    public function destroy(Kendaraan $kendaraan)
    {
        if ($kendaraan->servises()->exists()) {
            return redirect()->route('kendaraans.index')->withErrors([
                'kendaraan' => "Kendaraan '{$kendaraan->plat_nomor}' memiliki riwayat servis, tidak dapat dihapus.",
            ]);
        }

        $kendaraan->delete();

        return redirect()->back()->with('success', 'Kendaraan berhasil dihapus!');
    }
}
