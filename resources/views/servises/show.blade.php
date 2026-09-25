<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="text-xl font-bold leading-tight text-gray-900">
                Detail Transaksi Servis
            </h2>
            <div class="flex items-center gap-3">
                @if(Auth::user()->isAdmin() || Auth::user()->isKasir())
                    <a href="{{ route('servises.nota', $servis) }}" class="inline-flex items-center gap-2 rounded-lg bg-orange-500 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-orange-600">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5z" />
                        </svg>
                        Cetak Nota
                    </a>
                @endif
                <a href="{{ route('servises.index') }}" class="text-sm font-medium text-gray-600 hover:underline">&larr; Kembali</a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-5xl">
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

            <!-- Kartu Info Servis -->
            <div class="mb-6 overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                <div class="flex flex-wrap items-center gap-4 border-b border-gray-100 bg-gray-50 px-6 py-4">
                    <div>
                        <div class="text-xs font-medium uppercase tracking-wider text-gray-500">Kode Transaksi</div>
                        <div class="font-mono font-bold text-gray-900">{{ $servis->kode_transaksi }}</div>
                    </div>
                    <span @class([
                        'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold',
                        'bg-gray-100 text-gray-600' => $servis->status === 'antre',
                        'bg-yellow-100 text-yellow-800' => $servis->status === 'proses',
                        'bg-green-100 text-green-800' => $servis->status === 'selesai',
                        'bg-red-100 text-red-800' => $servis->status === 'batal',
                    ])>{{ strtoupper($servis->status) }}</span>
                    @if($servis->lunas)
                        <span class="inline-flex items-center rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-semibold text-green-700">LUNAS</span>
                    @else
                        <span class="inline-flex items-center rounded-full bg-orange-50 px-2.5 py-0.5 text-xs font-semibold text-orange-700">
                            SISA Rp {{ number_format($servis->total_bayar - $servis->totalDibayar) }}
                        </span>
                    @endif
                </div>

                <div class="grid grid-cols-1 gap-4 px-6 py-4 md:grid-cols-2">
                    <div>
                        <div class="text-xs font-medium uppercase tracking-wider text-gray-500">Kendaraan</div>
                        <div class="font-semibold text-gray-900">{{ $servis->kendaraan->plat_nomor }}</div>
                        <div class="text-sm text-gray-600">{{ $servis->kendaraan->merk }} {{ $servis->kendaraan->tipe }}</div>
                    </div>
                    <div>
                        <div class="text-xs font-medium uppercase tracking-wider text-gray-500">Pemilik</div>
                        <div class="font-semibold text-gray-900">{{ $servis->kendaraan->pelanggan->nama ?? '-' }}</div>
                        <div class="text-sm text-gray-600">{{ $servis->kendaraan->pelanggan->no_hp ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-xs font-medium uppercase tracking-wider text-gray-500">Mekanik</div>
                        <div class="font-semibold text-gray-900">{{ $servis->mekanik->name ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-xs font-medium uppercase tracking-wider text-gray-500">Keluhan</div>
                        <div class="text-sm text-gray-700">{{ $servis->keluhan }}</div>
                    </div>
                </div>
            </div>

            <!-- Rincian Biaya -->
            <div class="mb-6 rounded-xl border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-100 px-6 py-4">
                    <h3 class="text-base font-bold text-gray-900">Rincian Biaya</h3>
                </div>
                <div class="px-6 py-2">
                    @forelse($servis->detailServises as $detail)
                        <div class="flex items-center justify-between gap-4 border-b border-gray-100 py-3">
                            <div>
                                <div class="font-semibold text-gray-900">{{ $detail->sparepart->nama_barang }}</div>
                                <div class="text-sm text-gray-500">{{ $detail->jumlah }} x Rp {{ number_format($detail->harga_satuan) }}</div>
                            </div>
                            <span class="font-semibold text-gray-900">Rp {{ number_format($detail->subtotal) }}</span>
                        </div>
                    @empty
                        <p class="py-3 text-sm text-gray-500">Tidak ada sparepart yang digunakan.</p>
                    @endforelse

                    <div class="flex items-center justify-between gap-4 py-3 text-gray-700">
                        <span>Biaya Jasa</span>
                        <span>Rp {{ number_format($servis->biaya_jasa) }}</span>
                    </div>
                    <div class="flex items-center justify-between gap-4 border-t border-gray-200 py-4">
                        <span class="text-lg font-bold text-gray-900">Total Bayar</span>
                        <span class="text-lg font-bold text-orange-600">Rp {{ number_format($servis->total_bayar) }}</span>
                    </div>
                </div>
            </div>

            @if(
                Auth::user()->isAdmin() ||
                Auth::user()->isKasir() ||
                (Auth::user()->isMekanik() && $servis->mekanik_id === Auth::id())
            )
                <div class="mb-6 rounded-xl border border-gray-200 bg-white shadow-sm">
                    <div class="border-b border-gray-100 px-6 py-4">
                        <h3 class="text-base font-bold text-gray-900">Ubah Status Pengerjaan</h3>
                    </div>
                    <form action="{{ route('servises.status', $servis) }}" method="POST" class="flex flex-wrap items-center gap-4 p-6">
                        @csrf
                        @method('PATCH')
                        <select name="status" class="rounded-lg border-gray-300 shadow-sm focus:border-orange-400 focus:ring-orange-400">
                            @foreach(['antre', 'proses', 'selesai', 'batal'] as $status)
                                @if(Auth::user()->isMekanik() && $status !== 'selesai')
                                    @continue
                                @endif
                                <option value="{{ $status }}" @selected($servis->status === $status)>{{ strtoupper($status) }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-orange-500 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-orange-600">
                            Simpan Status
                        </button>
                    </form>
                </div>
            @endif

            @if(Auth::user()->isAdmin() || Auth::user()->isKasir())
                <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
                    <div class="border-b border-gray-100 px-6 py-4">
                        <h3 class="text-base font-bold text-gray-900">Pembayaran</h3>
                    </div>
                    <div class="p-6">
                        <p class="mb-4 text-sm text-gray-600">
                            Dibayar <strong class="text-gray-900">Rp {{ number_format($servis->totalDibayar) }}</strong> dari
                            Rp {{ number_format($servis->total_bayar) }}
                            (Sisa Rp {{ number_format($servis->total_bayar - $servis->totalDibayar) }})
                        </p>

                        @if($servis->lunas)
                            <div class="mb-4 rounded-lg bg-green-50 p-4 text-sm text-green-700">Tagihan sudah lunas.</div>
                        @elseif($servis->status === 'batal')
                            <div class="mb-4 rounded-lg bg-gray-50 p-4 text-sm text-gray-600">Servis dibatalkan, tidak perlu pembayaran.</div>
                        @else
                            <form action="{{ route('servises.pembayaran', $servis) }}" method="POST" class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-3">
                                @csrf
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Jumlah Bayar (Rp)</label>
                                    <input type="number" name="jumlah_bayar" required min="1" max="{{ $servis->total_bayar - $servis->totalDibayar }}" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-400 focus:ring-orange-400">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Metode</label>
                                    <select name="metode" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-400 focus:ring-orange-400">
                                        @foreach(['tunai', 'transfer', 'qris'] as $metode)
                                            <option value="{{ $metode }}">{{ strtoupper($metode) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="flex items-end">
                                    <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-orange-500 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-orange-600">
                                        Catat Pembayaran
                                    </button>
                                </div>
                            </form>
                            <form action="{{ route('servises.lunasi', $servis) }}" method="POST">
                                @csrf
                                <button type="submit" onclick="return confirm('Tandai transaksi sebagai lunas (bayar sisa penuh)?')" class="text-sm font-medium text-orange-600 hover:underline">
                                    Tandai Lunas (langsung bayar sisa)
                                </button>
                            </form>
                        @endif

                        <div class="divide-y divide-gray-100">
                            @forelse($servis->pembayarans as $bayar)
                                <div class="flex items-center justify-between gap-4 py-3">
                                    <div>
                                        <div class="font-semibold text-gray-900">Rp {{ number_format($bayar->jumlah_bayar) }}</div>
                                        <div class="text-sm text-gray-500">
                                            {{ $bayar->dibayar_pada->format('d M Y H:i') }} &middot; {{ strtoupper($bayar->metode) }} &middot; {{ $bayar->kasir->name ?? '-' }}
                                        </div>
                                    </div>
                                    <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-semibold text-blue-700">{{ strtoupper($bayar->metode) }}</span>
                                </div>
                            @empty
                                <p class="py-3 text-sm text-gray-500">Belum ada pembayaran.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>