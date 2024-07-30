<x-app-layout>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-xl font-bold text-gray-900 uppercase">Completar Registro de Paciente</h1>
                    <form method="POST" action="{{ route('pacientes.storeDesdeModal') }}">
                        @csrf
                        <input type="hidden" name="citaId" value="{{ $citaId }}">

                        <!-- Nombres -->
                        <div class="mt-4">
                            <x-input-label for="nombres" :value="__('Nombres')" />
                            <x-text-input id="nombres" class="block mt-1 w-full" type="text" name="nombres" :value="old('nombres', $datosPersona['nombres'])" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('nombres')" class="mt-2" />
                        </div>
                        
                        <!-- Apellido Paterno -->
                        <div class="mt-4">
                            <x-input-label for="apepat" :value="__('Apellido Paterno')" />
                            <x-text-input id="apepat" class="block mt-1 w-full" type="text" name="apepat" :value="old('apepat', $datosPersona['apepat'])" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('apepat')" class="mt-2" />
                        </div>
                        
                        <!-- Apellido Materno -->
                        <div class="mt-4">
                            <x-input-label for="apemat" :value="__('Apellido Materno')" />
                            <x-text-input id="apemat" class="block mt-1 w-full" type="text" name="apemat" :value="old('apemat', $datosPersona['apemat'])" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('apemat')" class="mt-2" />
                        </div>
                        
                        <!-- Fecha de Nacimiento -->
                        <div class="mt-4">
                            <x-input-label for="fechanac" :value="__('Fecha de Nacimiento')" />
                            <x-text-input id="fechanac" class="block mt-1 w-full" type="date" name="fechanac" :value="old('fechanac', $datosPersona['fechanac'])" required autofocus />
                            <x-input-error :messages="$errors->get('fechanac')" class="mt-2" />
                        </div>

                        <!-- Correo -->
                        <div class="mt-4">
                            <x-input-label for="correo" :value="__('Correo')" />
                            <x-text-input id="correo" class="block mt-1 w-full" type="email" name="correo" :value="old('correo', $datosPersona['correo'])" required autofocus />
                            <x-input-error :messages="$errors->get('correo')" class="mt-2" />
                        </div>
                        
                        <!-- CURP -->
                        <div class="mt-4">
                            <x-input-label for="curp" :value="__('CURP')" />
                            <x-text-input id="curp" class="block mt-1 w-full" type="text" name="curp" :value="old('curp', $datosPersona['curp'])" required autofocus />
                            <x-input-error :messages="$errors->get('curp')" class="mt-2" />
                        </div>

                        <!-- Teléfono -->
                        <div class="mt-4">
                            <x-input-label for="telefono" :value="__('Teléfono')" />
                            <x-text-input id="telefono" class="block mt-1 w-full" type="text" name="telefono" :value="old('telefono', $datosPersona['telefono'])" required autofocus />
                            <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
                        </div>
                        
                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Guardar Paciente') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
