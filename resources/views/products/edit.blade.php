<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Editar Produto
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-8 space-y-6">
            <x-form put :action="route('products.update', $product)" with-loading>
                <div class="flex flex-col gap-6 mb-6">

                    <x-form.input type="text"
                                  name="product_type"
                                  id="product_type"
                                  label="Tipo de Produto"
                                  value="{{ $product->type->name }}"
                                  readonly
                    />

                    <x-form.input type="text"
                                  name="code"
                                  id="code"
                                  label="Código"
                                  value="{{ \App\Actions\GetProductCode::run($product) }}"
                                  readonly
                    />

                    <x-form.textarea name="description"
                                     id="description"
                                     label="Descrição"
                                     value="{{ $product->type->description }}"
                                     readonly
                    />

                    <x-form.input type="text"
                                  name="price"
                                  id="price"
                                  label="Preço (R$)"
                                  :value="formatMoney($product->price)"
                                  x-mask:dynamic="$money($input, ',')"
                                  x-on:blur="$event.target.value = handleDecimals($event.target.value)"
                                  required
                    />
                </div>

                <x-buttons.submit with-loading>Salvar</x-buttons.submit>

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
