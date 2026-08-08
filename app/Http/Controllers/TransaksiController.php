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

    // Cek keranjang
    if (empty($keranjang)) {
        return back()->with('error', 'Keranjang masih kosong.');
    }

    // Hitung total
    $total = collect($keranjang)->sum('subtotal');

    // Cek uang bayar
    if ((float) $request->bayar < (float) $total) {
        return back()
            ->withInput()
            ->with(
                'error',
                'Uang bayar kurang. Total pembayaran Rp ' .
                number_format($total, 0, ',', '.')
            );
    }

    DB::transaction(function () use (
        $request,
        $keranjang,
        $total,
        &$transaction
    ) {

        // Buat transaksi
        $transaction = Transaction::create([
            'id_kasir' => auth()->id(),
            'number_transaction' =>
                'TRX-' .
                now()->format('Ymd') .
                '-' .
                strtoupper(Str::random(4)),

            'name_cust' => $request->name_cust,
            'transaction_date' => now(),
            'total_price' => $total,

            'payment_method' => $request->payment_method,
            'bayar' => $request->bayar,
            'kembalian' => $request->bayar - $total,
        ]);

        // Simpan detail transaksi
        foreach ($keranjang as $produk_id => $item) {

            // Lock produk
            $produk = Produk::where('id', $produk_id)
                ->lockForUpdate()
                ->first();

            if (!$produk) {
                throw new \Exception('Produk tidak ditemukan.');
            }

            // Cek stok
            if ($produk->stok < $item['qty']) {
                throw new \Exception(
                    "Stok {$produk->nama_produk} tidak mencukupi."
                );
            }

            // Simpan detail
            TransactionDetail::create([
                'id_transaction' => $transaction->id,
                'id_product' => $produk_id,
                'qty' => $item['qty'],
                'price' => $item['harga'],
                'discount_price' => $item['discount_price'] ?? 0,
                'discount_percent' => $item['discount_percent'] ?? 0,
            ]);

            // Kurangi stok
            $produk->decrement('stok', $item['qty']);
        }
    });

    // Kosongkan keranjang
    session()->forget('keranjang');

    // Pergi ke struk
    return redirect()
        ->route('transaksi.struk', $transaction->id)
        ->with('success', 'Transaksi berhasil disimpan.');
}

   public function struk(string $id)
{
    $transaksi = Transaction::with(['details.produk', 'kasir'])->findOrFail($id);

    $bayar = $transaksi->bayar;
    $kembalian = $transaksi->kembalian;

    return view('transaksi.struk', compact('transaksi', 'bayar', 'kembalian'));
}

    public function riwayat(Request $request)
{
    $keyword = $request->input('cari');
    $tanggal = $request->input('tanggal');

    $transaksis = Transaction::with([
        'kasir',
        'details.produk'
    ])
    ->when($keyword, function ($query) use ($keyword) {
        $query->where(function ($q) use ($keyword) {
            $q->where('name_cust', 'like', "%{$keyword}%")
              ->orWhere('number_transaction', 'like', "%{$keyword}%");
        });
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