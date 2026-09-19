<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
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
                'tugasDikerjakan' => Servis::whereBelongsTo($user, 'mekanik')->whereIn('status', ['antre', 'proses'])->latest()->get(),
                'tugasSelesai' => Servis::whereBelongsTo($user, 'mekanik')->where('status', 'selesai')->count(),
            ]);
        }

        if ($user->isKasir()) {
            return view('dashboard', [
                'totalTransaksi' => Servis::count(),
                'totalPendapatan' => (int) Servis::where('status', 'lunas')->sum('total_bayar'),
                'jalanSekarang' => Servis::whereIn('status', ['antre', 'proses'])->count(),
                'transaksiTerbaru' => Servis::with(['kendaraan', 'mekanik'])->latest()->limit(5)->get(),
            ]);
        }

        return view('dashboard', [
            'totalSparepart' => Sparepart::count(),
            'totalKendaraan' => Kendaraan::count(),
            'totalTransaksi' => Servis::count(),
            'totalPendapatan' => (int) Servis::where('status', 'lunas')->sum('total_bayar'),
            'transaksiTerbaru' => Servis::with(['kendaraan', 'mekanik'])->latest()->limit(5)->get(),
        ]);
    }
}
