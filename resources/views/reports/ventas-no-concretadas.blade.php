@extends('layouts.plantilla')
@section('title', 'Principal')
@section('titleH1', $title)

@section('content')
    @if (count($reporte) > 0)
        <table class="min-w-max w-full table-auto">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-2 text-left">Nro. Venta</th>
                    <th class="py-3 px-6 text-left">Vendedor</th>
                    <th class="py-3 px-6 text-left">Comisión (10%)</th>
                    <th class="py-3 px-6 text-left">Nro. Cotización</th>
                    <th class="py-3 px-6 text-left">Importe</th>
                    <th class="py-3 px-6 text-left">Vehículos</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @foreach ($reporte as $sale)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="mr-2">
                                    <span class="font-medium">{{ $sale['Venta'] }}</span>
                                </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="mr-2">
                                    <span class="font-medium">{{ $sale['Vendedor'] }}</span>
                                </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="mr-2">
                                    <span class="font-medium">${{ $sale['Comisión'] }}</span>
                                </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="mr-2">
                                    <span class="font-medium">{{ $sale['Cotización'] }}</span>
                                </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="mr-2">
                                    <span class="font-medium">${{ $sale['Importe'] }}</span>
                                </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="mr-2">
                                    <ul>
                                        @foreach ($sale['Vehiculos'] as $vehicle)
                                            <li>
                                                - {{ $vehicle['Marca'] }} {{ $vehicle['Modelo'] }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No se encontraron resultados para este reporte</p>
    @endif

@endsection
