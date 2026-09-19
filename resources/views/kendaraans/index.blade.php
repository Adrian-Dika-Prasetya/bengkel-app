<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Data Pelanggan & Kendaraan
        </h2>
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

            <!-- Form Tambah Pelanggan -->
            <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                <h3 class="text-lg font-bold mb-4">Tambah Pelanggan Baru</h3>
                <form action="{{ route('pelanggans.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama</label>
                        <input type="text" name="nama" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Andi Wijaya">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">No. HP</label>
                        <input type="text" name="no_hp" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="081234567890">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Alamat</label>
                        <input type="text" name="alamat" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Jl. Merdeka No.1">
                    </div>
                    <div class="md:col-span-3">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">
                            Simpan Pelanggan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Form Tambah Kendaraan -->
            <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                <h3 class="text-lg font-bold mb-4">Tambah Kendaraan Baru</h3>
                <form action="{{ route('kendaraans.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Pelanggan</label>
                        <select name="pelanggan_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">-- Pilih Pelanggan --</option>
                            @foreach($pelanggans as $p)
                                <option value="{{ $p->id }}">{{ $p->nama }}</option>
                            @endforeach
                        </select>
                        @error('pelanggan_id')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Plat Nomor</label>
                        <input type="text" name="plat_nomor" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="B 1234 ABC">
                        @error('plat_nomor')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Merk</label>
                        <input type="text" name="merk" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Honda">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tipe</label>
                        <input type="text" name="tipe" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Vario 150">
                    </div>
                    <div class="md:col-span-4">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">
                            Simpan Kendaraan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tabel Data Kendaraan -->
            <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                <h3 class="text-lg font-bold mb-4">Daftar Kendaraan</h3>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Plat Nomor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pemilik</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Merk</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipe</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($kendaraans as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap font-mono">{{ $item->plat_nomor }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $item->pelanggan->nama ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $item->merk }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $item->tipe }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <form action="{{ route('kendaraans.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada data kendaraan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Tabel Data Pelanggan -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-bold mb-4">Daftar Pelanggan ({{ $pelanggans->count() }})</h3>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. HP</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Alamat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jml Kendaraan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($pelanggans as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $item->nama }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $item->no_hp }}</td>
                                <td class="px-6 py-4">{{ $item->alamat ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $item->kendaraans->count() }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <form action="{{ route('pelanggans.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data pelanggan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada data pelanggan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>