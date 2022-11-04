<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomer extends FormRequest
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
            'birthDate' => 'required|date',
            'address' => 'required|string',
            // 'email' => ['required', 'unique:users,email,'.$this->input('email').',email', 'regex:/^.+@.+$/i'],
        ];
    }
    public function attribute()
    {
        return [
            'name' => 'nombre',
            'lastName' => 'apellido',
            'birthDate' => 'fecha de nacimiento',
            'address' => 'dirección',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'name.regex' => 'El formato del nombre ingresado no es válido.',
            'lastName.required' => 'El apellido es obligatorio.',
            'lastName.regex' => 'El formato del apellido ingresado no es válido.',
            'birthDate.required' => 'La fecha de nacimiento es obligatoria.',
            'address.required' => 'La dirección es obligatoria.',
            // 'email.required' => 'El email es obligatorio.',
            // 'email.unique' => 'El email ya se encuentra registrado.',
        ];
    }
}
