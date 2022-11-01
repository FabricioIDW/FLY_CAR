@extends('layouts.plantilla')
@section('title', 'Mi Cotizacion')
@section('titleH1', 'Mi Cotizacion')

@section('content')

    @foreach ($vehiculos as $vehiculo)
        <div class="w-50% h-17 pb-4 text-right col-span-4 lg:col-span-3 sm:col-span-4">
            <div class="w-100% col-span-4 lg:col-span-3">
                <div class="col-span-3 sm:col-span-1 lg:col-span-1 ">
                    <p class="float-left text-left mx-2 col-span-1">
                        <span class="text-xl font-bold">Modelo: </span>{{ $vehiculo->vehicleModel->name }} <br>
                        <span class="text-xl font-bold">Marca: </span>{{ $vehiculo->vehicleModel->brand->name }} <br>
                        <span class="text-xl font-bold">Año: </span>{{ $vehiculo->year }} <br>
                        <span class="text-xl font-bold w-full flex-none mt-2 order-1 text-green-700">Precio: $
                            {{ round($vehiculo->price, 2) }}</span><span
                            class="text-red-600 ml-4 text-sm font-semibold">{{ $vehiculo->offer->discount }} %</span>

                    </p>
                </div>
                <div class="mx-3 col-span-4 sm:col-span-1 lg:px-0 lg:col-span-1  rounded-lg shadow-lg overflow-hidden ">
                    <img class="w-full rounded-lg  " src="{{ $vehiculo->image }}" alt="">
                </div>
            </div>
            <div class="col-span-4 lg:col-span-1">
                <h1 class="ml-3 text-left text-opacity-50  text-sm">Accesorios</h1>



                <p class=" text-left py-0">
                    <?php
    if(!(empty($colecAccesorios[$vehiculo->id]))){
    ?>
                    @foreach ($colecAccesorios[$vehiculo->id] as $accesorio)
                        <li class="text-sm ml-3 my-1 font-bold text-left"> {{ $accesorio->name }} <span
                                class="text-sm my-1 font-semibold text-center text-green-700 text-left"> $
                                {{ round($accesorio->getPrice($accesorio->getPrice($vehiculo->vehicleModel->accessories[0]->pivot->price)), 2) }}
                            </span></li>
                    @endforeach
                    <?php
}
?>
                </p>
            </div>



        </div>
    @endforeach

    <div class="py-0 px-12 mx-4 col-span-3 lg:col-span-6 font-bold  text-left">
        <p class="text-2xl pr-8 float-right">Importe total: <span>$ {{ round($quotation->finalAmount, 2) }}</span> </p>
        <p class="text-red-600 pr-8">Esta cotización vence el día {{ $quotation->dateTimeExpiration }}hs.</p>
        <p class="text-xs">Fecha de creación de la cotización {{ $quotation->dateTimeGenerated }} </p>
    </div>
    {{-- popup para reserva --}}
    <div class="capitalice col-span-6 pt-4 pb-4 flex justify-center">
        @if ($quotation->reserve)
            <x-popup openBtn="Reservar" title="Reserva" leftBtn="Ok" rightBtn="Cancelar" ref="home"
                value="{{ $quotation->id }}">
                <p>Ya realizó la reserva de esta cotización.</p>
                <p>La reserva es válida hasta {{ $quotation->reserve->dateTimeExpiration }}</p>
            </x-popup>
        @else
            @php
                $values = ['action' => 'reserve', 'amount' => $reserve->amount];
            @endphp
            <x-popup openBtn="Reservar" title="Reserva" leftBtn="Realizar pago" rightBtn="Cancelar" ref="payments.index"
                :value=$values>
                <p>Importe de la cotización: ${{ $quotation->finalAmount }}</p>
                <p>Importe de la seña a pagar: ${{ $reserve->amount }}</p>
                <p>(5% del importe de la cotización)</p>
            </x-popup>
        @endif
        {{--     
<button class="text-xs  lg:text-sm h-10 px-6 font-semibold rounded-full bg-blue-600 text-white" onclick="parent.location = '{{route('quotations.show', '1')}}'">
    Realizar Reserva
</button> --}}
    </div>
@endsection
