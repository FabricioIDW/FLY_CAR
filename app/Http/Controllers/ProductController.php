<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAccessory;
use App\Http\Requests\StoreVehicle;
use App\Models\Accessory;
use App\Models\Brand;
use App\Models\Vehicle;
use App\Models\VehicleModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:vehiculos.buscar')->only('indexVehiculos');
        $this->middleware('can:accesorios.buscar')->only('indexAccesorios');
        $this->middleware('can:productos.buscarVehiculos')->only('searchV');
        $this->middleware('can:productos.buscarAccesorios')->only('searchA');
        $this->middleware('can:vehiculos.editar')->only('ediVehicle');
        $this->middleware('can:accesorios.editar')->only('editAccesory');
        $this->middleware('can:vehiculos.actualizar')->only('updateVehicle');
        $this->middleware('can:accesorios.actualizar')->only('updateAccesory');
        $this->middleware('can:vehiculos.baja')->only('destroyVehicle');
        $this->middleware('can:accesorios.baja')->only('destroyAccesory');
        $this->middleware('can:productos.modelosPorMarca')->only('modelsBrand');
        $this->middleware('can:productos.create')->only('create');
        // $this->middleware('can:accesorios.store')->only('storeAccesory');
        // $this->middleware('can:vehiculos.store')->only('storeVehicle');
        $this->middleware('can:vehiculos.store')->only('storeVehicle');
        $this->middleware('can:accesorios.store')->only('storeAccessory');

        // $this->middleware('can:productos.destroy')->only('destroy_vehicle');

    }

    public function indexVehiculos()
    {
        $vehiculos = Vehicle::where('removed', '=', 'false')->get();
        return view('products.buscarVehiculos', compact('vehiculos'));
    }
    public function indexAccesorios()
    {
        $accesorios = Accessory::where('removed', '=', 'false')->get();
        return view('products.buscarAccesorios', compact('accesorios'));
    }

    public function create()
    {
        $modelos = VehicleModel::all();
        $marcas = Brand::all();

        return view('products/create', compact('modelos', 'marcas'));
    }
    public function modelsBrand(Request $request)
    {
        $output = "";
        $modelos = vehicleModel::where('brand_id', '=', '' . $request->selectMarca . '')->get();
        foreach ($modelos as $model) {
            $output .=
                '<option id="' . $model->id . '" value="' . $model->id . '">' . $model->name . '</option>';
        }
        return response($output);
    }

    public function storeAccessory(Request $request)
    {
        $request->validate([
            "descripcionProducto" => "required",
            "stock" => "required|min:1",
            "name" => "required",
        ]);

        $accesorio = Accessory::create([
            'description' => $request->descripcionProducto,
            'enabled' => $request->selectEstado,
            'name' => $request->nombreA,
            'stock' => $request->stock,
        ]);
        //Obtengo el precio de los modelos seleccionados
        $preciosSeparados = explode('|', $request->modelos);
        foreach ($preciosSeparados as $precioSep) {
            if ($precioSep != "") {
                $modelo = explode('/', $precioSep);
                $m = $modelo[0]; //id del modelo
                $p = $modelo[1]; //precio del accesorio para ese modelo
                $accesorio->models()->attach($m, ['price' => $p]);
            }
        }
        return redirect()->route('accesorios.buscar');
    }

    public function storeVehicle(Request $request)
    {
        $request->validate([
            "descripcionProducto" => "required",
            "price" => "required",
            "anioV" => "required",
            "chassis" => "required|unique:vehicles|min:17|max:17",
            "file" => "image",
            "marcasVehiculos" => "required|not_in:0"
        ]);
        if ($request->file('file')) {
            $imagen = $request->file('file')->store('public/imgVehiculos');
            $url = Storage::url($imagen);
        } else {
            $url = "https://elceo.com/wp-content/uploads/2019/02/coches.jpg";
        }
        $vehiculo = new Vehicle;
        $vehiculo->price = $request->price;
        $vehiculo->description = $request->descripcionProducto;
        $vehiculo->enabled = $request->selectEstado;
        $vehiculo->vehicle_model_id = $request->modeloV;
        $vehiculo->year = $request->anioV;
        $vehiculo->chassis = $request->chassis;
        $vehiculo->image = $url;
        $vehiculo->save();
        return redirect()->route('vehiculos.buscar');
    }

    public function editVehicle(Vehicle $vehiculo)
    {
        $marcas = Brand::all();
        return view('products.editVehicle', compact('vehiculo', 'marcas'));
    }

    public function editAccesory(Accessory $accesorio)
    {
        $modelos = VehicleModel::all();
        return view('products.editAccesory', compact('accesorio', 'modelos'));
    }

    public function updateVehicle(Request $request, Vehicle $vehiculo)
    {
        if ($request->file('file')) {
            $imagen = $request->file('file')->store('public/imgVehiculos');
            $url = Storage::url($imagen);
        } else {
            $url = $vehiculo->image;
        }
        $vehiculo->image = $url;
        $vehiculo->chassis = $request->chassis;
        $vehiculo->price = $request->price;
        $vehiculo->description = $request->descripcionProducto;
        $vehiculo->enabled = $request->selectEstado;
        $vehiculo->vehicle_model_id = $request->modeloV;
        $vehiculo->year = $request->anioV;

        $vehiculo->save();
        return redirect()->route('vehiculos.buscar');
    }

    public function updateAccesory(Request $request, Accessory $accesorio)
    {
        $accesorio->description = $request->descripcionProducto;
        $accesorio->enabled = $request->selectEstado;
        $accesorio->name = $request->nombreA;
        $accesorio->stock = $request->stock;
        $preciosS = explode('|', $request->modelos);
        $i = 0;
        foreach ($preciosS as $precio) {
            if ($precio != "") {
                $modelo = explode('/', $precio);
                $m = intval($modelo[0]); //id del modelo
                $p = floatval($modelo[1]); //precio del accesorio para ese modelo
                if (empty($accesorio->models[$i])) {
                    $accesorio->models()->attach($m, ['price' => $p]);
                } else {
                    $accesorio->models()->updateExistingPivot($m, ['price' => $p]);
                }
                $i++;
            }
        }
        $accesorio->save();

        return redirect()->view('products.editAccesory');
    }

    public function destroyVehicle(Vehicle $vehicle)
    {

        $vehicle->removed = true;
        $vehicle->save();
        return redirect()->route('vehiculos.buscar');
    }
    public function destroyAccesory(Accessory $accesorio)
    {
        $accesorio->removed = true;
        $accesorio->save();
        return redirect()->route('accesorios.buscar');
    }
    public function catalogo()
    {
        //Elimino sessiones 
        session()->forget(['vehiculo1', 'vehiculo2', 'accesorio1', 'accesoriosSelec', 'vehiculosSelec', 'quotation']);
        ///
        $marcas = Brand::all();
        $vehiculos = Vehicle::where('vehicleState', 'availabled')->get();

        return view('catalogo', compact('vehiculos', 'marcas'));
    }
}
