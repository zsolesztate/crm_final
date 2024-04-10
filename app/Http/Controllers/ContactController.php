<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Models\Contact;
use App\Models\Partner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ContactController extends Controller
{
    public function index()
    {
        return Inertia::render('Contacts',[
            'contacts' => Contact::with('partner')->get()
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('CreateContact',[
            'partners' => Partner::all('id','name')
        ]);
    }

    public function edit(Contact $contact): Response
    {
        $contact->load('partner');

        return Inertia::render('EditContact', [
            'contact' => $contact,
            'partners' => Partner::all('id','name'),
        ]);

    }

    public function update(UpdateContactRequest $request,Contact $contact): RedirectResponse
    {
        $contact->update($request->validated());

        return redirect()->route('contacts.index');
    }


    public function store(StoreContactRequest $request): RedirectResponse
    {
        Contact::create($request->validated());

        return redirect()->route('contacts.index');
    }

    public function destroy(Contact $contact):  RedirectResponse
    {
        $contact->delete();

        return redirect()->route('contacts.index');
    }
}
