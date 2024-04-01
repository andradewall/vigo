<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Detalhes do Tipo de Produto
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-8 space-y-6">
            <div class="flex flex-col gap-6 mb-6" x-data="{base_type: {{ $productType->base_type }}}">
                <span class="px-6 py-2 rounded-full bg-blue-200 text-blue-800 uppercase w-fit">
                    @php
                        $baseTypeName = $productType->base_type->baseName();
                        $baseTypeComponent = "icons." . $productType->base_type->componentName();
                    @endphp
                    Produto por {{ $baseTypeName }}
                    <x-dynamic-component :component="$baseTypeComponent" class="w-5 h-5 inline-block" />
                </span>

                <x-form.input type="text"
                              name="name"
                              id="name"
                              label="Nome"
                              value="{{ $productType->name }}"
                              readonly
                />

                <x-form.input type="text"
                              name="code_prefix"
                              id="code_prefix"
                              label="Prefixo do Código"
                              value="{{ $productType->code_prefix }}"
                              readonly
                />

                <x-form.input type="text"
                              name="price"
                              id="price"
                              label="Preço (R$)"
                              value="{{ formatMoney($productType->price) }}"
                              readonly
                />

                <x-form.textarea name="description"
                              id="description"
                              label="Descrição"
                              value="{{ $productType->description }}"
                              readonly
                />
            </div>

            <x-buttons.edit route="{{ route('types.edit', $productType) }}" class="mr-8">
                Editar
            </x-buttons.edit>

            <x-buttons.remove id="delete-{{ $productType->id }}"
                              class="btn-delete mb-4"
                              title="Excluir contato"
                              :route="route('types.destroy', $productType)"
                              with-label
                              with-loading
            >
                <span class="block mb-2">Deseja excluir o tipo de produto {{ $productType->name }}?</span>
                <p class="font-bold">Os dados associados a este tipo de produto (por
                    exemplo, histórico de aluguéis) também serão excluídos!</p>
                <x-alerts.danger title="Atenção!" class="my-2">
                    Esta operação não pode ser desfeita!
                </x-alerts.danger>
            </x-buttons.remove>
        </div>
    </div>

    @if(session()->has('status'))
        <x-toast type="{{ session()->get('status') }}">
            {{ session()->get('message') }}
        </x-toast>
    @endif

    @push('scripts')
        <script>
            const handleDecimals = (value) => {
                console.log(value);
                if (!value) return value;

                const valueHasComma = value.includes(',');

                if (! valueHasComma) {
                    return value + ',00';
                }

                const valueSplitted = value.split(',');
                const valueBeforeComma = valueSplitted[0];
                const valueAfterComma = valueSplitted[1];

                if (! valueBeforeComma) return '0,' + valueAfterComma;

                if (valueAfterComma.length === 1) return valueBeforeComma + ',' + valueAfterComma + '0';

                if (valueAfterComma.length === 2) return valueBeforeComma + ',' + valueAfterComma;
            }
        </script>
    @endpush
</x-app-layout>
