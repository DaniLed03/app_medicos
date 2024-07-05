<x-app-layout>
    <x-guest-layout>
        <form method="POST" action="{{ route('medicos.update', $medico->id) }}">
            @csrf
            @method('PATCH')

            <!-- Nombres -->
            <div class="mt-4 col-span-2">
                <x-input-label for="nombres" :value="__('Nombres')" />
                <x-text-input id="nombres" class="block mt-1 w-full" type="text" name="nombres" :value="$medico->nombres" required autofocus />
                <x-input-error :messages="$errors->get('nombres')" class="mt-2" />
            </div>

            <!-- Apellido Paterno -->
            <div class="mt-4">
                <x-input-label for="apepat" :value="__('Apellido Paterno')" />
                <x-text-input id="apepat" class="block mt-1 w-full" type="text" name="apepat" :value="$medico->apepat" required autofocus />
                <x-input-error :messages="$errors->get('apepat')" class="mt-2" />
            </div>

            <!-- Apellido Materno -->
            <div class="mt-4">
                <x-input-label for="apemat" :value="__('Apellido Materno')" />
                <x-text-input id="apemat" class="block mt-1 w-full" type="text" name="apemat" :value="$medico->apemat" required autofocus />
                <x-input-error :messages="$errors->get('apemat')" class="mt-2" />
            </div>

            <!-- Fecha de Nacimiento -->
            <div class="mt-4">
                <x-input-label for="fechanac" :value="__('Fecha de Nacimiento')" />
                <x-text-input id="fechanac" class="block mt-1 w-full" type="date" name="fechanac" :value="$medico->fechanac" required />
                <x-input-error :messages="$errors->get('fechanac')" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="$medico->email" required />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Telefono -->
            <div class="mt-4">
                <x-input-label for="telefono" :value="__('Teléfono')" />
                <x-text-input id="telefono" class="block mt-1 w-full" type="text" name="telefono" :value="$medico->telefono" required />
                <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
            </div>

            <!-- Contraseña -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Contraseña')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirmar Contraseña -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="ml-4">
                    {{ __('Actualizar Médico') }}
                </x-primary-button>
            </div>
        </form>
    </x-guest-layout>
</x-app-layout>
