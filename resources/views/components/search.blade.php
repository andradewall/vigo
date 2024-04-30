@props([
    'action',
    'items',
])

<div class="flex justify-between mb-6">
    <x-form get action="{{ $action }}" class="flex items-center w-full mr-8">
        <x-form.search placeholder="Pesquise por qualquer coisa..."
            :items="$items" />
    </x-form>

    {{ $slot }}
</div>
