<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title> {{ $title ? $title . ' - ' : '' }} {{ config('app.name') }}</title>
        @include('partials.frontend-head')
    </head>

    <body class="font-sans antialiased">
        @livewire('storefront.navigation')
        {{ $slot }}
        @livewire('storefront.footer')
        @include('partials.frontend-scripts')
    </body>

</html>
