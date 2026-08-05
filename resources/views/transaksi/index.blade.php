<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Transaksi Kasir</h2>
    </x-slot>

    @if(session('error'))
        <script>
            alert(@json(session('error')));
        </script>
    @endif

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-lg p-6">
                <p class="text-sm text-gray-600">Tanggal: {{ now()->translatedFormat('d F Y') }}</p>
                <p class="text-sm text-gray-600">Kasir: {{ auth()->user()->name }}</p>
            </div>

            <div class="bg-white shadow-sm rounded-lg p-6">
                <form method="GET" action="{{ route('transaksi.index') }}" class="mb-4">
                    <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari nama produk..."
                        class="w-full border-gray-300 rounded-md shadow-sm">
                </form>

                <h3 class="font-semibold mb-2">Daftar Produk</h3>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="text-left text-xs text-gray-500 uppercase">
                            <th class="py-2">Nama</th>
                            <th class="py-2">Harga</th>
                            <th class="py-2">Stok</th>
                            <th class="py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($produks as $produk)
                            <tr>
                                <td class="py-2">{{ $produk->nama_produk }}</td>
                                <td class="py-2">Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                                <td class="py-2">{{ $produk->stok }}</td>
                                <td class="py-2">
                                    <form action="{{ route('transaksi.tambah') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                                        <button type="submit" @disabled($produk->stok < 1)
                                            class="bg-blue-500 hover:bg-blue-600 disabled:bg-gray-300 disabled:cursor-not-allowed text-white px-3 py-1 rounded text-xs">
                                            +
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-4 text-center text-gray-500">Produk tidak ditemukan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="font-semibold mb-2">Keranjang</h3>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="text-left text-xs text-gray-500 uppercase">
                            <th class="py-2">Produk</th>
                            <th class="py-2">Qty</th>
                            <th class="py-2">Harga</th>
                            <th class="py-2">Diskon</th>
                            <th class="py-2">Subtotal</th>
                            <th class="py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($keranjang as $produk_id => $item)
                            <tr>
                                <td class="py-2">{{ $item['nama'] }}</td>
                                <td class="py-2">{{ $item['qty'] }}</td>
                                <td class="py-2">Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                                <td class="py-2">
                                    @if (($item['discount_price'] ?? 0) > 0)
                                        Rp {{ number_format($item['discount_price'], 0, ',', '.') }}
                                    @elseif (($item['discount_percent'] ?? 0) > 0)
                                        {{ $item['discount_percent'] }}%
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="py-2">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                                <td class="py-2">
                                    <form action="{{ route('transaksi.hapus', $produk_id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 text-xs">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-4 text-center text-gray-500">Keranjang kosong</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4 text-right font-semibold text-lg">
                    Total: Rp {{ number_format($total, 0, ',', '.') }}
                </div>
            </div>

            <div class="bg-white shadow-sm rounded-lg p-6">
                <form action="{{ route('transaksi.simpan') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Customer</label>
                        <input type="text" name="name_cust" required value="{{ old('name_cust') }}"
                            class="w-full border-gray-300 rounded-md shadow-sm">
                        @error('name_cust')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Bayar</label>
                        <input type="number" name="bayar" required min="0" value="{{ old('bayar') }}"
                            class="w-full border-gray-300 rounded-md shadow-sm">
                        @error('bayar')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" @disabled(empty($keranjang))
                        class="bg-green-600 hover:bg-green-700 disabled:bg-gray-400 disabled:text-gray-600 disabled:cursor-not-allowed text-white font-bold py-2 px-4 rounded">
                        Simpan Transaksi
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>