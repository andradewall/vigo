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

            <x-search :action="route('products.index')"
                :items="[
                    'code_prefix' => 'Prefixo Código',
                    'code' => 'Código',
                    'name' => 'Nome',
                    'price' => 'Preço',
                    'is_rented:true' => 'Alugado',
                    'is_rented:false' => 'Livre',
                ]">

                <x-buttons.add :route="route('products.create')">Cadastrar</x-buttons.add>
            </x-search>

            @if($products->isNotEmpty())
                <x-table>
                    <x-table.head>
                        <x-table.th> # </x-table.th>
                        <x-table.th> Código </x-table.th>
                        <x-table.th> Preço </x-table.th>
                        <x-table.th> Nome </x-table.th>
                        <x-table.th> Descrição </x-table.th>
                        <x-table.th> Situação </x-table.th>
                    </x-table.head>
                    <tbody>
                        @foreach($products as $product)
                            <x-table.tr>
                                <x-table.td>{{ $loop->iteration }}</x-table.td>
                                <x-table.td>
                                    <x-link :route="route('products.show', $product)">
                                        {{ \App\Actions\GetProductCode::run($product) }}
                                    </x-link>
                                </x-table.td>
                                <x-table.td>R$ {{ formatMoney($product->price) }}</x-table>
                                <x-table.td>{{ $product->type->name }}</x-table>
                                <x-table.td>{{ $product->type->description }}</x-table>
                                <x-table.td>
                                    @if($product->is_rented)
                                        <x-badges.red>Alugado</x-badges.red>
                                    @else
                                        <x-badges.green>Livre</x-badges.green>
                                    @endif
                                </x-table.td>
                            </x-table.tr>
                        @endforeach
                    </tbody>
                </x-table>
            @else
                <x-table.empty>
                    Nenhum tipo de produto encontrado.<br/>
                    Revise sua busca ou comece a <x-link route="{{ route('products.create') }}">cadastrar</x-link>
                </x-table.empty>
            @endif

            {{ $products->appends($params)->links() }}
        </div>
    </div>

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
</x-app-layout>
