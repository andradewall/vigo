<?php

namespace App\Http\Controllers;

use App\Actions\CalculateAvailableSize;
use App\Models\{Product, ProductType};
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\{RedirectResponse, Request};
use Illuminate\Support\Facades\{DB, Log};
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index(): View
    {
        $search = request()->search;
        $filter = request()->filter;

        $products = Product::query()
            ->with('type')
            ->when(!empty($filter) && !in_array($filter, [
                '*', 'name', 'is_rented:true', 'is_rented:false', 'code_prefix',
            ]), function (Builder $query) use ($filter, $search) {
                $query->where($filter, 'LIKE', '%' . $search . '%');
            })
            ->when(!empty($filter) && $filter === 'name', function (Builder $query) use ($search) {
                $query->whereRelation('type', 'name', 'LIKE', '%' . $search . '%');
            })
            ->when(!empty($filter) && $filter === 'code_prefix', function (Builder $query) use ($search) {
                $query->whereRelation('type', 'code_prefix', 'LIKE', '%' . $search . '%');
            })
            ->when(!empty($filter) && $filter === 'is_rented:false', fn (Builder $query) => $this->buildIsRentedQuery($query, $search, false))
            ->when(!empty($filter) && $filter === 'is_rented:true', fn (Builder $query) => $this->buildIsRentedQuery($query, $search, true))
            ->when(!empty($search) && $search === '*', function (Builder $query) use ($search) {
                $query->where('price', 'LIKE', '%' . $search . '%');
                $query->orWhereRelation('type', 'description', 'LIKE', '%' . $search . '%');
                $query->orWhereRelation('type', 'name', 'LIKE', '%' . $search . '%');
                $query->orWhereRelation('type', 'code_prefix', 'LIKE', '%' . $search . '%');
                $query->orWhere('description', 'LIKE', '%' . $search . '%');
            })
            ->paginate(10);

        $params = request()->only('search');

        return view('products.index', compact('products', 'params'));
    }

    protected function buildIsRentedQuery(Builder $query, string $search, bool $value)
    {
        $query->where('is_rented', '=', $value);
        $query->where(function (Builder $query) use ($search) {
            $query->whereRelation('type', 'name', 'LIKE', '%' . $search . '%');
            $query->orWhereRelation('type', 'description', 'LIKE', '%' . $search . '%');
            $query->orWhere('price', 'LIKE', '%' . $search . '%');
        });
    }

    public function create(): View
    {
        return view('products.create');
    }

    /**
     * @throws Exception
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate(
            [
                'product_type' => ['required', 'exists:product_types,id'],
                'measurable'   => ['required', Rule::in(['true', 'false'])],
                'quantity'     => [
                    'nullable',
                    'required_if:measurable,false',
                    'numeric',
                    'min:1',
                ],
                'size' => [
                    'nullable',
                    'required_if:measurable,true',
                    'string',
                    'max:16',
                    function (string $attributes, mixed $value, \Closure $fail) {
                        $foundComma              = Str::contains($value, ',');
                        $commaAsDecimalSeparator = $foundComma && Str::charAt($value, Str::length($value) - 3) === ',';

                        if (!$foundComma && !$commaAsDecimalSeparator) {
                            $fail('O tamanho deve ser um número com duas casas decimais.');
                        }
                    },
                    function (string $attributes, mixed $value, \Closure $fail) use ($request) {
                        $type = ProductType::findOrFail($request->input('product_type'));

                        $requested = CalculateAvailableSize::run($type);

                        if ($requested < formatMoneyToFloat($value)) {
                            $fail('O tamanho desejado ultrapassa o disponível (' . formatMoney($type->max_size) . 'm)');
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
                    },
                ],
            ],
            [
                'product_type.required' => 'O tipo do produto é obrigatório.',
                'product_type.exists'   => 'O tipo do produto informado não existe.',
                'quantity.required'     => 'A quantidade é obrigatória.',
                'quantity.numeric'      => 'A quantidade deve ser um número.',
                'quantity.min'          => 'A quantidade deve que ser maior que 0.',
                'price.required'        => 'O preço é obrigatório.',
                'price.max'             => 'O preço não pode passar de R$ 9.999.999.999,99',
            ]
        );

        $lastProductOfType = ProductType::query()
            ->find($request->input('product_type'))
            ->products()
            ->orderBy('code', 'desc')
            ->first();

        $lastInt = (int) $lastProductOfType?->code;

        DB::beginTransaction();

        try {
            $price = (float) Str::replace(',', '.', Str::replace(
                '.',
                '',
                $request->input('price')
            ));

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

            return back();
        }

        return to_route('products.index')->with([
            'status'         => 'success',
            'status_message' => 'Produto criado com sucesso.',
        ]);
    }

    public function show(Product $product): View
    {
        $rents = $product->rents()->paginate(10);

        return view('products.show', compact('product', 'rents'));
    }

    public function edit(Product $product): View
    {
        $product->load('type');

        return view('products.edit', compact('product'));
    }

    public function update(Product $product, Request $request): RedirectResponse
    {
        $request->validate(
            [
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
            ],
            [
                'price.required' => 'O preço é obrigatório.',
                'price.max'      => 'O preço não pode passar de R$ 9.999.999.999,99',
            ]
        );

        $price = (float) Str::replace(',', '.', Str::replace(
            '.',
            '',
            $request->input('price')
        ));

        $product->update(['price' => $price]);

        return to_route('products.show', $product)->with([
            'status'  => 'success',
            'message' => 'Produto atualizado com sucesso.',
        ]);
    }

    public function destroy(Product $product): RedirectResponse
    {
        try {
            foreach ($product->rents as $rent) {
                foreach ($rent->products as $otherProduct) {
                    if ($otherProduct->id !== $product->id) {
                        $otherProduct->update(['is_rented' => false]);
                    }
                }
                $rent->delete();
            }
            $product->delete();
        } catch (Exception $e) {
            return back()->with([
                'status'  => 'error',
                'message' => 'Não foi possível excluir o produto.',
            ]);
        }

        return to_route('products.index')->with([
            'status'  => 'success',
            'message' => 'Produto excluído com sucesso.',
        ]);
    }
}
