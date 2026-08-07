<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-emerald-600 via-teal-500 to-cyan-500 rounded-2xl shadow-lg p-5 text-white">
            <h2 class="text-3xl font-bold">
                Daftar Obat
            </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm rounded-lg hover:shadow-lg transition-all duration-300">
                <div class="p-4 sm:p-6 flex flex-col sm:flex-row gap-3">

                    <a href="{{ route('produk.create') }}" class="w-full sm:w-auto
            bg-teal-600
            hover:bg-teal-700
            hover:scale-105
            active:scale-95
            transition-all
            duration-200
            text-white
            font-semibold
            py-2.5
            px-5
            rounded-lg
            shadow
            hover:shadow-lg
            text-center">
                        + Tambah Obat
                    </a>



                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-4 sm:p-6 text-gray-900 overflow-x-auto">
                    <table class="min-w-full whitespace-nowrap divide-y divide-gray-200">
                        <thead class="bg-teal-50">
                            <tr class="transition-all duration-200 hover:bg-teal-50">
                                <th class="px-6 py-3 text-left text-xs font-medium text-teal-700 uppercase">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-teal-700 uppercase">Nama Obat
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-teal-700 uppercase">Kategori
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-teal-700 uppercase">Harga</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-teal-700 uppercase">Stok</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-teal-700 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($produks as $produk)
                                <tr class="transition-all duration-200 hover:bg-teal-50/40">
                                    <td class="px-3 sm:px-6 py-3 text-sm text-gray-700">{{ $loop->iteration }}</td>
                                    <td class="px-3 sm:px-6 py-3 text-sm text-gray-700">{{ $produk->nama_produk }}</td>

                                    <td class="px-3 sm:px-6 py-3 text-sm">
                                        @php
                                            // Sesuaikan nama kategori berikut dengan kategori obat
                                            // yang benar-benar ada di tabel `kategoris`.
                                            $badge = match ($produk->kategori->nama_kategori ?? '') {
                                                'Tablet' => 'bg-teal-100 text-teal-800',
                                                'Sirup' => 'bg-cyan-100 text-cyan-800',
                                                'Kapsul' => 'bg-sky-100 text-sky-800',
                                                'Injeksi' => 'bg-red-100 text-red-800',
                                                'Salep' => 'bg-amber-100 text-amber-800',
                                                'Alat Kesehatan' => 'bg-purple-100 text-purple-800',
                                                default => 'bg-gray-100 text-gray-800',
                                            };
                                        @endphp

                                        <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold {{ $badge }}">
                                            {{ $produk->kategori->nama_kategori ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-3 sm:px-6 py-3 text-sm text-gray-700">
                                        Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                    </td>
                                    <td class="px-3 sm:px-6 py-3 text-sm text-gray-700">{{ $produk->stok }}</td>
                                    <td class="px-3 sm:px-6 py-3 text-sm">
                                        <div class="flex items-center gap-2">

                                            <!-- Tombol Lihat Detail Obat -->
                                            <a href="{{ route('produk.detail', $produk->id) }}"
                                                class="inline-flex items-center gap-2 rounded-lg bg-blue-500 hover:bg-blue-600 px-3 py-2 text-white transition">

                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L12 15l-4 1 1-4 8.586-8.586z" />
                                                </svg>

                                                Detail Obat
                                            </a>


                                            <!-- Tombol Edit -->
                                            <a href="{{ route('produk.edit', $produk->id) }}"
                                                class="inline-flex items-center gap-2 rounded-lg px-3 py-2 text-white bg-amber-500 hover:bg-amber-600 transition">

                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L12 15l-4 1 1-4 8.586-8.586z" />
                                                </svg>

                                                Edit
                                            </a>

                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('produk.destroy', $produk->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin mau hapus obat ini?')">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                    class="inline-flex items-center gap-2 rounded-lg bg-red-500 px-3 py-2 text-white hover:bg-red-600 transition">

                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7H5M10 11v6M14 11v6M9 7V4h6v3m-8 0h10l-1 13H8L7 7z" />
                                                    </svg>

                                                    Hapus
                                                </button>

                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr class="transition-all duration-200 hover:bg-teal-50/40">
                                    <td colspan="6" class="px-3 sm:px-6 py-3 text-center text-gray-500">
                                        Belum ada obat.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>