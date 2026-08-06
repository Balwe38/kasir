<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Riwayat Transaksi
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Form Pencarian -->
            <div class="bg-white shadow-sm rounded-lg p-6">
                <form method="GET" action="{{ route('transaksi.riwayat') }}"
                    class="flex flex-wrap gap-3 items-end">

                    <div class="flex-1 min-w-[220px]">
                        <label class="block text-xs text-gray-500 mb-1">
                            Cari (Customer / No. Transaksi)
                        </label>

                        <input type="text"
                            name="cari"
                            value="{{ request('cari') }}"
                            placeholder="Cari..."
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-teal-500 focus:ring-teal-500">
                    </div>

                    <div>
                        <label class="block text-xs text-gray-500 mb-1">
                            Tanggal
                        </label>

                        <input type="date"
                            name="tanggal"
                            value="{{ request('tanggal') }}"
                            class="border-gray-300 rounded-md shadow-sm focus:border-teal-500 focus:ring-teal-500">
                    </div>

                    <button type="submit"
                        class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-md">
                        Cari
                    </button>

                    @if(request('cari') || request('tanggal'))
                        <a href="{{ route('transaksi.riwayat') }}"
                            class="text-sm text-gray-600 underline py-2">
                            Reset
                        </a>
                    @endif

                </form>
            </div>


            <!-- Tabel -->
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">

                <div class="overflow-x-auto">
                    <table class="min-w-[900px] w-full divide-y divide-gray-200">

                        <thead class="bg-teal-50">
                            <tr class="text-left text-xs font-semibold uppercase text-teal-700">
                                <th class="px-4 py-3 whitespace-nowrap">No. Transaksi</th>
                                <th class="px-4 py-3 whitespace-nowrap">Obat</th>
                                <th class="px-4 py-3 whitespace-nowrap">Tanggal</th>
                                <th class="px-4 py-3 whitespace-nowrap">Customer</th>
                                <th class="px-4 py-3 whitespace-nowrap">Kasir</th>
                                <th class="px-4 py-3 whitespace-nowrap">Total</th>
                                <th class="px-4 py-3 text-center whitespace-nowrap">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200">

                            @forelse($transaksis as $trx)

                                <tr class="hover:bg-teal-50/40">

                                    <td class="px-4 py-3 whitespace-nowrap">
                                        {{ $trx->number_transaction }}
                                    </td>

                                    <!-- Barang -->
                                    <td class="px-4 py-3">
                                        @forelse($trx->details as $detail)
                                            <span class="inline-block bg-teal-100 text-teal-700 text-xs px-2 py-1 rounded mb-1 whitespace-nowrap">
                                                {{ $detail->produk->nama_produk ?? '-' }}
                                            </span><br>
                                        @empty
                                            <span class="text-gray-400">-</span>
                                        @endforelse
                                    </td>

                                    <td class="px-4 py-3 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($trx->transaction_date)->translatedFormat('d M Y H:i') }}
                                    </td>

                                    <td class="px-4 py-3 whitespace-nowrap">
                                        {{ $trx->name_cust }}
                                    </td>

                                    <td class="px-4 py-3 whitespace-nowrap">
                                        {{ $trx->kasir->name ?? '-' }}
                                    </td>

                                    <td class="px-4 py-3 font-semibold whitespace-nowrap">
                                        Rp {{ number_format($trx->total_price, 0, ',', '.') }}
                                    </td>

                                    <td class="px-4 py-3 text-center whitespace-nowrap">

                                        <a href="{{ route('transaksi.struk', $trx->id) }}"
                                            class="inline-flex items-center gap-1 bg-teal-600 hover:bg-teal-700 text-white px-3 py-2 rounded text-sm">

                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="w-4 h-4"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor">

                                                <path stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M9 12h6m-6 4h6M7 4h10a2 2 0 012 2v14l-3-2-3 2-3-2-3 2V6a2 2 0 012-2z"/>

                                            </svg>

                                            Lihat Struk

                                        </a>

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="7" class="py-6 text-center text-gray-500">
                                        Belum ada transaksi.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>
                </div>

                <div class="p-4">
                    {{ $transaksis->links() }}
                </div>

            </div>

            <div>
                <a href="{{ route('transaksi.index') }}"
                    class="text-sm text-gray-600 hover:underline">
                    ← Kembali ke Transaksi
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
