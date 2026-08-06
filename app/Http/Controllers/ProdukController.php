<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProdukRequest;
use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\View\View;
use Illuminate\Support\Str;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $produks = Produk::with('kategori')->latest()->get();
        return view("products.index", compact('produks'));
    }

    public function create()
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();

        return view('products.create', compact('kategoris'));
    }

    public function store(ProdukRequest $request)
    {
        $data = $request->validated();

        $data['code'] = 'PRD-' . strtoupper(Str::random(8));
        $data['status'] = true;
        $data['created_by'] = auth()->id();

        Produk::create($data);

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
        $kategoris = Kategori::all();

        return view('products.edit', compact('product', 'kategoris'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProdukRequest $request, $id)
    {
        $product = Produk::findOrFail($id);
        $product->update($request->validated());
        return redirect()->route('produk.index')
            ->with('success', 'Produk berhasil Di Edit.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produk $produk)
    {
        $produk->delete();

        return redirect()->route('produk.index')
            ->with('success', 'Produk berhasil dihapus');
    }
}