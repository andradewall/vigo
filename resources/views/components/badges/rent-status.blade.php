@props([
    'status'
])

@foreach(\App\Enums\RentStatus::cases() as $rentStatusCase)
    @if($rentStatusCase === $status)
        @php($color = \App\Enums\RentStatus::getColor($rentStatusCase))
    @endif
@endforeach

<div {{ $attributes->merge(['class' => '']) }}>
@if($color === 'green')
    <x-badges.green>{{ $slot }}</x-badges.green>
@elseif($color === 'yellow')
    <x-badges.yellow>{{ $slot }}</x-badges.yellow>
@elseif($color === 'red')
    <x-badges.red>{{ $slot }}</x-badges.red>
@endif
</div>
