@extends('layouts.plantilla')
@section('title', 'Editar vehículo')
@section('titleH1', 'Editar vehículo')

@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <form action="{{ route('vehiculos.actualizar', $vehiculo) }}" method="POST" id="idFormuVehiculo"
        enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="mt-10 sm:mt-0">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">

                        <label for="selectTipo" class="block text-sm font-medium text-gray-700">
                            Seleccione el tipo de producto
                            <select
                                class="tipoProducto 
                                relative w-full cursor-default rounded-md border border-gray-300 bg-white py-2 pl-3 pr-10 text-left shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm"
                                aria-haspopup="listbox" aria-expanded="true" aria-labelledby="listbox-label"
                                name="tProducto" id="selectTipo">
                                <option value="">Vehículo</option>
                            </select>

                            <p id="pPrecio" class="block text-sm font-medium text-gray-700">
                                Precio del vehículo:</p>
                            <input type="number" id="idPrecioProd" name="price" min="1" step="0.01"
                                name="precioP" value="{{ $vehiculo->price }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">

                            <label for="idDescProd" class="block text-sm font-medium text-gray-700">
                                Descripción del vehículo:
                                <textarea required name="descripcionProducto" id="idDescProd" cols="20" rows="3"
                                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-white dark:border-gray-600 dark:placeholder-black dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ $vehiculo->description }}</textarea>
                                @error('descripcionProducto')
                                    <div class="text-xs text-red-800">La descripción del vehículo esta vacía.</div>
                                @enderror

                                <label for="estadoProducto" class="block text-sm font-medium text-gray-700">
                                    Estado del producto:
                                    <div>
                                        <select id="estadoProducto" name="selectEstado"
                                            class="tipoProducto 
                                            relative w-full cursor-default rounded-md border border-gray-300 bg-white py-2 pl-3 pr-10 text-left shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm">
                                            @if ($vehiculo->enabled == 1)
                                                <option value="0">No disponible</option>
                                                <option value="1" selected>Disponible</option>
                                            @else
                                                <option value="0" selected>No disponible</option>
                                                <option value="1">Disponible</option>
                                            @endif
                                        </select>
                                    </div>
                    </div>
                </div>
                <div class="mt-5 md:col-span-2 md:mt-0">
                    <div class="overflow-hidden shadow sm:rounded-md" id="tipoVehiculo">
                        <div class="bg-white px-4 py-5 sm:p-6">
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-3">

                                    <div class="col-span-6 sm:col-span-4">
                                        <label for="marcaVehiculo" class="block text-sm font-medium text-gray-700">
                                            Marca del vehículo:
                                            <select name="marcasVehiculos" id="marcaVehiculo"
                                                class="relative w-full cursor-default rounded-md border border-gray-300 bg-white py-2 pl-3 pr-10 text-left shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm">
                                                <option value="0">Seleccione una marca</option>
                                                @foreach ($marcas as $marca)
                                                    @if ($vehiculo->VehicleModel->brand_id == $marca->id)
                                                        <option value="{{ $marca->id }}" selected>{{ $marca->name }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $marca->id }}">{{ $marca->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @error('marcasVehiculos')
                                                <div class="text-xs text-red-800">Debe seleccionar una marca.</div>
                                            @enderror
                                    </div>


                                    <div class="col-span-6 sm:col-span-4">
                                        <label for="contenidoModelo" class="block text-sm font-medium text-gray-700">
                                            Modelo del vehículo:<br>
                                            <p id="modeloActual" hidden>
                                                {{ $vehiculo->vehicleModel->name }}</p>
                                            <select id="contenidoModelo" name="modeloV"
                                                class="relative w-full cursor-default rounded-md border border-gray-300 bg-white py-2 pl-3 pr-10 text-left shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm">
                                            </select>
                                    </div>


                                    <div class="col-span-6 sm:col-span-4">
                                        <label for="anioVehiculo" class="block text-sm font-medium text-gray-700">
                                            Año del vehículo:</label>
                                        <input id="AnioVehiculo" name="anioV" type="number" min=1960 max=2022
                                            placeholder="Año entre 1960 y 2023..." value="{{ $vehiculo->year }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        @error('anioV')
                                            <div class="text-xs text-red-800">Año del vehículo invalido, debe ser entre 1960
                                                y 2022.</div>
                                        @enderror
                                    </div>


                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="nroChasis" class="block text-sm font-medium text-gray-700">
                                            Número de chasis:</label>
                                        <input id="nroChasis" name="chassis" type="text" maxlength="17"
                                            placeholder="Expresion de 17 digitos.." min="17"
                                            value="{{ $vehiculo->chassis }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        @error('chassis')
                                            <div class="text-xs text-red-800">El numero de chasis es incorrecto, debe ser
                                                único y tener 17
                                                caracteres.</div>
                                        @enderror
                                    </div>

                                </div>


                                <div class="col-span-6 sm:col-span-3">
                                    <label for="file" class="block text-sm font-medium text-gray-700">
                                        Imágen del vehículo:</label>
                                    <img id="picture" src="{{ $vehiculo->image }}">
                                    <input id="file" name="file" type="file" accept="image/*"
                                        class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer dark:text-gray-400 focus:outline-none dark:bg-white dark:border-black dark:placeholder-gray-400">
                                    @error('file')
                                        <div class="text-xs text-red-800">El archivo debe ser una imágen(JPEG, PNG,
                                            etc.).</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-right">
                <x-jet-button type="submit" id="actualizarVehiculo">Editar</x-jet-button>
            </div>
    </form>
    <script>
        $(document).ready(function() {
            $value = $('#marcaVehiculo').val();
            $modelo = $('#modeloActual').text();
            console.log($value);
            $.ajax({
                type: 'get',
                url: '{{ URL::to('modelsByBrand') }}',
                data: {
                    'marca': $value,
                    'modelo': $modelo
                },

                success: function(data) {
                    console.log(data);
                    $('#contenidoModelo').html(data);
                }
            });
        });
    </script>

    <script type="text/javascript">
        document.getElementById("file").addEventListener('change', cambiarImagen);

        function cambiarImagen(event) {
            var file = event.target.files[0];
            var reader = new FileReader();
            reader.onload = (event) => {
                document.getElementById("picture").setAttribute('src', event.target.result);
            };
            reader.readAsDataURL(file);
        }
    </script>
    <script type="text/javascript">
        $("#marcaVehiculo").change(function() {
            $value = $(this).val();

            $.ajax({
                type: 'get',
                url: '{{ URL::to('modelsByBrand') }}',
                data: {
                    'marca': $value,
                },

                success: function(data) {
                    console.log(data);
                    $('#contenidoModelo').html(data);
                }
            });
        })
    </script>
@endsection
