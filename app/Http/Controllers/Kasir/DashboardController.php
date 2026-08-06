<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $hariIni = Carbon::today();

        // Statistik
        $totalTransaksi = Transaction::whereDate(
            'transaction_date',
            $hariIni
        )->count();

        $pendapatanHariIni = Transaction::whereDate(
            'transaction_date',
            $hariIni
        )->sum('total_price');

        $produkTerjual = TransactionDetail::sum('qty');

        $stokHabis = Produk::where('stok', '<=', 5)->count();

        // Monitoring stok
        $stokMenipis = Produk::where('stok', '<=', 5)
            ->orderBy('stok', 'asc')
            ->take(5)
            ->get();

        // Transaksi terbaru
        $transaksiTerbaru = Transaction::latest()
            ->take(5)
            ->get();

        // Grafik 7 hari terakhir
        $penjualanHarian = [];

        for ($i = 6; $i >= 0; $i--) {

            $tanggal = Carbon::now()->subDays($i);

            $penjualanHarian[] = [
                'tanggal' => $tanggal->format('d M'),
                'total' => Transaction::whereDate(
                    'transaction_date',
                    $tanggal->format('Y-m-d')
                )->sum('total_price')
            ];
        }

        return view('kasir.dashboard', [
            'totalTransaksi' => $totalTransaksi,
            'pendapatanHariIni' => $pendapatanHariIni,
            'produkTerjual' => $produkTerjual,
            'stokHabis' => $stokHabis,
            'stokMenipis' => $stokMenipis,
            'transaksiTerbaru' => $transaksiTerbaru,
            'penjualanHarian' => $penjualanHarian,
        ]);
    }
}