<header {{ $attributes->merge([
    'class' => '
    flex items-center justify-between
    px-4 sm:px-6 lg:px-8
    h-[70px] border-b border-gray-200
    bg-white shadow fixed top-0 w-full z-10
    lg:pl-72
'
]) }}>
    <!-- Mobile menu button -->
    <button @click="sidebarOpen = !sidebarOpen" type="button"
        class="lg:hidden p-2 text-gray-500 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-amber-500 rounded-md">
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
        </svg>
    </button>

    <div class="hidden lg:block"></div>

    <div class="flex items-center space-x-2 text-sm text-gray-700">
        <div class="h-8 w-8 rounded-full bg-amber-100 flex items-center justify-center text-xs font-semibold text-amber-700">
            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
        </div>
        <span class="hidden sm:inline">{{ auth()->user()->name }}</span>
    </div>
</header>
