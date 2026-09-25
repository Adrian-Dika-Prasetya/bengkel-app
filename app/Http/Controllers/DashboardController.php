<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Models\Pelanggan;
use App\Models\Pembayaran;
use App\Models\Servis;
use App\Models\Sparepart;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->isMekanik()) {
            return view('dashboard', [
                'tugasDikerjakan' => Servis::whereBelongsTo($user, 'mekanik')
                    ->whereIn('status', ['antre', 'proses'])
                    ->with('kendaraan')
                    ->latest()
                    ->get(),
                'tugasSelesai' => Servis::whereBelongsTo($user, 'mekanik')
                    ->where('status', 'selesai')
                    ->count(),
            ]);
        }

        if ($user->isKasir()) {
            return view('dashboard', [
                'totalTransaksi' => Servis::count(),
                'totalPendapatan' => (int) Pembayaran::sum('jumlah_bayar'),
                'jalanSekarang' => Servis::whereIn('status', ['antre', 'proses'])->count(),
                'tagihanBelumLunas' => $this->tagihanBelumLunas(),
                'transaksiTerbaru' => Servis::with(['kendaraan.pelanggan', 'mekanik'])->latest()->limit(5)->get(),
            ]);
        }

        return view('dashboard', [
            'totalSparepart' => Sparepart::count(),
            'totalKendaraan' => Kendaraan::count(),
            'totalPelanggan' => Pelanggan::count(),
            'totalTransaksi' => Servis::count(),
            'totalPendapatan' => (int) Pembayaran::sum('jumlah_bayar'),
            'stokMenipis' => Sparepart::whereColumn('stok', '<=', 'stok_minimal')->count(),
            'tagihanBelumLunas' => $this->tagihanBelumLunas(),
            'transaksiTerbaru' => Servis::with(['kendaraan.pelanggan', 'mekanik'])->latest()->limit(5)->get(),
        ]);
    }

    private function tagihanBelumLunas(): int
    {
        return (int) Servis::where('total_bayar', '>', 0)
            ->where('status', '!=', 'batal')
            ->whereRaw(
                'COALESCE((SELECT SUM(jumlah_bayar) FROM pembayarans WHERE pembayarans.servis_id = servises.id), 0) < servises.total_bayar'
            )
            ->count();
    }
}
