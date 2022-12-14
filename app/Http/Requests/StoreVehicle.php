<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVehicle extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
        //TO DO Cambiar por falso cuando esten hechas las autorizaciones
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'chassis' => 'required|min:17|max:17|unique',
            'price' => 'required',
            'descripcionProducto' => 'required',
            'anioV' => 'required',
        ];
    }
    public function attributes()
    {
        return [
            "descripcionProducto" => "required",
            "price" => "required",
            "anioV" => "required",
            "chassis" => "required|unique:vehicles,chassis," . $this->input('chassis'),
        ];
    }
    public function messages()
    {
        return [
            'chassis.required' => 'El número de chasis del vehículo es obligatorio',
            // 'chassis.min' => 'El número de chasis de ser de 17 caracteres',
            // 'chassis.max' => 'El número de chasis de ser de 17 caracteres',
            'chassis.unique' => 'El numero de chassis ya se encuentra en el sistema',
            'price.required' => 'El precio del vehículo es obligatorio',
            'descripcionProducto.required' => 'La descripción del vehículo es obligatoria',
            'anioV.required' => 'El año del vehículo es obligatorio',
        ];
    }
}
