@extends('layouts.plantilla')
@section('title', 'Mi Cotización')
@section('titleH1', 'Mi Cotización')

@section('content')
    @if (session('quotation'))
        @php
            $cols = count(session('quotation')->vehicles);
        @endphp
        @foreach (session('quotation')->vehicles as $vehiculo)
            <section class="h-screen w-screen bg-gradient-to-br ">
                <div
                    class="grid justify-center md:grid-cols-{{ $cols }} lg:grid-cols-{{ $cols }} gap-2 lg:gap-2 my-10">
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
                            @if (count($vehiculo->accessoriesQuotation) > 0) 
                            <p class="paragraph-normal text-gray-600">
                                Accesorios:
                            <ul>
                                @foreach ($vehiculo->accessoriesQuotation as $accessory)
                                    <li>{{ $accessory->name }}</li>
                                    <li>{{ $accessory->price }}</li>
                                @endforeach
                            </ul>
                            @endif
                            </p>
                        </div>
                    </div>
                </div>
        @endforeach
    @else
        <p>Usted no tiene una cotización vigente</p>
    @endif
    </section>
@endsection
