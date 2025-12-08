@props(['active' => false])

<a {{ $attributes }} class="flex items-center p-3 rounded-lg text-gray-700 cursor-pointer gap-4 {{ $active
    ? 'font-semibold transition duration-150 ease-in-out border-l-4 border-amber-500 bg-amber-50 hover:bg-amber-100'
    : 'text-gray-600 hover:text-amber-700 transition duration-150 ease-in-out' }}">
    {{ $slot }}
</a>