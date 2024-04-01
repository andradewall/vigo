<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductTypeStoreUpdateRequest;
use App\Models\ProductType;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class ProductTypeController extends Controller
{
    public function index(): View
    {
        $search = request()->search;
        $filter = request()->filter;

        $productTypes = ProductType::query()
            ->when(!empty($filter) && $filter !== '*', function (Builder $query) use ($filter, $search) {
                $query->where($filter, 'LIKE', '%' . $search . '%');
            })
            ->when(!empty($search) && $search === '*', function (Builder $query) use ($search) {
                $query->where('code_prefix', 'like', '%' . $search . '%');
                $query->orWhere('name', 'like', '%' . $search . '%');
                $query->orWhere('description', 'like', '%' . $search . '%');
            })
            ->paginate(10);

        $params = request()->only('search');

        return view('product_types.index', compact('productTypes', 'params', 'filter'));
    }

    public function create(): View
    {
        return view('product_types.create');
    }

    public function store(ProductTypeStoreUpdateRequest $request): RedirectResponse
    {
        $price = (float) Str::replace(',', '.', Str::replace(
            '.',
            '',
            $request->input('price')
        ));

        ProductType::create([
            ...$request->only('name', 'description', 'code_prefix', 'base_type'),
            'price' => $price,
        ]);

        return to_route('types.index')
            ->with('success', 'Tipo de produto cadastrado com sucesso.');
    }

    public function show(ProductType $productType): View
    {
        return view('product_types.show', compact('productType'));
    }

    public function edit(ProductType $productType): View
    {
        return view('product_types.edit', compact('productType'));
    }

    public function update(ProductTypeStoreUpdateRequest $request, ProductType $productType): RedirectResponse
    {
        $price = (float) Str::replace(',', '.', Str::replace(
            '.',
            '',
            $request->input('price')
        ));

        $productType->update([
            ...$request->only('name', 'description', 'code_prefix'),
            'price' => $price,
        ]);

        return to_route('types.index');
    }

    public function destroy(ProductType $productType): RedirectResponse
    {

        try {
            foreach ($productType->products as $product) {

                foreach ($product->rents as $rent) {

                    foreach ($rent->products as $otherProduct) {
                        if ($otherProduct->id !== $product->id) {
                            $otherProduct->update(['is_rented' => false]);
                        }
                    }

                    $rent->delete();
                }

                $product->delete();
            }
            $productType->delete();
        } catch (\Exception $e) {
            return back()->with([
                'status'  => 'error',
                'message' => 'Não foi possível excluir o tipo de produto.',
            ]);
        }

        return to_route('types.index')->with([
            'status'  => 'success',
            'message' => 'Tipo de produto excluído com sucesso.',
        ]);
    }
}
