<?php

namespace App\Livewire;

use App\Actions\CalculateAvailableSize;
use App\Models\{Product, ProductType};
use App\Rules\NumberIsNotZeroRule;
use Closure;
use Illuminate\Contracts\View\{Factory, View};
use Illuminate\Database\Eloquent\{Builder, Collection};
use Illuminate\Support\Facades\{DB, Log};
use Illuminate\Support\Str;
use Illuminate\Validation\Rule as ValidationRule;
use Livewire\Attributes\{On};
use Livewire\Component;
use PHPUnit\Exception;

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
            'isMeasurable' => ['required', ValidationRule::in([true, false])],
            'quantity'     => [
                'nullable',
                'required_if:isMeasurable,false',
                'numeric',
                'min:1',
            ],
            'size' => [
                'nullable',
                'required_if:isMeasurable,true',
                'string',
                'max:16',
                new NumberIsNotZeroRule('tamanho'),
                function (string $attributes, mixed $value, Closure $fail) {
                    if ($this->sizeAvailable < formatMoneyToFloat($value)) {
                        $formated = formatMoney($this->sizeAvailable);
                        $fail("O tamanho desejado ultrapassa o disponível ({$formated}m)");
                    }
                },
            ],
            'price' => [
                'required',
                'string',
                'max:16',
                new NumberIsNotZeroRule('preço'),
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
        $this->validate();

        $lastProductOfType = Product::query()
            ->whereHas('type', function (Builder $query) {
                $query->where('id', $this->selectedType);
            })
            ->orderByDesc('id')
            ->first();

        $lastInt = (int) $lastProductOfType?->code;

        DB::beginTransaction();

        try {
            $splittedPrice = explode(',', $this->price);
            $integerPart   = str_replace(search: '.', replace: '', subject: $splittedPrice[0]);
            $price         = (float) implode('.', [$integerPart, $splittedPrice[1]]);
            dd($price);

            if ($request->input('measurable') === 'true') {

                $code = $lastInt + 1;

                $size = (float) Str::replace(',', '.', Str::replace(
                    '.',
                    '',
                    $request->input('price')
                ));

                Product::create([
                    'code'            => $code,
                    'product_type_id' => $request->input('product_type'),
                    'price'           => $price,
                    'size'            => $size,
                ]);

            } else {

                for ($i = 0; $i < (int) $request->input('quantity'); $i++) {
                    $code = $lastInt + 1;

                    Product::create([
                        'code'            => $code,
                        'product_type_id' => $request->input('product_type'),
                        'price'           => $price,
                    ]);

                    $lastInt++;
                }
            }

            DB::commit();
        } catch (Exception $error) {
            DB::rollBack();

            $request->session()->flash('status', 'error');
            $request->session()->flash('status_message', 'Houve um erro ao registrar o produto. Tente novamente mais tarde.');
            Log::error($error->getMessage());

            $this->redirect()->back();
        }

        $this->redirectRoute('products.index')->with([
            'status'         => 'success',
            'status_message' => 'Produto criado com sucesso.',
        ]);
    }

    /**
     * @return View|Factory
     */
    public function render(): View|Factory
    {
        return view('livewire.create-product-form');
    }
}
