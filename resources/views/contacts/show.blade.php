<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Detalhes de Cliente
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-8 space-y-6">
            <div class="flex flex-col gap-6 mb-6">
                <div class="">
                    <x-form.input type="text" name="name" id="name" label="Nome/Razão Social" readonly value="{{
                    $contact->name }}"/>
                </div>

                <div class="">
                    <x-form.input type="text"
                                  name="document_number"
                                  id="document_number"
                                  label="Nr do Documento"
                                  readonly
                                  value="{{ $contact->document_number }}"/>
                </div>

                <div class="">
                    <x-form.input type="text" name="address" id="address" label="Endereço" readonly value="{{
                    $contact->address }}"/>
                </div>

                <div class="">
                    <x-form.input type="tel" name="main_phone" id="main_phone" label="Telefone 1" readonly value="{{
                    $contact->main_phone }}"/>
                </div>

                <div class="">
                    <x-form.input type="tel" name="secondary_phone" id="secondary_phone" label="Telefone 2" readonly
                                  value="{{
                    $contact->secondary_phone }}"/>
                </div>

                <div class="">
                    <x-form.input type="email" name="email" id="email" label="E-mail" readonly value="{{
                    $contact->email }}"/>
                </div>
            </div>

            <x-buttons.edit route="{{ route('contacts.edit', $contact->id) }}" class="mr-8">
                Editar
            </x-buttons.edit>

            <x-buttons.remove id="delete-{{ $contact->id }}"
                              class="btn-delete mb-4"
                              title="Excluir contato"
                              :route="route('contacts.destroy', $contact)"
                              with-label
                              with-loading
            >
                <span class="block mb-2">Deseja excluir o contato {{ $contact->name }}?</span>
                <p>Para fins de histórico, os dados relacionados a este contato não serão excluídos.</p>
                <x-alerts.danger title="Atenção!" class="my-2">
                    Esta operação não pode ser desfeita!
                </x-alerts.danger>
            </x-buttons.remove>

    </div>
</x-app-layout>
