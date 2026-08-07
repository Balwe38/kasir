<x-app-layout>

<x-slot name="header">
    <div class="bg-gradient-to-r from-emerald-600 via-teal-500 to-cyan-500 rounded-2xl shadow-lg p-5 text-white">
        <h2 class="text-3xl font-bold">
            Laporan Penjualan Obat
        </h2>
    </div>
</x-slot>

<div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        {{-- Filter --}}
        <div class="bg-white p-6 rounded-xl shadow">
            <form method="GET">
                <div class="grid md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">
                            Mulai
                        </label>
                        <input type="date"
                            name="mulai"
                            value="{{ $mulai }}"
                            class="border-gray-300 rounded-lg w-full focus:border-teal-500 focus:ring-teal-500">
                    </div>

                    <div>
                        <label class="block text-xs text-gray-500 mb-1">
                            Selesai
                        </label>
                        <input type="date"
                            name="selesai"
                            value="{{ $selesai }}"
                            class="border-gray-300 rounded-lg w-full focus:border-teal-500 focus:ring-teal-500">
                    </div>

                    <div class="flex items-end">
                        <button class="bg-teal-600 hover:bg-teal-700 text-white px-5 py-2 rounded-lg transition">
                            Tampilkan
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Statistik --}}
        <div class="grid md:grid-cols-2 gap-6">
            <div class="bg-teal-600 text-white p-6 rounded-xl">
                <p class="text-sm opacity-80">
                    Total Transaksi
                </p>
                <h2 class="text-4xl font-bold mt-2">
                    {{ $totalTransaksi }}
                </h2>
            </div>

            <div class="bg-emerald-600 text-white p-6 rounded-xl">
                <p class="text-sm opacity-80">
                    Pendapatan
                </p>
                <h2 class="text-3xl font-bold mt-2">
                    Rp {{ number_format($pendapatan,0,',','.') }}
                </h2>
            </div>
        </div>

        {{-- Tabel Laporan --}}
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="p-6 border-b">
                <h3 class="text-lg font-semibold text-teal-700">
                    Detail Transaksi
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-teal-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm text-teal-700">No</th>
                            <th class="px-6 py-3 text-left text-sm text-teal-700">Tanggal</th>
                            <th class="px-6 py-3 text-left text-sm text-teal-700">Kasir</th>
                            {{-- PENAMBAHAN 1: Header Role --}}
                            <th class="px-6 py-3 text-left text-sm text-teal-700">Role</th>
                            <th class="px-6 py-3 text-left text-sm text-teal-700">Total</th>
                            <th class="px-6 py-3 text-left text-sm text-teal-700">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y">
                        @forelse($transaksi as $item)
                            <tr class="hover:bg-teal-50/40">
                                <td class="px-6 py-3">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-6 py-3">
                                    {{ $item->transaction_date }}
                                </td>

                                <td class="px-6 py-3">
                                    {{ $item->kasir->name ?? '-' }}
                                </td>

                                {{-- PENAMBAHAN 2: Data Role --}}
                                <td class="px-6 py-3">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-teal-100 text-teal-800 capitalize">
                                        {{ $item->kasir->role ?? '-' }}
                                    </span>
                                </td>

                                <td class="px-6 py-3">
                                    Rp {{ number_format($item->total_price,0,',','.') }}
                                </td>

                                <td class="px-6 py-3">
                                    <a href="{{ route('transaksi.struk',$item->id) }}" class="text-teal-600 hover:underline">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                {{-- PENAMBAHAN 3: Ubah Colspan menjadi 6 --}}
                                <td colspan="6" class="text-center py-5 text-gray-500">
                                    Belum ada transaksi
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
