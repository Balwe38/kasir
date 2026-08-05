<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Kategori') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900">

                    <form action="{{ route('kategori.store') }}" method="POST">
                        @csrf

                        <div>
                            <x-input-label
                                for="nama_kategori"
                                :value="__('Nama Kategori')" />

                            <x-text-input
                                id="nama_kategori"
                                class="block mt-1 w-full"
                                type="text"
                                name="nama_kategori"
                                :value="old('nama_kategori')"
                                required
                                autofocus />

                            <x-input-error
                                :messages="$errors->get('nama_kategori')"
                                class="mt-2" />
                        </div>

                        <div class="mt-6 flex gap-3">

                            <button
                                type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Simpan
                            </button>

                            <a href="{{ route('kategori.index') }}"
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Kembali
                            </a>

                        </div>

                    </form>

                </div>

            </div>
        </div>
    </div>
</x-app-layout>