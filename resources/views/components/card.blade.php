@props([
    'shadow' => 'lg', // default to shadow-lg
    'hover' => false, // default no hover effect
    'maxWidth' => 'xl', // default max-w-xl
])
@php
    $shadowClass = match ($shadow) {
        'sm' => 'shadow-sm',
        'md' => 'shadow-md',
        'lg' => 'shadow-lg',
        'xl' => 'shadow-xl',
        '2xl' => 'shadow-2xl',
        default => 'shadow-lg',
    };

    $hoverClass = $hover ? 'hover:shadow-2xl transition duration-300' : '';
    $maxWidthClass = "max-w-$maxWidth";

@endphp

<div {{ $attributes->merge(['class' => "{$maxWidthClass} mx-auto p-6 bg-white border border-gray-100 rounded-xl {$shadowClass} {$hoverClass}"]) }}>
    {{ $slot }}
</div>