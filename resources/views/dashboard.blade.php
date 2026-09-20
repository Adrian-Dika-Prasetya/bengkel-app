<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold leading-tight text-gray-900">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-8">
        @if(Auth::user()->isMekanik())
            <div class="mb-6 overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                <div class="flex flex-wrap items-center justify-between gap-4 p-6">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Selamat datang, {{ Auth::user()->name }}!</h3>
                        <p class="mt-1 text-sm text-gray-500">Berikut tugas servis yang sedang kamu kerjakan.</p>
                    </div>
                    <span class="inline-flex items-center gap-2 rounded-full bg-orange-50 px-3 py-1 text-xs font-semibold text-orange-700">
                        <span class="h-2 w-2 rounded-full bg-orange-500"></span>
                        Mekanik
                    </span>
                </div>
            </div>

            <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
                <x-stat-card
                    label="Tugas Sedang Dikerjakan"
                    value="{{ $tugasDikerjakan->count() }}"
                    tone="orange"
                    icon="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                <x-stat-card
                    label="Tugas Selesai"
                    value="{{ $tugasSelesai }}"
                    tone="green"
                    icon="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </div>

            <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-100 px-6 py-4">
                    <h3 class="text-base font-bold text-gray-900">Tugas Kamu</h3>
                </div>
                <div class="divide-y divide-gray-100">
                    @forelse($tugasDikerjakan as $item)
                        <div class="flex items-center justify-between gap-4 px-6 py-3">
                            <div class="min-w-0">
                                <div class="font-semibold text-gray-900">{{ $item->kendaraan->plat_nomor }} - {{ $item->kendaraan->merk }} {{ $item->kendaraan->tipe }}</div>
                                <div class="truncate text-sm text-gray-500">{{ $item->keluhan }}</div>
                            </div>
                            <a href="{{ route('servises.show', $item) }}" class="shrink-0 text-sm font-medium text-orange-600 hover:underline">Detail</a>
                        </div>
                    @empty
                        <p class="px-6 py-8 text-center text-sm text-gray-500">Tidak ada tugas yang sedang antre atau diproses.</p>
                    @endforelse
                </div>
            </div>
        @elseif(Auth::user()->isKasir())
            <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <x-stat-card
                    label="Total Transaksi"
                    value="{{ $totalTransaksi }}"
                    tone="blue"
                    icon="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                <x-stat-card
                    label="Pendapatan (Terkumpul)"
                    value="Rp {{ number_format($totalPendapatan) }}"
                    tone="green"
                    icon="M12 6v12m-3-2.818l.02-.01c.56-.28 1.184-.422 1.818-.422h.075c1.608 0 2.91.916 2.91 2.23 0 1.313-1.302 2.23-2.91 2.23h-.075a3.82 3.82 0 01-1.818-.422L9 16.818M12 6c-.59 0-1.16.184-1.63.5L3 12.4A5.79 5.79 0 005.3 15.76l4.74-3.39c.51-.36 1.12-.55 1.75-.55h4.99c.9 0 1.72-.62 1.86-1.46" />
                <x-stat-card
                    label="Servis Berjalan"
                    value="{{ $jalanSekarang }}"
                    tone="yellow"
                    icon="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                <x-stat-card
                    label="Tagihan Belum Lunas"
                    value="{{ $tagihanBelumLunas }}"
                    tone="red"
                    icon="M4.5 12.75l6 6 9-13.5" />
            </div>

            <div class="mb-6 rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <a href="{{ route('servises.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-orange-500 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-orange-600">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Catat Servis Baru
                </a>
            </div>

            <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-100 px-6 py-4">
                    <h3 class="text-base font-bold text-gray-900">Transaksi Terbaru</h3>
                </div>
                <div class="divide-y divide-gray-100">
                    @forelse($transaksiTerbaru as $item)
                        <div class="flex items-center justify-between gap-4 px-6 py-3">
                            <div class="min-w-0">
                                <div class="font-semibold text-gray-900">{{ $item->kode_transaksi }}</div>
                                <div class="truncate text-sm text-gray-500">{{ $item->kendaraan->plat_nomor }} - {{ $item->kendaraan->pelanggan->nama ?? '-' }}</div>
                            </div>
                            <div class="flex shrink-0 items-center gap-3">
                                <span @class([
                                    'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold',
                                    'bg-gray-100 text-gray-600' => $item->status === 'antre',
                                    'bg-yellow-100 text-yellow-800' => $item->status === 'proses',
                                    'bg-green-100 text-green-800' => $item->status === 'selesai',
                                    'bg-red-100 text-red-800' => $item->status === 'batal',
                                ])>{{ strtoupper($item->status) }}</span>
                                <span class="font-bold text-gray-900">Rp {{ number_format($item->total_bayar) }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="px-6 py-8 text-center text-sm text-gray-500">Belum ada transaksi.</p>
                    @endforelse
                </div>
            </div>
        @else
            <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <x-stat-card
                    label="Total Sparepart"
                    value="{{ $totalSparepart }}"
                    tone="orange"
                    icon="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0l-3-3m3 3l3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                <x-stat-card
                    label="Total Kendaraan"
                    value="{{ $totalKendaraan }}"
                    tone="blue"
                    icon="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                <x-stat-card
                    label="Total Pelanggan"
                    value="{{ $totalPelanggan }}"
                    tone="teal"
                    icon="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                <x-stat-card
                    label="Total Transaksi"
                    value="{{ $totalTransaksi }}"
                    tone="yellow"
                    icon="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
            </div>

            <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <x-stat-card
                    label="Pendapatan (Terkumpul)"
                    value="Rp {{ number_format($totalPendapatan) }}"
                    tone="green"
                    icon="M12 6v12m-3-2.818l.02-.01c.56-.28 1.184-.422 1.818-.422h.075c1.608 0 2.91.916 2.91 2.23 0 1.313-1.302 2.23-2.91 2.23h-.075a3.82 3.82 0 01-1.818-.422L9 16.818M12 6c-.59 0-1.16.184-1.63.5L3 12.4A5.79 5.79 0 005.3 15.76l4.74-3.39c.51-.36 1.12-.55 1.75-.55h4.99c.9 0 1.72-.62 1.86-1.46" />
                <x-stat-card
                    label="Stok Menipis"
                    value="{{ $stokMenipis }}"
                    tone="red"
                    icon="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                <x-stat-card
                    label="Tagihan Belum Lunas"
                    value="{{ $tagihanBelumLunas }}"
                    tone="orange"
                    icon="M12 6v12m-3-2.818l.02-.01c.56-.28 1.184-.422 1.818-.422h.075c1.608 0 2.91.916 2.91 2.23 0 1.313-1.302 2.23-2.91 2.23h-.075a3.82 3.82 0 01-1.818-.422L9 16.818M12 6c-.59 0-1.16.184-1.63.5L3 12.4A5.79 5.79 0 005.3 15.76l4.74-3.39c.51-.36 1.12-.55 1.75-.55h4.99c.9 0 1.72-.62 1.86-1.46" />
            </div>

            <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-100 px-6 py-4">
                    <h3 class="text-base font-bold text-gray-900">Transaksi Terbaru</h3>
                </div>
                <div class="divide-y divide-gray-100">
                    @forelse($transaksiTerbaru as $item)
                        <div class="flex items-center justify-between gap-4 px-6 py-3">
                            <div class="min-w-0">
                                <div class="font-semibold text-gray-900">{{ $item->kode_transaksi }}</div>
                                <div class="truncate text-sm text-gray-500">{{ $item->kendaraan->plat_nomor }} - {{ $item->kendaraan->pelanggan->nama ?? '-' }}</div>
                            </div>
                            <div class="flex shrink-0 items-center gap-3">
                                <span @class([
                                    'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold',
                                    'bg-gray-100 text-gray-600' => $item->status === 'antre',
                                    'bg-yellow-100 text-yellow-800' => $item->status === 'proses',
                                    'bg-green-100 text-green-800' => $item->status === 'selesai',
                                    'bg-red-100 text-red-800' => $item->status === 'batal',
                                ])>{{ strtoupper($item->status) }}</span>
                                <span class="font-bold text-gray-900">Rp {{ number_format($item->total_bayar) }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="px-6 py-8 text-center text-sm text-gray-500">Belum ada transaksi.</p>
                    @endforelse
                </div>
            </div>
        @endif
    </div>
</x-app-layout>