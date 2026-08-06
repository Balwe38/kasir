<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Kasir Dashboard
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Card Statistik --}}
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-6">

                <div class="bg-blue-500 rounded-xl shadow text-white p-6">
                    <p class="text-sm opacity-80">Transaksi Hari Ini</p>
                    <h2 class="text-4xl font-bold mt-2">
                        {{ $totalTransaksi }}
                    </h2>
                </div>

                <div class="bg-green-500 rounded-xl shadow text-white p-6">
                    <p class="text-sm opacity-80">Pendapatan Hari Ini</p>
                    <h2 class="text-3xl font-bold mt-2">
                        Rp {{ number_format($pendapatanHariIni,0,',','.') }}
                    </h2>
                </div>

                <div class="bg-purple-500 rounded-xl shadow text-white p-6">
                    <p class="text-sm opacity-80">Produk Terjual</p>
                    <h2 class="text-4xl font-bold mt-2">
                        {{ $produkTerjual }}
                    </h2>
                </div>

                <div class="bg-red-500 rounded-xl shadow text-white p-6">
                    <p class="text-sm opacity-80">Stok Menipis</p>
                    <h2 class="text-4xl font-bold mt-2">
                        {{ $stokHabis }}
                    </h2>
                </div>

            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Transaksi Terbaru --}}
                <div class="lg:col-span-2 bg-white rounded-xl shadow overflow-hidden">

                    <div class="border-b p-5 font-semibold">
                        Transaksi Terbaru
                    </div>

                    <table class="w-full">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="text-left p-3">Invoice</th>
                                <th class="text-left p-3">Customer</th>
                                <th class="text-left p-3">Total</th>
                                <th class="text-left p-3">Tanggal</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($transaksiTerbaru as $trx)
                                <tr class="border-t hover:bg-gray-50">
                                    <td class="p-3">{{ $trx->number_transaction }}</td>
                                    <td class="p-3">{{ $trx->name_cust }}</td>
                                    <td class="p-3">
                                        Rp {{ number_format($trx->total_price,0,',','.') }}
                                    </td>
                                    <td class="p-3">
                                        {{ $trx->transaction_date->format('d M Y') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center p-6 text-gray-500">
                                        Belum ada transaksi.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>

                </div>

                {{-- Monitoring Stok --}}
                <div class="bg-white rounded-xl shadow overflow-hidden">

                    <div class="border-b p-5 font-semibold">
                        Produk Hampir Habis
                    </div>

                    @forelse($stokMenipis as $produk)

                        <div class="flex justify-between items-center p-4 border-b">

                            <div>
                                <p class="font-medium">
                                    {{ $produk->nama_produk }}
                                </p>

                                <small class="text-gray-500">
                                    Stok : {{ $produk->stok }}
                                </small>
                            </div>

                            <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs">
                                Habis
                            </span>

                        </div>

                    @empty

                        <div class="p-6 text-center text-gray-500">
                            Semua stok aman
                        </div>

                    @endforelse

                </div>

            </div>

            {{-- Grafik Penjualan --}}
            <div class="mt-6 bg-white rounded-xl shadow p-6">

                <h3 class="font-semibold text-lg mb-5">
                    📈 Penjualan 7 Hari Terakhir
                </h3>

                <canvas id="salesChart" height="90"></canvas>

            </div>

        </div>
    </div>

    {{-- Chart JS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const labels = @json(collect($penjualanHarian)->pluck('tanggal'));
        const data = @json(collect($penjualanHarian)->pluck('total'));

        new Chart(document.getElementById('salesChart'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Pendapatan',
                    data: data,
                    borderColor: '#4F46E5',
                    backgroundColor: 'rgba(79,70,229,.15)',
                    borderWidth: 3,
                    fill: true,
                    tension: .4,
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

</x-app-layout>