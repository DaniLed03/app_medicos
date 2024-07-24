<x-app-layout>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Patient Header -->
                    <div class="flex flex-wrap justify-between items-center mb-6">
                        <!-- Nombre del paciente -->
                        <div class="flex items-center mb-4 md:mb-0">
                            <div class="flex items-center justify-center h-12 w-12 rounded-full bg-white text-xl font-bold border-2" style="border-color: #2D7498; color: #33AD9B;">
                                {{ substr($paciente->nombres, 0, 1) }}{{ substr($paciente->apepat, 0, 1) }}
                            </div>
                            <h2 class="text-3xl font-bold text-left ml-4" style="color: black;">
                                {{ $paciente->nombres }} {{ $paciente->apepat }} {{ $paciente->apemat }}
                            </h2>
                        </div>

                        <!-- Información adicional del paciente -->
                        <div class="relative flex items-center justify-center space-x-4 bg-[#2D7498] border rounded-lg p-4 text-white">
                            <!-- Botón con el icono -->
                            <button class="absolute top-0 right-0 m-2" onclick="openEditModal()">
                                <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M5 8a4 4 0 1 1 7.796 1.263l-2.533 2.534A4 4 0 0 1 5 8Zm4.06 5H7a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h2.172a2.999 2.999 0 0 1-.114-1.588l.674-3.372a3 3 0 0 1 .82-1.533L9.06 13Zm9.032-5a2.907 2.907 0 0 0-2.056.852L9.967 14.92a1 1 0 0 0-.273.51l-.675 3.373a1 1 0 0 0 1.177 1.177l3.372-.675a1 1 0 0 0 .511-.273l6.07-6.07a2.91 2.91 0 0 0-.944-4.742A2.907 2.907 0 0 0 18.092 8Z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                            <div class="flex items-center mr-4">
                                <svg class="w-6 h-6 text-white mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M5 4a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V4Zm12 12V5H7v11h10Zm-5 1a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2H12Z" clip-rule="evenodd"/>
                                </svg>
                                <span class="ml-1">{{ $paciente->sexo }}</span>
                            </div>
                            <div class="flex items-center mr-4">
                                <svg class="w-6 h-6 text-white mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20 7h-.7c.229-.467.349-.98.351-1.5a3.5 3.5 0 0 0-3.5-3.5c-1.717 0-3.215 1.2-4.331 2.481C10.4 2.842 8.949 2 7.5 2A3.5 3.5 0 0 0 4 5.5c.003.52.123 1.033.351 1.5H4a2 2 0 0 0-2 2v2a1 1 0 0 0 1 1h18a1 1 0 0 0 1-1V9a2 2 0 0 0-2-2Zm-9.942 0H7.5a1.5 1.5 0 0 1 0-3c.9 0 2 .754 3.092 2.122-.219.337-.392.635-.534.878Zm6.1 0h-3.742c.933-1.368 2.371-3 3.739-3a1.5 1.5 0 0 1 0 3h.003ZM13 14h-2v8h2v-8Zm-4 0H4v6a2 2 0 0 0 2 2h3v-8Zm6 0v8h3a2 2 0 0 0 2-2v-6h-5Z"/>
                                </svg>
                                <span class="ml-1">{{ $paciente->fechanac }}</span>
                            </div>
                            <div class="flex items-center mr-4">
                                <svg class="w-6 h-6 text-white mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20 7h-.7c.229-.467.349-.98.351-1.5a3.5 3.5 0 0 0-3.5-3.5c-1.717 0-3.215 1.2-4.331 2.481C10.4 2.842 8.949 2 7.5 2A3.5 3.5 0 0 0 4 5.5c.003.52.123 1.033.351 1.5H4a2 2 0 0 0-2 2v2a1 1 0 0 0 1 1h18a1 1 0 0 0 1-1V9a2 2 0 0 0-2-2Zm-9.942 0H7.5a1.5 1.5 0 0 1 0-3c.9 0 2 .754 3.092 2.122-.219.337-.392.635-.534.878Zm6.1 0h-3.742c.933-1.368 2.371-3 3.739-3a1.5 1.5 0 0 1 0 3h.003ZM13 14h-2v8h2v-8Zm-4 0H4v6a2 2 0 0 0 2 2h3v-8Zm6 0v8h3a2 2 0 0 0 2-2v-6h-5Z"/>
                                </svg>
                                <span class="ml-1">{{ $paciente->telefono }}</span>
                            </div>
                            <div class="flex items-center mr-4">
                                <svg class="w-6 h-6 text-white mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M5.024 3.783A1 1 0 0 1 6 3h12a1 1 0 0 1 .976.783L20.802 12h-4.244a1.99 1.99 0 0 0-1.824 1.205 2.978 2.978 0 0 1-5.468 0A1.991 1.991 0 0 0 7.442 12H3.198l1.826-8.217ZM3 14v5a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-5h-4.43a4.978 4.978 0 0 1-9.14 0H3Z" clip-rule="evenodd"/>
                                </svg>
                                <span class="ml-1">{{ $paciente->correo }}</span>
                            </div>
                        </div>

                        <!-- Número de Expediente -->
                        <div class="text-right">
                            <x-input-label for="no_expEditar" :value="__('No. Expediente')" />
                            <x-text-input id="no_expEditar" class="block mt-1 w-full" type="text" name="no_exp" value="{{ $paciente->no_exp }}" readonly />
                            <x-input-error :messages="$errors->get('no_exp')" class="mt-2" />
                        </div>
                    </div>

                    <div class="mt-2">
                        <form method="POST" action="{{ route('pacientes.update', $paciente->id) }}" id="editPacienteForm">
                            @csrf
                            @method('PATCH')

                            <!-- Información Personal -->
                            <div class="bg-gray-100 p-4 rounded-lg shadow-sm mb-6">
                                <h3 class="text-lg font-semibold mb-4">Información Personal</h3>
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                    <!-- Dirección -->
                                    <div class="mt-4 md:col-span-2">
                                        <x-input-label for="direccionEditar" :value="__('Dirección')" />
                                        <x-text-input id="direccionEditar" class="block mt-1 w-full" type="text" name="direccion" value="{{ $paciente->direccion }}" autofocus />
                                        <x-input-error :messages="$errors->get('direccion')" class="mt-2" />
                                    </div>

                                    <!-- Lugar de Nacimiento -->
                                    <div class="mt-4 md:col-span-1">
                                        <x-input-label for="lugar_naciEditar" :value="__('Lugar de Nacimiento')" />
                                        <x-text-input id="lugar_naciEditar" class="block mt-1 w-full" type="text" name="lugar_naci" value="{{ $paciente->lugar_naci }}" autofocus />
                                        <x-input-error :messages="$errors->get('lugar_naci')" class="mt-2" />
                                    </div>

                                    <!-- Hospital -->
                                    <div class="mt-4 md:col-span-1">
                                        <x-input-label for="hospitalEditar" :value="__('Hospital')" />
                                        <x-text-input id="hospitalEditar" class="block mt-1 w-full" type="text" name="hospital" value="{{ $paciente->hospital }}" autofocus />
                                        <x-input-error :messages="$errors->get('hospital')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                                    <!-- CURP -->
                                    <div class="mt-4 md:col-span-1">
                                        <x-input-label for="curpEditar" :value="__('CURP')" />
                                        <x-text-input id="curpEditar" class="block mt-1 w-full" type="text" name="curp" value="{{ $paciente->curp }}" autofocus />
                                        <x-input-error :messages="$errors->get('curp')" class="mt-2" />
                                    </div>
                                    
                                    <!-- Hora -->
                                    <div class="mt-4 md:col-span-1">
                                        <x-input-label for="horaEditar" :value="__('Hora de Nacimiento')" />
                                        <x-text-input id="horaEditar" class="block mt-1 w-full" type="time" name="hora" value="{{ $paciente->hora }}" autofocus />
                                        <x-input-error :messages="$errors->get('hora')" class="mt-2" />
                                    </div>

                                    <!-- Peso -->
                                    <div class="mt-4 md:col-span-1">
                                        <x-input-label for="pesoEditar" :value="__('Peso (kg)')" />
                                        <x-text-input id="pesoEditar" class="block mt-1 w-full" type="number" step="0.01" name="peso" value="{{ $paciente->peso }}" autofocus />
                                        <x-input-error :messages="$errors->get('peso')" class="mt-2" />
                                    </div>

                                    <!-- Talla -->
                                    <div class="mt-4 md:col-span-1">
                                        <x-input-label for="tallaEditar" :value="__('Talla (cm)')" />
                                        <x-text-input id="tallaEditar" class="block mt-1 w-full" type="number" maxlength="5" name="talla" value="{{ $paciente->talla }}" autofocus />
                                        <x-input-error :messages="$errors->get('talla')" class="mt-2" />
                                    </div>

                                    <!-- Tipo de Parto -->
                                    <div class="mt-4 md:col-span-1">
                                        <x-input-label for="tipopartoEditar" :value="__('Tipo de Parto')" />
                                        <x-text-input id="tipopartoEditar" class="block mt-1 w-full" type="text" maxlength="5" name="tipoparto" value="{{ $paciente->tipoparto }}" autofocus />
                                        <x-input-error :messages="$errors->get('tipoparto')" class="mt-2" />
                                    </div>

                                    <!-- Tipo de Sangre -->
                                    <div class="mt-4 md:col-span-1">
                                        <x-input-label for="tiposangreEditar" :value="__('Tipo de Sangre')" />
                                        <x-text-input id="tiposangreEditar" class="block mt-1 w-full" type="text" maxlength="5" name="tiposangre" value="{{ $paciente->tiposangre }}" autofocus />
                                        <x-input-error :messages="$errors->get('tiposangre')" class="mt-2" />
                                    </div>
                                </div>
                            </div>

                            <!-- Antecedentes -->
                            <div class="bg-gray-100 p-4 rounded-lg shadow-sm mb-6">
                                <x-input-label for="antecedentesEditar" :value="__('Antecedentes')" />
                                <textarea id="antecedentesEditar" name="antecedentes" class="block mt-1 w-full form-input rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" style="resize: none; height: 100px;" autofocus>{{ $paciente->antecedentes }}</textarea>
                                <x-input-error :messages="$errors->get('antecedentes')" class="mt-2" />
                            </div>

                            <!-- Contacto de Emergencias -->
                            <div class="bg-gray-100 p-4 rounded-lg shadow-sm mb-6">
                                <h3 class="text-lg font-semibold mb-4">Contacto de Emergencias</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Padre -->
                                    <div class="mt-4 md:col-span-1">
                                        <x-input-label for="padreEditar" :value="__('Padre')" />
                                        <x-text-input id="padreEditar" class="block mt-1 w-full" type="text" name="padre" value="{{ $paciente->padre }}" autofocus />
                                        <x-input-error :messages="$errors->get('padre')" class="mt-2" />
                                    </div>

                                    <!-- Madre -->
                                    <div class="mt-4 md:col-span-1">
                                        <x-input-label for="madreEditar" :value="__('Madre')" />
                                        <x-text-input id="madreEditar" class="block mt-1 w-full" type="text" name="madre" value="{{ $paciente->madre }}" autofocus />
                                        <x-input-error :messages="$errors->get('madre')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <!-- Teléfono Secundario -->
                                    <div class="mt-4 md:col-span-1">
                                        <x-input-label for="telefono2Editar" :value="__('Teléfono Secundario')" />
                                        <x-text-input id="telefono2Editar" class="block mt-1 w-full" type="text" name="telefono2" value="{{ $paciente->telefono2 }}" autofocus />
                                        <x-input-error :messages="$errors->get('telefono2')" class="mt-2" />
                                    </div>
                                </div>
                            </div>

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

    <!-- Modal -->
    <div id="editModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden">
        <div class="bg-white p-8 rounded-lg shadow-lg relative">
            <div class="flex justify-between items-center">
                <div class="w-full">
                    <h2 class="text-2xl font-bold mb-4 text-center" style="color: #2D7498;">Editar Paciente</h2>
                </div>
                <button class="ml-4" onclick="closeEditModal()">
                    <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M5 5a1 1 0 0 1 1.414 0L12 10.586 17.586 5A1 1 0 1 1 19 6.414L13.414 12 19 17.586A1 1 0 1 1 17.586 19L12 13.414 6.414 19A1 1 0 0 1 5 17.586L10.586 12 5 6.414A1 1 0 0 1 5 5Z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
            <hr class="mb-4 border-gray-300">
            <form method="POST" action="{{ route('pacientes.update', $paciente->id) }}" id="modalEditPacienteForm">
                @csrf
                @method('PATCH')

                <!-- Número de Expediente (hidden) -->
                <div class="mt-4 hidden">
                    <x-input-label for="modalNoExp" :value="__('No. Expediente')" />
                    <x-text-input id="modalNoExp" class="block mt-1 w-full" type="text" name="no_exp" value="{{ $paciente->no_exp }}" readonly />
                    <x-input-error :messages="$errors->get('no_exp')" class="mt-2" />
                </div>

                <!-- Nombres -->
                <div class="mt-4">
                    <x-input-label for="modalNombres" :value="__('Nombres')" />
                    <x-text-input id="modalNombres" class="block mt-1 w-full" type="text" name="nombres" value="{{ $paciente->nombres }}" autofocus />
                    <x-input-error :messages="$errors->get('nombres')" class="mt-2" />
                </div>

                <!-- Apellido Paterno -->
                <div class="mt-4">
                    <x-input-label for="modalApepat" :value="__('Apellido Paterno')" />
                    <x-text-input id="modalApepat" class="block mt-1 w-full" type="text" name="apepat" value="{{ $paciente->apepat }}" autofocus />
                    <x-input-error :messages="$errors->get('apepat')" class="mt-2" />
                </div>

                <!-- Apellido Materno -->
                <div class="mt-4">
                    <x-input-label for="modalApemat" :value="__('Apellido Materno')" />
                    <x-text-input id="modalApemat" class="block mt-1 w-full" type="text" name="apemat" value="{{ $paciente->apemat }}" autofocus />
                    <x-input-error :messages="$errors->get('apemat')" class="mt-2" />
                </div>

                <!-- Teléfono y Sexo -->
                <div class="flex justify-between">
                    <div class="mt-4 w-1/2 pr-2">
                        <x-input-label for="modalTelefono" :value="__('Teléfono')" />
                        <x-text-input id="modalTelefono" class="block mt-1 w-full" type="text" name="telefono" value="{{ $paciente->telefono }}" autofocus />
                        <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
                    </div>

                    <div class="mt-4 w-1/2 pl-2">
                        <x-input-label for="modalSexo" :value="__('Sexo')" />
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-secondary">
                                <input type="radio" name="sexo" id="modalMasculino" value="masculino" {{ $paciente->sexo == 'masculino' ? 'checked' : '' }} autocomplete="off" required> Masculino
                            </label>
                            <label class="btn btn-secondary">
                                <input type="radio" name="sexo" id="modalFemenino" value="femenino" {{ $paciente->sexo == 'femenino' ? 'checked' : '' }} autocomplete="off" required> Femenino
                            </label>
                        </div>
                        <x-input-error :messages="$errors->get('sexo')" class="mt-2" />
                    </div>
                </div>

                <!-- Correo -->
                <div class="mt-4">
                    <x-input-label for="modalCorreo" :value="__('Correo')" />
                    <x-text-input id="modalCorreo" class="block mt-1 w-full" type="email" name="correo" value="{{ $paciente->correo }}"  />
                    <x-input-error :messages="$errors->get('correo')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="ml-4">
                        {{ __('Actualizar Paciente') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal() {
            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
