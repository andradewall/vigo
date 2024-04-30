<div class="py-12" x-data="">
    <div class="max-w-7xl mx-auto px-8 space-y-6">

        <x-ts-loading loading="selectedType" />

        <x-ts-loading loading="save">
            <div class="flex items-center text-primary-500 dark:text-white">
                <x-ts-icon name="arrow-path" class="mr-2 h-10 w-10 animate-spin" />
                Salvando...
            </div>
        </x-ts-loading>

        <form wire:submit="save">
            <div class="flex flex-col gap-8 mb-8">
                <x-ts-select.styled label="Tipo de Produto *"
                    name="selectedType"
                    wire:model.live="selectedType"
                    select="label:label|value:value"
                    :options="$list"
                    x-on:select="$wire.dispatch('type-selected')"
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

                <input type="hidden" name="isMeasurable" wire:model.live="isMeasurable" />

                @if($isMeasurable)
                    <div>
                        <x-ts-input label="Tamanho *"
                            name="size"
                            wire:model="size"
                            x-mask:dynamic="$money($input, ',')"
                            hint="Em metros" />

                        <x-ts-alert color="yellow"
                            :personalize="[
                                'wrapper' => [
                                    'append' => 'mt-2',
                                ],
                            ]" outline>
                            <span>
                                Atualmente disponível: {{ $sizeAvailable }}m
                            </span>
                        </x-ts-alert>
                    </div>
                @else
                    <x-ts-input label="Quantidade *"
                        wire:model="quantity"
                        name="quantity"
                        type="number"
                        placeholder="3" />
                @endif

                <div class="flex flex-col gap-8 mb-8">
                    <x-ts-input label="Preço (R$) *"
                        name="price"
                        wire:model="price"
                        x-mask:dynamic="$money($input, ',')"
                        placeholder="9,99"
                        required />
                </div>

            </div>
            <x-ts-button color="green" type="submit">
                Salvar
            </x-ts-button>
        </form>
    </div>
</div>
