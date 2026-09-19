<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Transaksi Servis Baru
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <form action="{{ route('servises.store') }}" method="POST">
                    @csrf

                    <!-- Pilih Kendaraan & Mekanik -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Pilih Kendaraan / Pelanggan</label>
                            <select name="kendaraan_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">-- Pilih Kendaraan --</option>
                                @foreach($kendaraans as $k)
                                    <option value="{{ $k->id }}">{{ $k->plat_nomor }} - {{ $k->nama_pemilik }} ({{ $k->merk_tipe }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Pilih Mekanik</label>
                            <select name="mekanik_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
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
                        <textarea name="keluhan" rows="2" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Contoh: Ganti oli, serviss rutin, rem bunyi"></textarea>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700">Biaya Jasa Servis (Rp)</label>
                        <input type="number" name="biaya_jasa" value="0" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    <hr class="my-6">

                    <!-- Bagian Pemilihan Sparepart (Baris Dinamis Sederhana) -->
                    <h3 class="text-lg font-bold mb-3">Penggunaan Sparepart (Opsional)</h3>
                    
                    <div id="sparepart-container">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-3 sparepart-row">
                            <div>
                                <select name="sparepart_ids[]" class="block w-full rounded-md border-gray-300 shadow-sm">
                                    <option value="">-- Pilih Sparepart --</option>
                                    @foreach($spareparts as $s)
                                        <option value="{{ $s->id }}">{{ $s->nama_barang }} (Stok: {{ $s->stok }} | Rp {{ number_format($s->harga_jual) }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <input type="number" name="jumlahs[]" placeholder="Jumlah" min="1" class="block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded shadow hover:bg-green-700">
                            Simpan & Diproses
                        </button>
                        <a href="{{ route('servises.index') }}" class="ml-2 text-gray-600 hover:underline">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>