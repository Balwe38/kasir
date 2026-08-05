<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $produks = Produk::latest()->get();
        return view("products.index", compact('produks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("products.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi ekstra ketat!
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga'       => 'required|numeric|min:0',
            'stok'        => 'required|numeric|min:0',
            'gambar'      => 'required|file|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $image = $request->file('gambar');
        $nama_gambar = $image->hashName(); // Acak nama file!
        $image->storeAs('produks', $nama_gambar, 'public');

        Produk::create([
            'nama_produk' => $request->nama_produk,
            'harga'       => $request->harga,
            'stok'        => $request->stok,
            'gambar'      => $nama_gambar,
        ]);

        return redirect()->route('produk.index')
            ->with('success', 'Aman cuy, produk masuk!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Produk $produk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = Produk::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produk $produk)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produk $produk)
    {
        //
    }
}