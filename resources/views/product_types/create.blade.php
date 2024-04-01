<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Cadastro de Tipo de Produto
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-8 space-y-6">
            <x-form post :action="route('types.store')" with-loading>
                <div class="flex flex-col gap-6 mb-6">
                    <div class="space-x-8">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="radio" name="base_type" value="1" class="sr-only peer" required checked>
                            <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                            <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300 flex">
                                <x-icons.quantity class="w-5 h-5 mr-2" />
                                Por unidade
                            </span>
                        </label>

                        <label class="inline-flex items-center cursor-pointer">
                            <input type="radio" name="base_type" value="2" class="sr-only peer" required>
                            <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                            <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300 flex">
                                <x-icons.meter class="w-5 h-5 mr-2" />
                                Por metro
                            </span>
                        </label>
                    </div>

                    <x-form.input type="text"
                                  name="name"
                                  id="name"
                                  label="Nome"
                                  placeholder="Escada Extensiva 30m"
                                  required
                    />

                    <x-form.input type="text"
                                  name="code_prefix"
                                  id="code_prefix"
                                  label="Prefixo do Código"
                                  hint="O código do produto será uma união entre o prefixo do código informado e um número
                                  sequencial. Por exemplo: B12-1, B12-2, B12-3, etc..."
                                  placeholder="EE30"
                                  required
                    />

                    <x-form.input type="text"
                                  name="price"
                                  id="price"
                                  label="Preço (R$)"
                                  x-mask:dynamic="$money($input, ',')"
                                  x-on:blur="$event.target.value = handleDecimals($event.target.value)"
                                  required
                    />

                    <x-form.textarea name="description"
                                     id="description"
                                     label="Descrição"
                                     placeholder="Escada extensiva de 30m, na cor laranja..."
                                     rows="4"
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
