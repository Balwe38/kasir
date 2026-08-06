<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Kategori Obat') }}
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

                    <a href="{{ route('kategori.create') }}" class="w-full sm:w-auto
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
                        + Tambah Kategori Obat
                    </a>



                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-4 sm:p-6 text-gray-900 overflow-x-auto">

                    <table class="min-w-full whitespace-nowrap divide-y divide-gray-200">
                        <thead class="bg-teal-50">
                            <tr class="transition-all duration-200 hover:bg-teal-50">
                                <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-teal-700 uppercase">No
                                </th>
                                <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-teal-700 uppercase">Nama
                                    Kategori</th>
                                <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-teal-700 uppercase">
                                    Jumlah
                                    Obat</th>
                                <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-teal-700 uppercase">Aksi
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200">

                            @forelse ($kategoris as $kategori)
                                <tr class="transition-all duration-200 hover:bg-teal-50/40">
                                    <td class="px-3 sm:px-6 py-4 text-sm text-gray-700">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="px-3 sm:px-6 py-4 text-sm text-gray-700">
                                        {{ $kategori->nama_kategori }}
                                    </td>

                                    <td class="px-3 sm:px-6 py-4 text-sm text-gray-700">
                                        {{ $kategori->produks->count() }}
                                    </td>

                                    <td class="px-3 sm:px-6 py-4 text-sm">

                                        <a href="{{ route('kategori.edit', $kategori->id) }}" class="inline-block
                                        px-3
                                        py-1
                                        rounded-md
                                        text-teal-600
                                        hover:bg-teal-600
                                        hover:text-white
                                        transition-all
                                        duration-200
                                        mr-2">
                                            Edit
                                        </a>

                                        <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST"
                                            class="inline" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">

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
                                        duration-200">
                                                Hapus
                                            </button>

                                        </form>

                                    </td>
                                </tr>

                            @empty

                                <tr class="transition-all duration-200 hover:bg-teal-50/40">
                                    <td colspan="4" class="px-3 sm:px-6 py-4 text-center text-gray-500">
                                        Belum ada kategori.
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
