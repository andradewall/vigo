@props(['route', 'title', 'buttonName'])

<div x-data="{ modalOpen: false }"
     @keydown.escape.window="modalOpen = false"
     :class="{ 'z-40': modalOpen }" class="relative w-auto h-auto">

    <button @click="modalOpen=true" class="text-red-600 hover:text-red-900 ml-2">{{ $buttonName }}</button>

    <template x-teleport="body">
        <div x-show="modalOpen"
             class="fixed top-0 left-0 z-[99] flex items-center justify-center w-screen h-screen"
             x-cloak>
            <div x-show="modalOpen"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="modalOpen=false"
                 class="absolute inset-0 w-full h-full bg-white backdrop-blur-sm bg-opacity-70"></div>
            <div x-show="modalOpen"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 -translate-y-2 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 -translate-y-2 sm:scale-95"
                 class="relative w-full py-6 bg-white border shadow-lg px-7 border-neutral-200 sm:max-w-lg sm:rounded-lg">

                <div class="flex items-center justify-between pb-3">
                    <h3 class="text-lg font-semibold">{{ $title }}</h3>
                    <button @click="modalOpen=false"
                            class="absolute top-0 right-0 flex items-center justify-center w-8 h-8 mt-5 mr-5 text-gray-600">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <div class="relative w-auto pb-8">
                    {{ $slot }}
                </div>

                <div class="flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-2">
                    <button @click="modalOpen=false" type="button" class="text-sm px-5 py-2.5 mr-2
                    mb-2">Cancelar</button>
                    <form action="{{ $route }}" method="POST">
                        @csrf

                        <button @click="modalOpen=false"
                            type="submit"
                            class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
                        >Confirmar</button>
                    </form>
                </div>
            </div>
        </div>
    </template>
</div>
