<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Kasir\DashboardController as KasirDashboardController;

use App\Http\Controllers\Admin\LaporanController;

use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransaksiController;


Route::get('/', function () {
    return view('welcome');
});


// ADMIN

Route::middleware(['auth', 'role:admin'])->group(function () {


    Route::get('/admin', [AdminDashboardController::class, 'index'])
        ->name('admin.dashboard');

    Route::resource('products', ProdukController::class)
        ->names('produk')
        ->parameters(['products' => 'produk']);

    Route::get('/products/{produk}/detail', [ProdukController::class, 'detail'])
        ->name('produk.detail');

    Route::resource('kategori', KategoriController::class);


    // LAPORAN
    Route::get('/laporan', [LaporanController::class, 'index'])
        ->name('laporan.index');

});


// ====================


// KASIR
// ====================
Route::middleware(['auth', 'role:admin,kasir'])->group(function () {

    Route::get('/kasir', [KasirDashboardController::class, 'index'])
        ->name('kasir.dashboard');
});

// ====================
// TRANSAKSI
// ====================
Route::middleware('auth')->group(function () {

    Route::get('/transaksi', [TransaksiController::class, 'index'])
        ->name('transaksi.index');

    Route::post('/transaksi/tambah', [TransaksiController::class, 'tambahKeranjang'])
        ->name('transaksi.tambah');

    Route::delete('/transaksi/hapus/{produk_id}', [TransaksiController::class, 'hapusKeranjang'])
        ->name('transaksi.hapus');

    Route::post('/transaksi/simpan', [TransaksiController::class, 'simpan'])
        ->name('transaksi.simpan');

    Route::get('/transaksi/struk/{id}', [TransaksiController::class, 'struk'])
        ->name('transaksi.struk');

    Route::get('/transaksi/riwayat', [TransaksiController::class, 'riwayat'])
        ->name('transaksi.riwayat');
});

// ====================
// PROFILE
// ====================
Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__ . '/auth.php';