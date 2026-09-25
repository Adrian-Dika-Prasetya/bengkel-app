<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Nota - {{ $servis->kode_transaksi }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            @media print {
                body { background: #fff !important; }
                .no-print { display: none !important; }
            }
        </style>
    </head>
    <body class="bg-gray-100 py-8">
        <div class="mx-auto w-full max-w-3xl px-4">
            <div class="no-print mb-4 flex items-center justify-between gap-3 rounded-xl border border-gray-200 bg-white px-4 py-3 shadow-sm">
                <a href="{{ route('servises.show', $servis) }}" class="text-sm font-medium text-gray-600 hover:underline">&larr; Kembali</a>
                <div class="flex items-center gap-2">
                    <button type="button" onclick="window.print()" class="inline-flex items-center gap-2 rounded-lg bg-orange-500 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-orange-600">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5z" />
                        </svg>
                        Cetak Nota
                    </button>
                </div>
            </div>

            @if(session('success'))
                <div class="no-print mb-4 rounded-lg border border-green-200 bg-green-50 p-4 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white px-8 py-10 shadow-sm ring-1 ring-gray-200 print:shadow-none print:ring-0">
                <!-- Kop Nota -->
                <div class="flex items-center justify-between border-b-2 border-gray-800 pb-4">
                    <div>
                        <div class="flex items-center gap-3">
                            <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-orange-500 text-white">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z" />
                                </svg>
                            </div>
                            <div>
                                <div class="text-xl font-black tracking-wide text-gray-900">BENGKEL APP</div>
                                <div class="text-xs text-gray-500">Sistem Informasi Bengkel &middot; Layanan Servis Kendaraan</div>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-sm font-bold uppercase tracking-widest text-gray-900">Nota Transaksi</div>
                        <div class="mt-1 font-mono text-sm text-gray-700">{{ $servis->kode_transaksi }}</div>
                        <div class="text-xs text-gray-500">{{ $servis->created_at->format('d M Y, H:i') }}</div>
                    </div>
                </div>

                <!-- Data Pelanggan & Kendaraan -->
                <div class="mt-6 grid grid-cols-2 gap-6 text-sm">
                    <div>
                        <div class="text-xs font-semibold uppercase tracking-wider text-gray-400">Pelanggan</div>
                        <div class="mt-1 font-semibold text-gray-900">{{ $servis->kendaraan->pelanggan->nama ?? '-' }}</div>
                        <div class="text-gray-600">{{ $servis->kendaraan->pelanggan->no_hp ?? '-' }}</div>
                        <div class="text-gray-600">{{ $servis->kendaraan->pelanggan->alamat ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-xs font-semibold uppercase tracking-wider text-gray-400">Kendaraan &amp; Pengerjaan</div>
                        <div class="mt-1 font-semibold text-gray-900">{{ $servis->kendaraan->plat_nomor }}</div>
                        <div class="text-gray-600">{{ $servis->kendaraan->merk }} {{ $servis->kendaraan->tipe }}</div>
                        <div class="text-gray-600">Mekanik: {{ $servis->mekanik->name ?? '-' }}</div>
                    </div>
                </div>

                @if($servis->keluhan)
                    <div class="mt-4 text-sm">
                        <span class="font-semibold text-gray-700">Keluhan:</span>
                        <span class="text-gray-600">{{ $servis->keluhan }}</span>
                    </div>
                @endif

                <!-- Rincian Biaya -->
                <table class="mt-6 w-full border-collapse text-sm">
                    <thead>
                        <tr class="border-y-2 border-gray-800 text-left">
                            <th class="py-2 text-xs font-semibold uppercase tracking-wider text-gray-600">Item</th>
                            <th class="py-2 text-right text-xs font-semibold uppercase tracking-wider text-gray-600">Qty</th>
                            <th class="py-2 text-right text-xs font-semibold uppercase tracking-wider text-gray-600">Harga</th>
                            <th class="py-2 text-right text-xs font-semibold uppercase tracking-wider text-gray-600">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($servis->detailServises as $detail)
                            <tr>
                                <td class="py-2 text-gray-900">{{ $detail->sparepart->nama_barang }}</td>
                                <td class="py-2 text-right text-gray-600">{{ $detail->jumlah }}</td>
                                <td class="py-2 text-right text-gray-600">Rp {{ number_format($detail->harga_satuan) }}</td>
                                <td class="py-2 text-right text-gray-900">Rp {{ number_format($detail->subtotal) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td class="py-2 text-gray-500">Jasa Servis</td>
                                <td class="py-2 text-right text-gray-500">-</td>
                                <td class="py-2 text-right text-gray-500">-</td>
                                <td class="py-2 text-right text-gray-500">-</td>
                            </tr>
                        @endforelse
                        <tr>
                            <td class="py-2 font-semibold text-gray-900">Biaya Jasa</td>
                            <td></td>
                            <td></td>
                            <td class="py-2 text-right font-semibold text-gray-900">Rp {{ number_format($servis->biaya_jasa) }}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="border-t-2 border-gray-800">
                            <td colspan="3" class="py-3 text-right text-base font-bold uppercase tracking-wide text-gray-900">Total Tagihan</td>
                            <td class="py-3 text-right text-base font-bold text-gray-900">Rp {{ number_format($servis->total_bayar) }}</td>
                        </tr>
                    </tfoot>
                </table>

                <!-- Riwayat Pembayaran -->
                <div class="mt-6 border-t border-gray-200 pt-4">
                    <div class="text-xs font-semibold uppercase tracking-wider text-gray-400">Riwayat Pembayaran</div>
                    @forelse($servis->pembayarans as $bayar)
                        <div class="mt-2 flex items-center justify-between text-sm">
                            <div class="text-gray-600">
                                {{ $bayar->dibayar_pada->format('d M Y, H:i') }} &middot; {{ strtoupper($bayar->metode) }} &middot; {{ $bayar->kasir->name ?? '-' }}
                            </div>
                            <div class="font-semibold text-gray-900">Rp {{ number_format($bayar->jumlah_bayar) }}</div>
                        </div>
                    @empty
                        <div class="mt-2 text-sm text-gray-500">Belum ada pembayaran.</div>
                    @endforelse

                    <div class="mt-4 flex items-center justify-between border-t border-gray-200 pt-3">
                        <div class="text-sm font-semibold text-gray-700">Total Dibayar</div>
                        <div class="font-semibold text-gray-900">Rp {{ number_format($servis->totalDibayar) }}</div>
                    </div>
                    <div class="mt-1 flex items-center justify-between">
                        <div class="text-sm font-semibold text-gray-700">Sisa Tagihan</div>
                        <div class="font-semibold text-gray-900">Rp {{ number_format($servis->total_bayar - $servis->totalDibayar) }}</div>
                    </div>
                    <div class="mt-3">
                        @if($servis->lunas)
                            <span class="inline-flex items-center gap-1 rounded-md bg-green-100 px-3 py-1 text-sm font-bold text-green-700">
                                LUNAS
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 rounded-md bg-orange-100 px-3 py-1 text-sm font-bold text-orange-700">
                                BELUM LUNAS &middot; {{ strtoupper($servis->status) }}
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Tanda Tangan -->
                <div class="mt-14 grid grid-cols-2 gap-8 text-sm">
                    <div class="text-center">
                        <div class="text-gray-500">Dikerjakan Oleh</div>
                        <div class="mt-14 font-semibold text-gray-900">{{ $servis->mekanik->name ?? '-' }}</div>
                        <div class="border-t border-gray-400 pt-1 text-xs text-gray-500">Mekanik</div>
                    </div>
                    <div class="text-center">
                        <div class="text-gray-500">{{ $servis->lunas ? 'Pelunasan Diterima Oleh' : 'Diketahui Oleh' }}</div>
                        <div class="mt-14 font-semibold text-gray-900">{{ $servis->pembayarans->last()->kasir->name ?? '-' }}</div>
                        <div class="border-t border-gray-400 pt-1 text-xs text-gray-500">Kasir</div>
                    </div>
                </div>

                <div class="mt-8 text-center text-xs text-gray-400">
                    Terima kasih telah mempercayakan kendaraan Anda kepada kami.
                </div>
            </div>
        </div>
    </body>
</html>