<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg">
                <!-- Account page navigation-->
                <nav class="nav nav-borders justify-content-center">
                    <a class="nav-link active ms-0" id="information-tab" href="#information" data-bs-toggle="tab">Información</a>
                    <a class="nav-link" id="password-tab" href="#password" data-bs-toggle="tab">Contraseña</a>
                </nav>
                <hr class="mt-0 mb-4">
                <div class="tab-content px-4">
                    <!-- Update Profile Information Form -->
                    <div class="tab-pane fade show active" id="information">
                        <div class="row">
                            <div class="col-md-4 d-flex justify-content-center">
                                <!-- Profile picture card-->
                                <div class="card mb-4 text-center">
                                    <div class="card-header">Foto de Perfil</div>
                                    <div class="card-body position-relative">
                                        <!-- Profile picture image-->
                                        <img id="profile-pic-preview" src="{{ $user->foto ? asset('storage/' . $user->foto) : asset('images/default-profile.png') }}" alt="Foto de perfil" class="img-account-profile rounded-circle mb-2">
                                        <!-- Overlay for image upload -->
                                        <div id="upload-overlay" class="upload-overlay" onclick="document.getElementById('foto').click()">
                                            <div class="overlay-text">Subir nueva imagen</div>
                                        </div>
                                        <input type="file" id="foto" name="foto" accept="image/*" class="form-control d-none" onchange="previewImage(event)">
                                        <x-input-error class="mt-2" :messages="$errors->get('foto')" />
                                        <!-- Profile picture help block-->
                                        <div class="small font-italic text-muted mt-2">JPG o PNG no mayor a 2 MB</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <form method="post" action="{{ route('profile.update') }}" class="mt-3" enctype="multipart/form-data" id="profile-form">
                                    @csrf
                                    @method('patch')

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <x-input-label for="nombres" :value="__('Nombres')" />
                                            <x-text-input id="nombres" name="nombres" type="text" class="form-control" :value="old('nombres', $user->nombres)" autofocus autocomplete="nombres" />
                                            <x-input-error class="mt-2" :messages="$errors->get('nombres')" />
                                        </div>
                                        <div class="col-md-6">
                                            <x-input-label for="apepat" :value="__('Apellido Paterno')" />
                                            <x-text-input id="apepat" name="apepat" type="text" class="form-control" :value="old('apepat', $user->apepat)" autocomplete="apepat" />
                                            <x-input-error class="mt-2" :messages="$errors->get('apepat')" />
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <x-input-label for="apemat" :value="__('Apellido Materno')" />
                                            <x-text-input id="apemat" name="apemat" type="text" class="form-control" :value="old('apemat', $user->apemat)" autocomplete="apemat" />
                                            <x-input-error class="mt-2" :messages="$errors->get('apemat')" />
                                        </div>
                                        <div class="col-md-6">
                                            <x-input-label for="fechanac" :value="__('Fecha de Nacimiento')" />
                                            <x-text-input id="fechanac" name="fechanac" type="date" class="form-control" :value="old('fechanac', $user->fechanac)" autocomplete="bday" />
                                            <x-input-error class="mt-2" :messages="$errors->get('fechanac')" />
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <x-input-label for="telefono" :value="__('Teléfono')" />
                                            <x-text-input id="telefono" name="telefono" type="text" class="form-control" :value="old('telefono', $user->telefono)" autocomplete="tel" />
                                            <x-input-error class="mt-2" :messages="$errors->get('telefono')" />
                                        </div>
                                        <div class="col-md-6">
                                            <x-input-label for="email" :value="__('Correo Electrónico')" />
                                            <x-text-input id="email" name="email" type="email" class="form-control" :value="old('email', $user->email)" required autocomplete="username" />
                                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                                        </div>
                                    </div>

                                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                        <div class="mt-3">
                                            <p class="text-sm text-gray-800">
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

                                    <div class="mt-3">
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
                            </div>
                        </div>
                    </div>

                    <!-- Update Password Form -->
                    <div class="tab-pane fade" id="password">
                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <form method="post" action="{{ route('password.update') }}" class="mt-3">
                                    @csrf
                                    @method('put')

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <x-input-label for="current_password" :value="__('Contraseña Actual')" />
                                            <x-text-input id="current_password" name="current_password" type="password" class="form-control" autocomplete="current-password" required />
                                            <x-input-error class="mt-2" :messages="$errors->get('current_password')" />
                                        </div>
                                        <div class="col-md-6">
                                            <x-input-label for="new_password" :value="__('Nueva Contraseña')" />
                                            <x-text-input id="new_password" name="new_password" type="password" class="form-control" autocomplete="new-password" required />
                                            <x-input-error class="mt-2" :messages="$errors->get('new_password')" />
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <x-input-label for="new_password_confirmation" :value="__('Confirmar Contraseña')" />
                                            <x-text-input id="new_password_confirmation" name="new_password_confirmation" type="password" class="form-control" autocomplete="new-password_confirmation" required />
                                            <x-input-error class="mt-2" :messages="$errors->get('new_password_confirmation')" />
                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <x-primary-button>{{ __('Actualizar Contraseña') }}</x-primary-button>
                                    </div>
                                </form>
                                <br>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- Agrega en el head o al final del body en tu layout principal -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    body { 
        background-color: #f2f6fc; 
        color: #69707a; 
    }
    .img-account-profile {
        height: 20rem;
        width: 20rem;
        object-fit: cover;
        position: relative;
        border-radius: 50%;
    }
    .upload-overlay {
        position: absolute;
        top: 4%;
        left: 4%;
        height: 84%;
        width: 92%;
        background-color: rgba(0, 0, 0, 0.5);
        color: white;
        display: none;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        border-radius: 70%;
    }
    .img-account-profile:hover + .upload-overlay, 
    .upload-overlay:hover {
        display: flex;
    }
    .overlay-text {
        font-size: 1.25rem;
        font-weight: 500;
    }
    .card {
        box-shadow: 0 0.15rem 1.75rem 0 rgb(33 40 50 / 15%);
    }
    .card-header {
        font-weight: 500;
        background-color: rgba(33, 40, 50, 0.03);
        border-bottom: 1px solid rgba(33, 40, 50, 0.125);
    }
    .nav-borders .nav-link.active {
        color: #0061f2;
        border-bottom-color: #0061f2;
    }
    .nav-borders .nav-link {
        color: #69707a;
        border-bottom-width: 0.125rem;
        border-bottom-style: solid;
        border-bottom-color: transparent;
        padding-top: 0.5rem;
        padding-bottom: 0.5rem;
        margin-left: 1rem;
        margin-right: 1rem;
    }
</style>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('profile-pic-preview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

<script>
    // Mostrar mensaje de éxito al actualizar el perfil
    @if (session('status') === 'profile-updated')
        Swal.fire({
            icon: 'success',
            title: 'Perfil Actualizado',
            text: 'Tu información de perfil se ha actualizado exitosamente.',
            timer: 3000,
            showConfirmButton: false
        });
    @endif

    // Mostrar mensaje de éxito al actualizar la contraseña
    @if (session('status') === 'password-updated')
        Swal.fire({
            icon: 'success',
            title: 'Contraseña Actualizada',
            text: 'Tu contraseña se ha actualizado exitosamente.',
            timer: 3000,
            showConfirmButton: false
        });
    @endif

    // Mostrar errores si existen
    @if ($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Error en la Actualización',
            html: '{!! implode('<br>', $errors->all()) !!}',
        });
    @endif
</script>
