
<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
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

            <!-- Telefono -->
            <div class="mt-4">
                <x-input-label for="telefono" :value="__('Teléfono')" />
                <x-text-input id="telefono" class="block mt-1 w-full" type="number" name="telefono" :value="old('telefono')" required autofocus autocomplete="tel" />
                <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
            </div>

            <!-- Rol -->
            <div class="mt-4 col-span-2">
                <x-input-label for="rol" :value="__('Rol')" />
                <select id="rol" name="rol" class="block mt-1 w-full" required>
                    <option value="medico" {{ old('rol') == 'medico' ? 'selected' : '' }}>Médico</option>
                    <option value="secretaria" {{ old('rol') == 'secretaria' ? 'selected' : '' }}>Secretaria</option>
                    <option value="colaborador" {{ old('rol') == 'colaborador' ? 'selected' : '' }}>Colaborador</option>
                </select>
                <x-input-error :messages="$errors->get('rol')" class="mt-2" />
            </div>

            <!-- Correo Electrónico -->
            <div class="mt-4 col-span-2">
                <x-input-label for="correo" :value="__('Correo Electrónico')" />
                <x-text-input id="email" class="block mt-1 w-full" type="text" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Contraseña -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Contraseña')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirmar Contraseña -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ml-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
