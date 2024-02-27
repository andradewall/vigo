@props([
    'title',
    'route',
    'withLabel' => null,
    'withLoading' => null,
])

<div
        @if($withLoading)
            x-data="{ modalOpen: false, removeButtonDisabled: false }"
        @else
            x-data="{ modalOpen: false }"
        @endif
        @keydown.escape.window="modalOpen = false"
        :class="{ 'z-40': modalOpen }" class="relative py-2.5 text-center inline-flex items-center mr-2"
>
    <button type="button"
            @click="modalOpen = true"
            class="text-red-700 hover:text-red-500 focus:ring-4
            focus:outline-none focus:ring-red-300 font-medium text-sm text-center mx-auto
            dark:focus:ring-red-900 flex w-full"
            @if($withLoading) :disabled="removeButtonDisabled" @endif
    >
        @if($withLoading)
            <template x-if="removeButtonDisabled">
                <x-icons.loading class="text-inherit"/>
            </template>

            <template x-if="!removeButtonDisabled">
                <x-icons.delete />
            </template>
        @else
            <x-icons.delete />
        @endif

        @if($withLabel)
            <span class="ml-2">Excluir</span>
        @endif

    </button>

    <template x-teleport="body">
        <div x-show="modalOpen" class="fixed top-0 left-0 z-[99] flex items-center justify-center w-screen h-screen" x-cloak>
            <div x-show="modalOpen"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="modalOpen=false" class="absolute inset-0 w-full h-full bg-white backdrop-blur-sm bg-opacity-70"></div>
            <div x-show="modalOpen"
                 x-trap.inert.noscroll="modalOpen"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 -translate-y-2 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 -translate-y-2 sm:scale-95"
                 class="relative w-full py-6 bg-white border shadow-lg px-7 border-neutral-200 sm:max-w-lg sm:rounded-lg">
                <div class="flex items-center justify-between pb-3">
                    <h3 class="text-lg font-semibold">{{ $title }}</h3>
                    <button @click="modalOpen=false" class="absolute top-0 right-0 flex items-center justify-center w-8 h-8 mt-5 mr-5 text-gray-600 rounded-full hover:text-gray-800 hover:bg-gray-50">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
                <div class="relative w-auto pb-2">
                    {{ $slot }}
                </div>
                <div class="flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-2">
                    <form method="POST" action="{{ $route }}"
                          @if($withLoading) @submit="removeButtonDisabled = true" @endif
                    >
                        @csrf
                        @method('DELETE')
                        <x-buttons.link @click="modalOpen=false">Cancelar</x-buttons.link>
                        <x-buttons.submit @click="modalOpen=false">Confirmar</x-buttons.submit>
                    </form>
                </div>
            </div>
        </div>
    </template>
</div>