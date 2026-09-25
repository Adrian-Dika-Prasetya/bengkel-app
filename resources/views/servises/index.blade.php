<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="text-xl font-bold leading-tight text-gray-900">
                Daftar Transaksi Servis
            </h2>
            @if(Auth::user()->isAdmin() || Auth::user()->isKasir())
                <a href="{{ route('servises.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-orange-500 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-orange-600">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Servis Baru
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-8">
        @if(session('success'))
            <div class="mb-4 rounded-lg border border-green-200 bg-green-50 p-4 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Kode</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Kendaraan / Pemilik</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Mekanik</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Biaya Jasa</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Total Bayar</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Pembayaran</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($servises as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="whitespace-nowrap px-4 py-4 font-mono text-sm text-gray-900">{{ $item->kode_transaksi }}</td>
                                <td class="px-4 py-4">
                                    <div class="font-semibold text-gray-900">{{ $item->kendaraan->plat_nomor }}</div>
                                    <div class="text-xs text-gray-500">{{ $item->kendaraan->pelanggan->nama ?? '-' }}</div>
                                </td>
                                <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-600">{{ $item->mekanik->name ?? '-' }}</td>
                                <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-600">Rp {{ number_format($item->biaya_jasa) }}</td>
                                <td class="whitespace-nowrap px-4 py-4 text-sm font-bold text-gray-900">Rp {{ number_format($item->total_bayar) }}</td>
                                <td class="whitespace-nowrap px-4 py-4">
                                    <span @class([
                                        'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold',
                                        'bg-gray-100 text-gray-600' => $item->status === 'antre',
                                        'bg-yellow-100 text-yellow-800' => $item->status === 'proses',
                                        'bg-green-100 text-green-800' => $item->status === 'selesai',
                                        'bg-red-100 text-red-800' => $item->status === 'batal',
                                    ])>{{ strtoupper($item->status) }}</span>
                                </td>
                                <td class="whitespace-nowrap px-4 py-4">
                                    @if($item->lunas)
                                        <span class="inline-flex items-center rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-semibold text-green-700">LUNAS</span>
                                    @else
                                        <div class="inline-flex items-center gap-1 rounded-full bg-orange-50 px-2.5 py-0.5 text-xs font-semibold text-orange-700">
                                            SISA Rp {{ number_format($item->total_bayar - $item->totalDibayar) }}
                                        </div>
                                        @if(Auth::user()->isAdmin() || Auth::user()->isKasir())
                                            <form action="{{ route('servises.lunasi', $item) }}" method="POST" class="mt-1">
                                                @csrf
                                                <button type="submit" onclick="return confirm('Tandai transaksi {{ $item->kode_transaksi }} sebagai lunas?')" class="text-xs font-semibold text-orange-600 hover:underline">
                                                    Tandai Lunas
                                                </button>
                                            </form>
                                        @endif
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-4 py-4">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('servises.show', $item) }}" class="text-sm font-medium text-orange-600 hover:underline">Detail</a>
                                        @if(Auth::user()->isAdmin() || Auth::user()->isKasir())
                                            <a href="{{ route('servises.nota', $item) }}" class="text-sm font-medium text-orange-600 hover:underline">Nota</a>
                                        @endif
                                        @if(
                                            Auth::user()->isAdmin() ||
                                            Auth::user()->isKasir() ||
                                            (Auth::user()->isMekanik() && $item->mekanik_id === Auth::id())
                                        )
                                            <form action="{{ route('servises.status', $item) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <select name="status" onchange="this.form.submit()" class="rounded-md border-gray-300 text-xs shadow-sm focus:border-orange-400 focus:ring-orange-400">
                                                    @foreach(['antre', 'proses', 'selesai', 'batal'] as $status)
                                                        @if(Auth::user()->isMekanik() && $status !== 'selesai')
                                                            @continue
                                                        @endif
                                                        <option value="{{ $status }}" @selected($item->status === $status)>{{ strtoupper($status) }}</option>
                                                    @endforeach
                                                </select>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-8 text-center text-sm text-gray-500">Belum ada transaksi servis.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>