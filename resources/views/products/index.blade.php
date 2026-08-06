<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('List Produk') }}
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
            bg-blue-600
            hover:bg-blue-700
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
                        + Tambah Produk
                    </a>



                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-4 sm:p-6 text-gray-900 overflow-x-auto">
                    <table class="min-w-full whitespace-nowrap divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr class="transition-all duration-200 hover:bg-gray-50">
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Produk
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stok</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($produks as $produk)
                                <tr class="transition-all duration-200 hover:bg-gray-50">
                                    <td class="px-3 sm:px-6 py-3 text-sm text-gray-700">{{ $loop->iteration }}</td>
                                    <td class="px-3 sm:px-6 py-3 text-sm text-gray-700">{{ $produk->nama_produk }}</td>

                                    <td class="px-3 sm:px-6 py-3 text-sm">
                                        @php
                                            $badge = match ($produk->kategori->nama_kategori ?? '') {
                                                'Sembako' => 'bg-green-100 text-green-800',
                                                'Minuman' => 'bg-blue-100 text-blue-800',
                                                'Snack' => 'bg-yellow-100 text-yellow-800',
                                                'Makanan' => 'bg-red-100 text-red-800',
                                                'Elektronik' => 'bg-purple-100 text-purple-800',
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
                                        <a href="{{ route('produk.edit', $produk->id) }}" class="inline-block
                                            px-3
                                            py-1
                                            rounded-md
                                            text-blue-600
                                            hover:bg-blue-600
                                            hover:text-white
                                            transition-all
                                            duration-200
                                            mr-2">Edit</a>
                                        <form action="{{ route('produk.destroy', $produk->id) }}" method="POST"
                                            class="inline" onsubmit="return confirm('Yakin mau hapus produk ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-block
                                            px-3
                                            py-1
                                            rounded-md
                                            text-red-600
                                            hover:bg-red-600
                                            hover:text-white
                                            transition-all
                                            duration-200">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr class="transition-all duration-200 hover:bg-gray-50">
                                    <td colspan="6" class="px-3 sm:px-6 py-3 text-center text-gray-500">
                                        Belum ada produk.
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