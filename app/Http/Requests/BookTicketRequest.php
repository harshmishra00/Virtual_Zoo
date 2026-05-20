<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookTicketRequest extends FormRequest
{
    public function authorize(): bool { return auth()->check(); }

    public function rules(): array
    {
        return [
            'visit_date'  => ['required', 'date', 'after_or_equal:today'],
            'ticket_type' => ['required', 'in:adult,child,student,family'],
            'quantity'    => ['required', 'integer', 'min:1', 'max:20'],
        ];
    }
}
