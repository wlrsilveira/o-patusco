<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAppointmentRequest extends FormRequest
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
            'name'   => ['string', 'nullable', 'max:255'],
            'email'    => ['email:rfc,dns', 'nullable'],
            'animal_name' => ['string', 'nullable'],
            'animal_age' => ['integer', 'nullable'],
            'symptoms' => ['string', 'nullable'],
            'date' => ['date', 'nullable'],
            'period' => ['string', 'nullable'],
            'animal_type_id' => ['integer', 'nullable','exists:animal_types,id'],
            'doctor_id' => ['integer','exists:users'],
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'nome',
            'email' => 'e-mail',
            'animal_name' => 'nome do animal',
            'animal_age' => 'idade do animal',
            'symptoms' => 'sintomas',
            'date' => 'data',
            'period' => 'período',
            'animal_type_id' => 'tipo de animal',
            'doctor_id' => 'médico',
        ];
    }
}
