<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAnimalRequest extends StoreAnimalRequest
{
    public function rules(): array
    {
        $rules = parent::rules();
        $rules['thumbnail'] = ['nullable', 'image', 'max:5120'];
        return $rules;
    }
}
