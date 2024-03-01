<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePartnerRequest;
use App\Http\Requests\UpdatePartnerRequest;
use App\Models\CoWorker;
use App\Models\Partner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PartnerController extends Controller
{
    public function index()
    {
        return Inertia::render('Partners',[
            'partners' => Partner::with('coworkers')->get(),
            'coworkers' => CoWorker::all()
        ]);
    }

    public function store(StorePartnerRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        $partner = Partner::create([
            'name' => $validatedData['name'],
            'company_name' => $validatedData['company_name'],
            'email' => $validatedData['email'],
        ]);

        foreach ($validatedData['coworkers'] as $coworker) {
            $coworker = CoWorker::find($coworker['id']);
            if ($coworker) {
                $partner->coworkers()->attach($coworker['id']);
            }
        }

        return redirect('/partners');
    }

    public function destroy(Partner $partner): RedirectResponse
    {
        $partner->delete();

        return redirect('/partners');

    }

    public function update(UpdatePartnerRequest $request,Partner $partner): RedirectResponse
    {
        $validatedData = $request->validated();

        $partner->update([
            'name' => $validatedData['name'],
            'company_name' => $validatedData['company_name'],
            'email' => $validatedData['email'],
        ]);

        $partner->coworkers()->sync([]);

        foreach ($validatedData['coworkers'] as $coworker) {
            $coworker = CoWorker::find($coworker['id']);
            if ($coworker) {
                $partner->coworkers()->attach($coworker['id']);
            }
        }

        return redirect('/partners');
    }
}
