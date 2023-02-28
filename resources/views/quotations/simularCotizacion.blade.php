@extends('layouts.plantilla')
@section('title', 'Simular cotización')
@section('titleH1', 'Simular cotización')

@section('content')
    @php
        $precioFinal = 0;
        $cols = count($vehiculos);
    @endphp
    <div
        class="bg-white shadow-lg grid justify-center md:grid-cols-2 sm:grid-cols-1 gap-2 lg:gap-2 my-1 sm:px-36 px-0 flex-none relative rounded-lg">
        @foreach ($vehiculos as $vehiculo)
            <!-- Card 1 -->
            <div class="bg-white rounded-lg border shadow-md max-w-xs h-60 relative w-full">
                <img class="h-56 lg:h-60 shadow-lg relative object-contain rounded-lg md:h-40" src="{{ $vehiculo->image }}"
                    alt="{{ $vehiculo->vehicleModel->brand->name }} {{ $vehiculo->vehicleModel->name }}" />
            </div>
            <div class="p-3 ">
                <h3 class="font-semibold text-2xl leading-6 text-gray-700 my-2">
                    {{ $vehiculo->vehicleModel->brand->name }} {{ $vehiculo->vehicleModel->name }}
                    </h2>
                    <p class="paragraph-normal text-gray-600">
                        Año: {{ $vehiculo->year }}
                    </p>
                    <p class="paragraph-normal text-gray-600">
                        Número de chasis: {{ $vehiculo->chassis }}
                    </p>
                    <div class="grid sm:grid-cols-2 grid-cols-1 w-full">
                        <p class="paragraph-normal text-gray-600">
                            Precio:
                        <p class="text-right">
                            ${{ number_format($vehiculo->price, 2, ',', '.') }}
                        </p>
                        </p>
                    </div>
                    @php $precioFinal += $vehiculo->getPrice(); @endphp
                    @if (is_null($vehiculo->offer))
                        <p class="paragraph-normal text-red-600">
                            Este vehículo no posee oferta
                        </p>
                    @else
                        <p class="paragraph-normal text-red-600">
                            Actualmente posee una oferta del: {{ $vehiculo->offer->discount }}%
                        </p>
                        {{-- <p class="paragraph-normal text-red-600">
                            Precio del vehículo con oferta aplicada:
                        <p class="text-right">
                            ${{ number_format($vehiculo->getPrice(), 2, ',', '.') }}
                        </p>
                        </p> --}}
                        <p class="paragraph-normal text-gray-600">
                            Precio del vehículo con oferta aplicada:
                        <p class="text-right text-bold">
                            ${{ number_format($vehiculo->getPrice(), 2, ',', '.') }}
                        </p>
                        </p>
                    @endif
                    </p>
                    @php
                        $precioFinalAccesorio = 0;
                    @endphp
                    @if (!empty($colecAccesorios[$vehiculo->id]))
                        <p class="font-semibold text-gray-600">
                            Accesorios:
                        <ul>
                            @foreach ($colecAccesorios[$vehiculo->id] as $accesorio)
                                {{-- <li class="">
                                        <p class="text-left">{{ $accessory['name'] }} ${{ $accessory['price'] }}</p>
                                    </li> --}}
                                {{-- <li class="paragraph-normal text-gray-600 grid grid-cols-2">
                                    <p class="text-left">{{ $accesorio['name'] }}</p>
                                    <p class="text-right">${{ $accesorio['price'] }}</p>
                                </li> --}}
                                <li class="paragraph-normal text-gray-600 grid grid-cols-2 ">
                                    <p class="text-left ">
                                        {{ $accesorio->name }}
                                    </p>
                                    <p class="text-right text-black">
                                        ${{ round($accesorio->getPrice($vehiculo->vehicleModel->accessories[0]->pivot->price), 2) }}
                                    </p>
                                </li>
                                @php
                                    $precioFinalAccesorio += $accesorio->getPrice($vehiculo->vehicleModel->accessories[0]->pivot->price);
                                @endphp
                            @endforeach
                        </ul>
                    @endif
                    </p>
                    @php
                        $precioFinal += $precioFinalAccesorio;
                    @endphp
            </div>
        @endforeach
    </div>
    <div class="mr-40">
        <div class="sm:text-end text-center">
            <p class="text-2xl">Importe total: <span>$
                    {{ number_format($precioFinal, 2, ',', '.') }}</span> </p>
        </div>
        {{-- Generar cotización --}}
        {{-- capitalice col-span-3 lg:col-span-1 pt-4 pb-4 pr-0 flex justify-end --}}
        <div class="col-span-6 sm:col-span-4 text-right ml-0">
            @if (Auth::user())
                @if (Auth::user()->customer || Auth::user()->seller)
                    @if (Auth::user()->seller)
                        @livewire('customer-data')
                    @else
                        @if (Auth::user()->customer->hasValidQuotation())
                            @if (Auth::user()->customer->getQuotation()->reserve)
                                <p class="paragraph-normal text-red-600">
                                    Usted tiene una cotización con una reserva válida. Para poder generar otra cotización
                                    debe
                                    finalizar
                                    el proceso de compra de manera presencial.
                                </p>
                            @else
                                <x-popup openBtn="Generar cotización" title="Usted tiene una cotización vigente"
                                    leftBtn="Continuar operación" rightBtn="Cancelar operación"
                                    ref="quotations.generarCotizacion" value="">
                                    <p>
                                        ¿Desea continuar con la operacion?
                                    </p>
                                </x-popup>
                            @endif
                        @else
                            <a href="{{ route('quotations.generarCotizacion') }}">
                                <x-jet-button openBtn="Generar cotización">Generar cotización
                                </x-jet-button>
                            </a>
                        @endif
                    @endif
                @endif
            @else
                <span class="float-right">
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">
                        Para generar la cotización debe iniciar sesión
                    </a>
                </span>
            @endif
        </div>
    </div>
@endsection
