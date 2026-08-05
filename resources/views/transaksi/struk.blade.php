<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Struk Transaksi</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded print:hidden">
                    {{ session('success') }}
                </div>
            @endif

            <div id="struk" class="bg-white shadow-sm rounded-lg p-6 font-mono text-sm">
                <div class="text-center mb-4">
                    <p class="font-bold text-base">TOKO ANDA</p>
                    <p class="text-xs text-gray-500">Jl. Contoh Alamat No. 123</p>
                </div>

                <div class="border-t border-dashed border-gray-400 my-2"></div>

                <div class="space-y-1">
                    <div class="flex justify-between">
                        <span>No. Transaksi</span>
                        <span>{{ $transaksi->number_transaction }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Tanggal</span>
                        <span>{{ \Carbon\Carbon::parse($transaksi->transaction_date)->translatedFormat('d M Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Kasir</span>
                        <span>{{ $transaksi->kasir->name ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Customer</span>
                        <span>{{ $transaksi->name_cust }}</span>
                    </div>
                </div>

                <div class="border-t border-dashed border-gray-400 my-2"></div>

                <div class="space-y-2">
                    @foreach ($transaksi->details as $detail)
                        <div>
                            <div class="flex justify-between">
                                <span>{{ $detail->produk->nama_produk ?? 'Produk dihapus' }}</span>
                            </div>
                            <div class="flex justify-between text-xs text-gray-600">
                                <span>{{ $detail->qty }} x Rp {{ number_format($detail->price, 0, ',', '.') }}</span>
                                <span>
                                    Rp {{ number_format(
                                        ($detail->qty * $detail->price)
                                        - $detail->discount_price
                                        - ((($detail->qty * $detail->price) - $detail->discount_price) * $detail->discount_percent / 100),
                                        0, ',', '.'
                                    ) }}
                                </span>
                            </div>
                            @if ($detail->discount_price > 0 || $detail->discount_percent > 0)
                                <div class="text-xs text-gray-400">
                                    Diskon:
                                    @if ($detail->discount_price > 0) Rp {{ number_format($detail->discount_price, 0, ',', '.') }} @endif
                                    @if ($detail->discount_percent > 0) {{ $detail->discount_percent }}% @endif
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="border-t border-dashed border-gray-400 my-2"></div>

                <div class="space-y-1">
                    <div class="flex justify-between font-bold">
                        <span>Total</span>
                        <span>Rp {{ number_format($transaksi->total_price, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Bayar</span>
                        <span>Rp {{ number_format($bayar, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Kembalian</span>
                        <span>Rp {{ number_format($kembalian, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="border-t border-dashed border-gray-400 my-2"></div>

                <p class="text-center text-xs mt-4">Terima kasih atas kunjungan Anda</p>
            </div>

            <div class="flex gap-2 print:hidden">
                <button onclick="window.print()" class="flex-1 bg-gray-700 hover:bg-gray-800 text-white font-bold py-2 px-4 rounded">
                    Cetak Struk
                </button>
                <a href="{{ route('transaksi.index') }}" class="flex-1 text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Transaksi Baru
                </a>
            </div>

            <div class="text-center print:hidden">
                <a href="{{ route('transaksi.riwayat') }}" class="text-sm text-gray-600 underline">Lihat Riwayat Transaksi</a>
            </div>
            
            </div>

        </div>
    </div>

    <style>
        @media print {
            body * { visibility: hidden; }
            #struk, #struk * { visibility: visible; }
            #struk { position: absolute; top: 0; left: 0; width: 100%; }
        }
    </style>
</x-app-layout>