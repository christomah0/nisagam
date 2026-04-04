<x-layouts.dashboard-layout title="Paramètres">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Paramètres</h1>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Categories Management -->
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Catégories</h2>

            <form method="POST" action="{{ route('settings.categories.store') }}" class="flex gap-2 mb-4">
                @csrf
                <input type="text" name="name" placeholder="Nouvelle catégorie..." required
                    class="border border-gray-300 rounded-lg px-4 py-2 flex-1">
                <button type="submit" class="bg-amber-500 text-white px-4 py-2 rounded-lg hover:bg-amber-600 transition">
                    Ajouter
                </button>
            </form>
            @error('name')
                <p class="text-red-500 text-sm mb-2">{{ $message }}</p>
            @enderror

            <ul class="divide-y divide-gray-100">
                @forelse ($categories as $category)
                    <li class="flex items-center justify-between py-3">
                        <div>
                            <span class="font-medium text-gray-800">{{ $category->name }}</span>
                            <span class="text-sm text-gray-500 ml-2">({{ $category->products_count }} produits)</span>
                        </div>
                        <form method="POST" action="{{ route('settings.categories.destroy', $category) }}"
                            onsubmit="return confirm('Supprimer cette catégorie?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                Supprimer
                            </button>
                        </form>
                    </li>
                @empty
                    <li class="py-3 text-gray-500 text-center">Aucune catégorie.</li>
                @endforelse
            </ul>
        </div>

        <!-- User Management -->
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Utilisateurs</h2>

            <!-- Register Form -->
            <form method="POST" action="{{ route('register') }}" class="mb-6 space-y-3 border-b border-gray-100 pb-6">
                @csrf
                <input type="text" name="name" placeholder="Nom complet" value="{{ old('name') }}" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2">
                @error('name')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror

                <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2">
                @error('email')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror

                <input type="password" name="password" placeholder="Mot de passe" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2">
                @error('password')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror

                <input type="password" name="password_confirmation" placeholder="Confirmer le mot de passe" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2">

                <button type="submit" class="bg-amber-500 text-white w-full py-2 rounded-lg hover:bg-amber-600 transition font-semibold">
                    Créer un utilisateur
                </button>
            </form>

            <!-- User List -->
            <ul class="divide-y divide-gray-100">
                @foreach ($users as $user)
                    <li class="flex items-center justify-between py-3">
                        <div>
                            <span class="font-medium text-gray-800">{{ $user->name }}</span>
                            <span class="text-sm text-gray-500 block">{{ $user->email }}</span>
                        </div>
                        @if ($user->id !== auth()->id())
                            <form method="POST" action="{{ route('settings.users.destroy', $user) }}"
                                onsubmit="return confirm('Supprimer cet utilisateur?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                    Supprimer
                                </button>
                            </form>
                        @else
                            <span class="text-xs bg-amber-100 text-amber-700 px-2 py-1 rounded-full">Vous</span>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</x-layouts.dashboard-layout>
