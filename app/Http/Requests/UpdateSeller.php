<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSeller extends FormRequest
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
            'name' => ['required', 'string', 'regex:/^([A-Za-z])/'],
            'lastName' => ['required', 'string', 'regex:/^([A-Za-z])/'],
        ];
    }
    public function attribute()
    {
        return [
            'name' => 'nombre',
            'lastName' => 'apellido',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'name.regex' => 'El formato del nombre ingresado no es válido.',
            'lastName.required' => 'El apellido es obligatorio.',
            'lastName.regex' => 'El formato del apellido ingresado no es válido.',
        ];
    }
}
