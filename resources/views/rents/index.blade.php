<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Histórico de Aluguéis
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="flex justify-between">
                <x-form get action="{{ route('rents.index') }}" class="flex items-center w-full mr-8">
                    <x-form.search placeholder="Pesquise por qualquer coisa..."
                                   :items="[
                                'value' => 'Valor (R$)',
                                'name' => 'Nome',
                                'status:pending_payment' => 'Pagamento Pendente',
                                'status:paid' => 'Pago',
                                'status:in_progress' => 'Em Andamento',
                                'status:closed' => 'Fechado',
                                'starting_date' => 'Data de Início',
                                'ending_date' => 'Data de Término',
]                           "/>
                </x-form>

                <x-buttons.add :route="route('rents.create')">Alugar</x-buttons.add>
            </div>

            @if($rents->isEmpty())
                <x-table.empty>
                    Nenhum aluguel encontrado.<br/>
                    Revise sua busca ou comece a <x-link route="{{ route('rents.create') }}">alugar</x-link>
                </x-table.empty>
            @else
                <span class="text-sm text-gray-500 mb-6">Utilize o seguinte formato para pesquisar por datas:
                    00/00/0000</span>

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
                                Locatário
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Qtde. Produtos
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Início | Término
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($rents as $rent)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-6 py-3">{{ $rent->id }}</td>
                                <td class="px-6 py-3">
                                    <x-link :route="route('rents.show', $rent->id)">
                                        R$ {{ formatMoney($rent->value) }}
                                    </x-link>
                                </td>
                                <td class="px-6 py-3">
                                    <x-link :route="route('contacts.index', ['search' => $rent->contact_name])">
                                        {{ $rent->contact_name }}
                                    </x-link>
                                </td>
                                <td class="px-6 py-3">{{ $rent->products->count() }}</td>
                                <td class="px-6 py-3">
                                    <x-badges.rent-status :status="$rent->status">
                                        {{ $rent->status->value }}
                                    </x-badges.rent-status>
                                </td>
                                <td class="px-6 py-3">
                                    <span class="text-green-500">{{ formatDateTime($rent->starting_date) }}</span> |
                                    <span class="text-red-500">{{ formatDateTime($rent->ending_date) }}</span>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
                {{ $rents->appends($params)->links() }}
            @endif
        </div>
    </div>

    @if(session()->has('status'))
        <x-toast type="{{ session()->get('status') }}">
            <span class="block">
                {{ session()->get('message') }}
            </span>

            @if(session()->has('link'))
                <x-link :route="session()->get('link.route')" target="_blank">
                    {{ session()->get('link.text') }}
                </x-link>
            @endif
        </x-toast>
    @endif
</x-app-layout>
