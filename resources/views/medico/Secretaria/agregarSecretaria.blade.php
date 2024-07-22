<form action="{{ route('secretarias.store') }}" method="POST">
    @csrf

    <!-- Nombres -->
    <div class="mt-4">
        <x-input-label for="nombres" :value="__('Nombres')" />
        <x-text-input id="nombres" class="block mt-1 w-full" type="text" name="nombres" :value="old('nombres')" required autofocus autocomplete="name" />
        <x-input-error :messages="$errors->get('nombres')" class="mt-2" />
    </div>

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

    <div class="grid grid-cols-2 gap-4">
        <!-- Teléfono -->
        <div class="mt-4">
            <x-input-label for="telefono" :value="__('Teléfono')" />
            <x-text-input id="telefono" class="block mt-1 w-full" type="number" name="telefono" :value="old('telefono')" required autofocus autocomplete="tel" />
            <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
        </div>

        <!-- Sexo -->
        <div class="mt-4">
            <x-input-label for="sexo" :value="__('Sexo')" />
            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                <label class="btn btn-secondary">
                    <input type="radio" name="sexo" id="masculino" value="masculino" autocomplete="off" required> Masculino
                </label>
                <label class="btn btn-secondary">
                    <input type="radio" name="sexo" id="femenino" value="femenino" autocomplete="off" required> Femenino
                </label>
            </div>
            <x-input-error :messages="$errors->get('sexo')" class="mt-2" />
        </div>
    </div>

    <!-- Correo Electrónico -->
    <div class="mt-4 col-span-2">
        <x-input-label for="email" :value="__('Correo Electrónico')" />
        <x-text-input id="email" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" type="email" name="email" :value="old('email')" required autocomplete="username" />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <div class="grid grid-cols-2 gap-4">
        <!-- Contraseña -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Contraseña')" />
            <x-text-input id="password" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirmar Contraseña -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>
    </div>

    <div class="flex items-center justify-end mt-4">
        <x-primary-button class="ml-4">
            {{ __('Registrar Secretaria') }}
        </x-primary-button>
    </div>
</form>
