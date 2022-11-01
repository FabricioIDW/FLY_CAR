@extends('layouts.plantilla')
@section('title', 'Principal')
@section('titleH1', 'Crear cuenta de vendedor')

@section('content')
    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">

            <form method="POST" action="{{ route('usersSeller.store') }}">
                {{-- <x-jet-validation-errors class="mb-4" /> --}}
                @csrf
                <div>
                    <x-jet-label for="name" value="{{ __('Nombre') }}" />
                    <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                        required autofocus autocomplete="firstName" />
                    @error('name')
                        <p class="mt-2 text-sm text-red-500">*{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <x-jet-label for="lastName" value="{{ __('Apellido') }}" />
                    <x-jet-input id="lastName" class="block mt-1 w-full" type="text" name="lastName" :value="old('lastName')"
                        required autofocus autocomplete="lastName" />
                    @error('lastName')
                        <p class="mt-2 text-sm text-red-500">*{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <x-jet-label for="dni" value="{{ __('DNI') }}" />
                    <x-jet-input id="dni" class="block mt-1 w-full" type="text" name="dni" :value="old('dni')"
                        required autofocus autocomplete="dni" />
                    @error('dni')
                        <p class="mt-2 text-sm text-red-500">*{{ $message }}</p>
                    @enderror
                </div>

                <fieldset name="userData">
                    <div class="mt-4">
                        <x-jet-label for="email" value="{{ __('Email') }}" />
                        <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email"
                            :value="old('email')" required />
                        @error('email')
                            <p class="mt-2 text-sm text-red-500">*{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <x-jet-label for="password" value="{{ __('Contraseña') }}" />
                        <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required
                            autocomplete="new-password" />
                        @error('password')
                            <p class="mt-2 text-sm text-red-500">*{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <x-jet-label for="password_confirmation" value="{{ __('Confirmar contraseña') }}" />
                        <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password"
                            name="password_confirmation" required autocomplete="new-password" />
                        @error('password_confirmation')
                            <p class="mt-2 text-sm text-red-500">*{{ $message }}</p>
                        @enderror
                    </div>
                </fieldset>
                @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                    <div class="mt-4">
                        <x-jet-label for="terms">
                            <div class="flex items-center">
                                <x-jet-checkbox name="terms" id="terms" />

                                <div class="ml-2">
                                    {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' =>
                                            '<a target="_blank" href="' .
                                            route('terms.show') .
                                            '" class="underline text-sm text-gray-600 hover:text-gray-900">' .
                                            __('Terms of Service') .
                                            '</a>',
                                        'privacy_policy' =>
                                            '<a target="_blank" href="' .
                                            route('policy.show') .
                                            '" class="underline text-sm text-gray-600 hover:text-gray-900">' .
                                            __('Privacy Policy') .
                                            '</a>',
                                    ]) !!}
                                </div>
                            </div>
                        </x-jet-label>
                    </div>
                @endif

                <div class="flex items-center justify-end mt-4">

                    <x-jet-button class="ml-4">
                        {{ __('Crear cuenta') }}
                    </x-jet-button>
                </div>
            </form>
        </div>
    </div>

@endsection
