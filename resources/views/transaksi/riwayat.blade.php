<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Riwayat Transaksi
        </h2>
    </x-slot>

    <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        {{-- Header --}}
        <div class="bg-gradient-to-r from-emerald-600 via-teal-500 to-cyan-500 rounded-3xl shadow-xl p-6 text-white">

            <div class="flex justify-between items-center">

                <div>
                    <h2 class="text-3xl font-bold">
                        📋 Riwayat Transaksi
                    </h2>

                    <p class="text-sm opacity-90 mt-2">
                        Daftar seluruh transaksi penjualan Apotek Sehat
                    </p>
                </div>

                <a href="{{ route('transaksi.index') }}"
                    class="bg-white text-emerald-700 font-bold px-5 py-3 rounded-xl hover:scale-105 transition">
                    + Transaksi Baru
                </a>

            </div>

        </div>


        {{-- Filter --}}
        <div class="bg-white rounded-3xl shadow-xl border border-emerald-100 p-6">

            <form method="GET"
                action="{{ route('transaksi.riwayat') }}"
                class="grid grid-cols-1 md:grid-cols-3 gap-4">

                {{-- Search --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        🔎 Cari Transaksi
                    </label>

                    <input
                        type="text"
                        name="cari"
                        value="{{ request('cari') }}"
                        placeholder="Nama customer / nomor transaksi..."
                        class="w-full rounded-xl border-emerald-300
                        focus:border-emerald-500
                        focus:ring-emerald-500">
                </div>


                {{-- Tanggal --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        📅 Tanggal
                    </label>

                    <input
                        type="date"
                        name="tanggal"
                        value="{{ request('tanggal') }}"
                        class="w-full rounded-xl border-emerald-300
                        focus:border-emerald-500
                        focus:ring-emerald-500">
                </div>


                {{-- Button --}}
                <div class="flex items-end gap-2">

                    <button
                        type="submit"
                        class="flex-1 bg-gradient-to-r
                        from-emerald-600 to-teal-500
                        hover:from-emerald-700 hover:to-teal-600
                        text-white font-bold
                        py-3 rounded-xl
                        transition">

                        🔎 Cari
                    </button>

                    <a
                        href="{{ route('transaksi.riwayat') }}"
                        class="px-5 py-3 rounded-xl
                        bg-gray-100
                        hover:bg-gray-200
                        text-gray-700
                        font-semibold">

                        Reset
                    </a>

                </div>

            </form>

        </div>


        {{-- Tabel --}}
        <div class="bg-white rounded-3xl shadow-xl border border-emerald-100 overflow-hidden">

            <div class="p-6 border-b border-gray-100">

                <div class="flex justify-between items-center">

                    <div>
                        <h3 class="text-2xl font-bold text-emerald-700">
                            Daftar Transaksi
                        </h3>

                        <p class="text-sm text-gray-500 mt-1">
                            Menampilkan {{ $transaksis->total() }} transaksi
                        </p>
                    </div>

                </div>

            </div>


            <div class="overflow-x-auto">

                <table class="min-w-full">

                    <thead>
                        <tr class="bg-emerald-50 text-emerald-800 text-sm">

                            <th class="px-6 py-4 text-left">
                                No
                            </th>

                            <th class="px-6 py-4 text-left">
                                Invoice
                            </th>

                            <th class="px-6 py-4 text-left">
                                Customer
                            </th>

                            <th class="px-6 py-4 text-left">
                                Kasir
                            </th>

                            <th class="px-6 py-4 text-left">
                                Total
                            </th>

                            <th class="px-6 py-4 text-left">
                                Pembayaran
                            </th>

                            <th class="px-6 py-4 text-left">
                                Kembalian
                            </th>

                            <th class="px-6 py-4 text-left">
                                Tanggal
                            </th>

                            <th class="px-6 py-4 text-center">
                                Aksi
                            </th>

                        </tr>
                    </thead>


                    <tbody class="divide-y divide-gray-100">

                        @forelse ($transaksis as $index => $transaksi)

                            <tr class="hover:bg-emerald-50/40 transition">

                                {{-- No --}}
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $transaksis->firstItem() + $index }}
                                </td>


                                {{-- Invoice --}}
                                <td class="px-6 py-4">

                                    <div class="font-bold text-emerald-700">
                                        {{ $transaksi->number_transaction }}
                                    </div>

                                </td>


                                {{-- Customer --}}
                                <td class="px-6 py-4">

                                    <div class="font-semibold text-gray-700">
                                        {{ $transaksi->name_cust }}
                                    </div>

                                </td>


                                {{-- Kasir --}}
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $transaksi->kasir->name ?? '-' }}
                                </td>


                                {{-- Total --}}
                                <td class="px-6 py-4">

                                    <span class="font-bold text-gray-800">
                                        Rp {{ number_format($transaksi->total_price, 0, ',', '.') }}
                                    </span>

                                </td>


                                {{-- Pembayaran --}}
                                <td class="px-6 py-4">

                                    <div class="font-semibold text-gray-700">
                                        Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}
                                    </div>

                                    @if ($transaksi->payment_method === 'Cash')

                                        <span class="inline-block mt-1 px-2 py-1 rounded-full
                                            text-xs font-semibold
                                            bg-green-100 text-green-700">
                                            💵 Cash
                                        </span>

                                    @elseif ($transaksi->payment_method === 'QRIS')

                                        <span class="inline-block mt-1 px-2 py-1 rounded-full
                                            text-xs font-semibold
                                            bg-blue-100 text-blue-700">
                                            📱 QRIS
                                        </span>

                                    @elseif ($transaksi->payment_method === 'Debit')

                                        <span class="inline-block mt-1 px-2 py-1 rounded-full
                                            text-xs font-semibold
                                            bg-purple-100 text-purple-700">
                                            💳 Debit
                                        </span>

                                    @else

                                        <span class="inline-block mt-1 px-2 py-1 rounded-full
                                            text-xs font-semibold
                                            bg-orange-100 text-orange-700">
                                            📲 E-Wallet
                                        </span>

                                    @endif

                                </td>


                                {{-- Kembalian --}}
                                <td class="px-6 py-4">

                                    <span class="font-semibold text-teal-700">
                                        Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}
                                    </span>

                                </td>


                                {{-- Tanggal --}}
                                <td class="px-6 py-4 text-sm text-gray-600">

                                    {{ $transaksi->transaction_date->format('d/m/Y') }}

                                    <div class="text-xs text-gray-400">
                                        {{ $transaksi->transaction_date->format('H:i') }}
                                    </div>

                                </td>


                                {{-- Aksi --}}
                                <td class="px-6 py-4 text-center">

                                    <a
                                        href="{{ route('transaksi.struk', $transaksi->id) }}"
                                        class="inline-flex items-center
                                        bg-teal-500
                                        hover:bg-teal-600
                                        text-white
                                        font-semibold
                                        px-4 py-2
                                        rounded-xl
                                        transition">

                                        👁 Detail

                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="9"
                                    class="px-6 py-12 text-center">

                                    <div class="text-5xl mb-3">
                                        📭
                                    </div>

                                    <p class="font-bold text-gray-600">
                                        Tidak ada transaksi
                                    </p>

                                    <p class="text-sm text-gray-400 mt-1">
                                        Belum ada transaksi yang sesuai dengan pencarian.
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- Pagination --}}
            @if ($transaksis->hasPages())

                <div class="px-6 py-5 border-t border-gray-100">

                    {{ $transaksis->links() }}

                </div>

            @endif

        </div>

    </div>
</div>
</x-app-layout>
