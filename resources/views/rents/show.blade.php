<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Detalhes do Aluguel
        </h2>

        <x-badges.rent-status :status="$rent->status" class="mt-4">
            {{ $rent->status->value }}
        </x-badges.rent-status>
    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto px-8 space-y-6">

            <div class="flex justify-between">

                @if($rent->status !== \App\Enums\RentStatus::CLOSED)
                    <a href="{{ route('rents.close', $rent->id) }}"
                        id="close-button"
                        title="Definir aluguel como encerrado"
                        class="bg-white p-1.5 rounded shadow text-red-600 uppercase flex border border-red-600
                        hover:bg-red-100 transition">
                        <x-icons.no-symbol class="h-6 w-6 mr-2" />
                        Encerrar
                    </a>

                    <dialog id="close-modal"
                        class="p-6 rounded shadow-lg">
                        Deseja realmente encerrar?

                        <form action="{{ route('rents.close', $rent->id) }}"
                            method="POST"
                            class="mt-4 flex justify-between">
                            @csrf
                            <button type="button"
                                id="close-modal__btn-cancel">
                                Cancelar
                            </button>
                            <button type="submit"
                                id="close-modal__btn-submit"
                                class="text-red-600 p-1.5 rounded hover:bg-red-100 transition">
                                Encerrar
                            </button>
                        </form>
                    </dialog>
                @endif

                <a href="{{ route('pdf.contract', $rent) }}"
                   target="_blank"
                   title="Abrir o contrato de locação"
                   class="bg-white p-1.5 rounded shadow text-blue-600 uppercase flex border border-blue-600
                    hover:bg-blue-100 transition">
                    <x-icons.print class="h-6 w-6 mr-2" />
                    Contrato
                </a>

                <a href="{{ route('rents.renew.page', $rent) }}"
                   title="Renovar o contrato"
                   class="bg-white p-1.5 rounded shadow text-green-600 uppercase flex border border-green-600
                    hover:bg-green-100 transition">
                    <x-icons.add class="h-6 w-6 mr-2" />
                    Renovar
                </a>

                @if($rent->status === \App\Enums\RentStatus::PENDING_PAYMENT)
                    <x-form post action="{{ route('rents.change-status', $rent) }}" class="ml-4">
                        <input type="hidden" name="currentStatus" value="{{ $rent->status->name }}" />

                        <button type="submit" class="bg-white p-1.5 rounded shadow text-green-600 uppercase flex border border-green-600
                hover:bg-green-100 transition">
                            <x-icons.dollar class="h-6 w-6 mr-2" />
                            Marcar Como Pago
                        </button>
                    </x-form>
                @endif

                @if($rent->status === \App\Enums\RentStatus::PAID)
                    <x-form post action="{{ route('rents.change-status', $rent) }}" class="ml-4">
                        <input type="hidden" name="currentStatus" value="{{ $rent->status->name }}" />

                        <button type="submit" class="bg-white p-1.5 rounded shadow text-green-600 uppercase flex border border-green-600
            hover:bg-green-100 transition">
                            <x-icons.cube class="h-6 w-6 mr-2" />
                            Marcar Como Entregue
                        </button>
                    </x-form>
                @endif
            </div>

            <div class="grid grid-cols-2 gap-6 mb-6 w-full">

                <div class="col-span-2 flex justify-between">
                    <h3 class="font-semibold">
                        Produtos do Aluguel
                    </h3>

                    <x-link route="{{ route('rents.create', [ 'ref' => $rent ]) }}">
                        Adicionar Produtos
                    </x-link>
                </div>

                <div class="col-span-2 overflow-x-auto shadow-md sm:rounded-lg">
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
                                Nome
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Preço (R$)
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Descrição
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                            @php
                                $productsSum = 0.0;
                            @endphp
                            @foreach($products as $product)
                                @php
                                    $productsSum += $product->pivot->price;
                                @endphp
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-6 py-3">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-3">
                                        <x-link :route="route('products.show', $product)">
                                            {{ \App\Actions\GetProductCode::run($product) }}
                                        </x-link>
                                    </td>
                                    <td class="px-6 py-3">{{ formatMoney($product->pivot->price)}}</td>
                                    <td class="px-6 py-3">{{ $product->type->name }}</td>
                                    <td class="px-6 py-3">{{ $product->type->description }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" class="px-6 py-3">
                                    Subtotal: R$ {{ formatMoney($productsSum) }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" class="px-6 py-3">
                                    Desconto ({{ $rent->discount_percentage }}%): R$ {{ formatMoney
                                        (($productsSum * $rent->discount_percentage) / 100) }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" class="px-6 py-3">
                                    Frete: R$ {{ formatMoney($rent->shipping_fee) }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" class="px-6 py-3">
                                    <strong>TOTAL:</strong> R$ {{ formatMoney($rent->value) }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <hr class="col-span-2"/>

                <div class="col-span-2">
                    <h3 class="font-semibold">
                        Informações do Aluguel
                    </h3>
                </div>

                <x-form.input type="text"
                              name="starting_date"
                              id="starting_date"
                              label="Data de Início"
                              value="{{ formatDateTime($rent->starting_date) }}"
                              readonly
                />

                <x-form.input type="text"
                              name="ending_date"
                              id="ending_date"
                              label="Data de Término"
                              value="{{ formatDateTime($rent->ending_date) }}"
                              readonly
                />

                <x-form.input type="text"
                              name="value"
                              id="value"
                              label="Valor (R$)"
                              value="R$ {{ formatMoney($rent->value) }}"
                              readonly
                />

                <x-form.input type="text"
                              name="payment_method"
                              id="payment_method"
                              label="Método de Pagamento"
                              value="{{ $rent->payment_method }}"
                              readonly
                />

                <div class="col-span-2">
                    <x-form.input type="text"
                                  name="usage_address"
                                  id="usage_address"
                                  label="Endereço do Uso"
                                  value="{{ $rent->usage_address }}"
                                  readonly
                    />
                </div>

                <div class="col-span-2">
                    <x-form.textarea name="notes"
                                     id="notes"
                                     label="Observações"
                                     value="{{ $rent->notes }}"
                                     readonly
                    />
                </div>

                <hr class="col-span-2"/>

                <div class="col-span-2">
                    <h3 class="font-semibold">
                        Informações do Cliente
                    </h3>
                </div>

                <x-form.input type="text"
                              name="contact_name"
                              id="contact_name"
                              label="Nome do Cliente"
                              value="{{ $rent->contact_name }}"
                              readonly
                />

                <x-form.input type="text"
                              name="contact_address"
                              id="contact_address"
                              label="Endereço"
                              value="{{ $rent->contact_address }}"
                              readonly
                />

                <x-form.input type="tel"
                              name="contact_main_phone"
                              id="contact_main_phone"
                              label="Telefone 1"
                              value="{{ $rent->contact_main_phone }}"
                              readonly
                />

                <x-form.input type="tel"
                              name="contact_secondary_phone"
                              id="contact_secondary_phone"
                              label="Telefone 2"
                              value="{{ $rent->contact_secondary_phone }}"
                              readonly
                />

                <x-form.input type="email"
                              name="contact_email"
                              id="contact_email"
                              label="E-mail"
                              value="{{ $rent->contact_email }}"
                              readonly
                />
            </div>

            <x-buttons.remove id="delete-{{ $rent->id }}"
                              class="btn-delete mb-4"
                              title="Excluir aluguel"
                              :route="route('rents.destroy', $rent)"
                              with-label
                              with-loading
            >
                <span class="block mb-2">Deseja excluir este aluguel?</span>
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

    @push('scripts')
        <script>
            const modal = document.querySelector('#close-modal');
            const closeBtn = document.querySelector('#close-button');
            const cancelBtn = document.querySelector('#close-modal__btn-cancel');

            closeBtn.addEventListener('click', (event) => {
                event.preventDefault();

                modal.showModal();
            });

            cancelBtn.addEventListener('click', (event) => {
                event.preventDefault();

                modal.close();
            });
        </script>
    @endpush
</x-app-layout>
