<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\StockTransactionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfileController;

Route::middleware('auth')->group(function () {

    // Dashboard - Admin & Staff
    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/dashboard', function () {
        return redirect()->route('dashboard');
    });

    // Products - Admin & Staff can view
    Route::get('/products', [ProductController::class, 'index'])
        ->name('products.index');

    // Stock Transactions - Admin & Staff
    Route::get('/stock-transactions', [StockTransactionController::class, 'index'])
        ->name('stock-transactions.index');

    Route::get('/stock-transactions/create', [StockTransactionController::class, 'create'])
        ->name('stock-transactions.create');

    Route::post('/stock-transactions', [StockTransactionController::class, 'store'])
        ->name('stock-transactions.store');

    // Admin Only
    Route::middleware('admin')->group(function () {

        // Categories
        Route::resource('categories', CategoryController::class);

        // Products Management
        Route::resource('products', ProductController::class)
            ->except(['index', 'show']);

        // Suppliers
        Route::resource('suppliers', SupplierController::class);

        // Reports
        Route::get('/reports', [ReportController::class, 'index'])
            ->name('reports.index');

        Route::get('/reports/export', [ReportController::class, 'export'])
            ->name('reports.export');
    });

    // Profile - Admin & Staff
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__.'/auth.php';
