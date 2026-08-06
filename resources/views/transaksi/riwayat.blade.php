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
                            class="w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div>
                        <label class="block text-xs text-gray-500 mb-1">
                            Tanggal
                        </label>

                        <input type="date"
                            name="tanggal"
                            value="{{ request('tanggal') }}"
                            class="border-gray-300 rounded-md shadow-sm">
                    </div>

                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
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

                <table class="min-w-full divide-y divide-gray-200">

                    <thead class="bg-gray-50">
                        <tr class="text-left text-xs font-semibold uppercase text-gray-500">
                            <th class="px-4 py-3">No. Transaksi</th>
                            <th class="px-4 py-3">Barang</th>
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3">Customer</th>
                            <th class="px-4 py-3">Kasir</th>
                            <th class="px-4 py-3">Total</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">

                        @forelse($transaksis as $trx)

                            <tr class="hover:bg-gray-50">

                                <td class="px-4 py-3">
                                    {{ $trx->number_transaction }}
                                </td>

                                <!-- Barang -->
                                <td class="px-4 py-3">
                                    @forelse($trx->details as $detail)
                                        <span class="inline-block bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded mb-1">
                                            {{ $detail->produk->nama_produk ?? '-' }}
                                        </span><br>
                                    @empty
                                        <span class="text-gray-400">-</span>
                                    @endforelse
                                </td>

                                <td class="px-4 py-3">
                                    {{ \Carbon\Carbon::parse($trx->transaction_date)->translatedFormat('d M Y H:i') }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $trx->name_cust }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $trx->kasir->name ?? '-' }}
                                </td>

                                <td class="px-4 py-3 font-semibold">
                                    Rp {{ number_format($trx->total_price, 0, ',', '.') }}
                                </td>

                                <td class="px-4 py-3 text-center">

                                    <a href="{{ route('transaksi.struk', $trx->id) }}"
                                        class="inline-flex items-center gap-1 bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded text-sm">

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