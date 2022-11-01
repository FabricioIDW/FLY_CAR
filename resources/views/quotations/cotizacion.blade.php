@extends('layouts.plantilla')
@section('title', 'Cotización')
@section('titleH1', 'Simular cotización')

@section('content')
    {{ Auth::user()->customer->hasValidQuotation() }}
    @php $precioFinal = 0; @endphp
    @foreach ($vehiculos as $vehiculo)
        <div class="w-full h-17 pb-4 text-right col-span-4 lg:col-span-2 sm:col-span-1">
            <p class="text-left mx-2">
                <span class="text-xl font-bold">Modelo: </span>{{ $vehiculo->vehicleModel->name }} <br>
                <span class="text-xl font-bold">Marca: </span>{{ $vehiculo->vehicleModel->brand->name }} <br>
                <span class="text-xl font-bold">Año: </span>{{ $vehiculo->year }} <br>
                <span class="text-xl font-bold w-full flex-none mt-2 order-1 text-green-700">Precio: $
                    {{ round($vehiculo->price, 2) }}</span>
                @php $precioFinal += $vehiculo->getPrice(); @endphp
                @if (is_null($vehiculo->offer))
                    <span class="text-green-700 ml-4 font-semibold"> 0 %</span>
                @else
                    <span class="text-red-600 ml-4 font-semibold">{{ $vehiculo->offer->discount }} %</span>
                @endif

            </p>
        </div>
        <div class="col-span-4 lg:col-span-1">
            <h1 class="text-center text-bold text-sm">Accesorios</h1>



            <p class="text-left mx-1 py-0">
                @php
                    $precioFinalAccesorio = 0;
                @endphp
                @if (!empty($colecAccesorios[$vehiculo->id]))
                    @foreach ($colecAccesorios[$vehiculo->id] as $accesorio)
                        <li class="text-sm my-1 font-bold text-left"> {{ $accesorio->name }} </li>
                    @endforeach
                @endif
            </p>
        </div>
        <div class="col-span-4 lg:col-span-1 text-right">
            <h1 class="text-center text-bold text-sm">Precios</h1>
            <p class="text-left mx-1 py-0">
                @if (!empty($colecAccesorios[$vehiculo->id]))
                    @foreach ($colecAccesorios[$vehiculo->id] as $accesorio)
                        <li class="text-sm my-1 font-semibold text-center text-green-700 text-left">$
                            {{ round($accesorio->getPrice($accesorio->getPrice($vehiculo->vehicleModel->accessories[0]->pivot->price)), 2) }}
                            @php $precioFinal += $accesorio->getPrice($accesorio->getPrice($vehiculo->vehicleModel->accessories[0]->pivot->price)); @endphp</li>
                    @endforeach
                @endif
            </p>
        </div>

        <div
            class="w-full mx-3 col-span-3 sm:col-span-4 sm:px-12 sm:col-span-4 lg:px-0 lg:col-span-1  rounded-lg shadow-lg overflow-hidden">
            <img class="w-1/2 rounded-lg " src="{{ $vehiculo->image }}" alt="">
        </div>
    @endforeach
    <div class="pt-4 mx-4 col-span-4 font-extrabold text-2xl text-left text-green-700">
        <p class="mx-10 font-bold"> <span class="font-bold text-black text-left">Importe total: </span> <span
                class="float-right">$ {{ round($precioFinal, 2) }} </span></p>
    </div>
    <div class="capitalice col-span-3 lg:col-span-1 pt-4 pb-4 pr-0 flex justify-end">
        @if (Auth::user())
            @if (Auth::user()->customer->hasValidQuotation())
                <x-popup openBtn="Generar cotización" title="Usted tiene una cotización vigente"
                    leftBtn="Continuar operación" rightBtn="Cancelar operación" ref="quotations.generarCotizacion"
                    value="">
                    <p>
                        ¿Desea continuar con la operacion?
                    </p>
                </x-popup>
            @else
                <a href="{{ route('quotations.generarCotizacion') }}">
                    <x-button-normal openBtn="Generar cotización">
                    </x-button-normal>
                </a>
            @endif
        @else
            <a href="{{ route('login') }}">
                <x-button-normal openBtn="Para generar la cotización debe iniciar sesión."
                    class="text-xs content-center lg:text-sm h-10 px-6 font-semibold hidden:bg-blue-400 rounded-full bg-blue-700 text-white hover:bg-opacity-40 hover:text-blue-700">
                </x-button-normal>
            </a>
        @endif



    </div>
@endsection
