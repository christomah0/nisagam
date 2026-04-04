<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Supplier;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $totalProducts = Product::count();
        $totalSuppliers = Supplier::count();
        $lowStockProducts = Product::whereColumn('quantity', '<=', 'stock_alert')->count();
        $totalStockValue = Product::selectRaw('SUM(price * quantity) as total')->value('total') ?? 0;

        $recentTransactions = Transaction::with('product')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalProducts',
            'totalSuppliers',
            'lowStockProducts',
            'totalStockValue',
            'recentTransactions',
        ));
    }
}
