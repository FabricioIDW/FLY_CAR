<x-jet-form-section submit="updateProfileInformation" action="{{ Auth::user()->customer ? route('usersCustomer.update') : route('usersSeller.update') }}">
    <x-slot name="title">
        {{ __('Información de la cuenta') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Modificar los datos de su cuenta.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Profile Photo -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">
                <!-- Profile Photo File Input -->
                <input type="file" class="hidden"
                            wire:model="photo"
                            x-ref="photo"
                            x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />

                <x-jet-label for="photo" value="{{ __('Photo') }}" />

                <!-- Current Profile Photo -->
                <div class="mt-2" x-show="! photoPreview">
                    <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}" class="rounded-full h-20 w-20 object-cover">
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" x-show="photoPreview" style="display: none;">
                    <span class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
                          x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <x-jet-secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.photo.click()">
                    {{ __('Select A New Photo') }}
                </x-jet-secondary-button>

                @if ($this->user->profile_photo_path)
                    <x-jet-secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">
                        {{ __('Remove Photo') }}
                    </x-jet-secondary-button>
                @endif

                <x-jet-input-error for="photo" class="mt-2" />
            </div>
        @endif
        
        <form action="{{ Auth::user()->customer ? route('usersCustomer.update') : route('usersSeller.update') }}">
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
        
        @if ($this->user->customer)            
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

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) && ! $this->user->hasVerifiedEmail())
                <p class="text-sm mt-2">
                    {{ __('Your email address is unverified.') }}

                    <button type="button" class="underline text-sm text-gray-600 hover:text-gray-900" wire:click.prevent="sendEmailVerification">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>

                @if ($this->verificationLinkSent)
                    <p v-show="verificationLinkSent" class="mt-2 font-medium text-sm text-green-600">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </p>
                @endif
            @endif
        </div>
        </form>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Datos guardados.') }}
        </x-jet-action-message>

        <x-jet-button wire:loading.attr="disabled" wire:target="photo">
            {{ __('Guardar') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
