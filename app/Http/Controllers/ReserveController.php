<?php

namespace App\Http\Controllers;

use App\Models\ExpirationDate;
use App\Models\Quotation;
use App\Models\Reserve;
use Illuminate\Http\Request;

class ReserveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index(Quotation $quotation)
    // {
    //     $reserve = new Reserve();
    //     $reserve->amount = $reserve->calculateAmount($quotation->finalAmount);
    //     session(['reserve' => $reserve]);
    //     session(['quotation' => $quotation]);
    //     return view('quotations.index', compact('quotation', 'reserve'));
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
