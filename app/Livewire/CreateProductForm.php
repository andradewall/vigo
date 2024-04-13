<?php

namespace App\Livewire;

use App\Actions\CalculateAvailableSize;
use App\Models\ProductType;
use Illuminate\Contracts\View\{Factory, View};
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

class CreateProductForm extends Component
{
    private ?Collection $productTypes;

    public ?array $list = [];

    public ?string $selectedType = '';

    private ?ProductType $type = null;

    public bool $isMeasurable = false;

    public ?string $quantity = '';

    public ?string $size = '';

    public ?string $price = '';

    public float $sizeAvailable = 0;

    public function mount(): void
    {
        $this->productTypes = ProductType::all();

        foreach ($this->productTypes as $type) {
            if ($type->base_type->isMeasurable()) {
                $available = CalculateAvailableSize::run($type);

                $type->__set('sizeAvailable', $available);
            }
        }

        $this->list = collect($this->productTypes)
            ->map(function ($type) {
                return [
                    'value'       => $type->id,
                    'label'       => $type->code_prefix . ' - ' . $type->name . ' (R$ ' . $type->price . '/' . ($type->base_type->isMeasurable() ? 'm' : 'un') . ')',
                    'description' => $type->base_type->isMeasurable()
                        ? 'Produto por metro | Tamanho máximo (m): ' . formatMoney($type->max_size) . ' | Disponível (m): ' . formatMoney($type->sizeAvailable)
                        : 'Produto por unidade | Existentes: x',
                ];
            })->toArray();
    }

    #[On('type-selected')]
    public function handleTypeSelection(): void
    {
        $this->type          = ProductType::find($this->selectedType);
        $this->sizeAvailable = CalculateAvailableSize::run($this->type);
        $this->isMeasurable  = $this->type->base_type->isMeasurable();
    }

    /**
     * @return array<string,mixed>
     */
    public function rules(): array
    {
        return [
            'selectedType' => ['required', 'exists:product_types,id'],
            'isMeasurable' => ['required', Rule::in(['true', 'false'])],
            'quantity'     => [
                'nullable',
                'required_if:isMeasurable,false',
                'numeric',
                'min:1'
            ],
            'size'     => [
                'nullable',
                'required_if:isMeasurable,true',
                'string',
                'max:16',
                function (string $attributes, mixed $value, \Closure $fail) {
                    $foundComma              = Str::contains($value, ',');
                    $commaAsDecimalSeparator = $foundComma && Str::charAt($value, Str::length($value) - 3) === ',';

                    if (!$foundComma && !$commaAsDecimalSeparator) {
                        $fail('O tamanho deve ser um número com duas casas decimais.');
                    }
                },
                function (string $attributes, mixed $value, \Closure $fail) {
                    $type = ProductType::findOrFail($this->selectedType);

                    $requested = CalculateAvailableSize::run($type);

                    if ($requested < formatMoneyToFloat($value)) {
                        $fail('O tamanho desejado ultrapassa o disponível (' . formatMoney($type->max_size) . 'm)');
                    }
                }
            ],
            'price'        => [
                'required',
                'string',
                'max:16',
                function (string $attributes, mixed $value, \Closure $fail) {
                    $foundComma              = Str::contains($value, ',');
                    $commaAsDecimalSeparator = $foundComma && Str::charAt($value, Str::length($value) - 3) === ',';

                    if (!$foundComma && !$commaAsDecimalSeparator) {
                        $fail('O preço deve ser um número com duas casas decimais.');
                    }

                    if ((float) Str::replace(',', '.', Str::replace('.', '', $value)) <= 0) {
                        $fail('O preço não pode ser zero');
                    }

                },
            ],
        ];
    }
    /**
     * @return array<string,string>
     */
    public function messages(): array
    {
        return [
            'product_type.required' => 'O tipo do produto é obrigatório.',
            'product_type.exists'   => 'O tipo do produto informado não existe.',
            'quantity.required'     => 'A quantidade é obrigatória.',
            'quantity.numeric'      => 'A quantidade deve ser um número.',
            'quantity.min'          => 'A quantidade deve que ser maior que 0.',
            'price.required'        => 'O preço é obrigatório.',
            'price.max'             => 'O preço não pode passar de R$ 9.999.999.999,99',
        ];
    }

    public function save(): void
    {
        $validated = $this->validate();
        dd($validated);
    }

    /**
     * @return View|Factory
     */
    public function render(): View|Factory
    {
        return view('livewire.create-product-form');
    }
}
