<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with('product');

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $transactions = $query->latest()->paginate(preg_match('/Mobile|Android|iPhone/i', $request->userAgent()) ? 10 : 15)->withQueryString();
        $products = Product::all();

        return view('finances.index', compact('transactions', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:entree,sortie',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'note' => 'nullable|string',
        ]);

        $product = Product::findOrFail($validated['product_id']);

        if ($validated['type'] === 'entree') {
            $product->increment('quantity', $validated['quantity']);
        } else {
            if ($product->quantity < $validated['quantity']) {
                return back()->withErrors(['quantity' => 'Stock insuffisant.'])->withInput();
            }
            $product->decrement('quantity', $validated['quantity']);
        }

        Transaction::create($validated);

        return redirect()->route('finances.index')->with('success', 'Transaction enregistrée avec succès.');
    }
}
