@extends('layouts.plantilla')
@section('title', 'Editar oferta')
@section('content')
    <h1>Editar oferta</h1>
    <section>
        <form action="{{ route('ofertas.update', $oferta) }}" method="POST">
            @csrf
            @method('put')
            <label>Descuento:
                <input type="number" name="descuento" step="0.1" value="{{ old('descuento', $oferta->descuento) }}">
            </label>
            @error('descuento')
                <br>
                <small>*{{ $message }}</small>
                <br>
            @enderror
            <br>
            <label>
                Fecha de inicio:
                <input type="date" name="fechaInicio" value="{{ old('fechaInicio', $oferta->fechaInicio) }}">
            </label>
            @error('fechaInicio')
                <br>
                <small>*{{ $message }}</small>
                <br>
            @enderror
            <br>
            <label>
                Fecha de fin:
                <input type="date" name="fechaFin" value="{{ old('fechaFin', $oferta->fechaFin) }}">
            </label>
            @error('fechaFin')
                <br>
                <small>*{{ $message }}</small>
                <br>
            @enderror
            <br>
            <input type="submit" value="Editar oferta">
        </form>
    </section>
@endsection
