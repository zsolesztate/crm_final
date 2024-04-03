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
            'fromDate' => ['required', 'date','before_or_equal:toDate', new \App\Rules\DateRangeRule($this->contact->id,$this->fromDate, $this->toDate,$this->vacation->id)],
            'toDate' => ['required', 'date', 'after_or_equal:fromDate', new \App\Rules\DateRangeRule($this->contact->id,$this->fromDate, $this->toDate,$this->vacation->id)],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Az indok mező kitöltése kötelező.',
            'name.regex' => 'Az indok csak betűket, számokat és ékezetes betűket tartalmazhat.',
            'name.min' => 'A indok minimum :min karakter hosszúnak kell lennie.',
            'name.max' => 'A indok maximum :max karakter hosszú lehet.',
            'fromDate.required'  => 'Kezdő dátum kiválasztása kötelező',
            'fromDate.before_or_equal'  => 'Kezdő dátum nem lehet később mint a végső dátum',
            'toDate.required'  => 'Végső dátum kiválasztása kötelező',
            'toDate.after_or_equal'  => 'A végső dátum nem lehet korábbi mint a kezdő dátum.',
        ];
    }
}
