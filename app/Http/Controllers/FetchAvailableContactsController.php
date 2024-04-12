<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class FetchAvailableContactsController extends Controller
{
    public function __invoke(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        $query = Contact::query()
            ->where(fn($query) => $query
                ->whereNotIn('id', fn($subQuery) => $subQuery
                    ->select('contact_id')
                    ->from('vacations')
                    ->where('from_date', '<=', $endDate)
                    ->where('to_date', '>=', $startDate)
                )
            );

        $availableContactsQuery = $query->get();

        return response()->json($availableContactsQuery);
    }
}
