<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Cadastro de Produto
        </h2>
    </x-slot>

    <livewire:create-product-form />

    @if(session()->has('status'))
        <x-toast type="{{ session()->get('status') }}">
            <span class="block">
                {{ session()->get('status_message') }}
            </span>

            @if(session()->has('link'))
                <x-link :route="session()->get('link.route')" target="_blank">
                    {{ session()->get('link.text') }}
                </x-link>
            @endif
        </x-toast>
    @endif

    @push('scripts')
        <script>
            const validateSize = (event, sizeAvailable) => {
                let available = parseFloat(sizeAvailable.replace(',', '.'))
                let requested = parseFloat(event.target.value.replace(',', '.'))
                console.log(available, requested, (available - requested > 0))

                console.log(this.isMeasurable)
            }
        </script>
    @endpush

</x-app-layout>
