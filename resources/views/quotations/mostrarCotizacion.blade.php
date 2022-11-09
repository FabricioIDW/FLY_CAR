@extends('layouts.plantilla')
@section('title', 'Cotización')
@section('titleH1', 'Cotización')

@section('content')
    <h1 class="pt-2 text-center font-bold text-3xl  hover:shadow-sky-600">
        Cotización N°: {{ $quotation->id }}
    </h1>
    @php
        $cols = count($quotation->vehicles) + 1;
    @endphp
    <div class="grid justify-center md:grid-cols-{{ $cols }} lg:grid-cols-{{ $cols }} gap-2 lg:gap-2 my-1">
        @foreach ($quotation->vehicles as $vehiculo)
            <!-- Card 1 -->
            <div class="bg-white rounded-lg border shadow-md max-w-xs md:max-w-none overflow-hidden">
                <img class="h-56 lg:h-60 object-contain" src="{{ $vehiculo->image }}"
                    alt="{{ $vehiculo->vehicleModel->brand->name }} {{ $vehiculo->vehicleModel->name }}" />
            </div>
            <div class="p-3">
                {{-- <span class="text-sm text-primary">November 19, 2022</span> --}}
                <h3 class="font-semibold text-xl leading-6 text-gray-700 my-2">
                    {{ $vehiculo->vehicleModel->brand->name }} {{ $vehiculo->vehicleModel->name }}
                </h3>
                <p class="paragraph-normal text-gray-600">
                    Descripción: {{ $vehiculo->description }}
                </p>
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
                        @endforeach
                    </ul>
                @endif
                </p>
            </div>
    </div>
    @endforeach
    <div class="bg-white rounded-lg border shadow-md max-w-xs md:max-w-none overflow-hidden">
        <h3 class="font-semibold text-xl leading-6 text-gray-700 my-2">
            Datos del cliente:
        </h3>
        <p class="paragraph-normal text-gray-600">
            Nombre y Apellido: {{ $quotation->customer->name }} {{ $quotation->customer->lastName }}
        </p>
        <p class="paragraph-normal text-gray-600">
            DNI: {{ $quotation->customer->dni }}
        </p>
        <p class="paragraph-normal text-gray-600">
            Dirección: {{ $quotation->customer->address }}
        </p>
        <p class="paragraph-normal text-gray-600">
            Email: {{ $quotation->customer->email }}
        </p>
    </div>
    </div>
    <div class="grid justify-center md:grid-cols-1 lg:grid-cols-1 gap-2 lg:gap-2 my-1">
        <p class="paragraph-normal text-gray-600">
            Importe total: ${{ $quotation->finalAmount }}
        </p>
        <p class="paragraph-normal text-gray-600">
            Esta cotización vence el día: {{ $quotation->dateTimeExpiration }}
        </p>
        <p class="paragraph-normal text-gray-600">
            Fecha generada: {{ $quotation->dateTimeGenerated }}
        </p>
        @if ($quotation->reserve)
            <p class="paragraph-normal text-gray-600">
                Esta cotización posee una reserva
            </p>
            <p class="paragraph-normal text-gray-600">
                Fecha de reserva: {{ $quotation->reserve->dateTimeGenerated }}
            </p>
            <p class="paragraph-normal text-gray-600">
                Importe pagado: ${{ $quotation->reserve->amount }} (5% del importe de la cotización)
            </p>
        @endif
        @if ($quotation->reserve && !$quotation->checkVehiclesState())
            @php
                $values = ['action' => 'cancelateReserve', 'amount' => $quotation->reserve->amount];
            @endphp
            <p>Alguno de los vehículos de la cotización sufrio un sinientro. Se debe cancelar la reserva.</p>
            <x-popup openBtn="Cancelar reserva" title="Cancelar reserva" leftBtn="Realizar pago" rightBtn="Cancelar"
            ref="payments.index" :value=$values>
            <p>Monto a pagar: ${{ $values['amount'] }}</p>
        </x-popup>

        @else
            @if (!$quotation->checkVehiclesState())
                <p>No se puede realizar la venta ya que alguno de los vehículos de la cotización sufrio un sinientro.</p>
            @else
                @php
                    $amount = $quotation->reserve ? $quotation->finalAmount - $quotation->reserve->amount : $quotation->finalAmount;
                    $values = ['action' => 'sale', 'amount' => $amount];
                @endphp
                <x-popup openBtn="Realizar venta" title="Venta" leftBtn="Realizar pago" rightBtn="Cancelar"
                    ref="payments.index" :value=$values>
                    <p>Monto a pagar: ${{ $amount }}</p>
                </x-popup>
            @endif
        @endif
    </div>
@endsection
