@props([
    'id',
    'color',
    'has-input' => null,
    'list' => null,
    'value' => null,
])

@php
    $colorClasses = match ($color) {
        'green' => 'text-green-800 bg-green-100',
        'blue' => 'text-blue-800 bg-blue-100',
    }
@endphp

<span id="{{ $id }}"
      class="inline-flex items-center px-2 py-1 mr-2 text-sm font-medium rounded {{ $colorClasses }}">
    {{ $slot }}
    <button type="button"
            class="btn-badge-remove inline-flex items-center p-1 ml-2 text-sm {{ $colorClasses }} bg-transparent
            rounded-sm"
            data-dismiss-target="#{{ $id }}"
            aria-label="Remover">
        <svg class="w-2 h-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
        </svg>
        <span class="sr-only">Remover item</span>
    </button>
    @if(isset($hasInput))
        <input type="hidden" name="{{ $list }}" value="{{ $value }}">
    @endif
</span>