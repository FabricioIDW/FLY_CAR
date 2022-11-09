@extends('layouts.plantilla')
@section('title', 'Editar accesorio')
@section('titleH1', 'Editar accesorio')

@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <form action="{{ route('accesorios.actualizar', $accesorio) }}" method="POST" id="idFormuAccesorio">
        @csrf
        @method('put')
        <div class="content">
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
                                    <option>Accesorio</option>
                                </select>

                                <label for="idDescProd" class="block text-sm font-medium text-gray-700">
                                    Descripción del accesorio:
                                    <textarea name="descripcionProducto" id="idDescProd" cols="20" rows="3"
                                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-white dark:border-gray-600 dark:placeholder-black dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ $accesorio->description }}</textarea>
                                    @error('descripcionProducto')
                                        <div class="text-xs text-red-800">La descripción del producto esta vacía.</div>
                                    @enderror

                                    <label for="estadoProducto" class="block text-sm font-medium text-gray-700">
                                        Estado del accesorio:
                                        <div>
                                            <select id="estadoProducto" name="selectEstado"
                                                class="tipoProducto 
                                    relative w-full cursor-default rounded-md border border-gray-300 bg-white py-2 pl-3 pr-10 text-left shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm">
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
                    </div>
                    <div class="mt-5 md:col-span-2 md:mt-0">

                        <div class="mt-5 md:col-span-2 md:mt-0" id="tipoAccesorio">
                            <div class="overflow-hidden shadow sm:rounded-md">
                                <div class="bg-white px-4 py-5 sm:p-6">
                                    <div class="grid grid-cols-6 gap-6">

                                        <div class="col-span-6 sm:col-span-3">

                                            <div class="col-span-6 sm:col-span-3">
                                                <label for="idNombreAccesorio"
                                                    class="block text-sm font-medium text-gray-700">Nombre
                                                    del accesorio:
                                                </label>
                                                <input type="text" id="idNombreAccesorio" name="nombreA"
                                                    value="{{ $accesorio->name }}"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                @error('nombreA')
                                                    <div class="text-xs text-red-800">El nombre del accesorio es obligatorio.
                                                    </div>
                                                @enderror
                                            </div>

                                            <div class="col-span-6 sm:col-span-4">
                                                <label for="stock" class="block text-sm font-medium text-gray-700">Stock:
                                                </label>
                                                <input type="number" min="0" max="500" name="stock"
                                                    value="{{ $accesorio->stock }}" id="stock"
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
                                                    que desea asociar al accesorio
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
                    </div>
                </div>
                <div class="text-right">
                    <x-jet-button id="botonActualizar" type="button"
                        >Editar</x-jet-button>
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
