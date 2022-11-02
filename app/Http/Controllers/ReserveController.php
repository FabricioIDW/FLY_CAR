<?php

namespace App\Http\Controllers;

use App\Models\ExpirationDate;
use App\Models\Quotation;
use App\Models\Reserve;
use Illuminate\Http\Request;

class ReserveController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:reserves.create')->only('create');
    }
    public function create()
    {
        // TO DO
        // Verificar si están seteados los valores que se solicitan del arreglo session 
        // quotation = se debe guardar al momento de seleccionar o generar una cotización
        // payment = se debe gurdar al momento de crear el pago
        // reserve = se debe guardar al momento de presionar el boton de realizar reserva (este objeto reserva solo tiene el monto)
        $reserve = session('reserve');
        $reserve->quotation_id = session('quotation')->id;
        $reserve->payment_id = session('payment')->id;
        $reserve->dateTimeExpiration = ExpirationDate::getExpiration($reserve->dateTimeGenerated, 7);
        session('quotation')->updateTimes($reserve->dateTimeGenerated);
        session()->forget(['payment', 'quotation', 'reserve']);
        $reserve->save();
        return $reserve;
    }
}
