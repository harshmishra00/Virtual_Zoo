<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAnimalRequest extends FormRequest
{
    public function authorize(): bool { return auth()->user()->hasAnyRole(['admin', 'staff']); }

    public function rules(): array
    {
        return [
            'name'                => ['required', 'string', 'max:100'],
            'species_id'          => ['required', 'exists:species,id'],
            'enclosure_id'        => ['required', 'exists:enclosures,id'],
            'age'                 => ['nullable', 'integer', 'min:0'],
            'gender'              => ['nullable', 'in:male,female,unknown'],
            'weight_kg'           => ['nullable', 'numeric', 'min:0'],
            'height_cm'           => ['nullable', 'numeric', 'min:0'],
            'diet'                => ['nullable', 'string', 'max:100'],
            'conservation_status' => ['required', 'in:Least Concern,Near Threatened,Vulnerable,Endangered,Critically Endangered,Extinct in Wild'],
            'description'         => ['nullable', 'string'],
            'fun_fact'            => ['nullable', 'string'],
            'arrival_date'        => ['nullable', 'date'],
            'is_featured'         => ['nullable', 'boolean'],
            'thumbnail'           => ['nullable', 'image', 'max:5120'],
            'images.*'            => ['nullable', 'image', 'max:5120'],
        ];
    }
}
