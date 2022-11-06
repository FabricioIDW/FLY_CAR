@extends('layouts.plantilla')
@section('title', 'Principal')
@section('titleH1', 'Administrador')

@section('content')
    <div class="content">

        <div class="grid grid-cols-4">
            <div class="mx-auto grid grid-cols-1">
                <div class="text-2xl font-semibold text-center">Productos</div><br>

                <a href="{{ route('productos.create') }}">
                    <x-button-normal openBtn="Crear producto"></x-button-normal>
                </a>
                <br>
                <a href="{{ route('vehiculos.buscar') }}">
                    <x-button-normal openBtn="Buscar vehículos"></x-button-normal>
                </a>
                <a href="{{ route('accesorios.buscar') }}">
                    <x-button-normal openBtn="Buscar accesorios"></x-button-normal>
                </a>
            </div>
            <div class="mx-auto grid grid-cols-1">
                <div class="text-2xl font-semibold text-center">Ofertas</div><br>

                <a href="{{ route('offers.index') }}">
                    <x-button-normal openBtn="Ver ofertas"></x-button-normal>
                </a>
                <a href="{{ route('offers.create') }}">
                    <x-button-normal openBtn="Crear oferta"></x-button-normal>
                </a>
            </div>
        </div>
    </div>
@endsection
