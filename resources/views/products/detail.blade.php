<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Detail Obat
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto">

            <div class="bg-white shadow rounded-xl overflow-hidden">

                <div class="bg-teal-600 text-white p-6">
                    <h1 class="text-2xl font-bold">
                        {{ $produk->nama_produk }}
                    </h1>

                    <p class="opacity-80">
                        Informasi lengkap obat
                    </p>
                </div>

                <div class="p-8">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div>
                            <p class="text-sm text-gray-500">
                                Nama Obat
                            </p>

                            <p class="text-lg font-semibold">
                                {{ $produk->nama_produk }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">
                                Kategori
                            </p>

                            <span class="inline-flex px-3 py-1 rounded-full bg-teal-100 text-teal-700 font-semibold">
                                {{ $produk->kategori->nama_kategori }}
                            </span>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">
                                Harga
                            </p>

                            <p class="text-lg font-semibold text-green-600">
                                Rp {{ number_format($produk->harga, 0, ',', '.') }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">
                                Stok
                            </p>

                            @if($produk->stok > 50)
                                <span class="px-3 py-1 rounded-full bg-green-100 text-green-700">
                                    {{ $produk->stok }} (Banyak)
                                </span>
                            @elseif($produk->stok > 10)
                                <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700">
                                    {{ $produk->stok }} (Sedang)
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full bg-red-100 text-red-700">
                                    {{ $produk->stok }} (Hampir Habis)
                                </span>
                            @endif
                        </div>

                        <div class="md:col-span-2">
                            <p class="text-sm text-gray-500">
                                Deskripsi
                            </p>

                            <div class="mt-2 p-4 rounded-lg bg-gray-50 border">
                                {{ $produk->deskripsi ?? 'Tidak ada deskripsi.' }}
                            </div>
                        </div>

                    </div>

                    <div class="mt-8 flex gap-3">

                        <a href="{{ route('produk.index') }}"
                            class="px-5 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                            Kembali
                        </a>

                        <a href="{{ route('produk.edit', $produk->id) }}"
                            class="px-5 py-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600">
                            Edit Obat
                        </a>

                    </div>

                </div>

            </div>

        </div>
    </div>
</x-app-layout>