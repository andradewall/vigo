<?php

namespace App\Http\Requests;

use App\Enums\BaseTypeEnum;
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
            'base_type' => [
                'required',
                'numeric',
                Rule::in(array_map(fn ($case) => $case->value, BaseTypeEnum::cases())),
            ],
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
            'max_size' => [
                'nullable',
                'required_if:base_type,' . BaseTypeEnum::MEASURABLE->value,
                'string',
                'max:16',
                function (string $attributes, mixed $value, \Closure $fail) {
                    $foundComma              = Str::contains($value, ',');
                    $commaAsDecimalSeparator = $foundComma && Str::charAt($value, Str::length($value) - 3) === ',';

                    if (!$foundComma && !$commaAsDecimalSeparator) {
                        $fail('O tamanho máximo deve ser um número com duas casas decimais.');
                    }

                    // Check if it's value is greater than zero
                    if ((float) Str::replace(',', '.', Str::replace('.', '', $value)) <= 0) {
                        $fail('O tamanho máximo deve ser maior que zero.');
                    }
                },
                function (string $attributes, mixed $value, \Closure $fail) {
                    if ($this->input('base_type') == BaseTypeEnum::MEASURABLE->value && empty($value)) {
                        $fail('O tamanho máximo é obrigatório para produtos por metro.');
                    }
                },
            ],
            'price' => [
                'required',
                'string',
                'max:16',
                function (string $attributes, mixed $value, \Closure $fail) {
                    $foundComma              = Str::contains($value, ',');
                    $commaAsDecimalSeparator = $foundComma && Str::charAt($value, Str::length($value) - 3) === ',';

                    if (!$foundComma && !$commaAsDecimalSeparator) {
                        $fail('O preço deve ser um número com duas casas decimais.');
                    }

                    // Check if it's value is greater than zero
                    if ((float) Str::replace(',', '.', Str::replace('.', '', $value)) <= 0) {
                        $fail('O preço deve ser maior que zero.');
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
            'max_size.required_if' => 'O tamanho máximo é obrigatório para produtos por metro.',
        ];
    }

    // If validation fails, the following method will be called
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        // Get the rule and the field that failed
        $errors = $validator->errors()->all();
        $target = "O tamanho máximo é obrigatório para produtos por metro.";

        $foundTarget = count(array_filter($errors, fn ($error) => $error === $target)) > 0;

        if ($foundTarget) {
            $validator->errors()->forget('max_size');
            $validator->errors()->add('max_size', $target);
        }

        parent::failedValidation($validator);
    }
}
