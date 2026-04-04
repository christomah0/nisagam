<div class="p-4 flex items-center h-[70px] border-b border-gray-100">
    <span class="text-2xl text-center font-extrabold text-amber-600">
        NISAGAM
    </span>
</div>

<!-- Navigation -->
<nav class="flex-1 overflow-y-auto p-4 space-y-2">
    <x-nav-link href="{{ route('dashboard') }}" :active="request()->is('/')">
        <img src="/images/dashboard.svg" width="24" height="24">
        Tableau de bord
    </x-nav-link>

    <x-nav-link href="{{ route('inventory.index') }}" :active="request()->is('inventory*')">
        <img src="/images/inventaire.svg" width="24" height="24">
        Inventaire
    </x-nav-link>

    <x-nav-link href="{{ route('suppliers.index') }}" :active="request()->is('suppliers*')">
        <img src="/images/fournisseurs.svg" width="24" height="24">
        Fournisseurs
    </x-nav-link>

    <x-nav-link href="{{ route('finances.index') }}" :active="request()->is('finances*')">
        <img src="/images/card.svg" width="24" height="24">
        Finances
    </x-nav-link>

    <x-nav-link href="{{ route('reports') }}" :active="request()->is('reports')">
        <img src="/images/report-business.svg" width="24" height="24">
        Rapports
    </x-nav-link>
</nav>

<div class="p-4 border-t border-gray-100 space-y-2">
    <x-nav-link href="{{ route('settings') }}" :active="request()->is('settings*')">
        <img src="/images/settings.svg" width="24" height="24">
        Paramètres
    </x-nav-link>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="flex items-center p-3 rounded-lg text-gray-600 hover:text-amber-700 transition duration-150 ease-in-out gap-4 w-full cursor-pointer">
            <img src="/images/logout.svg" width="24" height="24">
            Déconnexion
        </button>
    </form>
</div>
