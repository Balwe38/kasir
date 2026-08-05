<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// ZONA ADMIN — Hanya role 'admin' yang boleh masuk
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', fn() => view('admin.dashboard'))
        ->name('admin.dashboard');
    Route::resource('/admin/produk', ProdukController::class);
});

// ZONA KASIR — Hanya role 'kasir' yang boleh masuk
Route::middleware(['auth', 'role:admin,kasir'])->group(function () {
    // Route::get('/kasir', fn() => view('kasir.dashboard'))
    //     ->name('kasir.dashboard');
    Route::get('/kasir', function () {
        return view('kasir.dashboard');
    })->name('kasir.dashboard');
});

// ZONA PROFIL — Semua yang sudah login
Route::middleware('auth')->group(function () {
    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/products', [ProdukController::class, 'index'])
            ->name('produk.index');

        Route::get('/transaction', [TransactionController::class, 'index'])
            ->name('transaction.index');
    });
    Route::get('products/create', [ProdukController::class, 'create'])
        ->name('produk.create');
    Route::post('products', [ProdukController::class, 'store'])
        ->name('produk.store');
    Route::patch('/products/{id}', [ProdukController::class, 'edit'])
        ->name('produk.edit');
    Route::get('/products/{id}', [ProdukController::class, 'update'])
        ->name('produk.update');
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});


require __DIR__ . '/auth.php';
