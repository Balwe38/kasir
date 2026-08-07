@php
    $isAdminPage =
        auth()->user()->role === 'admin' &&
        (
            request()->routeIs('admin.dashboard') ||
            request()->routeIs('produk.*') ||
            request()->routeIs('kategori.*') ||
            request()->routeIs('transaksi.*') ||
            request()->routeIs('laporan.*') ||
            request()->routeIs('users.*')
        );
@endphp

<aside class="bg-white border-r border-gray-100 flex flex-col transition-all duration-300 ease-in-out shrink-0"
    :class="sidebarOpen ? 'w-64' : 'w-20'">

    <!-- Logo + Toggle -->
    <div class="flex items-center justify-between h-16 px-4 border-b border-gray-100">
        <a href="{{ $isAdminPage ? route('admin.dashboard') : route('kasir.dashboard') }}" class="flex items-center gap-2 overflow-hidden group">
            <div class="w-8 h-8 shrink-0 flex items-center justify-center rounded-lg bg-teal-600 text-white text-lg transition-transform duration-300 group-hover:rotate-12">
                💊
            </div>
            <span x-show="sidebarOpen" x-transition:enter="transition ease-out duration-200 delay-75"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                class="font-semibold text-gray-800 whitespace-nowrap">Apotek Sehat</span>
        </a>
        <button @click="sidebarOpen = !sidebarOpen"
            class="p-1.5 rounded-md text-gray-400 hover:bg-gray-100 hover:text-gray-600 active:scale-90 transition-all duration-150 shrink-0">
            <svg class="w-5 h-5 transition-transform duration-300" :class="sidebarOpen ? '' : 'rotate-180'" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
            </svg>
        </button>
    </div>

    <!-- Navigation Links -->
    <nav class="flex-1 px-3 py-4 space-y-1" x-data x-init="$el.querySelectorAll('a').forEach((el, i) => {
            el.style.opacity = 0;
            el.style.transform = 'translateX(-8px)';
            setTimeout(() => {
                el.style.transition = 'all 0.3s ease-out';
                el.style.opacity = 1;
                el.style.transform = 'translateX(0)';
            }, i * 80);
         })">

        <!-- //dashboard -->
        <a href="{{ $isAdminPage ? route('admin.dashboard') : route('kasir.dashboard') }}" class="group relative flex items-center gap-3 px-3 py-2.5 rounded-lg
transition-all duration-300 ease-out
hover:bg-teal-50
hover:text-teal-600
hover:translate-x-2
hover:shadow-md
{{ request()->routeIs('admin.dashboard') || request()->routeIs('kasir.dashboard')
    ? 'bg-teal-600 text-white shadow-lg scale-[1.02]'
    : 'text-gray-600'
}}">

            <span
                class="absolute left-0 top-1/2 -translate-y-1/2 w-1 bg-teal-600 rounded-r-full transition-all duration-300
                {{ request()->routeIs('admin.dashboard') || request()->routeIs('kasir.dashboard') ? 'h-6' : 'h-0' }}"></span>

            <svg class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-110" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span x-show="sidebarOpen" x-transition:enter="transition ease-out duration-200 delay-75"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="whitespace-nowrap">
                {{ $isAdminPage ? 'Admin Dashboard' : 'Kasir Dashboard' }}
            </span>
        </a>

        <!-- //produk / obat -->
        <a href="{{ url('products') }}" class="group relative flex items-center gap-3 px-3 py-2.5 rounded-lg
transition-all duration-300 ease-out
hover:bg-teal-50
hover:text-teal-600
hover:translate-x-2
hover:shadow-md
{{ request()->routeIs('produk.*')
    ? 'bg-teal-600 text-white shadow-lg scale-[1.02]'
    : 'text-gray-600'
}}">

            <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 bg-teal-600 rounded-r-full transition-all duration-300
                {{ request()->routeIs('produk.*') ? 'h-6' : 'h-0' }}"></span>

            <svg class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-110" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H6.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 0011 10.172V5L10 4z" />
            </svg>
            <span x-show="sidebarOpen" x-transition:enter="transition ease-out duration-200 delay-75"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                class="whitespace-nowrap">Obat</span>

            <span x-show="!sidebarOpen" x-transition:enter="transition ease-out duration-150 delay-300"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="hidden group-hover:block absolute left-full ml-2 px-2 py-1 bg-gray-800 text-white text-xs rounded-md whitespace-nowrap z-20">
                Obat
            </span>
        </a>

        <!-- //kategori -->
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('kategori.index') }}" class="group relative flex items-center gap-3 px-3 py-2.5 rounded-lg
                                    transition-all duration-300 ease-out
                                    hover:bg-teal-50
                                    hover:text-teal-600
                                    hover:translate-x-2
                                    hover:shadow-md
                                    {{ request()->routeIs('kategori.*')
        ? 'bg-teal-600 text-white shadow-lg scale-[1.02]'
        : 'text-gray-600'
                                    }}">

                <span
                    class="absolute left-0 top-1/2 -translate-y-1/2 w-1 bg-teal-600 rounded-r-full transition-all duration-300
                                                                                {{ request()->routeIs('kategori.*') ? 'h-6' : 'h-0' }}"></span>

                <svg class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-110" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 7h.01M7 3h5c.512 0 1.023.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>

                <span x-show="sidebarOpen" x-transition:enter="transition ease-out duration-200 delay-75"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    class="whitespace-nowrap">Kategori Obat</span>

                <span x-show="!sidebarOpen" x-transition:enter="transition ease-out duration-150 delay-300"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="hidden group-hover:block absolute left-full ml-2 px-2 py-1 bg-gray-800 text-white text-xs rounded-md whitespace-nowrap z-20">
                    Kategori Obat
                </span>
            </a>
        @endif

        <!-- //transaksi -->
        <a href="{{ url('transaksi') }}" class="group relative flex items-center gap-3 px-3 py-2.5 rounded-lg
transition-all duration-300 ease-out
hover:bg-teal-50
hover:text-teal-600
hover:translate-x-2
hover:shadow-md
{{ request()->routeIs('transaksi.*')
    ? 'bg-teal-600 text-white shadow-lg scale-[1.02]'
    : 'text-gray-600'
}}">

            <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 bg-teal-600 rounded-r-full transition-all duration-300
                {{ request()->routeIs('transaksi.*') ? 'h-6' : 'h-0' }}"></span>

            <svg class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-110" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
            </svg>
            <span x-show="sidebarOpen" x-transition:enter="transition ease-out duration-200 delay-75"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                class="whitespace-nowrap">Transaksi</span>

            <span x-show="!sidebarOpen" x-transition:enter="transition ease-out duration-150 delay-300"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="hidden group-hover:block absolute left-full ml-2 px-2 py-1 bg-gray-800 text-white text-xs rounded-md whitespace-nowrap z-20">
                Transaksi
            </span>
        </a>

        <!-- //Laporan -->
        @if(auth()->user()->role === 'admin')

<a href="{{ route('laporan.index') }}"
class="group relative flex items-center gap-3 px-3 py-2.5 rounded-lg
transition-all duration-300
hover:bg-teal-50 hover:text-teal-600

{{ request()->routeIs('laporan.*')
    ? 'bg-teal-600 text-white'
    : 'text-gray-600'
}}">

    <svg class="w-5 h-5" fill="none"
        stroke="currentColor"
        viewBox="0 0 24 24">

        <path stroke-linecap="round"
        stroke-linejoin="round"
        stroke-width="2"
        d="M9 17v-6h6v6m2 4H7a2 2 0 01-2-2V5a2 2 0 012-2h5l2 2h3a2 2 0 012 2v12a2 2 0 01-2 2z"/>
    </svg>


    <span x-show="sidebarOpen">
        Laporan
    </span>

</a>

@endif

{{-- Kelola Akun --}}
@if(auth()->user()->role === 'admin')
<a href="{{ route('users.index') }}"
    class="group relative flex items-center gap-3 px-3 py-2.5 rounded-lg
    transition-all duration-300 ease-out
    hover:bg-teal-50
    hover:text-teal-600
    hover:translate-x-2
    hover:shadow-md
    {{ request()->routeIs('users.*')
        ? 'bg-teal-600 text-white shadow-lg scale-[1.02]'
        : 'text-gray-600'
    }}">

    <span
        class="absolute left-0 top-1/2 -translate-y-1/2 w-1 bg-teal-600 rounded-r-full transition-all duration-300
        {{ request()->routeIs('users.*') ? 'h-6' : 'h-0' }}">
    </span>

    <svg class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-110"
        fill="none"
        stroke="currentColor"
        viewBox="0 0 24 24">
        <path stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M17 20h5V4H2v16h5m10 0v-2a4 4 0 00-4-4H11a4 4 0 00-4 4v2m10 0H7m10-10a4 4 0 11-8 0 4 4 0 018 0z"/>
    </svg>

    <span x-show="sidebarOpen"
        x-transition:enter="transition ease-out duration-200 delay-75"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        class="whitespace-nowrap">
        Kelola Akun
    </span>

    <span x-show="!sidebarOpen"
        class="hidden group-hover:block absolute left-full ml-2 px-2 py-1 bg-gray-800 text-white text-xs rounded-md whitespace-nowrap z-20">
        Kelola Akun
    </span>
</a>
@endif


    </nav>

    <!-- User dropdown di bawah sidebar -->
    <div class="border-t border-gray-100 p-3">
        <div x-data="{ userOpen: false }" class="relative">
            <button @click="userOpen = !userOpen"
                class="flex items-center gap-3 w-full px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 active:scale-95 transition-all duration-150">
                <div
                    class="w-7 h-7 rounded-full bg-teal-100 flex items-center justify-center shrink-0 text-xs font-semibold text-teal-700 transition-transform duration-200 hover:scale-105">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <span x-show="sidebarOpen" x-transition:enter="transition ease-out duration-200 delay-75"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    class="whitespace-nowrap flex-1 text-left">{{ Auth::user()->name }}</span>
            </button>

            <!-- Dropdown menu -->
            <div x-show="userOpen" @click.outside="userOpen = false"
                x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                class="absolute bottom-full left-0 mb-2 w-full min-w-[180px] bg-white rounded-lg shadow-lg border border-gray-100 py-1 z-10">

                <a href="{{ route('profile.edit') }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-150">Profile</a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-150">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</aside>
