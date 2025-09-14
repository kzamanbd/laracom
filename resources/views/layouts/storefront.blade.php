<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title> {{ $title ? $title . ' - ' : '' }} {{ config('app.name') }}</title>
        @include('storefront.partials.frontend-head')
        @livewireStyles
    </head>

    <body class="font-sans antialiased">
        @livewire('storefront.layout.navigation')
        {{ $slot }}
        @livewire('storefront.layout.footer')
        @include('storefront.partials.frontend-scripts')
        @livewire('toast-notification')
        @livewireScripts
    </body>

</html>
