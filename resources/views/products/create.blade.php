<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Cadastro de Produto
        </h2>
    </x-slot>

    <div class="py-12" x-data="{isMeasurable: false, maxSize: 0}">
        <div class="max-w-7xl mx-auto px-8 space-y-6">
            <x-form post :action="route('products.store')" with-loading>
                <div class="flex flex-col gap-6 mb-6">

                    <x-ts-select.styled label="Tipo de Produto *"
                        name="product_type_id"
                        select="label:text|value:value"
                        :options="$productTypes->map(function ($type) {
                            return [
                                'value' =>  $type->id,
                                'text' => $type->name . ' (R$ ' . $type->price . '/' . ($type->base_type->isMeasurable() ? 'm' : 'un') . ')',
                                'description' => $type->base_type->isMeasurable()
                                    ? 'Produto por metro | Tamanho máximo (m): ' . formatMoney($type->max_size)
                                    : 'Produto por unidade | Existentes: x',
                            ];
                        })"
                        x-on:select="splitted = $event.detail.select.description.split(' '); isMeasurable = splitted[2] === 'metro'; maxSize = splitted[splitted.length - 1]"
                        searchable
                        required>
                        <x-slot:after>
                            <div class="px-2 mb-2 flex justify-center items-center">
                                <x-ts-button color="green"
                                    x-on:click="show = false; $dispatch('confirmed', { term: search })">
                                    <span x-html="`Criar produto <b>${search}</b>`"></span>
                                </x-ts-button>
                            </div>
                        </x-slot:after>
                    </x-ts-select.styled>

                    <div x-show="isMeasurable">
                        <x-ts-input label="Tamanho *"
                            name="size"
                            x-on:input="formatCurrency"
                            hint="Em metros" />
                        <x-ts-alert color="yellow" light>
                            <div class="text-sm">
                                <span x-text="'Atualmente disponível: ' + maxSize + 'm'"></span>
                            </div>
                        </x-ts-alert>
                    </div>

                    <div x-show="!isMeasurable">
                        <x-ts-input label="Quantidade *"
                            name="quantity"
                            type="number"
                            placeholder="3" />
                    </div>

                    <x-ts-input label="Preço (R$) *"
                        name="price"
                        x-on:input="formatCurrency"
                        placeholder="9,99"
                        required />
                </div>

                <x-ts-button color="green" type="submit">
                    Salvar
                </x-ts-button>
            </x-form>
        </div>
    </div>

    @push('scripts')
        <script>
            const formatCurrency = (event) => {
                let input = event.target;
                let value = input.value.replace(/\D/g, ''); // Remove não dígitos
                value = (value / 100).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                input.value = value;
            }
        </script>
    @endpush
</x-app-layout>
