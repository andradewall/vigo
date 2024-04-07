@props([
    'route',
])

<a href="{{ $route }}"
        {{ $attributes->merge([
             'class' => 'inline-flex justify-center items-center px-6 py-2 text-base text-center text-white rounded-lg
                         bg-green-500 hover:bg-green-600 focus:ring-4 focus:ring-green-300 dark:focus:ring-green-900'
        ]) }}
>
    <x-icons.add class="mr-2 h-5 w-5"/>
    {{ $slot }}
</a>
