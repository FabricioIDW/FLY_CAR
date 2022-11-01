@extends('layouts.plantilla')
@section('title', 'Editar accesorio')
@section('titleH1', 'Editar accesorio')

@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <div class="content">
        <form action="{{ route('accesorios.actualizar', $accesorio) }}" method="POST" id="idFormuAccesorio">
            @csrf
            @method('put')
            <div class="grid grid-cols-1 md:grid-cols-2">
                <div class="grid grid-cols-2">
                    <div class="py-1">
                        Producto de tipo:
                    </div>
                    <div class="py-1">
                        <select class="tipoProducto" name="tProducto" id="selectTipo">
                            <option value="1">Accesorio</option>
                        </select>
                    </div>


                    <div class="py-1">
                        Descripcion del accesorio:
                    </div>
                    <div class="py-1">
                        <textarea name="descripcionProducto" id="idDescProd" cols="20" rows="5" value="">{{ $accesorio->description }}</textarea>
                    </div>

                    <div class="py-1">
                        Estado del accesorio:
                    </div>
                    <div>
                        <select id="estadoProducto" name="selectEstado">
                            @if ($accesorio->enabled == 1)
                                <option value="0">No disponible</option>
                                <option value="1" selected>Disponible</option>
                            @else
                                <option value="0" selected>No disponible</option>
                                <option value="1">Disponible</option>
                            @endif
                        </select>
                    </div>
                </div>

                <div id="tipoAccesorio" class="grid grid-cols-2">

                    <div class="py-1">Nombre del accesorio</div>
                    <div class="py-1">
                        <input type="text" id="idNombreAccesorio" name="nombreA" value="{{ $accesorio->name }}">
                    </div>

                    <div class="py-1">Stock disponible</div>
                    <div class="py-1"><input type="number" min="0" max="500" name="stock"
                            value="{{ $accesorio->stock }}"></div>

                    <div class="py-1">
                        <div class="m-auto scroll-containerChico">
                            <ul class="border border-gray-200 rounded shadow-md" id="modelosSeleccionados">
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
                                        <input type="checkbox" id="{{ $modelo->id }}" class="scrollModelos"
                                            value="{{ $modelo->id }}" name="{{ $modelo->id }}">
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <input type="hidden" id="modelosSelec" name="modelos">
                    <div class="py-1 grid grid-cols-2" id="inputPrecios">
                    </div>


                </div>
            </div>
            <div class="place-items-center grid grid-cols-1">
                <button id="botonActualizar" type="button"
                    class="rounded-xl bg-gray-600 font-semibold text-2xl py-6">Actualizar accesorio</button>
            </div>
        </form>

        <script>
            let valoresCheck = [];
            $("#modelosSeleccionados").on('click', function() {
                valoresCheck.length = 0;
                $("input[type=checkbox]:checked").each(function() {
                    valoresCheck.push(this.value);
                });
                console.log(valoresCheck);
                $('#inputPrecios').empty();
                $.each(valoresCheck, function(i, value) {
                    $('#inputPrecios').append('Precio del modelo' + value + '<input type="number" id="modelo' +
                        value + '" step="0.01" class="h-7 w-20">');
                });
            });
        </script>
        <script>
            let precios = "";
            $('#botonActualizar').on('click', function() {
                valoresCheck.forEach(element => {
                    precios += element + '/' + $('#modelo' + element).val() + '|';
                });
                $('#modelosSelec').val(precios);
                $('#idFormuAccesorio').submit();
            })
        </script>
    @endsection
