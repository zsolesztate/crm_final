<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVacationRequest;
use App\Http\Requests\UpdateVacationRequest;
use App\Models\Contact;
use App\Models\Vacation;

use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class VacationController extends Controller
{
    public function index(Contact $contact)
    {
        return Inertia::render('Vacation',[
            'vacations' => Vacation::where('contact_id', $contact->id)->get(),
            'contact' => $contact
        ]);
    }

    public function create(Contact $contact): Response
    {
        return Inertia::render('CreateVacation',[
            'contact' => $contact
        ]);
    }

    public function store(StoreVacationRequest $request,Contact $contact): RedirectResponse
    {
        $validatedData = $request->validated();

        Vacation::create([
            'name' => $validatedData['name'],
            'contact_id' => $contact->id,
            'from_date' => $validatedData['fromDate'],
            'to_date' => $validatedData['toDate'],
        ]);

        return redirect('vacations/' . $contact->id);
    }

    public function edit(Vacation $vacation): Response
    {
        $vacation->load('contact');

        return Inertia::render('EditVacation', [
            'vacation' => $vacation,
        ]);
    }

    public function update(Vacation $vacation,UpdateVacationRequest $request): RedirectResponse
    {
        $vacation->update($request->validated());

        return redirect('vacations/' . $vacation->contact_id);
    }

    public function destroy(Vacation $vacation): RedirectResponse
    {
        $vacation->delete();

        return redirect('vacations/' . $vacation->contact_id);
    }


}
