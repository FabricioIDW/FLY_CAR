@extends('layouts.plantilla')
@section('title', 'Crear vehículo')
@section('content')
    <h1>Crear vehículo</h1>
    <section>
        <form action="{{ route('vehicles.store') }}" method="POST">
            @csrf
            <label>Marca:
                <input type="text" name="chassis" value="{{ old('chassis') }}">
            </label>
            @error('chassis')
                <br>
                <small>*{{ $message }}</small>
                <br>
            @enderror
            <br>
            <label>Número de chasis:
                <input type="text" name="chassis" value="{{ old('chassis') }}">
            </label>
            @error('chassis')
                <br>
                <small>*{{ $message }}</small>
                <br>
            @enderror
            <br>
            <label>
                Precio:
                <input type="float" name="price" {{ old('price') }}>
            </label>
            @error('price')
                <br>
                <small>*{{ $message }}</small>
                <br>
            @enderror
            <br>
            <label>
                Año:
                <input type="date" name="year" {{ old('year') }}>
            </label>
            @error('year')
                <br>
                <small>*{{ $message }}</small>
                <br>
            @enderror
            <br>
            <label>
                Descripción:
                <textarea name="description" cols="30" rows="10">{{}}</textarea>
            </label>
            @error('price')
                <br>
                <small>*{{ $message }}</small>
                <br>
            @enderror
            <br>
            {{-- <label>
                Imágen:
                <input type="image" name="image" {{ old('image') }}>
            </label>
            @error('image')
                <br>
                <small>*{{ $message }}</small>
                <br>
            @enderror
            <br> --}}
            
            <br>
            <input type="submit" value="Crear vehículo">
        </form>
    </section>
@endsection
