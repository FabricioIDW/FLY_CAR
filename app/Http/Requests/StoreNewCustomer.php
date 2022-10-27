<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNewCustomer extends FormRequest
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
            'dni' => ['required', 'string', 'min:8', 'max:8', 'unique:customers', 'regex:/^([0-9]+)/'],
            'name' => ['required', 'string', 'regex:/^([A-Za-z])/'],
            'lastName' => ['required', 'string', 'regex:/^([A-Za-z])/'],
            'birthDate' => 'required|date',
            'address' => 'required|string',
            'email' => ['required', 'unique:users', 'regex:/^.+@.+$/i'],
            'password' => 'required',
            'password_confirmation' => 'required',
        ];
    }
    public function attribute()
    {
        return [
            'name' => 'nombre',
            'lastName' => 'apellido',
            'birthDate' => 'fecha de nacimiento',
            'address' => 'dirección',
            'password' => 'contraseña',
        ];
    }
    public function messages()
    {
        return [
            'dni.required' => 'El DNI es obligatorio.',
            'dni.min' => 'El DNI debe ser de 8 dígitos (solo números).',
            'dni.max' => 'El DNI debe ser de 8 dígitos (solo números).',
            'dni.unique' => 'El DNI ya se encuentra registrado.',
            'dni.regex' => 'El formato del DNI ingresado no es válido.',
            'name.required' => 'El nombre es obligatorio.',
            'name.regex' => 'El formato del nombre ingresado no es válido.',
            'lastName.required' => 'El apellido es obligatorio.',
            'lastName.regex' => 'El formato del apellido ingresado no es válido.',
            'birthDate.required' => 'La fecha de nacimiento es obligatoria.',
            'address.required' => 'La dirección es obligatoria.',
            'email.required' => 'El email es obligatorio.',
            'email.unique' => 'El email ya se encuentra registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password_confirmation.required' => 'Confirme la contraseña.',
        ];
    }
}
