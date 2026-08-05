<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Riwayat Transaksi</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white shadow-sm rounded-lg p-6">
                <form method="GET" action="{{ route('transaksi.riwayat') }}" class="flex flex-wrap gap-2 items-end">
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-xs text-gray-500 mb-1">Cari (nama customer / no. transaksi)</label>
                        <input type="text" name="cari" value="{{ request('cari') }}"
                               placeholder="Cari..."
                               class="w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Tanggal</label>
                        <input type="date" name="tanggal" value="{{ request('tanggal') }}"
                               class="border-gray-300 rounded-md shadow-sm">
                    </div>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                        Cari
                    </button>
                    @if (request('cari') || request('tanggal'))
                        <a href="{{ route('transaksi.riwayat') }}" class="text-sm text-gray-600 underline px-2 py-2">Reset</a>
                    @endif
                </form>
            </div>

            <div class="bg-white shadow-sm rounded-lg p-6">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="text-left text-xs text-gray-500 uppercase">
                            <th class="py-2">No. Transaksi</th>
                            <th class="py-2">Tanggal</th>
                            <th class="py-2">Customer</th>
                            <th class="py-2">Kasir</th>
                            <th class="py-2">Total</th>
                            <th class="py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($transaksis as $trx)
                            <tr>
                                <td class="py-2">{{ $trx->number_transaction }}</td>
                                <td class="py-2">{{ \Carbon\Carbon::parse($trx->transaction_date)->translatedFormat('d M Y H:i') }}</td>
                                <td class="py-2">{{ $trx->name_cust }}</td>
                                <td class="py-2">{{ $trx->kasir->name ?? '-' }}</td>
                                <td class="py-2">Rp {{ number_format($trx->total_price, 0, ',', '.') }}</td>
                                <td class="py-2">
                                    <a href="{{ route('transaksi.struk', $trx->id) }}" class="text-blue-600 hover:underline text-xs">
                                        Lihat Struk
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="py-4 text-center text-gray-500">Belum ada transaksi</td></tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $transaksis->links() }}
                </div>
            </div>

            <div>
                <a href="{{ route('transaksi.index') }}" class="text-sm text-gray-600 underline">← Kembali ke Transaksi</a>
            </div>

        </div>
    </div>
</x-app-layout>