<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['unique:roles,name','required','string','max:255'],
            'permissions' => ['array', 'nullable',],
            'permissions.*' => ['exists:permissions,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'A csoport neve mező kitöltése kötelező.',
            'name.max' => 'A csoport neve mező maximum :max karakter hosszú lehet.',
        ];
    }
}
