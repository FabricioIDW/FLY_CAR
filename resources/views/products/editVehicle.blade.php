@extends('layouts.plantilla')
@section('title', 'Editar vehículo')
@section('titleH1', 'Editar vehículo')

@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <div class="content">
        <div class="titulos">Editar Vehiculo</div>
        <form action="{{ route('vehiculos.actualizar', $vehiculo) }}" method="POST" id="idFormuVehiculo">
            @csrf
            @method('put')
            <div class="grid grid-cols-1 md:grid-cols-2">
                <div class="grid grid-cols-2">


                    <div class="py-1">
                        Producto de tipo:
                    </div>
                    <div class="py-1">
                        <select class="tipoProducto" name="tProducto" id="selectTipo">
                            <option value="0">Vehiculo</option>
                        </select>
                    </div>

                    <div class="py-1">
                        Precio del Vehiculo:
                    </div>
                    <div class="py-1">
                        <input type="number" id="idPrecioProd" min="1" name="precioP" step="0.01"
                            value="{{ $vehiculo->price }}">
                    </div>

                    <div class="py-1">
                        Descripcion del vehiculo:
                    </div>
                    <div class="py-1">
                        <textarea name="descripcionProducto" id="idDescProd" cols="20" rows="5" value="">{{ $vehiculo->description }}</textarea>
                    </div>

                    <div class="py-1">
                        Estado del vehiculo:
                    </div>
                    <div>
                        <select id="estadoProducto" name="selectEstado">
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

                <div id="tipoVehiculo" class="grid grid-cols-2">

                    <div class="py-1">Marca del vehiculo:</div>
                    <div class="py-1">
                        <select name="marcasVehiculos" id="marcaVehiculo">
                            <option value="0">Seleccione una marca</option>
                            @foreach ($marcas as $marca)
                                @if ($vehiculo->VehicleModel->brand_id == $marca->id)
                                    <option value="{{ $marca->id }}" selected>{{ $marca->name }}</option>
                                @else
                                    <option value="{{ $marca->id }}">{{ $marca->name }}</option>
                                @endif
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
                            placeholder="Año entre 1980 y 2023..." value="{{ $vehiculo->year }}">
                    </div>

                    <div class="py-1">Nro de Chasis:</div>
                    <div class="py-1">
                        <input id="nroChasis" name="chasisV" type="text" maxlength="17"
                            pattern="[A-HJ-NN-NP-PR-Z0-9]{17,17}" placeholder="Expresion de 17 digitos.."
                            value="{{ $vehiculo->chassis }}">
                    </div>

                    <div class="py-1">
                        Imagen del vehiculo:
                    </div>
                    <div class="py-1">
                        <input id="imageVehiculo" name="imgVehiculo" type="file" accept="image/*"><span
                            class="text-xs">{{ $vehiculo->image }}</span>
                    </div>
                </div>
            </div>
            <div class="place-items-center grid grid-cols-1">
                <button id="botonActualizar" type="submit"
                    class="rounded-xl bg-gray-600 font-semibold text-2xl py-6">Actualizar vehiculo</button>
            </div>
        </form>
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
    @endsection
