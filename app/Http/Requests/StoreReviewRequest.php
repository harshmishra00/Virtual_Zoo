<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    public function authorize(): bool { return auth()->check(); }

    public function rules(): array
    {
        return [
            'animal_id' => ['required', 'exists:animals,id'],
            'rating'    => ['required', 'integer', 'min:1', 'max:5'],
            'title'     => ['required', 'string', 'max:100'],
            'body'      => ['required', 'string', 'min:10', 'max:1000'],
        ];
    }
}
