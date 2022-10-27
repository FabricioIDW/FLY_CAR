@extends('layouts.plantilla')
@section('title', 'Principal')
@section('titleH1', 'Administrador')

@section('content')
    <div class="content">

        <div class="grid grid-cols-4">
            <div class="mx-auto grid grid-cols-1">
                <div class="text-2xl font-semibold text-center">Productos</div><br>
                <a href="{{ route('productos.create') }}"><button
                        class="rounded-xl bg-gray-600 font-semibold text-2xl py-6">Crear Producto</button></a><br>
                <a href="{{ route('productos.buscar') }}"><button
                        class="rounded-xl bg-gray-600 font-semibold text-2xl py-6">Buscar Producto</button></a>
            </div>
            <div class="mx-auto grid grid-cols-1">
                <div class="text-2xl font-semibold text-center">Ofertas</div><br>
                
                <a href="{{ route('offers.index') }}">
                    <button class="rounded-xl bg-gray-600 font-semibold text-2xl py-6">Ver ofertas</button>
                </a>
                <a href="{{ route('offers.create') }}">
                    <button class="rounded-xl bg-gray-600 font-semibold text-2xl py-6">Crear Oferta</button><br>
                </a>
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
@endsection
