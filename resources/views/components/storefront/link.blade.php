@props(['route'])

<a {{ $attributes->class(['active' => request()->routeIs($route)]) }} href="{{ route($route) }}">
    {{ $slot }}
</a>
