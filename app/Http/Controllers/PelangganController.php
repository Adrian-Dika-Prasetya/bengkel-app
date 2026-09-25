<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function create()
    {
        return view('pelanggans.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'alamat' => 'nullable|string|max:255',
        ]);

        Pelanggan::create($request->only(['nama', 'no_hp', 'alamat']));

        return redirect()->route('kendaraans.index')->with('success', 'Pelanggan berhasil ditambahkan!');
    }

    public function destroy(Pelanggan $pelanggan)
    {
        if ($pelanggan->kendaraans()->exists()) {
            return redirect()->back()->withErrors([
                'pelanggan' => 'Pelanggan masih memiliki kendaraan, hapus kendaraannya terlebih dahulu.',
            ]);
        }

        $pelanggan->delete();

        return redirect()->back()->with('success', 'Pelanggan berhasil dihapus!');
    }
}
