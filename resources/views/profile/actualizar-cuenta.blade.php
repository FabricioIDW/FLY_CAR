@extends('layouts.plantilla')
@section('title', 'Modificar cuenta')
@section('titleH1', 'Modificar cuenta')
@section('content')
    @php
        $route = '';
        if (Auth::user()->customer || Auth::user()->seller) {
            $route = Auth::user()->customer ? route('usersCustomer.update') : route('usersSeller.update');
        }
    @endphp
    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @if (Auth::user()->customer || Auth::user()->seller)
                <form action="{{ $route }}" method="POST">
                    @csrf
                    @method('put')
                    <!-- Name -->
                    <div class="col-span-6 sm:col-span-4">
                        <x-jet-label for="name" value="{{ __('Nombre') }}" />
                        <x-jet-input id="name" type="text" class="mt-1 block w-full" name="name"
                            value="{{ Auth::user()->customer ? Auth::user()->customer->name : Auth::user()->seller->name }}"
                            autocomplete="name" />
                        <x-jet-input-error for="name" class="mt-2" />
                    </div>

                    <!-- Last Name -->
                    <div class="col-span-6 sm:col-span-4">
                        <x-jet-label for="lastName" value="{{ __('Apellido') }}" />
                        <x-jet-input id="lastName" type="text" class="mt-1 block w-full" name="lastName"
                            value="{{ Auth::user()->customer ? Auth::user()->customer->lastName : Auth::user()->seller->lastName }}"
                            autocomplete="lastName" />
                        <x-jet-input-error for="lastName" class="mt-2" />
                    </div>

                    @if (Auth::user()->customer)
                        <!-- Address -->
                        <div class="col-span-6 sm:col-span-4">
                            <x-jet-label for="address" value="{{ __('Dirección') }}" />
                            <x-jet-input id="address" type="text" class="mt-1 block w-full" name="address"
                                autocomplete="address" value="{{ Auth::user()->customer->address }}" />
                            <x-jet-input-error for="address" class="mt-2" />
                        </div>
                        <!-- Bith Date -->
                        <div class="col-span-6 sm:col-span-4">
                            <x-jet-label for="birthDate" value="{{ __('Fecha de nacimiento') }}" />
                            <x-jet-input id="birthDate" type="date" name="birthDate" class="mt-1 block w-full"
                                autocomplete="birthDate" value="{{ Auth::user()->customer->birthDate }}" />
                            <x-jet-input-error for="birthDate" class="mt-2" />
                        </div>
                    @endif
                    <br>
                    <div class="col-span-6 sm:col-span-4 text-right">
                        <x-jet-button type="submit">
                            {{ __('Guardar') }}
                        </x-jet-button>
                    </div>
                </form>
            @endif
        </div>
        @livewire('profile.update-password-form')
    </div>
@endsection
