<header {{ $attributes->merge([
    'class' => '
    flex items-center justify-end 
    px-4 sm:px-6 lg:px-8 
    h-16 border-b border-gray-200 
    bg-white shadow fixed top-0 w-full z-10
'
]) }}>
    <div class="flex items-center space-x-4">
        <div class="hidden sm:block">
            <a href="/profile"
                class="flex items-center space-x-2 text-sm text-gray-700 hover:text-amber-600 transition duration-150">
                <div
                    class="h-8 w-8 rounded-full bg-gray-300 flex items-center justify-center text-xs font-semibold text-gray-600">
                    JD
                </div>
                <span>John Doe</span>
            </a>
        </div>

        <button type="button"
            class="md:hidden p-1 text-gray-500 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-amber-500 rounded-md">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
            </svg>
        </button>
    </div>

</header>