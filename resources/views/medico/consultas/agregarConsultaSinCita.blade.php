<x-app-layout>
    <!-- Pantalla de carga -->
    <div id="loader" class="loader-container">
        <div class="loader"></div>
    </div>

    <div class="bg-gray-100 flex justify-center items-start p-4" style="min-height: 100vh; width: 100%;">
        <div class="bg-white shadow-lg rounded-lg p-8 mx-4 my-8 w-full" style="max-width: 100%;">
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center">
                    <div class="flex items-center justify-center h-12 w-12 rounded-full bg-white text-xl font-bold border-2" style="border-color: #2D7498; color: #33AD9B;">
                        {{ substr($paciente->nombres, 0, 1) }}{{ substr($paciente->apepat, 0, 1) }}
                    </div>
                    <h2 class="text-3xl font-bold text-left ml-4" style="color: black;">
                        {{ $paciente->nombres }} {{ $paciente->apepat }} {{ $paciente->apemat }}
                    </h2>
                </div>
                <p class="text-lg font-medium">
                    Edad: 
                    <?php
                        $fecha_nacimiento = \Carbon\Carbon::parse($paciente->fechanac);
                        $edad = $fecha_nacimiento->diff(\Carbon\Carbon::now());
                        echo $edad->y . ' años ' . $edad->m . ' meses ' . $edad->d . ' días';
                    ?>
                </p>
            </div>

            <!-- Estructura de Tabs, Fecha de Hoy, Total a Pagar y Botón Terminar Consulta en la misma línea -->
            <div class="flex justify-between items-center mb-4">
                <!-- Estructura de Tabs -->
                <ul class="flex border-b mb-0" id="tabs">
                    <li class="-mb-px mr-1">
                        <a class="tab-link active-tab" href="#consultaTab" onclick="openTab(event, 'consultaTab')">Consulta</a>
                    </li>
                    <li class="mr-1">
                        <a class="tab-link" href="#recetasTab" onclick="openTab(event, 'recetasTab')">Recetas</a>
                    </li>
                    <li class="mr-1">
                        <a class="tab-link" href="#historialTab" onclick="openTab(event, 'historialTab')">Historial</a>
                    </li>
                    <li class="mr-1">
                        <a class="tab-link" href="#generarDocumentosTab" onclick="openTab(event, 'generarDocumentosTab')">
                            Generar documentos
                        </a>
                    </li>
                </ul>

                <div class="flex items-center space-x-2">
                    <label for="fechaActual" class="block text-sm font-medium text-gray-700" style="margin-bottom: 0;">Fecha de Consulta:</label>
                    <div id="fechaActual" class="font-semibold" style="margin-bottom: 0; align-self: center;"></div>
                </div>

                <!-- Total a Pagar y Botón Terminar Consulta -->
                <div class="flex items-center space-x-4">
                    <label for="totalPagar" class="block text-sm font-medium text-gray-700">Precio de la Consulta:</label>
                    <input type="number" id="totalPagar" name="totalPagar" class="mt-1 p-2 w-24 border rounded-md" value="{{ $precioConsulta }}" {{ $precioConsulta ? '' : 'required' }}>
                    
                    <!-- Botón Terminar Consulta -->
                    <button type="submit" id="guardarConsulta" form="consultasForm" class="bg-[#33AD9B] text-white px-4 py-2 rounded-md">Guardar Consulta</button>
                </div>
            </div>


            <div id="tab-content-wrapper" class="w-full">
                <div id="consultaTab" class="tab-pane active">
                    <form action="{{ route('consultas.storeWithoutCita') }}" method="POST" id="consultasForm">
                        @csrf
                        <input type="hidden" name="pacienteid" value="{{ $paciente->no_exp }}">
                        <input type="hidden" name="usuariomedicoid" value="{{ $medico->id }}">
                        <input type="hidden" name="status" value="en curso">
                        <div id="recetasContainer"></div>

                        <!-- Contenedores de Edad y Signos Vitales -->
                        <div class="flex justify-between space-x-2 mb-8">
                            <!-- Contenedor de Edad -->
                            <div class="w-1/4 bg-gray-100 p-4 rounded-lg">
                                <h3 class="text-lg font-medium mb-4">Edad</h3>
                                <div class="grid grid-cols-3 gap-2">
                                    <div>
                                        <label for="edad_anios" class="block text-xs font-medium text-gray-700">Años</label>
                                        <input type="text" id="edad_anios" name="años" class="mt-1 p-1 w-full border rounded-md text-xs opacity-50" style="width: 90px;" value="{{ $edad->y }}" readonly>
                                    </div>
                                    <div>
                                        <label for="edad_meses" class="block text-xs font-medium text-gray-700">Meses</label>
                                        <input type="text" id="edad_meses" name="meses" class="mt-1 p-1 w-full border rounded-md text-xs opacity-50" style="width: 90px;" value="{{ $edad->m }}" readonly>
                                    </div>
                                    <div>
                                        <label for="edad_dias" class="block text-xs font-medium text-gray-700">Días</label>
                                        <input type="text" id="edad_dias" name="dias" class="mt-1 p-1 w-full border rounded-md text-xs opacity-50" style="width: 90px;" value="{{ $edad->d }}" readonly>
                                    </div>
                                </div>
                            </div>
                        
                            <!-- Contenedor de Signos Vitales -->
                            <div class="w-3/4 bg-gray-100 p-4 rounded-lg">
                                <h3 class="text-lg font-medium mb-4">Signos Vitales</h3>
                                <div class="grid grid-cols-7 gap-2">
                                    <div>
                                        <label for="hidden_temperatura" class="block text-xs font-medium text-gray-700">Temperatura</label>
                                        <input type="text" id="hidden_temperatura" name="hidden_temperatura" class="mt-1 p-1 w-full border rounded-md text-xs" placeholder="°C" value="{{ old('hidden_temperatura') }}">
                                    </div>
                                    <div>
                                        <label for="hidden_frecuencia_cardiaca" class="block text-xs font-medium text-gray-700">Frecuencia Cardíaca</label>
                                        <input type="text" id="hidden_frecuencia_cardiaca" name="hidden_frecuencia_cardiaca" class="mt-1 p-1 w-full border rounded-md text-xs" placeholder="bpm" value="{{ old('hidden_frecuencia_cardiaca') }}">
                                    </div>
                                    <div>
                                        <label for="hidden_saturacion_oxigeno" class="block text-xs font-medium text-gray-700">Saturación de Oxígeno</label>
                                        <input type="text" id="hidden_saturacion_oxigeno" name="hidden_saturacion_oxigeno" class="mt-1 p-1 w-full border rounded-md text-xs" placeholder="%" value="{{ old('hidden_saturacion_oxigeno') }}">
                                    </div>
                                    <div>
                                        <label for="hidden_tension_arterial" class="block text-xs font-medium text-gray-700">Tensión Arterial</label>
                                        <input type="text" id="hidden_tension_arterial" name="hidden_tension_arterial" class="mt-1 p-1 w-full border rounded-md text-xs" placeholder="mmHg" value="{{ old('hidden_tension_arterial') }}">
                                    </div>
                                    <div>
                                        <label for="circunferencia_cabeza" class="block text-xs font-medium text-gray-700">Perímetro Cefálico</label>
                                        <input type="text" id="circunferencia_cabeza" name="circunferencia_cabeza" class="mt-1 p-1 w-full border rounded-md text-xs" placeholder="cm" value="{{ old('circunferencia_cabeza') }}">
                                    </div>
                                    <div>
                                        <label for="hidden_talla" class="block text-xs font-medium text-gray-700">Talla</label>
                                        <input type="text" id="hidden_talla" name="hidden_talla" class="mt-1 p-1 w-full border rounded-md text-xs" placeholder="m" value="{{ old('hidden_talla') }}">
                                    </div>
                                    <div>
                                        <label for="hidden_peso" class="block text-xs font-medium text-gray-700">Peso</label>
                                        <input type="text" id="hidden_peso" name="hidden_peso" class="mt-1 p-1 w-full border rounded-md text-xs" placeholder="kg" value="{{ old('hidden_peso') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Campos de la consulta -->
                        <div class="mb-6 grid md:grid-cols-3 gap-4">
                            <!-- Campo de Antecedentes editable -->
                            <div class="bg-gray-100 p-4 rounded-lg">
                                <label for="antecedentes" class="block text-sm font-medium text-gray-700">Antecedentes</label>
                                <textarea id="antecedentes" name="antecedentes" class="mt-1 p-2 w-full border rounded-md resize-none" style="height: 300px;">
                                    {{ $paciente->antecedentes }}
                                </textarea>
                            </div>                            

                            <div class="bg-gray-100 p-4 rounded-lg">
                                <label for="motivoConsulta" class="block text-sm font-medium text-gray-700">Motivo de la Consulta</label>
                                <textarea id="motivoConsulta" name="motivoConsulta" class="mt-1 p-2 w-full border rounded-md resize-none" style="height: 230px;">{{ old('motivoConsulta') }}</textarea>
                            </div>

                            <div class="bg-gray-100 p-4 rounded-lg">
                                <label for="diagnostico" class="block text-sm font-medium text-gray-700">Diagnóstico</label>
                                <textarea id="diagnostico" name="diagnostico" class="mt-1 p-2 w-full border rounded-md resize-none" style="height: 230px;">{{ old('diagnostico') }}</textarea>
                            </div>
                        </div>
                    </form>
                </div>

                <div id="recetasTab" class="tab-pane hidden">
                    <div class="mb-6">
                        <div class="bg-gray-100 p-4 rounded-lg flex justify-between items-center">
                            <h3 class="text-lg font-medium">Recetas</h3>
                            <button type="button" id="addReceta" class="bg-blue-500 text-white px-4 py-2 rounded-md">Agregar Receta</button>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border rounded-lg">
                                <thead>
                                    <tr class="bg-[#2D7498] text-white uppercase text-sm leading-normal">
                                        <th class="py-3 px-6 text-left">No.Receta</th>
                                        <th class="py-3 px-6 text-left">Tipo de Receta</th>
                                        <th class="py-3 px-6 text-left">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="recetas" class="space-y-4"> <!-- Aquí agregamos espacio entre filas -->
                                    <tr id="noRecetasMessage">
                                        <td colspan="3" class="text-center py-3">No hay recetas</td>
                                    </tr>
                                </tbody>
                            </table>                            
                        </div>
                    </div>

                    <!-- Modal -->
                    <div id="modalReceta" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center hidden">
                        <div class="bg-white rounded-lg shadow-lg w-1/2 p-6">
                            <h2 class="text-xl font-semibold mb-4">Agregar Receta</h2>
                            <!-- Aquí se agregan las etiquetas de los signos vitales -->
                            <div class="flex justify-center space-x-2 mb-4 flex-wrap">
                                <span class="bg-gray-200 text-gray-700 text-sm font-semibold px-2 py-1 rounded flex flex-col">
                                    Talla:
                                    <span id="modalTalla" class="text-black">N/A</span>
                                </span>
                                <span class="bg-gray-200 text-gray-700 text-sm font-semibold px-2 py-1 rounded flex flex-col">
                                    Temperatura:
                                    <span id="modalTemperatura" class="text-black">N/A</span>
                                </span>
                                <span class="bg-gray-200 text-gray-700 text-sm font-semibold px-2 py-1 rounded flex flex-col">
                                    Peso:
                                    <span id="modalPeso" class="text-black">N/A</span>
                                </span>
                                <span class="bg-gray-200 text-gray-700 text-sm font-semibold px-2 py-1 rounded flex flex-col">
                                    Tensión Arterial:
                                    <span id="modalTension" class="text-black">N/A</span>
                                </span>
                                <span class="bg-gray-200 text-gray-700 text-sm font-semibold px-2 py-1 rounded flex flex-col">
                                    Frecuencia Cardíaca:
                                    <span id="modalFrecuencia" class="text-black">N/A</span>
                                </span>
                                <span class="bg-gray-200 text-gray-700 text-sm font-semibold px-2 py-1 rounded flex flex-col">
                                    Saturación de Oxígeno:
                                    <span id="modalSaturacion" class="text-black">N/A</span>
                                </span>
                            </div>
                            <div class="mb-4">
                                <label for="modalTipoReceta" class="block text-sm font-medium text-gray-700">Tipo de Receta</label>
                                <select id="modalTipoReceta" name="recetas[0][tipo_de_receta]" class="mt-1 p-2 w-full border rounded-md">
                                    <option value="" disabled selected>Selecciona una opción</option>
                                    @foreach ($tiposDeReceta as $tipo)
                                        <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="modalRecetaInput" class="block text-sm font-medium text-gray-700">Receta</label>
                                <textarea id="modalRecetaInput" name="recetas[0][receta]" class="mt-1 p-2 w-full border rounded-md resize-none" style="height: 300px;"></textarea>
                            </div>
                            <div class="flex justify-end">
                                <button id="closeModal" class="bg-gray-500 text-white px-4 py-2 rounded-md mr-2">Cancelar</button>
                                <button id="saveReceta" class="bg-green-500 text-white px-4 py-2 rounded-md">Guardar</button>
                            </div>
                        </div>
                    </div>

                    <!-- Preview Modal -->
                    <div id="recetaModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
                        <div class="bg-white p-6 rounded-lg shadow-lg w-3/4">
                            <div class="flex justify-between items-center mb-4 border-b-2 pb-4">
                                <h3 id="recetaModalTitle" class="text-xl font-medium">Receta</h3>
                                <button id="closeRecetaModal" class="text-red-600 font-bold text-lg">&times;</button>
                            </div>
                            <div id="recetaModalContent" class="mt-4">
                                <!-- Aquí se mostrará la receta -->
                            </div>
                        </div>
                    </div> 
                </div> 
                
                <div id="historialTab" class="tab-pane hidden">
                    <div class="bg-gray-100 p-4 rounded-lg shadow-sm mb-6">
                        <h3 class="text-lg font-medium mb-4">Historial de Consultas</h3>
                        <table id="historialConsultasTable" class="min-w-full bg-white border shadow-md rounded-lg overflow-hidden">
                            <thead>
                                <tr class="bg-[#2D7498] text-white uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-left">Fecha y Hora</th>
                                    <th class="py-3 px-6 text-left">Motivo</th>
                                    <th class="py-3 px-6 text-left">Diagnóstico</th>
                                    <th class="py-3 px-6 text-left">Recetas</th>
                                    <th class="py-3 px-6 text-left">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="historialConsultas">
                                @foreach ($consultasPasadas as $consulta)
                                <tr class="border-b">
                                    <td class="py-3 px-6">
                                        {{ mb_strtoupper(\Carbon\Carbon::parse($consulta->created_at ?? $consulta->fechaHora)->format('d/m/Y h:i A')) }}
                                    </td>
                                    <td class="py-3 px-6">{!! $consulta->motivoConsulta !!}</td>
                                    <td class="py-3 px-6">{!! $consulta->diagnostico !!}</td>
                                    <td class="text-left py-3 px-4">
                                        {{ $consulta->total_recetas }} {{ Str::plural('Receta', $consulta->total_recetas) }}
                                    </td>
                                    <td class="py-3 px-6">
                                        <button class="bg-blue-500 text-white px-4 py-2 rounded"
                                            onclick="verConsulta({{ $consulta->id }}, {{ $consulta->pacienteid }}, {{ $consulta->usuariomedicoid }})">
                                            Ver
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            
                        </table>
                    </div>

                    <!-- Modal -->
                    <div id="modalConsulta" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center hidden z-50">
                        <div class="bg-white rounded-lg shadow-lg w-3/4 h-auto p-6 relative" style="max-height: 80vh; overflow-y: auto;">
                            <!-- Botón de cierre con "X" en la esquina superior derecha -->
                            <button id="closeModalConsulta" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl font-bold">&times;</button>

                            <!-- Título del modal con la fecha de la consulta -->
                            <h2 class="text-xl font-semibold mb-4">CONSULTA DEL <span id="fechaConsultaTitulo"></span></h2>                            
                            <div id="consultaDetalles" class="overflow-y-auto" style="max-height: 60vh;">
                                
                                <!-- Contenedor principal con dos columnas: Signos Vitales + Motivo y Diagnóstico (2/3) y Recetas (1/3) -->
                                <div class="grid grid-cols-3 gap-4">
                                    
                                    <!-- Contenedor de Signos Vitales, Motivo de Consulta y Diagnóstico (2/3) -->
                                    <div class="col-span-2">
                                        <!-- Contenedor de Signos Vitales -->
                                        <div class="bg-gray-100 p-4 rounded-lg mb-4">
                                            <h3 class="text-lg font-medium mb-4">Signos Vitales</h3>
                                            <div class="grid grid-cols-7 gap-4 text-sm">
                                                <!-- Campos de Signos Vitales -->
                                                <div>
                                                    <label for="detalleTalla" class="block text-xs font-medium text-gray-700">Talla</label>
                                                    <input type="text" id="detalleTalla" name="detalleTalla" class="mt-1 p-2 w-full border rounded-md text-xs" placeholder="m" readonly>
                                                </div>
                                                <div>
                                                    <label for="detalleTemperatura" class="block text-xs font-medium text-gray-700">Temperatura</label>
                                                    <input type="text" id="detalleTemperatura" name="detalleTemperatura" class="mt-1 p-2 w-full border rounded-md text-xs" placeholder="°C" readonly>
                                                </div>
                                                <div>
                                                    <label for="detalleFrecuencia" class="block text-xs font-medium text-gray-700">Frec. Cardiaca</label>
                                                    <input type="text" id="detalleFrecuencia" name="detalleFrecuencia" class="mt-1 p-2 w-full border rounded-md text-xs" placeholder="bpm" readonly>
                                                </div>
                                                <div>
                                                    <label for="detallePeso" class="block text-xs font-medium text-gray-700">Peso</label>
                                                    <input type="text" id="detallePeso" name="detallePeso" class="mt-1 p-2 w-full border rounded-md text-xs" placeholder="kg" readonly>
                                                </div>
                                                <div>
                                                    <label for="detalleTension" class="block text-xs font-medium text-gray-700">Tensión Art.</label>
                                                    <input type="text" id="detalleTension" name="detalleTension" class="mt-1 p-2 w-full border rounded-md text-xs" placeholder="mmHg" readonly>
                                                </div>
                                                <div>
                                                    <label for="detallePerimetro" class="block text-xs font-medium text-gray-700">Per. Cefálico</label>
                                                    <input type="text" id="detallePerimetro" name="detallePerimetro" class="mt-1 p-2 w-full border rounded-md text-xs" placeholder="cm" readonly>
                                                </div>
                                                <div>
                                                    <label for="detalleSaturacion" class="block text-xs font-medium text-gray-700">Sat. Oxígeno</label>
                                                    <input type="text" id="detalleSaturacion" name="detalleSaturacion" class="mt-1 p-2 w-full border rounded-md text-xs" placeholder="%" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Contenedor para Motivo de la Consulta y Diagnóstico -->
                                        <div class="grid grid-cols-2 gap-4">
                                            <!-- Motivo de la Consulta -->
                                            <div class="bg-gray-100 p-4 rounded-lg">
                                                <h3 class="text-lg font-medium mb-4">Motivo de la Consulta</h3>
                                                <p id="detalleMotivo" class="border p-2 rounded-md">N/A</p>
                                            </div>
                        
                                            <!-- Diagnóstico -->
                                            <div class="bg-gray-100 p-4 rounded-lg">
                                                <h3 class="text-lg font-medium mb-4">Diagnóstico</h3>
                                                <p id="detalleDiagnostico" class="border p-2 rounded-md">N/A</p>
                                            </div>
                                        </div>
                                    </div>
                        
                                    <!-- Contenedor de Recetas (1/3) -->
                                    <div>
                                        <div class="bg-gray-100 p-4 rounded-lg">
                                            <h3 class="text-lg font-medium mb-4">Recetas</h3>
                                            <ul id="detalleRecetas" class="border p-2 rounded-md">
                                                <li>No hay recetas asociadas a esta consulta.</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="generarDocumentosTab" class="tab-pane hidden">
                    <!-- Contenedor de Documentos -->
                    <div id="documentosContainer" class="bg-gray-100 p-4 rounded-lg shadow-sm mb-6">
                        <h3 class="text-lg font-medium mb-4">Documentos</h3>
                        <button 
                            id="mostrarPasaporteWizard" 
                            class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700"
                        >
                            Constancia de Relaciones Exteriores
                        </button>
                        <!-- Nuevo botón para Generar factura -->
                            <button 
                            id="mostrarFacturaWizard" 
                            class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700"
                        >
                            Generar Recibo de Honorarios
                        </button>
                    </div>
                
                    <!-- Wizard de 2 pasos -->
                    <div id="pasaporteWizard" class="hidden w-full">
                
                        <!-- Barra de pasos -->
                        <div class="flex justify-around items-center mb-2">
                            <!-- Paso 1: Datos del Doctor -->
                            <div class="flex flex-col items-center" id="paso1Indicator">
                                <div class="h-8 w-8 rounded-full flex items-center justify-center bg-green-600 text-white font-bold mb-1">1</div>
                                <p class="text-xs font-medium">Datos del Doctor</p>
                            </div>
                            <!-- Línea divisoria -->
                            <div class="border-t-2 border-gray-300 flex-grow mx-2" style="margin-top: 0.5rem;"></div>
                            <!-- Paso 2: Datos del Consultorio -->
                            <div class="flex flex-col items-center" id="paso2Indicator">
                                <div class="h-8 w-8 rounded-full flex items-center justify-center bg-gray-300 text-white font-bold mb-1">2</div>
                                <p class="text-xs font-medium text-gray-400">Datos del Consultorio</p>
                            </div>
                            <!-- Línea divisoria -->
                            <div class="border-t-2 border-gray-300 flex-grow mx-2" style="margin-top: 0.5rem;"></div>
                            <!-- Paso 3: Datos del Paciente -->
                            <div class="flex flex-col items-center" id="paso3Indicator">
                                <div class="h-8 w-8 rounded-full flex items-center justify-center bg-gray-300 text-white font-bold mb-1">3</div>
                                <p class="text-xs font-medium text-gray-400">Datos del Paciente</p>
                            </div>
                            <!-- Línea divisoria -->
                            <div class="border-t-2 border-gray-300 flex-grow mx-2" style="margin-top: 0.5rem;"></div>
                            <!-- Paso 4: Generar PDF -->
                            <div class="flex flex-col items-center" id="paso4Indicator">
                                <div class="h-8 w-8 rounded-full flex items-center justify-center bg-gray-300 text-white font-bold mb-1">4</div>
                                <p class="text-xs font-medium text-gray-400">Generar PDF</p>
                            </div>
                        </div>

                
                        <!-- Contenedor de cada paso -->
                        <!-- Paso 1: Datos del Doctor -->
                        <div id="paso1Contenido" class="bg-white p-4 rounded shadow-md">
                            <h4 class="text-lg font-semibold mb-4">Paso 1: Datos del Doctor</h4>
                            <form id="formPaso1">
                                <div class="mb-4 flex items-center space-x-4">
                                    <div class="flex-1">
                                        <label for="doctorName" class="block text-sm font-medium text-gray-700">Nombre</label>
                                        <input 
                                            type="text"
                                            id="doctorName"
                                            name="doctorName"
                                            class="w-full mt-1 border rounded p-2"
                                            value="{{ old('doctorName', 'DR. ' . $medico->nombres . ' ' . $medico->apepat . ' ' . $medico->apemat) }}"
                                            placeholder="Ej: Dr. Juan Pérez" 
                                            required
                                        >
                                    </div>
                                    <div class="flex-1">
                                        <label for="cedula" class="block text-sm font-medium text-gray-700">Cédula Profesional</label>
                                        <input 
                                            type="text"
                                            id="cedula"
                                            name="cedula"
                                            class="w-full mt-1 border rounded p-2"
                                            value="{{ old('cedula', $cedulaProfesional) }}"
                                            placeholder="Ej: 12345678"
                                            required
                                        >
                                    </div>
                                    <div class="flex-1">
                                        <label for="telefonoPersonalMedico" class="block text-sm font-medium text-gray-700">Teléfono Celular</label>
                                        <input
                                            type="text"
                                            id="telefonoPersonalMedico"
                                            name="telefonoPersonalMedico"
                                            class="w-full mt-1 border rounded p-2"
                                            value="{{ old('telefonoPersonalMedico', $telefonoPersonalMedico) }}"
                                            placeholder="Ej: 8343011758"
                                            required
                                        >
                                    </div>   
                                </div>
                            </form>
                            <div class="flex justify-between">
                                <button id="backToDocuments" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Regresar</button>
                                <button id="nextPaso1" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Siguiente</button>
                            </div>
                        </div>

                        <!-- Paso 2: Datos del Consultorio -->
                        <div id="paso2Contenido" class="hidden bg-white p-4 rounded shadow-md">
                            <h4 class="text-lg font-semibold mb-4">Paso 2: Datos del Consultorio</h4>
                            <form id="formPaso2">
                                <div class="mb-4 flex space-x-4">
                                    <!-- Campo de Calle con mayor ancho -->
                                    <div class="flex-grow">
                                        <label for="calle" class="block text-sm font-medium text-gray-700">Calle del Consultorio</label>
                                        <input 
                                            type="text" 
                                            id="calle"
                                            name="calle"
                                            class="w-full mt-1 border rounded p-2"
                                            value="{{ old('calle', $calle) }}"
                                            placeholder="Ej: Av. Principal #123"
                                            required
                                        >
                                    </div>
                                    <!-- Campo de Teléfono con menor ancho -->
                                    <div class="w-1/3">
                                        <label for="telefonoConsultorio" class="block text-sm font-medium text-gray-700">Teléfono del Consultorio</label>
                                        <input
                                            type="text"
                                            id="telefonoConsultorio"
                                            name="telefonoConsultorio"
                                            class="w-full mt-1 border rounded p-2"
                                            value="{{ old('telefonoConsultorio', $telefonoConsultorio) }}"
                                            placeholder="Ej: 8343011758"
                                            required
                                        >
                                    </div>
                                </div>
                            </form>
                            <div class="flex justify-between">
                                <button id="backPaso2" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Regresar</button>
                                <button id="nextPaso2" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Siguiente</button>
                            </div>
                        </div>

                        <!-- Paso 3: Datos del Paciente -->
                        <div id="paso3Contenido" class="hidden bg-white p-4 rounded shadow-md">
                            <h4 class="text-lg font-semibold mb-4">Paso 3: Datos del Paciente</h4>
                            <form id="formPaso3">
                                <div class="mb-4 flex space-x-4">
                                    <!-- Campo Nombre -->
                                    <div class="flex-1">
                                        <label for="pacienteNombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                                        <input
                                            type="text"
                                            id="pacienteNombre"
                                            name="pacienteNombre"
                                            class="w-full mt-1 border rounded p-2"
                                            value="{{ old('pacienteNombre', $paciente->nombres . ' ' . $paciente->apepat . ' ' . $paciente->apemat) }}"
                                            placeholder="Nombre completo"
                                            required
                                        >
                                    </div>
                                    <!-- Campo Padre -->
                                    <div class="flex-1">
                                        <label for="padre" class="block text-sm font-medium text-gray-700">Padre</label>
                                        <input
                                            type="text"
                                            id="padre"
                                            name="padre"
                                            class="w-full mt-1 border rounded p-2"
                                            value="{{ old('padre', $paciente->padre ?? '') }}"
                                            placeholder="Nombre del padre"
                                            required
                                        >
                                    </div>
                                    <!-- Campo Madre -->
                                    <div class="flex-1">
                                        <label for="madre" class="block text-sm font-medium text-gray-700">Madre</label>
                                        <input
                                            type="text"
                                            id="madre"
                                            name="madre"
                                            class="w-full mt-1 border rounded p-2"
                                            value="{{ old('madre', $paciente->madre ?? '') }}"
                                            placeholder="Nombre de la madre"
                                            required
                                        >
                                    </div>
                                </div>
                            </form>
                            <div class="flex justify-between">
                                <button id="backPaso3" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Regresar</button>
                                <button id="nextPaso3" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Siguiente</button>
                            </div>
                        </div>


                        <!-- Paso 4: Generar PDF -->
                        <div id="paso4Contenido" class="hidden bg-white p-4 rounded shadow-md">
                            <h4 class="text-lg font-semibold mb-4">Paso 4: Generar PDF</h4>
                            <p>Haz clic en el botón para generar el PDF de la Constancia de Relaciones Exteriores.</p>
                            
                            <!-- Botones de navegación -->
                            <div class="flex justify-between mt-4">
                                <button id="backPaso4" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Regresar</button>
                                <button id="generarPDFWizard" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Generar PDF</button>
                            </div>
                            
                            <!-- Iframe para la vista previa del PDF -->
                            <div id="pdfPreviewContainer" class="mt-6 hidden w-full h-auto">
                                <iframe id="pdfPreviewFrameWizard" src="" frameborder="0" class="w-full h-full"></iframe>
                            </div>
                        </div>
                    </div>

                    <!-- Wizard para la factura -->
                    <div id="facturaWizard" class="hidden w-full">
                        <!-- Barra de pasos - similar a la existente, ajusta títulos según corresponda -->
                        <div class="flex justify-around items-center mb-2">
                            <!-- Reutilizamos los mismos pasos para datos del médico, consultorio y paciente -->
                            <div class="flex flex-col items-center" id="factPaso1Indicator">
                                <div class="h-8 w-8 rounded-full flex items-center justify-center bg-green-600 text-white font-bold mb-1">1</div>
                                <p class="text-xs font-medium">Datos del Doctor</p>
                            </div>
                            <!-- Se repiten los mismos pasos 2, 3 y 4 para mantener la consistencia -->
                            <div class="border-t-2 border-gray-300 flex-grow mx-2" style="margin-top: 0.5rem;"></div>
                            <div class="flex flex-col items-center" id="factPaso2Indicator">
                                <div class="h-8 w-8 rounded-full flex items-center justify-center bg-gray-300 text-white font-bold mb-1">2</div>
                                <p class="text-xs font-medium text-gray-400">Datos del Consultorio</p>
                            </div>
                            <div class="border-t-2 border-gray-300 flex-grow mx-2" style="margin-top: 0.5rem;"></div>
                            <div class="flex flex-col items-center" id="factPaso3Indicator">
                                <div class="h-8 w-8 rounded-full flex items-center justify-center bg-gray-300 text-white font-bold mb-1">3</div>
                                <p class="text-xs font-medium text-gray-400">Solicitante</p>
                            </div>
                            <div class="border-t-2 border-gray-300 flex-grow mx-2" style="margin-top: 0.5rem;"></div>
                            <div class="flex flex-col items-center" id="factPaso4Indicator">
                                <div class="h-8 w-8 rounded-full flex items-center justify-center bg-gray-300 text-white font-bold mb-1">4</div>
                                <p class="text-xs font-medium text-gray-400">Datos del Recibo</p>
                            </div>
                            <div class="border-t-2 border-gray-300 flex-grow mx-2" style="margin-top: 0.5rem;"></div>
                            <div class="flex flex-col items-center" id="factPaso5Indicator">
                                <div class="h-8 w-8 rounded-full flex items-center justify-center bg-gray-300 text-white font-bold mb-1">5</div>
                                <p class="text-xs font-medium text-gray-400">Generar PDF</p>
                            </div>
                        </div>

                        <!-- Contenido de cada paso para la factura -->
                        <!-- Paso 1: Datos del Doctor -->
                        <div id="factPaso1Contenido" class="bg-white p-4 rounded">
                            <h4 class="text-lg font-semibold mb-4">Paso 1: Datos del Doctor</h4>
                            <form id="formFactPaso1">
                                
                                <div class="mb-4 flex items-center space-x-4">
                                    <!-- Nombre del Doctor -->
                                    <div class="flex-1">
                                        <label for="factDoctorName" class="block text-sm font-medium text-gray-700">Nombre</label>
                                        <input 
                                            type="text"
                                            id="factDoctorName"
                                            name="doctorName"
                                            class="w-full mt-1 border rounded p-2"
                                            value="{{ old('doctorName', 'DR. ' . $medico->nombres . ' ' . $medico->apepat . ' ' . $medico->apemat) }}"
                                            required
                                        >
                                    </div>
                                    <!-- Correo Electrónico -->
                                    <div class="flex-1">
                                        <label for="factDoctorEmail" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                                        <input 
                                            type="email" 
                                            id="factDoctorEmail" 
                                            name="doctorEmail" 
                                            class="w-full mt-1 border rounded p-2" 
                                            value="{{ old('doctorEmail', $emailMedico) }}" 
                                            required
                                        >
                                    </div>
                                    <!-- Cédula Profesional -->
                                    <div class="flex-1">
                                        <label for="factCedula" class="block text-sm font-medium text-gray-700">Cédula Profesional</label>
                                        <input 
                                            type="text"
                                            id="factCedula"
                                            name="cedula"
                                            class="w-full mt-1 border rounded p-2"
                                            value="{{ old('cedula', $cedulaProfesional) }}"
                                            required
                                        >
                                    </div>
                                    <!-- Teléfono Celular Personal del Médico -->
                                    <div class="flex-1">
                                        <label for="factTelefonoPersonalMedico" class="block text-sm font-medium text-gray-700">Teléfono Celular</label>
                                        <input
                                            type="text"
                                            id="factTelefonoPersonalMedico"
                                            name="telefonoPersonalMedico"
                                            class="w-full mt-1 border rounded p-2"
                                            value="{{ old('telefonoPersonalMedico', $telefonoPersonalMedico) }}"
                                            required
                                        >
                                    </div>
                                </div>                                
                            </form>
                            <div class="flex justify-between">
                                <button id="factBackToDocuments" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Regresar</button>
                                <button id="nextFactPaso1" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Siguiente</button>
                            </div>
                        </div>

                        <div id="factPaso2Contenido" class="hidden bg-white p-4 rounded">
                            <h4 class="text-lg font-semibold mb-4">Paso 2: Datos del Consultorio</h4>
                            <form id="formFactPaso2">
                                <div class="mb-4 flex items-center space-x-4">
                                    <!-- Calle del Consultorio -->
                                    <div class="flex-1">
                                        <label for="factCalle" class="block text-sm font-medium text-gray-700">Calle del Consultorio</label>
                                        <input 
                                            type="text" 
                                            id="factCalle"
                                            name="calle"
                                            class="w-full mt-1 border rounded p-2"
                                            value="{{ old('calle', $calle) }}"
                                            required
                                        >
                                    </div>
                                    <!-- Teléfono del Consultorio -->
                                    <div class="flex-3">
                                        <label for="factTelefonoConsultorio" class="block text-sm font-medium text-gray-700">Teléfono del Consultorio</label>
                                        <input
                                            type="text"
                                            id="factTelefonoConsultorio"
                                            name="telefonoConsultorio"
                                            class="w-full mt-1 border rounded p-2"
                                            value="{{ old('telefonoConsultorio', $telefonoConsultorio) }}"
                                            required
                                        >
                                    </div>
                                </div>
                            </form>
                            <div class="flex justify-between">
                                <button id="backFactPaso2" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Regresar</button>
                                <button id="nextFactPaso2" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Siguiente</button>
                            </div>
                        </div>
                        
                        <!-- Paso 3: Datos de quien recibe -->
                        <div id="factPaso3Contenido" class="hidden bg-white p-4 rounded ">
                            <h4 class="text-lg font-semibold mb-4">Paso 3: Datos del Solicitante</h4>
                            <form id="formFactPaso3">
                                <div class="mb-4">
                                    <span class="block text-sm font-medium text-gray-700 mb-2">Seleccione una opcion:</span>
                                    <div class="flex flex-col space-y-2">
                                        <!-- Opción Padre -->
                                        <div class="flex items-center space-x-2 w-full">
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="quienRecibe" value="padre" class="form-radio" required>
                                                <span class="ml-2">Padre</span>
                                            </label>
                                            <input type="text" id="inputPadre" name="padre" 
                                                class="mt-1 p-2 border rounded-md opacity-50 cursor-not-allowed flex-grow" 
                                                placeholder="Nombre del Padre" disabled
                                                value="{{ $paciente->padre ?? '' }}">
                                        </div>
                                        <!-- Opción Madre -->
                                        <div class="flex items-center space-x-2 w-full">
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="quienRecibe" value="madre" class="form-radio" required>
                                                <span class="ml-2">Madre</span>
                                            </label>
                                            <input type="text" id="inputMadre" name="madre" 
                                                class="mt-1 p-2 border rounded-md opacity-50 cursor-not-allowed flex-grow" 
                                                placeholder="Nombre de la Madre" disabled
                                                value="{{ $paciente->madre ?? '' }}">
                                        </div>
                                        <!-- Opción Otro -->
                                        <div class="flex items-center space-x-2 w-full">
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="quienRecibe" value="otro" class="form-radio" required>
                                                <span class="ml-2">Otro</span>
                                            </label>
                                            <input type="text" id="inputOtro" name="otro" 
                                                class="mt-1 p-2 border rounded-md opacity-50 cursor-not-allowed flex-grow" 
                                                placeholder="Otro" disabled>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="flex justify-between">
                                <button id="backFactPaso3" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Regresar</button>
                                <button id="nextFactPaso3" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Siguiente</button>
                            </div>
                        </div>

                        <!-- Paso 4: Datos de Factura -->
                        <div id="factPaso4Contenido" class="hidden bg-white p-4">
                            <h4 class="text-lg font-semibold mb-4">Paso 4: Datos de Factura</h4>
                            <form id="formFactPaso4">
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700">CANTIDAD:</label>
                                    <input 
                                        type="number" 
                                        name="cantidad" 
                                        class="w-1/4 mt-1 border rounded p-2" 
                                        placeholder="Cantidad" 
                                        required
                                        step="any"
                                    >
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700">CONCEPTO:</label>
                                    <textarea 
                                        name="concepto" 
                                        class="w-full mt-1 border rounded p-2" 
                                        rows="3" 
                                        placeholder="Descripción del concepto" 
                                        required
                                    ></textarea>
                                </div>
                            </form>
                            <div class="flex justify-between">
                                <button id="backFactPaso4" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Regresar</button>
                                <button id="nextFactPaso4" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Siguiente</button>
                            </div>
                        </div>

                        <!-- Paso 5: Generar PDF -->
                        <div id="factPaso5Contenido" class="hidden bg-white p-4 rounded">
                            <h4 class="text-lg font-semibold mb-4">Paso 5: Generar PDF</h4>
                            <p>Haz clic en el botón para generar la factura.</p>
                            
                            <div class="flex justify-between mt-4">
                                <button id="backFactPaso5" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Regresar</button>
                                <button id="generarPDFFactura" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Generar PDF</button>
                            </div>
                            
                            <!-- Iframe para vista previa del PDF -->
                            <div id="pdfPreviewContainerFactura" class="mt-6 hidden w-full h-auto">
                                <iframe id="pdfPreviewFrameFactura" src="" frameborder="0" class="w-full h-full"></iframe>
                            </div>                            
                        </div>
                    </div>

                </div>
            </div>

            @if (old('recetas'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        let recetas = @json(old('recetas'));
                        let recetasDiv = document.getElementById('recetas');
                        recetasDiv.innerHTML = ''; // Limpia el contenido actual

                        recetas.forEach((receta, index) => {
                            let newRecetaRow = document.createElement('tr');
                            newRecetaRow.classList.add('receta', 'bg-gray-100', 'border-b', 'border-gray-200');
                            newRecetaRow.setAttribute('data-index', index);

                            newRecetaRow.innerHTML = `
                                <td class="py-3 px-6 text-left whitespace-nowrap">${index + 1}</td>
                                <td class="py-3 px-6 text-left">
                                    <input type="hidden" name="recetas[${index}][tipo_de_receta]" value="${receta.tipo_de_receta}">${receta.tipo_de_receta}
                                </td>
                                <td class="py-3 px-6 text-left">
                                    <input type="hidden" name="recetas[${index}][receta]" value="${encodeURIComponent(receta.receta)}">
                                    <button type="button" class="text-blue-500 hover:text-blue-700 previsualizar-receta" data-receta="${encodeURIComponent(receta.receta)}">Previsualizar</button>
                                    <button type="button" class="text-yellow-500 hover:text-yellow-700 editar-receta ml-2" data-receta-index="${index}">Editar</button>
                                    <button type="button" class="text-red-500 hover:text-red-700 eliminar-receta ml-2">Eliminar</button>
                                </td>
                            `;

                            recetasDiv.appendChild(newRecetaRow);

                            // Añadir event listeners a los botones de cada receta
                            newRecetaRow.querySelector('.eliminar-receta').addEventListener('click', function () {
                                newRecetaRow.remove();
                                if (recetasDiv.getElementsByClassName('receta').length === 0) {
                                    recetasDiv.innerHTML = '<tr id="noRecetasMessage"><td colspan="3" class="text-center py-3">No hay recetas</td></tr>';
                                }
                            });

                            newRecetaRow.querySelector('.previsualizar-receta').addEventListener('click', function () {
                                const recetaContent = decodeURIComponent(this.dataset.receta);
                                document.getElementById('recetaModalContent').innerHTML = recetaContent;
                                document.getElementById('recetaModal').classList.remove('hidden');
                            });

                            newRecetaRow.querySelector('.editar-receta').addEventListener('click', function () {
                                const recetaIndex = this.dataset.recetaIndex;
                                const tipoRecetaInput = document.querySelector(`input[name="recetas[${recetaIndex}][tipo_de_receta]"]`).value;
                                const recetaInput = decodeURIComponent(document.querySelector(`input[name="recetas[${recetaIndex}][receta]"]`).value);
                                
                                document.getElementById('modalTipoReceta').value = tipoRecetaInput;
                                CKEDITOR.instances['modalRecetaInput'].setData(recetaInput);
                                document.getElementById('modalReceta').classList.remove('hidden');
                                document.getElementById('saveReceta').setAttribute('data-edit-index', recetaIndex);
                            });
                        });
                    });
                </script>
            @endif

            <script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
            <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
            <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
            
            <style>
                /* Asegúrate de que los nuevos indicadores de pasos sigan el mismo estilo */
                .paso-indicator {
                    flex: 1;
                    text-align: center;
                }

                /* Asegura que el wizard no sobrepase los bordes del tab */
                #pasaporteWizard {
                    max-width: 100%;
                    overflow-x: hidden;
                }

                /* Asegura que el wizard no sobrepase los bordes del tab */
                #pasaporteWizard {
                    max-width: 100%;
                    overflow-x: hidden;
                }

                /* Ajustar el iframe para que sea responsivo */
                #pdfPreviewFrameWizard {
                    width: 100%;
                    height: 600px;
                    border: none;
                }

                /* Opcional: Ajustar el contenedor de la vista previa para una mejor presentación */
                #pdfPreviewContainer {
                    border-top: 1px solid #e2e8f0;
                    padding-top: 20px;
                }

                /* Ajustar el iframe para que sea responsivo */
                #pdfPreviewFrameFactura {
                    width: 100%;
                    height: 600px;
                    border: none;
                }

                /* Opcional: Ajustar el contenedor de la vista previa para una mejor presentación */
                #pdfPreviewContainerFactura {
                    border-top: 1px solid #e2e8f0;
                    padding-top: 20px;
                }

            </style>
            <script>
                // Si existen errores de validación (en $errors), muéstralos con un SweetAlert:
                @if ($errors->any())
                    let errorsHtml = `
                        <ul style="list-style:none; padding:0; margin:0;">
                            @foreach($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    `;
                    Swal.fire({
                        icon: 'error',
                        title: 'Errores de validación',
                        html: errorsHtml,
                        confirmButtonText: 'Aceptar'
                    });
                @endif
            </script>
            
            <script>
                // Manejo de navegación entre pasos del wizard
                document.addEventListener('DOMContentLoaded', function() {
                    // Botones Paso 1
                    document.getElementById('nextPaso1').addEventListener('click', function() {
                        // Validar formulario Paso 1
                        if (document.getElementById('formPaso1').checkValidity()) {
                            avanzarPaso(1);
                        } else {
                            document.getElementById('formPaso1').reportValidity();
                        }
                    });
            
                    // Botones Paso 2
                    document.getElementById('nextPaso2').addEventListener('click', function() {
                        // Validar formulario Paso 2
                        if (document.getElementById('formPaso2').checkValidity()) {
                            avanzarPaso(2);
                        } else {
                            document.getElementById('formPaso2').reportValidity();
                        }
                    });
            
                    // Botones Paso 3
                    document.getElementById('nextPaso3').addEventListener('click', function() {
                        // Validar formulario Paso 3
                        if (document.getElementById('formPaso3').checkValidity()) {
                            avanzarPaso(3);
                        } else {
                            document.getElementById('formPaso3').reportValidity();
                        }
                    });
            
                    // Botones Regresar
                    document.getElementById('backPaso2').addEventListener('click', function() {
                        regresarPaso(2);
                    });
                    document.getElementById('backPaso3').addEventListener('click', function() {
                        regresarPaso(3);
                    });
                    document.getElementById('backPaso4').addEventListener('click', function() {
                        regresarPaso(4);
                    });
            
                    // Botón Generar PDF en el Paso 4
                    // Manejo del botón "Generar PDF" en el Wizard
                    document.getElementById('generarPDFWizard').addEventListener('click', function() {
                        // Obtener los datos de los formularios de los pasos anteriores
                        const formPaso1 = document.getElementById('formPaso1');
                        const formPaso2 = document.getElementById('formPaso2');
                        const formPaso3 = document.getElementById('formPaso3');

                        // Crear un objeto FormData y agregar los datos de los formularios
                        let formData = new FormData();

                        // Paso 1
                        formData.append('doctorName', formPaso1.doctorName.value);
                        formData.append('cedula', formPaso1.cedula.value);
                        formData.append('telefonoPersonalMedico', formPaso1.telefonoPersonalMedico.value);

                        // Paso 2
                        formData.append('calle', formPaso2.calle.value);
                        formData.append('telefonoConsultorio', formPaso2.telefonoConsultorio.value);

                        // Paso 3
                        formData.append('pacienteNombre', formPaso3.pacienteNombre.value);
                        formData.append('padre', formPaso3.padre.value);
                        formData.append('madre', formPaso3.madre.value);

                        // Enviar la solicitud AJAX al controlador para generar el PDF
                        fetch('{{ route('documento.generarPasaporteDesdeFormulario') }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                            },
                            body: formData
                        })
                        .then(response => {
                            if (!response.ok) {
                                return response.json().then(err => { throw err; });
                            }
                            return response.json();
                        })
                        .then(data => {
                            if(data.pdfBase64){
                                // Mostrar la vista previa en el iframe
                                document.getElementById('pdfPreviewFrameWizard').src = 'data:application/pdf;base64,' + data.pdfBase64;
                                document.getElementById('pdfPreviewContainer').classList.remove('hidden');

                                // Actualizar indicadores de paso
                                document.getElementById('paso4Indicator').querySelector('.h-8').classList.remove('bg-green-600');
                                document.getElementById('paso4Indicator').querySelector('.h-8').classList.add('bg-blue-600');
                                // Puedes añadir más lógica para indicar que el PDF fue generado
                            } else {
                                alert('Error al generar el PDF.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            if (error.errors) {
                                let mensajes = '';
                                for (const [campo, msgs] of Object.entries(error.errors)) {
                                    mensajes += `${campo}: ${msgs.join(', ')}\n`;
                                }
                                alert(`Errores de validación:\n${mensajes}`);
                            } else if (error.message) {
                                alert(`Error: ${error.message}`);
                            } else {
                                alert('Ocurrió un error al generar el PDF.');
                            }
                        });
                    });
                        
                    // Función para avanzar al siguiente paso
                    function avanzarPaso(pasoActual) {
                        // Ocultar contenido del paso actual
                        document.getElementById(`paso${pasoActual}Contenido`).classList.add('hidden');
            
                        // Mostrar contenido del siguiente paso
                        document.getElementById(`paso${pasoActual + 1}Contenido`).classList.remove('hidden');
            
                        // Actualizar indicadores de paso
                        document.getElementById(`paso${pasoActual}Indicator`).querySelector('.h-8').classList.remove('bg-green-600');
                        document.getElementById(`paso${pasoActual}Indicator`).querySelector('.h-8').classList.add('bg-gray-300');
                        document.getElementById(`paso${pasoActual + 1}Indicator`).querySelector('.h-8').classList.remove('bg-gray-300');
                        document.getElementById(`paso${pasoActual + 1}Indicator`).querySelector('.h-8').classList.add('bg-green-600');
                    }
            
                    // Función para regresar al paso anterior
                    function regresarPaso(pasoActual) {
                        // Ocultar contenido del paso actual
                        document.getElementById(`paso${pasoActual}Contenido`).classList.add('hidden');
            
                        // Mostrar contenido del paso anterior
                        document.getElementById(`paso${pasoActual - 1}Contenido`).classList.remove('hidden');
            
                        // Actualizar indicadores de paso
                        document.getElementById(`paso${pasoActual}Indicator`).querySelector('.h-8').classList.remove('bg-green-600');
                        document.getElementById(`paso${pasoActual}Indicator`).querySelector('.h-8').classList.add('bg-gray-300');
                        document.getElementById(`paso${pasoActual - 1}Indicator`).querySelector('.h-8').classList.remove('bg-gray-300');
                        document.getElementById(`paso${pasoActual - 1}Indicator`).querySelector('.h-8').classList.add('bg-green-600');
                    }
            
                    // Mostrar el Wizard y ocultar el contenedor de Documentos
                    document.getElementById('mostrarPasaporteWizard').addEventListener('click', function () {
                        // Ocultar el contenedor de Documentos
                        const documentosDiv = document.getElementById('documentosContainer');
                        documentosDiv.classList.add('hidden'); // Usa la clase hidden para ocultar

                        // Mostrar el Wizard
                        const wizardDiv = document.getElementById('pasaporteWizard');
                        wizardDiv.classList.remove('hidden'); // Quita la clase hidden para mostrar
                    });

                    // Regresar al contenedor de Documentos y ocultar el Wizard
                    document.getElementById('backToDocuments').addEventListener('click', function () {
                        // Mostrar el contenedor de Documentos
                        const documentosDiv = document.getElementById('documentosContainer');
                        documentosDiv.classList.remove('hidden'); // Quita la clase hidden para mostrar

                        // Ocultar el Wizard
                        const wizardDiv = document.getElementById('pasaporteWizard');
                        wizardDiv.classList.add('hidden'); // Usa la clase hidden para ocultar
                    });

            
                });
            </script>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Mostrar el wizard de factura y ocultar otros elementos
                    document.getElementById('mostrarFacturaWizard').addEventListener('click', function () {
                        document.getElementById('documentosContainer').classList.add('hidden');
                        document.getElementById('facturaWizard').classList.remove('hidden');
                    });
                
                    // Regresar al contenedor de Documentos desde el wizard de factura
                    document.getElementById('factBackToDocuments').addEventListener('click', function () {
                        document.getElementById('facturaWizard').classList.add('hidden');
                        document.getElementById('documentosContainer').classList.remove('hidden');
                    });
                
                    // Funciones para avanzar y regresar entre pasos en el wizard de factura
                    function avanzarFactPaso(pasoActual) {
                        // Ocultar el contenido del paso actual
                        document.getElementById(`factPaso${pasoActual}Contenido`).classList.add('hidden');
                
                        // Mostrar contenido del siguiente paso
                        document.getElementById(`factPaso${pasoActual + 1}Contenido`).classList.remove('hidden');
                
                        // Actualizar indicadores de paso
                        document.getElementById(`factPaso${pasoActual}Indicator`).querySelector('.h-8').classList.remove('bg-green-600');
                        document.getElementById(`factPaso${pasoActual}Indicator`).querySelector('.h-8').classList.add('bg-gray-300');
                        document.getElementById(`factPaso${pasoActual + 1}Indicator`).querySelector('.h-8').classList.remove('bg-gray-300');
                        document.getElementById(`factPaso${pasoActual + 1}Indicator`).querySelector('.h-8').classList.add('bg-green-600');
                    }
                
                    function regresarFactPaso(pasoActual) {
                        // Ocultar el contenido del paso actual
                        document.getElementById(`factPaso${pasoActual}Contenido`).classList.add('hidden');
                
                        // Mostrar contenido del paso anterior
                        document.getElementById(`factPaso${pasoActual - 1}Contenido`).classList.remove('hidden');
                
                        // Actualizar indicadores de paso
                        document.getElementById(`factPaso${pasoActual}Indicator`).querySelector('.h-8').classList.remove('bg-green-600');
                        document.getElementById(`factPaso${pasoActual}Indicator`).querySelector('.h-8').classList.add('bg-gray-300');
                        document.getElementById(`factPaso${pasoActual - 1}Indicator`).querySelector('.h-8').classList.remove('bg-gray-300');
                        document.getElementById(`factPaso${pasoActual - 1}Indicator`).querySelector('.h-8').classList.add('bg-green-600');
                    }
                
                    // Ejemplo de asignación de eventos para navegación en el wizard de factura
                    document.getElementById('nextFactPaso1').addEventListener('click', function() {
                        if(document.getElementById('formFactPaso1').checkValidity()) {
                            avanzarFactPaso(1);
                        } else {
                            document.getElementById('formFactPaso1').reportValidity();
                        }
                    });
                
                    document.getElementById('nextFactPaso2').addEventListener('click', function() {
                        if(document.getElementById('formFactPaso2').checkValidity()) {
                            avanzarFactPaso(2);
                        } else {
                            document.getElementById('formFactPaso2').reportValidity();
                        }
                    });
                
                    document.getElementById('nextFactPaso3').addEventListener('click', function() {
                        // Validar que al menos un radio esté seleccionado y que el input correspondiente no esté vacío
                        const selectedRadio = document.querySelector('input[name="quienRecibe"]:checked');
                        let isValid = false;
                        if(selectedRadio) {
                            if(selectedRadio.value === 'padre' && document.getElementById('inputPadre').value.trim() !== '') {
                                isValid = true;
                            } else if(selectedRadio.value === 'madre' && document.getElementById('inputMadre').value.trim() !== '') {
                                isValid = true;
                            } else if(selectedRadio.value === 'otro' && document.getElementById('inputOtro').value.trim() !== '') {
                                isValid = true;
                            }
                        }
                        
                        if(isValid) {
                            avanzarFactPaso(3);
                        } else {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Seleccione el solicitante',
                                text: 'Por favor, complete el campo correspondiente a la opción seleccionada.'
                            });
                        }
                    });


                
                    document.getElementById('nextFactPaso4').addEventListener('click', function() {
                        if(document.getElementById('formFactPaso4').checkValidity()) {
                            avanzarFactPaso(4);
                        } else {
                            document.getElementById('formFactPaso4').reportValidity();
                        }
                    });
                
                    document.getElementById('backFactPaso2').addEventListener('click', function() {
                        regresarFactPaso(2);
                    });
                
                    document.getElementById('backFactPaso3').addEventListener('click', function() {
                        regresarFactPaso(3);
                    });
                
                    document.getElementById('backFactPaso4').addEventListener('click', function() {
                        regresarFactPaso(4);
                    });
                
                    document.getElementById('backFactPaso5').addEventListener('click', function() {
                        regresarFactPaso(5);
                    });
                
                    document.getElementById('generarPDFFactura').addEventListener('click', function() {
                        // Recopilar datos de todos los formularios del wizard de factura
                        let formFact1 = document.getElementById('formFactPaso1');
                        let formFact2 = document.getElementById('formFactPaso2');
                        let formFact4 = document.getElementById('formFactPaso4');
                        
                        let formData = new FormData();
                        
                        // Paso 1 y 2
                        formData.append('doctorName', formFact1.doctorName.value);
                        formData.append('cedula', formFact1.cedula.value);
                        formData.append('telefonoPersonalMedico', formFact1.telefonoPersonalMedico.value);
                        formData.append('doctorEmail', formFact1.doctorEmail.value); // Añadir el correo
                        formData.append('calle', formFact2.calle.value);
                        formData.append('telefonoConsultorio', formFact2.telefonoConsultorio.value);
                        
                        // Paso 3: Datos de quien recibe
                        const selectedRadio = document.querySelector('input[name="quienRecibe"]:checked');
                        let quienRecibe = '';
                        if(selectedRadio) {
                            if(selectedRadio.value === 'padre') {
                                quienRecibe = document.getElementById('inputPadre').value;
                            } else if(selectedRadio.value === 'madre') {
                                quienRecibe = document.getElementById('inputMadre').value;
                            } else if(selectedRadio.value === 'otro') {
                                quienRecibe = document.getElementById('inputOtro').value;
                            }
                        }
                        formData.append('quienRecibe', quienRecibe);
                        
                        // Paso 4: Cantidad y Concepto
                        formData.append('cantidad', formFact4.cantidad.value);
                        formData.append('concepto', formFact4.concepto.value);
                        
                        // Enviar la solicitud AJAX para generar el PDF de la factura
                        fetch('{{ route('ruta.generarFacturaDesdeFormulario') }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                            },
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log(data); // Verificar la respuesta en la consola
                            if(data.pdfBase64){
                                document.getElementById('pdfPreviewFrameFactura').src = 'data:application/pdf;base64,' + data.pdfBase64;
                                document.getElementById('pdfPreviewContainerFactura').classList.remove('hidden');
                            } else {
                                alert('Error al generar la factura.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Ocurrió un error al generar el PDF de la factura.');
                        });
                    });
                });
            </script>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const radios = document.querySelectorAll('input[name="quienRecibe"]');
                    const inputPadre = document.getElementById('inputPadre');
                    const inputMadre = document.getElementById('inputMadre');
                    const inputOtro = document.getElementById('inputOtro');
                
                    radios.forEach(radio => {
                        radio.addEventListener('change', function() {
                            // Deshabilitar todos los inputs inicialmente
                            inputPadre.disabled = true;
                            inputMadre.disabled = true;
                            inputOtro.disabled = true;
                            inputPadre.classList.add('opacity-50','cursor-not-allowed');
                            inputMadre.classList.add('opacity-50','cursor-not-allowed');
                            inputOtro.classList.add('opacity-50','cursor-not-allowed');
                
                            // Habilitar el input correspondiente a la opción seleccionada
                            if(this.value === 'padre') {
                                inputPadre.disabled = false;
                                inputPadre.classList.remove('opacity-50','cursor-not-allowed');
                            } else if(this.value === 'madre') {
                                inputMadre.disabled = false;
                                inputMadre.classList.remove('opacity-50','cursor-not-allowed');
                            } else if(this.value === 'otro') {
                                inputOtro.disabled = false;
                                inputOtro.classList.remove('opacity-50','cursor-not-allowed');
                            }
                        });
                    });
                });
            </script>
    
    
            <script>
                // Función para actualizar los signos vitales dentro del modal
                function updateModalVitalSigns() {
                    const talla = document.getElementById('hidden_talla').value || 'N/A';
                    const temperatura = document.getElementById('hidden_temperatura').value || 'N/A';
                    const peso = document.getElementById('hidden_peso').value || 'N/A';
                    const tension = document.getElementById('hidden_tension_arterial').value || 'N/A';
                    const frecuencia = document.getElementById('hidden_frecuencia_cardiaca').value || 'N/A';
                    const saturacion = document.getElementById('hidden_saturacion_oxigeno').value || 'N/A';

                    document.getElementById('modalTalla').textContent = talla;
                    document.getElementById('modalTemperatura').textContent = temperatura;
                    document.getElementById('modalPeso').textContent = peso;
                    document.getElementById('modalTension').textContent = tension;
                    document.getElementById('modalFrecuencia').textContent = frecuencia;
                    document.getElementById('modalSaturacion').textContent = saturacion;
                }

                // Mostrar el modal al hacer clic en el botón "Agregar Receta"
                document.getElementById('addReceta').addEventListener('click', function() {
                    updateModalVitalSigns(); // Actualiza los signos vitales en el modal
                    document.getElementById('modalReceta').classList.remove('hidden'); // Mostrar el modal
                });

                // Mostrar el modal al hacer clic en el botón "Editar Receta"
                document.querySelectorAll('.editar-receta').forEach(function(button) {
                    button.addEventListener('click', function() {
                        // Código para cargar los datos de la receta actual (puedes ajustar según tu implementación)
                        const recetaIndex = this.getAttribute('data-receta-index');
                        const tipoRecetaInput = document.querySelector(`input[name="recetas[${recetaIndex}][tipo_de_receta]"]`).value;
                        const recetaInput = decodeURIComponent(document.querySelector(`input[name="recetas[${recetaIndex}][receta]"]`).value);
                        
                        document.getElementById('modalTipoReceta').value = tipoRecetaInput;
                        CKEDITOR.instances['modalRecetaInput'].setData(recetaInput);

                        updateModalVitalSigns(); // Actualizar los signos vitales dentro del modal
                        document.getElementById('modalReceta').classList.remove('hidden'); // Mostrar el modal
                    });
                });

                // Cerrar el modal
                document.getElementById('closeModal').addEventListener('click', function() {
                    document.getElementById('modalReceta').classList.add('hidden');
                });

                $(document).ready(function() {
                    $('#historialConsultasTable').DataTable({
                        "language": {
                            "decimal": "",
                            "emptyTable": "No hay consultas registradas",
                            "info": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                            "infoEmpty": "Mostrando 0 a 0 de 0 entradas",
                            "infoFiltered": "(filtrado de _MAX_ entradas en total)",
                            "lengthMenu": "Mostrar _MENU_ entradas",
                            "loadingRecords": "Cargando...",
                            "processing": "Procesando...",
                            "search": "Buscar:",
                            "zeroRecords": "No se encontraron coincidencias",
                            "paginate": {
                                "first": "Primero",
                                "last": "Último",
                                "next": "Siguiente",
                                "previous": "Anterior"
                            }
                        },
                        "paging": true,
                        "ordering": true,
                        "info": true,
                        "autoWidth": true,
                        "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "Todo"]],
                        "order": [[0, 'desc']],  // Ordena por la primera columna (fecha) en orden descendente
                        "columnDefs": [
                            {
                                "targets": 0,
                                "render": function (data, type, row) {
                                    // Convierte la fecha a formato YYYYMMDD para que se ordene correctamente por año, mes y día
                                    var dateParts = data.split('/');
                                    return type === 'sort' ? dateParts[2] + dateParts[1] + dateParts[0] : data;
                                }
                            }
                        ]
                    });
                });


                function verConsulta(consultaId, pacienteId, medicoId) {
                    const url = `/consultas/${consultaId}/detalles/${pacienteId}/${medicoId}`;

                    fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                        .then(response => response.json())
                        .then(data => {
                            // Convierte la fecha a objeto Date
                            const fechaConsulta = new Date(data.fechaHora);

                            // Extrae día, mes (numérico) y año, asegurándote de agregar ceros a la izquierda
                            const dia = String(fechaConsulta.getDate()).padStart(2, '0'); 
                            const mes = String(fechaConsulta.getMonth() + 1).padStart(2, '0');
                            const año = fechaConsulta.getFullYear();

                            // Formato: dd/mm/yyyy
                            const fechaFormateada = `${dia}/${mes}/${año}`;

                            // Ahora se asigna "19/12/2024" en lugar de "19 DIC 2024"
                            document.getElementById('fechaConsultaTitulo').innerText = fechaFormateada;

                            // Asignar otros datos al modal
                            document.getElementById('detalleTalla').value = data.talla;
                            document.getElementById('detallePeso').value = data.peso;
                            document.getElementById('detalleFrecuencia').value = data.frecuencia_cardiaca;
                            document.getElementById('detalleTemperatura').value = data.temperatura;
                            document.getElementById('detalleSaturacion').value = data.saturacion_oxigeno;
                            document.getElementById('detalleTension').value = data.tension_arterial;
                            document.getElementById('detallePerimetro').value = data.circunferencia_cabeza;
                            document.getElementById('detalleMotivo').innerHTML = data.motivoConsulta;
                            document.getElementById('detalleDiagnostico').innerHTML = data.diagnostico;

                            // Manejar recetas
                            const recetasContainer = document.getElementById('detalleRecetas');
                            recetasContainer.innerHTML = ''; // Limpia el contenido previo
                            if (data.recetas && data.recetas.length > 0) {
                                data.recetas.forEach(receta => {
                                    const recetaItem = document.createElement('li');
                                    recetaItem.innerHTML = `<strong>${receta.tipo_receta_nombre}:</strong> ${receta.receta}`;
                                    recetasContainer.appendChild(recetaItem);
                                });
                            } else {
                                recetasContainer.innerHTML = '<li>No hay recetas asociadas a esta consulta.</li>';
                            }

                            document.getElementById('modalConsulta').classList.remove('hidden');
                        })
                        .catch(error => console.error('Error:', error));
                }

                // Cerrar el modal
                document.getElementById('closeModalConsulta').addEventListener('click', function () {
                    document.getElementById('modalConsulta').classList.add('hidden');
                });

                // Función para calcular la edad en años, meses y días
                function calcularEdad(fechaNacimiento) {
                    var hoy = new Date();
                    var nacimiento = new Date(fechaNacimiento);

                    var años = hoy.getFullYear() - nacimiento.getFullYear();
                    var meses = hoy.getMonth() - nacimiento.getMonth();
                    var dias = hoy.getDate() - nacimiento.getDate();

                    if (meses < 0 || (meses === 0 && dias < 0)) {
                        años--;
                        meses += (meses < 0 ? 12 : 0);
                    }

                    if (dias < 0) {
                        meses--;
                        dias += 30;  // Ajuste aproximado para días del mes
                    }

                    // Asignar los valores a los campos ocultos
                    document.getElementById('hidden_anios').value = años;
                    document.getElementById('hidden_meses').value = meses;
                    document.getElementById('hidden_dias').value = dias;
                }

                // Calcular edad en base a la fecha de nacimiento del paciente antes de enviar el formulario
                document.getElementById('consultasForm').addEventListener('submit', function(event) {
                    calcularEdad("{{ $paciente->fechanac }}");  // Usa la fecha de nacimiento del paciente
                });

                function openTab(event, tabName) {
                    var i, tabcontent, tablinks;
                    tabcontent = document.getElementsByClassName("tab-pane");
                    for (i = 0; i < tabcontent.length; i++) {
                        tabcontent[i].classList.remove("active");
                    }
                    tablinks = document.getElementsByClassName("tab-link");
                    for (i = 0; i < tablinks.length; i++) {
                        tablinks[i].classList.remove("active-tab");
                    }
                    document.getElementById(tabName).classList.add("active");
                    event.currentTarget.classList.add("active-tab");
                }

                // Set default tab
                document.addEventListener("DOMContentLoaded", function() {
                    openTab({currentTarget: document.querySelector(`[href="#consultaTab"]`)}, 'consultaTab');
                });

                CKEDITOR.replace('motivoConsulta', {
                    versionCheck: false,
                    enterMode: CKEDITOR.ENTER_P, // Salto de línea con interlineado
                    shiftEnterMode: CKEDITOR.ENTER_BR, // Salto de línea sin interlineado
                    toolbar: [
                        { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat'] },
                        { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote'] },
                        { name: 'styles', items: ['Format', 'Font', 'FontSize'] },
                        { name: 'insert', items: ['HorizontalRule'] },
                        { name: 'justify', items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'] }
                    ],
                    removePlugins: 'exportpdf'
                });

                CKEDITOR.replace('diagnostico', {
                    versionCheck: false,
                    enterMode: CKEDITOR.ENTER_P, // Salto de línea con interlineado
                    shiftEnterMode: CKEDITOR.ENTER_BR, // Salto de línea sin interlineado
                    toolbar: [
                        { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat'] },
                        { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote'] },
                        { name: 'styles', items: ['Format', 'Font', 'FontSize'] },
                        { name: 'insert', items: ['HorizontalRule'] },
                        { name: 'justify', items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'] }
                    ],
                    removePlugins: 'exportpdf'
                });

                CKEDITOR.replace('modalRecetaInput', {
                    versionCheck: false,
                    enterMode: CKEDITOR.ENTER_P, // Salto de línea con interlineado
                    shiftEnterMode: CKEDITOR.ENTER_BR, // Salto de línea sin interlineado
                    toolbar: [
                        { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat'] },
                        { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote'] },
                        { name: 'styles', items: ['Format', 'Font', 'FontSize'] },
                        { name: 'insert', items: ['HorizontalRule'] },
                        { name: 'justify', items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'] }
                    ],
                    removePlugins: 'exportpdf' // Remover el plugin 'exportpdf'
                });

                CKEDITOR.replace('antecedentes', {
                    versionCheck: false,
                    enterMode: CKEDITOR.ENTER_P, // Salto de línea con interlineado
                    shiftEnterMode: CKEDITOR.ENTER_BR, // Salto de línea sin interlineado
                    toolbar: [
                        { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat'] },
                        { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote'] },
                        { name: 'styles', items: ['Format', 'Font', 'FontSize'] },
                        { name: 'insert', items: ['HorizontalRule'] },
                        { name: 'justify', items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'] }
                    ],
                    removePlugins: 'exportpdf'
                });

                CKEDITOR.extraPlugins = "justify"
                CKEDITOR.extraPlugins = "font"
                CKEDITOR.extraPlugins = "size"

                document.getElementById('addReceta').addEventListener('click', function () {
                    document.getElementById('modalTipoReceta').value = '';
                    CKEDITOR.instances['modalRecetaInput'].setData('');
                    document.getElementById('modalReceta').classList.remove('hidden');
                    document.getElementById('saveReceta').setAttribute('data-edit-index', '');
                });

                // Declarar una variable de contador fuera de la función para que mantenga el valor entre ejecuciones
                let recetaCounter = 0;
                let recetaNumbers = []; // Para rastrear los números de receta
                let deletedNumbers = []; // Números de recetas eliminados que pueden ser reutilizados

                document.getElementById('saveReceta').addEventListener('click', function () {
                    let tipoRecetaId = document.getElementById('modalTipoReceta').value;
                    let receta = CKEDITOR.instances['modalRecetaInput'].getData(); // Obtén el contenido en formato HTML

                    // Obtener el nombre del tipo de receta basado en el ID seleccionado
                    let tipoRecetaNombre = document.querySelector(`#modalTipoReceta option[value="${tipoRecetaId}"]`).textContent;

                    if (tipoRecetaId && receta) {
                        let recetaIndex = this.getAttribute('data-edit-index');
                        let recetasDiv = document.getElementById('recetasContainer');
                        let recetasTableBody = document.getElementById('recetas');

                        if (recetaIndex !== '') {
                            // Editar receta existente
                            document.querySelector(`input[name="recetas[${recetaIndex}][tipo_de_receta]"]`).value = tipoRecetaId;
                            document.querySelector(`input[name="recetas[${recetaIndex}][receta]"]`).value = receta;

                            let existingRow = recetasTableBody.querySelector(`tr[data-receta-id="${recetaIndex}"]`);
                            existingRow.querySelector('td:nth-child(2)').innerText = tipoRecetaNombre; // Mostrar el nombre en lugar del ID
                            // Actualizar los atributos `data-receta` en los botones de Previsualizar e Imprimir
                            existingRow.querySelector('.previsualizar-receta').setAttribute('data-receta', encodeURIComponent(receta));
                            existingRow.querySelector('.imprimir-receta').setAttribute('data-receta', encodeURIComponent(receta));
                        } else {
                            let recetaNumber = deletedNumbers.length > 0 ? deletedNumbers.shift() : ++recetaCounter;

                            // Agregar nueva receta
                            recetasDiv.innerHTML += `
                                <input type="hidden" name="recetas[${recetaCounter}][tipo_de_receta]" value="${tipoRecetaId}">
                                <input type="hidden" name="recetas[${recetaCounter}][receta]" value="${receta}">`;

                            // Agregar la receta a la tabla en la interfaz
                            let newRecetaRow = document.createElement('tr');
                            newRecetaRow.classList.add('receta');
                            newRecetaRow.setAttribute('data-receta-id', recetaCounter); // Agrega un atributo para identificar la receta
                            newRecetaRow.innerHTML = `
                                <td>${recetaCounter}</td> <!-- Número de receta -->
                                <td>${tipoRecetaNombre}</td> <!-- Nombre de la receta -->
                                <td>
                                    <button type="button" class="text-blue-500 hover:text-blue-700 previsualizar-receta" data-receta="${receta}">Previsualizar</button>
                                    <button type="button" class="text-yellow-500 hover:text-yellow-700 editar-receta ml-2" data-receta-index="${recetaCounter}">Editar</button>
                                    <button type="button" class="text-red-500 hover:text-red-700 eliminar-receta ml-2">Eliminar</button>
                                    <button type="button" class="text-green-500 hover:text-green-700 imprimir-receta ml-2" data-receta="${encodeURIComponent(receta)}">Imprimir</button>
                                </td>`;

                            recetasTableBody.appendChild(newRecetaRow);

                            // Añadir eventos a los botones de previsualizar, editar, eliminar e imprimir
                            newRecetaRow.querySelector('.imprimir-receta').addEventListener('click', function () {
                                                const recetaContent = decodeURIComponent(this.dataset.receta);
                                                                
                                                // Extraemos el nombre, fecha, talla y peso
                                                const nombreCompleto = "{{ $paciente->nombres }} {{ $paciente->apepat }} {{ $paciente->apemat }}";
                                                const fechaActual = formatDate(new Date());
                                                const talla = document.getElementById('hidden_talla').value || 'N/A';
                                                const peso = document.getElementById('hidden_peso').value || 'N/A';
                                                                
                                                // Crear un elemento temporal para calcular el número de líneas
                                                const tempDiv = document.createElement('div');
                                                tempDiv.style.position = 'absolute';
                                                tempDiv.style.visibility = 'hidden';
                                                tempDiv.style.width = '800px';
                                                tempDiv.style.lineHeight = '1.5em';
                                                tempDiv.innerHTML = recetaContent;
                                                document.body.appendChild(tempDiv);
                                                                
                                                // Calcular la altura y determinar cuántas líneas hay
                                                const lineHeight = parseFloat(window.getComputedStyle(tempDiv).lineHeight);
                                                const totalLines = tempDiv.offsetHeight / lineHeight;
                                                                
                                                // Remover el elemento temporal
                                                document.body.removeChild(tempDiv);

                                                // Verificar si excede el límite de 8 líneas
                                                if (totalLines > 6) {
                                                    alert("Sobrepasa los límites de la receta");
                                                } else {
                                                    const printWindow = window.open('', '', 'width=800,height=600');
                                                        printWindow.document.write(`
                                                            <br><br><br><br><br><br><br>
                                                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 0 40px;">
                                                                <div style="flex-basis: 40%; text-align: left; font-size: 10px; font-weight: normal;">${nombreCompleto}</div>
                                                                <div style="flex-basis: 20%; text-align: right; font-size: 12px; font-weight: normal;">${fechaActual}</div>
                                                                <div style="flex-basis: 10%; text-align: right; font-size: 12px; font-weight: normal;">${peso}</div>
                                                                <div style="flex-basis: 10%; text-align: right; font-size: 12px; font-weight: normal;">${talla}</div>
                                                            </div>
                                                            <div style="padding: 20px 40px; font-size: 15px;">
                                                                ${recetaContent}
                                                            </div>
                                                        `);
                                                        printWindow.document.write('</body></html>');
                                                        printWindow.document.close();
                                                        printWindow.focus();
                                                        printWindow.print();
                                                    }
                                            });


                            // Añadir eventos a los botones de previsualizar, editar, eliminar e imprimir
                            newRecetaRow.querySelector('.eliminar-receta').addEventListener('click', function () {
                                // Eliminar receta del DOM y los inputs
                                let recetaId = parseInt(newRecetaRow.getAttribute('data-receta-id'));
                                
                                // Eliminar la receta en los inputs ocultos
                                let hiddenRecetas = recetasDiv.querySelectorAll(`input[name^="recetas[${recetaId}]"]`);
                                hiddenRecetas.forEach(function (input) {
                                    input.remove();
                                });

                                // Eliminar la fila visualmente
                                newRecetaRow.remove();

                                // Si no hay más recetas, mostrar el mensaje de "No hay recetas"
                                if (recetasTableBody.getElementsByClassName('receta').length === 0) {
                                    recetasTableBody.innerHTML = '<tr id="noRecetasMessage"><td colspan="3" class="text-center py-3">No hay recetas</td></tr>';
                                }
                            });

                            newRecetaRow.querySelector('.previsualizar-receta').addEventListener('click', function () {
                                const recetaContent = decodeURIComponent(this.dataset.receta);
                                document.getElementById('recetaModalContent').innerHTML = recetaContent;
                                document.getElementById('recetaModal').classList.remove('hidden');
                            });

                            newRecetaRow.querySelector('.editar-receta').addEventListener('click', function () {
                                const recetaIndex = this.dataset.recetaIndex;
                                const tipoRecetaInput = document.querySelector(`input[name="recetas[${recetaIndex}][tipo_de_receta]"]`).value;
                                const recetaInput = decodeURIComponent(document.querySelector(`input[name="recetas[${recetaIndex}][receta]"]`).value);

                                document.getElementById('modalTipoReceta').value = tipoRecetaInput;
                                CKEDITOR.instances['modalRecetaInput'].setData(recetaInput);
                                document.getElementById('modalReceta').classList.remove('hidden');
                                document.getElementById('saveReceta').setAttribute('data-edit-index', recetaIndex);
                            });
                        }

                        // Remover el mensaje de "No hay recetas" si existe
                        let noRecetasMessage = document.getElementById('noRecetasMessage');
                        if (noRecetasMessage) {
                            noRecetasMessage.remove();
                        }

                        // Cerrar el modal de la receta
                        document.getElementById('modalReceta').classList.add('hidden');
                    } else {
                        alert('Por favor, complete todos los campos.');
                    }
                });

                function formatDate(date) {
                    let day = ('0' + date.getDate()).slice(-2); // Asegura dos dígitos
                    let month = ('0' + (date.getMonth() + 1)).slice(-2); // Asegura dos dígitos
                    let year = date.getFullYear();
                    return `${day}/${month}/${year}`; // Cambia el orden a día/mes/año
                }

                // Evento para cerrar el modal de visualización de la receta
                document.getElementById('closeRecetaModal').addEventListener('click', function () {
                    document.getElementById('recetaModal').classList.add('hidden');
                });

                // Evento para cerrar el modal de edición de receta
                document.getElementById('closeModal').addEventListener('click', function () {
                    clearModalFields();
                });

                // Función para limpiar los campos del modal
                function clearModalFields() {
                    document.getElementById('modalReceta').classList.add('hidden');
                    document.getElementById('modalTipoReceta').value = '';
                    CKEDITOR.instances['modalRecetaInput'].setData('');
                }

                document.getElementById('closeRecetaModal').addEventListener('click', function () {
                    document.getElementById('recetaModal').classList.add('hidden');
                });

                document.querySelectorAll('.eliminar-receta').forEach(button => {
                    button.addEventListener('click', function () {
                        button.closest('tr').remove();
                        if (document.getElementById('recetas').getElementsByClassName('receta').length === 0) {
                            document.getElementById('recetas').innerHTML = '<tr id="noRecetasMessage"><td colspan="3" class="text-center py-3">No hay recetas</td></tr>';
                        }
                    });
                });

                document.getElementById('consultasForm').addEventListener('submit', function () {
                    CKEDITOR.instances['modalRecetaInput'].updateElement();
                });


                // Add unit validation on blur event for vital signs fields
                const vitalSignsFields = {
                    'hidden_talla': 'm',
                    'hidden_temperatura': '°C',
                    'hidden_saturacion_oxigeno': '%',
                    'hidden_frecuencia_cardiaca': 'bpm',
                    'hidden_peso': 'kg',
                    'hidden_tension_arterial': 'mmHg',
                    'circunferencia_cabeza': 'cm'
                };

                for (const [fieldId, unit] of Object.entries(vitalSignsFields)) {
                    const field = document.getElementById(fieldId);

                    // Al hacer focus: quitar unidad si está al final
                    field.addEventListener('focus', function () {
                        if (this.value.endsWith(unit)) {
                            this.value = this.value.slice(0, -unit.length).trim();
                        }
                    });

                    // Al perder el foco (blur): agregar unidad si no existe y el campo no está vacío
                    field.addEventListener('blur', function () {
                        if (this.value && !this.value.endsWith(unit)) {
                            this.value += ` ${unit}`;
                        }
                    });
                }


                document.addEventListener('DOMContentLoaded', function() {
                    let showAlert = @json($showAlert); // Pasamos la variable desde el backend

                    if (showAlert) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Concepto de Consulta no encontrado',
                            text: 'Por favor, agregue un concepto de consulta en la configuración antes de continuar.',
                            confirmButtonText: 'Aceptar'
                        }).then(() => {
                            window.location.href = "{{ route('conceptos.index') }}"; // Redirigir a la página de crear concepto
                        });
                    }
                });

                document.addEventListener('DOMContentLoaded', function() {
                    var today = new Date();
                    var options = { year: 'numeric', month: '2-digit', day: '2-digit' };
                    var formattedDate = today.toLocaleDateString('es-ES', options); // Cambia 'es-ES' según tu formato de idioma preferido
                    document.getElementById('fechaActual').innerText = formattedDate;
                });

                document.addEventListener('DOMContentLoaded', function() {
                    // Desactiva el botón de "Guardar Consulta" al enviar el formulario
                    document.getElementById('consultasForm').addEventListener('submit', function() {
                        const submitButton = document.getElementById('guardarConsulta');
                        submitButton.disabled = true; // Desactiva el botón
                        submitButton.innerText = 'Guardando...';  // Cambia el texto del botón mientras se guarda
                    });
                });

                document.addEventListener('DOMContentLoaded', function () {
                    // Mostrar el loader
                    document.getElementById('loader').style.display = 'flex';

                    window.onload = function() {
                        // Ocultar el loader una vez que todo el contenido se haya cargado
                        document.getElementById('loader').style.display = 'none';
                        // Mostrar el contenido
                        document.querySelector('.py-12').style.display = 'block';
                    };
                });

            </script>

            <style>
                .dataTables_filter input[type="search"] {
                    width: 500px !important; /* Ajusta el tamaño a tu preferencia */
                    padding: 6px 12px; /* Ajuste de padding */
                    font-size: 16px;
                    border-radius: 4px;
                    border: 1px solid #ccc;
                    box-sizing: border-box; /* Asegura que el padding y el border estén incluidos en el tamaño total del elemento */
                }

                .dataTables_filter input[type="search"]:focus {
                    border-color: #007bff; /* Color del borde azul */
                    outline: none; /* Elimina el outline por defecto */
                    box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.25); /* Añade un efecto de sombra azul alrededor del borde */
                }
                
                #recetaModalContent ul,
                #recetaModalContent ol {
                    list-style-type: disc; /* Puntos para listas no ordenadas */
                    padding-left: 30px;
                    font-size: 0.9em; /* Reduce el tamaño de la fuente */
                    line-height: 1.2em; /* Reduce el interlineado */
                }
            
                #recetaModalContent ol {
                    list-style-type: decimal; /* Números para listas ordenadas */
                }
            
                #recetaModalContent li {
                    margin-bottom: 0.3em; /* Espaciado reducido entre elementos de lista */
                }

                #recetaModalContent p {
                    margin: 1em 0; /* Controla el interlineado cuando se presiona Enter */
                }

                #recetaModalContent br {
                    margin: 0; /* No agrega espacio cuando se presiona Shift + Enter */
                    line-height: 1.2em; /* Opcional: ajusta el interlineado de las líneas */
                }

                /* Estilos para las pestañas */
                .tab-link {
                    color: black;
                    text-decoration: none;
                    padding: 10px 20px;
                    display: inline-block;
                    font-weight: normal;
                    border-bottom: 2px solid transparent;
                    cursor: pointer;
                    font-size: 16px; /* Asegúrate de que el tamaño de la fuente sea el mismo */
                }

                .active-tab {
                    font-weight: bold;
                    border-bottom: 2px solid #2D7498;
                }

                .tab-link:hover {
                    font-weight: bold;
                }

                .tab-pane {
                    display: none;
                }

                .tab-pane.active {
                    display: block;
                }

                /* Si la línea es un borde en el contenedor del nombre, elimínalo */
                .nombre-contenedor {
                    border-bottom: none; /* Asegúrate de que el borde inferior esté desactivado */
                    margin-bottom: 0; /* Ajusta el margen si es necesario */
                }

                /* Mantén la línea en los tabs */
                #tabs {
                    border-bottom: 1px solid #e2e8f0; /* Mantén la línea en los tabs */
                    margin-top: 0; /* Elimina el margen superior para que las pestañas estén pegadas al nombre */
                }

                /* Pantalla de carga centrada */
                .loader-container {
                    position: fixed;
                    z-index: 9999;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background-color: rgba(255, 255, 255, 0.9); /* Fondo semitransparente */
                    display: flex;
                    justify-content: center;
                    align-items: center;
                }

                .loader {
                    border: 16px solid #f3f3f3;
                    border-top: 16px solid #3498db;
                    border-radius: 50%;
                    width: 120px;
                    height: 120px;
                    animation: spin 2s linear infinite;
                }
            </style>
        </div>
    </div>
</x-app-layout>
