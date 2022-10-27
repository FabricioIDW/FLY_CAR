@extends('layouts.plantilla')
@section('title', 'Vehiculos')
@section('content')
    <h1>Ofertas de FLY Car</h1>
    <a href="{{ route('vehicles.create') }}">Crear Vehículo</a>
    <ul>
        @foreach ($vehicles as $vehicle)
            <li><a href="{{ route('vehicles.show', $vehicle) }}">Ver</a> <strong>Marca:</strong> {{ $vehicle->vehicleModel->brand->name }} <strong>Modelo:</strong> {{ $vehicle->vehicleModel->name }} <strong>Chasis:</strong> {{ $vehicle->chassis }}</li>
        @endforeach
    </ul>
@endsection
