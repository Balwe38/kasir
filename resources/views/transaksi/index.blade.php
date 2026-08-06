<x-app-layout>
    <x-slot name="header">
    <div class="bg-gradient-to-r from-emerald-600 via-teal-500 to-cyan-500 rounded-2xl shadow-lg p-5 text-white">
        <h2 class="text-3xl font-bold">
            💊 Kasir - Apotek Sehat
        </h2>
        <p class="text-emerald-100">
            Sistem Penjualan Obat
        </p>
    </div>
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

            <div class="bg-gradient-to-r from-emerald-600 via-teal-500 to-cyan-500 rounded-2xl shadow-xl p-6 flex justify-between items-center text-white">

    <div>
        <h3 class="text-2xl font-bold">
            💊 Apotek Sehat
        </h3>

        <p class="text-sm opacity-90 mt-2">
            📅 {{ now()->translatedFormat('d F Y') }}
        </p>

        <p class="text-sm opacity-90">
            👨‍⚕️ Kasir : {{ auth()->user()->name }}
        </p>
    </div>

    <a href="{{ route('transaksi.riwayat') }}"
        class="bg-white text-emerald-700 font-semibold px-5 py-3 rounded-xl hover:scale-105 transition">
        📋 Riwayat
    </a>

</div>

            <div class="bg-white rounded-3xl shadow-xl border border-emerald-100 p-6">
                <form method="GET" action="{{ route('transaksi.index') }}" class="mb-4">
                    <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari nama obat..."
                        class="w-full rounded-xl border-emerald-300 focus:border-emerald-500 focus:ring-emerald-500">
                </form>

                <h3 class="text-2xl font-bold text-emerald-700 mb-5">Daftar Obat</h3>
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
                                            class="bg-emerald-600 hover:bg-emerald-700
text-white
rounded-full
w-10
h-10
font-bold
transition
hover:scale-110
disabled:bg-gray-300">
                                            +
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-4 text-center text-gray-500">Obat tidak ditemukan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="bg-white rounded-3xl shadow-xl p-6 border border-emerald-100">
                <h3 class="text-2xl font-bold text-emerald-700 mb-5">🛒 Keranjang Belanja</h3>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="text-left text-xs text-gray-500 uppercase">
                            <th class="py-2">Obat</th>
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

                <div class="mt-6 bg-emerald-50 rounded-2xl border-2 border-emerald-400 p-5 text-right">
                    <p class="text-gray-500">
Total Pembayaran
</p>

<h2 class="text-2xl font-bold text-emerald-700">
Rp {{ number_format($total,0,',','.') }}
</h2>
                    
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-xl p-8 border border-emerald-100">
                <form action="{{ route('transaksi.simpan') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Customer</label>
                        <input type="text" name="name_cust" required value="{{ old('name_cust') }}"
                            class="w-full rounded-xl border-emerald-300 focus:border-emerald-500 focus:ring-emerald-500">
                        @error('name_cust')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="text-1xl font-bold text-emerald-700 mb-6">💳 Pembayaran</label>
                        <input type="number" name="bayar" required min="0" value="{{ old('bayar') }}"
                            class="w-full rounded-xl border-emerald-300 focus:border-emerald-500 focus:ring-emerald-500">
                        @error('bayar')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" @disabled(empty($keranjang))
                        class=" w-full
bg-gradient-to-r
from-emerald-600
to-teal-500
hover:from-emerald-700
hover:to-teal-600
text-white
font-bold
py-4
rounded-2xl
shadow-lg
transition
hover:scale-[1.02]
disabled:bg-gray-400">
                        Simpan Transaksi
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
