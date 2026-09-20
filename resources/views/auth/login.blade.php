<x-guest-layout>
    <div class="flex min-h-screen flex-col items-center bg-slate-900 px-4 pt-6 sm:justify-center sm:pt-0">
        <div class="grid w-full max-w-4xl overflow-hidden rounded-2xl bg-slate-800 shadow-2xl ring-1 ring-slate-700 lg:grid-cols-2">
            <!-- Panel Brand -->
            <div class="relative hidden flex-col justify-between bg-gradient-to-br from-orange-500 to-orange-600 p-10 lg:flex">
                <div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/15 text-white">
                        <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z" />
                        </svg>
                    </div>
                    <h1 class="mt-6 text-3xl font-bold leading-tight text-white">Sistem Informasi Bengkel</h1>
                    <p class="mt-3 text-sm leading-relaxed text-orange-100">
                        Kelola pelanggan, kendaraan, sparepart, transaksi servis, dan pembayaran dalam satu aplikasi yang rapi dan teraudit.
                    </p>
                </div>
                <div class="space-y-2 text-sm text-orange-100">
                    <p class="flex items-center gap-2">
                        <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Peran khusus: Admin, Kasir, dan Mekanik
                    </p>
                    <p class="flex items-center gap-2">
                        <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Pantau stok &amp; riwayat pembayaran
                    </p>
                </div>
            </div>

            <!-- Panel Form -->
            <div class="p-8 sm:p-10">
                <div class="mb-6 flex items-center gap-3 lg:hidden">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-orange-500 text-white">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-sm font-bold text-white">BENGKEL APP</div>
                        <div class="text-xs text-slate-400">Sistem Informasi Bengkel</div>
                    </div>
                </div>

                <h2 class="text-2xl font-bold text-white">Masuk</h2>
                <p class="mt-1 text-sm text-slate-400">Silakan masuk untuk mengelola operasional bengkel.</p>

                <x-auth-session-status class="mt-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="mt-6">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-300">Email Alamat</label>
                        <input id="email" class="mt-1 block w-full rounded-lg border-slate-700 bg-slate-900 py-2.5 px-3 text-sm text-slate-200 placeholder-slate-500 focus:border-orange-400 focus:ring-orange-400"
                               type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="admin@bengkel.com" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <label for="password" class="block text-sm font-medium text-slate-300">Kata Sandi</label>
                        <input id="password" class="mt-1 block w-full rounded-lg border-slate-700 bg-slate-900 py-2.5 px-3 text-sm text-slate-200 placeholder-slate-500 focus:border-orange-400 focus:ring-orange-400"
                               type="password" name="password" required autocomplete="current-password" placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="mt-4 flex items-center justify-between">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded border-slate-700 bg-slate-900 text-orange-500 shadow-sm focus:ring-orange-400" name="remember">
                            <span class="ms-2 text-sm text-slate-400">Ingat saya</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="rounded-md text-sm text-orange-400 underline hover:text-orange-300 focus:outline-none focus:ring-2 focus:ring-orange-400 focus:ring-offset-2 focus:ring-offset-slate-800" href="{{ route('password.request') }}">
                                Lupa password?
                            </a>
                        @endif
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="w-full rounded-lg bg-orange-500 py-3 px-4 font-semibold text-white shadow-lg shadow-orange-500/25 transition hover:bg-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-400 focus:ring-offset-2 focus:ring-offset-slate-800">
                            Masuk ke Aplikasi
                        </button>
                    </div>

                    <div class="mt-6 text-center text-sm text-slate-400">
                        Belum punya akun?
                        <a class="rounded-md text-orange-400 underline hover:text-orange-300 focus:outline-none focus:ring-2 focus:ring-orange-400 focus:ring-offset-2 focus:ring-offset-slate-800" href="{{ route('register') }}">
                            Daftar di sini
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>