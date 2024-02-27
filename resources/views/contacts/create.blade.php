<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Cadastro Cliente
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-8 space-y-6">
            <form action="{{ route('contacts.store') }}" method="POST">
                @csrf
                <div class="flex flex-col gap-6 mb-6">
                    <div class="">
                        <x-form.input type="text"
                                      name="name"
                                      id="name"
                                      label="Nome/Razão Social"
                                      placeholder="Ex.: João da Silva"
                                      required
                        />
                    </div>

                    <div class="">
                        <x-form.input type="text"
                                      name="document_number"
                                      id="document_number"
                                      label="Nr do Documento"
                                      placeholder="Ex.: CPF ou CNPJ"
                                      required
                        />
                    </div>

                    <div class="">
                        <x-form.input type="text"
                                      name="address"
                                      id="address"
                                      label="Endereço"
                                        placeholder="Ex.: Rua das Flores, 123"
                                      required
                        />
                    </div>

                    <div class="">
                        <x-form.input type="tel"
                                      name="main_phone"
                                      id="main_phone"
                                      label="Telefone 1"
                                      placeholder="Ex.: (11) 99999-9999"
                                      required
                        />
                    </div>

                    <div class="">
                        <x-form.input type="tel"
                                      name="secondary_phone"
                                      id="secondary_phone"
                                      label="Telefone 2"
                                      placeholder="Ex.: (11) 99999-9999"
                        />
                    </div>

                    <div class="">
                        <x-form.input type="email"
                                      name="email"
                                      id="email"
                                      label="E-mail"
                                      placeholder="Ex.: joao.silva@gmail.com"
                        />
                    </div>
                </div>

                <button type="submit" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4
                focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-green-600
                dark:hover:bg-green-700 dark:focus:ring-green-800">Salvar</button>

            </form>
        </div>
    </div>
</x-app-layout>
