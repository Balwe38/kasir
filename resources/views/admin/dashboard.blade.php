<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800">
            Dashboard Admin
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Statistik --}}
            
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">

    {{-- Produk --}}
    <div class="bg-blue-500 rounded-xl shadow text-white p-6 
                transition hover:-translate-y-1 hover:shadow-lg">

        <div class="flex justify-between items-center">

            <div>
                <p class="text-sm opacity-80">
                    Total Produk
                </p>

                <h2 class="text-4xl font-bold mt-2">
                    {{ $produk }}
                </h2>
            </div>

            <div class="bg-white/20 p-3 rounded-full">
                📦
            </div>

        </div>

    </div>


    {{-- Kategori --}}
    <div class="bg-green-500 rounded-xl shadow text-white p-6
                transition hover:-translate-y-1 hover:shadow-lg">

        <div class="flex justify-between items-center">

            <div>
                <p class="text-sm opacity-80">
                    Total Kategori
                </p>

                <h2 class="text-4xl font-bold mt-2">
                    {{ $kategori }}
                </h2>
            </div>

            <div class="bg-white/20 p-3 rounded-full">
                🏷️
            </div>

        </div>

    </div>


    {{-- Transaksi --}}
    <div class="bg-indigo-500 rounded-xl shadow text-white p-6
                transition hover:-translate-y-1 hover:shadow-lg">

        <div class="flex justify-between items-center">

            <div>
                <p class="text-sm opacity-80">
                    Total Transaksi
                </p>

                <h2 class="text-4xl font-bold mt-2">
                    {{ $transaksi }}
                </h2>
            </div>

            <div class="bg-white/20 p-3 rounded-full">
                🧾
            </div>

        </div>

    </div>

    <div class="bg-emerald-600 rounded-xl shadow text-white p-6 
            transition hover:-translate-y-1 hover:shadow-lg">

    <div class="flex justify-between items-center">

        <div>
            <p class="text-sm opacity-80">
                Total Pendapatan
            </p>

            <h2 class="text-2xl font-bold mt-2">
                Rp {{ number_format($pendapatan,0,',','.') }}
            </h2>
        </div>

        <div class="bg-white/20 p-3 rounded-full">
            💰
        </div>

    </div>

</div>

</div>


            {{-- Content --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Transaksi --}}
                <div class="lg:col-span-2 bg-white rounded-xl shadow">

                    <div class="border-b px-6 py-4">
                        <h3 class="font-semibold text-lg">
                            Transaksi Terbaru
                        </h3>
                    </div>

                    <div class="overflow-x-auto">

                        <table class="min-w-full">

                            <thead class="bg-gray-100">

                                <tr>

                                    <th class="px-6 py-3 text-left">
                                        Invoice
                                    </th>

                                    <th class="px-6 py-3 text-left">
                                        Total
                                    </th>

                                    <th class="px-6 py-3 text-left">
                                        Tanggal
                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                @forelse($transaksiTerbaru as $item)

                                    <tr class="border-b">

                                        <td class="px-6 py-4">
                                            {{ $item->number_transaction }}
                                        </td>

                                        <td class="px-6 py-4">
                                            Rp {{ number_format($item->total_price,0,',','.') }}
                                        </td>

                                        <td class="px-6 py-4">
                                            {{ $item->created_at->format('d M Y') }}
                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td colspan="3" class="text-center py-6 text-gray-500">
                                            Belum ada transaksi.
                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

               
                {{-- Monitoring Stok --}}
<div class="bg-white rounded-xl shadow">

    <div class="border-b px-6 py-4 flex justify-between items-center">

        <h3 class="font-semibold text-lg">
            📦 Monitoring Stok
        </h3>

        <span class="text-sm text-red-500">
            {{ $stokMenipis->count() }} produk
        </span>

         <a href="{{ route('produk.index') }}"
       class="text-sm text-blue-600 hover:underline">
        Lihat Semua
    </a>

    </div>


    <div class="p-6">

        @forelse($stokMenipis as $produk)

            <div class="flex justify-between items-center py-3 border-b hover:bg-gray-50 transition">

                <div>
                    <p class="font-medium text-gray-800">
                        {{ $produk->nama_produk }}
                    </p>

                    <p class="text-sm text-gray-500">
                        Sisa stok
                    </p>
                </div>


               @if($produk->stok == 0)

    <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-sm font-semibold">
        Habis
    </span>


@elseif($produk->stok <= 2)

    <span class="bg-orange-100 text-orange-600 px-3 py-1 rounded-full text-sm font-semibold">
        {{ $produk->stok }} pcs
    </span>


@else

    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm font-semibold">
        {{ $produk->stok }} pcs
    </span>

@endif


            </div>

        @empty

            <div class="text-center py-5">

                <div class="text-3xl">
                    ✅
                </div>

                <p class="text-gray-500 mt-2">
                    Semua stok aman
                </p>

            </div>

        @endforelse

    </div>

</div>

</div>

{{-- Grafik Penjualan --}}

<div class="bg-white rounded-xl shadow p-6">

    <h3 class="font-semibold text-lg mb-4">
        📈 Penjualan 7 Hari Terakhir
    </h3>

    <canvas id="salesChart" height="100"></canvas>

</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const ctx = document.getElementById('salesChart');

new Chart(ctx, {

    type: 'line',

    data: {

        labels: @json(collect($penjualanHarian)->pluck('tanggal')),

        datasets: [{

            label: 'Pendapatan',

            data: @json(collect($penjualanHarian)->pluck('total')),

            borderColor: '#4f46e5',

            backgroundColor: 'rgba(79,70,229,0.2)',

            tension: 0.4,

            fill: true

        }]

    },


    options: {

        responsive: true,

        plugins: {

            legend: {

                display: false

            }

        }

    }

});

</script>

    
</x-app-layout>