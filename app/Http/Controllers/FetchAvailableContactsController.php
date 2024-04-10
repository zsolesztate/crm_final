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
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereNotIn('id', function($query) use ($startDate, $endDate) {
                    $query->select('contact_id')
                        ->from('vacations')
                        ->where('from_date', '<=', $endDate)
                        ->where('to_date', '>=', $startDate);
                });
            });

        $query->whereNotIn('id', function($query) {
            $query->select('contact_id')
                ->from('tasks');
        });

        $query->when($request->has('task'), function ($query) use ($request) {
            return $query->orWhereIn('id', function ($subQuery) use ($request) {
                $subQuery->select('contact_id')
                    ->from('tasks')
                    ->where('id', $request->input('task'));
            });
        });

        $availableContactsQuery = $query->get();

        return response()->json($availableContactsQuery);
    }
}
