<!-- dashboard.blade.php -->

<x-app-layout>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-xl font-bold text-gray-900 uppercase">Lista de Pacientes</h1>

                    <div class="flex items-center space-x-4 mb-4">
                        <!-- Contenedor de Total Pacientes -->
                        <div class="bg-white p-4 shadow-2xl rounded-md flex items-center space-x-4">
                            <div class="bg-icon-color p-2 rounded-full">
                                <svg class="w-8 h-8 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M12 6a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7Zm-1.5 8a4 4 0 0 0-4 4 2 2 0 0 0 2 2h7a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-3Zm6.82-3.096a5.51 5.51 0 0 0-2.797-6.293 3.5 3.5 0 1 1 2.796 6.292ZM19.5 18h.5a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-1.1a5.503 5.503 0 0 1-.471.762A5.998 5.998 0 0 1 19.5 18ZM4 7.5a3.5 3.5 0 0 1 5.477-2.889 5.5 5.5 0 0 0-2.796 6.293A3.501 3.501 0 0 1 4 7.5ZM7.1 12H6a4 4 0 0 0-4 4 2 2 0 0 0 2 2h.5a5.998 5.998 0 0 1 3.071-5.238A5.505 5.505 0 0 1 7.1 12Z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="text-center">
                                <h2 class="text-lg font-bold">Total Pacientes: {{ $totalPacientes }}</h2>
                            </div>
                        </div>
                        <!-- Contenedor de Mujeres y Hombres -->
                        <div class="flex items-center space-x-4">
                            <div class="bg-white p-4 shadow-2xl rounded-md flex items-center space-x-4">
                                <div class="bg-icon-color p-2 rounded-full">
                                    <img src="{{ asset('images/woman.svg') }}" class="w-8 h-8 text-white" alt="Icono de Mujer">
                                </div>
                                <div class="text-center">
                                    <h2 class="text-lg font-bold">Mujeres: {{ number_format($porcentajeMujeres, 1) }}%</h2>
                                </div>
                                <div class="bg-icon-color p-2 rounded-full">
                                    <img src="{{ asset('images/man.svg') }}" class="w-8 h-8 text-white" alt="Icono de Hombre">
                                </div>
                                <div class="text-center">
                                    <h2 class="text-lg font-bold">Hombres: {{ number_format($porcentajeHombres, 1) }}%</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de pacientes -->
                    <div class="overflow-x-auto bg-white dark:bg-neutral-700">
                        <!-- Filtro -->
                        <form method="GET" action="{{ route('pacientes.index') }}" class="my-4 flex items-center justify-between">
                            <div class="flex space-x-4">
                                <input type="text" name="name" placeholder="Buscar por nombre..." class="border rounded-md px-4 py-2">
                                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Filtrar</button>
                                <a href="{{ route('pacientes.index') }}" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    <span>Reset</span>
                                </a>
                            </div>
                            <div>
                                <button type="button" id="openModal" class="bg-button-color hover:bg-button-hover text-white py-2 px-4 rounded">
                                    Agregar Paciente
                                </button>
                            </div>
                        </form>
                        <!-- Table -->
                        <table class="min-w-full text-center text-sm whitespace-nowrap">
                            <!-- Table head -->
                            <thead class="uppercase tracking-wider border-b-2 dark:border-neutral-600 bg-table-header-color">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-white font-bold">Nombres</th>
                                    <th scope="col" class="px-6 py-4 text-white font-bold">Apellido Paterno</th>
                                    <th scope="col" class="px-6 py-4 text-white font-bold">Apellido Materno</th>
                                    <th scope="col" class="px-6 py-4 text-white font-bold">Correo</th>
                                    <th scope="col" class="px-6 py-4 text-white font-bold">Teléfono</th>
                                    <th scope="col" class="px-6 py-4 text-white font-bold">Sexo</th>
                                    <th scope="col" class="px-6 py-4 text-white font-bold">Activo</th>
                                    <th scope="col" class="px-6 py-4 text-white font-bold">Acciones</th>
                                </tr>
                            </thead>

                            <!-- Table body -->
                            <tbody>
                                @foreach($pacientes as $paciente)
                                    <tr class="border-b dark:border-neutral-600">
                                        <td class="px-6 py-4">{{ $paciente->nombres }}</td>
                                        <td class="px-6 py-4">{{ $paciente->apepat }}</td>
                                        <td class="px-6 py-4">{{ $paciente->apemat }}</td>
                                        <td class="px-6 py-4">{{ $paciente->correo }}</td>
                                        <td class="px-6 py-4">{{ $paciente->telefono }}</td>
                                        <td class="px-6 py-4">{{ $paciente->sexo }}</td>
                                        <td class="px-6 py-4">{{ $paciente->activo }}</td>
                                        <td class="px-6 py-4">
                                            <!-- Enlace para editar el paciente -->
                                            <a href="{{ route('pacientes.editar', $paciente->id) }}" class="text-blue-500 hover:text-blue-700 edit-button" data-id="{{ $paciente->id }}">Editar</a>
                                            <!-- Formulario para eliminar el paciente -->
                                            <form action="{{ route('pacientes.eliminar', $paciente->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 ml-4">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- Mensaje si no hay pacientes registrados -->
                        @if($pacientes->isEmpty())
                            <p class="text-center text-gray-500 mt-4">No hay pacientes registrados.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="modal" class="fixed z-10 inset-0 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity" aria-hidden="true"></div>
            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="sm:flex sm:items-center w-full">
                            <h3 class="text-2xl leading-6 font-bold text-center text-gray-900 w-full" style="color: #316986;">
                                Agregar Paciente
                            </h3>
                            <button type="button" class="absolute top-0 right-0 mt-4 mr-4 text-gray-400 hover:text-gray-500 text-4xl" id="closeModal">
                                <span class="sr-only">Close</span>
                                &times;
                            </button>
                        </div>
                    </div>
                    <div class="border-t border-gray-200 mt-4"></div>
                    <div class="mt-2">
                        <form method="POST" action="{{ route('registrarPaciente.store') }}" id="addPacienteForm">
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

                                <!-- Teléfono -->
                                <div class="mt-4">
                                    <x-input-label for="telefono" :value="__('Teléfono')" />
                                    <x-text-input id="telefono" class="block mt-1 w-full" type="text" name="telefono" :value="old('telefono')" required autofocus />
                                    <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Sexo -->
                            <div class="mt-4 col-span-2">
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

                            <!-- Correo -->
                            <div class="mt-4 col-span-2">
                                <x-input-label for="correo" :value="__('Correo')" />
                                <x-text-input id="correo" class="block mt-1 w-full" type="email" name="correo" :value="old('correo')" required />
                                <x-input-error :messages="$errors->get('correo')" class="mt-2" />
                            </div>

                            <!-- Contraseña -->
                            <div class="mt-4 col-span-2">
                                <x-input-label for="contraseña" :value="__('Contraseña')" />
                                <x-text-input id="contraseña" class="block mt-1 w-full" type="password" name="contraseña" required />
                                <x-input-error :messages="$errors->get('contraseña')" class="mt-2" />
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <x-primary-button class="ml-4">
                                    {{ __('Registrar Usuario') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Editar -->
    <div id="modalEditar" class="fixed z-10 inset-0 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity" aria-hidden="true"></div>
            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="sm:flex sm:items-center w-full">
                            <h3 class="text-2xl leading-6 font-bold text-center text-gray-900 w-full" style="color: #316986;">
                                Editar Paciente
                            </h3>
                            <button type="button" class="absolute top-0 right-0 mt-4 mr-4 text-gray-400 hover:text-gray-500 text-4xl" id="closeModalEditar">
                                <span class="sr-only">Close</span>
                                &times;
                            </button>
                        </div>
                    </div>
                    <div class="border-t border-gray-200 mt-4"></div>
                    <div class="mt-2">
                        <form method="POST" action="" id="editPacienteForm">
                            @csrf
                            @method('PATCH')

                            <!-- Nombres -->
                            <div class="mt-4 col-span-2">
                                <x-input-label for="nombres" :value="__('Nombres')" />
                                <x-text-input id="nombresEditar" class="block mt-1 w-full" type="text" name="nombres" required autofocus />
                                <x-input-error :messages="$errors->get('nombres')" class="mt-2" />
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <!-- Apellido Paterno -->
                                <div class="mt-4">
                                    <x-input-label for="apepat" :value="__('Apellido Paterno')" />
                                    <x-text-input id="apepatEditar" class="block mt-1 w-full" type="text" name="apepat" required autofocus />
                                    <x-input-error :messages="$errors->get('apepat')" class="mt-2" />
                                </div>

                                <!-- Apellido Materno -->
                                <div class="mt-4">
                                    <x-input-label for="apemat" :value="__('Apellido Materno')" />
                                    <x-text-input id="apematEditar" class="block mt-1 w-full" type="text" name="apemat" required autofocus />
                                    <x-input-error :messages="$errors->get('apemat')" class="mt-2" />
                                </div>

                                <!-- Fecha de Nacimiento -->
                                <div class="mt-4">
                                    <x-input-label for="fechanac" :value="__('Fecha de Nacimiento')" />
                                    <x-text-input id="fechanacEditar" class="block mt-1 w-full" type="date" name="fechanac" required autofocus />
                                    <x-input-error :messages="$errors->get('fechanac')" class="mt-2" />
                                </div>

                                <!-- Teléfono -->
                                <div class="mt-4">
                                    <x-input-label for="telefono" :value="__('Teléfono')" />
                                    <x-text-input id="telefonoEditar" class="block mt-1 w-full" type="text" name="telefono" required autofocus />
                                    <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Sexo -->
                            <div class="mt-4 col-span-2">
                                <x-input-label for="sexo" :value="__('Sexo')" />
                                <select id="sexoEditar" name="sexo" class="block mt-1 w-full" required>
                                    <option value="" disabled>Seleccionar sexo</option>
                                    <option value="masculino">Masculino</option>
                                    <option value="femenino">Femenino</option>
                                </select>
                                <x-input-error :messages="$errors->get('sexo')" class="mt-2" />
                            </div>

                            <!-- Correo -->
                            <div class="mt-4 col-span-2">
                                <x-input-label for="correo" :value="__('Correo')" />
                                <x-text-input id="correoEditar" class="block mt-1 w-full" type="email" name="correo" required />
                                <x-input-error :messages="$errors->get('correo')" class="mt-2" />
                            </div>

                            <!-- Contraseña -->
                            <div class="mt-4 col-span-2">
                                <x-input-label for="contraseña" :value="__('Contraseña')" />
                                <x-text-input id="contraseñaEditar" class="block mt-1 w-full" type="password" name="contraseña" />
                                <x-input-error :messages="$errors->get('contraseña')" class="mt-2" />
                                <small class="text-gray-500">Dejar en blanco para mantener la contraseña actual.</small>
                            </div>

                            <input type="hidden" name="activo" value="si">

                            <div class="flex items-center justify-end mt-4">
                                <x-primary-button class="ml-4">
                                    {{ __('Actualizar Paciente') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.getElementById('openModal').addEventListener('click', function() {
        document.getElementById('modal').classList.remove('hidden');
    });

    document.getElementById('closeModal').addEventListener('click', function() {
        document.getElementById('modal').classList.add('hidden');
    });

    document.querySelectorAll('.edit-button').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const id = this.getAttribute('data-id');
            const formAction = `{{ url('medico/pacientes/editar') }}/${id}`;
            document.getElementById('editPacienteForm').setAttribute('action', formAction);
            
            // Fill the form with the data from the patient
            const patient = @json($pacientes).find(p => p.id == id);
            document.getElementById('nombresEditar').value = patient.nombres;
            document.getElementById('apepatEditar').value = patient.apepat;
            document.getElementById('apematEditar').value = patient.apemat;
            document.getElementById('fechanacEditar').value = patient.fechanac;
            document.getElementById('telefonoEditar').value = patient.telefono;
            document.getElementById('sexoEditar').value = patient.sexo;
            document.getElementById('correoEditar').value = patient.correo;

            document.getElementById('modalEditar').classList.remove('hidden');
        });
    });

    document.getElementById('closeModalEditar').addEventListener('click', function() {
        document.getElementById('modalEditar').classList.add('hidden');
    });
</script>

<style>
    .bg-button-color {
        background-color: #33AD9B;
    }
    .hover\:bg-button-hover:hover {
        background-color: #278A75;
    }
    .bg-table-header-color {
        background-color: #2D7498;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    th {
        background-color: #2D7498;
        color: white;
    }
    tr:hover {
        background-color: #f5f5f5;
    }
    .info-box {
        display: flex;
        align-items: center;
        background-color: white;
        border-radius: 8px;
        padding: 16px;
        width: 300px;
        border: 1px solid #ddd;
    }
    .info-icon {
        margin-right: 12px;
    }
    .icon-circle {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #2D7498;
    }
    .info-title {
        font-weight: bold;
        color: black;
    }
    .info-value {
        font-size: 24px;
        font-weight: bold;
        color: black;
    }
    .icon-small {
        width: 20px;
        height: 20px;
    }
    .shadow-md {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .bg-icon-color {
        background-color: #2D7498;
    }
</style>
