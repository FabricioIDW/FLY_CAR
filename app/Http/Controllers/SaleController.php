<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Seller;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:sales.create')->only('create');
    }
    public function create($concretized)
    {
        // TO DO
        /**
         * Cambiar el seller_id por el id del usuario que tiene la sesion activa (vendedor)
         */
        $sale = Sale::create([
            'comission' => Sale::calculateComission(session('quotation')->finalAmount),
            'payment_id' => session('payment') ? session('payment')->id : null,
            'quotation_id' => session('quotation')->id,
            'seller_id' => Seller::all()->random()->id,
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
        return $sale;
    }
}
