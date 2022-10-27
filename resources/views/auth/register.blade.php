<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>


        <div class="flex items-center justify-center mt-4">
            <a href="{{ route('usersCustomer.createExisting') }}">
                <x-jet-button class="ml-4">
                    {{ __('¿Fue cliente de manera presencial?') }}
                </x-jet-button>
            </a>
        </div>
        <div class="flex items-center justify-center mt-4">
            <a href="{{ route('usersCustomer.createNew') }}">
                <x-jet-button class="ml-4">
                    {{ __('Crear nueva cuenta') }}
                </x-jet-button>
            </a>
        </div>
    </x-jet-authentication-card>
</x-guest-layout>
