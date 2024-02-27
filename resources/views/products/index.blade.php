<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <a href="{{ route('products.index') }}">
                Produtos
            </a>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="flex justify-between mb-6">
                <x-form get action="{{ route('products.index') }}" class="flex items-center w-full mr-8">
                    <x-form.search placeholder="Pesquise por qualquer coisa..."
                                   :items="[
                                'code_prefix' => 'Prefixo Código',
                                'code' => 'Código',
                                'name' => 'Nome',
                                'price' => 'Preço',
                                'is_rented:true' => 'Alugado',
                                'is_rented:false' => 'Livre',
]                           "/>
                </x-form>

                <x-buttons.add :route="route('products.create')">Cadastrar</x-buttons.add>
            </div>

            @if($products->isEmpty())
                <x-table.empty>
                    Nenhum produto encontrado.<br/>
                    Revise sua busca ou comece a <x-link route="{{ route('products.create') }}">cadastrar</x-link>
                </x-table.empty>
            @else
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                #
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Código
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Preço
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Nome
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Descrição
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Situação
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $product)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-6 py-3">{{ $loop->iteration }}</td>
                                <td class="px-6 py-3 flex">
                                    <x-link :route="route('products.show', $product)">
                                        {{ \App\Actions\GetProductCode::run($product) }}
                                    </x-link>
                                </td>
                                <td class="px-6 py-3">R$ {{ formatMoney($product->price) }}</td>
                                <td class="px-6 py-3">{{ $product->type->name }}</td>
                                <td class="px-6 py-3">{{ $product->type->description }}</td>
                                <td class="px-6 py-3">
                                    @if($product->is_rented)
                                        <x-badges.red>Alugado</x-badges.red>
                                    @else
                                        <x-badges.green>Livre</x-badges.green>
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
                {{ $products->appends($params)->links() }}
            @endif
        </div>
    </div>

    @if(session()->has('status'))
        <x-toast type="{{ session()->get('status') }}">
            {{ session()->get('message') }}
        </x-toast>
    @endif
</x-app-layout>
