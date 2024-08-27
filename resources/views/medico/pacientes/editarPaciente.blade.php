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
                                {{ substr($paciente->nombres ?? '', 0, 1) }}{{ substr($paciente->apepat ?? '', 0, 1) }}
                            </div>
                            <h2 class="text-3xl font-bold text-left ml-4" style="color: black;">
                                {{ $paciente->nombres ?? '' }} {{ $paciente->apepat ?? '' }} {{ $paciente->apemat ?? '' }}
                            </h2>
                        </div>

                        <!-- Número de Expediente -->
                        <div class="text-right">
                            <x-input-label for="no_expEditar" :value="__('No. Expediente')" />
                            <x-text-input id="no_expEditar" class="block mt-1 w-full" type="text" name="no_exp" value="{{ $paciente->no_exp ?? '' }}" readonly />
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
                            <a class="tab-link" href="#historial" onclick="openTab(event, 'historial')">Historial Clinico</a>
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
                            <form method="POST" action="{{ route('pacientes.update', $paciente->id ?? 0) }}" id="editPacienteFormNew">
                                @csrf
                                @method('PATCH')

                                <!-- Información Personal -->
                                <div class="bg-gray-100 p-4 rounded-lg shadow-sm mb-6" id="personalNew">
                                    <div class="flex justify-between items-center mb-4">
                                        <h3 class="text-lg font-semibold">Información Personal</h3>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                        <!-- Nombres -->
                                        <div class="mt-4 md:col-span-1">
                                            <x-input-label for="modalNombres" :value="__('Nombres')" />
                                            <x-text-input id="modalNombres" class="block mt-1 w-full" type="text" name="nombres" value="{{ $paciente->nombres }}" autofocus />
                                            <x-input-error :messages="$errors->get('nombres')" class="mt-2" />
                                        </div>

                                        <!-- Apellido Paterno -->
                                        <div class="mt-4 md:col-span-1">
                                            <x-input-label for="modalApepat" :value="__('Apellido Paterno')" />
                                            <x-text-input id="modalApepat" class="block mt-1 w-full" type="text" name="apepat" value="{{ $paciente->apepat ?? '' }}" autofocus />
                                            <x-input-error :messages="$errors->get('apepat')" class="mt-2" />
                                        </div>

                                        <!-- Apellido Materno -->
                                        <div class="mt-4 md:col-span-1">
                                            <x-input-label for="modalApemat" :value="__('Apellido Materno')" />
                                            <x-text-input id="modalApemat" class="block mt-1 w-full" type="text" name="apemat" value="{{ $paciente->apemat ?? '' }}" autofocus />
                                            <x-input-error :messages="$errors->get('apemat')" class="mt-2" />
                                        </div>

                                        <!-- Sexo -->
                                        <div class="mt-4 md:col-span-1">
                                            <x-input-label for="modalSexo" :value="__('Sexo')" />
                                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                <label class="btn btn-secondary">
                                                    <input type="radio" name="sexo" id="modalMasculino" value="masculino" {{ ($paciente->sexo ?? '') == 'masculino' ? 'checked' : '' }} autocomplete="off" required> Masculino
                                                </label>
                                                <label class="btn btn-secondary">
                                                    <input type="radio" name="sexo" id="modalFemenino" value="femenino" {{ ($paciente->sexo ?? '') == 'femenino' ? 'checked' : '' }} autocomplete="off" required> Femenino
                                                </label>
                                            </div>
                                            <x-input-error :messages="$errors->get('sexo')" class="mt-2" />
                                        </div>

                                        <div class="mt-4 md:col-span-1">
                                            <x-input-label for="fecha_nacimiento" :value="__('Fecha de Nacimiento')" />
                                            <x-text-input id="fecha_nacimiento" class="block mt-1 w-full" type="date" name="fechanac" value="{{ $paciente->fechanac }}" />
                                            <x-input-error :messages="$errors->get('fechanac')" class="mt-2" />
                                        </div>

                                        <!-- CURP -->
                                        <div class="mt-4 md:col-span-1">
                                            <x-input-label for="curpEditar" :value="__('CURP')" />
                                            <x-text-input id="curpEditar" class="block mt-1 w-full" type="text" name="curp" value="{{ $paciente->curp ?? '' }}" />
                                            <x-input-error :messages="$errors->get('curp')" class="mt-2" />
                                        </div>

                                        <!-- Lugar de Nacimiento -->
                                        <div class="mt-4 md:col-span-1">
                                            <x-input-label for="lugar_naciEditar" :value="__('Lugar de Nacimiento')" />
                                            <x-text-input id="lugar_naciEditar" class="block mt-1 w-full" type="text" name="lugar_naci" value="{{ $paciente->lugar_naci ?? '' }}" />
                                            <x-input-error :messages="$errors->get('lugar_naci')" class="mt-2" />
                                        </div>

                                        <!-- Hora de Nacimiento -->
                                        <div class="mt-4 md:col-span-1">
                                            <x-input-label for="horaEditar" :value="__('Hora de Nacimiento')" />
                                            <x-text-input id="horaEditar" class="block mt-1 w-full" type="time" step="1" name="hora" value="{{ $paciente->hora ?? '' }}" />
                                            <x-input-error :messages="$errors->get('hora')" class="mt-2" />
                                        </div>


                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                                        <!-- Peso (kg) -->
                                        <div class="mt-4 md:col-span-1">
                                            <x-input-label for="pesoEditar" :value="__('Peso (kg)')" />
                                            <x-text-input id="pesoEditar" class="block mt-1 w-full" type="number" step="0.01" name="peso" value="{{ $paciente->peso ?? '' }}" />
                                            <x-input-error :messages="$errors->get('peso')" class="mt-2" />
                                        </div>

                                        <!-- Talla (cm) -->
                                        <div class="mt-4 md:col-span-1">
                                            <x-input-label for="tallaEditar" :value="__('Talla (cm)')" />
                                            <x-text-input id="tallaEditar" class="block mt-1 w-full" type="number" name="talla" value="{{ $paciente->talla ?? '' }}" />
                                            <x-input-error :messages="$errors->get('talla')" class="mt-2" />
                                        </div>

                                        <!-- Tipo de Parto -->
                                        <div class="mt-4 md:col-span-1">
                                            <x-input-label for="tipopartoEditar" :value="__('Tipo de Parto')" />
                                            <x-text-input id="tipopartoEditar" class="block mt-1 w-full" type="text" name="tipoparto" value="{{ $paciente->tipoparto ?? '' }}" />
                                            <x-input-error :messages="$errors->get('tipoparto')" class="mt-2" />
                                        </div>

                                        <!-- Tipo de Sangre -->
                                        <div class="mt-4 md:col-span-1">
                                            <x-input-label for="tiposangreEditar" :value="__('Tipo de Sangre')" />
                                            <x-text-input id="tiposangreEditar" class="block mt-1 w-full" type="text" name="tiposangre" value="{{ $paciente->tiposangre ?? '' }}" />
                                            <x-input-error :messages="$errors->get('tiposangre')" class="mt-2" />
                                        </div>

                                        <!-- Hospital -->
                                        <div class="mt-4">
                                            <x-input-label for="hospitalEditar" :value="__('Hospital')" />
                                            <x-text-input id="hospitalEditar" class="block mt-1 w-full" type="text" name="hospital" value="{{ $paciente->hospital ?? '' }}" />
                                            <x-input-error :messages="$errors->get('hospital')" class="mt-2" />
                                        </div>
                                    </div>
                                    <div class="flex justify-end mt-4">
                                        <x-primary-button class="ml-4" id="personalNew-update" onclick="submitForm('editPacienteFormNew')">
                                            {{ __('Actualizar Información Personal') }}
                                        </x-primary-button>
                                    </div>
                                </div>

                                <!-- Nueva Sección de Contacto -->
                                <div class="bg-gray-100 p-4 rounded-lg shadow-sm mb-6" id="contactoNew">
                                    <div class="flex justify-between items-center mb-4">
                                        <h3 class="text-lg font-semibold">Contacto</h3>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                        <!-- Teléfono -->
                                        <div class="mt-4 md:col-span-1">
                                            <x-input-label for="telefono" :value="__('Teléfono')" />
                                            <x-text-input id="telefono" class="block mt-1 w-full" type="text" name="telefono" value="{{ $paciente->telefono ?? '' }}" />
                                            <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
                                        </div>

                                        <!-- Correo -->
                                        <div class="mt-4 md:col-span-3">
                                            <x-input-label for="correo" :value="__('Correo')" />
                                            <x-text-input id="correo" class="block mt-1 w-full" type="email" name="correo" value="{{ $paciente->correo ?? '' }}" required autofocus autocomplete="email" />
                                            <x-input-error :messages="$errors->get('correo')" class="mt-2" />
                                        </div>
                                    </div>
                                    <div class="flex justify-end mt-4">
                                        <x-primary-button class="ml-4" id="contacto-update" onclick="submitForm('editPacienteFormNew')">
                                            {{ __('Actualizar Contacto') }}                                            
                                        </x-primary-button>
                                    </div>
                                </div>

                                <!-- Domicilio -->
                                <div class="bg-gray-100 p-4 rounded-lg shadow-sm mb-6" id="domicilioNew">
                                    <div class="flex justify-between items-center mb-4">
                                        <h3 class="text-lg font-semibold">Domicilio</h3>
                                    </div>
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                            <select id="entidad_federativa" class="block mt-1 w-full form-select" name="entidad_federativa_id" onchange="updateMunicipios(this.value)">
                                                <option value="">Seleccione una opción</option>
                                                @foreach($entidadesFederativas as $entidad)
                                                    <option value="{{ $entidad->id }}" {{ $paciente->entidad_federativa_id == $entidad->id ? 'selected' : '' }}>
                                                        {{ $entidad->nombre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            
                                            <select id="municipio" class="block mt-1 w-full form-select" name="municipio_id" onchange="updateColonias(this.value)">
                                                <option value="">Seleccione una opción</option>
                                                @foreach($municipios as $municipio)
                                                    <option value="{{ $municipio->id_municipio }}" {{ $paciente->municipio_id == $municipio->id_municipio ? 'selected' : '' }}>
                                                        {{ $municipio->nombre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            
                                            <select id="localidad" name="localidad_id" class="block mt-1 w-full form-select">
                                                <option value="">Seleccione una opción</option>
                                                @foreach($localidades as $localidad)
                                                    <option value="{{ $localidad['id_localidad'] }}" {{ $paciente->localidad_id == $localidad['id_localidad'] ? 'selected' : '' }}>
                                                        {{ $localidad['nombre'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            
                                            <select id="colonia" class="block mt-1 w-full form-select" name="colonia_id">
                                                <option value="">Seleccione una opción</option>
                                                @foreach($colonias as $colonia)
                                                    <option value="{{ $colonia->id_asentamiento }}" {{ $paciente->colonia_id == $colonia->id_asentamiento ? 'selected' : '' }}>
                                                        {{ $colonia->cp }} - {{ $colonia->tipo_asentamiento }} - {{ $colonia->asentamiento }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    
                                                                            
                                    
                                        <!-- Calle -->
                                        <div class="mt-4 md:col-span-1">
                                            <x-input-label for="calle" :value="__('Calle')" />
                                            <x-text-input id="calle" class="block mt-1 w-full" type="text" name="calle" value="{{ $paciente->calle ?? '' }}" />
                                            <x-input-error :messages="$errors->get('calle')" class="mt-2" />
                                        </div>
                                    </div>
                                    <div class="flex justify-end mt-4">
                                        <x-primary-button class="ml-4" id="domicilioNew-update" onclick="submitForm('editPacienteFormNew')">
                                            {{ __('Actualizar Domicilio') }}
                                        </x-primary-button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div id="padres" class="tab-content hidden mt-3">
                        <!-- Contacto de Emergencias -->
                        <form method="POST" action="{{ route('pacientes.update', $paciente->id ?? 0) }}" id="padresForm">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="tab" value="padres">
                            <div class="bg-gray-100 p-4 rounded-lg shadow-sm mb-6" id="emergencias">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg font-semibold">Padres</h3>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <!-- Padre -->
                                    <div class="mt-4 md:col-span-1">
                                        <x-input-label for="padreEditar" :value="__('Padre')" />
                                        <x-text-input id="padreEditar" class="block mt-1 w-full" type="text" name="padre" value="{{ $paciente->padre ?? '' }}" />
                                        <x-input-error :messages="$errors->get('padre')" class="mt-2" />
                                    </div>
                                
                                    <!-- Madre -->
                                    <div class="mt-4 md:col-span-1">
                                        <x-input-label for="madreEditar" :value="__('Madre')" />
                                        <x-text-input id="madreEditar" class="block mt-1 w-full" type="text" name="madre" value="{{ $paciente->madre ?? '' }}" />
                                        <x-input-error :messages="$errors->get('madre')" class="mt-2" />
                                    </div>
                                
                                    <!-- Teléfono Secundario -->
                                    <div class="mt-4 md:col-span-1">
                                        <x-input-label for="telefono2Editar" :value="__('Teléfono Secundario')" />
                                        <x-text-input id="telefono2Editar" class="block mt-1 w-full" type="text" name="telefono2" value="{{ $paciente->telefono2 ?? '' }}" />
                                        <x-input-error :messages="$errors->get('telefono2')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="flex justify-end mt-4">
                                    <x-primary-button class="ml-4" id="emergencias-update" onclick="submitForm('padresForm')">
                                        {{ __('Actualizar Contacto de Emergencias') }}
                                    </x-primary-button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div id="antecedentes" class="tab-content mt-3">
                        <!-- Antecedentes -->
                        <form method="POST" action="{{ route('pacientes.update', $paciente->id ?? 0) }}" id="antecedentesForm">
                            @csrf
                            @method('PATCH')
                            <div class="bg-gray-100 p-4 rounded-lg shadow-sm mb-6" id="antecedentes">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg font-semibold">Antecedentes Familiares</h3>
                                </div>
                                <div class="mt-4">
                                    <div id="antecedentesContent">
                                        <!-- Textarea para CKEditor -->
                                        <textarea id="editor" name="antecedentes" class="form-input rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" style="resize: none; height: 450px; width: 100%;">
                                            {!! $paciente->antecedentes ?? '' !!}
                                        </textarea>
                                    </div>
                                    <x-input-error :messages="$errors->get('antecedentes')" class="mt-2" />
                                </div>
                                <div class="flex justify-end mt-4">
                                    <x-primary-button class="ml-4" id="antecedentes-update" onclick="submitForm('antecedentesForm')">
                                        {{ __('Actualizar Antecedentes') }}
                                    </x-primary-button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div id="facturacion" class="tab-content hidden mt-3">
                        <!-- Información de Facturación -->
                        <form method="POST" action="{{ route('pacientes.update', $paciente->id ?? 0) }}" id="facturacionForm">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="tab" value="facturacion">
                            <div class="bg-gray-100 p-4 rounded-lg shadow-sm mb-6" id="facturacion">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg font-semibold">Información de Facturación</h3>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Nombre de Facturación -->
                                    <div class="mt-4">
                                        <x-input-label for="Nombre_factEditar" :value="__('Razon Social')" />
                                        <x-text-input id="Nombre_factEditar" class="block mt-1 w-full" type="text" name="Nombre_fact" value="{{ $paciente->Nombre_fact ?? '' }}" />
                                        <x-input-error :messages="$errors->get('Nombre_fact')" class="mt-2" />
                                    </div>

                                    <!-- Dirección de Facturación -->
                                    <div class="mt-4">
                                        <x-input-label for="Direccion_factEditar" :value="__('Domicilio Fiscal')" />
                                        <x-text-input id="Direccion_factEditar" class="block mt-1 w-full" type="text" name="Direccion_fact" value="{{ $paciente->Direccion_fact ?? '' }}" />
                                        <x-input-error :messages="$errors->get('Direccion_fact')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <!-- RFC -->
                                    <div class="mt-4">
                                        <x-input-label for="RFCEditar" :value="__('RFC')" />
                                        <x-text-input id="RFCEditar" class="block mt-1 w-full" type="text" name="RFC" value="{{ $paciente->RFC ?? '' }}" />
                                        <x-input-error :messages="$errors->get('RFC')" class="mt-2" />
                                    </div>

                                    <!-- Régimen Fiscal -->
                                    <div class="mt-4">
                                        <x-input-label for="Regimen_fiscalEditar" :value="__('Régimen Fiscal')" />
                                        <x-text-input id="Regimen_fiscalEditar" class="block mt-1 w-full" type="text" name="Regimen_fiscal" value="{{ $paciente->Regimen_fiscal ?? '' }}" />
                                        <x-input-error :messages="$errors->get('Regimen_fiscal')" class="mt-2" />
                                    </div>

                                    <!-- CFDI -->
                                    <div class="mt-4">
                                        <x-input-label for="CFDIEditar" :value="__('CFDI')" />
                                        <x-text-input id="CFDIEditar" class="block mt-1 w-full" type="text" name="CFDI" value="{{ $paciente->CFDI ?? '' }}" />
                                        <x-input-error :messages="$errors->get('CFDI')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="flex justify-end mt-4">
                                    <x-primary-button class="ml-4" id="facturacion-update" onclick="submitForm('facturacionForm')">
                                        {{ __('Actualizar Información de Facturación') }}
                                    </x-primary-button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div id="historial" class="tab-content hidden mt-3">
                        <!-- Historial de Consultas -->
                        <div class="bg-gray-100 p-4 rounded-lg shadow-sm mb-6">
                            <h3 class="text-lg font-semibold mb-4">Historial de Consultas</h3>
                            <div class="overflow-x-auto">
                                <table id="historialTable" class="min-w-full bg-white shadow-md rounded-lg overflow-hidden display nowrap">
                                    <thead class="bg-[#2D7498] text-white">
                                        <tr>
                                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Fecha</th>
                                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Motivo</th>
                                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Diagnóstico</th>
                                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Recetas</th>
                                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Doctor</th>
                                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-700">
                                        @if(isset($consultas) && count($consultas) > 0)
                                            @foreach($consultas as $consulta)
                                                <tr>
                                                    <td class="text-left py-3 px-4">{{ \Carbon\Carbon::parse($consulta->fechaHora)->format('d M, Y h:i A') }}</td>
                                                    <td class="text-left py-3 px-4" style="max-width: 200px; word-wrap: break-word; overflow-wrap: break-word;">
                                                        {!! $consulta->motivoConsulta !!}
                                                    </td>                                                                                                        
                                                    <td class="text-left py-3 px-4" style="max-width: 200px; word-wrap: break-word; overflow-wrap: break-word;">
                                                        {!! $consulta->diagnostico !!}
                                                    </td>
                                                    <td class="text-left py-3 px-4">
                                                        {{ $consulta->recetas->count() }} {{ Str::plural('Receta', $consulta->recetas->count()) }}
                                                    </td>                                                                                                       
                                                    <td class="text-left py-3 px-4">Dr. {{ $consulta->usuarioMedico->nombres }} {{ $consulta->usuarioMedico->apepat }} {{ $consulta->usuarioMedico->apemat }}</td>
                                                    <td class="text-left py-3 px-4">
                                                        <a href="{{ route('consultas.show', $consulta->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Ver</a>
                                                        <a href="{{ route('consultas.print', $consulta->id) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Imprimir</a>
                                                    </td>                                                
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6" class="text-center py-3 px-4">No hay consultas registradas.</td>
                                            </tr>
                                        @endif
                                    </tbody>                                    
                                </table>
                            </div>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
    </div>

    <!-- DataTables CSS & JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

    <!-- Ensure jQuery is included -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- CKEditor -->
    <script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>

    <!-- SweetAlert2 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

        .dataTables_wrapper .dataTables_scrollBody {
            overflow-x: hidden;
            overflow-y: hidden;
        }

        table.dataTable tbody td {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .table th, .table td {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .dataTables_wrapper .dataTables_scrollBody {
            overflow-x: hidden;
            overflow-y: hidden;
        }
    </style>
    <style>
        .form-select {
            appearance: none;
            background-color: white;
            border: 1px solid #d1d5db;
            padding: 8px;
            border-radius: 0.375rem;
            font-size: 1rem;
            line-height: 1.5;
            color: #4a5568;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='%234a5568'%3E%3Cpath fill-rule='evenodd' d='M10 3a1 1 0 01.707.293l5 5a1 1 0 01-1.414 1.414L10 5.414 5.707 9.707a1 1 0 01-1.414-1.414l5-5A1 1 0 0110 3z' clip-rule='evenodd'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.5rem center;
            background-size: 1.5em 1.5em;
        }
        .form-select:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.5);
            border-color: #3182ce;
        }
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
        .dataTables_wrapper .dataTables_scrollBody {
            overflow-x: hidden;
            overflow-y: hidden;
        }
        table.dataTable tbody td {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .table th, .table td {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>

    <script>
        CKEDITOR.replace('editor', {
            versionCheck: false,
            toolbar: [
                { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat'] },
                { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote'] },
                { name: 'styles', items: ['Format', 'Font', 'FontSize', 'Bold', 'Italic', 'Underline'] },
                { name: 'insert', items: ['HorizontalRule'] },
                { name: 'document', items: ['Source'] },
                { name: 'justify', items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'] }
            ]
        });

        CKEDITOR.extraPlugins = "justify";
        CKEDITOR.extraPlugins = "font";
        CKEDITOR.extraPlugins = "size";

        function submitForm(formId) {
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

            $('#historialTable').DataTable({
                "language": {
                    "decimal": "",
                    "emptyTable": "No hay consultas registradas",  // Mensaje cuando no hay registros
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                    "infoEmpty": "Mostrando 0 a 0 de 0 Entradas",
                    "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                    "lengthMenu": "Mostrar _MENU_ entradas",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
                "paging": true,
                "searching": true,
                "info": true,
                "scrollX": false,
                "autoWidth": true,
                "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]],
                "columnDefs": [
                    {
                        "targets": 0,
                        "width": "15%"
                    },
                    {
                        "targets": 1,
                        "width": "20%"
                    },
                    {
                        "targets": 2,
                        "width": "20%"
                    },
                    {
                        "targets": 3,
                        "width": "20%"
                    },
                    {
                        "targets": 4,
                        "width": "15%"
                    },
                    {
                        "targets": 5,
                        "width": "10%",
                        "orderable": false
                    }
                ]
            });
        });

        function updateMunicipios(entidadId) {
            if (entidadId) {
                $.ajax({
                    url: '/get-municipios/' + entidadId,
                    type: 'GET',
                    success: function(data) {
                        $('#municipio').empty().append('<option value="">Seleccione una opción</option>');
                        $.each(data, function(index, municipio) {
                            $('#municipio').append('<option value="'+ municipio.id_municipio +'">'+ municipio.nombre +'</option>');
                        });
                        $('#localidad').empty().append('<option value="">Seleccione una opción</option>');
                        $('#colonia').empty().append('<option value="">Seleccione una opción</option>');
                    }
                });
            }
        }

        function updateColonias(municipioId) {
            let entidadId = $('#entidad_federativa').val();

            if (municipioId && entidadId) {
                // Actualizar colonias
                $.ajax({
                    url: '/get-colonias/' + municipioId,
                    type: 'GET',
                    data: { entidad_id: entidadId },
                    success: function(data) {
                        $('#colonia').empty().append('<option value="">Seleccione una opción</option>');
                        $.each(data, function(index, colonia) {
                            $('#colonia').append('<option value="'+ colonia.id_asentamiento +'">'+ colonia.cp + ' - ' + colonia.tipo_asentamiento + ' - ' + colonia.asentamiento +'</option>');
                        });
                    },
                    error: function() {
                        alert('Error al cargar las colonias.');
                    }
                });

                // Actualizar localidades
                $.ajax({
                    url: '/get-localidades/' + municipioId,
                    type: 'GET',
                    data: { entidad_id: entidadId }, // Si es necesario enviar la entidad_id
                    success: function(data) {
                        $('#localidad').empty().append('<option value="">Seleccione una opción</option>');
                        $.each(data, function(index, localidad) {
                            $('#localidad').append('<option value="'+ localidad.id_localidad +'">'+ localidad.nombre +'</option>');
                        });
                    },
                    error: function() {
                        alert('Error al cargar las localidades.');
                    }
                });
            } else {
                $('#colonia').empty().append('<option value="">Seleccione una opción</option>');
                $('#localidad').empty().append('<option value="">Seleccione una opción</option>');
            }
        }


    </script>

    @if(session('alerta'))
    <script>
            Swal.fire({
                title: 'Persona no encontrada',
                text: 'Esta persona no se encontró en los registros, se le redirigirá a la ventana de registro.',
                icon: 'warning',
                confirmButtonText: 'Aceptar'
            }).then((result) => {
                // Opcional: puedes agregar alguna acción después de cerrar el SweetAlert
            });
        </script>
    @endif

    
</x-app-layout>
