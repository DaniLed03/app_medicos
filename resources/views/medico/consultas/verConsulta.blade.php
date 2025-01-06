<x-app-layout>
    <!-- Pantalla de carga -->
    <div id="loader" class="loader-container">
        <div class="loader"></div>
    </div>

    <div class="bg-gray-100 min-h-screen flex justify-center items-center">
        <div class="bg-white shadow-lg rounded-lg p-8 mx-4 my-8 w-full" style="max-width: 100%;">
            
            <!-- Navegación entre consultas -->
            <div class="flex justify-center items-center mb-4 space-x-2">
                <button id="firstConsultation" class="bg-gray-300 text-black px-4 py-2 rounded-md">
                    <!-- Icono doble flecha izquierda -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                         class="bi bi-chevron-double-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" 
                              d="M8.354 1.646a.5.5 0 0 1 0 .708L2.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0"/>
                        <path fill-rule="evenodd" 
                              d="M12.354 1.646a.5.5 0 0 1 0 .708L6.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0"/>
                    </svg>
                </button>
                <button id="prevConsultation" class="bg-gray-300 text-black px-4 py-2 rounded-md">
                    <!-- Flecha izquierda -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                         class="bi bi-chevron-compact-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" 
                              d="M9.224 1.553a.5.5 0 0 1 .223.67L6.56 8l2.888 5.776a.5.5 0 1 1-.894.448l-3-6a.5.5 0 0 1 0-.448l3-6a.5.5 0 0 1 .671-.223"/>
                    </svg>
                </button>

                <!-- Fecha de la consulta -->
                <h3 id="consultationDate" class="text-xl font-medium">
                    Fecha de Consulta: 
                    {{ \Illuminate\Support\Str::upper(\Carbon\Carbon::parse($fechaConsulta)->format('d/m/Y')) }}
                </h3>

                <button id="nextConsultation" class="bg-gray-300 text-black px-4 py-2 rounded-md">
                    <!-- Flecha derecha -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                         class="bi bi-chevron-compact-right" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" 
                              d="M6.776 1.553a.5.5 0 0 1 .671.223l3 6a.5.5 0 0 1 0 .448l-3 6a.5.5 0 1 1-.894-.448L9.44 8 6.553 2.224a.5.5 0 0 1 .223-.671"/>
                    </svg>
                </button>
                <button id="lastConsultation" class="bg-gray-300 text-black px-4 py-2 rounded-md">
                    <!-- Flecha doble derecha -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                         class="bi bi-chevron-double-right" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" 
                              d="M3.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L9.293 8 3.646 2.354a.5.5 0 0 1 0-.708"/>
                        <path fill-rule="evenodd" 
                              d="M7.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L13.293 8 7.646 2.354a.5.5 0 0 1 0-.708"/>
                    </svg>
                </button>
            </div>

            <!-- Datos del paciente -->
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center">
                    <!-- Iniciales del paciente -->
                    <div class="flex items-center justify-center h-12 w-12 rounded-full 
                                bg-white text-xl font-bold border-2"
                         style="border-color: #2D7498; color: #33AD9B;">
                        {{ substr($paciente->nombres, 0, 1) }}{{ substr($paciente->apepat, 0, 1) }}
                    </div>
                    <h2 class="text-3xl font-bold text-left ml-4" style="color: black;">
                        {{ $paciente->nombres }} {{ $paciente->apepat }} {{ $paciente->apemat }}
                    </h2>
                </div>
                <p class="text-lg font-medium">
                    Edad: 
                    {{ \Carbon\Carbon::parse($paciente->fechanac)
                                     ->diff(\Carbon\Carbon::now())
                                     ->format('%y años, %m meses, %d días') }}
                </p>
            </div>

            <!-- Estructura de Tabs y Precio -->
            <div class="flex justify-between items-center mb-4">
                <ul class="flex border-b mb-0" id="tabs">
                    <li class="-mb-px mr-1">
                        <a class="tab-link active-tab" 
                           href="#consultaTab" 
                           onclick="openTab(event, 'consultaTab')">
                            Consulta
                        </a>
                    </li>
                    <li class="mr-1">
                        <a class="tab-link" 
                           href="#recetasTab" 
                           onclick="openTab(event, 'recetasTab')">
                            Recetas
                        </a>
                    </li>
                </ul>

                <div class="flex items-center space-x-4">
                    <label for="modalTotalPagar" class="block text-sm font-medium text-gray-700">
                        Precio de la Consulta
                    </label>
                    <input type="number" 
                           id="modalTotalPagar" 
                           value="{{ $consulta->totalPagar }}" 
                           class="mt-1 p-2 w-24 border rounded-md" 
                           disabled>
                    <a href="{{ route('medico.pacientes.editarPaciente', 
                            ['id' => $paciente->no_exp, 'tab' => 'historial']) }}"
                       class="bg-gray-400 text-black px-4 py-2 rounded-md">
                        Cerrar
                    </a>
                </div>
            </div>

            <!-- Contenido de los Tabs -->
            <div id="tab-content-wrapper" style="min-height: 400px; max-height: 600px;">
                <!-- Tab de Consulta -->
                <div id="consultaTab" class="tab-pane active">
                    <form>
                        <!-- Contenedores de Edad, Signos Vitales, Motivo de la Consulta, Diagnóstico y Antecedentes -->
                        <div class="flex justify-between space-x-2 mb-8">
                            <!-- Edad -->
                            <div class="w-1/4 bg-gray-100 p-4 rounded-lg">
                                <h3 class="text-lg font-medium mb-4">Edad</h3>
                                <div class="grid grid-cols-3 gap-2">
                                    <div>
                                        <label for="edad_anios"
                                               class="block text-xs font-medium text-gray-700">
                                            Años
                                        </label>
                                        <input type="text" 
                                               id="edad_anios" 
                                               value="{{ $consulta->años }}"
                                               class="mt-1 p-1 w-full border rounded-md text-xs"
                                               disabled>
                                    </div>
                                    <div>
                                        <label for="edad_meses"
                                               class="block text-xs font-medium text-gray-700">
                                            Meses
                                        </label>
                                        <input type="text" 
                                               id="edad_meses" 
                                               value="{{ $consulta->meses }}"
                                               class="mt-1 p-1 w-full border rounded-md text-xs"
                                               disabled>
                                    </div>
                                    <div>
                                        <label for="edad_dias"
                                               class="block text-xs font-medium text-gray-700">
                                            Días
                                        </label>
                                        <input type="text" 
                                               id="edad_dias" 
                                               value="{{ $consulta->dias }}"
                                               class="mt-1 p-1 w-full border rounded-md text-xs"
                                               disabled>
                                    </div>
                                </div>
                            </div>

                            <!-- Signos Vitales -->
                            <div class="w-3/4 bg-gray-100 p-4 rounded-lg">
                                <h3 class="text-lg font-medium mb-4">Signos Vitales</h3>
                                <div class="grid grid-cols-7 gap-2">
                                    <div>
                                        <label for="modalTemperatura"
                                               class="block text-xs font-medium text-gray-700">
                                            Temperatura
                                        </label>
                                        <input type="text" 
                                               id="modalTemperatura" 
                                               value="{{ $consulta->temperatura }}"
                                               class="mt-1 p-1 w-full border rounded-md text-xs"
                                               disabled>
                                    </div>
                                    <div>
                                        <label for="modalFrecuenciaCardiaca"
                                               class="block text-xs font-medium text-gray-700">
                                            Frecuencia Cardíaca
                                        </label>
                                        <input type="text" 
                                               id="modalFrecuenciaCardiaca" 
                                               value="{{ $consulta->frecuencia_cardiaca }}"
                                               class="mt-1 p-1 w-full border rounded-md text-xs"
                                               disabled>
                                    </div>
                                    <div>
                                        <label for="modalSaturacionOxigeno"
                                               class="block text-xs font-medium text-gray-700">
                                            Saturación de Oxígeno
                                        </label>
                                        <input type="text" 
                                               id="modalSaturacionOxigeno" 
                                               value="{{ $consulta->saturacion_oxigeno }}"
                                               class="mt-1 p-1 w-full border rounded-md text-xs"
                                               disabled>
                                    </div>
                                    <div>
                                        <label for="modalTensionArterial"
                                               class="block text-xs font-medium text-gray-700">
                                            Tensión Arterial
                                        </label>
                                        <input type="text" 
                                               id="modalTensionArterial" 
                                               value="{{ $consulta->tension_arterial }}"
                                               class="mt-1 p-1 w-full border rounded-md text-xs"
                                               disabled>
                                    </div>
                                    <div>
                                        <label for="modalCircunferenciaCabeza"
                                               class="block text-xs font-medium text-gray-700">
                                            Perimetro Cefalico
                                        </label>
                                        <input type="text" 
                                               id="modalCircunferenciaCabeza" 
                                               value="{{ $consulta->circunferencia_cabeza }}"
                                               class="mt-1 p-1 w-full border rounded-md text-xs"
                                               disabled>
                                    </div>
                                    <div>
                                        <label for="modalTalla"
                                               class="block text-xs font-medium text-gray-700">
                                            Talla
                                        </label>
                                        <input type="text" 
                                               id="modalTalla" 
                                               value="{{ $consulta->talla }}"
                                               class="mt-1 p-1 w-full border rounded-md text-xs"
                                               disabled>
                                    </div>
                                    <div>
                                        <label for="modalPeso"
                                               class="block text-xs font-medium text-gray-700">
                                            Peso
                                        </label>
                                        <input type="text" 
                                               id="modalPeso" 
                                               value="{{ $consulta->peso }}"
                                               class="mt-1 p-1 w-full border rounded-md text-xs"
                                               disabled>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Motivo de la Consulta, Diagnóstico y Antecedentes -->
                        <div class="mb-6 grid md:grid-cols-3 gap-4">
                            <!-- Antecedentes -->
                            <div class="bg-gray-100 p-4 rounded-lg">
                                <h3 class="text-lg font-medium mb-4">Antecedentes</h3>
                                <div id="antecedentes"
                                     class="mt-1 p-2 w-full border rounded-md resize-none"
                                     style="height: 300px; pointer-events: none; background-color: #fff;">
                                    {!! $paciente->antecedentes !!}
                                </div>
                            </div>
                        
                            <!-- Motivo de la Consulta -->
                            <div class="bg-gray-100 p-4 rounded-lg">
                                <h3 class="text-lg font-medium mb-4">Motivo de la Consulta</h3>
                                <div id="modalMotivoConsulta"
                                     class="mt-1 p-2 w-full border rounded-md resize-none"
                                     style="height: 300px; pointer-events: none; background-color: #fff;">
                                    {!! $consulta->motivoConsulta !!}
                                </div>
                            </div>
                        
                            <!-- Diagnóstico -->
                            <div class="bg-gray-100 p-4 rounded-lg">
                                <h3 class="text-lg font-medium mb-4">Diagnóstico</h3>
                                <div id="modalDiagnostico"
                                     class="mt-1 p-2 w-full border rounded-md resize-none"
                                     style="height: 300px; pointer-events: none; background-color: #fff;">
                                    {!! $consulta->diagnostico !!}
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Tab de Recetas -->
                <div id="recetasTab" class="tab-pane hidden">
                    <div class="mb-6">
                        <div class="bg-gray-100 p-4 rounded-lg flex justify-between items-center">
                            <h3 class="text-lg font-medium mb-2">Recetas</h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border rounded-lg table-auto">
                                <thead>
                                    <tr class="bg-[#2D7498] text-white uppercase text-sm leading-normal">
                                        <th class="py-3 px-6 text-left">No. Receta</th>
                                        <th class="py-3 px-6 text-left">Tipo de Receta</th>
                                        <th class="py-3 px-6 text-left">Receta</th>
                                    </tr>
                                </thead>
                                <tbody id="modalRecetas">
                                    @foreach($consulta->recetas as $index => $receta)
                                        <tr>
                                            <td class="py-3 px-6 text-left">{{ $index + 1 }}</td>
                                            <td class="py-3 px-6 text-left">
                                                {{ $receta->tipo_receta_nombre ?? 'No especificado' }}
                                            </td>
                                            <td class="py-3 px-6 text-left">
                                                {!! $receta->receta !!}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>                            
                            </table>
                        </div>
                    </div>
                </div> 
                
            </div>
        </div>
    </div>

    <!-- Inclusión de jQuery y JS adicional -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function () {
            // Botones para navegar entre consultas
            $('#firstConsultation').on('click', function () {
                navigateConsultation('first');
            });

            $('#prevConsultation').on('click', function () {
                navigateConsultation('prev');
            });

            $('#nextConsultation').on('click', function () {
                navigateConsultation('next');
            });

            $('#lastConsultation').on('click', function () {
                navigateConsultation('last');
            });

            // Función AJAX para navegar
            function navigateConsultation(direction) {
                var currentConsultationId = {{ $consulta->id }};  // ID de la consulta actual
                var pacienteId = {{ $paciente->no_exp }};         // ID del paciente

                $.ajax({
                    url: "{{ route('consultas.navigate') }}",  // Ruta que manejará la navegación
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',  // Token CSRF
                        direction: direction,
                        currentConsultationId: currentConsultationId,
                        pacienteId: pacienteId
                    },
                    success: function (response) {
                        if (response.success) {
                            // Redirige a la nueva consulta
                            window.location.href = response.redirectUrl;
                        } else {
                            alert(response.message || 'No hay más consultas en esta dirección.');
                        }
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                    }
                });
            }
        });

        // Manejar la apertura de tabs
        window.openTab = function(event, tabName) {
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

        // Abre la pestaña "Consulta" por defecto
        document.addEventListener("DOMContentLoaded", function() {
            openTab({currentTarget: document.querySelector(`[href="#consultaTab"]`)}, 'consultaTab');
        });

        // Si tienes modales para ver recetas detalladas:
        $('.ver-receta').on('click', function(event) {
            event.preventDefault();
            var index = $(this).data('receta-index');
            var receta = {!! json_encode($consulta->recetas->pluck('receta')) !!}[index];
            $('#recetaModalTitle').text('Receta');
            $('#recetaModalContent').html('<div class="bg-gray-100 p-4 rounded-lg">' + receta + '</div>');
            $('#recetaModal').removeClass('hidden');
        });

        $('#closeRecetaModal').on('click', function() {
            $('#recetaModal').addClass('hidden');
        });

        // Si quieres refrescar las recetas por AJAX:
        $(document).ready(function () {
            function obtenerDetallesConsulta() {
                var consultaId = {{ $consulta->id }};
                var pacienteId = {{ $paciente->no_exp }};
                var medicoId   = {{ Auth::id() }};

                $.ajax({
                    url: "{{ route('consultas.getConsultaDetails', [
                        'id'         => $consulta->id,
                        'pacienteId' => $paciente->no_exp,
                        'medicoId'   => Auth::id()
                    ]) }}",
                    type: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        if (response.recetas && response.recetas.length > 0) {
                            $('#modalRecetas').empty();
                            $.each(response.recetas, function (index, receta) {
                                $('#modalRecetas').append(`
                                    <tr>
                                        <td class="py-3 px-6 text-left">${index + 1}</td>
                                        <td class="py-3 px-6 text-left">${receta.tipo_receta_nombre}</td>
                                        <td class="py-3 px-6 text-left">${receta.receta}</td>
                                    </tr>
                                `);
                            });
                        } else {
                            $('#modalRecetas').html('<tr><td colspan="3" class="text-center">No hay recetas registradas.</td></tr>');
                        }
                    },
                    error: function (xhr) {
                        console.error("Error al obtener los detalles de la consulta:", xhr.responseText);
                    }
                });
            }

            // Llamamos a la función cuando se cargue la página
            obtenerDetallesConsulta();
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

    <!-- Estilos para que los inputs disabled se vean en blanco y texto en negro -->
    <style>
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

        /* Para los inputs/textarea disabled, forzamos el fondo blanco y texto negro */
        input[disabled], textarea[disabled] {
            opacity: 1 !important;
            color: #000 !important;
            background-color: #fff !important;
            cursor: not-allowed;
        }

        .tab-link {
            color: black;
            text-decoration: none;
            padding: 10px 20px;
            display: inline-block;
            font-weight: normal;
            border-bottom: 2px solid transparent;
            cursor: pointer;
            font-size: 16px;
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
    </style>
</x-app-layout>
