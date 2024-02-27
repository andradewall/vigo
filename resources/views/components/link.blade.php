@props([
    'route' => '#',
])
<a href="{{ $route }}" {{ $attributes->merge(["class" => "text-blue-600 hover:text-blue-900"]) }}>{{ $slot }}</a>
