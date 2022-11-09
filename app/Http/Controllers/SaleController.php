<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Seller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class SaleController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:sales.create')->only('create');
    }
    public function create($concretized)
    {
        $sale = Sale::create([
            'comission' => Sale::calculateComission(session('quotation')->finalAmount),
            'payment_id' => session('payment') ? session('payment')->id : null,
            'quotation_id' => session('quotation')->id,
            'seller_id' => Auth::user()->seller->id,
            'concretized' => $concretized,
        ]);
        // TO DO marcar la venta como no concretada
        if ($concretized) {
            session('quotation')->setVehicles('sold');
            session('quotation')->setValid(false);
        } else {
            session('quotation')->setVehicles('availabled');
            session('quotation')->setValid(false);
        }
        if (session('quotation')->reserve && session('quotation')->reserve->reserveState == 'enabled') {
            session('quotation')->reserve->setState('disabled');
        }
        session()->forget(['payment', 'quotation']);
        if ($concretized) {
            Alert::success('Venta realizada! Número de venta: ' . $sale->id . '.');
        } else {
            Alert::success('Reserva cancelada! El monto de la reserva fue devuelto al cliente.');
        }
        return redirect()->action([ProductController::class, 'catalogo']);
    }
}
