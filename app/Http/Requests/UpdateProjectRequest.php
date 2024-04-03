<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProjectRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string','min:5', 'max:255',Rule::unique('projects')->ignore($this->project->id)],
            'description' => ['required', 'string','min:10', 'max:1000'],
            'partner_id' => ['required', 'exists:partners,id', 'integer'],
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
            'partner_id.required' => 'Partner kiválasztása kötelező',
        ];
    }
}
