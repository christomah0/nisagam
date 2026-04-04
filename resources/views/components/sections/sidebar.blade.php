<!-- Mobile sidebar -->
<aside
    x-show="sidebarOpen"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="-translate-x-full"
    x-transition:enter-end="translate-x-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="translate-x-0"
    x-transition:leave-end="-translate-x-full"
    @click.outside="sidebarOpen = false"
    class="flex flex-col h-full bg-white border-r border-gray-200 w-64 fixed top-0 left-0 z-40 lg:hidden"
    style="display: none;">

    @include('components.sections.sidebar-content')
</aside>

<!-- Desktop sidebar (always visible) -->
<aside class="hidden lg:flex flex-col h-full bg-white border-r border-gray-200 w-64 fixed top-0 left-0 z-40">
    @include('components.sections.sidebar-content')
</aside>
