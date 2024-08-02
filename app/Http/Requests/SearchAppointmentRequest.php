<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchAppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'start_date'   => ['string', 'nullable', 'max:255'],
            'end_date'    => ['email:rfc,dns', 'nullable'],
            'animal_type_id' => ['integer', 'nullable','exists:animal_types,id'],
        ];
    }

    public function attributes()
    {
        return [
            'start_date' => 'data inicial',
            'end_date' => 'data final',
            'animal_type_id' => 'tipo de animal',
        ];
    }
}
