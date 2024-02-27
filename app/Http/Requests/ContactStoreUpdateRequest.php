<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContactStoreUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'document_number' => preg_replace('/[^0-9]/', '', $this->document_number),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<string>>
     */
    public function rules(): array
    {
        return [
            'name'            => ['required', 'string', 'max:125'],
            'address'         => ['required', 'string', 'max:255'],
            'document_number' => [
                'required',
                'string',
                'min:11',
                'max:14',
                Rule::unique('contacts', 'document_number')->ignore($this->contact),
            ],
            'main_phone'      => ['required', 'string', 'max:125'],
            'secondary_phone' => ['nullable', 'string', 'max:125'],
            'email'           => ['nullable', 'email', 'max:125'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required'            => 'O nome é obrigatório.',
            'name.string'              => 'O nome deve ser um texto.',
            'name.max'                 => 'O nome não pode passar de 125 caracteres',
            'address.required'         => 'O endereço é obrigatório.',
            'address.string'           => 'O endereço deve ser um texto.',
            'address.max'              => 'O endereço não pode passar de 125 caracteres',
            'document_number.required' => 'O número do documento é obrigatório.',
            'document_number.max'      => 'O número do documento não pode ser maior que o tamanho do formato de CNPJ (XX.XXX.XXX/XXXX-XX)',
            'document_number.min'      => 'O número do documento não pode ser menor que o tamanho do formato de CPF (XXX.XXX.XXX-XX)',
            'document_number.unique'   => 'O número do documento já está cadastrado.',
            'main_phone.required'      => 'O telefone 1 é obrigatório.',
            'main_phone.string'        => 'O telefone 1 deve ser um texto.',
            'main_phone.max'           => 'O telefone 1 não pode passar de 125 caracteres',
            'secondary_phone.string'   => 'O telefone 2 deve ser um texto.',
            'secondary_phone.max'      => 'O telefone 2 não pode passar de 125 caracteres',
            'email.email'              => 'O e-mail é inválido.',
            'email.max'                => 'O e-mail não pode passar de 125 caracteres',
        ];
    }
}
