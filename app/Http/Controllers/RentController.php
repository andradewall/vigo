<?php

namespace App\Http\Controllers;

use App\Actions\{CloseRent, CreateRent, Pdf\GenerateContractPdf};
use App\Enums\RentStatus;
use App\Http\Requests\Rent\StoreRequest;
use App\Models\{Contact, Product, Rent};
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\{RedirectResponse, Request, Response};
use Illuminate\Support\Facades\{DB, Log};
use Illuminate\Support\{Carbon, Str};

class RentController extends Controller
{
    public function index(): View
    {
        $search = request()->search;
        $filter = request()->filter;

        $rents = Rent::query()
            ->with('products')
            ->when(!empty($search) && $filter === 'value', function (Builder $query) use ($search) {
                $query->where('value', 'LIKE', '%' . $search . '%');
            })
            ->when(!empty($search) && $filter === 'name', function (Builder $query) use ($search) {
                $query->where('contact_name', 'LIKE', '%' . $search . '%');
            })
            ->when(
                Str::contains($filter, 'status'),
                function (Builder $query) use ($filter) {
                    $status = RentStatus::fromValue(Str::substr($filter, 7));
                    $query->where('status', '=', $status);
                }
            )
            ->when(
                !empty($search) && Str::contains($filter, 'date'),
                function (Builder $query) use ($filter, $search) {

                    if (Str::contains($search, '/')) {
                        $format = 'd/m/Y';
                    } elseif (Str::contains($search, '-')) {
                        $format = 'd-m-Y';
                    }

                    $date = Carbon::createFromFormat($format ?? 'd/m/Y', $search);

                    $query->whereDate($filter, $date);
                }
            )
            ->when(!empty($search) && $search === '*', function (Builder $query) use ($search) {
                $query->where('code_prefix', 'LIKE', '%' . $search . '%');
                $query->orWhere('name', 'LIKE', '%' . $search . '%');
                $query->orWhere('description', 'LIKE', '%' . $search . '%');
            })
            ->paginate(10);

        $params = request()->only('search');

        return view('rents.index', compact('rents', 'params'));
    }

    public function create(Request $request): View
    {
        $rent = null;

        if ($request->has('ref')) {
            $rent = Rent::find($request->ref)->first();
        }

        $products = Product::with('type')
            ->where('is_rented', false)
            ->get();
        $contacts = Contact::all();

        return view('rents.create', compact('products', 'contacts', 'rent'));
    }

    /**
     * @throws \Throwable
     */
    public function store(StoreRequest $request): View|RedirectResponse
    {
        $validated = $request->safe();

        $contactData = $validated->only([
            'contact_name',
            'contact_address',
            'contact_main_phone',
            'contact_secondary_phone',
            'contact_email',
            'contact_document_number',
        ]);

        $contact = Contact::query()
            ->where('document_number', $contactData['contact_document_number'])
            ->get();

        if ($contact->isNotEmpty()) {
            $contactData['contact_id'] = $contact->first()->id;
        }

        try {
            $valueParsed       = formatMoneyToFloat($validated->total_amount);
            $shippingFeeParsed = formatMoneyToFloat($validated->shipping_fee);

            $fields = $validated->only([
                'notes',
                'payment_method',
                'discount_percentage',
                'usage_address',
            ]);

            $fields = collect($fields)->merge([
                'id'                      => $validated->number,
                'value'                   => $valueParsed,
                'shipping_fee'            => $shippingFeeParsed,
                'starting_date'           => Carbon::parse($validated->starting_date),
                'ending_date'             => Carbon::parse($validated->ending_date),
                'contact_id'              => $contactData['contact_id'] ?? null,
                'contact_name'            => $contactData['contact_name'],
                'contact_main_phone'      => $contactData['contact_main_phone'],
                'contact_secondary_phone' => $contactData['contact_secondary_phone'],
                'contact_email'           => $contactData['contact_email'],
                'contact_address'         => $contactData['contact_address'],
                'contact_document_number' => $contactData['contact_document_number'],
                'status'                  => RentStatus::PENDING_PAYMENT,
                'products'                => array_map(function (int $id, string $price) {
                    return [
                        'id'    => $id,
                        'price' => formatMoneyToFloat($price),
                    ];
                }, array_keys($validated->products), $validated->products),
            ])->toArray();

            $createRent = CreateRent::run(...$fields);

            if ($createRent['status'] === 'error') {
                throw new Exception('Não foi possível criar o novo aluguel.');
            }

        } catch (Exception $error) {
            $request->session()->flash('status', 'error');
            $request->session()->flash('status_message', 'Houve um erro ao registrar o aluguel. Tente novamente mais tarde.');
            Log::error($error->getMessage());

            return back();
        }

        return to_route('rents.index')->with([
            'status'  => 'success',
            'message' => 'Aluguel criado com sucesso.',
            'link'    => [
                'route' => route('pdf.contract', $createRent['entity']),
                'text'  => 'Baixar contrato',
            ],
        ]);
    }

    public function show(Rent $rent): View
    {
        $products = $rent->products()->with('type')->get();

        return view('rents.show', compact('rent', 'products'));
    }

    public function destroy(Rent $rent): RedirectResponse
    {
        try {
            $rent->products()->each(fn (Product $product) => $product->update(['is_rented' => false]));
            $rent->delete();
        } catch (Exception $e) {
            LOg::error($e->getMessage());

            return back()->with([
                'status'  => 'error',
                'message' => 'Não foi possível excluir o aluguel.',
            ]);
        }

        return to_route('rents.index')->with([
            'status'  => 'success',
            'message' => 'Aluguel excluído com sucesso.',
        ]);
    }

    /**
     * @throws \Throwable
     */
    public function close(Rent $rent): RedirectResponse
    {
        $closeRent = CloseRent::run($rent);

        if ($closeRent['status'] === 'error') {
            return back()->with([
                'status'  => 'error',
                'message' => 'Houve um erro com sua solicitação. Tente novamente mais tarde.',
            ]);
        }

        return back()->with([
            'status'  => 'success',
            'message' => 'Aluguel encerrado com sucesso!',
        ]);
    }

    public function changeStatus(Rent $rent, Request $request): RedirectResponse
    {
        $request->validate([
            'currentStatus' => [
                'required',
                'in:' . RentStatus::PENDING_PAYMENT->name . ',' . RentStatus::PAID->name,
            ],
        ]);

        if ($request->currentStatus === RentStatus::PENDING_PAYMENT->name) {
            $this->setPaid($rent);
        } else {
            $this->setInProgress($rent);
        }

        return back()->with([
            'status'  => 'success',
            'message' => 'Status do aluguel alterado',
        ]);
    }

    private function setPaid(Rent $rent): void
    {
        $rent->update([
            'status' => RentStatus::PAID,
        ]);
    }

    private function setInProgress(Rent $rent): void
    {
        $rent->update([
            'status' => RentStatus::IN_PROGRESS,
        ]);
    }

    public function renewPage(Rent $rent)
    {
        $allProducts = Product::with('type')
            ->where('is_rented', false)
            ->get();
        $rentProducts = $rent->products()->with('type')->get();

        return view('rents.renew', compact('rent', 'allProducts', 'rentProducts'));
    }

    /**
     * @throws \Throwable
     */
    public function renew(Rent $rent, StoreRequest $request): RedirectResponse
    {
        $validated = $request->safe();

        $contactData = $validated->only([
            'contact_name',
            'contact_address',
            'contact_main_phone',
            'contact_secondary_phone',
            'contact_email',
            'contact_document_number',
        ]);

        try {
            $valueParsed       = formatMoneyToFloat($validated->total_amount);
            $shippingFeeParsed = formatMoneyToFloat($validated->shipping_fee);

            $fewValidatedFields = $validated->only([
                'notes',
                'payment_method',
                'discount_percentage',
                'usage_address',
            ]);

            $fields = collect($fewValidatedFields)->merge([
                'value'                   => $valueParsed,
                'shipping_fee'            => $shippingFeeParsed,
                'starting_date'           => Carbon::parse($validated->starting_date),
                'ending_date'             => Carbon::parse($validated->ending_date),
                'contact_id'              => $contactData['contact_id'] ?? null,
                'contact_name'            => $contactData['contact_name'],
                'contact_main_phone'      => $contactData['contact_main_phone'],
                'contact_secondary_phone' => $contactData['contact_secondary_phone'],
                'contact_email'           => $contactData['contact_email'],
                'contact_address'         => $contactData['contact_address'],
                'contact_document_number' => $contactData['contact_document_number'],
                'status'                  => RentStatus::PENDING_PAYMENT,
            ])->toArray();

            $products = array_map(function (int $id, string $price) {
                return [
                    'id'    => $id,
                    'price' => formatMoneyToFloat($price),
                ];
            }, array_keys($validated->products), $validated->products);

            DB::transaction(function () use ($rent, $fields, $products) {
                $update = $rent->update($fields);

                ds($products);

                $rent->products()->detach();

                foreach ($products as $product) {
                    $rent->products()->attach($product['id'], [
                        'price' => $product['price'],
                    ]);
                }

                if (!$update) {
                    throw new Exception('Não foi possível renovar o aluguel.');
                }
            });

        } catch (Exception $error) {
            $request->session()->flash('status', 'error');
            $request->session()->flash('status_message', 'Houve um erro ao renovar o aluguel. Tente novamente mais tarde.');
            Log::error('RentController@renew', [
                'message' => $error->getMessage(),
                'trace'   => $error->getTraceAsString(),
            ]);

            return back();
        }

        return to_route('rents.index')->with([
            'status'  => 'success',
            'message' => 'Aluguel renovado com sucesso.',
            //            'link'    => [
            //                'route' => route('pdf.contract', $createRent['entity']),
            //                'text'  => 'Baixar contrato',
            //            ],
        ]);
    }

    public function contract(Rent $rent): Response
    {
        $products = $rent->products()->with('type')->get();
        $contact  = $rent->contact ?: Contact::query()->whereName($rent->contact_name)->first();

        return GenerateContractPdf::run($rent, $products, $contact);
    }
}
