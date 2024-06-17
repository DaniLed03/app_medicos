<x-app-layout>
    <x-guest-layout>
        <form method="POST" action="{{ route('registrarPaciente.store') }}">
            @csrf

            <!-- Nombres -->
            <div class="mt-4 col-span-2">
                <x-input-label for="nombres" :value="__('Nombres')" />
                <x-text-input id="nombres" class="block mt-1 w-full" type="text" name="nombres" :value="old('nombres')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('nombres')" class="mt-2" />
            </div>

            <div class="grid grid-cols-2 gap-4">
                <!-- Apellido Paterno -->
                <div class="mt-4">
                    <x-input-label for="apepat" :value="__('Apellido Paterno')" />
                    <x-text-input id="apepat" class="block mt-1 w-full" type="text" name="apepat" :value="old('apepat')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('apepat')" class="mt-2" />
                </div>

                <!-- Apellido Materno -->
                <div class="mt-4">
                    <x-input-label for="apemat" :value="__('Apellido Materno')" />
                    <x-text-input id="apemat" class="block mt-1 w-full" type="text" name="apemat" :value="old('apemat')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('apemat')" class="mt-2" />
                </div>

                <!-- Fecha de Nacimiento -->
                <div class="mt-4">
                    <x-input-label for="fechanac" :value="__('Fecha de Nacimiento')" />
                    <x-text-input id="fechanac" class="block mt-1 w-full" type="date" name="fechanac" :value="old('fechanac')" required autofocus />
                    <x-input-error :messages="$errors->get('fechanac')" class="mt-2" />
                </div>
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="ml-4">
                    {{ __('Registrar Usuario') }}
                </x-primary-button>
            </div>
        </form>
    </x-guest-layout>
</x-app-layout>
