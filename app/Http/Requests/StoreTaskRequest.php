<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string','min:5', 'max:255','unique:projects'],
            'description' => ['required', 'string','min:10', 'max:1000'],
            'users' => ['required', 'array'],
            'users.*' => ['exists:users,id'],
            'contact_id' => ['required', 'integer','exists:contacts,id'],
            'status' => ['required', 'boolean'],
            'start_date' => ['required', 'date'],
            'finnish_date' => ['required', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'A név mező kitöltése kötelező.',
            'name.max' => 'A név maximum :max karakter hosszú lehet.',
            'name.min' => 'A név minimum :min karakter hosszú kell legyen.',
            'name.unique' => 'Már van ilyen nevű projekt.',
            'description.required' => 'A leírás mező kitöltése kötelező.',
            'description.max' => 'A leírás maximum :max karakter hosszú lehet.',
            'description.min' => 'A leírás minimum :min karakter hosszú kell legyen.',
            'users.required' => 'Munkatárs kiválasztása kötelező',
            'contact_id.required' => 'Kapcsolattartó megadása kötelező',
            'start_date.required' => 'Kezdő dátum megadása kötelező',
            'finnish_date.required' => 'Befejező dátum megadása kötelező',
        ];
    }
}
