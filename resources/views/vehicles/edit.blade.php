@extends('layouts.plantilla')
@section('title', 'Editar vehiculo')
@section('content')
    <h1>Editar vehiculo</h1>
    <section>
        <form action="{{ route('vehicles.update', $vehicle) }}" method="POST">
            @csrf
            @method('put')
            <label>chassis:
                <input type="number" name="chassis" step="0.1" value="{{ old('chassis', $vehicle->chassis) }}">
            </label>
            @error('chassis')
                <br>
                <small>*{{ $message }}</small>
                <br>
            @enderror
            <br>
            <label>
                Precio:
                <input type="date" name="price" value="{{ old('price', $vehicle->price) }}">
            </label>
            @error('price')
                <br>
                <small>*{{ $message }}</small>
                <br>
            @enderror
            <br>
            <br>
            <input type="submit" value="Editar vehiculo">
        </form>
    </section>
@endsection
