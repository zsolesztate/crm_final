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
            'users' => ['nullable', 'array'],
            'users.*.id' => ['exists:users,id']
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'A megjelenítési név mező kitöltése kötelező.',
            'name.max' => 'A megjelenítési név maximum :max karakter hosszú lehet.',
            'company_name.max' => 'A cégnév maximum :max karakter hosszú lehet.',
            'company_name.required' => 'A cégnév mező kitöltése kötelező.',
            'company_name.unique' => 'Ez a cégnév már foglalt.',
            'email.max' => 'Az email cím maximum :max karakter hosszú lehet.',
            'email.min' => 'Az email cím legalább :min karakter hosszú kell legyen.',
            'email.required' => 'Az email cím mező kitöltése kötelező.',
            'email.unique' => 'Ez az email cím már egy másik céghez tartozik.',
        ];
    }
}
