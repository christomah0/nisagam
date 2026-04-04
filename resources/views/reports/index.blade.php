<x-layouts.dashboard-layout title="Rapports">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Rapports</h1>

    <!-- Financial Summary -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow p-6">
            <p class="text-sm text-gray-500 mb-1">Total Entrées</p>
            <p class="text-2xl font-bold text-green-600">{{ number_format($totalEntries, 2) }} MGA</p>
        </div>
        <div class="bg-white rounded-xl shadow p-6">
            <p class="text-sm text-gray-500 mb-1">Total Sorties</p>
            <p class="text-2xl font-bold text-red-600">{{ number_format($totalExits, 2) }} MGA</p>
        </div>
        <div class="bg-white rounded-xl shadow p-6">
            <p class="text-sm text-gray-500 mb-1">Solde net</p>
            <p class="text-2xl font-bold {{ $totalEntries - $totalExits >= 0 ? 'text-green-600' : 'text-red-600' }}">
                {{ number_format($totalEntries - $totalExits, 2) }} MGA
            </p>
        </div>
    </div>

    <!-- Low Stock Alert -->
    <div class="mb-8">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Produits en stock bas</h2>
        <div class="bg-white rounded-xl shadow overflow-x-auto">
            <table class="w-full text-left min-w-[500px]">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Produit</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Catégorie</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Stock actuel</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Seuil alerte</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($lowStockProducts as $product)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $product->name }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $product->category?->name ?? '—' }}</td>
                            <td class="px-6 py-4 text-red-600 font-semibold">{{ $product->quantity }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $product->stock_alert }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500">Aucun produit en stock bas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Top Products -->
    <div>
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Top 10 produits (par quantité)</h2>
        <div class="bg-white rounded-xl shadow overflow-x-auto">
            <table class="w-full text-left min-w-[500px]">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase">#</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Produit</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Quantité</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Valeur</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($topProducts as $index => $product)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-gray-600">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $product->name }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $product->quantity }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ number_format($product->price * $product->quantity, 2) }} MGA</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500">Aucun produit trouvé.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.dashboard-layout>
