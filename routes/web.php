<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ReportController;

// ROUTE GUEST (Hanya bisa diakses jika belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

// ROUTE AUTH (Harus login terlebih dahulu)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // AKSES BERSAMA (Admin, Cashier, & Kasir) - Bisa akses Katalog Produk & Kasir Penjualan
    Route::middleware(\App\Http\Middleware\RoleMiddleware::class . ':admin,cashier,kasir')->group(function () {
        Route::get('/sales', [SaleController::class, 'index'])->name('sales.index');
        Route::get('/sales/create', [SaleController::class, 'create'])->name('sales.create');
        Route::post('/sales', [SaleController::class, 'store'])->name('sales.store');
        Route::get('/sales/{id}', [SaleController::class, 'show'])->name('sales.show');
        Route::get('/sales/{id}/receipt', [SaleController::class, 'receipt'])->name('sales.receipt');
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    });

    // KHUSUS ADMIN / OWNER - Akses penuh ke Dashboard, Kategori, Pemasok, Restok, Laporan, & Kelola Data
    Route::middleware(\App\Http\Middleware\RoleMiddleware::class . ':admin')->group(function () {
        Route::get('/', function() { return redirect()->route('dashboard'); });
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('categories', CategoryController::class);
        Route::resource('suppliers', SupplierController::class);
        Route::resource('purchases', PurchaseController::class);
        Route::resource('reports', ReportController::class);

        // Manajemen Produk & Hapus Transaksi
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
        Route::delete('/sales/{id}', [SaleController::class, 'destroy'])->name('sales.destroy');
    });
});