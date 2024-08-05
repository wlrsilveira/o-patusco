<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchUsersRequest extends FormRequest
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
            'search'   => ['string', 'nullable', 'max:255'],
            'perPage' => ['integer', 'nullable'],
            'page' => ['integer', 'nullable'],

        ];
    }

    public function attributes()
    {
        return [
            'search' => 'busca',
        ];
    }
}
