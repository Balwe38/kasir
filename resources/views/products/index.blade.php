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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 flex gap-3">

                    <a href="{{ route('produk.create') }}"
                        class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded">
                        + Tambah Produk
                    </a>

                    <a href="{{ route('kategori.index') }}"
                        class="bg-green-500 hover:bg-green-700 text-white px-4 py-2 rounded">
                        📂 Kategori
                    </a>

                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6 text-gray-900">
                    <table class="min-w-full divide-y divide-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Produk</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stok</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($produks as $produk)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $produk->nama_produk }}</td>

                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        {{ $produk->kategori->nama_kategori ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $produk->stok }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        <a href="{{ route('produk.edit', $produk->id) }}"
                                            class="text-blue-600 hover:text-blue-800 mr-3">Edit</a>
                                        <form action="{{ route('produk.destroy', $produk->id) }}" method="POST"
                                            class="inline" onsubmit="return confirm('Yakin mau hapus produk ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
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