<aside {{ $attributes->merge([
    'class' => '
        flex flex-col h-full bg-white border-r border-gray-200 
        w-64 transform transition-transform duration-300 ease-in-out 
        fixed top-0 left-0 z-40
    '
]) }}>

    <div class="p-4 flex items-center h-[70px] border-b border-gray-100">
        <span class="text-2xl text-center font-extrabold text-amber-600">
            NISAGAM
        </span>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto p-4 space-y-2">
        <x-nav-link :active="request()->is('dashboard')">
            <img src="/images/dashboard.svg" width="24" height="24">
            Tableau de bord
        </x-nav-link>

        <x-nav-link :active="request()->is('inventory')">
            <img src="/images/inventaire.svg" width="24" height="24">
            Inventaire
        </x-nav-link>

        <x-nav-link :active="request()->is('orders')">
            <img src="/images/fournisseurs.svg" width="24" height="24">
            Fournisseurs
        </x-nav-link>

        <x-nav-link :active="request()->is('finances')">
            <img src="/images/card.svg" width="24" height="24">
            Finances
        </x-nav-link>

        <x-nav-link :active="request()->is('reports')">
            <img src="/images/report-business.svg" width="24" height="24">
            Rapports
        </x-nav-link>
    </nav>

    <div class="p-4 border-t border-gray-100">
        <x-nav-link :active="request()->is('settings')">
            <img src="/images/settings.svg" width="24" height="24">
            Paramètres
        </x-nav-link>
        <x-nav-link>
            <img src="/images/logout.svg" width="24" height="24">
            Déconnexion
        </x-nav-link>
    </div>

</aside>