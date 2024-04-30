<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Novo Aluguel
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-8 space-y-6">
            <x-form post :action="route('rents.store')" with-loading>

                <section class="grid grid-cols-2 gap-6 mb-6 w-full">

                    <div class="col-span-2">
                        <h3 class="font-semibold">
                            Informações do Cliente
                        </h3>
                    </div>

                    <div class="">
                        <span class="block mb-2 text-sm font-medium text-gray-900">
                            Todos os Clientes
                        </span>
                        <div class="flex">
                            <div id="all-contacts-wrapper" class="w-80 relative">
                                <x-form.select-searchable
                                        name="select-contacts"
                                        id="select-contacts"
                                        placeholder="Pesquise um cliente..."
                                        options-class="select-searchable-contact-item"
                                        :list="$contacts->map(function ($contact) {
                                            return [
                                                'value' => $contact->id,
                                                'label' => $contact->name . ' (' . $contact->main_phone . ')',
                                            ];
                                        })"
                                />
                            </div>
                            <button type="button"
                                    id="btn-add-client"
                                    class="text-white bg-blue-700 hover:bg-blue-800
                                        focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-lg px-5 py-1.5
                                        mx-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none
                                        dark:focus:ring-blue-800"
                            >
                                &rarr;
                            </button>
                        </div>
                        <p id="helper-text-explanation" class="text-sm text-gray-500">
                            Você pode pesquisar por nome ou telefone.
                        </p>
                    </div>

                    <x-form.input type="text"
                                  name="contact_name"
                                  id="contact_name"
                                  label="Nome do Cliente"
                                  :value="$rent->contact_name ?? ''"
                                  required
                    />

                    <div class="col-span-2">
                        <x-form.input type="text"
                                      name="contact_address"
                                      id="contact_address"
                                      label="Endereço"
                                      :value="$rent->contact_address ?? ''"
                                      required
                        />
                    </div>

                    <x-form.input type="tel"
                                  name="contact_main_phone"
                                  id="contact_main_phone"
                                  label="Telefone 1"
                                  :value="$rent->contact_main_phone ?? ''"
                                  required
                    />

                    <x-form.input type="text"
                                  name="contact_document_number"
                                  id="contact_document_number"
                                  label="Nr do Documento"
                                  placeholder="Ex.: CPF ou CNPJ"
                                  :value="$rent->contact_document_number ?? ''"
                                  required
                    />

                    <x-form.input type="tel"
                                  name="contact_secondary_phone"
                                  id="contact_secondary_phone"
                                  label="Telefone 2"
                                  :value="$rent->contact_secondary_phone ?? ''"
                                  hint="Opcional"
                    />

                    <x-form.input type="email"
                                  name="contact_email"
                                  id="contact_email"
                                  label="E-mail"
                                  :value="$rent->contact_email ?? ''"
                                  hint="Opcional"
                    />

                    <hr class="col-span-2"/>

                    <div class="col-span-2">
                        <h3 class="font-semibold">
                                Informações do Aluguel
                        </h3>
                    </div>

                    <livewire:rent-number />

                    <livewire:rent-duration />

                    <!-- <x-form.input type="date" -->
                    <!--               name="ending_date" -->
                    <!--               id="ending_date" -->
                    <!--               label="Data de Término" -->
                    <!--               :value="!empty($rent->ending_date) && $rent->ending_date >= now() ? -->
                    <!--               $rent->ending_date->format('Y-m-d') : ''" -->
                    <!--               required -->
                    <!-- /> -->

                    <div class="col-span-2">
                        <x-form.input type="text"
                                      name="usage_address"
                                      id="usage_address"
                                      label="Endereço do Uso"
                                      :value="$rent->usage_address ?? ''"
                                      required
                        />
                    </div>

                    <div class="col-span-2">
                        <x-form.input type="text"
                                      name="payment_method"
                                      id="payment_method"
                                      label="Método de Pagamento"
                                      placeholder="Ex.: Dinheiro, Cartão de Crédito, Pix, etc."
                                      :value="$rent->payment_method ?? ''"
                                      required
                        />
                    </div>

                    <div class="col-span-2">
                        <x-form.textarea name="notes"
                                         id="notes"
                                         label="Observações"
                                         :value="$rent->notes ?? ''"
                                         hint="Detalhes do aluguel, se necessário."
                        />
                    </div>

                    <hr class="col-span-2"/>

                    <div class="col-span-2">
                        <h3 class="font-semibold">
                            Produtos Alugados
                        </h3>
                    </div>
                    <div class="col-span-2">
                        <span class="block mb-2 text-sm font-medium text-gray-900">
                            Todos os Produtos
                        </span>
                        <div class="flex">
                            <div id="all-procuts-wrapper" class="w-full relative">
                                <x-form.select-searchable
                                        name="select-products"
                                        id="select-products"
                                        placeholder="Pesquise um produto..."
                                        options-class="select-searchable-product-item"
                                        required
                                        :list="$products->map(function ($product) {
                                        return [
                                            'value' => $product->id,
                                            'label' => \App\Actions\GetProductCode::run($product) . ' | R$' .
                                            formatMoney($product->price) . ' | ' .$product->type->name,
                                        ];
                                    })"
                                />
                            </div>
                            <button type="button"
                                    id="btn-add-product"
                                    class="text-white bg-blue-700 hover:bg-blue-800
                                        focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-lg px-5 py-2
                                        mx-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none
                                        dark:focus:ring-blue-800"
                            >
                                <x-icons.add class="w-6 h-6" />
                            </button>
                        </div>
                    </div>

                    <div class="col-span-2">
                        <span class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-200">
                            Produtos adicionados ao aluguel <span class="text-red-400 text-bold">*</span>
                        </span>
                        <div id="products-wrapper" class="grid grid-cols-[10%_1fr] gap-4 border p-4 rounded">
                            <span id="emptyList" class="col-span-2">Nenhum produto selecionado.</span>
                        </div>
                    </div>

                    @error('products')
                    <p class="col-span-2 mt-2 text-sm text-red-600">
                        <span class="font-medium">{{ $errors->first('products') }}</span>
                    </p>
                    @enderror

                    <x-form.input type="number"
                                  name="discount_percentage"
                                  id="discount_percentage"
                                  label="Desconto (%)"
                                  min="0"
                                  max="100"
                                  x-on:blur="calculate"
                    />

                    <div x-data>
                        <x-form.input type="text"
                                      name="shipping_fee"
                                      id="shipping_fee"
                                      label="Frete (R$)"
                                      x-on:input="formatCurrency"
                                      x-on:blur="calculate"
                                      hint="Deixe em branco para aluguel sem frete"
                        />
                    </div>

                    <input type="hidden" name="total_amount" id="total_amount" />

                    <div class="p-4 text-yellow-800 border border-yellow-300 rounded-lg bg-yellow-50 col-span-2"
                         role="alert">
                        <div class="flex items-center">
                            <x-icons.currency-dollar class="w-6 h-6 mr-2" />
                            <span class="sr-only">Info</span>
                            <h3 class="text-lg font-medium">VALOR TOTAL</h3>
                        </div>
                        <div class="mt-4 text-sm flex flex-col w-fit">
                            <div id="products-sum-label" class="flex justify-between">
                                <strong>Soma dos Produtos:</strong>
                                <span class="ml-4">
                                    R$ <span id="products-sum-value">0,00</span>
                                </span>
                            </div>
                            <div id="discount-label" class="flex justify-between ">
                                <strong>Desconto (<span id="discount-percentage">0</span>%):</strong>
                                <span>
                                   - R$ <span id="discount-value">0,00</span>
                                </span>
                            </div>
                            <div id="shipping-fee-label" class="flex justify-between ">
                                <strong>Valor do Frete:</strong>
                                <span>
                                    + R$ <span id="shipping-fee-value">0,00</span>
                                </span>
                            </div>
                            <div id="total-amount-label" class="flex justify-between mt-2 pt-2 border-t
                            border-amber-600">
                                <strong>Valor Total:</strong>
                                <span>
                                    R$ <span id="total-amount-value">0,00</span>
                                </span>
                            </div>
                        </div>
                    </div>

                </section>

                <x-buttons.submit with-loading>
                    Salvar
                </x-buttons.submit>
            </x-form>
        </div>
    </div>

    @if(session()->has('status'))
        <x-toast type="{{ session()->get('status') }}">
            {{ session()->get('status_message') }}
        </x-toast>
    @endif

    @push('scripts')
        <script type="module">
            $(document).ready(() => {
                $(document).on('change', '#contact_address', function () {
                    const address = $(this).val();
                    $('#usage_address').val(address);
                });

                handleAddProductClick()

                handleAddClientClick()
            });

            const handleAddProductClick = () => {
                $('#btn-add-product').click(() => {
                    const $select = $('#select-products');
                    const $productsWrapper = $('#products-wrapper');
                    const id = $select.val();
                    const $item = $('.select-searchable-product-item[data-value="' + id + '"]')
                    const itemLabel = $item.text().split(' | ');
                    const itemText = itemLabel[0] + ' | ' + itemLabel[2];
                    const itemPrice = itemLabel[1].replace('R$', '').trim();

                    if ($(`#product-${id}`).length > 0) {
                        return;
                    }

                    const emptyList = $productsWrapper.find('span#emptyList').length === 1;

                    const newProductElement = `<div class="item-${id}">
    <input type="text"
        name="products[${id}]"
        id="product-${id}"
        value="${itemPrice}"
        x-on:input="formatCurrency"
        x-on:blur="calculate"
        class="product-selected bg-gray-50 read-only:bg-gray-200 border border-gray-300 text-gray-900
            text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
    />
</div>
<div class="item-${id} flex items-center justify-between">
    <span>${itemText}</span>
    <button type="button" id="delete-item-${id}" data-relative-id="item-${id}" x-on:click="removeProduct($event
    .currentTarget)">
        <x-icons.delete class="text-red-500" />
    </button>
</div>
`;

                    if (emptyList) {
                        $productsWrapper.html(newProductElement);
                    } else {
                        $productsWrapper.append(newProductElement);
                    }

                    updateProductsSum()
                });
            }

            const handleAddClientClick = () => {
                $('#btn-add-client').click(() => {
                    $.post('{{ route('contacts.details') }}', {
                        _token: '{{ csrf_token() }}',
                        id: $('#select-contacts').val(),
                    }, (data) => {
                        const contactInfo = JSON.parse(data);
                        $('#contact_name').val(contactInfo.name);
                        $('#contact_address').val(contactInfo.address);
                        $('#usage_address').val(contactInfo.address);
                        $('#contact_main_phone').val(contactInfo.main_phone);
                        $('#contact_secondary_phone').val(contactInfo.secondary_phone);
                        $('#contact_email').val(contactInfo.email);
                        $('#contact_document_number').val(contactInfo.document_number);

                        $('#select-contacts-search').val('');
                    });
                });
            }
        </script>
        <script>
            const formatCurrency = (event) => {
                let input = event.target;
                let value = input.value.replace(/\D/g, ''); // Remove não dígitos
                value = (value / 100).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                input.value = value;
            }

            const removeProduct = (target) => {
                const id = target.dataset.relativeId
                document.querySelectorAll(`.${id}`).forEach(element => element.remove())

                if (document.querySelector('#products-wrapper').children.length === 0) {
                    document.querySelector('#products-wrapper').innerHTML = '<span id="emptyList" class="col-span-2">Nenhum produto selecionado.</span>'
                }

                calculate()
            }

            const updateProductsSum = () => {
                const products = document.querySelectorAll('.product-selected')

                let amount = 0.00;
                products.forEach((element) => {
                    amount += parseFloat(element.value.replace('.', '').replace(',', '.'))
                })

                const productSumLabel = document.querySelector('#products-sum-value')
                productSumLabel.textContent = amount.toLocaleString('pt-BR', { minimumFractionDigits: 2,
                    maximumFractionDigits:
                        2 })

                updateTotalAmount()
            }

            const updateDiscount = () => {
                let input = document.querySelector('#discount_percentage').value

                if (input === '') {
                    input = '0'
                }

                const discountValue = document.querySelector('#discount-value')
                const discountPercentage = document.querySelector('#discount-percentage')

                const productsSumsValue = document.querySelector('#products-sum-value').textContent

                let discount = parseFloat(productsSumsValue.replace('.', '').replace(',', '.'))
                    * (parseInt(input) / 100)

                if (discount.toString().indexOf('.') === -1) {
                    discount = discount + '.00'
                } else {
                    discount = discount.toString()
                }

                const split = discount.split('.')

                discountValue.textContent = split[0] + ',' + split[1].substring(0, 2)
                discountPercentage.textContent = input

                updateTotalAmount()
            }

            const updateShippingFee = () => {
                let input = document.querySelector('#shipping_fee').value

                if (input === '') {
                    input = '0,00'
                }

                const shippingFeeValue = document.querySelector('#shipping-fee-value')

                shippingFeeValue.textContent = input

                updateTotalAmount()
            }

            const updateTotalAmount = () => {
                const productsSumValue = document.querySelector('#products-sum-value')
                const shippingFeeValue = document.querySelector('#shipping-fee-value')
                const discountValue = document.querySelector('#discount-value')
                const totalAmountValue = document.querySelector('#total-amount-value')

                const productsSum = parseFloat(productsSumValue.textContent.replace('.', '').replace(',', '.'))
                const discount = parseFloat(discountValue.textContent.replace('.', '').replace(',', '.'))
                const shippingFee = parseFloat(shippingFeeValue.textContent.replace('.', '').replace(',', '.'))

                const totalAmount = productsSum - discount + shippingFee
                const totalAmountParsed = totalAmount.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })
                totalAmountValue.textContent = totalAmountParsed

                document.querySelector('#total_amount').value = totalAmountParsed
            }

            const calculate = () => {
                updateProductsSum()
                updateDiscount()
                updateShippingFee()
                updateTotalAmount()
            }
        </script>
    @endpush
</x-app-layout>
