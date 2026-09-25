<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="text-xl font-bold leading-tight text-gray-900">
                Edit Sparepart
            </h2>
            <a href="{{ route('spareparts.index') }}" class="text-sm font-medium text-gray-600 hover:underline">&larr; Kembali</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-4xl rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="flex items-center gap-3 border-b border-gray-100 px-6 py-4">
                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-orange-50 text-orange-600">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                    </svg>
                </div>
                <h3 class="text-base font-bold text-gray-900">Formulir Edit Sparepart</h3>
            </div>

            <form action="{{ route('spareparts.update', $sparepart) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                @if($errors->any())
                    <div class="mb-4 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kode Barang</label>
                        <input type="text" name="kode_barang" value="{{ old('kode_barang', $sparepart->kode_barang) }}" disabled class="mt-1 block w-full rounded-lg border-gray-200 bg-gray-50 text-sm text-gray-500">
                        <p class="mt-1 text-xs text-gray-500">Kode barang tidak dapat diubah.</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kategori</label>
                        <select name="kategori_id" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-400 focus:ring-orange-400">
                            <option value="">-- Tanpa Kategori --</option>
                            @foreach($kategoris as $k)
                                <option value="{{ $k->id }}" @selected(old('kategori_id', $sparepart->kategori_id) == $k->id)>{{ $k->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Barang</label>
                        <input type="text" name="nama_barang" required value="{{ old('nama_barang', $sparepart->nama_barang) }}" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-400 focus:ring-orange-400">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Harga Beli (Rp)</label>
                        <input type="number" name="harga_beli" required min="0" value="{{ old('harga_beli', $sparepart->harga_beli) }}" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-400 focus:ring-orange-400">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Harga Jual (Rp)</label>
                        <input type="number" name="harga_jual" required min="0" value="{{ old('harga_jual', $sparepart->harga_jual) }}" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-400 focus:ring-orange-400">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Stok</label>
                        <input type="number" name="stok" required min="0" value="{{ old('stok', $sparepart->stok) }}" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-400 focus:ring-orange-400">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Stok Minimal</label>
                        <input type="number" name="stok_minimal" required min="0" value="{{ old('stok_minimal', $sparepart->stok_minimal) }}" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-400 focus:ring-orange-400">
                    </div>
                </div>

                <div class="mt-6 flex items-center gap-4">
                    <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-orange-500 px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-orange-600">
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('spareparts.index') }}" class="text-sm font-medium text-gray-600 hover:underline">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>