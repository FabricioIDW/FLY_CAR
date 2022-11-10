@extends('layouts.plantilla')
@section('title', 'Mi Cotización')
@section('titleH1', 'Mi Cotización')

@section('content')
    @if (session('quotation'))
        @php
            $cols = count(session('quotation')->vehicles);
        @endphp
        <div
            class="bg-white shadow-lg grid justify-center md:grid-cols-2 sm:grid-cols-1 gap-2 lg:gap-2 my-1 sm:px-36 px-0 flex-none relative rounded-lg">
            {{-- bg-white shadow-lg col-span-2 md:col-span-3 lg:col-span-3 row-span-2 flex-none relative rounded-lg --}}
            @foreach (session('quotation')->vehicles as $vehiculo)
                <!-- Card 1 -->
                <div class="bg-white rounded-lg border shadow-md max-w-xs h-60 relative w-full">
                    <img class="h-56 lg:h-60 shadow-lg relative object-contain rounded-lg md:h-40"
                        src="{{ $vehiculo->image }}"
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
                        </p>
                        <p class="paragraph-normal text-gray-600">${{ number_format($vehiculo->getPrice(), 2, ',', '.') }}</p>
                    </div>
                        @if (count($vehiculo->getAccessoriesFromQuotation(session('quotation')->id)) > 0)
                            <p class="font-semibold text-gray-600">
                                Accesorios:
                            <ul>
                                @foreach ($vehiculo->getAccessoriesFromQuotation(session('quotation')->id) as $accessory)
                                    <li class="grid sm:grid-cols-2 grid-cols-1">
                                        <p class="text-left">{{ $accessory['name'] }}</p>
                                        <p class="text-right">${{ $accessory['price'] }}</p>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                        </p>
                </div>
            @endforeach
        </div>
        <div class="grid justify-center md:grid-cols-2 lg:grid-cols-2  sm:grid-cols-1 gap-2 lg:gap-2 my-1 sm:col-span-1">
            <div class="h-fit">
                <p class="text-red-600">Esta cotización vence el día {{ session('quotation')->dateTimeExpiration }}hs.
                </p>
                <p class="text-xs py-0">Fecha de creación de la cotización {{ session('quotation')->dateTimeGenerated }}
                </p>
                <span class="sm:text-start text-center">
                    <form action="{{ route('quotations.generatePDF', session('quotation')) }}" method="POST">
                        @csrf
                        <x-jet-button type="submit" name="btnGenerar">Generar PDF
                        </x-jet-button>
                    </form>
                </span>
            </div>
            <div class="sm:text-end text-center">
                <p class="text-2xl">Importe total: <span>$
                        {{ number_format(session('quotation')->finalAmount, 2, ',', '.') }}</span> </p>
                @if (session('quotation')->reserve)
                    <p>Usted realizó la reserva de esta cotización.</p>
                    <p>La reserva es válida hasta {{ session('quotation')->reserve->dateTimeExpiration }}</p>
                @else
                    @php
                        $values = ['action' => 'reserve', 'amount' => session('reserve')->amount];
                    @endphp
                    <div class="sm:text-end text-center">
                        <x-popup class="float-right" openBtn="Reservar" title="Reserva" leftBtn="Realizar pago"
                            rightBtn="Cancelar" ref="payments.index" :value=$values>
                            <p>Importe de la cotización:
                                ${{ number_format(session('quotation')->finalAmount, 2, ',', '.') }}</p>
                            <p>Importe de la seña a pagar: ${{ number_format(session('reserve')->amount, 2, ',', '.') }}
                            </p>
                            <p>(5% del importe de la cotización)</p>
                        </x-popup>
                    </div>
                @endif
            </div>
            {{-- <div class="sm:text-left text-center sm:pl-0 pl-44">
                <form action="{{ route('quotations.generatePDF', session('quotation')) }}" method="POST">
                    @csrf
                    <x-jet-button type="submit" name="btnGenerar">Generar PDF
                    </x-jet-button>
                </form>
            </div> --}}

        </div>
    @else
        <p>Usted no tiene una cotización vigente</p>
    @endif
@endsection
