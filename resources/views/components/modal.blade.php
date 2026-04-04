@props(['name', 'title' => ''])

<div x-show="{{ $name }}" x-cloak class="fixed inset-0 z-50" style="display: none;">
    <!-- Backdrop -->
    <div x-show="{{ $name }}" x-transition.opacity class="absolute inset-0 bg-black/50" @click="{{ $name }} = false"></div>

    <!-- Desktop: centered modal -->
    <div x-show="{{ $name }}"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="hidden sm:flex items-center justify-center absolute inset-0 p-4 pointer-events-none">
        <div class="relative bg-white rounded-xl shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto pointer-events-auto">
            <div class="flex items-center justify-between p-6 border-b border-gray-100">
                <h2 class="text-xl font-bold text-gray-800">{{ $title }}</h2>
                <button @click="{{ $name }} = false" type="button" class="text-gray-400 hover:text-gray-600 cursor-pointer">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="p-6">
                {{ $slot }}
            </div>
        </div>
    </div>

    <!-- Mobile: bottomsheet -->
    <div x-show="{{ $name }}"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="translate-y-full"
        x-transition:enter-end="translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="translate-y-0"
        x-transition:leave-end="translate-y-full"
        class="sm:hidden absolute bottom-0 left-0 right-0">
        <div class="bg-white rounded-t-2xl shadow-xl max-h-[85vh] overflow-y-auto">
            <div class="flex justify-center pt-3 pb-1">
                <div class="w-10 h-1 bg-gray-300 rounded-full"></div>
            </div>
            <div class="flex items-center justify-between px-5 pb-3 border-b border-gray-100">
                <h2 class="text-lg font-bold text-gray-800">{{ $title }}</h2>
                <button @click="{{ $name }} = false" type="button" class="text-gray-400 hover:text-gray-600 cursor-pointer">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="p-5">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
