<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="text-xl font-bold leading-tight text-gray-900">
                Edit Kendaraan
            </h2>
            <a href="{{ route('kendaraans.index') }}" class="text-sm font-medium text-gray-600 hover:underline">&larr; Kembali</a>
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
                <h3 class="text-base font-bold text-gray-900">Formulir Edit Kendaraan</h3>
            </div>

            <form action="{{ route('kendaraans.update', $kendaraan) }}" method="POST" class="p-6">
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
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Pelanggan</label>
                        <select name="pelanggan_id" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-400 focus:ring-orange-400">
                            <option value="">-- Pilih Pelanggan --</option>
                            @foreach($pelanggans as $p)
                                <option value="{{ $p->id }}" @selected(old('pelanggan_id', $kendaraan->pelanggan_id) == $p->id)>{{ $p->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Plat Nomor</label>
                        <input type="text" name="plat_nomor" required value="{{ old('plat_nomor', $kendaraan->plat_nomor) }}" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-400 focus:ring-orange-400">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Merk</label>
                        <input type="text" name="merk" required value="{{ old('merk', $kendaraan->merk) }}" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-400 focus:ring-orange-400">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tipe</label>
                        <input type="text" name="tipe" required value="{{ old('tipe', $kendaraan->tipe) }}" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-400 focus:ring-orange-400">
                    </div>
                </div>

                <div class="mt-6 flex items-center gap-4">
                    <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-orange-500 px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-orange-600">
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('kendaraans.index') }}" class="text-sm font-medium text-gray-600 hover:underline">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>