@extends('layouts.plantilla')
@section('title', 'Crear oferta')
@section('content')
    <div class="mt-10 sm:mt-0">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Crear oferta</h3>
                    <p class="mt-1 text-sm text-gray-600">Podrá asociar vehículos y accesorios a la misma.</p>
                </div>
            </div>
            <div class="mt-5 md:col-span-2 md:mt-0">
                <form action="{{ route('offers.store') }}" method="POST">
                    @csrf
                    <div class="overflow-hidden shadow sm:rounded-md">
                        <div class="bg-white px-4 py-5 sm:p-6">
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="idDiscount" class="block text-sm font-medium text-gray-700">Descuento:
                                    </label>
                                    <input type="number" name="discount" id="idDiscount" step="0.01" min="0.01"
                                        max="99.99" value="{{ old('discount') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                                @error('discount')
                                    <p class="mt-2 text-sm text-gray-500">*{{ $message }}</p>
                                @enderror
                                {{-- Fecha de inicio --}}
                                <div class="col-span-6 sm:col-span-4">
                                    <label for="idStartDate" class="block text-sm font-medium text-gray-700">Fecha de
                                        inicio</label>
                                    <input type="date" name="startDate" id="idStartDate" value="{{ old('startDate') }}" min="{{ now()->toDateString('Y-m-d') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                                @error('startDate')
                                    <p class="mt-2 text-sm text-gray-500">*{{ $message }}</p>
                                @enderror
                                <div class="col-span-6 sm:col-span-4">
                                    <label for="idEndDate" class="block text-sm font-medium text-gray-700">Fecha de
                                        fin</label>
                                    <input type="date" name="endDate" id="idEndDate" value="{{ old('endDate') }}" min="{{ now()->toDateString('Y-m-d') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                                @error('endDate')
                                    <p class="mt-2 text-sm text-gray-500">*{{ $message }}</p>
                                @enderror
                                <br>
                                {{-- Asignación de productos --}}
                                {{-- Vehículos --}}
                                @if (count($vehicles) > 0)
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="idVehicles" class="block text-sm font-medium text-gray-700">Vehículos:
                                        </label>
                                        <select id="idVehicles" name="vehicles[]" multiple size="4"
                                            class="mt-1 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                                            @foreach ($vehicles as $vehicle)
                                                <option value="{{ $vehicle->id }}">
                                                    {{ $vehicle->vehicleModel->brand->name }} -
                                                    {{ $vehicle->vehicleModel->name }} - Chasis:
                                                    {{ $vehicle->chassis }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @else
                                    <p class="mt-2 text-sm text-gray-500">Actualmente todos los vehículos poseen una
                                        oferta.
                                    </p>
                                @endif

                                @if (count($accessories) > 0)
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="idAccessories"
                                            class="block text-sm font-medium text-gray-700">Accesorios:
                                        </label>
                                        <select id="idAccessories" name="accessories[]" multiple size="4"
                                            class="mt-1 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                                            @foreach ($accessories as $accessory)
                                                <option value="{{ $accessory->id }}">
                                                    {{ $accessory->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @else
                                    <p class="mt-2 text-sm text-gray-500">Actualmente todos los accesorios poseen una
                                        oferta.
                                    </p>
                                @endif
                            </div>
                            <div class="bg-gray-50 px-4 py-3 text-right sm:px-6">
                                <button type="submit"
                                    class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Crear</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>

@endsection
