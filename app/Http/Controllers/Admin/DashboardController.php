<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Transaction;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {


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


        return view('admin.dashboard', [

            'produk' => Produk::count(),

            'kategori' => Kategori::count(),

            'transaksi' => Transaction::count(),

            'pendapatan' => Transaction::sum('total_price'),

            'transaksiTerbaru' => Transaction::with('kasir')
                ->latest()
                ->take(5)
                ->get(),

            
                'totalStok' => Produk::sum('stok'),

                'stokMenipis' => Produk::where('stok', '<=', 5)
                ->orderBy('stok', 'asc')
                ->take(5)
                ->get(),

                'stokHabis' => Produk::where('stok', 0)
                ->count(),
            
                'penjualanHarian' => $penjualanHarian,

                

        ]);
    }
}