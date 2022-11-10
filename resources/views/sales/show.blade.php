@extends('layouts.plantilla')
@section('title', 'Venta realizada')
@section('titleH1', 'Venta realizada')

@section('content')
    @if (session()->exists('sale'))
        <h3 class="pt-2 text-center font-semibold text-2xl  hover:shadow-sky-600">
            Venta N°: {{ session('sale')->id }}
        </h3>
        @php
            $cols = count(session('sale')->quotation->vehicles) + 1;
        @endphp
        <div class="grid justify-center md:grid-cols-2 lg:grid-cols-2 sm:grid-cols-1 gap-2 lg:gap-2 my-1">
            @foreach (session('sale')->quotation->vehicles as $vehiculo)
                <!-- Card 1 -->
                <div class="bg-white rounded-lg border shadow-md max-w-xs md:max-w-none overflow-hidden sm:px-36 px-0">
                    <img class="h-56 lg:h-60 object-contain shadow-lg relative rounded-lg md:h-40n"
                        src="{{ $vehiculo->image }}"
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
                        <span class="text-black">Precio:</span> ${{ number_format($vehiculo->getPrice(), 2, ',', '.') }}
                    </p>
                    @php
                        $accesorios = $vehiculo->getAccessoriesFromQuotation(session('sale')->quotation->id);
                    @endphp
                    @if (count($accesorios) > 0)
                        <p class="font-semibold text-1xl text-black">
                            Accesorios:
                        <ul>
                            @foreach ($accesorios as $accessory)
                                <li class="paragraph-normal text-gray-600 grid grid-cols-2">
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
        <div
            class="bg-white rounded-lg border shadow-md max-w-xs md:max-w-none overflow-hidden grid sm:grid-cols-2 grid-cols-1 w-full">
            <div>
                <h3 class="pl-3 font-semibold text-xl leading-6 text-gray-700 my-2">
                    Datos del cliente:
                </h3>
                <p class="pl-3 font-semibold text-black">
                    Nombre y Apellido: <span class="text-gray-600">{{ session('sale')->quotation->customer->name }}
                        {{ session('sale')->quotation->customer->lastName }}</span>
                </p>
                <p class="pl-3 font-semibold text-black">
                    DNI: <span class="text-gray-600">{{ session('sale')->quotation->customer->dni }}</span>
                </p>
                <p class="pl-3 font-semibold text-black">
                    Dirección: <span class="text-gray-600">{{ session('sale')->quotation->customer->address }}</span>
                </p>
                <p class="pl-3 font-semibold text-black">
                    Email: <span class="text-gray-600">{{ session('sale')->quotation->customer->email }}</span>
                </p>
            </div>
            <div>
                <h3 class="pl-3 font-semibold text-xl leading-6 text-gray-700 my-2">
                    Datos del vendedor:
                </h3>
                <p class="pl-3 font-semibold text-black">
                    Nombre y Apellido: <span class="text-gray-600">{{ session('sale')->seller->name }}
                        {{ session('sale')->seller->lastName }}</span>
                </p>
                <p class="pl-3 font-semibold text-black">
                    DNI: <span class="text-gray-600">{{ session('sale')->seller->dni }}</span>
                </p>
                <p class="pl-3 font-semibold text-black">
                    Comisión: <span
                        class="text-gray-600">${{ number_format(session('sale')->comission, 2, ',', '.') }}</span>
                </p>
            </div>
        </div>
        <div class="text-center">
            @php
                $sale = session('sale');
            @endphp
            <a href="{{ route('sales.report', $sale) }}">
                <x-jet-button>Generar excel de la venta</x-jet-button>
            </a>
        </div>
    @endif

@endsection
