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
    public function index()
    {
        $accesorios = Accessory::all();
        $vehiculos = Vehicle::all();
        
        return view('products.buscar', compact('accesorios', 'vehiculos'));
    }

    public function searchV(Request $request){
        $output="";
        $vehiculos = DB::table('vehicles')->
            select('vehicles.id', 'vehicles.chassis', 'brands.name as nombreMarca', 'vehicle_models.name as nombreModelo', 'vehicles.vehicle_model_id', 'vehicle_models.brand_id')->
            join('vehicle_models', 'vehicle_models.id', '=','vehicles.vehicle_model_id')->
            join('brands', 'brands.id', '=', 'vehicle_models.brand_id')->
            where('brands.name', 'like', '%'.$request->searchV.'%')->
            orWhere('vehicle_models.name', 'like', '%'.$request->searchV.'%')->
            orWhere('vehicles.id', 'like', '%'.$request->searchV.'%')->
            get();   
        foreach($vehiculos as $vehiculos)
        {
            $output.= 
            '<tr class="border-b border-gray-200 hover:bg-gray-100">
            <td class="py-3 px-3 text-center whitespace-nowrap">
                                            <div class="items-center">
                                                <div class="mr-2">
                                                    <span class="font-medium">'.$vehiculos->id.'</span>
                                            </div>
            </td>
            <td class="py-3 px-3 text-center whitespace-nowrap">
                                            <div class="items-center">
                                                <div class="mr-2">
                                                    <span class="font-medium">'.
                                                    Brand::find($vehiculos->brand_id)->name
                                                    .'</span>
                                            </div>
            </td>
            <td class="py-3 px-3 text-center whitespace-nowrap">
                                            <div class="items-center">
                                                <div class="mr-2">
                                                    <span class="font-medium">'.
                                                    VehicleModel::find($vehiculos->vehicle_model_id)->name
                                                    .'</span>
                                            </div>
            </td>
            <td class="py-3 px-3 text-center whitespace-nowrap">
                                            <div class="items-center">
                                                <div class="mr-2">
                                                    <span class="font-medium">'.$vehiculos->chassis.'</span>
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
                                                        value="'.$vehiculos->id.'">
                                                        <p>¿Está seguro de eliminar este vehiculo?</p>
                                                    </x-modal>
                                                </div>
            </td>
            </tr>';
        }
        return response($output);
    }

    public function searchA(Request $request){
        $output="";
        $accesorios=Accessory::where('id','Like','%'.$request->searchA.'%')->
        orWhere('stock','Like','%'.$request->searchA.'%')->
        orWhere('name','Like','%'.$request->searchA.'%')->
        get();
        foreach($accesorios as $accesorios)
        {
            $output.= 
            '<tr class="border-b border-gray-200 hover:bg-gray-100">
            <td class="py-3 px-3 text-center whitespace-nowrap">
                                            <div class="items-center">
                                                <div class="mr-2">
                                                    <span class="font-medium">'.$accesorios->id.'</span>
                                            </div>
            </td>
            <td class="py-3 px-3 text-center whitespace-nowrap">
                                            <div class="items-center">
                                                <div class="mr-2">
                                                    <span class="font-medium">'.$accesorios->name.'</span>
                                            </div>
            </td>
            <td class="py-3 px-3 text-center whitespace-nowrap">
                                            <div class="items-center">
                                                <div class="mr-2">
                                                    <span class="font-medium">'.$accesorios->stock.'</span>
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
                                                        value="'.$accesorios->id.'">
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
        $vehiculos = Vehicle::whereNotNull('offer_id');

        return view('products/create', compact('modelos', 'vehiculos', 'marcas'));
    }
    public function modelsBrand(Request $request){
        $output="";
        $modelos = vehicleModel::where('brand_id','=',''.$request->selectMarca.'')->get();
        foreach($modelos as $model){
            $output.= 
            '<option id="'.$model->id.'" value="'.$model->id.'">'.$model->name.'</option>';
        }
        return response($output);
    }

    // public function allModelos(Request $request){
    //     $output = "";
    //     $modelos = vehicleModel::all();
    //     foreach($modelos as $model){
    //         $output.=
    //         '<li>'.$model->name.'</li>';
    //     }
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if($request->tProducto == 0){ // Producto tipo vehiculos
            $vehiculo = new Vehicle;
            $vehiculo->price = $request->precioP; 
            $vehiculo->description = $request->descripcionProducto; 
            $vehiculo->enabled = $request->selectEstado;
            $vehiculo->vehicle_model_id = $request->modeloV;
            $vehiculo->year = $request->anioV;
            $vehiculo->chassis = $request->chasisV;
            $vehiculo->image = $request->imgVehiculo;
            $vehiculo->save();
            return redirect()->route('productos.buscar');

        }else { //Producto tipo Accesorio
            $accesorio = new Accessory;
            $accesorio->price = $request->precioP; 
            $accesorio->description = $request->descripcionP; 
            $accesorio->enabled = $request->selectEstado;
            $accesorio->name = $request->nombreA;
            $accesorio->stock = $request->stock;
            //Obtengo el precio de los modelos seleccionados
            $precios[] = $request->input("modelo");
        }
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
    public function destroy_vehicle($id)
    {
        //
    }
    public function destroy_accesory($id)
    {
        //
    }
    public function catalogo(){
        $vehiculos = Vehicle::where('vehicleState', 'availabled')->get();

        return view('welcome', compact('vehiculos'));
    }
}
