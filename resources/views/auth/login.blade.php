<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-slate-900">
        
        <!-- Header & Logo Bengkel -->
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-600 text-white mb-3 shadow-lg shadow-blue-500/30">
                <!-- Icon Wrench / Kunci Pas -->
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-white tracking-wide">SISTEM INFORMASI BENGKEL</h2>
            <p class="text-sm text-slate-400 mt-1">Masuk untuk mengelola transaksi & inventaris</p>
        </div>

        <!-- Card Form Login -->
        <div class="w-full sm:max-w-md px-6 py-8 bg-slate-800 shadow-xl border border-slate-700 overflow-hidden sm:rounded-xl">
            
            <!-- Session Status Alert -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-300">Email Alamat</label>
                    <input id="email" class="block mt-1 w-full rounded-lg bg-slate-900 border-slate-700 text-slate-200 focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5 px-3" 
                           type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="admin@bengkel.com" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <label for="password" class="block text-sm font-medium text-slate-300">Kata Sandi</label>
                    <input id="password" class="block mt-1 w-full rounded-lg bg-slate-900 border-slate-700 text-slate-200 focus:border-blue-500 focus:ring-blue-500 text-sm py-2.5 px-3"
                           type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded bg-slate-900 border-slate-700 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                        <span class="ms-2 text-sm text-slate-400">Ingat saya</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-blue-400 hover:text-blue-300 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" href="{{ route('password.request') }}">
                            Lupa password?
                        </a>
                    @endif
                </div>

                <!-- Submit Button -->
                <div class="mt-6">
                    <button type="submit" class="w-full py-3 px-4 bg-blue-600 hover:bg-blue-500 focus:ring-blue-500 text-white font-semibold rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 transition duration-150">
                        Masuk ke Aplikasi
                    </button>
                </div>

                <!-- Link Register -->
                <div class="mt-6 text-center text-sm text-slate-400">
                    Belum punya akun?
                    <a class="text-blue-400 hover:text-blue-300 underline rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" href="{{ route('register') }}">
                        Daftar di sini
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>