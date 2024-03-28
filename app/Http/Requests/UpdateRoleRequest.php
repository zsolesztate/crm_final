<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRoleRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('roles')->ignore($this->role->id)],
            'permissions' =>['array','nullable'],
            'permissions.*' => ['exists:permissions,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'A csoport neve mező kitöltése kötelező.',
            'name.max' => 'A csoport neve mező maximum :max karakter hosszú lehet.',
            'name.unique' => 'Ez a csoport név már foglalt.',
        ];
    }
}

