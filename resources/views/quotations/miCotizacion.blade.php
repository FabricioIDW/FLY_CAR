@extends('layouts.plantilla')
@section('title', 'Mi Cotización')
@section('titleH1', 'Mi Cotización')

@section('content')
    @if (session('quotation'))
        @php
            $cols = count(session('quotation')->vehicles);
        @endphp
        <div
            class="bg-white shadow-lg grid justify-center md:grid-cols-2 sm:grid-cols-1 gap-2 lg:gap-2 my-1 flex-none relative rounded-lg">
            {{-- bg-white shadow-lg col-span-2 md:col-span-3 lg:col-span-3 row-span-2 flex-none relative rounded-lg --}}
            @foreach (session('quotation')->vehicles as $vehiculo)
                <!-- Card 1 -->
                <div class="bg-white rounded-lg border shadow-md max-w-xs h-60 ">
                    <img class="h-56 lg:h-60 shadow-lg relative object-contain rounded-lg md:h-40 "
                        src="{{ $vehiculo->image }}"
                        alt="{{ $vehiculo->vehicleModel->brand->name }} {{ $vehiculo->vehicleModel->name }}" />
                </div>
                <div class="p-3">
                    <h3 class="font-semibold text-2xl leading-6 text-gray-700 my-2">
                        {{ $vehiculo->vehicleModel->brand->name }} {{ $vehiculo->vehicleModel->name }}
                        </h2>
                        <p class="paragraph-normal text-gray-600">
                            Año: {{ $vehiculo->year }}
                        </p>
                        <p class="paragraph-normal text-gray-600">
                            Número de chasis: {{ $vehiculo->chassis }}
                        </p>
                        <p class="paragraph-normal text-gray-600">
                            Precio: ${{ round($vehiculo->price, 2) }}
                        </p>
                        @if (count($vehiculo->getAccessoriesFromQuotation(session('quotation')->id)) > 0)
                            <p class="paragraph-normal text-gray-600">
                                Accesorios:
                            <ul>
                                @foreach ($vehiculo->getAccessoriesFromQuotation(session('quotation')->id) as $accessory)
                                    <li>{{ $accessory['name'] }} Precio: {{ $accessory['price'] }}</li>
                                @endforeach
                            </ul>
                        @endif
                        </p>
                </div>
            @endforeach
        </div>
        <div class="grid justify-center md:grid-cols-2 lg:grid-cols-2  sm:grid-cols-1 gap-2 lg:gap-2 my-1 sm:col-span-1">
            <div>
                <p class="text-red-600 pr-8">Esta cotización vence el día {{ session('quotation')->dateTimeExpiration }}hs.
                </p>
                <p class="text-xs">Fecha de creación de la cotización {{ session('quotation')->dateTimeGenerated }} </p>
            </div>
            <div class="sm:text-end text-center">
                <p class="text-2xl">Importe total: <span>$
                        {{ round(session('quotation')->finalAmount, 2) }}</span> </p>
                @if (session('quotation')->reserve)
                    <p>Usted realizó la reserva de esta cotización.</p>
                    <p>La reserva es válida hasta {{ session('quotation')->reserve->dateTimeExpiration }}</p>
                @else
                    @php
                        $values = ['action' => 'reserve', 'amount' => session('reserve')->amount];
                    @endphp
                @endif
            </div>
            <div class="sm:text-start text-center sm:pl-44 pl-0">
                <form action="{{ route('quotations.generatePDF', session('quotation')) }}" method="POST">
                    @csrf
                    <x-jet-button type="submit" name="btnGenerar">Generar PDF
                    </x-jet-button>
                </form>
            </div>
            <div class="sm:text-end text-center">
                <x-popup class="float-right" openBtn="Reservar" title="Reserva" leftBtn="Realizar pago" rightBtn="Cancelar"
                    ref="payments.index" :value=$values>
                    <p>Importe de la cotización: ${{ session('quotation')->finalAmount }}</p>
                    <p>Importe de la seña a pagar: ${{ session('reserve')->amount }}</p>
                    <p>(5% del importe de la cotización)</p>
                </x-popup>
            </div>
        </div>
    @else
        <p>Usted no tiene una cotización vigente</p>
    @endif
@endsection
