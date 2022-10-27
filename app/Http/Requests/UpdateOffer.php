<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOffer extends FormRequest
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
            'discount' => 'required|unique:offers,discount,' . $this->input('id') . ',id,startDate,' . $this->input('startDate') . ',endDate,' . $this->input('endDate'),
            'startDate' => 'required',
            'endDate' => 'required',
        ];
    }
    public function attribute()
    {
        return [
            'discount' => 'descuento',
            'startDate' => 'fecha de inicio',
            'endDate' => 'fecha de fin',
        ];
    }
    public function messages()
    {
        return [
            'discount.required' => 'El descuento de la oferta es obligatorio',
            'discount.unique' => 'Ya existe una oferta con los datos ingresado',
            'discount.min' => 'El descuento mínimo es de 0.01',
            'discount.max' => 'El descuento máximo es de 99.99',
            'startDate.required' => 'La fecha de inicio es obligatoria',
            'endDate.required' => 'La fecha de fin es obligatoria',
        ];
    }
}
