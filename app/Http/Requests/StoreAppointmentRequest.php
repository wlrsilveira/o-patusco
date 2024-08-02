<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentRequest extends FormRequest
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
            'name'   => ['string', 'required', 'max:255'],
            'email'    => ['email:rfc,dns', 'required'],
            'animal_name' => ['string', 'required'],
            'animal_age' => ['integer', 'required'],
            'symptoms' => ['string', 'required'],
            'date' => ['date', 'required'],
            'period' => ['string', 'required'],
            'animal_type_id' => ['integer', 'required','exists:animal_types,id'],
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
        ];
    }
}
