<?php

namespace App\Http\Requests\Rent;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'discount_percentage'     => $this->discount_percentage ?? 0,
            'shipping_fee'            => $this->shipping_fee ?? '0,00',
            'contact_document_number' => preg_replace('/[^0-9]/', '', $this->contact_document_number),
        ]);
    }

    public function rules(): array
    {
        return [
            'contact_name'            => ['required', 'string', 'max:125'],
            'contact_address'         => ['required', 'string', 'max:255'],
            'contact_main_phone'      => ['required', 'string', 'max:15'],
            'contact_secondary_phone' => ['nullable', 'string', 'max:15'],
            'contact_email'           => ['nullable', 'email', 'max:125'],
            'contact_document_number' => [
                'required',
                'string',
                'min:11',
                'max:14',
            ],
            'number'         => ['required', 'numeric', 'unique:rents,id', 'min:1'],
            'starting_date'  => ['required', 'date'],
            'ending_date'    => ['required', 'date', 'after_or_equal:starting_date'],
            'usage_address'  => ['required', 'string', 'max:255'],
            'payment_method' => ['required', 'string', 'max:125'],
            'notes'          => ['nullable', 'string'],
            'products'       => [
                'required',
                'array',
                function (string $attributes, mixed $value, \Closure $fail) {
                    if (Product::findMany(array_keys($value))->count() !== count($value)) {
                        $fail('Um ou mais produtos selecionados não existem.');
                    }
                },
                function (string $attributes, mixed $value, \Closure $fail) {
                    foreach ($value as $item) {
                        $foundComma              = Str::contains($item, ',');
                        $commaAsDecimalSeparator = $foundComma && Str::charAt($item, Str::length($item) - 3) === ',';

                        if (!$foundComma && !$commaAsDecimalSeparator) {
                            $fail('O valor deve ser um número decimal com duas casas decimais (Ex.: R$ 9,99)');
                        }
                    }
                },
            ],
            'discount_percentage' => ['required', 'integer', 'min:0', 'max:100'],
            'shipping_fee'        => [
                'nullable',
                'string',
                'max:13',
                function (string $attributes, mixed $value, \Closure $fail) {
                    $foundComma              = Str::contains($value, ',');
                    $commaAsDecimalSeparator = $foundComma && Str::charAt($value, Str::length($value) - 3) === ',';

                    if (!$foundComma && !$commaAsDecimalSeparator) {
                        $fail('O valor do frete deve ser um número decimal com duas casas decimais (Ex.: R$ 9,99)');
                    }
                },
            ],
            'total_amount' => [
                'required',
                'string',
                'max:13',
                function (string $attributes, mixed $value, \Closure $fail) {
                    $foundComma              = Str::contains($value, ',');
                    $commaAsDecimalSeparator = $foundComma && Str::charAt($value, Str::length($value) - 3) === ',';

                    if (!$foundComma && !$commaAsDecimalSeparator) {
                        $fail('O valor deve ser um número decimal com duas casas decimais (Ex.: R$ 9,99)');
                    }
                },
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'number.min'                       => 'O número não pode ser menor ou igual a zero.',
            'number.unique'                    => 'O número informado já está em uso.',
            'contact_document_number.required' => 'O número do documento é obrigatório.',
            'contact_document_number.max'      => 'O número do documento não pode ser maior que o tamanho do formato de CNPJ (XX.XXX.XXX/XXXX-XX)',
            'contact_document_number.min'      => 'O número do documento não pode ser menor que o tamanho do formato de CPF (XXX.XXX.XXX-XX)',
        ];
    }
}
