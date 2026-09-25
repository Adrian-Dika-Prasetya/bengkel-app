<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
       class="fixed inset-y-0 left-0 z-40 flex w-64 transform flex-col bg-slate-900 transition-transform duration-200 ease-in-out lg:translate-x-0">
    <!-- Brand -->
    <div class="flex h-16 shrink-0 items-center gap-3 border-b border-slate-800 px-5">
        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-orange-500 text-white shadow-lg shadow-orange-500/30">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z" />
            </svg>
        </div>
        <div class="leading-tight">
<div class="text-sm font-bold tracking-wide text-white">BENGKEL ADRIAN</div>
            <div class="text-[11px] text-slate-400">Kelola servis &amp; inventaris</div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 space-y-1 overflow-y-auto px-3 py-4">
        <p class="px-3 pb-2 text-[11px] font-semibold uppercase tracking-wider text-slate-500">Menu Utama</p>

        @php
            $menu = [];
            $menu[] = [
                'label' => 'Dashboard',
                'route' => 'dashboard',
                'active' => request()->routeIs('dashboard'),
                'icon' => 'M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75',
            ];
            if (Auth::user()->isAdmin()) {
                $menu[] = [
                    'label' => 'Data Sparepart',
                    'route' => 'spareparts.index',
                    'active' => request()->routeIs('spareparts.*'),
                    'icon' => 'M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0l-3-3m3 3l3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z',
                ];
            }
            if (Auth::user()->isAdmin() || Auth::user()->isKasir()) {
                $menu[] = [
                    'label' => 'Data Kendaraan',
                    'route' => 'kendaraans.index',
                    'active' => request()->routeIs('kendaraans.*'),
                    'icon' => 'M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12',
                ];
            }
            $menu[] = [
                'label' => 'Transaksi Servis',
                'route' => 'servises.index',
                'active' => request()->routeIs('servises.*'),
                'icon' => 'M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z',
            ];
        @endphp

        @foreach($menu as $item)
            <a href="{{ route($item['route']) }}"
               @class([
                   'group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition',
                   'bg-slate-800 text-white' => $item['active'],
                   'text-slate-400 hover:bg-slate-800/60 hover:text-white' => ! $item['active'],
               ])>
                <svg class="h-5 w-5 shrink-0 {{ $item['active'] ? 'text-orange-400' : 'text-slate-500 group-hover:text-orange-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                </svg>
                {{ $item['label'] }}
            </a>
        @endforeach
    </nav>

    <!-- User Area -->
    <div class="shrink-0 border-t border-slate-800 p-3">
        <div class="flex items-center gap-3 rounded-lg px-3 py-2">
            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-orange-500/20 text-sm font-bold uppercase text-orange-400">
                {{ \Illuminate\Support\Str::substr(Auth::user()->name, 0, 1) }}
            </div>
            <div class="min-w-0 flex-1 leading-tight">
                <div class="truncate text-sm font-semibold text-white">{{ Auth::user()->name }}</div>
                <div class="truncate text-[11px] text-slate-400">{{ ucfirst(Auth::user()->role) }}</div>
            </div>
        </div>

        <div class="mt-2 space-y-1">
            <a href="{{ route('profile.edit') }}" class="group flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium text-slate-400 transition hover:bg-slate-800/60 hover:text-white">
                <svg class="h-5 w-5 shrink-0 text-slate-500 group-hover:text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                </svg>
                Profile
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="group flex w-full items-center gap-3 rounded-lg px-3 py-2 text-left text-sm font-medium text-slate-400 transition hover:bg-slate-800/60 hover:text-white">
                    <svg class="h-5 w-5 shrink-0 text-slate-500 group-hover:text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                    </svg>
                    Log Out
                </button>
            </form>
        </div>
    </div>
</aside>

<!-- Mobile overlay -->
<div :class="sidebarOpen ? 'block' : 'hidden'" @click="sidebarOpen = false" class="fixed inset-0 z-30 bg-slate-900/60 lg:hidden"></div>