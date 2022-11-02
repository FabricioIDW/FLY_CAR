@extends('layouts.plantilla')
@section('title', 'Mi Cotización')
@section('titleH1', 'Mi Cotización')

@section('content')
    @php
        $precioFinal = 0;
        $cols = count($vehiculos);
    @endphp
    <div class="grid justify-center md:grid-cols-{{ $cols }} lg:grid-cols-{{ $cols }} gap-2 lg:gap-2 my-1">
        @foreach ($vehiculos as $vehiculo)
            <!-- Card 1 -->
            <div class="bg-white rounded-lg border shadow-md max-w-xs md:max-w-none overflow-hidden">
                <img class="h-56 lg:h-60 w-full object-cover" src="{{ $vehiculo->image }}"
                    alt="{{ $vehiculo->vehicleModel->brand->name }} {{ $vehiculo->vehicleModel->name }}" />
                <div class="p-3">
                    {{-- <span class="text-sm text-primary">November 19, 2022</span> --}}
                    <h3 class="font-semibold text-xl leading-6 text-gray-700 my-2">
                        {{ $vehiculo->vehicleModel->brand->name }} {{ $vehiculo->vehicleModel->name }}
                    </h3>
                    <p class="paragraph-normal text-gray-600">
                        Año: {{ $vehiculo->year }}
                    </p>
                    <p class="paragraph-normal text-gray-600">
                        Número de chasis: {{ $vehiculo->chassis }}
                    </p>
                    <p class="paragraph-normal text-gray-600">
                        Precio: ${{ round($vehiculo->price, 2) }}
                    </p>
                    @php $precioFinal += $vehiculo->getPrice(); @endphp
                    @if (is_null($vehiculo->offer))
                        <span class="text-green-700 ml-4 font-semibold"> 0 %</span>
                    @else
                        <span class="text-red-600 ml-4 font-semibold">{{ $vehiculo->offer->discount }} %</span>
                    @endif
                    </p>
                    <h3 class="font-semibold text-xl leading-6 text-gray-700 my-2">
                        Accesorios
                    </h3>
                    <p class="paragraph-normal text-gray-600">
                        @php
                            $precioFinalAccesorio = 0;
                        @endphp
                        @if (!empty($colecAccesorios[$vehiculo->id]))
                            <ul>
                                @foreach ($colecAccesorios[$vehiculo->id] as $accesorio)
                                    <li class="text-sm my-1 font-bold text-left">
                                        {{ $accesorio->name }} precio:
                                        {{ round($accesorio->getPrice($accesorio->getPrice($vehiculo->vehicleModel->accessories[0]->pivot->price)), 2) }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </p>
                </div>
            </div>
        @endforeach
    </div>
    <div class="pt-4 mx-4 col-span-4 font-extrabold text-2xl text-left text-green-700">
        <p class="mx-10 font-bold"> <span class="font-bold text-black text-left">Importe total: </span> <span
                class="float-right">$ {{ round($precioFinal, 2) }} </span></p>
    </div>
    {{-- Generar cotización --}}
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
    @endsection
    {{-- 
    
    @extends('layouts.plantilla')
@section('title', 'Cotización')
@section('titleH1', 'Simular cotización')

@section('content')
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

    
    --}}
