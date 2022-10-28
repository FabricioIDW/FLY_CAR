@extends('layouts.plantilla')
@section('content')
<div class="content">
@vite(['resources/js/selectProducto.js'])

<div class="grid grid-cols-2">
<div class="grid grid-cols-2">

    <div class="py-1">
        Seleccione el tipo de producto
    </div>
    <div class="py-1">
    <select name="tipoProducto" id="selectTipo" onchange='selectTipo()'>
        <option value="0">Vehiculo</option>
        <option value="1">Accesorio</option>
    </select>
    </div>

    <div class="py-1">
        Precio del producto:
    </div>
    <div class="py-1">
        <input type="number" id="idPrecioProd" min="1">
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
        <select id="estadoProducto">
            <option value="0">Disponible</option>
            <option value="1">No disponible</option>
        </select>
    </div>
</div>
</div>
<script>
    function selectTipo(){
        tipoP = document.getElementById('selectTipo').selectedIndex;
        if(tipoP == 0){
            alert("entro tipo Vehiculo");
        }else{
            alert("entro tipo accesorio");
        }
    }
</script>
@endsection