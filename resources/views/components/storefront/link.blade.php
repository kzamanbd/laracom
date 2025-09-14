@props(['route', 'params' => []])

<a {{ $attributes->class(['active' => request()->routeIs($route)]) }} href="{{ route($route, $params) }}" wire:navigate>
    {{ $slot }}
</a>
