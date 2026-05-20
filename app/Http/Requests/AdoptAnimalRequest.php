<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdoptAnimalRequest extends FormRequest
{
    public function authorize(): bool { return auth()->check(); }

    public function rules(): array
    {
        return [
            'animal_id'       => ['required', 'exists:animals,id'],
            'duration_months' => ['required', 'in:1,6,12'],
            'message'         => ['nullable', 'string', 'max:500'],
        ];
    }
}
