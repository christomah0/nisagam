<x-layouts.dashboard-layout title="Finances">
    <div x-data="{
        showCreate: false,
        showDetail: false,
        selectedTransaction: null,
        openDetail(transaction) {
            this.selectedTransaction = transaction;
            this.showDetail = true;
        }
    }">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Transactions</h1>
            <button @click="showCreate = true"
                class="bg-amber-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-amber-600 transition cursor-pointer">
                + Nouvelle transaction
            </button>
        </div>

        <!-- Filter -->
        <form method="GET" class="flex gap-4 mb-6">
            <select name="type" class="border border-gray-300 rounded-lg px-4 py-2">
                <option value="">Tous les types</option>
                <option value="entree" {{ request('type') === 'entree' ? 'selected' : '' }}>Entrée</option>
                <option value="sortie" {{ request('type') === 'sortie' ? 'selected' : '' }}>Sortie</option>
            </select>
            <button type="submit" class="bg-gray-700 text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition">
                Filtrer
            </button>
        </form>

        <!-- Desktop Table -->
        <div class="hidden sm:block bg-white rounded-xl shadow overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Type</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Produit</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Quantité</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Prix unitaire</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Total</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Note</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($transactions as $transaction)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-gray-600">{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $transaction->type === 'entree' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $transaction->type === 'entree' ? 'Entrée' : 'Sortie' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-600">{{ $transaction->product?->name ?? '—' }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $transaction->quantity }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ number_format($transaction->unit_price, 2) }} MGA</td>
                            <td class="px-6 py-4 font-medium text-gray-900">
                                {{ number_format($transaction->quantity * $transaction->unit_price, 2) }} MGA
                            </td>
                            <td class="px-6 py-4 text-gray-500 text-sm">{{ $transaction->note ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">Aucune transaction trouvée.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Card List -->
        <div class="sm:hidden space-y-3">
            @forelse ($transactions as $transaction)
                <div @click="openDetail({
                    date: '{{ $transaction->created_at->format('d/m/Y H:i') }}',
                    type: '{{ $transaction->type }}',
                    typeLabel: '{{ $transaction->type === 'entree' ? 'Entrée' : 'Sortie' }}',
                    product: '{{ addslashes($transaction->product?->name ?? '—') }}',
                    quantity: '{{ $transaction->quantity }}',
                    unitPrice: '{{ number_format($transaction->unit_price, 2) }}',
                    total: '{{ number_format($transaction->quantity * $transaction->unit_price, 2) }}',
                    note: '{{ addslashes($transaction->note ?? '') }}'
                })" class="bg-white rounded-xl shadow p-4 active:bg-gray-50 cursor-pointer">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="font-semibold text-gray-900">{{ $transaction->product?->name ?? '—' }}</p>
                            <p class="text-xs text-gray-400 mt-1">{{ $transaction->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div class="text-right">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $transaction->type === 'entree' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $transaction->type === 'entree' ? 'Entrée' : 'Sortie' }}
                            </span>
                            <p class="font-semibold text-gray-800 mt-1">{{ number_format($transaction->quantity * $transaction->unit_price, 2) }} MGA</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500 py-8">Aucune transaction trouvée.</div>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $transactions->links() }}
        </div>

        <!-- Detail Bottomsheet (mobile) -->
        <x-modal name="showDetail" title="Détails de la transaction">
            <template x-if="selectedTransaction">
                <div>
                    <dl class="space-y-3">
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-500">Date</dt>
                            <dd class="text-sm text-gray-700" x-text="selectedTransaction.date"></dd>
                        </div>
                        <div class="flex justify-between items-center">
                            <dt class="text-sm text-gray-500">Type</dt>
                            <dd>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full"
                                    :class="selectedTransaction.type === 'entree' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'"
                                    x-text="selectedTransaction.typeLabel"></span>
                            </dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-500">Produit</dt>
                            <dd class="text-sm font-medium text-gray-900" x-text="selectedTransaction.product"></dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-500">Quantité</dt>
                            <dd class="text-sm text-gray-700" x-text="selectedTransaction.quantity"></dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-500">Prix unitaire</dt>
                            <dd class="text-sm text-gray-700"><span x-text="selectedTransaction.unitPrice"></span> MGA</dd>
                        </div>
                        <div class="flex justify-between border-t border-gray-100 pt-3">
                            <dt class="text-sm font-semibold text-gray-700">Total</dt>
                            <dd class="text-sm font-bold text-gray-900"><span x-text="selectedTransaction.total"></span> MGA</dd>
                        </div>
                        <div x-show="selectedTransaction.note">
                            <dt class="text-sm text-gray-500 mb-1">Note</dt>
                            <dd class="text-sm text-gray-700" x-text="selectedTransaction.note"></dd>
                        </div>
                    </dl>

                    <div class="mt-6">
                        <button @click="showDetail = false"
                            class="w-full bg-gray-200 text-gray-700 font-semibold py-3 rounded-lg cursor-pointer hover:bg-gray-300 transition">
                            Fermer
                        </button>
                    </div>
                </div>
            </template>
        </x-modal>

        <!-- Create Modal -->
        <x-modal name="showCreate" title="Nouvelle transaction">
            <form method="POST" action="{{ route('finances.store') }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                        <select name="type" required class="w-full border border-gray-300 rounded-lg px-4 py-2">
                            <option value="entree">Entrée (achat/réception)</option>
                            <option value="sortie">Sortie (vente/utilisation)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Produit</label>
                        <select name="product_id" required class="w-full border border-gray-300 rounded-lg px-4 py-2">
                            <option value="">— Sélectionner —</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }} (stock: {{ $product->quantity }})</option>
                            @endforeach
                        </select>
                        @error('product_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Quantité</label>
                            <input type="number" name="quantity" value="{{ old('quantity') }}" min="1" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2">
                            @error('quantity') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Prix unitaire (MGA)</label>
                            <input type="number" name="unit_price" value="{{ old('unit_price') }}" step="0.01" min="0" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2">
                            @error('unit_price') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Note</label>
                        <textarea name="note" rows="2" class="w-full border border-gray-300 rounded-lg px-4 py-2">{{ old('note') }}</textarea>
                    </div>
                </div>
                <div class="mt-6 flex gap-3 justify-end">
                    <button type="button" @click="showCreate = false"
                        class="bg-gray-200 text-gray-700 font-semibold py-2 px-6 rounded-lg hover:bg-gray-300 transition cursor-pointer">Annuler</button>
                    <button type="submit"
                        class="bg-amber-500 text-white font-semibold py-2 px-6 rounded-lg hover:bg-amber-600 transition cursor-pointer">Enregistrer</button>
                </div>
            </form>
        </x-modal>
    </div>
</x-layouts.dashboard-layout>
