@extends('layouts.plantilla')
@section('title', 'Mostrar vehículo')
@section('content')
    <h1>Vehículo</h1>
    <a href="{{ route('vehicles.index') }}">Volver a vehículos</a> |
    @can('vehicles.edit')
        <a href="{{ route('vehicles.edit', $vehicle) }}">Editar</a>
    @endcan
    <br>
    <p><strong>ID: {{ $vehicle->id }}</strong></p>
    <p><strong>Marca: {{ $vehicle->vehicleModel->brand->name }}</strong></p>
    <p><strong>Modelo: {{ $vehicle->vehicleModel->name }}</strong></p>
    <p><strong>Número de chasis: {{ $vehicle->chassis }}</strong></p>

    <p><strong>Accesorios</strong></p>
    @foreach ($vehicle->vehicleModel->accessories as $accessory)
        <ul>
            <li>{{ $accessory->name }}</li>
        </ul>
        <br>
    @endforeach
    <br>
<<<<<<< HEAD
    @can('vehicles.destroy')
        <form action="{{ route('vehicles.destroy', $vehicle) }}" method="POST">
            @csrf
            @method('delete')
            <button type="submit">Eliminar</button>
        </form>
    @endcan
@endsection
=======
     <form action="{{ route('vehicles.destroy', $vehicle) }}" method="POST">
        @csrf
        @method('delete')
        <button type="submit">Eliminar</button>
    </form>
    @endsection
@push('scripts')
<script>
console.log('asdasd');
</script>
@endpush
>>>>>>> 59dca736b72a597783d275273ea311dd68cb37f7
