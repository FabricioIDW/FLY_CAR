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
        if ($concretized) {
            session('quotation')->setVehicles('sold');
            session('quotation')->setValid(false);
        }
        if (session('quotation')->reserve && session('quotation')->reserve->reserveState == 'enabled') {
            session('quotation')->reserve->setState('disabled');
        }
        session()->forget(['payment', 'quotation']);

        /**
         * TO DO 
         * 
         * REVISAR ESTO, SE DEBERÍA REDIRECCIONAR SIN TENER QUE HACER LO MISMO QUE EN ProductController catalogo()
         */
        
        session()->forget(['vehiculo1', 'vehiculo2', 'accesorio1', 'accesoriosSelec', 'vehiculosSelec', 'quotation']);
        $vehiculos = Vehicle::where('vehicleState', 'availabled')->get();

        Alert::success('Venta realizada! Número de venta: ' . $sale->id . '.');
        return view('welcome', compact('vehiculos'));
    }
}
