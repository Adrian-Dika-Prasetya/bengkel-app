<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold leading-tight text-gray-900">
            Tambah Kendaraan
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-4xl rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="flex items-center gap-3 border-b border-gray-100 px-6 py-4">
                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-orange-50 text-orange-600">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                    </svg>
                </div>
                <h3 class="text-base font-bold text-gray-900">Formulir Kendaraan Baru</h3>
            </div>

            <form action="{{ route('kendaraans.store') }}" method="POST" class="p-6">
                @csrf

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
                                <option value="{{ $p->id }}" @selected(old('pelanggan_id') == $p->id)>{{ $p->nama }}</option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-xs text-gray-500">
                            Pelanggan belum terdaftar?
                            <a href="{{ route('pelanggans.create') }}" class="font-medium text-orange-600 hover:underline">Tambah pelanggan dulu</a>
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Plat Nomor</label>
                        <input type="text" name="plat_nomor" required placeholder="B 1234 ABC" value="{{ old('plat_nomor') }}" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-400 focus:ring-orange-400">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Merk</label>
                        <input type="text" name="merk" required placeholder="Honda" value="{{ old('merk') }}" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-400 focus:ring-orange-400">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tipe</label>
                        <input type="text" name="tipe" required placeholder="Vario 150" value="{{ old('tipe') }}" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-400 focus:ring-orange-400">
                    </div>
                </div>

                <div class="mt-6 flex items-center gap-4">
                    <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-orange-500 px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-orange-600">
                        Simpan Kendaraan
                    </button>
                    <a href="{{ route('kendaraans.index') }}" class="text-sm font-medium text-gray-600 hover:underline">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>