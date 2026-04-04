<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;

class ReportController extends Controller
{
    public function __invoke()
    {
        $lowStockProducts = Product::whereColumn('quantity', '<=', 'stock_alert')
            ->with('category')
            ->get();

        $topProducts = Product::orderByDesc('quantity')->take(10)->get();

        $totalEntries = Transaction::where('type', 'entree')
            ->selectRaw('SUM(quantity * unit_price) as total')
            ->value('total') ?? 0;

        $totalExits = Transaction::where('type', 'sortie')
            ->selectRaw('SUM(quantity * unit_price) as total')
            ->value('total') ?? 0;

        return view('reports.index', compact(
            'lowStockProducts',
            'topProducts',
            'totalEntries',
            'totalExits',
        ));
    }
}
