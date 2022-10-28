<div>
    {{-- Do your work, then step back. --}}

    <x-jet-danger-button wire:click="$set('open', true)">
        Crear una oferta
    </x-jet-danger-button>

    <x-jet-dialog-modal wire:model="open">
        <x-slot name="title">
            Crear una oferta
        </x-slot>
        <x-slot name="content">
            <x-jet-label value="Descuento" />
            <x-jet-input type="number" step="0.01" min="0.01" max="99" class="w-full" wire:model="discount" />
            <x-jet-input-error for="discount" />

            <x-jet-label value="Fecha de inicio" />
            <x-jet-input type="date" class="w-full" wire:model.defer="startDate" />
            <x-jet-input-error for="startDate" />

            <x-jet-label value="Fecha de fin" />
            <x-jet-input type="date" class="w-full" wire:model.defer="endDate" />
            <x-jet-input-error for="endDate" />
            
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('open', false)">
                Cancelar
            </x-jet-secondary-button>
            <x-jet-danger-button wire:click="save" wire:loading.attr="disabled" wire:target="save" class="disabled:opacity-25">
                Crear oferta
            </x-jet-danger-button>
            {{-- <span wire:loading wire:target="save">Cargando...</span> --}}
        </x-slot>

    </x-jet-dialog-modal>
</div>
