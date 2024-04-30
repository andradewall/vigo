<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edição de Tipo de Produto
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-8 space-y-6">
            <x-form put :action="route('types.update', $productType)" with-loading>
                <div class="flex flex-col gap-6 mb-6" x-data="{ isMeasurable: @js(\App\Enums\BaseTypeEnum::MEASURABLE->value == old('base_type'))}">
                    <div class="space-x-8">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="radio"
                                name="base_type"
                                value="{{ \App\Enums\BaseTypeEnum::COUNTABLE->value }}"
                                class="sr-only peer"
                                required
                                @click="isMeasurable = false"
                                @checked(\App\Enums\BaseTypeEnum::COUNTABLE->value == old('base_type') || $productType->base_type === \App\Enums\BaseTypeEnum::COUNTABLE)>
                            <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                            <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300 flex">
                                <x-icons.quantity class="w-5 h-5 mr-2" />
                                Por unidade
                            </span>
                        </label>

                        <label class="inline-flex items-center cursor-pointer">
                            <input type="radio"
                                name="base_type"
                                value="{{ \App\Enums\BaseTypeEnum::MEASURABLE->value }}"
                                class="sr-only peer"
                                required
                                @click="isMeasurable = true"
                                @checked(\App\Enums\BaseTypeEnum::MEASURABLE->value == old('base_type') || $productType->base_type === \App\Enums\BaseTypeEnum::MEASURABLE)>
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
                                  :value="$productType->name"
                                  required
                    />

                    <x-form.input type="text"
                                  name="code_prefix"
                                  id="code_prefix"
                                  label="Prefixo do Código"
                                  hint="O código do produto será uma união entre o prefixo do código informado e um número
                                  sequencial. Por exemplo: B12-1, B12-2, B12-3, etc..."
                                  :value="$productType->code_prefix"
                                  required
                    />

                    <x-form.input type="text"
                        name="price"
                        id="price"
                        label="Preço (R$)"
                        :value="formatMoney($productType->price)"
                        x-on:input="formatCurrency"
                        required
                    />

                    <div class="hidden" :class="{ 'hidden': ! isMeasurable }">
                        <x-form.input type="text"
                            name="max_size"
                            id="max_size"
                            label="Tamanho Máximo (m)"
                            :value="$productType->max_size !== null ? formatMoney($productType->max_size) : ''"
                            x-on:input="formatCurrency"
                        />
                    </div>

                    <x-form.textarea name="description"
                                     id="description"
                                     label="Descrição"
                                     :value="$productType->description"
                                     rows="4"
                    />
                </div>

                <x-buttons.submit with-loading>Salvar</x-buttons.submit>

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
