<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductTypeStoreUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:125',
                Rule::unique('product_types', 'name')->ignore($this->productType),
            ],
            'code_prefix' => [
                'required',
                'string',
                'max:120',
                Rule::unique('product_types', 'code_prefix')->ignore($this->productType),
            ],
            'price' => [
                'required',
                'string',
                'max:16',
                function (string $attributes, mixed $value, \Closure $fail) {
                    $foundComma              = Str::contains($value, ',');
                    $commaAsDecimalSeparator = $foundComma && Str::charAt($value, Str::length($value) - 3) === ',';

                    if (!$foundComma && !$commaAsDecimalSeparator) {
                        $fail('O preço deve ser um número decimal com duas casas decimais.');
                    }
                },
            ],
            'description' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'        => 'O tipo de produto é obrigatório.',
            'name.string'          => 'O tipo de produto deve ser um texto.',
            'name.max'             => 'O tipo de produto não pode passar de 125 caracteres',
            'name.unique'          => 'Este tipo de produto já existe.',
            'description.string'   => 'A descrição deve ser um texto.',
            'description.max'      => 'A descrição não pode passar de 255 caracteres',
            'code_prefix.required' => 'O prefixo do código é obrigatório.',
            'code_prefix.string'   => 'O prefixo do código deve ser um texto.',
            'code_prefix.max'      => 'O prefixo do código não pode passar de 120 caracteres',
            'code_prefix.unique'   => 'Este prefixo do código já existe.',
            'price.required'       => 'O preço é obrigatório.',
            'price.max'            => 'O preço não pode passar de R$ 9.999.999.999,99',
        ];
    }
}
