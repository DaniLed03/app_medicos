<x-app-layout>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Nombre y contenedor gris -->
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

                        <!-- Número de Expediente -->
                        <div class="text-right">
                            <x-input-label for="no_expEditar" :value="__('No. Expediente')" />
                            <x-text-input id="no_expEditar" class="block mt-1 w-full" type="text" name="no_exp" value="{{ $paciente->no_exp }}" readonly />
                            <x-input-error :messages="$errors->get('no_exp')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Tabs -->
                    <ul class="flex border-b" id="tabs">
                        <li class="-mb-px mr-1">
                            <a class="tab-link active-tab" href="#datos" onclick="openTab(event, 'datos')">Datos del Paciente</a>
                        </li>
                        <li class="mr-1">
                            <a class="tab-link" href="#padres" onclick="openTab(event, 'padres')">Padres</a>
                        </li>
                        <li class="mr-1">
                            <a class="tab-link" href="#antecedentes" onclick="openTab(event, 'antecedentes')">Antecedentes Familiares</a>
                        </li>
                        <li class="mr-1">
                            <a class="tab-link" href="#facturacion" onclick="openTab(event, 'facturacion')">Datos de Facturación</a>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div id="datos" class="tab-content">
                        <!-- Información Personal -->
                        <div class="mt-3">
                            <!-- Editar Paciente Section -->
                            <form method="POST" action="{{ route('pacientes.update', $paciente->id) }}" id="editPacienteFormNew">
                                @csrf
                                @method('PATCH')

                                <!-- Información Personal -->
                                <div class="bg-gray-100 p-4 rounded-lg shadow-sm mb-6" id="personalNew">
                                    <div class="flex justify-between items-center mb-4">
                                        <h3 class="text-lg font-semibold">Información Personal</h3>
                                        <button type="button" class="text-gray-800" onclick="enableFields('personalNew')">
                                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd" d="M5 8a4 4 0 1 1 7.796 1.263l-2.533 2.534A4 4 0 0 1 5 8Zm4.06 5H7a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h2.172a2.999 2.999 0 0 1-.114-1.588l.674-3.372a3 3 0 0 1 .82-1.533L9.06 13Zm9.032-5a2.907 2.907 0 0 0-2.056.852L9.967 14.92a1 1 0 0 0-.273.51l-.675 3.373a1 1 0 0 0 1.177 1.177l3.372-.675a1 1 0 0 0 .511-.273l6.07-6.07a2.91 2.91 0 0 0-.944-4.742A2.907 2.907 0 0 0 18.092 8Z" clip-rule="evenodd"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                        <!-- Nombres -->
                                        <div class="mt-4 md:col-span-1">
                                            <x-input-label for="modalNombres" :value="__('Nombres')" />
                                            <x-text-input id="modalNombres" class="block mt-1 w-full" type="text" name="nombres" value="{{ $paciente->nombres }}" autofocus disabled />
                                            <x-input-error :messages="$errors->get('nombres')" class="mt-2" />
                                        </div>

                                        <!-- Apellido Paterno -->
                                        <div class="mt-4 md:col-span-1">
                                            <x-input-label for="modalApepat" :value="__('Apellido Paterno')" />
                                            <x-text-input id="modalApepat" class="block mt-1 w-full" type="text" name="apepat" value="{{ $paciente->apepat }}" autofocus disabled />
                                            <x-input-error :messages="$errors->get('apepat')" class="mt-2" />
                                        </div>

                                        <!-- Apellido Materno -->
                                        <div class="mt-4 md:col-span-1">
                                            <x-input-label for="modalApemat" :value="__('Apellido Materno')" />
                                            <x-text-input id="modalApemat" class="block mt-1 w-full" type="text" name="apemat" value="{{ $paciente->apemat }}" autofocus disabled />
                                            <x-input-error :messages="$errors->get('apemat')" class="mt-2" />
                                        </div>

                                        <!-- Sexo -->
                                        <div class="mt-4 md:col-span-1">
                                            <x-input-label for="modalSexo" :value="__('Sexo')" />
                                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                <label class="btn btn-secondary">
                                                    <input type="radio" name="sexo" id="modalMasculino" value="masculino" {{ $paciente->sexo == 'masculino' ? 'checked' : '' }} autocomplete="off" required disabled> Masculino
                                                </label>
                                                <label class="btn btn-secondary">
                                                    <input type="radio" name="sexo" id="modalFemenino" value="femenino" {{ $paciente->sexo == 'femenino' ? 'checked' : '' }} autocomplete="off" required disabled> Femenino
                                                </label>
                                            </div>
                                            <x-input-error :messages="$errors->get('sexo')" class="mt-2" />
                                        </div>

                                        <!-- Fecha de Nacimiento -->
                                        <div class="mt-4 md:col-span-1">
                                            <x-input-label for="fecha_nacimiento" :value="__('Fecha de Nacimiento')" />
                                            <x-text-input id="fecha_nacimiento" class="block mt-1 w-full" type="date" name="fechanac" value="{{ $paciente->fechanac }}" disabled />
                                            <x-input-error :messages="$errors->get('fechanac')" class="mt-2" />
                                        </div>

                                        <!-- CURP -->
                                        <div class="mt-4 md:col-span-1">
                                            <x-input-label for="curpEditar" :value="__('CURP')" />
                                            <x-text-input id="curpEditar" class="block mt-1 w-full" type="text" name="curp" value="{{ $paciente->curp }}" disabled />
                                            <x-input-error :messages="$errors->get('curp')" class="mt-2" />
                                        </div>

                                        <!-- Lugar de Nacimiento -->
                                        <div class="mt-4 md:col-span-1">
                                            <x-input-label for="lugar_naciEditar" :value="__('Lugar de Nacimiento')" />
                                            <x-text-input id="lugar_naciEditar" class="block mt-1 w-full" type="text" name="lugar_naci" value="{{ $paciente->lugar_naci }}" disabled />
                                            <x-input-error :messages="$errors->get('lugar_naci')" class="mt-2" />
                                        </div>

                                        <!-- Hora de Nacimiento -->
                                        <div class="mt-4 md:col-span-1">
                                            <x-input-label for="horaEditar" :value="__('Hora de Nacimiento')" />
                                            <x-text-input id="horaEditar" class="block mt-1 w-full" type="time" step="1" name="hora" value="{{ $paciente->hora }}" disabled />
                                            <x-input-error :messages="$errors->get('hora')" class="mt-2" />
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                                        <!-- Peso (kg) -->
                                        <div class="mt-4 md:col-span-1">
                                            <x-input-label for="pesoEditar" :value="__('Peso (kg)')" />
                                            <x-text-input id="pesoEditar" class="block mt-1 w-full" type="number" step="0.01" name="peso" value="{{ $paciente->peso }}" disabled />
                                            <x-input-error :messages="$errors->get('peso')" class="mt-2" />
                                        </div>

                                        <!-- Talla (cm) -->
                                        <div class="mt-4 md:col-span-1">
                                            <x-input-label for="tallaEditar" :value="__('Talla (cm)')" />
                                            <x-text-input id="tallaEditar" class="block mt-1 w-full" type="number" name="talla" value="{{ $paciente->talla }}" disabled />
                                            <x-input-error :messages="$errors->get('talla')" class="mt-2" />
                                        </div>

                                        <!-- Tipo de Parto -->
                                        <div class="mt-4 md:col-span-1">
                                            <x-input-label for="tipopartoEditar" :value="__('Tipo de Parto')" />
                                            <x-text-input id="tipopartoEditar" class="block mt-1 w-full" type="text" name="tipoparto" value="{{ $paciente->tipoparto }}" disabled />
                                            <x-input-error :messages="$errors->get('tipoparto')" class="mt-2" />
                                        </div>

                                        <!-- Tipo de Sangre -->
                                        <div class="mt-4 md:col-span-1">
                                            <x-input-label for="tiposangreEditar" :value="__('Tipo de Sangre')" />
                                            <x-text-input id="tiposangreEditar" class="block mt-1 w-full" type="text" name="tiposangre" value="{{ $paciente->tiposangre }}" disabled />
                                            <x-input-error :messages="$errors->get('tiposangre')" class="mt-2" />
                                        </div>

                                        <!-- Hospital -->
                                        <div class="mt-4">
                                            <x-input-label for="hospitalEditar" :value="__('Hospital')" />
                                            <x-text-input id="hospitalEditar" class="block mt-1 w-full" type="text" name="hospital" value="{{ $paciente->hospital }}" disabled />
                                            <x-input-error :messages="$errors->get('hospital')" class="mt-2" />
                                        </div>

                                        <!-- Correo -->
                                        <div class="mt-4">
                                            <x-input-label for="correo" :value="__('Correo')" />
                                            <x-text-input id="correo" class="block mt-1 w-full" type="email" name="correo" value="{{ $paciente->correo }}" required autofocus autocomplete="email" disabled />
                                            <x-input-error :messages="$errors->get('correo')" class="mt-2" />
                                        </div>
                                    </div>
                                    <div class="flex justify-end mt-4">
                                        <x-primary-button class="ml-4 hidden" id="personalNew-update" onclick="submitForm('editPacienteFormNew')">
                                            {{ __('Actualizar Información Personal') }}
                                        </x-primary-button>
                                        <x-secondary-button class="ml-4 hidden" id="personalNew-cancel" onclick="disableFields('personalNew')">
                                            {{ __('Cancelar') }}
                                        </x-secondary-button>
                                    </div>
                                </div>

                                <!-- Domicilio -->
                                <div class="bg-gray-100 p-4 rounded-lg shadow-sm mb-6" id="domicilioNew">
                                    <div class="flex justify-between items-center mb-4">
                                        <h3 class="text-lg font-semibold">Domicilio</h3>
                                        <button type="button" class="text-gray-800" onclick="enableFields('domicilioNew')">
                                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd" d="M5 8a4 4 0 1 1 7.796 1.263l-2.533 2.534A4 4 0 0 1 5 8Zm4.06 5H7a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h2.172a2.999 2.999 0 0 1-.114-1.588l.674-3.372a3 3 0 0 1 .82-1.533L9.06 13Zm9.032-5a2.907 2.907 0 0 0-2.056.852L9.967 14.92a1 1 0 0 0-.273.51l-.675 3.373a1 1 0 0 0 1.177 1.177l3.372-.675a1 1 0 0 0 .511-.273l6.07-6.07a2.91 2.91 0 0 0-.944-4.742A2.907 2.907 0 0 0 18.092 8Z" clip-rule="evenodd"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
                                        <!-- Dirección -->
                                        <div class="mt-4">
                                            <x-input-label for="direccionEditar" :value="__('Calle/Numero/Colonia')" />
                                            <x-text-input id="direccionEditar" class="block mt-1 w-full h-12" type="text" name="direccion" value="{{ $paciente->direccion }}" disabled />
                                            <x-input-error :messages="$errors->get('direccion')" class="mt-2" />
                                        </div>  
                                    </div>
                                    <div class="flex justify-end mt-4">
                                        <x-primary-button class="ml-4 hidden" id="domicilioNew-update" onclick="submitForm('editPacienteFormNew')">
                                            {{ __('Actualizar Domicilio') }}
                                        </x-primary-button>
                                        <x-secondary-button class="ml-4 hidden" id="domicilioNew-cancel" onclick="disableFields('domicilioNew')">
                                            {{ __('Cancelar') }}
                                        </x-secondary-button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div id="padres" class="tab-content hidden mt-3">
                        <!-- Contacto de Emergencias -->
                        <form method="POST" action="{{ route('pacientes.update', $paciente->id) }}" id="padresForm">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="tab" value="padres">
                            <div class="bg-gray-100 p-4 rounded-lg shadow-sm mb-6" id="emergencias">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg font-semibold">Padres</h3>
                                    <button type="button" class="text-gray-800" onclick="enableFields('emergencias')">
                                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd" d="M5 8a4 4 0 1 1 7.796 1.263l-2.533 2.534A4 4 0 0 1 5 8Zm4.06 5H7a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h2.172a2.999 2.999 0 0 1-.114-1.588l.674-3.372a3 3 0 0 1 .82-1.533L9.06 13Zm9.032-5a2.907 2.907 0 0 0-2.056.852L9.967 14.92a1 1 0 0 0-.273.51l-.675 3.373a1 1 0 0 0 1.177 1.177l3.372-.675a1 1 0 0 0 .511-.273l6.07-6.07a2.91 2.91 0 0 0-.944-4.742A2.907 2.907 0 0 0 18.092 8Z" clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <!-- Padre -->
                                    <div class="mt-4 md:col-span-1">
                                        <x-input-label for="padreEditar" :value="__('Padre')" />
                                        <x-text-input id="padreEditar" class="block mt-1 w-full" type="text" name="padre" value="{{ $paciente->padre }}" disabled />
                                        <x-input-error :messages="$errors->get('padre')" class="mt-2" />
                                    </div>
                                
                                    <!-- Madre -->
                                    <div class="mt-4 md:col-span-1">
                                        <x-input-label for="madreEditar" :value="__('Madre')" />
                                        <x-text-input id="madreEditar" class="block mt-1 w-full" type="text" name="madre" value="{{ $paciente->madre }}" disabled />
                                        <x-input-error :messages="$errors->get('madre')" class="mt-2" />
                                    </div>
                                
                                    <!-- Teléfono Secundario -->
                                    <div class="mt-4 md:col-span-1">
                                        <x-input-label for="telefono2Editar" :value="__('Teléfono Secundario')" />
                                        <x-text-input id="telefono2Editar" class="block mt-1 w-full" type="text" name="telefono2" value="{{ $paciente->telefono2 }}" disabled />
                                        <x-input-error :messages="$errors->get('telefono2')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="flex justify-end mt-4">
                                    <x-primary-button class="ml-4 hidden" id="emergencias-update" onclick="submitForm('padresForm')">
                                        {{ __('Actualizar Contacto de Emergencias') }}
                                    </x-primary-button>
                                    <x-secondary-button class="ml-4 hidden" id="emergencias-cancel" onclick="disableFields('emergencias')">
                                        {{ __('Cancelar') }}
                                    </x-secondary-button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div id="antecedentes" class="tab-content hidden mt-3">
                        <!-- Antecedentes -->
                        <form method="POST" action="{{ route('pacientes.update', $paciente->id) }}" id="antecedentesForm">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="tab" value="antecedentes">
                            <div class="bg-gray-100 p-4 rounded-lg shadow-sm mb-6" id="antecedentes">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg font-semibold">Antecedentes Familiares</h3>
                                    <button type="button" class="text-gray-800" onclick="enableFields('antecedentes')">
                                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd" d="M5 8a4 4 0 1 1 7.796 1.263l-2.533 2.534A4 4 0 0 1 5 8Zm4.06 5H7a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h2.172a2.999 2.999 0 0 1-.114-1.588l.674-3.372a3 3 0 0 1 .82-1.533L9.06 13Zm9.032-5a2.907 2.907 0 0 0-2.056.852L9.967 14.92a1 1 0 0 0-.273.51l-.675 3.373a1 1 0 0 0 1.177 1.177l3.372-.675a1 1 0 0 0 .511-.273l6.07-6.07a2.91 2.91 0 0 0-.944-4.742A2.907 2.907 0 0 0 18.092 8Z" clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                </div>
                                <div class="mt-4">
                                    <div class="bg-white p-4 rounded-lg shadow-sm border">
                                        <div id="antecedentesContent">
                                            {!! $paciente->antecedentes !!}
                                        </div>
                                        <textarea id="antecedentesEditar" name="antecedentes" class="hidden form-input rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" style="resize: none; height: 450px;"></textarea>
                                    </div>
                                    <x-input-error :messages="$errors->get('antecedentes')" class="mt-2" />
                                </div>
                                <div class="flex justify-end mt-4">
                                    <x-primary-button class="ml-4 hidden" id="antecedentes-update" onclick="submitForm('antecedentesForm')">
                                        {{ __('Actualizar Antecedentes') }}
                                    </x-primary-button>
                                    <x-secondary-button class="ml-4 hidden" id="antecedentes-cancel" onclick="disableFields('antecedentes')">
                                        {{ __('Cancelar') }}
                                    </x-secondary-button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div id="facturacion" class="tab-content hidden mt-3">
                        <!-- Información de Facturación -->
                        <form method="POST" action="{{ route('pacientes.update', $paciente->id) }}" id="facturacionForm">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="tab" value="facturacion">
                            <div class="bg-gray-100 p-4 rounded-lg shadow-sm mb-6" id="facturacion">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg font-semibold">Información de Facturación</h3>
                                    <button type="button" class="text-gray-800" onclick="enableFields('facturacion')">
                                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd" d="M5 8a4 4 0 1 1 7.796 1.263l-2.533 2.534A4 4 0 0 1 5 8Zm4.06 5H7a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h2.172a2.999 2.999 0 0 1-.114-1.588l.674-3.372a3 3 0 0 1 .82-1.533L9.06 13Zm9.032-5a2.907 2.907 0 0 0-2.056.852L9.967 14.92a1 1 0 0 0-.273.51l-.675 3.373a1 1 0 0 0 1.177 1.177l3.372-.675a1 1 0 0 0 .511-.273l6.07-6.07a2.91 2.91 0 0 0-.944-4.742A2.907 2.907 0 0 0 18.092 8Z" clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Nombre de Facturación -->
                                    <div class="mt-4">
                                        <x-input-label for="Nombre_factEditar" :value="__('Razon Social')" />
                                        <x-text-input id="Nombre_factEditar" class="block mt-1 w-full" type="text" name="Nombre_fact" value="{{ $paciente->Nombre_fact }}" disabled />
                                        <x-input-error :messages="$errors->get('Nombre_fact')" class="mt-2" />
                                    </div>

                                    <!-- Dirección de Facturación -->
                                    <div class="mt-4">
                                        <x-input-label for="Direccion_factEditar" :value="__('Domicilio Fiscal')" />
                                        <x-text-input id="Direccion_factEditar" class="block mt-1 w-full" type="text" name="Direccion_fact" value="{{ $paciente->Direccion_fact }}" disabled />
                                        <x-input-error :messages="$errors->get('Direccion_fact')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <!-- RFC -->
                                    <div class="mt-4">
                                        <x-input-label for="RFCEditar" :value="__('RFC')" />
                                        <x-text-input id="RFCEditar" class="block mt-1 w-full" type="text" name="RFC" value="{{ $paciente->RFC }}" disabled />
                                        <x-input-error :messages="$errors->get('RFC')" class="mt-2" />
                                    </div>

                                    <!-- Régimen Fiscal -->
                                    <div class="mt-4">
                                        <x-input-label for="Regimen_fiscalEditar" :value="__('Régimen Fiscal')" />
                                        <x-text-input id="Regimen_fiscalEditar" class="block mt-1 w-full" type="text" name="Regimen_fiscal" value="{{ $paciente->Regimen_fiscal }}" disabled />
                                        <x-input-error :messages="$errors->get('Regimen_fiscal')" class="mt-2" />
                                    </div>

                                    <!-- CFDI -->
                                    <div class="mt-4">
                                        <x-input-label for="CFDIEditar" :value="__('CFDI')" />
                                        <x-text-input id="CFDIEditar" class="block mt-1 w-full" type="text" name="CFDI" value="{{ $paciente->CFDI }}" disabled />
                                        <x-input-error :messages="$errors->get('CFDI')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="flex justify-end mt-4">
                                    <x-primary-button class="ml-4 hidden" id="facturacion-update" onclick="submitForm('facturacionForm')">
                                        {{ __('Actualizar Información de Facturación') }}
                                    </x-primary-button>
                                    <x-secondary-button class="ml-4 hidden" id="facturacion-cancel" onclick="disableFields('facturacion')">
                                        {{ __('Cancelar') }}
                                    </x-secondary-button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Summernote CSS & JS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-lite.min.js"></script>

    <style>
        .tab-link {
            color: black;
            text-decoration: none;
            padding: 10px 20px;
            display: inline-block;
            font-weight: normal;
            border-bottom: 2px solid transparent;
        }

        .active-tab {
            font-weight: bold;
            border-bottom: 2px solid #2D7498;
        }

        .tab-link:hover {
            font-weight: bold;
        }
    </style>

    <script>
        function enableFields(sectionId) {
            const section = document.getElementById(sectionId);
            const inputs = section.querySelectorAll('input, textarea');
            inputs.forEach(input => {
                input.disabled = false;
            });
            document.getElementById(`${sectionId}-update`).classList.remove('hidden');
            document.getElementById(`${sectionId}-cancel`).classList.remove('hidden');
            const editButton = section.querySelector('button');
            if (editButton) {
                editButton.classList.add('hidden');
            }

            if (sectionId === 'antecedentes') {
                const antecedentesContent = document.getElementById('antecedentesContent');
                const antecedentesEditar = document.getElementById('antecedentesEditar');
                antecedentesEditar.value = antecedentesContent.innerHTML;
                antecedentesContent.classList.add('hidden');
                antecedentesEditar.classList.remove('hidden');
                $('#antecedentesEditar').summernote({
                    height: 450,
                    toolbar: [
                        ['style', ['bold', 'underline']],
                        ['font', ['strikethrough']],
                        ['fontname', ['fontname']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']]
                    ]
                });
            }
        }

        function disableFields(sectionId) {
            const section = document.getElementById(sectionId);
            const inputs = section.querySelectorAll('input, textarea');
            inputs.forEach(input => {
                input.disabled = true;
            });
            document.getElementById(`${sectionId}-update`).classList.add('hidden');
            document.getElementById(`${sectionId}-cancel`).classList.add('hidden');
            const editButton = section.querySelector('button');
            if (editButton) {
                editButton.classList.remove('hidden');
            }

            if (sectionId === 'antecedentes') {
                $('#antecedentesEditar').summernote('destroy');
                const antecedentesContent = document.getElementById('antecedentesContent');
                const antecedentesEditar = document.getElementById('antecedentesEditar');
                antecedentesContent.innerHTML = antecedentesEditar.value;
                antecedentesContent.classList.remove('hidden');
                antecedentesEditar.classList.add('hidden');
            }
        }

        function submitForm(formId) {
            const antecedentes = $('#antecedentesEditar');
            if (antecedentes.length) {
                antecedentes.val(antecedentes.summernote('code'));
            }
            document.getElementById(formId).submit();
        }

        function openTab(event, tabName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tab-content");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementById("tabs").getElementsByTagName("a");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active-tab", "");
            }
            document.getElementById(tabName).style.display = "block";
            event.currentTarget.className += " active-tab";
        }

        // Set default tab
        document.addEventListener("DOMContentLoaded", function() {
            const urlParams = new URLSearchParams(window.location.search);
            const tab = urlParams.get('tab') || 'datos';
            openTab({currentTarget: document.querySelector(`[href="#${tab}"]`)}, tab);
        });
    </script>
</x-app-layout>
