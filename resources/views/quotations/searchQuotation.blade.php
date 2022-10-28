@extends('layouts.plantilla')
@extends('layouts.partials.contenedorMiCotizacion')
@section('title', 'Buscar Cotizacion')

@section('contend')

<div>
    <form action="" method="POST" name="formularioDeBusqueda">
     <input type="search" name="cotizacionABuscar" id="cotizacionABuscar" placeholder="Buscar cotizacion" class="fon-control rounded-full">
    </form>
</div>
@section('contenedorMiCotizacion')
@endsection
@endsection
<script>
 const csrfToken = document.head.querySelector("[name~=csrf-token][contend]").contend;
 cotizacionABuscar.addEventListener("keyup", e=>{
    var texto = e.target.value;
    if (texto.length>3) {
        fetch("searchQuotation/",{
            method:"post",
            body:Json.stringify({texto : texto}),
            headers:{
                'X-Requested-With' : 'XMLHttpRequest',
                'Content-Type': 'aplication/json',
                'X-CSRF-Token': crsToken
            }
        }).then(response => {
            return response.json()
        }).then(data => {
            console.log(data.lista)
        }).catch(error => console.error(error));
    }})
</script>