@extends('layouts.plantilla')
@section('content')
<form action="{{ route('productos.store') }}" method="POST">
    @csrf
    <div class="grid grid-cols-1 md:grid-cols-2">
        <div class="grid grid-cols-2">


            <div class="py-1">
                Seleccione el tipo de producto
            </div>
            <div class="py-1">
                <select class="tipoProducto" name="tProducto" id="selectTipo">
                    <option value="0">Vehiculo</option>
                    <option value="1">Accesorio</option>
                </select>
            </div>

            <div class="py-1">
                Precio del producto:
            </div>
            <div class="py-1">
                <input type="number" id="idPrecioProd" min="1" name="precioP">
            </div>

            <div class="py-1">
                Descripcion:
            </div>
            <div class="py-1">
                <textarea name="descripcionProducto" id="idDescProd" cols="20" rows="3"></textarea>
            </div>

            <div class="py-1">
                Estado del producto:
            </div>
            <div>
                <select id="estadoProducto" name="selectEstado">
                    <option value="0">No disponible</option>
                    <option value="1">Disponible</option>
                </select>
            </div>


        </div>

        {{-- TIPO VEHICULO --}}
        <div id="tipoVehiculo" class="grid grid-cols-2">

            <div class="py-1">Marca del vehiculo:</div>
            <div class="py-1">
                <select name="marcasVehiculos" id="marcaVehiculo">
                    <option value="0">Seleccione una marca</option>
                    @foreach ($marcas as $marca)
                        <option value="{{ $marca->id }}">{{ $marca->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="py-1">Modelo del vehiculo</div>
            <div class="py-1">
                <select id="contenidoModelo" name="modeloV">
                </select>
            </div>

            <div class="py-1">
                Año del vehiculo:
            </div>
            <div class="py-1">
                <input id="AnioVehiculo" name="anioV" type="number" min="1980" max="2023"
                    placeholder="Año entre 1980 y 2023...">
            </div>

            <div class="py-1">Nro de Chasis:</div>
            <div class="py-1">
                <input id="nroChasis" name="chasisV" type="text" maxlength="17"
                    pattern="[A-HJ-NN-NP-PR-Z0-9]{17,17}" placeholder="Expresion de 17 digitos..">
            </div>

            <div class="py-1">
                Imagen del vehiculo:
            </div>
            <div class="py-1">
                <input id="imageVehiculo" name="imgVehiculo" type="file" accept="image">
            </div>


        </div>
        {{-- TERMINA TIPO VEHICULO --}}

        {{-- TIPO ACCESORIO --}}
        <div id="tipoAccesorio" class="grid grid-cols-2">

            <div class="py-1">Nombre del accesorio</div>
            <div class="py-1">
                <input type="text" id="idNombreAccesorio" name="nombreA">
            </div>

            <div class="py-1">Stock disponible</div>
            <div class="py-1"><input type="number" min="0" max="500" name="stock"></div>

            <div class="py-1">
                <div class="m-auto scroll-containerChico">
                    <ul class="border border-gray-200 rounded shadow-md" id="modelosSeleccionados">
                        @foreach ($modelos as $modelo)
                            <li
                                class="px-4 py-2 bg-white hover:bg-sky-100 hover:text-sky-900 border-b last:border-none border-gray-200 transition-all duration-300 ease-in-out">
                                {{ $modelo->name }} <input type="checkbox" id="{{ $modelo->id }}"
                                    class="scrollModelos" value="{{ $modelo->id }}">
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="py-1 grid grid-cols-2" id="inputPrecios" name=""></div>

        </div>
        {{-- TERMINA TIPO ACCESORIO --}}

    </div>
    <div class="place-items-center grid grid-cols-1">
        <button type="submit" class="rounded-xl bg-gray-600 font-semibold text-2xl py-6">Guardar producto</button>
    </div>

</form>
<script>
    $(document).ready(function() {
        $('#tipoVehiculo').show();
        $('#tipoAccesorio').hide();
    });
</script>
<script type="text/javascript">
    $(".tipoProducto").change(function() {
        $value = $(this).val();
        if ($value == 0) {
            $('#tipoVehiculo').show();
            $('#tipoAccesorio').hide();
        } else {
            $('#tipoVehiculo').hide();
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
                'selectMarca': $value
            },

            success: function(data) {
                console.log(data);
                $('#contenidoModelo').html(data);
            }
        });
    })
</script>
<script>
    $("#modelosSeleccionados").on('click', function() {
        let valoresCheck = [];
        $("input[type=checkbox]:checked").each(function() {
            valoresCheck.push(this.value);
        });
        console.log(valoresCheck);
        $('#inputPrecios').empty();
        $.each(valoresCheck, function(i, value) {
            $('#inputPrecios').append('Precio del modelo ' + value + '<input type="number" id="' +
                value + ' name="modelo" class="h-7 w-20">');
        });
    });
</script>

    @endsection
