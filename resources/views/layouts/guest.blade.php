<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="tw--radial-gradient">
            <div class="flex min-h-screen items-center justify-center overflow-hidden p-6">
                <div class="auth-card">
                    <div class="auth-box-1"></div>
                    <div class="auth-box-2"></div>
                    <div class="card-body">
                        <div class="my-4 flex items-center justify-center space-x-2">
                            <x-application-logo class="size-9 fill-current text-black dark:text-white" />
                            <p class="text-3xl font-semibold">{{ config('app.name', 'Laravel') }}</p>
                        </div>
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>

</html>
