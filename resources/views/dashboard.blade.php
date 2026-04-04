<x-layouts.dashboard-layout title="Tableau de bord">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Tableau de bord</h1>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow p-6">
            <p class="text-sm text-gray-500 mb-1">Total produits</p>
            <p class="text-3xl font-bold text-gray-800">{{ $totalProducts }}</p>
        </div>
        <div class="bg-white rounded-xl shadow p-6">
            <p class="text-sm text-gray-500 mb-1">Fournisseurs</p>
            <p class="text-3xl font-bold text-gray-800">{{ $totalSuppliers }}</p>
        </div>
        <div class="bg-white rounded-xl shadow p-6">
            <p class="text-sm text-gray-500 mb-1">Stock bas</p>
            <p class="text-3xl font-bold {{ $lowStockProducts > 0 ? 'text-red-600' : 'text-green-600' }}">
                {{ $lowStockProducts }}
            </p>
        </div>
        <div class="bg-white rounded-xl shadow p-6">
            <p class="text-sm text-gray-500 mb-1">Valeur du stock</p>
            <p class="text-3xl font-bold text-amber-600">{{ number_format($totalStockValue, 2) }} MGA</p>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div>
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-gray-800">Transactions récentes</h2>
            <a href="{{ route('finances.index') }}" class="text-amber-600 hover:text-amber-800 text-sm font-medium">
                Voir tout &rarr;
            </a>
        </div>
        <div class="bg-white rounded-xl shadow overflow-x-auto">
            <table class="w-full text-left min-w-[600px]">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Type</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Produit</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Quantité</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($recentTransactions as $transaction)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-gray-600">{{ $transaction->created_at->format('d/m/Y') }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $transaction->type === 'entree' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $transaction->type === 'entree' ? 'Entrée' : 'Sortie' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-600">{{ $transaction->product?->name ?? '—' }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $transaction->quantity }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900">
                                {{ number_format($transaction->quantity * $transaction->unit_price, 2) }} MGA
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">Aucune transaction récente.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.dashboard-layout>
