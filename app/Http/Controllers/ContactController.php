<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactStoreUpdateRequest;
use App\Models\Contact;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\{RedirectResponse, Request};

class ContactController extends Controller
{
    public function index(): View
    {
        $search = request()->search;
        $filter = request()->filter;

        $contacts = Contact::query()
            ->when(!empty($filter) && !in_array($filter, ['*', 'phones']), function (Builder $query) use (
                $filter,
                $search
            ) {
                $query->where($filter, 'LIKE', '%' . $search . '%');
            })
            ->when(!empty($search) && $filter === '*', function (Builder $query) use ($search) {
                $query->orWhere('name', 'like', '%' . $search . '%');
                $query->orWhere('main_phone', 'like', '%' . $search . '%');
                $query->orWhere('secondary_phone', 'like', '%' . $search . '%');
                $query->orWhere('address', 'like', '%' . $search . '%');
                $query->orWhere('email', 'like', '%' . $search . '%');
                $query->orWhere('document_number', 'like', '%' . $search . '%');
            })
            ->when(!empty($filter) && $filter === 'phones', function (Builder $query) use ($search) {
                $query->orWhere('main_phone', 'like', '%' . $search . '%');
                $query->orWhere('secondary_phone', 'like', '%' . $search . '%');
            })
            ->paginate(10);

        $params = request()->only('search');

        return view('contacts.index', compact('contacts', 'params'));
    }

    public function create(): View
    {
        return view('contacts.create');
    }

    public function store(ContactStoreUpdateRequest $request): RedirectResponse
    {
        Contact::create($request->only(
            'name',
            'address',
            'document_number',
            'main_phone',
            'secondary_phone',
            'email'
        ));

        return to_route('contacts.index');
    }

    public function show(Contact $contact): View
    {
        return view('contacts.show', compact('contact'));
    }

    public function details(Request $request): string
    {
        $request->validate([
            'id' => ['required', 'exists:contacts,id'],
        ]);

        $contact = Contact::find($request->input('id'));

        return json_encode($contact->toArray());

    }

    public function edit(Contact $contact): View
    {
        return view('contacts.edit', compact('contact'));
    }

    public function update(ContactStoreUpdateRequest $request, Contact $contact): RedirectResponse
    {
        $contact->update($request->only(
            'name',
            'address',
            'document_number',
            'main_phone',
            'secondary_phone',
            'email'
        ));

        return to_route('contacts.index');
    }

    public function destroy(Contact $contact): RedirectResponse
    {
        $contact->delete();

        return to_route('contacts.index');
    }
}
