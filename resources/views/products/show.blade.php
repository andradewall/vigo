<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Detalhes do Produto
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid gap-4 grid-cols-3">
                <div class="">
                    <span class="font-bold block">
                        Código:
                    </span>
                    <span class="block">
                        {{ \App\Actions\GetProductCode::run($product) }}
                    </span>
                </div>

                <div class="">
                    <span class="font-bold block">
                        Nome:
                    </span>
                    <span class="block">
                        <x-link :route="route('types.show', $product->type->id)">
                            {{ $product->type->name }}
                        </x-link>
                    </span>
                </div>

                <div class="">
                    <span class="font-bold block">
                        Preço:
                    </span>
                    <span class="block">
                        R$ {{ formatMoney($product->price)}}
                    </span>
                </div>

                <div class="col-span-3">
                    <span class="font-bold block">
                        Descrição:
                    </span>
                    <span class="block">
                        {{ $product->type->description ?: '-' }}
                    </span>
                </div>

                <div class="">
                    <span class="font-bold block">
                        Está alugado?
                    </span>
                    <span class="block">
                        {{ $product->is_rented ? 'Sim' : 'Não' }}
                    </span>
                </div>

                @if($product->is_rented)
                    <div class="">
                        <span class="font-bold block">
                            Aluguel atual:
                        </span>
                        <x-link :route="route('rents.show', $product->rents->last()->id)">
                            {{ formatDateTime($product->rents->last()->starting_date) }}
                        </x-link>
                    </div>
                @endif
            </div>

            <span class="font-bold block">
                Histórico de aluguéis:
            </span>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            #
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Valor (R$)
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Data de Início
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Data de Término
                        </th>

                        <th scope="col" class="px-6 py-3">
                            Pago Em
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Locatário
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($rents->isEmpty())
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td colspan="6" class="px-6 py-3">
                                Nenhum aluguel encontrado
                            </td>
                        </tr>
                    @else
                        @foreach($rents as $rent)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-6 py-3">{{ $loop->iteration }}</td>
                                <td class="px-6 py-3">
                                    <x-link :route="route('rents.show', $rent)">
                                        R$ {{ formatMoney($rent->value) }}
                                    </x-link>
                                </td>
                                <td class="px-6 py-3">{{ formatDateTime($rent->starting_date) }}</td>
                                <td class="px-6 py-3">{{ formatDateTime($rent->ending_date) }}</td>
                                <td class="px-6 py-3">{{ formatDateTime($rent->created_at) }}</td>
                                <td class="px-6 py-3">{{ $rent->contact_name }}</td>

                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>

                {{ $rents->links() }}
            </div>

            <x-buttons.edit route="{{ route('products.edit', $product) }}" class="mr-8">
                Editar
            </x-buttons.edit>

            <x-buttons.remove id="delete-{{ $product->id }}"
                              class="btn-delete mb-4"
                              title="Excluir contato"
                              :route="route('products.destroy', $product)"
                              with-label
                              with-loading
            >
                <span class="block mb-2">Deseja excluir o produto de código {{ \App\Actions\GetProductCode::run
                ($product) }}?</span>
                <p class="font-bold">Os dados associados a este produto (por
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
</x-app-layout>
