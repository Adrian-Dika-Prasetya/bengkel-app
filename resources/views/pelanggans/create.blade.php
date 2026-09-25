<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold leading-tight text-gray-900">
            Tambah Pelanggan
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-3xl rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="flex items-center gap-3 border-b border-gray-100 px-6 py-4">
                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-orange-50 text-orange-600">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                </div>
                <h3 class="text-base font-bold text-gray-900">Formulir Pelanggan Baru</h3>
            </div>

            <form action="{{ route('pelanggans.store') }}" method="POST" class="p-6">
                @csrf

                @if($errors->any())
                    <div class="mb-4 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama</label>
                        <input type="text" name="nama" required placeholder="Andi Wijaya" value="{{ old('nama') }}" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-400 focus:ring-orange-400">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">No. HP</label>
                        <input type="text" name="no_hp" required placeholder="081234567890" value="{{ old('no_hp') }}" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-400 focus:ring-orange-400">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Alamat</label>
                        <input type="text" name="alamat" placeholder="Jl. Merdeka No.1" value="{{ old('alamat') }}" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-400 focus:ring-orange-400">
                    </div>
                </div>

                <div class="mt-6 flex items-center gap-4">
                    <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-orange-500 px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-orange-600">
                        Simpan Pelanggan
                    </button>
                    <a href="{{ route('kendaraans.index') }}" class="text-sm font-medium text-gray-600 hover:underline">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>