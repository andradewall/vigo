@props([
    'placeholder' => null,
    'items',
])


<!-- <div class="relative w-full flex" x-data="{ filterLabel: 'Filtrar', filter: '*' }"> -->
<label for="search" class="sr-only">Pesquisar</label>
<div class="relative w-full flex"
    x-data="{ filterLabel: 'Filtrar', filter: '*', placeholder: 'Pesquisar...'}"
    x-init="$watch('filterLabel', value => placeholder = (filter === '*' ? 'Pesquisar...' : 'Pesquisar por ' + filterLabel.toLowerCase() + ' ...'))"
>
    <x-ts-dropdown position="bottom-start">
        <x-slot:action>
            <!-- <x-ts-button x-on:click="show = !show" sm outline>Open</x-ts-button> -->
            <button id="dropdown-search-button"
                x-on:click="show = !show"
                class="flex-shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center
                text-gray-900 bg-gray-100 border border-gray-300 rounded-s-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100"
                type="button">
                <x-ts-icon name="chevron-down" class="h-5 w-5">
                    <x-slot:left>
                        <span x-text="filterLabel">Filtrar</span>
                    </x-slot:left>
                </x-ts-icon>
                <input type="hidden" name="filter" id="filter"/>
            </button>
        </x-slot:action>
        @foreach($items as $key => $value)
            <x-ts-dropdown.items text="{{ $value }}"
                x-on:click="filterLabel = '{{ $value }}'; filter='{{ $key }}'; show = !show" />
        @endforeach
    </x-ts-dropdown>

<!--     <button id="dropdown-search-button" -->
<!--             data-dropdown-toggle="dropdown-search" -->
<!--             class="flex-shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center -->
<!--             text-gray-900 bg-gray-100 border border-gray-300 rounded-s-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100" -->
<!--             type="button"> -->
<!--         <span x-text="filterLabel">Filtrar</span> -->
<!--         <input type="hidden" name="filter" id="filter" x-model="filter" /> -->
<!--         <x-icons.chevron-down class="ml-4 h-4 w-4" /> -->
<!--     </button> -->
<!--     <div id="dropdown-search" -->
<!--          class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-52"> -->
<!--         <ul class="py-2 text-sm text-gray-700" -->
<!--             aria-labelledby="dropdown-search-button"> -->
<!--             <li> -->
<!--                 <button type="button" -->
<!--                         class="inline-flex w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" -->
<!--                         x-on:click="filterLabel = 'Todos'; filter = '*'" -->
<!--                         role="menuitem"> -->
<!--                     <div class="inline-flex items-center"> -->
<!--                         Todos -->
<!--                     </div> -->
<!--                 </button> -->
<!--             </li> -->
<!--             @foreach($items as $key => $value) -->
<!--                 <li> -->
<!--                     <button type="button" -->
<!--                             class="inline-flex w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" -->
<!--                             x-on:click="filterLabel = '{{ $value }}'; filter = '{{ $key }}'" -->
<!--                             role="menuitem"> -->
<!--                         <div class="inline-flex items-center"> -->
<!--                             {{ $value }} -->
<!--                         </div> -->
<!--                     </button> -->
<!--             </li> -->
<!--             @endforeach -->
<!--         </ul> -->
<!--     </div> -->
    <div class="relative w-full">
        <input type="text"
               id="search"
               name="search"
               class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 border-s-0 border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
               x-bind:placeholder="placeholder">
    </div>
    <button type="submit"
            class="p-2.5 text-sm font-bold text-white bg-blue-500 hover:bg-blue-700 rounded-e-lg">
        <x-icons.search class="w-5 h-5 inline-block"/>
        <span class="sr-only">Pesquisar</span>
    </button>
</div>
