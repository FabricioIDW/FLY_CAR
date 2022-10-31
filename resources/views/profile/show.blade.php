<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cuenta') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">   
            <form action="{{  route('usersSeller.update') }}">
                <!-- Name -->
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="name" value="{{ __('Nombre') }}" />
                <x-jet-input id="name" type="text" class="mt-1 block w-full" value="{{ Auth::user()->customer ? Auth::user()->customer->name : Auth::user()->seller->name }}" autocomplete="name"  />
                <x-jet-input-error for="name" class="mt-2" />
            </div>
            
            <!-- Last Name -->
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="lastName" value="{{ __('Apellido') }}" />
                <x-jet-input id="lastName" type="text" class="mt-1 block w-full" value="{{ Auth::user()->customer ? Auth::user()->customer->lastName : Auth::user()->seller->lastName }}" autocomplete="lastName" />
                <x-jet-input-error for="lastName" class="mt-2" />
            </div>
            
            @if (Auth::user()->customer)            
            <!-- Address -->
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="address" value="{{ __('Dirección') }}" />
                <x-jet-input id="address" type="text" class="mt-1 block w-full" wire:model.defer="state.address" autocomplete="address" />
                <x-jet-input-error for="address" class="mt-2" />
            </div>
            <!-- Bith Date -->
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="birthDate" value="{{ __('Fecha de nacimiento') }}" />
                <x-jet-input id="birthDate" type="date" class="mt-1 block w-full" wire:model.defer="state.birthDate" autocomplete="birthDate" />
                <x-jet-input-error for="birthDate" class="mt-2" />
            </div>
            @endif
            <!-- Email -->
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="state.email" />
                <x-jet-input-error for="email" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-jet-button type="submit">
                    {{ __('Guardar') }}
                </x-jet-button>
            </div>
            </form>
{{-- 
            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.update-password-form')
                </div>

                <x-jet-section-border />
            @endif --}}

            {{-- @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.two-factor-authentication-form')
                </div>

                <x-jet-section-border />
            @endif

            <div class="mt-10 sm:mt-0">
                @livewire('profile.logout-other-browser-sessions-form')
            </div>

            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                <x-jet-section-border />

                <div class="mt-10 sm:mt-0">
                    @livewire('profile.delete-user-form')
                </div>
            @endif --}}
        </div>
    </div>
</x-app-layout>
