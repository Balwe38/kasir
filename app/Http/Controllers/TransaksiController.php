<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransaksiRequest;
use App\Models\Produk;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('cari');

        $produks = Produk::when($keyword, function ($query) use ($keyword) {
                $query->where('nama_produk', 'like', "%{$keyword}%");
            })
            ->get();

        $keranjang = session('keranjang', []);

        $total = collect($keranjang)->sum('subtotal');

        return view('transaksi.index', compact('produks', 'keranjang', 'total'));
    }

    public function tambahKeranjang(Request $request)
    {
        $produk = Produk::findOrFail($request->produk_id);

        $keranjang = session('keranjang', []);
        $currentQty = $keranjang[$produk->id]['qty'] ?? 0;

        if ($currentQty >= $produk->stok) {
            return redirect()->route('transaksi.index')
                ->with('error', 'Stok produk "' . $produk->nama_produk . '" hanya tersedia ' . $produk->stok . '.');
        }

        if (isset($keranjang[$produk->id])) {
            $keranjang[$produk->id]['qty']++;
        } else {
            $keranjang[$produk->id] = [
                'nama'             => $produk->nama_produk,
                'harga'            => $produk->harga,
                'qty'              => 1,
                'discount_price'   => 0,
                'discount_percent' => 0,
            ];
        }

        $item = $keranjang[$produk->id];

        // subtotal = (harga * qty) - discount_price, lalu dipotong discount_percent
        $subtotal = ($item['harga'] * $item['qty']) - $item['discount_price'];
        $subtotal -= $subtotal * ($item['discount_percent'] / 100);

        $keranjang[$produk->id]['subtotal'] = $subtotal;

        session(['keranjang' => $keranjang]);

        return redirect()->route('transaksi.index');
    }

    public function hapusKeranjang($produk_id)
    {
        $keranjang = session('keranjang', []);
        unset($keranjang[$produk_id]);
        session(['keranjang' => $keranjang]);

        return redirect()->route('transaksi.index');
    }

    public function simpan(TransaksiRequest $request)
    {
        $keranjang = session('keranjang', []);

        if (empty($keranjang)) {
            return back()->with('error', 'Keranjang masih kosong');
        }

        $total = collect($keranjang)->sum('subtotal');

        if ($request->bayar < $total) {
            return back()->with('error', 'Uang bayar kurang dari total');
        }

        DB::transaction(function () use ($request, $keranjang, $total, &$transaction) {

            sleep(10);

            $transaction = Transaction::create([
                'id_kasir' => auth()->id(),
                'number_transaction' => 'TRX-' . now()->format('Ymd') . '-' . strtoupper(Str::random(4)),
                'name_cust' => $request->name_cust,
                'transaction_date' => now(),
                'total_price' => $total,
            ]);

            foreach ($keranjang as $produk_id => $item) {
                
                sleep(5);

                TransactionDetail::create([
                    'id_transaction' => $transaction->id,
                    'id_product' => $produk_id,
                    'qty' => $item['qty'],
                    'price' => $item['harga'],
                    'discount_price' => $item['discount_price'] ?? 0,
                    'discount_percent' => $item['discount_percent'] ?? 0,
                ]);

                // Lock data produk agar transaksi lain menunggu
                $produk = Produk::where('id', $produk_id)
                    ->lockForUpdate()
                    ->first();

                // Cek stok
                if ($produk->stok < $item['qty']) {
                    throw new \Exception("Stok {$produk->nama_produk} tidak mencukupi.");
                }

                // Kurangi stok
                $produk->decrement('stok', $item['qty']);
            }
        });

        session([
            'bayar_' . $transaction->id => $request->bayar,
            'kembalian_' . $transaction->id => $request->bayar - $total,
        ]);

        session()->forget('keranjang');

        return redirect()->route('transaksi.struk', $transaction->id)
            ->with('success', 'Transaksi berhasil disimpan.');
    }

    public function struk(string $id)
    {
        $transaksi = Transaction::with(['details.produk', 'kasir'])->findOrFail($id);

        $bayar     = session('bayar_' . $id, $transaksi->total_price);
        $kembalian = session('kembalian_' . $id, 0);

        return view('transaksi.struk', compact('transaksi', 'bayar', 'kembalian'));
    }

    public function riwayat(Request $request)
    {
        $keyword = $request->input('cari');
        $tanggal = $request->input('tanggal');



        $transaksis = Transaction::with([
        'kasir',
        'details.produk'])
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('name_cust', 'like', "%{$keyword}%")
                      ->orWhere('number_transaction', 'like', "%{$keyword}%");
            })
            ->when($tanggal, function ($query) use ($tanggal) {
                $query->whereDate('transaction_date', $tanggal);
            })
            ->latest('transaction_date')
            ->paginate(15)
            ->withQueryString();

        return view('transaksi.riwayat', compact('transaksis'));
    }
}