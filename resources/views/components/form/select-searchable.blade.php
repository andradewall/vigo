@php
    if (isset($json)) {
        $array = json_decode($json, true);
    }

    if (isset($list)) {
        $array = $list;
    }

    $collection = collect($array);
    $list = $collection->map(function ($item) {
        return [
            'id' => $item['value'],
            'value' => $item['label'],
        ];
    })->toJson();
@endphp

<div x-data="{
        search: '',
        hiddenInput: '',
        open: false,
        items: {{ $list }},
        get filteredItems() {
            return this.items.filter(
                i => i.value.toLowerCase().includes(this.search.toLowerCase())
            )
        },
    }"
     class="w-full flex flex-col items-center justify-center absolute overflow-hidden"
>
    <input x-on:click="open = !open"
           type="search"
           x-model="search"
           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
                dark:focus:ring-primary-500 dark:focus:border-primary-500 dark:text-gray-200"
           placeholder="{{ $placeholder }}"
           id="{{ $id . '-search' }}"
           autocomplete="off"
           aria-autocomplete="none"
    >
    <svg role="presentation" class="i-search" viewBox="0 0 32 32" width="14" height="14" fill="none"
         stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3">
        <circle cx="14" cy="14" r="12"/>
        <path d="M23 23 L30 30"/>
    </svg>
    <input type="hidden" name="{{ $name }}" id="{{ $id }}" x-model="hiddenInput">

    <ul x-show="open"
        x-cloak
        x-on:click.outside="open = !open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate"
        x-transition:enter-end="opacity-100 translate"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 translate"
        x-transition:leave-end="opacity-0 translate"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                mt-2 cursor-pointer h-80 overflow-y-auto"
    >
        <template x-for="item in filteredItems" :key="item.id">
            <li x-text="item.value"
                x-on:click="open = false; search = item.value; hiddenInput = item.id"
                class="p-2 hover:bg-gray-300 {{ $optionsClass }}"
                :data-value="item.id"
            ></li>
        </template>
    </ul>
</div>