<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Product စာရင်းပြရန်
    public function index()
    {
        $products = Product::with('category')
            ->latest()
            ->paginate(10);

        return view('products.index', compact('products'));
    }

    // Product အသစ်ထည့်ရန် Form
    public function create()
    {
        $categories = Category::where('status', true)
            ->orderBy('name')
            ->get();

        return view('products.create', compact('categories'));
    }

    // Product အသစ်သိမ်းရန်
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:255|unique:products,sku',
            'description' => 'nullable|string',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'min_stock_level' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
            'status' => 'required|boolean',
        ]);

        Product::create($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    // Product ပြင်ရန် Form
    public function edit(Product $product)
    {
        $categories = Category::where('status', true)
            ->orderBy('name')
            ->get();

        return view('products.edit', compact('product', 'categories'));
    }

    // Product ပြင်ဆင်ပြီး သိမ်းရန်
   public function update(Request $request, Product $product)
        {
            $validated = $request->validate([
                'category_id' => 'required|exists:categories,id',
                'name' => 'required|string|max:255',
                'sku' => 'required|string|max:255|unique:products,sku,' . $product->id,
                'description' => 'nullable|string',
                'purchase_price' => 'required|numeric|min:0',
                'selling_price' => 'required|numeric|min:0',
                'min_stock_level' => 'required|integer|min:0',
                'unit' => 'required|string|max:50',
                'status' => 'required|boolean',
            ]);

            $product->update($validated);

            return redirect()
                ->route('products.index')
                ->with('success', 'Product updated successfully.');
        }

    // Product ဖျက်ရန်
    public function destroy(Product $product)
    {
        if ($product->stockTransactions()->exists()) {
            return redirect()
                ->route('products.index')
                ->with('error', 'Cannot delete a product with stock transactions.');
        }

        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }
}