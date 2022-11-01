@extends('layouts.plantilla')
@extends('layouts.partials.contenedorMiCotizacion')
@section('title', 'Mi Cotizacion')

@section('contend')
 
@section('contenedorMiCotizacion')
<div class="w-full h-17 pt-2 pb-8 col-span-3 lg:col-span-3">
    <div class="w-full h-8 pt-2 pl-8 col-span-1 lg:col-span-1">
    <a href="{{route('quotations.search')}}">
        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-circle" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
      </svg>
    </a> </div>
    <h1 class="pt-2 text-center uppercase font-bold text-3xl  hover:shadow-sky-600">
    Mi Cotizacion N° {{$quotation->id}}
    </h1> 
</div>
<div class="w-full h-17 pt-2 pb-8 col-span-3 lg:col-span-3"> 
    <p class="float-right text-left mx-2 text-sx">
        <span class="font-bold">Nombre y Apellido: </span>{{$customer->name}} <br>
        <span class="font-bold">DNI: </span>{{$customer->dni}} <br>  
        <span class="font-bold">Direccíon: </span>{{$customer->address}} <br>
        <span class="font-bold">Email: </span>{{$customer->email}} <br>  
    </p>
</div>

@foreach ($vehiculos as $vehiculo)

<div class="w-50% h-17 pb-4 text-right col-span-4 lg:col-span-3 sm:col-span-4">
   <div class="w-100% col-span-4 lg:col-span-3">
    <div class="col-span-3 sm:col-span-1 lg:col-span-1 ">
    <p class="float-left text-left mx-2 col-span-1">
        <span class="text-xl font-bold">Modelo: </span>{{$vehiculo->vehicleModel->name}} <br>
        <span class="text-xl font-bold">Marca: </span>{{$vehiculo->vehicleModel->brand->name}} <br>
        <span class="text-xl font-bold">Año: </span>{{$vehiculo->year}} <br>
        <span class="text-xl font-bold w-full flex-none mt-2 order-1 text-green-700">Precio: $ {{round($vehiculo->price,2)}}</span><span class="text-red-600 ml-4 text-sm font-semibold">{{$vehiculo->offer->discount}} %</span>
        
       </p>
    </div>
       <div class="mx-3 col-span-4 sm:col-span-1 lg:px-0 lg:col-span-1  rounded-lg shadow-2xl overflow-hidden">
        <img class="w-full rounded-lg" src="{{$vehiculo->image}}" alt="">
        </div>
    </div>
<div class="col-span-4 lg:col-span-1">
    <h1 class="ml-3 text-left text-opacity-50  text-sm">Accesorios</h1>
  
  
   
   <p class=" text-left py-0">
    <?php
    if(!(empty($colecAccesorios[$vehiculo->id]))){
    ?>
    @foreach ($colecAccesorios[$vehiculo->id] as $accesorio)
          <li class="text-sm ml-3 my-1 font-bold text-left"> {{$accesorio->name}} <span class="text-sm my-1 font-semibold text-center text-green-700 text-left"> $ {{round($accesorio->getPrice($accesorio->getPrice($vehiculo->vehicleModel->accessories[0]->pivot->price)),2)}} </span></li>
@endforeach
<?php
}
?>
   </p>
   </div>
  


</div>
@endforeach

<div class="py-0 px-12 mx-4 col-span-3 lg:col-span-6 font-bold  text-left">
<p class="text-2xl pr-8 float-right">Importe total: <span >$ {{$quotation->finalAmount}}</span> </p>
<p class="text-red-600 pr-8">Esta cotización vence el día {{ $quotation->dateTimeExpiration}}hs.</p>
<p class="text-xs">Fecha de creación de la cotización {{$quotation->dateTimeGenerated}} </p>
</div>
<div class="capitalice col-span-6 pt-4 pb-4 flex justify-center">
{{-- popup para reserva --}}

@php
$values = ['action' => 'venta', 'amount' => $quotation->finalAmount];
@endphp
<x-popup openBtn="Realizar Venta" title="Venta" leftBtn="Realizar pago" rightBtn="Cancelar" ref="payments.index"
:value=$values>
<p>Importe de la cotización: ${{ $quotation->finalAmount }}</p>
</x-popup>

{{--     
<button class="text-xs  lg:text-sm h-10 px-6 font-semibold rounded-full bg-blue-600 text-white" onclick="parent.location = '{{route('quotations.show', '1')}}'">
    Realizar Reserva
</button> --}}
</div>
@endsection
@endsection