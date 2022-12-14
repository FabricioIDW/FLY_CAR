<div class="text-right">
    {{-- Do your work, then step back. --}}

    <x-jet-button wire:click="$set('open', true)">
        Cargar datos del cliente
    </x-jet-button>

    <x-jet-dialog-modal wire:model="open">
        <x-slot name="title" class="text-center">
            <x-jet-label value="Cargar datos del cliente" class="text-center text-2xl font-semibold" />
            {{-- Cargar datos del cliente --}}
        </x-slot>
        <x-slot name="content">
            <x-jet-label value="DNI" class="text-left" />
            <x-jet-input type="number" min="11111111" max="99999999" class="w-full" wire:model="dni" />
            <x-jet-input-error for="dni" />

            <x-jet-label value="Nombre" class="text-left" />
            <x-jet-input type="text" class="w-full" wire:model.defer="name" />
            <x-jet-input-error for="name" />

            <x-jet-label value="Apellido" class="text-left" />
            <x-jet-input type="text" class="w-full" wire:model.defer="lastName" />
            <x-jet-input-error for="lastName" />

            <x-jet-label value="Fecha de nacimiento" class="text-left" />
            <x-jet-input type="date" class="w-full" wire:model.defer="birthDate" />
            <x-jet-input-error for="birthDate" />

            <x-jet-label value="Dirección" class="text-left" />
            <x-jet-input type="text" class="w-full" wire:model.defer="address" />
            <x-jet-input-error for="address" />

            <x-jet-label value="Email" class="text-left" />
            <x-jet-input type="email" class="w-full" wire:model.defer="email" />
            <x-jet-input-error for="email" />

            {{-- @if ($hasQuotation)
                <p>{{ $message }}</p>
            @endif --}}

        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('open', false)">
                Cancelar
            </x-jet-secondary-button>
            <x-jet-danger-button wire:click="save" wire:loading.attr="disabled" wire:target="save"
                class="disabled:opacity-25">
                Generar cotización
            </x-jet-danger-button>
            {{-- <span wire:loading wire:target="save">Cargando...</span> --}}
        </x-slot>

    </x-jet-dialog-modal>
</div>
