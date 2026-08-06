<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Obat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white
overflow-hidden
shadow-sm
rounded-lg
hover:shadow-lg
transition
duration-300">
                <div class="p-4 sm:p-6 text-gray-900">
                    <form action="{{ route('produk.update', $product->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <!-- Name -->
                        <div class="mt-4">
                            <x-input-label for="name" :value="__('Nama Obat')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="nama_produk"
                                :value="old('nama_produk', $product->nama_produk)" required autofocus
                                autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <!-- Harga -->
                        <div class="mt-4">
                            <x-input-label for="price" :value="__('Harga')" />
                            <x-text-input id="price" class="block mt-1 w-full" type="number" name="harga"
                                :value="old('price', $product->harga)" required autofocus autocomplete="price" />
                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                        </div>
                        <!-- Stok -->
                        <div class="mt-4">
                            <x-input-label for="stok" :value="__('Stok')" />
                            <x-text-input id="stok" class="block mt-1 w-full" type="number" name="stok"
                                :value="old('stok', $product->stok)" required autofocus autocomplete="stok" />
                            <x-input-error :messages="$errors->get('stok')" class="mt-2" />
                        </div>
                        <!-- deksripsi -->
                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Deskripsi')" />
                            <x-text-input id="description" class="block mt-1 w-full" type="text" name="description"
                                :value="old('description', $product->description)" autofocus
                                autocomplete="description" />
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>
                        <!-- kategori -->
                        <div class="mt-4">
                            <x-input-label for="kategori_id" :value="__('Kategori Obat')" />

                            <select id="kategori_id" name="kategori_id"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-teal-500 focus:ring-teal-500"
                                required>
                                <option value="">-- Pilih Kategori --</option>

                                @foreach ($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}" {{ old('kategori_id', $product->kategori_id) == $kategori->id ? 'selected' : '' }}>
                                        {{ $kategori->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>

                            <x-input-error :messages="$errors->get('kategori_id')" class="mt-2" />
                        </div>

                        <input type="submit" value="Simpan" class="mt-6
w-full
sm:w-auto
bg-teal-600
hover:bg-teal-700
text-white
font-semibold
px-6
py-2.5
rounded-lg
transition
duration-200">

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
