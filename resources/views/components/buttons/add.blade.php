@props([
    'route',
])

<a href="{{ $route }}"
        {{ $attributes->merge([
             'class' => 'inline-flex justify-center items-center px-6 py-2 text-base text-center text-white rounded-lg
                         bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900'
        ]) }}
>
    <x-icons.add class="mr-2 h-5 w-5"/>
    {{ $slot }}
</a>