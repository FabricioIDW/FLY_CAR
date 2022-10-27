@extends('layouts.plantilla')
@section('content')
<div class="content">

    {{-- NAVBAR --}}
<div class="m-auto justify-between flex items-center text-gray-700">
    <a href=""><button class="block py-3 px-4 mx-2 rounded focus:outline-none hover:bg-gray-200 group">
        <div class="w-5 h-1 bg-gray-600 mb-1"></div>
        <div class="w-5 h-1 bg-gray-600 mb-1"></div>
        <div class="w-5 h-1 bg-gray-600"></div>
    </button></a>
    <div class="titulos">FLY<br>CAR</div>
    <div>IMAGEN SESION</div>
</div>
{{-- END NAVBAR --}}

<div class="grid grid-cols-4">
<div class="mx-auto grid grid-cols-1">
    <div class="text-2xl font-semibold text-center">Productos</div><br>
    <a href="{{route('productos.create')}}"><button class="rounded-xl bg-gray-600 font-semibold text-2xl py-6">Crear Producto</button></a><br>
    <a href="{{route('productos.buscar')}}"><button class="rounded-xl bg-gray-600 font-semibold text-2xl py-6">Buscar Producto</button></a>
</div>
<div class="mx-auto grid grid-cols-1">
    <div class="text-2xl font-semibold text-center">Ofertas</div><br>
    <button class="rounded-xl bg-gray-600 font-semibold text-2xl py-6">Crear Oferta</button><br>
    <button class="rounded-xl bg-gray-600 font-semibold text-2xl py-6">Eliminar Oferta</button>
</div>
<div class="mx-auto grid grid-cols-1">
    <div class="text-2xl font-semibold text-center">Estadisticas</div><br>
    <button class="rounded-xl bg-gray-600 font-semibold text-2xl py-6">Comisiones mensuales</button><br>
    <button class="rounded-xl bg-gray-600 font-semibold text-2xl py-6">Modelos mas vendidos</button>
</div>
<div class="mx-auto grid grid-cols-1">
    <div class="text-2xl font-semibold text-center">Reportes</div><br>
    <button class="rounded-xl bg-gray-600 font-semibold text-2xl py-6">Accesorio más solicitado</button><br>
    <button class="rounded-xl bg-gray-600 font-semibold text-2xl py-6">Ventas no concretadas</button><br>
    <button class="rounded-xl bg-gray-600 font-semibold text-2xl py-6">Vehiculos más cotizados</button>
</div>
</div>


</div>