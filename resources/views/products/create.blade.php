<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Cadastro de Produto
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-8 space-y-6">
            <x-form post :action="route('products.store')" with-loading>
                <div class="flex flex-col gap-6 mb-6">

                    <div class="w-full relative pb-8 mb-8">
                        <label for="product_type" class="block mb-2 text-sm font-medium text-gray-900">
                            Tipo de Produto <span class="text-red-600">*</span>
                        </label>
                        <x-form.select-searchable
                                name="product_type"
                                id="product_type"
                                placeholder="Pesquise um tipo de produto..."
                                options-class="select-searchable-contact-item"
                                :list="$productTypes->map(function ($type) {
                                            return [
                                                'value' => $type->id,
                                                'label' => $type->name . ' (R$ ' . formatMoney
                                                ($type->price) . ')',
                                            ];
                                        })"
                        />
                    </div>

                    <div class="mt-2">
                        <x-form.input type="number"
                                      name="quantity"
                                      id="quantity"
                                      label="Quantidade"
                                      placeholder="3"
                                      required
                        />
                    </div>

                    <x-form.input type="text"
                                  name="price"
                                  id="price"
                                  label="Preço (R$)"
                                  x-mask:dynamic="$money($input, ',')"
                                  x-on:blur="$event.target.value = handleDecimals($event.target.value)"
                                  required
                    />
                </div>

                <button type="submit" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4
                focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-green-600
                dark:hover:bg-green-700 dark:focus:ring-green-800">Salvar</button>

            </x-form>
        </div>
    </div>

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
