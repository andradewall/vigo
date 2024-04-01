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

            <div class="flex justify-between mb-6">
                <x-form get action="{{ route('types.index') }}" class="flex items-center w-full mr-8">
                    <x-form.search placeholder="Pesquise por qualquer coisa..."
                                   :items="[
                        'code_prefix' => 'Código',
                        'price' => 'Preço',
                        'name' => 'Nome',
                        'description' => 'Descrição',
                    ]"/>
                </x-form>

                <x-buttons.add :route="route('types.create')">Cadastrar</x-buttons.add>
            </div>

            @if($productTypes->isEmpty())
                <x-table.empty>
                    Nenhum tipo de produto encontrado.<br/>
                    Revise sua busca ou comece a <x-link route="{{ route('types.create') }}">cadastrar</x-link>
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
                                Prefixo do Código
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
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($productTypes as $type)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-6 py-3">{{ $loop->iteration }}</td>
                                <td class="px-6 py-3">
                                    <a href="{{ route('types.show', $type) }}" class="text-blue-600
                                    hover:text-blue-900">{{ $type->code_prefix }}</a>
                                </td>
                            <td class="px-6 py-3 flex">
                                @php($baseTypeComponent = "icons." . $type->base_type->componentName())
                                R$ {{ formatMoney($type->price) }} / <x-dynamic-component :component="$baseTypeComponent" class="ml-2 w-5 h-5" />
                            </td>
                                <td class="px-6 py-3">{{ $type->name }}</td>
                                <td class="px-6 py-3">{{ $type->description }}</td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>

                {{ $productTypes->appends($params)->links() }}
            @endif
        </div>
    </div>

    @if(session()->has('status'))
        <x-toast type="{{ session()->get('status') }}">
            {{ session()->get('message') }}
        </x-toast>
    @endif
</x-app-layout>
