<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\StockTransaction;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();

        $totalCategories = Category::count();

        $totalSuppliers = Supplier::count();

        $totalStockValue = Product::sum(
            \DB::raw('quantity * purchase_price')
        );

        $lowStockProducts = Product::with('category')
            ->whereColumn('quantity', '<=', 'min_stock_level')
            ->latest()
            ->take(5)
            ->get();

        $recentTransactions = StockTransaction::with([
            'product',
            'user'
        ])
            ->latest('transaction_date')
            ->take(5)
            ->get();

        $totalStockIn = StockTransaction::where('type', 'in')
            ->sum('quantity');

        $totalStockOut = StockTransaction::where('type', 'out')
            ->sum('quantity');

        return view('dashboard', compact(
            'totalProducts',
            'totalCategories',
            'totalSuppliers',
            'totalStockValue',
            'lowStockProducts',
            'recentTransactions',
            'totalStockIn',
            'totalStockOut'
        ));
    }
}