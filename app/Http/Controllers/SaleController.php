<?php

namespace App\Http\Controllers;

use App\Exports\SaleExport;
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
        $this->middleware('can:sales.show')->only('showSale');
        $this->middleware('can:sales.report')->only('saleReport');
    }
    public function create($concretized)
    {
        if (session('newSale')) {
            # code...
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
            } else {
                session('quotation')->setVehicles('availabled');
                session('quotation')->setValid(false);
            }
            if (session('quotation')->reserve && session('quotation')->reserve->reserveState == 'enabled') {
                session('quotation')->reserve->setState('canceled');
            }
            session()->forget(['payment', 'quotation']);
            if ($concretized) {
                Alert::success('Venta realizada! Número de venta: ' . $sale->id . '');
                // TO DO generar el excel de la venta
                // $this->saleReport($sale);
                session(['newSale' => false]);
                session(['sale' => $sale]);
                // $this->saleReport($sale);
                return view('sales.show');
            } else {
                Alert::success('Reserva cancelada! El monto de la reserva fue devuelto al cliente.');
                return redirect()->action([ProductController::class, 'catalogo']);
            }
        } else {
            return view('sales.show');
        }
    }
    public function showSale()
    {
        return view('sales.show');
    }
    public function saleReport(Sale $sale)
    {
        // session()->forget(['sale']);
        $collection = Sale::where('id', $sale->id)->get();
        return (new SaleExport($collection))->download('venta_' . $sale->id . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
}
