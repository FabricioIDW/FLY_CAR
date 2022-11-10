<?php

namespace App\Http\Controllers;

use App\Exports\QuotationExport;
use App\Http\Livewire\QuotationSearch;
use App\Models\Accessory;
use App\Models\Customer;
use App\Models\ExpirationDate;
use App\Models\Quotation;
use App\Models\Reserve;
use App\Models\User;
use App\Models\Vehicle;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class QuotationController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:quotations.generarCotizacion')->only('generarCotizacion');
        $this->middleware('can:quotations.miCotizacion')->only('miCotizacion');
        $this->middleware('can:quotations.search')->only('buscarCotizacion');
        $this->middleware('can:quotations.seeQuotation')->only('mostrarQuotation');
    }
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

    public function simularCotizacion(Vehicle $vehiculo)
    {
        if ($vehiculo->vehicleState == 'sold' || $vehiculo->vehicleState == 'reserved') {
            return redirect()->action([ProductController::class, 'catalogo']);
        }
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
        return view('quotations.vehiculoSeleccionado', compact('vehiculo'));
    }

    ///AGREGAR OTRO VEHICULO
    public function agregarOtroVehiculo(Request $request)
    {
        if ($request->input('btnAgregar') === 'Agregar otro Vehiculo') {
            if (session()->exists('vehiculo1')) {
                session(['accesorio1' => $request->input('accesorios')]);
            }

            $vehiculos = Vehicle::where('vehicleState', 'availabled')->get();
            return view('catalogo', compact('vehiculos'));
        }

        //SIMULAR COTIZACION

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
                if (session()->exists('vehiculo2')) {
                    $vehiculo2 = session('vehiculo2');
                    $arr2 = $this->listarAccesorios($request->input('accesorios'));
                    $colecAccesorios[$vehiculo2->id] = $arr2;
                    //session(['accesorio2' =>  $request->input('accesorios')]);
                    array_push($vehiculos, $vehiculo2);
                }
            }

            session(['accesoriosSelec' =>  $colecAccesorios]);
            session(['vehiculosSelec' =>  $vehiculos]);
            return view('quotations.simularCotizacion', compact('vehiculos', 'colecAccesorios'));
        }
    }
    //MI COTIZACION - GENERAR COTIZACION

    public function generarCotizacion()
    {
        if (!session()->exists('quotation')) {
            $quotation = Quotation::create();
            // $quotation = Quotation::find($quotation->id);
            $precioFinal = 0;
            if (session()->exists('vehiculosSelec')) {
                foreach (session('vehiculosSelec') as $vehiculo) {
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
                    $quotation->vehicles()->attach($vehiculo->id);
                }
            }
            $quotation->dateTimeExpiration = ExpirationDate::getExpiration($quotation->dateTimeGenerated, 2);
            if (Auth::user()->customer->hasValidQuotation()) {
                Auth::user()->customer->getQuotation()->setVehicles('availabled');
                // TO DO Aumentar el stock del accesorio
                Auth::user()->customer->disableQuotation();
            }
            $quotation->finalAmount = $precioFinal;
            $quotation->customer_id = Auth::user()->customer->id;
            $quotation->save();
            $quotation = Quotation::find($quotation->id);
            $reserve = new Reserve();
            $reserve->amount = $reserve->calculateAmount($quotation->finalAmount);
            $vehiculos = session('vehiculosSelec');
            $colecAccesorios = session('accesoriosSelec');
            session(['reserve' => $reserve]);
            session(['quotation' => $quotation]);
            session()->forget(['vehiculo1', 'vehiculo2', 'accesorio1', 'accesoriosSelec', 'vehiculosSelec']);
            Alert::success('La cotización de genero correctamente.');
        } else {
            $quotation = session('quotation');
            $reserve = session('reserve');
            $vehiculos = session('vehiculosSelec');
            $colecAccesorios = session('accesoriosSelec');
        }
        return view('quotations.miCotizacion', compact('quotation', 'reserve', 'vehiculos', 'colecAccesorios'));
    }

    public function generarCotizacionVendedor()
    {
        // Probando
        if (session()->exists('customer_id')) {
            # code...
            $quotation = $this->createQuotation();
            $quotation->customer_id = session('customer_id');
            $quotation->save();
            session(['quotation' => $quotation]);
            session()->forget('customer_id');
            Alert::success('La cotización de genero correctamente.');
        } else {
            $quotation = session('quotation');
        }
        return view('quotations.mostrarCotizacion', compact('quotation'));
    }

    private function createQuotation()
    {
        $quotation = Quotation::create();
        $precioFinal = 0;
        if (session()->exists('vehiculosSelec')) {
            foreach (session('vehiculosSelec') as $vehiculo) {
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
                $quotation->vehicles()->attach($vehiculo->id);
            }
        }
        $quotation->finalAmount = $precioFinal;
        $quotation->dateTimeExpiration = ExpirationDate::getExpiration($quotation->dateTimeGenerated, 2);
        return $quotation;
    }

    // Buscar mi cotizacion
    public function miCotizacion()
    {
        if (!session('quotation')) {
            $quotation = Quotation::where('customer_id', Auth::user()->customer->id)->where('valid', 1)->first();
            if ($quotation) {
                $reserve = new Reserve();
                $reserve->amount = $reserve->calculateAmount($quotation->finalAmount);
                session(['quotation' => $quotation]);
                session(['reserve' => $reserve]);
            }
        }
        return view('quotations.miCotizacion');
    }

    // Buscador de Cotizaciones 

    public function buscarCotizacion(Request $request)
    {
        $data = ["success" => false];
        if ($request->ajax()) {
            $data = ["success" => true];
        }
        return response()->json($data, 200);
    }

    //Mostrar cotizacion

    public function mostrarQuotation(Quotation $quotation)
    {
        $colecAccesorios = [];
        $vehiculos = $quotation->vehicles;
        foreach ($vehiculos as $vehiculo) {
            $colecAccesorios[$vehiculo->id] = $vehiculo->accessoriesQuotation;
        }
        $customer = $quotation->customer;
        $reserve = new Reserve();
        $reserve->amount = $reserve->calculateAmount($quotation->finalAmount);
        session(['quotation' => $quotation]);
        return view('quotations.mostrarCotizacion', compact('quotation', 'vehiculos', 'colecAccesorios', 'customer', 'reserve'));
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

    public function generateQuotationPDF(Quotation $quotation)
    {
        // return  $quotation->customer;
        $collection = Quotation::where('id', $quotation->id)->get();
        return (new QuotationExport($collection))->download('mi_cotizacion.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
}
