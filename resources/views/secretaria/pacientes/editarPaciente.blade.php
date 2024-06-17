<x-app-layout>
    <x-guest-layout>
        <form method="POST" action="{{ route('pacientes.update', $paciente->id) }}">
            @csrf
            @method('PATCH')

            <!-- Nombres -->
            <div class="mt-4 col-span-2">
                <x-input-label for="nombres" :value="__('Nombres')" />
                <x-text-input id="nombres" class="block mt-1 w-full" type="text" name="nombres" :value="$paciente->nombres" required autofocus />
                <x-input-error :messages="$errors->get('nombres')" class="mt-2" />
            </div>

            <!-- Apellido Paterno -->
            <div class="mt-4">
                <x-input-label for="apepat" :value="__('Apellido Paterno')" />
                <x-text-input id="apepat" class="block mt-1 w-full" type="text" name="apepat" :value="$paciente->apepat" required autofocus />
                <x-input-error :messages="$errors->get('apepat')" class="mt-2" />
            </div>

            <!-- Apellido Materno -->
            <div class="mt-4">
                <x-input-label for="apemat" :value="__('Apellido Materno')" />
                <x-text-input id="apemat" class="block mt-1 w-full" type="text" name="apemat" :value="$paciente->apemat" required autofocus />
                <x-input-error :messages="$errors->get('apemat')" class="mt-2" />
            </div>

            <!-- Fecha de Nacimiento -->
            <div class="mt-4">
                <x-input-label for="fechanac" :value="__('Fecha de Nacimiento')" />
                <x-text-input id="fechanac" class="block mt-1 w-full" type="date" name="fechanac" :value="$paciente->fechanac" required />
                <x-input-error :messages="$errors->get('fechanac')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="ml-4">
                    {{ __('Actualizar Paciente') }}
                </x-primary-button>
            </div>
        </form>
    </x-guest-layout>
</x-app-layout>
