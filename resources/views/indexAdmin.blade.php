@extends('layouts.plantilla')
@section('title', 'Principal')
@section('titleH1', 'Administrador')

@section('content')
    <div class="content">

        <div class="text-2xl font-semibosld text-center">Productos</div>
        <div class="grid grid-cols-3">
            <div>
                <a href="{{ route('productos.create') }}">
                    <x-button-normal openBtn="Crear producto"></x-button-normal>
                </a>
            </div>
            <div>
                <a href="{{ route('vehiculos.buscar') }}">
                    <x-button-normal openBtn="Buscar vehículos"></x-button-normal>
                </a>
            </div>
            <div>
                <a href="{{ route('accesorios.buscar') }}">
                    <x-button-normal openBtn="Buscar accesorios"></x-button-normal>
                </a>
            </div>
        </div>
    </div>
@endsection
