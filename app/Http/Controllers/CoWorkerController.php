<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShowCoWorkerRequest;
use App\Http\Requests\StoreCoWorkerRequest;
use App\Http\Requests\UpdateCoWorkerRequest;
use App\Models\CoWorker;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CoWorkerController extends Controller
{
    public function index(ShowCoWorkerRequest $request, $type = null)
    {
        $validatedData = $request->validated();
        $searchText = $validatedData['search'] ?? null;
        $error = [];

        $query = CoWorker::query();

        if($type === 'search'){
            $query->where(function ($query) use ($searchText) {
                $query->where('name', 'LIKE', "%$searchText%")
                    ->orWhere('email', 'LIKE', "%$searchText%")
                    ->orWhere('phone', 'LIKE', "%$searchText%")
                    ->orWhere('position', 'LIKE', "%$searchText%");
            });
        }

        $coworkers = $query->get();

        if($coworkers->isEmpty()){
            $error = ['not_found' => 'Nincs találat'];
        }

        return Inertia::render('CoWorkers',[
            'coworkers' => $coworkers,
            'errors' => $error,
            'searchedText' => $searchText,
        ]);
    }

    public function store(StoreCoWorkerRequest $request): RedirectResponse
    {
        CoWorker::query()->create($request->validated());

        return redirect('/coworkers');
    }

    public function update(UpdateCoWorkerRequest $request,CoWorker $coworker): RedirectResponse
    {
        $coworker->update($request->validated());

        return redirect('/coworkers');
    }

    public function destroy(CoWorker $coworker): RedirectResponse
    {
        $coworker->delete();

        return redirect('/coworkers');

    }
}
