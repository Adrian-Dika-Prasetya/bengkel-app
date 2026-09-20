<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold leading-tight text-gray-900">
            Tambah Transaksi Servis Baru
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="flex items-center gap-3 border-b border-gray-100 px-6 py-4">
                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-orange-50 text-orange-600">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085" />
                    </svg>
                </div>
                <h3 class="text-base font-bold text-gray-900">Formulir Servis</h3>
            </div>

            <form action="{{ route('servises.store') }}" method="POST" class="p-6">
                @csrf

                @if($errors->any())
                    <div class="mb-4 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <!-- Pilih Kendaraan & Mekanik -->
                <div class="mb-4 grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Pilih Kendaraan / Pelanggan</label>
                        <select name="kendaraan_id" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-400 focus:ring-orange-400">
                            <option value="">-- Pilih Kendaraan --</option>
                            @foreach($kendaraans as $k)
                                <option value="{{ $k->id }}">{{ $k->plat_nomor }} - {{ $k->pelanggan->nama ?? '-' }} ({{ $k->merk }} {{ $k->tipe }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Pilih Mekanik</label>
                        <select name="mekanik_id" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-400 focus:ring-orange-400">
                            <option value="">-- Tanpa Mekanik / Pilih Nanti --</option>
                            @foreach($mekaniks as $m)
                                <option value="{{ $m->id }}">{{ $m->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Input Keluhan & Biaya Jasa -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Keluhan / Jenis Servis</label>
                    <textarea name="keluhan" rows="2" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-400 focus:ring-orange-400" placeholder="Contoh: Ganti oli, servis rutin, rem bunyi"></textarea>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700">Biaya Jasa Servis (Rp)</label>
                    <input type="number" name="biaya_jasa" value="0" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-400 focus:ring-orange-400">
                </div>

                <hr class="my-6 border-gray-100">

                <!-- Bagian Pemilihan Sparepart (Baris Dinamis Sederhana) -->
                <h3 class="mb-3 text-base font-bold text-gray-900">Penggunaan Sparepart (Opsional)</h3>

                <div id="sparepart-container">
                    <div class="mb-3 grid grid-cols-1 gap-4 md:grid-cols-3 sparepart-row">
                        <div>
                            <select name="sparepart_ids[]" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-400 focus:ring-orange-400">
                                <option value="">-- Pilih Sparepart --</option>
                                @foreach($spareparts as $s)
                                    <option value="{{ $s->id }}">{{ $s->nama_barang }} (Stok: {{ $s->stok }} | Rp {{ number_format($s->harga_jual) }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <input type="number" name="jumlahs[]" placeholder="Jumlah" min="1" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-400 focus:ring-orange-400">
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex items-center gap-3">
                    <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-orange-500 px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-orange-600">
                        Simpan &amp; Diproses
                    </button>
                    <a href="{{ route('servises.index') }}" class="text-sm font-medium text-gray-600 hover:underline">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>