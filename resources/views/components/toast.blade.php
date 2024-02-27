@props([
    'type',
])

@php
    $colorClasses = match ($type) {
        'success' => 'bg-green-100 text-green-500 dark:bg-green-800 dark:text-green-200',
        'error' => 'bg-red-100 text-red-500 dark:bg-red-800 dark:text-red-200',
        'warning' => 'bg-yellow-100 text-yellow-500 dark:bg-yellow-800 dark:text-yellow-200',
        'info' => 'bg-blue-100 text-blue-500 dark:bg-blue-800 dark:text-blue-200',
    };
@endphp

<div id="toast-{{ $type }}"
     {{ $attributes->merge(['class' => "fixed flex items-center w-full max-w-xs p-4 mb-4 rounded-lg
            shadow-2xl top-5 right-5 $colorClasses"]) }}
     role="alert">
    <div {{ $attributes->merge(['class' => "inline-flex items-center justify-center flex-shrink-0 w-8 h-8
            text-green-500 bg-green-100 rounded-lg $colorClasses"]) }}
    >

        @if($type === 'success')
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
            </svg>
            <span class="sr-only">Ícone de sucesso</span>
        @elseif($type === 'error')
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/>
            </svg>
            <span class="sr-only">Ícone de erro</span>
        @else
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z"/>
            </svg>
            <span class="sr-only">Ícone de alerta</span>
        @endif

    </div>
    <div class="ml-3 text-sm font-normal">{{ $slot }}</div>
    <button type="button"
            {{ $attributes->merge(['class' =>"ml-auto -mx-1.5 -my-1.5 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5
            inline-flex items-center justify-center h-8 w-8 $colorClasses"]) }}
            data-dismiss-target="#toast-{{ $type }}"
            aria-label="Remover">
        <span class="sr-only">Remover</span>
        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
        </svg>
    </button>
</div>