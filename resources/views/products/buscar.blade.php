@extends('layouts.plantilla')
@section('title', 'Buscar productos')
@section('titleH1', 'Buscar productos')
@section('content')
    <div class="content">

        <div class="grid grid-cols-2 place-items-center max-h-full">
            {{-- Scroll Vehiculos  --}}
            <div class="w-11/12">
                <div class="text-2xl font-semibold text-center">Vehiculos</div>
                <div class="text-center"><input type="search" id="searchV" placeholder="ID, marca, modelo..."
                        class="h-6 rounded-xl"></div> {{-- BUSCADOR --}}
                <div class="scroll-containerChico mx-auto">
                    <div>
                        <table class="min-w-max w-full table-auto">
                            <thead>
                                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-center">ID</th>
                                    <th class="py-3 px-6 text-center">Marca</th>
                                    <th class="py-3 px-6 text-center">Modelo</th>
                                    <th class="py-3 px-6 text-center">N° de chasis</th>
                                    <th class="py-3 px-6 text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="alldataV" class="text-gray-600 text-sm font-light bg-gray-200">
                                @foreach ($vehiculos as $vehiculo)
                                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                                        <td class="py-3 px-3 text-center whitespace-nowrap">
                                            <div class="items-center">
                                                <div class="mr-2">
                                                    <span class="font-medium">{{ $vehiculo->id }}</span>
                                                </div>
                                        </td>
                                        <td class="py-3 px-3 text-center">
                                            <div class="items-center">
                                                <span>{{ $vehiculo->vehicleModel->brand->name }}</span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-3 text-center">
                                            <div class="items-center">
                                                <span>{{ $vehiculo->vehicleModel->name }}</span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-3 text-center">
                                            <div class="items-center">
                                                <span>{{ $vehiculo->chassis }}</span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-3 text-center">
                                            <div class="flex item-center justify-center">
                                                <a href="">{{-- EDITAR VEHICULO --}}
                                                    <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                        </svg>
                                                    </div>
                                                </a>
                                                <div class="overflow-x-auto">
                                                    <x-modal openBtn="Eliminar" title="Eliminar vehiculo" leftBtn="Eliminar"
                                                        rightBtn="Cancelar" ref="productos_vehiculos.destroy"
                                                        value="{{ $vehiculo->id }}">
                                                        <p>¿Está seguro de eliminar este vehiculo?</p>
                                                    </x-modal>
                                                </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tbody id="contenidoV" class="searchDataV text-gray-600 text-sm font-light bg-gray-200">

                            </tbody>
                        </table>
                        <script type="text/javascript">
                            $('#searchV').on('keyup', function() {
                                $value = $(this).val();

                                if ($value) {
                                    $('#alldataV').hide();
                                    $('.searchDataV').show();
                                } else {
                                    $('#alldataV').show();
                                    $('.searchDataV').hide();
                                }

                                $.ajax({

                                    type: 'get',
                                    url: '{{ URL::to('busquedaV') }}',
                                    data: {
                                        'searchV': $value
                                    },

                                    success: function(data) {
                                        console.log(data);
                                        $('#contenidoV').html(data);
                                    }
                                });
                            })
                        </script>
                    </div>
                </div>

            </div>

            {{-- Scroll Accesorios  --}}
            <div class="w-11/12 mx-auto">
                <div class="text-2xl font-semibold text-center">Accesorios</div>
                <div class="text-center"><input type="search" id="searchA" name="buscadorAccesorio"
                        placeholder="ID, nombre..." class="h-6 rounded-xl"></div>
                <div class="scroll-containerChico mx-auto">
                    <table class="min-w-max w-full table-auto">
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-center">ID</th>
                                <th class="py-3 px-6 text-center">Nombre</th>
                                <th class="py-3 px-6 text-center">Stock</th>
                                <th class="py-3 px-6 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="alldataA" class="text-gray-600 text-sm font-light bg-gray-200">
                            @foreach ($accesorios as $accesorio)
                                <tr class="border-b border-gray-200 hover:bg-gray-100">
                                    <td class="py-3 px-3 text-center whitespace-nowrap">
                                        <div class="items-center">
                                            <div class="mr-2">
                                                <span class="font-medium">{{ $accesorio->id }}</span>
                                            </div>
                                    </td>
                                    <td class="py-3 px-3 text-center">
                                        <div class=" items-center ">
                                            <span>{{ $accesorio->name }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 text-center">
                                        <div class=" items-center">
                                            <span>{{ $accesorio->stock }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 text-center">
                                        <div class="flex item-center justify-center">
                                            <a href="">{{-- EDITAR accesorio --}}
                                                <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                    </svg>
                                                </div>
                                            </a>
                                            <div class="overflow-x-auto">

                                                <x-modal openBtn="Eliminar" title="Eliminar accesorio" leftBtn="Eliminar"
                                                    rightBtn="Cancelar" ref="productos_accesorio.destroy"
                                                    value="{{ $accesorio->id }}">
                                                    <p>¿Está seguro de eliminar este accesorio?</p>
                                                </x-modal>
                                            </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tbody id="contenidoA" class="searchDataA text-gray-600 text-sm font-light bg-gray-200"></tbody>
                    </table>
                    <script type="text/javascript">
                        $('#searchA').on('keyup', function() {
                            $value = $(this).val();

                            if ($value) {
                                $('#alldataA').hide();
                                $('.searchDataA').show();
                            } else {
                                $('#alldataA').show();
                                $('.searchDataA').hide();
                            }

                            $.ajax({

                                type: 'get',
                                url: '{{ URL::to('busquedaA') }}',
                                data: {
                                    'searchA': $value
                                },

                                success: function(data) {
                                    console.log(data);
                                    $('#contenidoA').html(data);
                                }
                            });
                        })
                    </script>
                </div>
            </div>
        </div>
        <div class="text-center pt-32">@include('layouts.partials.footer')</div>
    </div>
    {{-- Termina div content --}}
@endsection
