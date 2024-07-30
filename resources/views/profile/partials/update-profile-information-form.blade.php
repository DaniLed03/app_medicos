<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Información del Perfil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Actualiza la información del perfil y la dirección de correo electrónico de tu cuenta.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="nombres" :value="__('Nombres')" />
            <x-text-input id="nombres" name="nombres" type="text" class="mt-1 block w-full" :value="old('nombres', $user->nombres)" autofocus autocomplete="nombres" />
            <x-input-error class="mt-2" :messages="$errors->get('nombres')" />
        </div>

        <div>
            <x-input-label for="apepat" :value="__('Apellido Paterno')" />
            <x-text-input id="apepat" name="apepat" type="text" class="mt-1 block w-full" :value="old('apepat', $user->apepat)" autocomplete="apepat" />
            <x-input-error class="mt-2" :messages="$errors->get('apepat')" />
        </div>

        <div>
            <x-input-label for="apemat" :value="__('Apellido Materno')" />
            <x-text-input id="apemat" name="apemat" type="text" class="mt-1 block w-full" :value="old('apemat', $user->apemat)" autocomplete="apemat" />
            <x-input-error class="mt-2" :messages="$errors->get('apemat')" />
        </div>

        <div>
            <x-input-label for="fechanac" :value="__('Fecha de Nacimiento')" />
            <x-text-input id="fechanac" name="fechanac" type="date" class="mt-1 block w-full" :value="old('fechanac', $user->fechanac)" autocomplete="bday" />
            <x-input-error class="mt-2" :messages="$errors->get('fechanac')" />
        </div>

        <div>
            <x-input-label for="telefono" :value="__('Teléfono')" />
            <x-text-input id="telefono" name="telefono" type="text" class="mt-1 block w-full" :value="old('telefono', $user->telefono)" autocomplete="tel" />
            <x-input-error class="mt-2" :messages="$errors->get('telefono')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Correo Electrónico')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Tu dirección de correo electrónico no está verificada.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Haz clic aquí para reenviar el correo de verificación.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('Se ha enviado un nuevo enlace de verificación a tu dirección de correo electrónico.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Guardar') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Guardado.') }}</p>
            @endif
        </div>
    </form>
</section>
