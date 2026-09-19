<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }} - {{ Auth::user()->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(Auth::user()->isMekanik())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <p class="text-gray-700">
                            Selamat datang, <strong>{{ Auth::user()->name }}</strong>! Berikut tugas servis yang sedang kamu kerjakan.
                        </p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-6">
                        <div class="rounded-lg bg-blue-50 p-4">
                            <div class="text-sm text-blue-700 font-medium">Tugas Sedang Dikerjakan</div>
                            <div class="text-3xl font-bold text-blue-800">{{ $tugasDikerjakan->count() }}</div>
                        </div>
                        <div class="rounded-lg bg-green-50 p-4">
                            <div class="text-sm text-green-700 font-medium">Tugas Selesai</div>
                            <div class="text-3xl font-bold text-green-800">{{ $tugasSelesai }}</div>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-lg font-bold mb-4">Tugas Kamu</h3>
                    @forelse($tugasDikerjakan as $item)
                        <div class="flex justify-between items-center border-b border-gray-100 py-3">
                            <div>
                                <div class="font-semibold">{{ $item->kendaraan->plat_nomor }} - {{ $item->kendaraan->merk_tipe }}</div>
                                <div class="text-sm text-gray-500">{{ $item->keluhan }}</div>
                            </div>
                            <a href="{{ route('servises.show', $item) }}" class="text-blue-600 text-sm hover:underline">Detail</a>
                        </div>
                    @empty
                        <p class="text-gray-500">Tidak ada tugas yang sedang antre atau diproses.</p>
                    @endforelse
                </div>
            @elseif(Auth::user()->isKasir())
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div class="rounded-lg bg-blue-50 p-4">
                        <div class="text-sm text-blue-700 font-medium">Total Transaksi</div>
                        <div class="text-3xl font-bold text-blue-800">{{ $totalTransaksi }}</div>
                    </div>
                    <div class="rounded-lg bg-green-50 p-4">
                        <div class="text-sm text-green-700 font-medium">Pendapatan (Lunas)</div>
                        <div class="text-3xl font-bold text-green-800">Rp {{ number_format($totalPendapatan) }}</div>
                    </div>
                    <div class="rounded-lg bg-yellow-50 p-4">
                        <div class="text-sm text-yellow-700 font-medium">Servis Berjalan</div>
                        <div class="text-3xl font-bold text-yellow-800">{{ $jalanSekarang }}</div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                    <a href="{{ route('servises.create') }}" class="bg-green-600 text-white px-4 py-2 rounded shadow text-sm hover:bg-green-700">
                        + Catat Servis Baru
                    </a>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-lg font-bold mb-4">Transaksi Terbaru</h3>
                    @forelse($transaksiTerbaru as $item)
                        <div class="flex justify-between items-center border-b border-gray-100 py-3">
                            <div>
                                <div class="font-semibold">{{ $item->kode_transaksi }}</div>
                                <div class="text-sm text-gray-500">{{ $item->kendaraan->plat_nomor }} - {{ $item->mekanik->name ?? '-' }} - {{ strtoupper($item->status) }}</div>
                            </div>
                            <span class="font-bold">Rp {{ number_format($item->total_bayar) }}</span>
                        </div>
                    @empty
                        <p class="text-gray-500">Belum ada transaksi.</p>
                    @endforelse
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="rounded-lg bg-blue-50 p-4">
                        <div class="text-sm text-blue-700 font-medium">Total Sparepart</div>
                        <div class="text-3xl font-bold text-blue-800">{{ $totalSparepart }}</div>
                    </div>
                    <div class="rounded-lg bg-indigo-50 p-4">
                        <div class="text-sm text-indigo-700 font-medium">Total Kendaraan</div>
                        <div class="text-3xl font-bold text-indigo-800">{{ $totalKendaraan }}</div>
                    </div>
                    <div class="rounded-lg bg-yellow-50 p-4">
                        <div class="text-sm text-yellow-700 font-medium">Total Transaksi</div>
                        <div class="text-3xl font-bold text-yellow-800">{{ $totalTransaksi }}</div>
                    </div>
                    <div class="rounded-lg bg-green-50 p-4">
                        <div class="text-sm text-green-700 font-medium">Pendapatan (Lunas)</div>
                        <div class="text-3xl font-bold text-green-800">Rp {{ number_format($totalPendapatan) }}</div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-lg font-bold mb-4">Transaksi Terbaru</h3>
                    @forelse($transaksiTerbaru as $item)
                        <div class="flex justify-between items-center border-b border-gray-100 py-3">
                            <div>
                                <div class="font-semibold">{{ $item->kode_transaksi }}</div>
                                <div class="text-sm text-gray-500">{{ $item->kendaraan->plat_nomor }} - {{ $item->mekanik->name ?? '-' }} - {{ strtoupper($item->status) }}</div>
                            </div>
                            <span class="font-bold">Rp {{ number_format($item->total_bayar) }}</span>
                        </div>
                    @empty
                        <p class="text-gray-500">Belum ada transaksi.</p>
                    @endforelse
                </div>
            @endif
        </div>
    </div>
</x-app-layout>