@extends('layouts.plantilla')
@section('title', 'Simular cotización')
@section('titleH1', 'Simular cotización')

@section('content')
    @php
        $precioFinal = 0;
        $cols = count($vehiculos);
    @endphp
    <div class="grid justify-center md:grid-cols-{{ $cols }} lg:grid-cols-{{ $cols }} gap-2 lg:gap-2 my-1">
        @foreach ($vehiculos as $vehiculo)
            <!-- Card 1 -->
            <div class="bg-white rounded-lg border shadow-md max-w-xs md:max-w-none overflow-hidden">
                <img class="h-56 lg:h-60 w-full object-contain " src="{{ $vehiculo->image }}"
                    alt="{{ $vehiculo->vehicleModel->brand->name }} {{ $vehiculo->vehicleModel->name }}" />
                <div class="p-3">
                    {{-- <span class="text-sm text-primary">November 19, 2022</span> --}}
                    <h3 class="font-semibold text-xl leading-6 text-gray-700">
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
                        <p class="paragraph-normal text-red-600">
                            Este vehículo no posee oferta
                        </p>
                    @else
                        <p class="paragraph-normal text-red-600">
                            Actualmente posee una oferta del: {{ $vehiculo->offer->discount }}%
                        </p>
                        <p class="paragraph-normal text-red-600">
                            Precio del vehículo con oferta aplicada: ${{ round($vehiculo->getPrice(), 2) }}
                        </p>
                    @endif
                    </p>
                    <h3 class="font-semibold text-xl leading-6 text-gray-700 my-1 text-center">
                        Accesorios
                    </h3>
                    <p class="paragraph-normal text-gray-600">
                        @php
                            $precioFinalAccesorio = 0;
                        @endphp
                        @if (!empty($colecAccesorios[$vehiculo->id]))
                            <ul>
                                @foreach ($colecAccesorios[$vehiculo->id] as $accesorio)
                                    <li class="text-sm font-semibold text-left">
                                        {{ $accesorio->name }}
                                        {{-- TO DO esto esta mal, muestra otro precio --}}
                                        ${{ round($accesorio->getPrice($vehiculo->vehicleModel->accessories[0]->pivot->price), 2) }}
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
            </div>
        @endforeach
    </div>
    <div class="pt-1 mx-4 col-span-4 font-extrabold text-2xl text-left">
        <span class="float-left">Importe total: ${{ round($precioFinal, 2) }} </span></p>
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
                                Usted tiene una cotización con una reserva válida. Para poder generar otra cotización debe
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
                            {{-- QUE ONDA ESTO?? --}}
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
@endsection
