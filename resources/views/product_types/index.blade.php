<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <a href="{{ route('types.index') }}">
                Tipos de Produto
            </a>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <x-search :action="route('types.index')"
                :items="[
                    'code_prefix' => 'Código',
                    'price' => 'Preço',
                    'name' => 'Nome',
                    'description' => 'Descrição',
                ]">

                <x-buttons.add :route="route('types.create')">Cadastrar</x-buttons.add>
            </x-search>

            @if($productTypes->isNotEmpty())
                <x-table>
                    <x-table.head>
                        <x-table.th> # </x-table.th>
                        <x-table.th> Prefixo do Código </x-table.th>
                        <x-table.th> Preço </x-table.th>
                        <x-table.th> Nome </x-table.th>
                        <x-table.th> Descrição </x-table.th>
                    </x-table.head>
                    <tbody>
                        @foreach($productTypes as $type)
                            <x-table.tr>
                                <x-table.td>{{ $loop->iteration }}</x-table.td>
                                <x-table.td>
                                    <a href="{{ route('types.show', $type) }}" class="text-blue-600
                                    hover:text-blue-900">{{ $type->code_prefix }}</a>
                                </x-table.td>
                                <x-table.td class="flex">
                                    @php($baseTypeComponent = "icons." . $type->base_type->componentName())
                                    R$ {{ formatMoney($type->price) }} / <x-dynamic-component :component="$baseTypeComponent" class="ml-2 w-5 h-5" title="Teste" />
                                </x-table.td>
                                <x-table.td>{{ $type->name }}</x-table.td>
                                <x-table.td>{{ $type->description }}</x-table.td>
                            </x-table.tr>
                        @endforeach
                    </tbody>
                </x-table>
            @else
                <x-table.empty>
                    Nenhum tipo de produto encontrado.<br/>
                    Revise sua busca ou comece a <x-link route="{{ route('types.create') }}">cadastrar</x-link>
                </x-table.empty>
            @endif

            {{ $productTypes->appends($params)->links() }}
        </div>
    </div>

    @if(session()->has('status'))
        <x-toast type="{{ session()->get('status') }}">
            {{ session()->get('status_message') }}
        </x-toast>
    @endif
</x-app-layout>
