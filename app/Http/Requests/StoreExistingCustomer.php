<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExistingCustomer extends FormRequest
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
            'dni' => ['required', 'string', 'min:8', 'max:8', 'exists:customers,dni', 'regex:/^([0-9]+)/'],
            'email' => ['required', 'exists:customers,email', 'regex:/^.+@.+$/i'],
            'password' => 'required',
            'password_confirmation' => 'required',
        ];
    }
    public function attribute()
    {
        return [
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
            'dni.exists' => 'El DNI ingresado no pertenece a un cliente que no posee una cuenta.',
            'dni.regex' => 'El formato del DNI ingresado no es válido.',
            'email.required' => 'El email es obligatorio.',
            'email.exists' => 'El email ingresado no pertenece a un cliente que no posee una cuenta.',
            'password.required' => 'La contraseña es obligatoria.',
            'password_confirmation.required' => 'Confirme la contraseña.',
        ];
    }
}
