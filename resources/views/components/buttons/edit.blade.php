@props([
    'route',
])

<a
        href="{{ $route }}"
        {{ $attributes->merge([
            'class' => 'text-blue-700 hover:text-blue-500 focus:ring-4
            focus:outline-none focus:ring-blue-300 font-medium text-sm text-center mx-auto
            dark:focus:ring-blue-900px-5 py-2.5 text-center inline-flex items-center mr-2'
        ]) }}
>
    <x-icons.edit/>
    @if($slot->isNotEmpty())
        <span class="ml-2">
            {{ $slot }}
        </span>
    @endif
</a>