<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Kelola Akun') }}
            </h2>

            <a href="{{ route('users.create') }}"
                class="inline-flex items-center px-4 py-2 bg-teal-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-teal-700 transition">
                + Tambah Akun
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Flash Message --}}
            @if(session('success'))
                <div class="mb-4 rounded-lg bg-green-100 border border-green-300 text-green-700 px-4 py-3">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-lg overflow-hidden">

                {{-- Header --}}
                <div class="px-6 py-4 border-b border-gray-200 flex flex-col md:flex-row md:justify-between md:items-center gap-3">

                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">
                            Data Pengguna
                        </h3>

                        <p class="text-sm text-gray-500">
                            Daftar akun Admin dan Kasir.
                        </p>
                    </div>

                    {{-- Search --}}
                    <form method="GET">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari nama / email..."
                            class="rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500 w-72">
                    </form>

                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">

                    <table class="min-w-full divide-y divide-gray-200">

                        <thead class="bg-gray-50">

                            <tr>

                                <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                                    No
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                                    Nama
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-gray-500">
                                    Email
                                </th>

                                <th class="px-6 py-3 text-center text-xs font-bold uppercase tracking-wider text-gray-500">
                                    Role
                                </th>

                                <th class="px-6 py-3 text-center text-xs font-bold uppercase tracking-wider text-gray-500">
                                    Dibuat
                                </th>

                                <th class="px-6 py-3 text-center text-xs font-bold uppercase tracking-wider text-gray-500">
                                    Aksi
                                </th>

                            </tr>

                        </thead>

                        <tbody class="bg-white divide-y divide-gray-100">

                            @forelse($users as $user)

                                <tr class="hover:bg-gray-50 transition">

                                    <td class="px-6 py-4">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="px-6 py-4">

                                        <div class="flex items-center gap-3">

                                            <div class="w-10 h-10 rounded-full bg-teal-100 flex items-center justify-center font-bold text-teal-700">

                                                {{ strtoupper(substr($user->name, 0, 1)) }}

                                            </div>

                                            <div>

                                                <div class="font-semibold text-gray-800">

                                                    {{ $user->name }}

                                                </div>

                                            </div>

                                        </div>

                                    </td>

                                    <td class="px-6 py-4 text-gray-600">

                                        {{ $user->email }}

                                    </td>

                                    <td class="px-6 py-4 text-center">

                                        @if($user->role == 'admin')

                                            <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold">
                                                Admin
                                            </span>

                                        @else

                                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
                                                Kasir
                                            </span>

                                        @endif

                                    </td>

                                    <td class="px-6 py-4 text-center text-gray-500 text-sm">

                                        {{ $user->created_at->format('d M Y') }}

                                    </td>

                                    <td class="px-6 py-4">

                                        <div class="flex justify-center gap-2">

                                            {{-- Edit --}}
                                            <a href="{{ route('users.edit', $user->id) }}"
                                                class="px-3 py-2 rounded-lg bg-yellow-400 text-white hover:bg-yellow-500 transition">

                                                Edit

                                            </a>

                                            {{-- Delete --}}
                                            <form
                                                action="{{ route('users.destroy', $user->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus akun ini?')">

                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    class="px-3 py-2 rounded-lg bg-red-500 text-white hover:bg-red-600 transition">

                                                    Hapus

                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="6"
                                        class="py-10 text-center text-gray-500">

                                        Belum ada data pengguna.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                {{-- Pagination --}}
                @if(method_exists($users, 'links'))

                    <div class="px-6 py-4 border-t">

                        {{ $users->links() }}

                    </div>

                @endif

            </div>

        </div>
    </div>
</x-app-layout>