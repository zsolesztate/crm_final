<?php

namespace App\Rules;

use App\Models\Vacation;
use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class DateRangeRule implements ValidationRule
{
    protected $contactId;
    protected $fromDate;
    protected $toDate;
    protected $vacationId;
    public function __construct($contactId,$fromDate, $toDate,$vacationId)
    {
        $this->contactId = $contactId;
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
        $this->vacationId = $vacationId;
    }

    public function validate($attribute, $value, Closure $fail): void
    {
        $query = Vacation::where('contact_id', $this->contactId)
            ->where(function ($query) {
                $query->where('from_date', '<=', $this->toDate)
                    ->where('to_date', '>=', $this->fromDate);
            });

        if ($this->vacationId) {
            $query->where('id', '!=', $this->vacationId);
        }

        $overlap = $query->first();

        if ($overlap) {
            $fromDate = Carbon::parse($overlap->from_date)->format('Y-m-d');
            $toDate = Carbon::parse($overlap->to_date)->format('Y-m-d');
            $overlapRange = "$fromDate - $toDate";
            $fail('Átfedés van egy már betervezett szabadsággal. ' . $overlapRange . ' közötti dátummal');
        }
    }

}
