<div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full modal-content">
    <div class="modal-header relative">
        <h2 class="font-bold text-center" style="color:#2D7498;">Agregar Persona</h2>
        <button type="button" class="text-black absolute right-0 top-0" @click="isPersonaModalOpen = false">
            <svg class="h-6 w-6 fill-none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="stroke: black !important;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
    <form method="POST" action="{{ route('personas.storeDesdeModal') }}" id="addPersonaForm">
        @csrf
        <div class="form-group">
            <x-input-label for="nombres" :value="__('Nombres')" />
            <x-text-input id="nombres" class="block mt-1 w-full" type="text" name="nombres" :value="old('nombres')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('nombres')" class="mt-2" />
        </div>
        <div class="form-group">
            <x-input-label for="apepat" :value="__('Apellido Paterno')" />
            <x-text-input id="apepat" class="block mt-1 w-full" type="text" name="apepat" :value="old('apepat')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('apepat')" class="mt-2" />
        </div>
        <div class="form-group">
            <x-input-label for="apemat" :value="__('Apellido Materno')" />
            <x-text-input id="apemat" class="block mt-1 w-full" type="text" name="apemat" :value="old('apemat')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('apemat')" class="mt-2" />
        </div>
        <div class="form-group">
            <x-input-label for="fechanac" :value="__('Fecha de Nacimiento')" />
            <x-text-input id="fechanac" class="block mt-1 w-full" type="date" name="fechanac" :value="old('fechanac')" required autofocus />
            <x-input-error :messages="$errors->get('fechanac')" class="mt-2" />
        </div>
        <div class="form-group">
            <x-input-label for="curp" :value="__('CURP')" />
            <x-text-input id="curp" class="block mt-1 w-full" type="text" name="curp" :value="old('curp')" required autofocus />
            <x-input-error :messages="$errors->get('curp')" class="mt-2" />
        </div>
        <div class="form-group grid grid-cols-2 gap-4">
            <div>
                <x-input-label for="telefono" :value="__('Teléfono')" />
                <x-text-input id="telefono" class="block mt-1 w-full" type="text" name="telefono" :value="old('telefono')" required autofocus />
                <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
            </div>
            <!-- Sexo -->
            <div class="mt-4">
                <x-input-label for="sexo" :value="__('Sexo')" />
                <div class="flex items-center space-x-4">
                    <div class="flex items-center">
                        <input type="radio" id="masculino" name="sexo" value="masculino" class="mr-2" required>
                        <label for="masculino" class="text-sm font-medium text-gray-700">Masculino</label>
                    </div>
                    <div class="flex items-center">
                        <input type="radio" id="femenino" name="sexo" value="femenino" class="mr-2" required>
                        <label for="femenino" class="text-sm font-medium text-gray-700">Femenino</label>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('sexo')" class="mt-2" />
            </div>
        </div>
        <div class="form-group">
            <x-input-label for="correo" :value="__('Correo')" />
            <x-text-input id="correo" class="block mt-1 w-full" type="email" name="correo" :value="old('correo')" required />
            <x-input-error :messages="$errors->get('correo')" class="mt-2" />
        </div>
        <div class="form-group">
            <x-input-label for="password" :value="__('Contraseña (Opcional)')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        <div class="modal-footer">
            <button type="submit" class="bg-blue-500 text-white p-2 rounded-md">Registrar Persona</button>
        </div>
    </form>
</div>
