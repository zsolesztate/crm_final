<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePartnerRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required','string','max:255'],
            'company_name' => ['required','string','max:255','unique:partners'],
            'email' => ['required','email','unique:partners','min:10','max:255'],
            'coworkers' => ['nullable', 'array'],
        ];
    }
}
