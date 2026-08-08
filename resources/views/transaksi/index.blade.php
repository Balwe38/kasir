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

   

    <div class="py-12">
@if (session('error'))
    <div class="max-w-5xl mx-auto mb-4 bg-red-100 border border-red-400 text-red-700 px-5 py-4 rounded-xl">
        ⚠️ {{ session('error') }}
    </div>
@endif
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
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

    <div class="flex items-center gap-3 mb-6">
        <div class="w-12 h-12 bg-emerald-100 rounded-2xl flex items-center justify-center text-2xl">
            💳
        </div>

        <div>
            <h3 class="text-2xl font-bold text-emerald-700">
                Pembayaran
            </h3>

            <p class="text-sm text-gray-500">
                Pilih metode pembayaran
            </p>
        </div>
    </div>


    <form action="{{ route('transaksi.simpan') }}" method="POST" id="formTransaksi" class="space-y-6">
        @csrf


        {{-- CUSTOMER --}}
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">
                👤 Nama Customer
            </label>

            <input
                type="text"
                name="name_cust"
                required
                value="{{ old('name_cust') }}"
                placeholder="Masukkan nama customer"
                class="w-full rounded-xl border-emerald-300 focus:border-emerald-500 focus:ring-emerald-500"
            >

            @error('name_cust')
                <p class="text-sm text-red-600 mt-1">
                    {{ $message }}
                </p>
            @enderror
        </div>


        {{-- TOTAL --}}
        <div class="bg-gradient-to-r from-emerald-50 to-teal-50 border-2 border-emerald-200 rounded-2xl p-5">

            <div class="flex justify-between items-center">

                <div>
                    <p class="text-sm text-gray-500">
                        Total Pembayaran
                    </p>

                    <p class="text-3xl font-bold text-emerald-700">
                        Rp {{ number_format($total, 0, ',', '.') }}
                    </p>
                </div>

                <div class="text-4xl">
                    🛒
                </div>

            </div>

        </div>


        {{-- METODE PEMBAYARAN --}}
        <div>

            <label class="block text-sm font-bold text-gray-700 mb-3">
                💳 Metode Pembayaran
            </label>

            <input
                type="hidden"
                name="payment_method"
                id="payment_method"
                value="{{ old('payment_method') }}"
            >


            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">

                {{-- CASH --}}
                <button
                    type="button"
                    data-payment="Cash"
                    class="payment-btn border-2 border-gray-200 rounded-2xl p-4 hover:border-emerald-500 hover:bg-emerald-50 transition"
                >
                    <div class="text-3xl mb-2">
                        💵
                    </div>

                    <div class="font-bold">
                        Cash
                    </div>

                    <div class="text-xs text-gray-500 mt-1">
                        Tunai
                    </div>
                </button>


                {{-- QRIS --}}
                <button
                    type="button"
                    data-payment="QRIS"
                    class="payment-btn border-2 border-gray-200 rounded-2xl p-4 hover:border-emerald-500 hover:bg-emerald-50 transition"
                >
                    <div class="text-3xl mb-2">
                        📱
                    </div>

                    <div class="font-bold">
                        QRIS
                    </div>

                    <div class="text-xs text-gray-500 mt-1">
                        Scan QR
                    </div>
                </button>


                {{-- DEBIT --}}
                <button
                    type="button"
                    data-payment="Debit"
                    class="payment-btn border-2 border-gray-200 rounded-2xl p-4 hover:border-emerald-500 hover:bg-emerald-50 transition"
                >
                    <div class="text-3xl mb-2">
                        💳
                    </div>

                    <div class="font-bold">
                        Debit
                    </div>

                    <div class="text-xs text-gray-500 mt-1">
                        Kartu Debit
                    </div>
                </button>


                {{-- E-WALLET --}}
                <button
                    type="button"
                    data-payment="E-Wallet"
                    class="payment-btn border-2 border-gray-200 rounded-2xl p-4 hover:border-emerald-500 hover:bg-emerald-50 transition"
                >
                    <div class="text-3xl mb-2">
                        📲
                    </div>

                    <div class="font-bold">
                        E-Wallet
                    </div>

                    <div class="text-xs text-gray-500 mt-1">
                        Dompet Digital
                    </div>
                </button>

            </div>

            @error('payment_method')
                <p class="text-sm text-red-600 mt-2">
                    {{ $message }}
                </p>
            @enderror

        </div>


        {{-- NOMINAL BAYAR --}}
        <div>

            <label class="block text-sm font-bold text-gray-700 mb-2">
                💰 Nominal Bayar
            </label>

            <div class="relative">

                <span class="absolute left-4 top-1/2 -translate-y-1/2 font-bold text-gray-500">
                    Rp
                </span>

                <input
                    type="number"
                    name="bayar"
                    id="bayar"
                    required
                    min="0"
                    value="{{ old('bayar') }}"
                    placeholder="0"
                    class="w-full pl-12 pr-4 py-4 text-xl font-bold rounded-xl border-emerald-300 focus:border-emerald-500 focus:ring-emerald-500"
                >

            </div>

            @error('bayar')
                <p class="text-sm text-red-600 mt-1">
                    {{ $message }}
                </p>
            @enderror

        </div>


        {{-- KEMBALIAN --}}
        <div
            id="boxKembalian"
            class="bg-gray-50 border-2 border-gray-200 rounded-2xl p-5"
        >

            <div class="flex justify-between items-center">

                <div>

                    <p class="text-sm text-gray-500">
                        Kembalian
                    </p>

                    <p
                        id="kembalian"
                        class="text-3xl font-bold text-gray-700"
                    >
                        Rp 0
                    </p>

                </div>

                <div
                    id="iconKembalian"
                    class="text-4xl"
                >
                    💰
                </div>

            </div>

        </div>


        {{-- STATUS --}}
        <div
            id="statusBayar"
            class="hidden rounded-xl p-4 text-sm font-semibold"
        >
        </div>


        {{-- BUTTON --}}
        <button
            type="submit"
            id="btnSimpan"
            disabled
            class="w-full bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-700 hover:to-teal-600 text-white font-bold py-4 rounded-2xl shadow-lg transition hover:scale-[1.02] disabled:bg-gray-300 disabled:from-gray-300 disabled:to-gray-400 disabled:cursor-not-allowed disabled:hover:scale-100"
        >
            💾 Simpan Transaksi
        </button>

    </form>
</div>
</x-app-layout>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const total = Number(@json($total));

    const bayarInput = document.getElementById('bayar');
    const paymentInput = document.getElementById('payment_method');

    const kembalianText = document.getElementById('kembalian');
    const boxKembalian = document.getElementById('boxKembalian');
    const iconKembalian = document.getElementById('iconKembalian');

    const statusBayar = document.getElementById('statusBayar');
    const btnSimpan = document.getElementById('btnSimpan');

    const paymentButtons = document.querySelectorAll('.payment-btn');


    function formatRupiah(number) {

        return new Intl.NumberFormat('id-ID').format(number);

    }


    function updatePembayaran() {

        const bayar = Number(bayarInput.value || 0);

        const metode = paymentInput.value;

        const kembalian = bayar - total;


        // Reset
        statusBayar.classList.add('hidden');

        btnSimpan.disabled = true;


        // Belum pilih pembayaran
        if (!metode) {

            kembalianText.innerText = 'Rp 0';

            return;

        }


        // Belum isi nominal
        if (!bayarInput.value) {

            kembalianText.innerText = 'Rp 0';

            return;

        }


        // UANG KURANG
        if (bayar < total) {

            const kurang = total - bayar;

            kembalianText.innerText =
                '- Rp ' + formatRupiah(kurang);

            kembalianText.classList.remove(
                'text-emerald-600',
                'text-gray-700'
            );

            kembalianText.classList.add(
                'text-red-600'
            );


            boxKembalian.classList.remove(
                'bg-gray-50',
                'border-gray-200'
            );

            boxKembalian.classList.add(
                'bg-red-50',
                'border-red-300'
            );


            iconKembalian.innerText = '⚠️';


            statusBayar.innerText =
                '⚠️ Uang pembayaran masih kurang Rp ' +
                formatRupiah(kurang);

            statusBayar.classList.remove('hidden');

            statusBayar.classList.add(
                'bg-red-100',
                'text-red-700'
            );


            return;
        }


        // UANG CUKUP / LEBIH
        kembalianText.innerText =
            'Rp ' + formatRupiah(kembalian);

        kembalianText.classList.remove(
            'text-red-600',
            'text-gray-700'
        );

        kembalianText.classList.add(
            'text-emerald-600'
        );


        boxKembalian.classList.remove(
            'bg-gray-50',
            'border-gray-200',
            'bg-red-50',
            'border-red-300'
        );

        boxKembalian.classList.add(
            'bg-emerald-50',
            'border-emerald-300'
        );


        iconKembalian.innerText = '💰';


        statusBayar.innerText =
            '✅ Pembayaran sudah mencukupi';

        statusBayar.classList.remove('hidden');

        statusBayar.classList.remove(
            'bg-red-100',
            'text-red-700'
        );

        statusBayar.classList.add(
            'bg-emerald-100',
            'text-emerald-700'
        );


        btnSimpan.disabled = false;

    }


    // PILIH METODE PEMBAYARAN
    paymentButtons.forEach(button => {

        button.addEventListener('click', function () {

            const metode = this.dataset.payment;

            paymentInput.value = metode;


            // Reset semua tombol
            paymentButtons.forEach(btn => {

                btn.classList.remove(
                    'border-emerald-500',
                    'bg-emerald-50',
                    'ring-2',
                    'ring-emerald-300'
                );

                btn.classList.add(
                    'border-gray-200'
                );

            });


            // Aktifkan tombol yang dipilih
            this.classList.remove(
                'border-gray-200'
            );

            this.classList.add(
                'border-emerald-500',
                'bg-emerald-50',
                'ring-2',
                'ring-emerald-300'
            );


            // Kalau bukan cash,
            // otomatis isi pembayaran sesuai total
            if (metode !== 'Cash') {

                bayarInput.value = total;

                bayarInput.readOnly = true;

            } else {

                bayarInput.readOnly = false;

                bayarInput.value = '';

                bayarInput.focus();

            }


            updatePembayaran();

        });

    });


    // BAYAR DIKETIK
    bayarInput.addEventListener('input', function () {

        updatePembayaran();

    });


    // Jalankan saat halaman dibuka
    updatePembayaran();

});
</script>
