<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Daftar Transaksi Servis
            </h2>
            <a href="{{ route('servises.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded shadow text-sm hover:bg-blue-700">
                + Servis Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <div class="bg-white p-6 rounded-lg shadow-md">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kendaraan / Pemilik</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mekanik</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Biaya Jasa</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Bayar</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($servises as $item)
                            <tr>
                                <td class="px-4 py-4 font-mono text-sm">{{ $item->kode_transaksi }}</td>
                                <td class="px-4 py-4">
                                    <div class="font-bold">{{ $item->kendaraan->plat_nomor }}</div>
                                    <div class="text-xs text-gray-500">{{ $item->kendaraan->nama_pemilik }}</div>
                                </td>
                                <td class="px-4 py-4 text-sm">{{ $item->mekanik->name ?? '-' }}</td>
                                <td class="px-4 py-4 text-sm">Rp {{ number_format($item->biaya_jasa) }}</td>
                                <td class="px-4 py-4 font-bold text-sm">Rp {{ number_format($item->total_bayar) }}</td>
                                <td class="px-4 py-4">
                                    <span class="px-2 py-1 text-xs font-semibold rounded
                                        @switch($item->status)
                                            @case('antre') bg-gray-100 text-gray-700 @break
                                            @case('proses') bg-yellow-100 text-yellow-800 @break
                                            @case('selesai') bg-blue-100 text-blue-800 @break
                                            @case('lunas') bg-green-100 text-green-800 @break
                                        @endswitch">
                                        {{ strtoupper($item->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('servises.show', $item) }}" class="text-blue-600 text-sm hover:underline">Detail</a>
                                        @if(
                                            Auth::user()->isAdmin() ||
                                            Auth::user()->isKasir() ||
                                            (Auth::user()->isMekanik() && $item->mekanik_id === Auth::id())
                                        )
                                            <form action="{{ route('servises.status', $item) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <select name="status" onchange="this.form.submit()" class="text-xs rounded-md border-gray-300 shadow-sm">
                                                    @foreach(['antre', 'proses', 'selesai', 'lunas'] as $status)
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
                                <td colspan="7" class="px-4 py-4 text-center text-gray-500">Belum ada transaksi servis.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>