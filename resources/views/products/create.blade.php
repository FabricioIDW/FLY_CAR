@extends('layouts.plantilla')
@section('title', 'Crear producto')
@section('titleH1', 'Crear producto')

@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <form action="{{ route('vehiculos.store') }}" method="POST" id="formuProducto" enctype="multipart/form-data">
        @csrf
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
                                <option value="{{ route('vehiculos.store') }}">Vehículo</option>
                                <option value="{{ route('accesorios.store') }}">Accesorio</option>
                            </select>

                            <p id="pPrecio" class="block text-sm font-medium text-gray-700">
                                Precio del producto:</p>
                            <input type="number" id="idPrecioProd" name="price" min="1" step="0.01"
                                name="precioP"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">

                            <label for="idDescProd" class="block text-sm font-medium text-gray-700">
                                Descripción del producto:
                                <textarea name="descripcionProducto" id="idDescProd" cols="20" rows="3"
                                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-white dark:border-gray-600 dark:placeholder-black dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
                                @error('descripcionProducto')
                                    <div class="text-xs text-red-800">La descripción del producto esta vacía.</div>
                                @enderror

                                <label for="estadoProducto" class="block text-sm font-medium text-gray-700">
                                    Estado del producto:
                                    <div>
                                        <select id="estadoProducto" name="selectEstado"
                                            class=" 
                                        relative w-full cursor-default rounded-md border border-gray-300 bg-white py-2 pl-3 pr-10 text-left shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm">
                                            <option value="0">No disponible</option>
                                            <option value="1">Disponible</option>
                                        </select>
                                    </div>
                    </div>
                </div>
                <div class="mt-5 md:col-span-2 md:mt-0">
                    {{-- TIPO VEHICULO --}}
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
                                                    <option value="{{ $marca->id }}">{{ $marca->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('marcasVehiculos')
                                                <div class="text-xs text-red-800">Debe seleccionar una marca.</div>
                                            @enderror
                                    </div>


                                    <div class="col-span-6 sm:col-span-4">
                                        <label for="contenidoModelo" class="block text-sm font-medium text-gray-700">
                                            Modelo del vehículo
                                            <select id="contenidoModelo" name="modeloV"
                                                class="relative w-full cursor-default rounded-md border border-gray-300 bg-white py-2 pl-3 pr-10 text-left shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm">
                                            </select>
                                    </div>


                                    <div class="col-span-6 sm:col-span-4">
                                        <label for="anioVehiculo" class="block text-sm font-medium text-gray-700">
                                            Año del vehículo:</label>
                                        <input id="AnioVehiculo" name="anioV" type="number" min=1960 max=2022
                                            placeholder="Año entre 1960 y 2023..."
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
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        @error('chassis')
                                            <div class="text-xs text-red-800">El número de chasis es incorrecto, debe ser
                                                único y tener 17
                                                caracteres.</div>
                                        @enderror
                                    </div>

                                </div>


                                <div class="col-span-6 sm:col-span-3">
                                    <label for="file" class="block text-sm font-medium text-gray-700">
                                        Imágen del vehículo:</label>
                                    <img id="picture" src="https://elceo.com/wp-content/uploads/2019/02/coches.jpg"
                                        alt="Imagen predefinida">
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

                    {{-- TERMINA TIPO VEHICULO --}}
                    {{-- TIPO ACCESORIO --}}
                    {{-- ------------------------------------- --}}

                    <div class="mt-5 md:col-span-2 md:mt-0" id="tipoAccesorio">
                        <div class="overflow-hidden shadow sm:rounded-md">
                            <div class="bg-white px-4 py-5 sm:p-6">
                                <div class="grid grid-cols-6 gap-6">

                                    <div class="col-span-6 sm:col-span-3">

                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="idNombreAccesorio"
                                                class="block text-sm font-medium text-gray-700">Nombre del accesorio:
                                            </label>
                                            <input type="text" id="idNombreAccesorio" name="nombreA"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            @error('nombreA')
                                                <div class="text-xs text-red-800">El nombre del accesorio es obligatorio.</div>
                                            @enderror
                                        </div>

                                        <div class="col-span-6 sm:col-span-4">
                                            <label for="stock" class="block text-sm font-medium text-gray-700">Stock:
                                            </label>
                                            <input type="number" min="0" max="500" name="stock"
                                                id="stock"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            @error('stock')
                                                <div class="text-xs text-red-800">El stock es obligatorio y debe ser mayor o
                                                    igual
                                                    a 1</div>
                                            @enderror
                                        </div>


                                        <div class="col-span-6 sm:col-span-4">
                                            <label for="modelosSeleccionados"
                                                class="block text-sm font-medium text-gray-700">Seleccione los modelos
                                                que desea asociar al accesorio:
                                            </label>
                                            <div class="m-auto scroll-containerChico">
                                                <ul class="border border-gray-200 rounded shadow-md h-60"
                                                    id="modelosSeleccionados">
                                                    @php
                                                        $i = 1;
                                                    @endphp
                                                    @foreach ($modelos as $modelo)
                                                        <li
                                                            class="px-4 py-2 bg-white hover:bg-sky-100 hover:text-sky-900 border-b last:border-none border-gray-200 transition-all duration-300 ease-in-out">
                                                            @php
                                                                echo $i;
                                                                $i = $i + 1;
                                                            @endphp
                                                            . {{ $modelo->name }}
                                                            <input type="checkbox" id="{{ $modelo->id }}"
                                                                class="scrollModelos" value="{{ $modelo->id }}"
                                                                name="{{ $modelo->id }}">
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>

                                            <input type="hidden" id="modelosSelec" name="modelos">
                                        </div>
                                    </div>
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="inputPrecios" class="block text-sm font-medium text-gray-700">
                                            Precios de los modelos:</label>
                                        <div class="col-span-6 sm:col-span-4">
                                            <div class="py-1 grid grid-cols-2 h-96 overflow-scroll " id="inputPrecios">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- 
                                     --}}

                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- TERMINA TIPO ACCESORIO --}}
                </div>
            </div>
            <div class="text-right">
                <x-jet-button type="button" id="botonCrear">Crear</x-jet-button>
            </div>
    </form>

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
    <script>
        $(document).ready(function() {
            $('#tipoVehiculo').show();
            $('#tipoAccesorio').hide();
        });
    </script>
    <script type="text/javascript">
        $(".tipoProducto").change(function() {
            $value = $('#selectTipo option:selected').text();
            $ruta = $('#selectTipo').val();
            $('#formuProducto').attr('action', $ruta);
            if ($value == 'Vehículo') {
                $('#tipoVehiculo').show();
                $('#tipoAccesorio').hide();
                $('#idPrecioProd').show();
                $('#pPrecio').show();

            } else {
                $('#tipoVehiculo').hide();
                $('#idPrecioProd').hide();
                $('#pPrecio').hide();
                $('#tipoAccesorio').show();
            }
        });
    </script>
    <script type="text/javascript">
        $("#marcaVehiculo").change(function() {
            $value = $(this).val();
            $.ajax({
                type: 'get',
                url: '{{ URL::to('modelsByBrand') }}',
                data: {
                    'marca': $value
                },

                success: function(data) {
                    console.log(data);
                    $('#contenidoModelo').html(data);
                }
            });
        })
    </script>
    <script>
        let valoresCheck = [];
        $("#modelosSeleccionados").on('click', function() {
            valoresCheck.length = 0;
            $("input[type=checkbox]:checked").each(function() {
                valoresCheck.push(this.value);
            });
            $('#inputPrecios').empty();
            $.each(valoresCheck, function(i, value) {
                $('#inputPrecios').append('Precio del modelo ' + value + '<input type="number" id="modelo' +
                    value +
                    '" step="0.01" class="h-7 w-20" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">'
                );
            });
        });
    </script>
    <script>
        let precios = "";
        $('#botonCrear').on('click', function() {
            valoresCheck.forEach(element => {

                precios += element + '/' + $('#modelo' + element).val() + '|';
            });

            $('#modelosSelec').val(precios);
            let marca = document.getElementById('marcaVehiculo').value;
            let select = document.getElementById('selectTipo');
            let tipo = select.options[select.selectedIndex].text;
            if (tipo = 'Accesorio') {
                document.getElementById('formuProducto').submit();
            } else if (marca == 0) {
                swal("¡Cuidado!", "No se seleccionó ninguno marca. Vuelva a intentarlo", "error");
            } else {
                document.getElementById('formuProducto').submit();
            }
        })
    </script>
@endsection
