<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <x-head title="{{ request()->is('login') ? 'Nisagam | Login' : 'Nisagam | Dashboard' }}" />

    <body class="bg-gray-100 min-h-screen w-full">
        {{ $slot }}
    </body>
</html>