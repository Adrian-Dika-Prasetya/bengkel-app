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
        $query = Servis::with(['kendaraan.pelanggan', 'mekanik', 'pembayarans']);

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
            'jumlahs' => 'nullable|array',
            'jumlahs.*' => 'nullable|integer|min:1',
        ]);

        // Saring baris sparepart kosong supaya servis tanpa sparepart tetap bisa dibuat
        $items = [];
        foreach ($request->input('sparepart_ids', []) as $index => $id) {
            $id = trim((string) $id);
            $jumlah = (int) ($request->input('jumlahs', [])[$index] ?? 0);

            if ($id !== '' && $jumlah >= 1) {
                $items[] = ['sparepart_id' => $id, 'jumlah' => $jumlah];
            }
        }

        try {
            // Gunakan DB Transaction agar jika ada error, database tidak rusak
            DB::transaction(function () use ($request, $items) {
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
                $dipakai = [];

                // 2. Simpan Detail Sparepart yang Dipakai (jika ada)
                foreach ($items as $item) {
                    $sparepart = Sparepart::find($item['sparepart_id']);

                    if (! $sparepart) {
                        throw ValidationException::withMessages([
                            'sparepart_ids' => 'Sparepart yang dipilih tidak ditemukan.',
                        ]);
                    }

                    // Satu sparepart tidak boleh dipilih di lebih dari satu baris
                    if (isset($dipakai[$sparepart->id])) {
                        throw ValidationException::withMessages([
                            'sparepart_ids' => 'Sparepart yang sama tidak boleh dipilih dua kali.',
                        ]);
                    }
                    $dipakai[$sparepart->id] = true;

                    // Cegah stok melebihi ketersediaan
                    if ($item['jumlah'] > $sparepart->stok) {
                        throw ValidationException::withMessages([
                            'sparepart_ids' => "Stok {$sparepart->nama_barang} hanya tersisa {$sparepart->stok} pcs.",
                        ]);
                    }

                    $subtotal = $sparepart->harga_jual * $item['jumlah'];
                    $totalSparepart += $subtotal;

                    DetailServis::create([
                        'servis_id' => $servis->id,
                        'sparepart_id' => $sparepart->id,
                        'jumlah' => $item['jumlah'],
                        'harga_satuan' => $sparepart->harga_jual,
                        'subtotal' => $subtotal,
                    ]);

                    // 3. Potong Stok Sparepart Otomatis
                    $sparepart->decrement('stok', $item['jumlah']);
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
        if ($request->user()->isMekanik() && $servis->mekanik_id !== $request->user()->id) {
            abort(403);
        }

        $servis->load(['kendaraan.pelanggan', 'mekanik', 'detailServises.sparepart', 'pembayarans.kasir']);

        return view('servises.show', compact('servis'));
    }

    public function nota(Request $request, Servis $servis)
    {
        if ($request->user()->isMekanik()) {
            abort(403);
        }

        $servis->load(['kendaraan.pelanggan', 'mekanik', 'detailServises.sparepart', 'pembayarans.kasir']);

        return view('servises.nota', compact('servis'));
    }

    public function updateStatus(Request $request, Servis $servis)
    {
        $allowedStatuses = ['antre', 'proses', 'selesai', 'batal'];

        $request->validate([
            'status' => ['required', 'in:'.implode(',', $allowedStatuses)],
        ]);

        // Mekanik hanya boleh menandai servis yang ditugaskan kepadanya sebagai selesai
        if ($request->user()->isMekanik()) {
            if ($servis->mekanik_id !== $request->user()->id || $request->status !== 'selesai') {
                abort(403);
            }
        }

        // Servis yang sudah dibayar tidak boleh dibatalkan (uang telah diterima)
        if ($request->status === 'batal' && $servis->pembayarans()->exists()) {
            return back()->withErrors(['status' => 'Tidak dapat membatalkan servis yang sudah memiliki pembayaran.']);
        }

        $servis->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status servis berhasil diperbarui menjadi '.strtoupper($request->status).'!');
    }
}
