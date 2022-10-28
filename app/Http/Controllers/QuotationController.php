<?php

namespace App\Http\Controllers;

use App\Models\Accessory;
use App\Models\Customer;
use App\Models\ExpirationDate;
use App\Models\Quotation;
use App\Models\Reserve;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class QuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    public function show(Quotation $quotation)
    {
        // ******Solo de prueba******
        // TO DO
        // Cuando se selecciona una cotización se tiene que guardar en el arreglo session para obtenerlo desde el controlador de reserva o venta 
        $reserve = new Reserve();
        $reserve->amount = $reserve->calculateAmount($quotation->finalAmount);
        session(['reserve' => $reserve]);
        session(['quotation' => $quotation]);
        return view('quotations.index', compact('quotation', 'reserve'));
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

    public function simularCotizacion(Vehicle $vehiculo)
    {
        if (session()->exists('vehiculo1')) {
            $vehiSession1 = session('vehiculo1');
            if ($vehiSession1->id === $vehiculo->id) {
                session(['vehiculo1' => $vehiculo]);
            } else {
                session(['vehiculo2' => $vehiculo]);
            }
        } else {
            session(['vehiculo1' => $vehiculo]);
        }
        return view('quotations.simularCotizacion', compact('vehiculo'));
    }

            ///AGREGAR OTRO VEHICULO
    public function agregarOtroVehiculo(Request $request)
    {
        if ($request->input('btnAgregar') === 'Agregar otro Vehiculo') {
            if (session()->exists('vehiculo1')) {
                session(['accesorio1' => $request->input('accesorios')]);
            }
            $catalogo = new ProductController();
            return $catalogo->catalogo();
        }

        ////SIMULAR COTIZACION

        if ($request->input('btnSimular') === 'Simular Cotizacion') {
            $vehiculos = [];
            $colecAccesorios = [];

            if (session()->exists('vehiculo1')) {
                $vehiculo = session('vehiculo1');
                if (!(session()->exists('accesorio1'))) {
                    $colecAccesorios[$vehiculo->id] = $this->listarAccesorios($request->input('accesorios'));
                } else {
                    $arr = $this->listarAccesorios(session('accesorio1'));
                    $colecAccesorios[$vehiculo->id] = $arr;
                }
                array_push($vehiculos, $vehiculo);
            }


            if (session()->exists('vehiculo2')) {
                $vehiculo2 = session('vehiculo2');
                $arr2 = $this->listarAccesorios($request->input('accesorios'));
                $colecAccesorios[$vehiculo2->id] = $arr2;
                //session(['accesorio2' =>  $request->input('accesorios')]);
                array_push($vehiculos, $vehiculo2);
            }
            session(['accesoriosSelec' =>  $colecAccesorios]);
            session(['vehiculosSelec' =>  $vehiculos]);
            return view('quotations.cotizacion', compact('vehiculos', 'colecAccesorios'));
        }
    }
  ////MI COTIZACION - GENERAR COTIZACION

  public function generarCotizacion(){
if (!session()->exists('user')) {
    if (!session()->exists('quotation')) {
    $quotation = Quotation::create();
    $precioFinal = 0;
   // $quotation = Quotation::find('1');
    $usuario = User::find('1');//session('user');
    $customer = Customer::where('user_id',$usuario->id)->first();///busco usuario de roll cliente
    if (session()->exists('vehiculosSelec')) {
        $vehiculos = session('vehiculosSelec');
        foreach ($vehiculos as $vehiculo) {
            if (session()->exists('accesoriosSelec')) {
                $accesoriosSelec = session('accesoriosSelec');
                foreach ($accesoriosSelec[$vehiculo->id] as $accesorio) {
                    $precioFinal += $accesorio->getPrice($accesorio->getPrice($vehiculo->vehicleModel->accessories[0]->pivot->price));
                    $accesorio->discountStock();
                    $vehiculo->accessoriesQuotation()->attach($accesorio->id, ['quotation_id' => $quotation->id]);
                }
            }
            $vehiculo->setState('reserved');
            $precioFinal += $vehiculo->getPrice();
        }
    }

    //creo una nueva cotizacion

    $quotation->dateTimeExpiration = ExpirationDate::getExpiration((string)$quotation->dateTimeGenerated, 2);
    $quotation->vehicles()->attach($vehiculo->id);
    if ($customer->hasValidQuotation()) {
        
        $customer->disableQuotation();
    }

    $quotation = Quotation::find($quotation->id);
    $quotation->finalAmount = $precioFinal;
    $quotation->customer_id = $customer->id;
    $reserve = new Reserve();
    $reserve->amount = $reserve->calculateAmount($quotation->finalAmount);
    $vehiculos = session('vehiculosSelec');
    $colecAccesorios = session('accesoriosSelec');
    session(['reserve' => $reserve]);
    session(['quotation' => $quotation]);
    return view('quotations.miCotizacion', compact('quotation', 'reserve','vehiculos', 'colecAccesorios'));
    }
    $quotation = session('quotation');//cotizacion a crear
    $reserve = session('reserve');
    //$reserve->amount = $reserve->calculateAmount($quotation->finalAmount);
    $vehiculos = session('vehiculosSelec');
    $colecAccesorios = session('accesoriosSelec');
    session(['reserve' => $reserve]);
    session(['quotation' => $quotation]);
    return view('quotations.miCotizacion', compact('quotation', 'reserve','vehiculos', 'colecAccesorios'));
} else {
    return view('auth.login');
}
   
}



    // Buscador de Cotizaciones 

    public function buscarCotizacion(Request $request){
    $data = ["success" => false];
    if ($request->ajax()) {
        $data = ["success" => true];
    }
    return response()->json($data,200);
    }


    ///CARGA LOS OBJETOS ACCESORIOS AL ARREGLO
    public function listarAccesorios($list)
    {
        $listaAccesorios = [];
        if (!(is_null($list))) {
            foreach ($list as $id) {
                $accesorioObj = Accessory::find($id);
                array_push($listaAccesorios, $accesorioObj);
            }
            return $listaAccesorios;
        }
        return $listaAccesorios;
    }
 
  

}
