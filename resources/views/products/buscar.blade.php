@extends('layouts.plantilla')
@section('content')
<div class="content">

    {{-- NAVBAR --}}
<div class="m-auto justify-between flex items-center text-gray-700">
    <a href="{{route('admin.index')}}"><button class="block py-3 px-4 mx-2 rounded focus:outline-none hover:bg-gray-200 group">
        <div class="flecha"><div></div></div>{{-- La clase flecha hace la flecha en css --}}
    </button></a>
    <div class="titulos">FLY<br>CAR</div>
    <div>IMAGEN SESION</div>
{{-- END NAVBAR --}}
</div>

<div class="grid grid-cols-2 place-items-center max-h-full">
    {{-- Scroll Vehiculos --}}
<div class="w-11/12">
    <div class="text-2xl font-semibold text-center">Vehiculos</div>
    <div class="text-center"><input type="search" name="buscadorVehiculo" placeholder="ID, marca, modelo..." class="h-6 rounded-xl"></div>
    <div class="scroll-containerChico mx-auto">
        <table class="border-collapse w-full">
            <tr>
                <td>ID</td><td>Marca</td><td>Precio</td>
            </tr>
            @foreach ($vehiculos as $ve)
                <tr>
                    <td>{{$ve->id}}</td><td>{{$ve->vehicle_model_id}}</td><td>{{$ve->price}}</td>
                </tr>
            @endforeach
        </table>
    </div>
    <div class="place-content-center grid grid-cols-2 mx-52">
        <div><button name="eliminarVehiculo" class="rounded-xl bg-gray-700 font-semibold text-2xl py-2 px-7">Eliminar<br>Vehiculo</button></div>
        <div><button name="modificarVehiculo" class="rounded-xl bg-gray-700 font-semibold text-2xl py-2 px-7">Modificar<br>Vehiculo</button></div>
    </div>
</div>

        {{-- Scroll Accesorios --}}
    <div class="w-11/12 mx-auto">
        <div class="text-2xl font-semibold text-center">Accesorios</div>
        <div class="text-center"><input type="search" name="buscadorAccesorio" placeholder="ID, nombre..." class="h-6 rounded-xl"></div>
        <div class="scroll-containerChico mx-auto">
            <table class="border-collapse w-full">
                <tr>
                    <td>ID</td><td>Nombre</td><td>Precio</td>
                </tr>
                @foreach ($accesorios as $acc)
                    <tr>
                        <td>{{$acc->id}}</td><td>{{$acc->name}}</td><td>{{$acc->stock}}</td>
                    </tr>
                @endforeach
            </table>
        </div>
        <div class="place-content-center grid grid-cols-2 mx-52">
            <div><button name="eliminarAccesorio" class="rounded-xl bg-gray-700 font-semibold text-2xl py-2 px-7">Eliminar<br>Accesorio</button></div>
            <div><button name="modificarAccesorio" class="rounded-xl bg-gray-700 font-semibold text-2xl py-2 px-7">Modificar<br>Accesorio</button></div>
        </div>
    </div>

</div>
</div> {{-- Termina div content --}}
@endsection