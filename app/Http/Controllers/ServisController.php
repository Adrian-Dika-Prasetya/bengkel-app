<?php

namespace App\Http\Controllers;

use App\Models\DetailServis;
use App\Models\Kendaraan;
use App\Models\Servis;
use App\Models\Sparepart;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ServisController extends Controller
{
    public function index(Request $request)
    {
        $query = Servis::with(['kendaraan', 'mekanik']);

        if ($request->user()->isMekanik()) {
            $query->whereBelongsTo($request->user(), 'mekanik');
        }

        $servises = $query->latest()->get();

        return view('servises.index', compact('servises'));
    }

    public function create()
    {
        $kendaraans = Kendaraan::all();
        $spareparts = Sparepart::where('stok', '>', 0)->get();
        $mekaniks = User::where('role', 'mekanik')->get();

        return view('servises.create', compact('kendaraans', 'spareparts', 'mekaniks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kendaraan_id' => 'required',
            'mekanik_id' => 'nullable',
            'keluhan' => 'required',
            'biaya_jasa' => 'required|numeric|min:0',
            'sparepart_ids' => 'nullable|array',
            'sparepart_ids.*' => 'exists:spareparts,id',
            'jumlahs' => 'nullable|array',
            'jumlahs.*' => 'nullable|integer|min:1',
        ]);

        try {
            // Gunakan DB Transaction agar jika ada error, database tidak rusak
            DB::transaction(function () use ($request) {
                // 1. Simpan Header Transaksi Servis
                $servis = Servis::create([
                    'kode_transaksi' => 'SRV-'.now()->format('YmdHis').'-'.Str::upper(Str::random(4)),
                    'kendaraan_id' => $request->kendaraan_id,
                    'mekanik_id' => $request->mekanik_id,
                    'keluhan' => $request->keluhan,
                    'biaya_jasa' => $request->biaya_jasa,
                    'total_bayar' => $request->biaya_jasa,
                    'status' => 'antre',
                ]);

                $totalSparepart = 0;

                // 2. Simpan Detail Sparepart yang Dipakai (jika ada)
                if ($request->has('sparepart_ids')) {
                    foreach ($request->sparepart_ids as $index => $sparepartId) {
                        $jumlah = (int) ($request->jumlahs[$index] ?? 0);

                        if ($jumlah < 1) {
                            continue;
                        }

                        $sparepart = Sparepart::findOrFail($sparepartId);

                        // Cegah stok melebihi ketersediaan
                        if ($jumlah > $sparepart->stok) {
                            throw ValidationException::withMessages([
                                'sparepart_ids' => "Stok {$sparepart->nama_barang} hanya tersisa {$sparepart->stok} pcs.",
                            ]);
                        }

                        $subtotal = $sparepart->harga_jual * $jumlah;
                        $totalSparepart += $subtotal;

                        DetailServis::create([
                            'servis_id' => $servis->id,
                            'sparepart_id' => $sparepartId,
                            'jumlah' => $jumlah,
                            'harga_satuan' => $sparepart->harga_jual,
                            'subtotal' => $subtotal,
                        ]);

                        // 3. Potong Stok Sparepart Otomatis
                        $sparepart->decrement('stok', $jumlah);
                    }
                }

                // 4. Update Total Bayar (Biaya Jasa + Total Sparepart)
                $servis->update([
                    'total_bayar' => $servis->biaya_jasa + $totalSparepart,
                ]);
            });
        } catch (ValidationException $exception) {
            return back()->withErrors($exception->errors())->withInput();
        }

        return redirect()->route('servises.index')->with('success', 'Transaksi servis berhasil dicatat dan stok sparepart telah diperbarui!');
    }

    public function show(Request $request, Servis $servis)
    {
        $servis->load(['kendaraan', 'mekanik', 'detailServises.sparepart']);

        return view('servises.show', compact('servis'));
    }

    public function updateStatus(Request $request, Servis $servis)
    {
        $allowedStatuses = ['antre', 'proses', 'selesai', 'lunas'];

        $request->validate([
            'status' => ['required', 'in:'.implode(',', $allowedStatuses)],
        ]);

        // Mekanik hanya boleh menandai servis yang ditugaskan kepadanya sebagai selesai
        if ($request->user()->isMekanik()) {
            if ($servis->mekanik_id !== $request->user()->id || $request->status !== 'selesai') {
                abort(403);
            }
        }

        $servis->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status servis berhasil diperbarui menjadi '.strtoupper($request->status).'!');
    }
}
