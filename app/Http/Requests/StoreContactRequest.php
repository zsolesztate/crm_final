<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:contacts', 'min:10', 'max:255'],
            'phone' => ['required', 'string', 'max:255', 'regex:/^[+\/\-\s\d]+$/'],
            'position' => ['required', 'string', 'max:255'],
            'partner_id' => ['required', 'exists:partners,id', 'integer'],
            'primary_contact' => ['nullable', 'boolean', Rule::unique('contacts')->where(function ($query) {
                return $query->where('primary_contact', true)->where('partner_id', $this->partner_id);
            })->ignore($this->input('id'))],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'A név mező kitöltése kötelező.',
            'name.regex' => 'A név csak betűket, számokat és ékezetes betűket tartalmazhat.',
            'name.max' => 'A név maximum :max karakter hosszú lehet.',
            'email.required' => 'Az email mező kitöltése kötelező.',
            'email.email' => 'Az email mező érvényes email címet kell tartalmazzon.',
            'email.unique' => 'Ez az email cím már regisztrálva van.',
            'email.min' => 'Az email cím legalább :min karakter hosszú legyen.',
            'email.max' => 'Az email cím maximum :max karakter hosszú lehet.',
            'phone.required' => 'A telefonszám mező kitöltése kötelező.',
            'phone.regex' => 'A telefonszám csak számokat, szóközöket és kötőjeleket tartalmazhat.',
            'position.required' => 'A beosztás mező kitöltése kötelező.',
            'position.max' => 'A beosztás maximum :max karakter hosszú lehet.',
            'partner_id.required' => 'Partner kiválasztása kötelező',
            'primary_contact.unique' => 'Ehhez a partnerhez már van más elsődleges kapcsolattartó beállítva.'
        ];
    }
}
