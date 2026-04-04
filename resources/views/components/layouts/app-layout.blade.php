<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <x-head title="Nisagam" />

    <body class="bg-gray-100 min-h-screen w-full">
        {{ $slot }}
    </body>
</html>
