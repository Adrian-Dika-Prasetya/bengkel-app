<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Transaksi Servis
            </h2>
            <a href="{{ route('servises.index') }}" class="text-gray-600 text-sm hover:underline">← Kembali</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
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

            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                <div class="px-6 py-4 bg-gray-50 flex justify-between items-center">
                    <div>
                        <div class="text-xs text-gray-500 uppercase">Kode Transaksi</div>
                        <div class="font-mono font-bold">{{ $servis->kode_transaksi }}</div>
                    </div>
                    <span class="px-2 py-1 text-xs font-semibold rounded
                        @switch($servis->status)
                            @case('antre') bg-gray-100 text-gray-700 @break
                            @case('proses') bg-yellow-100 text-yellow-800 @break
                            @case('selesai') bg-blue-100 text-blue-800 @break
                            @case('lunas') bg-green-100 text-green-800 @break
                        @endswitch">
                        {{ strtoupper($servis->status) }}
                    </span>
                </div>

                <div class="px-6 py-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <div class="text-xs text-gray-500 uppercase">Kendaraan</div>
                        <div class="font-semibold">{{ $servis->kendaraan->plat_nomor }}</div>
                        <div class="text-sm text-gray-600">{{ $servis->kendaraan->merk_tipe }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500 uppercase">Pemilik</div>
                        <div class="font-semibold">{{ $servis->kendaraan->nama_pemilik }}</div>
                        <div class="text-sm text-gray-600">{{ $servis->kendaraan->no_hp }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500 uppercase">Mekanik</div>
                        <div class="font-semibold">{{ $servis->mekanik->name ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500 uppercase">Keluhan</div>
                        <div class="text-sm text-gray-700">{{ $servis->keluhan }}</div>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                <h3 class="text-lg font-bold mb-4">Sparepart yang Digunakan</h3>
                @forelse($servis->detailServises as $detail)
                    <div class="flex justify-between items-center border-b border-gray-100 py-3">
                        <div>
                            <div class="font-semibold">{{ $detail->sparepart->nama_barang }}</div>
                            <div class="text-sm text-gray-500">{{ $detail->jumlah }} x Rp {{ number_format($detail->harga_satuan) }}</div>
                        </div>
                        <span class="font-semibold">Rp {{ number_format($detail->subtotal) }}</span>
                    </div>
                @empty
                    <p class="text-gray-500">Tidak ada sparepart yang digunakan.</p>
                @endforelse

                <div class="flex justify-between items-center py-4 border-t border-gray-200">
                    <span class="text-gray-700">Biaya Jasa</span>
                    <span>Rp {{ number_format($servis->biaya_jasa) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-lg font-bold">Total Bayar</span>
                    <span class="text-lg font-bold">Rp {{ number_format($servis->total_bayar) }}</span>
                </div>
            </div>

            @if(
                Auth::user()->isAdmin() ||
                Auth::user()->isKasir() ||
                (Auth::user()->isMekanik() && $servis->mekanik_id === Auth::id())
            )
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-lg font-bold mb-4">Ubah Status</h3>
                    <form action="{{ route('servises.status', $servis) }}" method="POST" class="flex items-center gap-4">
                        @csrf
                        @method('PATCH')
                        <select name="status" class="rounded-md border-gray-300 shadow-sm">
                            @foreach(['antre', 'proses', 'selesai', 'lunas'] as $status)
                                @if(Auth::user()->isMekanik() && $status !== 'selesai')
                                    @continue
                                @endif
                                <option value="{{ $status }}" @selected($servis->status === $status)>{{ strtoupper($status) }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded shadow text-sm hover:bg-blue-700">
                            Simpan Status
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>