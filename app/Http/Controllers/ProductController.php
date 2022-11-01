<?php

namespace App\Http\Controllers;

use App\Models\Accessory;
use App\Models\Brand;
use App\Models\Vehicle;
use App\Models\VehicleModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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

    public function searchV(Request $request)
    {
        $output = "";
        $vehiculos = DB::table('vehicles')->select('vehicles.id', 'vehicles.chassis', 'brands.name as nombreMarca', 'vehicle_models.name as nombreModelo', 'vehicles.vehicle_model_id', 'vehicle_models.brand_id')->join('vehicle_models', 'vehicle_models.id', '=', 'vehicles.vehicle_model_id')->join('brands', 'brands.id', '=', 'vehicle_models.brand_id')->where('brands.name', 'like', '%' . $request->searchV . '%')->orWhere('removed', '=', 'false')->orWhere('vehicle_models.name', 'like', '%' . $request->searchV . '%')->orWhere('vehicles.id', 'like', '%' . $request->searchV . '%')->get();
        foreach ($vehiculos as $vehiculos) {
            $output .=
                '<tr class="border-b border-gray-200 hover:bg-gray-100">
            <td class="py-3 px-3 text-center whitespace-nowrap">
                                            <div class="items-center">
                                                <div class="mr-2">
                                                    <span class="font-medium">' . $vehiculos->id . '</span>
                                            </div>
            </td>
            <td class="py-3 px-3 text-center whitespace-nowrap">
                                            <div class="items-center">
                                                <div class="mr-2">
                                                    <span class="font-medium">' .
                Brand::find($vehiculos->brand_id)->name
                . '</span>
                                            </div>
            </td>
            <td class="py-3 px-3 text-center whitespace-nowrap">
                                            <div class="items-center">
                                                <div class="mr-2">
                                                    <span class="font-medium">' .
                VehicleModel::find($vehiculos->vehicle_model_id)->name
                . '</span>
                                            </div>
            </td>
            <td class="py-3 px-3 text-center whitespace-nowrap">
                                            <div class="items-center">
                                                <div class="mr-2">
                                                    <span class="font-medium">' . $vehiculos->chassis . '</span>
                                            </div>
            </td>
            <td class="py-3 px-3 text-center">
                                            <div class="flex item-center justify-center">
                                                <a href="">
                                                    <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                        </svg>
                                                    </div>
                                                </a>
                                                <div class="overflow-x-auto">
                                                    <x-modal openBtn="Eliminar" title="Eliminar vehiculo" leftBtn="Eliminar"
                                                        rightBtn="Cancelar" ref="productos_vehiculos.destroy"
                                                        value="' . $vehiculos->id . '">
                                                        <p>¿Está seguro de eliminar este vehiculo?</p>
                                                    </x-modal>
                                                </div>
            </td>
            </tr>';
        }
        return response($output);
    }

    public function searchA(Request $request)
    {
        $output = "";
        $accesorios = Accessory::where('id', 'Like', '%' . $request->searchA . '%')->orWhere('removed', '=', 'false')->orWhere('stock', 'Like', '%' . $request->searchA . '%')->orWhere('name', 'Like', '%' . $request->searchA . '%')->get();
        foreach ($accesorios as $accesorios) {
            $output .=
                '<tr class="border-b border-gray-200 hover:bg-gray-100">
            <td class="py-3 px-3 text-center whitespace-nowrap">
                                            <div class="items-center">
                                                <div class="mr-2">
                                                    <span class="font-medium">' . $accesorios->id . '</span>
                                            </div>
            </td>
            <td class="py-3 px-3 text-center whitespace-nowrap">
                                            <div class="items-center">
                                                <div class="mr-2">
                                                    <span class="font-medium">' . $accesorios->name . '</span>
                                            </div>
            </td>
            <td class="py-3 px-3 text-center whitespace-nowrap">
                                            <div class="items-center">
                                                <div class="mr-2">
                                                    <span class="font-medium">' . $accesorios->stock . '</span>
                                            </div>
            </td>
            <td class="py-3 px-3 text-center">
                                            <div class="flex item-center justify-center">
                                                <a href="">
                                                    <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                        </svg>
                                                    </div>
                                                </a>
                                                <div class="overflow-x-auto">
                                                    <x-modal openBtn="Eliminar" title="Eliminar vehiculo" leftBtn="Eliminar"
                                                        rightBtn="Cancelar" ref="productos_vehiculos.destroy"
                                                        value="' . $accesorios->id . '">
                                                        <p>¿Está seguro de eliminar este vehiculo?</p>
                                                    </x-modal>
                                                </div>
            </td>
            </tr>';
        }
        return response($output);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->tProducto == 0) { // Producto tipo vehiculos
            $vehiculo = new Vehicle;
            $vehiculo->price = $request->precioP;
            $vehiculo->description = $request->descripcionProducto;
            $vehiculo->enabled = $request->selectEstado;
            $vehiculo->vehicle_model_id = $request->modeloV;
            $vehiculo->year = $request->anioV;
            $vehiculo->chassis = $request->chasisV;
            $vehiculo->image = $request->imgVehiculo;
            $vehiculo->save();
            return redirect()->route('vehiculos.buscar');
        } else { //Producto tipo Accesorio
            $accesorio = Accessory::create([
                'description' => $request->descripcionProducto,
                'enabled' => $request->selectEstado,
                'name' => $request->nombreA,
                'stock' => $request->stock,
                'image' => "img",
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
        $vehiculo->chassis = $request->chassis;
        $vehiculo->price = $request->precioP;
        $vehiculo->description = $request->descripcionProducto;
        $vehiculo->enabled = $request->selectEstado;
        $vehiculo->vehicle_model_id = $request->modeloV;
        $vehiculo->year = $request->anioV;
        $vehiculo->image = $request->imgVehiculo;

        $vehiculo->save();
        return redirect()->view('vehiculos.buscar');

        //     $file = $_FILES['file'][''.$vehiculo->image.''];

        //     if ($file != '') {
        //         move_uploaded_file($_FILES['file']['tmp_name'], '/image/' . $file);
        //     } else {
        //         $file = $oldfile;
        //     }
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

        return redirect()->route('accesorios.buscar');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyVehicle(Vehicle $vehiculo)
    {
        $vehiculo->update([
            'removed' => true,
        ]);
        return redirect()->route('vehiculos.buscar');
    }
    public function destroyAccesory(Accessory $accesorio)
    {
        $accesorio->update([
            'removed' => true,
        ]);
        return redirect()->route('accesorios.buscar');
    }
    public function catalogo()
    {
        //Elimino sessiones 
        session()->forget(['vehiculo1', 'vehiculo2', 'accesorio1', 'accesoriosSelec', 'vehiculosSelec', 'quotation']);
        ///
        $vehiculos = Vehicle::where('vehicleState', 'availabled')->get();

        return view('welcome', compact('vehiculos'));
    }
}
