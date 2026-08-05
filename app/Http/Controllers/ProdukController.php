<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Str;

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

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        Produk::create([
            'code' => 'PRD-' . strtoupper(Str::random(8)), // contoh kode
            'nama_produk' => $request->nama_produk,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'description' => $request->deskripsi,
            'status' => true,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('produk.index')
            ->with('success', 'Produk berhasil ditambahkan.');
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
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);
        $product = Produk::findOrFail($id);
        $product->update($validated);
        return redirect()->route('produk.index')
            ->with('success', 'Produk berhasil Di Edit.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produk $produk)
    {
        // 

        $produk->delete();

    return redirect()->route('produk.index')
        ->with('success', 'Produk berhasil dihapus');
    }
}