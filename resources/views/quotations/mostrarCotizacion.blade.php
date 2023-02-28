@extends('layouts.plantilla')
@section('title', 'Cotización')
@section('titleH1', 'Cotización')

@section('content')
    <h3 class="pt-2 text-center font-semibold text-2xl  hover:shadow-sky-600">
        Cotización N°: {{ $quotation->id }}
    </h3>
    @php
        $cols = count($quotation->vehicles) + 1;
    @endphp
    <div class="grid justify-center md:grid-cols-2 lg:grid-cols-2 sm:grid-cols-1 gap-2 lg:gap-2 my-1">
        @foreach ($quotation->vehicles as $vehiculo)
            <!-- Card 1 -->
            <div class="bg-white rounded-lg border shadow-md max-w-xs md:max-w-none overflow-hidden sm:px-36 px-0">
                <img class="h-56 lg:h-60 object-contain shadow-lg relative rounded-lg md:h-40n" src="{{ $vehiculo->image }}"
                    alt="{{ $vehiculo->vehicleModel->brand->name }} {{ $vehiculo->vehicleModel->name }}" />
            </div>
            <div class="p-3">
                {{-- <span class="text-sm text-primary">November 19, 2022</span> --}}
                <h3 class="font-semibold text-xl leading-6 text-black">
                    {{ $vehiculo->vehicleModel->brand->name }} {{ $vehiculo->vehicleModel->name }}
                </h3>
                <p class="paragraph-normal text-gray-600">
                    <span class="text-black">Descripción:</span> {{ $vehiculo->description }}
                </p>
                <p class="paragraph-normal text-gray-600">
                    <span class="text-black">Año:</span> {{ $vehiculo->year }}
                </p>
                <p class="paragraph-normal text-gray-600">
                    <span class="text-black">Número de chasis: </span>{{ $vehiculo->chassis }}
                </p>
                <p class="paragraph-normal text-gray-600">
                <p class="text-black text-left">Precio:</p>
                <p class="text-right">${{ number_format($vehiculo->getPrice(), 2, ',', '.') }}</p>
                </p>
                @php
                    $accesorios = $vehiculo->getAccessoriesFromQuotation($quotation->id);
                @endphp
                @if (count($accesorios) > 0)
                    <p class="font-semibold text-1xl text-black">
                        Accesorios:
                    <ul>
                        @foreach ($accesorios as $accessory)
                            <li class="paragraph-normal text-gray-600 grid grid-cols-2">
                                <p class="text-left">{{ $accessory['name'] }}</p>
                                <p class="text-right text-black">${{ $accessory['price'] }}</p>
                            </li>
                        @endforeach
                    </ul>
                @endif
                </p>
            </div>
        @endforeach
    </div>
    <div
        class="bg-white rounded-lg border shadow-md max-w-xs md:max-w-none overflow-hidden grid sm:grid-cols-2 grid-cols-1 w-full">
        <div>
            <h3 class="pl-3 font-semibold text-xl leading-6 text-gray-700 my-2">
                Datos del cliente:
            </h3>
            <p class="pl-3 font-semibold text-black">
                Nombre y Apellido: <span class="text-gray-600">{{ $quotation->customer->name }}
                    {{ $quotation->customer->lastName }}</span>
            </p>
            <p class="pl-3 font-semibold text-black">
                DNI: <span class="text-gray-600">{{ $quotation->customer->dni }}</span>
            </p>
            <p class="pl-3 font-semibold text-black">
                Dirección: <span class="text-gray-600">{{ $quotation->customer->address }}</span>
            </p>
            <p class="pl-3 font-semibold text-black">
                Email: <span class="text-gray-600">{{ $quotation->customer->email }}</span>
            </p>
        </div>
        <div>
            @if ($quotation->reserve)
                <p class="paragraph-normal text-gray-600">
                    Esta cotización posee una reserva
                </p>
                <p class="paragraph-normal text-gray-600">
                    Fecha de reserva: {{ $quotation->reserve->dateTimeGenerated }}
                </p>
                <p class="paragraph-normal text-gray-600">
                    Importe pagado: ${{ number_format($quotation->reserve->amount, 2, ',', '.') }} (5% del importe de la
                    cotización)
                </p>
            @endif
        </div>
    </div>
    </div>
    <div class="grid grid-cols-2">
        <div class="text-left grid justify-center md:grid-cols-1 lg:grid-cols-1 gap-2 lg:gap-2 my-1">
            <p class="paragraph-normal text-red-600">
                Esta cotización vence el día: {{ $quotation->dateTimeExpiration }}
            </p>
            <p class="paragraph-normal text-gray-600">
                Fecha generada: {{ $quotation->dateTimeGenerated }}
            </p>
        </div>
        <div class="text-right grid justify-center md:grid-cols-1 lg:grid-cols-1 gap-2 lg:gap-2 my-1">
            <p class="font-bold text-black text-2xl">
                @php
                    $amount = $quotation->reserve ? $quotation->finalAmount - $quotation->reserve->amount : $quotation->finalAmount;
                @endphp
                Importe total: ${{ number_format($amount, 2, ',', '.') }}
            </p>
        </div>
        <div class="col-span-2 text-center">
            @if ($quotation->reserve && !$quotation->checkVehiclesState())
                @php
                    $values = ['action' => 'cancelateReserve', 'amount' => $quotation->reserve->amount];
                @endphp
                <p class="text-red-600 text-center">Alguno de los vehículos de la cotización sufrio un sinientro. Se
                    debe
                    cancelar la
                    reserva.</p>
                <x-popup openBtn="Cancelar reserva" title="Cancelar reserva" leftBtn="Realizar pago" rightBtn="Cancelar"
                    ref="payments.index" :value=$values>
                    <p>Monto a pagar: ${{ number_format($values['amount'], 2, ',', '.') }}</p>
                </x-popup>
            @else
                @if (!$quotation->checkVehiclesState())
                    <p>No se puede realizar la venta ya que alguno de los vehículos de la cotización sufrio un
                        sinientro.
                    </p>
                @else
                    @php
                        $amount = $quotation->reserve ? $quotation->finalAmount - $quotation->reserve->amount : $quotation->finalAmount;
                        $values = ['action' => 'sale', 'amount' => $amount];
                    @endphp
                    <div class="text-center">
                        <x-popup openBtn="Realizar venta" title="Venta" leftBtn="Realizar pago" rightBtn="Cancelar"
                            ref="payments.index" :value=$values>
                            <p>Monto a pagar: ${{ number_format($amount, 2, ',', '.') }}</p>
                        </x-popup>
                    </div>
                @endif
            @endif
        </div>
    </div>
@endsection
