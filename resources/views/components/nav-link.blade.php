@props(['active' => false])

<a {{ $attributes }} class="flex items-center p-3 rounded-lg text-gray-700 cursor-pointer gap-4 {{ $active
    ? 'font-semibold transition duration-150 ease-in-out bg-amber-500 text-white hover:bg-amber-600'
    : 'text-gray-600 hover:text-amber-700 transition duration-150 ease-in-out' }}">
    {{ $slot }}
</a>