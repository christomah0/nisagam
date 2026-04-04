<x-layouts.dashboard-layout title="Fournisseurs">
    <div x-data="{
        showCreate: false,
        showEdit: false,
        showDetail: false,
        selectedSupplier: null,
        editSupplier: { id: null, name: '', email: '', phone: '', address: '' },
        openDetail(supplier) {
            this.selectedSupplier = supplier;
            this.showDetail = true;
        },
        openEdit(supplier) {
            this.editSupplier = supplier;
            this.showDetail = false;
            this.showEdit = true;
        }
    }">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Fournisseurs</h1>
            <button @click="showCreate = true"
                class="bg-amber-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-amber-600 transition cursor-pointer">
                + Nouveau fournisseur
            </button>
        </div>

        <!-- Search -->
        <form method="GET" class="flex flex-col sm:flex-row gap-3 sm:gap-4 mb-6">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher un fournisseur..."
                class="border border-gray-300 rounded-lg px-4 py-2 flex-1">
            <button type="submit" class="bg-gray-700 text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition">
                Rechercher
            </button>
        </form>

        <!-- Desktop Table -->
        <div class="hidden sm:block bg-white rounded-xl shadow overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Nom</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Téléphone</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Produits</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($suppliers as $supplier)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $supplier->name }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $supplier->email ?? '—' }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $supplier->phone ?? '—' }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $supplier->products_count }}</td>
                            <td class="px-6 py-4 flex gap-2">
                                <button @click="openEdit({
                                    id: {{ $supplier->id }},
                                    name: '{{ addslashes($supplier->name) }}',
                                    email: '{{ addslashes($supplier->email ?? '') }}',
                                    phone: '{{ addslashes($supplier->phone ?? '') }}',
                                    address: '{{ addslashes($supplier->address ?? '') }}'
                                })" class="text-amber-600 hover:text-amber-800 text-sm font-medium cursor-pointer">Modifier</button>
                                <form method="POST" action="{{ route('suppliers.destroy', $supplier) }}"
                                    onsubmit="return confirm('Supprimer ce fournisseur?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium cursor-pointer">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">Aucun fournisseur trouvé.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Card List -->
        <div class="sm:hidden space-y-3">
            @forelse ($suppliers as $supplier)
                <div @click="openDetail({
                    id: {{ $supplier->id }},
                    name: '{{ addslashes($supplier->name) }}',
                    email: '{{ addslashes($supplier->email ?? '') }}',
                    phone: '{{ addslashes($supplier->phone ?? '') }}',
                    address: '{{ addslashes($supplier->address ?? '') }}',
                    productsCount: '{{ $supplier->products_count }}',
                    destroyUrl: '{{ route('suppliers.destroy', $supplier) }}'
                })" class="bg-white rounded-xl shadow p-4 active:bg-gray-50 cursor-pointer">
                    <p class="font-semibold text-gray-900">{{ $supplier->name }}</p>
                    <p class="text-sm text-gray-500 mt-1">{{ $supplier->phone ?? $supplier->email ?? '—' }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ $supplier->products_count }} produit(s)</p>
                </div>
            @empty
                <div class="text-center text-gray-500 py-8">Aucun fournisseur trouvé.</div>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $suppliers->links() }}
        </div>

        <!-- Detail Bottomsheet (mobile) -->
        <x-modal name="showDetail" title="Détails du fournisseur">
            <template x-if="selectedSupplier">
                <div>
                    <dl class="space-y-3">
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-500">Nom</dt>
                            <dd class="text-sm font-medium text-gray-900" x-text="selectedSupplier.name"></dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-500">Email</dt>
                            <dd class="text-sm text-gray-700" x-text="selectedSupplier.email || '—'"></dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-500">Téléphone</dt>
                            <dd class="text-sm text-gray-700" x-text="selectedSupplier.phone || '—'"></dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-500">Produits</dt>
                            <dd class="text-sm text-gray-700" x-text="selectedSupplier.productsCount"></dd>
                        </div>
                        <div x-show="selectedSupplier.address">
                            <dt class="text-sm text-gray-500 mb-1">Adresse</dt>
                            <dd class="text-sm text-gray-700" x-text="selectedSupplier.address"></dd>
                        </div>
                    </dl>

                    <div class="mt-6 flex gap-3">
                        <button @click="openEdit({
                            id: selectedSupplier.id,
                            name: selectedSupplier.name,
                            email: selectedSupplier.email,
                            phone: selectedSupplier.phone,
                            address: selectedSupplier.address
                        })" class="flex-1 bg-amber-500 text-white font-semibold py-3 rounded-lg text-center cursor-pointer hover:bg-amber-600 transition">
                            Modifier
                        </button>
                        <form method="POST" :action="selectedSupplier.destroyUrl" class="flex-1"
                            onsubmit="return confirm('Supprimer ce fournisseur?')">
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
        <x-modal name="showCreate" title="Nouveau fournisseur">
            <form method="POST" action="{{ route('suppliers.store') }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2">
                        @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                        <input type="text" name="phone" value="{{ old('phone') }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Adresse</label>
                        <textarea name="address" rows="2" class="w-full border border-gray-300 rounded-lg px-4 py-2">{{ old('address') }}</textarea>
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
        <x-modal name="showEdit" title="Modifier fournisseur">
            <form method="POST" :action="'/suppliers/' + editSupplier.id">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                        <input type="text" name="name" x-model="editSupplier.name" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" x-model="editSupplier.email"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                        <input type="text" name="phone" x-model="editSupplier.phone"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Adresse</label>
                        <textarea name="address" rows="2" x-model="editSupplier.address"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2"></textarea>
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
