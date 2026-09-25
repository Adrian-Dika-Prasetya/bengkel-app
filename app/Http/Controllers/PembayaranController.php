<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Servis;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class PembayaranController extends Controller
{
    public function store(Request $request, Servis $servis)
    {
        $request->validate([
            'jumlah_bayar' => 'required|numeric|min:1',
            'metode' => ['required', Rule::in(['tunai', 'transfer', 'qris'])],
        ]);

        $sisa = $servis->total_bayar - $servis->totalDibayar;

        if ($request->jumlah_bayar > $sisa) {
            throw ValidationException::withMessages([
                'jumlah_bayar' => 'Nominal melebihi sisa tagihan (Rp '.number_format($sisa).').',
            ]);
        }

        Pembayaran::create([
            'servis_id' => $servis->id,
            'kasir_id' => $request->user()->id,
            'jumlah_bayar' => $request->jumlah_bayar,
            'metode' => $request->metode,
            'dibayar_pada' => now(),
        ]);

        return redirect()->back()->with('success', 'Pembayaran berhasil dicatat!');
    }

    public function lunasi(Request $request, Servis $servis)
    {
        $sisa = $servis->total_bayar - $servis->totalDibayar;

        if ($sisa <= 0) {
            return redirect()->back()->with('success', 'Transaksi ini sudah lunas.');
        }

        Pembayaran::create([
            'servis_id' => $servis->id,
            'kasir_id' => $request->user()->id,
            'jumlah_bayar' => $sisa,
            'metode' => 'tunai',
            'dibayar_pada' => now(),
        ]);

        return redirect()->back()->with('success', 'Transaksi ditandai lunas!');
    }
}
