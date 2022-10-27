@extends('layouts.plantilla')
@section('title', 'Vehiculos')
@section('titleH1', 'Vehículos de FLY CAR')
@section('content')
    @can('vehicles.create')
        <a href="{{ route('vehicles.create') }}">
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Crear vehículo
          </button>
        </a>
    @endcan
    <table class="min-w-max w-full table-auto">
        <thead>
            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <th class="py-3 px-6 text-left">Marca</th>
                <th class="py-3 px-6 text-left">Modelo</th>
                <th class="py-3 px-6 text-left">Nro. Chasis</th>
                <th class="py-3 px-6 text-center">Acciones</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 text-sm font-light">
            @foreach ($vehicles as $vehicle)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="mr-2">
                                <span class="font-medium">{{ $vehicle->vehicleModel->brand->name }}</span>
                            </div>
                    </td>
                    <td class="py-3 px-6 text-left">
                        <div class="flex items-center">
                            <span>{{ $vehicle->vehicleModel->name }}</span>
                        </div>
                    </td>
                    <td class="py-3 px-6 text-left">
                        <div class="flex items-center">
                            <span>{{ $vehicle->chassis }}</span>
                        </div>
                    </td>
                    <td class="py-3 px-6 text-left">
                        <div class="flex items-center">
                            <a href="{{ route('vehicles.show', $vehicle) }}">
                                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Ver
                                  </button>
                                </a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $vehicles->links() }}
@endsection
