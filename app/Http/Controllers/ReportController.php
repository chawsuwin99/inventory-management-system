<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockTransaction;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
        ]);

        $dateFrom = $validated['date_from'] ?? null;
        $dateTo = $validated['date_to'] ?? null;

        $transactionQuery = StockTransaction::with([
            'product',
            'user'
        ]);

        if ($dateFrom) {
            $transactionQuery->whereDate(
                'transaction_date',
                '>=',
                $dateFrom
            );
        }

        if ($dateTo) {
            $transactionQuery->whereDate(
                'transaction_date',
                '<=',
                $dateTo
            );
        }

        $totalStockIn = (clone $transactionQuery)
            ->where('type', 'in')
            ->sum('quantity');

        $totalStockOut = (clone $transactionQuery)
            ->where('type', 'out')
            ->sum('quantity');

        $totalTransactions = (clone $transactionQuery)->count();

        $transactions = $transactionQuery
            ->latest('transaction_date')
            ->paginate(10)
            ->withQueryString();

        $totalProducts = Product::count();

        $totalStockValue = Product::sum(
            \DB::raw('quantity * purchase_price')
        );

        $lowStockProducts = Product::whereColumn(
            'quantity',
            '<=',
            'min_stock_level'
        )->count();

        return view('reports.index', compact(
            'dateFrom',
            'dateTo',
            'totalStockIn',
            'totalStockOut',
            'totalTransactions',
            'transactions',
            'totalProducts',
            'totalStockValue',
            'lowStockProducts'
        ));
    }

    public function export(Request $request)
{
    $validated = $request->validate([
        'date_from' => 'nullable|date',
        'date_to' => 'nullable|date|after_or_equal:date_from',
    ]);

    $query = StockTransaction::with(['product', 'user']);

    if (!empty($validated['date_from'])) {
        $query->whereDate(
            'transaction_date',
            '>=',
            $validated['date_from']
        );
    }

    if (!empty($validated['date_to'])) {
        $query->whereDate(
            'transaction_date',
            '<=',
            $validated['date_to']
        );
    }

    $transactions = $query
        ->latest('transaction_date')
        ->get();

    return response()->streamDownload(function () use ($transactions) {
        $file = fopen('php://output', 'w');

        // Excel အတွက် UTF-8 BOM
        fwrite($file, "\xEF\xBB\xBF");

        fputcsv($file, [
            'Date',
            'Product',
            'SKU',
            'Type',
            'Quantity',
            'Unit Price',
            'Recorded By',
            'Note',
        ]);

        foreach ($transactions as $transaction) {
            fputcsv($file, [
                $transaction->transaction_date->format('Y-m-d'),
                $transaction->product->name ?? 'N/A',
                $transaction->product->sku ?? 'N/A',
                strtoupper($transaction->type),
                $transaction->quantity,
                $transaction->unit_price,
                $transaction->user->name ?? 'N/A',
                $transaction->note ?? '',
            ]);
        }

        fclose($file);
    }, 'inventory-report.csv', [
        'Content-Type' => 'text/csv; charset=UTF-8',
    ]);
}
}