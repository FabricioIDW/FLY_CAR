@extends('layouts.plantilla')
@section('title', 'Principal')
@section('titleH1', 'Administrador')

@section('content')
    <div class="content">

        <div class="grid grid-cols-4">
            <div class="mx-auto grid grid-cols-1">
                <div class="text-2xl font-semibold text-center">Productos</div><br>
                <a href="{{ route('productos.create') }}">
                    <x-button value="" openBtn="Crear producto"></x-button>
                </a><br>
                <a href="{{ route('productos.buscar') }}">
                    <x-button value="" openBtn="Buscar producto"></x-button>
                </a>
            </div>
            <div class="mx-auto grid grid-cols-1">
                <div class="text-2xl font-semibold text-center">Ofertas</div><br>

                <a href="{{ route('offers.index') }}">
                    <x-button value="" openBtn="Ver ofertas"></x-button>
                </a>
                <a href="{{ route('offers.create') }}">
                    <x-button value="" openBtn="Crear oferta"></x-button>
                </a>
            </div>
            <div class="mx-auto grid grid-cols-1">
                <div class="text-2xl font-semibold text-center">Estadísticas</div><br>
                <x-button value="" openBtn="Comisiones mensuales"></x-button>
                <br>
                <x-button value="" openBtn="Modelos más vendidos"></x-button>
            </div>
            <div class="mx-auto grid grid-cols-1">
                <div class="text-2xl font-semibold text-center">Reportes</div><br>
                <x-button value="" openBtn="Accesorios más solicitados"></x-button>
                <br>
                <x-button value="" openBtn="Ventas no concretadas"></x-button>
                <br>
                <x-button value="" openBtn="Vehículos más cotizados"></x-button>
            </div>
        </div>


    </div>
@endsection
