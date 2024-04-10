<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVacationRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:5', 'max:255'],
            'from_date' => ['required', 'date','before_or_equal:from_date', new \App\Rules\DateRangeRule($this->vacation->contact_id,$this->from_date, $this->to_date,$this->vacation->id)],
            'to_date' => ['required', 'date', 'after_or_equal:to_date', new \App\Rules\DateRangeRule($this->vacation->contact_id,$this->from_date, $this->to_date,$this->vacation->id)],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Az indok mező kitöltése kötelező.',
            'name.regex' => 'Az indok csak betűket, számokat és ékezetes betűket tartalmazhat.',
            'name.min' => 'A indok minimum :min karakter hosszúnak kell lennie.',
            'name.max' => 'A indok maximum :max karakter hosszú lehet.',
            'from_date.required'  => 'Kezdő dátum kiválasztása kötelező',
            'from_date.before_or_equal'  => 'Kezdő dátum nem lehet később mint a végső dátum',
            'to_date.required'  => 'Végső dátum kiválasztása kötelező',
            'to_date.after_or_equal'  => 'A végső dátum nem lehet korábbi mint a kezdő dátum.',
        ];
    }
}
