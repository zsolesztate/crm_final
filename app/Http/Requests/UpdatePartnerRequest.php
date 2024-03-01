<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePartnerRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required','string','max:255'],
            'company_name' => ['required','string','max:255',Rule::unique('partners')->ignore($this->partner->id)],
            'email' => ['required','email','min:10','max:255',Rule::unique('partners')->ignore($this->partner->id)],
            'coworkers' => ['nullable', 'array'],
        ];
    }
}
