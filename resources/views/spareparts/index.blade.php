<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Data Sparepart / Suku Cadang
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Alert Success -->
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Form Tambah Sparepart -->
            <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                <h3 class="text-lg font-bold mb-4">Tambah Sparepart Baru</h3>
                <form action="{{ route('spareparts.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kode Barang</label>
                        <input type="text" name="kode_barang" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Barang</label>
                        <input type="text" name="nama_barang" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Stok</label>
                        <input type="number" name="stok" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Harga Jual (Rp)</label>
                        <input type="number" name="harga_jual" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div class="md:col-span-4">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">
                            Simpan Sparepart
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tabel Data Sparepart -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Barang</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stok</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($spareparts as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $item->kode_barang }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $item->nama_barang }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $item->stok }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($item->harga_jual) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <form action="{{ route('spareparts.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada data sparepart.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>