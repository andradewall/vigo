<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Página Inicial') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <h3 class="uppercase font-bold">
                Aluguéis Encerrando Hoje
            </h3>
            <span>Aluguéis que estão com <strong>data de término</strong> para hoje</span>

            @if($endingToday->isEmpty())
                <x-table.empty>
                    Nenhum aluguel encontrado<br/>
                    Não foi encontrado aluguel <strong>encerrando</strong> hoje
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
                        @foreach($endingToday as $rent)
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
                {{ $endingToday->links() }}
            @endif

            <hr class="mt-4" />

            <h3 class="uppercase font-bold">
                Aluguéis Em Aberto
            </h3>
            <span>Aluguéis em aberto estão <strong>em andamento</strong></span>

            @if($inProgressRents->isEmpty())
                <x-table.empty>
                    Nenhum aluguel encontrado.<br/>
                    Aluguéis com entrega pendente estão <strong>em andamento</strong>
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
                        @foreach($inProgressRents as $rent)
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
                {{ $inProgressRents->links() }}
            @endif

            <hr class="mt-4" />

            <h3 class="uppercase font-bold">
                Aluguéis Iniciando Hoje
            </h3>
            <span>Aluguéis que estão com <strong>data de início</strong> para hoje</span>

            @if($startingToday->isEmpty())
                <x-table.empty>
                    Nenhum aluguel encontrado<br/>
                    Não foi encontrado aluguel <strong>iniciando</strong> hoje
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
                        @foreach($startingToday as $rent)
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
                {{ $startingToday->links() }}
            @endif

        </div>
    </div>
</x-app-layout>
