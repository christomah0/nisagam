<x-layouts.dashboard-layout title="Inventaire">
    <div x-data="{
        showCreate: false,
        showEdit: false,
        showDetail: false,
        selectedProduct: null,
        editProduct: { id: null, name: '', description: '', price: '', quantity: '', stock_alert: '', category_id: '', supplier_id: '' },
        openDetail(product) {
            this.selectedProduct = product;
            this.showDetail = true;
        },
        openEdit(product) {
            this.editProduct = product;
            this.showDetail = false;
            this.showEdit = true;
        }
    }">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Inventaire</h1>
            <button @click="showCreate = true"
                class="bg-amber-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-amber-600 transition cursor-pointer">
                + Nouveau produit
            </button>
        </div>

        <!-- Filters -->
        <form method="GET" class="flex flex-col sm:flex-row gap-3 sm:gap-4 mb-6">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher un produit..."
                class="border border-gray-300 rounded-lg px-4 py-2 flex-1">
            <select name="category" class="border border-gray-300 rounded-lg px-4 py-2">
                <option value="">Toutes les catégories</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
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
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Produit</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Catégorie</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Fournisseur</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Prix</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Quantité</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($products as $product)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $product->name }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $product->category?->name ?? '—' }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $product->supplier?->name ?? '—' }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ number_format($product->price, 2) }} MGA</td>
                            <td class="px-6 py-4">
                                <span class="{{ $product->quantity <= $product->stock_alert ? 'text-red-600 font-semibold' : 'text-gray-600' }}">
                                    {{ $product->quantity }}
                                </span>
                                @if ($product->quantity <= $product->stock_alert)
                                    <span class="ml-1 text-xs bg-red-100 text-red-700 px-2 py-0.5 rounded-full">Stock bas</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 flex gap-2">
                                <button @click="openEdit({
                                    id: {{ $product->id }},
                                    name: '{{ addslashes($product->name) }}',
                                    description: '{{ addslashes($product->description) }}',
                                    price: '{{ $product->price }}',
                                    quantity: '{{ $product->quantity }}',
                                    stock_alert: '{{ $product->stock_alert }}',
                                    category_id: '{{ $product->category_id ?? '' }}',
                                    supplier_id: '{{ $product->supplier_id ?? '' }}'
                                })" class="text-amber-600 hover:text-amber-800 text-sm font-medium cursor-pointer">Modifier</button>
                                <form method="POST" action="{{ route('inventory.destroy', $product) }}"
                                    onsubmit="return confirm('Supprimer ce produit?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium cursor-pointer">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">Aucun produit trouvé.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Card List -->
        <div class="sm:hidden space-y-3">
            @forelse ($products as $product)
                <div @click="openDetail({
                    id: {{ $product->id }},
                    name: '{{ addslashes($product->name) }}',
                    description: '{{ addslashes($product->description) }}',
                    price: '{{ $product->price }}',
                    priceFormatted: '{{ number_format($product->price, 2) }}',
                    quantity: '{{ $product->quantity }}',
                    stock_alert: '{{ $product->stock_alert }}',
                    category: '{{ addslashes($product->category?->name ?? '—') }}',
                    supplier: '{{ addslashes($product->supplier?->name ?? '—') }}',
                    category_id: '{{ $product->category_id ?? '' }}',
                    supplier_id: '{{ $product->supplier_id ?? '' }}',
                    lowStock: {{ $product->quantity <= $product->stock_alert ? 'true' : 'false' }},
                    destroyUrl: '{{ route('inventory.destroy', $product) }}'
                })" class="bg-white rounded-xl shadow p-4 active:bg-gray-50 cursor-pointer">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="font-semibold text-gray-900">{{ $product->name }}</p>
                            <p class="text-sm text-gray-500">{{ $product->category?->name ?? '—' }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold text-gray-800">{{ number_format($product->price, 2) }} MGA</p>
                            <p class="text-sm {{ $product->quantity <= $product->stock_alert ? 'text-red-600 font-semibold' : 'text-gray-500' }}">
                                Qté: {{ $product->quantity }}
                                @if ($product->quantity <= $product->stock_alert)
                                    <span class="text-xs bg-red-100 text-red-700 px-1.5 py-0.5 rounded-full ml-1">Bas</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500 py-8">Aucun produit trouvé.</div>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $products->links() }}
        </div>

        <!-- Detail Bottomsheet (mobile) -->
        <x-modal name="showDetail" title="Détails du produit">
            <template x-if="selectedProduct">
                <div>
                    <dl class="space-y-3">
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-500">Nom</dt>
                            <dd class="text-sm font-medium text-gray-900" x-text="selectedProduct.name"></dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-500">Catégorie</dt>
                            <dd class="text-sm text-gray-700" x-text="selectedProduct.category"></dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-500">Fournisseur</dt>
                            <dd class="text-sm text-gray-700" x-text="selectedProduct.supplier"></dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-500">Prix</dt>
                            <dd class="text-sm font-semibold text-gray-900"><span x-text="selectedProduct.priceFormatted"></span> MGA</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-500">Quantité</dt>
                            <dd class="text-sm" :class="selectedProduct.lowStock ? 'text-red-600 font-semibold' : 'text-gray-700'" x-text="selectedProduct.quantity"></dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-500">Seuil alerte</dt>
                            <dd class="text-sm text-gray-700" x-text="selectedProduct.stock_alert"></dd>
                        </div>
                        <div x-show="selectedProduct.description">
                            <dt class="text-sm text-gray-500 mb-1">Description</dt>
                            <dd class="text-sm text-gray-700" x-text="selectedProduct.description"></dd>
                        </div>
                    </dl>

                    <div class="mt-6 flex gap-3">
                        <button @click="openEdit({
                            id: selectedProduct.id,
                            name: selectedProduct.name,
                            description: selectedProduct.description,
                            price: selectedProduct.price,
                            quantity: selectedProduct.quantity,
                            stock_alert: selectedProduct.stock_alert,
                            category_id: selectedProduct.category_id,
                            supplier_id: selectedProduct.supplier_id
                        })" class="flex-1 bg-amber-500 text-white font-semibold py-3 rounded-lg text-center cursor-pointer hover:bg-amber-600 transition">
                            Modifier
                        </button>
                        <form method="POST" :action="selectedProduct.destroyUrl" class="flex-1"
                            onsubmit="return confirm('Supprimer ce produit?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-50 text-red-600 font-semibold py-3 rounded-lg border border-red-200 cursor-pointer hover:bg-red-100 transition">
                                Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            </template>
        </x-modal>

        <!-- Create Modal -->
        <x-modal name="showCreate" title="Nouveau produit">
            <form method="POST" action="{{ route('inventory.store') }}">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nom du produit</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2">
                        @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="description" rows="2" class="w-full border border-gray-300 rounded-lg px-4 py-2">{{ old('description') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Prix (MGA)</label>
                        <input type="number" name="price" value="{{ old('price') }}" step="0.01" min="0" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2">
                        @error('price') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Quantité</label>
                        <input type="number" name="quantity" value="{{ old('quantity', 0) }}" min="0" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alerte stock</label>
                        <input type="number" name="stock_alert" value="{{ old('stock_alert', 5) }}" min="0" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Catégorie</label>
                        <select name="category_id" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                            <option value="">— Aucune —</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fournisseur</label>
                        <select name="supplier_id" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                            <option value="">— Aucun —</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                            @endforeach
                        </select>
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

        <!-- Edit Modal -->
        <x-modal name="showEdit" title="Modifier produit">
            <form method="POST" :action="'/inventory/' + editProduct.id">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nom du produit</label>
                        <input type="text" name="name" x-model="editProduct.name" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="description" rows="2" x-model="editProduct.description"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Prix (MGA)</label>
                        <input type="number" name="price" x-model="editProduct.price" step="0.01" min="0" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Quantité</label>
                        <input type="number" name="quantity" x-model="editProduct.quantity" min="0" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alerte stock</label>
                        <input type="number" name="stock_alert" x-model="editProduct.stock_alert" min="0" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Catégorie</label>
                        <select name="category_id" x-model="editProduct.category_id" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                            <option value="">— Aucune —</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fournisseur</label>
                        <select name="supplier_id" x-model="editProduct.supplier_id" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                            <option value="">— Aucun —</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mt-6 flex gap-3 justify-end">
                    <button type="button" @click="showEdit = false"
                        class="bg-gray-200 text-gray-700 font-semibold py-2 px-6 rounded-lg hover:bg-gray-300 transition cursor-pointer">Annuler</button>
                    <button type="submit"
                        class="bg-amber-500 text-white font-semibold py-2 px-6 rounded-lg hover:bg-amber-600 transition cursor-pointer">Mettre à jour</button>
                </div>
            </form>
        </x-modal>
    </div>
</x-layouts.dashboard-layout>
