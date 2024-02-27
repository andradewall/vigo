<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <a href="{{ route('contacts.index') }}">
                Clientes
            </a>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="flex justify-between">
                <x-form get action="{{ route('contacts.index') }}" class="flex items-center w-full mr-8">
                    <x-form.search placeholder="Pesquise por qualquer coisa..."
                        :items="[
                            'name' => 'Nome',
                            'document_number' => 'Nr Documento',
                            'phones' => 'Telefones',
                            'email' => 'E-mail',
                            'address' => 'Endereço',
                       ]"/>
                </x-form>

                <x-buttons.add :route="route('contacts.create')">Cadastrar</x-buttons.add>
            </div>
            <span class="text-sm text-gray-500 mb-6">Utilize apenas números ao filtrar por número do documento</span>

            @if($contacts->isEmpty())
                <x-table.empty>
                    Nenhum cliente encontrado.<br/>
                    Revise sua busca ou comece a <x-link route="{{ route('contacts.create') }}">cadastrar</x-link>
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
                                Nome
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Nr do Documento
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Telefones
                            </th>
                            <th scope="col" class="px-6 py-3">
                                E-mail
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Endereço
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($contacts as $contact)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-6 py-3">{{ $loop->iteration }}</td>
                                <td class="px-6 py-3">
                                    <x-link :route="route('contacts.show', $contact->id)">
                                        {{ $contact->name }}
                                    </x-link>
                                </td>
                                <td class="px-6 py-3">
                                    {{ $contact->document_number }}
                                </td>
                                <td class="px-6 py-3">
                                    {{ $contact->main_phone }}
                                    @if($contact->secondary_phone) / {{ $contact->secondary_phone }} @endif
                                </td>
                                <td class="px-6 py-3">{{ $contact->email }}</td>
                                <td class="px-6 py-3">{{ $contact->address }}</td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
                {{ $contacts->appends($params)->links() }}
            @endif
        </div>
    </div>
</x-app-layout>
