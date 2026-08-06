<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    //
     public function index(Request $request)
    {

        $mulai = $request->mulai ?? now()->startOfMonth()->format('Y-m-d');

        $selesai = $request->selesai ?? now()->format('Y-m-d');


        $transaksi = Transaction::with('kasir')
            ->whereDate('transaction_date', '>=', $mulai)
            ->whereDate('transaction_date', '<=', $selesai)
            ->latest()
            ->get();


        $totalTransaksi = $transaksi->count();


        $pendapatan = $transaksi->sum('total_price');


        $grafik = Transaction::selectRaw(
                'DATE(transaction_date) tanggal,
                SUM(total_price) total'
            )
            ->whereBetween(
                'transaction_date',
                [$mulai, $selesai]
            )
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();



       return view('admin.laporan.index', compact('transaksi', 'mulai', 'selesai', 'totalTransaksi', 'pendapatan'));

    }

}
