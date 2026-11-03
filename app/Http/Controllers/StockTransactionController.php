<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockTransaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StockTransactionController extends Controller
{
    public function index()
    {
        $transactions = StockTransaction::with(['product', 'user'])
            ->latest('transaction_date')
            ->paginate(10);

        return view('stock-transactions.index', compact('transactions'));
    }

    public function create()
    {
        $products = Product::where('status', true)
            ->orderBy('name')
            ->get();

        return view('stock-transactions.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'note' => 'nullable|string',
            'transaction_date' => 'required|date',
        ]);

        DB::transaction(function () use ($validated) {

            $product = Product::whereKey($validated['product_id'])
                ->lockForUpdate()
                ->firstOrFail();

            if ($validated['type'] === 'out') {
                if ($product->quantity < $validated['quantity']) {
                    throw ValidationException::withMessages([
                        'quantity' => 'Insufficient stock. Available quantity: '
                            . $product->quantity,
                    ]);
                }

                $product->decrement('quantity', $validated['quantity']);
            } else {
                $product->increment('quantity', $validated['quantity']);
            }

            $userId = Auth::id() ?? User::query()->value('id');

            if (!$userId) {
                throw ValidationException::withMessages([
                    'product_id' => 'A user account is required to record this transaction.',
                ]);
            }

            StockTransaction::create([
                'product_id' => $product->id,
                'user_id' => $userId,
                'type' => $validated['type'],
                'quantity' => $validated['quantity'],
                'unit_price' => $validated['unit_price'],
                'note' => $validated['note'] ?? null,
                'transaction_date' => $validated['transaction_date'],
            ]);
        });

        return redirect()->route('stock-transactions.index')
            ->with('success', 'Stock transaction recorded successfully.');
    }
}