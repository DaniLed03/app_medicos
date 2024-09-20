<x-app-layout>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Botones de Navegación y Fecha de Consulta -->
                    <div class="flex justify-center items-center mb-4 space-x-2">
                        <!-- Botón Primero -->
                        <button id="firstConsultation" class="bg-gray-300 text-black px-4 py-2 rounded-md">
                            <!-- Icono SVG -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-double-left" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M8.354 1.646a.5.5 0 0 1 0 .708L2.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0"/>
                                <path fill-rule="evenodd" d="M12.354 1.646a.5.5 0 0 1 0 .708L6.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0"/>
                            </svg>
                        </button>

                        <!-- Botón Anterior -->
                        <button id="prevConsultation" class="bg-gray-300 text-black px-4 py-2 rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-compact-left" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M9.224 1.553a.5.5 0 0 1 .223.67L6.56 8l2.888 5.776a.5.5 0 1 1-.894.448l-3-6a.5.5 0 0 1 0-.448l3-6a.5.5 0 0 1 .671-.223"/>
                            </svg>
                        </button>

                        <!-- Fecha de Consulta -->
                        <h3 id="consultationDate" class="text-xl font-medium">Fecha de Consulta: {{ $fechaConsulta }}</h3>

                        <!-- Botón Siguiente -->
                        <button id="nextConsultation" class="bg-gray-300 text-black px-4 py-2 rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-compact-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M6.776 1.553a.5.5 0 0 1 .671.223l3 6a.5.5 0 0 1 0 .448l-3 6a.5.5 0 1 1-.894-.448L9.44 8 6.553 2.224a.5.5 0 0 1 .223-.671"/>
                            </svg>
                        </button>

                        <!-- Botón Último -->
                        <button id="lastConsultation" class="bg-gray-300 text-black px-4 py-2 rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-double-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M3.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L9.293 8 3.646 2.354a.5.5 0 0 1 0-.708"/>
                                <path fill-rule="evenodd" d="M7.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L13.293 8 7.646 2.354a.5.5 0 0 1 0-.708"/>
                            </svg>
                        </button>
                    </div>

                    <!-- Detalles del Paciente -->
                    <div class="flex justify-between items-center pb-2">
                        <div class="flex items-center">
                            <div id="modalPacienteInitials" class="flex items-center justify-center h-12 w-12 rounded-full bg-white text-xl font-bold border-2" style="border-color: #2D7498; color: #33AD9B;">
                                {{ strtoupper(substr($paciente->nombres, 0, 1)) }}{{ strtoupper(substr($paciente->apepat, 0, 1)) }}
                            </div>
                            <h2 id="modalPacienteName" class="text-3xl font-bold text-left ml-4" style="color: black;">
                                {{ $paciente->nombres }} {{ $paciente->apepat }} {{ $paciente->apemat }}
                            </h2>
                        </div>
                        <p id="modalPacienteAge" class="text-lg font-medium">
                            Edad: {{ \Carbon\Carbon::parse($paciente->fechanac)->diff(\Carbon\Carbon::now())->format('%y años, %m meses, %d días') }}
                        </p>
                    </div>

                    <!-- Estructura de Tabs, Total a Pagar y Botón Cerrar -->
                    <div class="flex justify-between items-center mb-4">
                        <!-- Estructura de Tabs -->
                        <ul class="flex border-b mb-0" id="tabs">
                            <li class="-mb-px mr-1">
                                <a class="tab-link active-tab" href="#consultaTab" onclick="openTab(event, 'consultaTab')">Consulta</a>
                            </li>
                            <li class="mr-1">
                                <a class="tab-link" href="#recetasTab" onclick="openTab(event, 'recetasTab')">Recetas</a>
                            </li>
                        </ul>

                        <!-- Total a Pagar -->
                        <div class="flex items-center space-x-4">
                            <label for="modalTotalPagar" class="block text-sm font-medium text-gray-700">Precio de la Consulta</label>
                            <input type="number" id="modalTotalPagar" value="{{ $consulta->totalPagar }}" class="mt-1 p-2 w-24 border rounded-md" disabled>
                            
                            <!-- Botón Cerrar -->
                            <a href="{{ route('medico.pacientes.editarPaciente', ['id' => $paciente->no_exp, 'tab' => 'historial']) }}">
                                Cerrar
                            </a>
                            
                        </div>
                    </div>



                    <!-- Contenedor de Contenido de Tabs -->
                    <div id="tab-content-wrapper" style="min-height: 400px; max-height: 600px; overflow-y: auto;">
                        <!-- Tab de Consulta -->
                        <div id="consultaTab" class="tab-pane active">
                            <form>
                                <!-- Signos Vitales, Motivo de Consulta y Diagnóstico -->
                                <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <!-- Signos Vitales -->
                                    <div class="bg-gray-100 p-4 rounded-lg">
                                        <h3 class="text-lg font-medium mb-4">Signos Vitales</h3>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label for="modalTalla" class="block text-sm font-medium text-gray-700">Talla</label>
                                                <input type="text" id="modalTalla" value="{{ $consulta->talla }}" class="mt-1 p-2 w-full border rounded-md" disabled>
                                            </div>
                                            <div>
                                                <label for="modalTemperatura" class="block text-sm font-medium text-gray-700">Temperatura</label>
                                                <input type="text" id="modalTemperatura" value="{{ $consulta->temperatura }}" class="mt-1 p-2 w-full border rounded-md" disabled>
                                            </div>
                                            <div>
                                                <label for="modalSaturacionOxigeno" class="block text-sm font-medium text-gray-700">Saturación de Oxígeno</label>
                                                <input type="text" id="modalSaturacionOxigeno" value="{{ $consulta->saturacion_oxigeno }}" class="mt-1 p-2 w-full border rounded-md" disabled>
                                            </div>
                                            <div>
                                                <label for="modalFrecuenciaCardiaca" class="block text-sm font-medium text-gray-700">Frecuencia Cardíaca</label>
                                                <input type="text" id="modalFrecuenciaCardiaca" value="{{ $consulta->frecuencia_cardiaca }}" class="mt-1 p-2 w-full border rounded-md" disabled>
                                            </div>
                                            <div>
                                                <label for="modalPeso" class="block text-sm font-medium text-gray-700">Peso</label>
                                                <input type="text" id="modalPeso" value="{{ $consulta->peso }}" class="mt-1 p-2 w-full border rounded-md" disabled>
                                            </div>
                                            <div>
                                                <label for="modalTensionArterial" class="block text-sm font-medium text-gray-700">Tensión Arterial</label>
                                                <input type="text" id="modalTensionArterial" value="{{ $consulta->tension_arterial }}" class="mt-1 p-2 w-full border rounded-md" disabled>
                                            </div>
                                            <div>
                                                <label for="modalCircunferenciaCabeza" class="block text-sm font-medium text-gray-700">Circunferencia de Cabeza</label>
                                                <input type="text" id="modalCircunferenciaCabeza" value="{{ $consulta->circunferencia_cabeza }}" class="mt-1 p-2 w-full border rounded-md" disabled>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Motivo de la Consulta -->
                                    <div class="bg-gray-100 p-4 rounded-lg">
                                        <label for="modalMotivoConsulta" class="block text-sm font-medium text-gray-700">Motivo de la Consulta</label>
                                        <div id="modalMotivoConsulta" class="mt-1 p-2 w-full border rounded-md resize-none" style="height: 230px;">
                                            {!! $consulta->motivoConsulta !!}
                                        </div>
                                    </div>

                                    <!-- Diagnóstico -->
                                    <div class="bg-gray-100 p-4 rounded-lg">
                                        <label for="modalDiagnostico" class="block text-sm font-medium text-gray-700">Diagnóstico</label>
                                        <div id="modalDiagnostico" class="mt-1 p-2 w-full border rounded-md resize-none" style="height: 230px;">
                                            {!! $consulta->diagnostico !!}
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Tab de Recetas -->
                        <div id="recetasTab" class="tab-pane hidden">
                            <!-- Tabla de Recetas -->
                            <div class="mb-6">
                                <div class="bg-gray-100 p-4 rounded-lg flex justify-between items-center">
                                    <h3 class="text-lg font-medium mb-2">Recetas</h3>
                                </div>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full bg-white border rounded-lg table-auto">
                                        <thead>
                                            <tr class="bg-[#2D7498] text-white uppercase text-sm leading-normal">
                                                <th class="py-3 px-6 text-left">No.Receta</th>
                                                <th class="py-3 px-6 text-left">Tipo de Receta</th>
                                                <th class="py-3 px-6 text-left">Receta</th>
                                            </tr>
                                        </thead>
                                        <tbody id="modalRecetas">
                                            @foreach($consulta->recetas as $index => $receta)
                                            <tr>
                                                <td class="py-3 px-6 text-left whitespace-nowrap">{{ $index + 1 }}</td>
                                                <td class="py-3 px-6 text-left">{!! $receta->tipo_de_receta !!}</td>
                                                <td class="py-3 px-6 text-left">
                                                    @if(count($consulta->recetas) > 1)
                                                        <button type="button" class="bg-gray-300 text-black px-4 py-2 rounded-md ver-recetas" data-receta-index="{{ $index }}">Ver Receta</button>
                                                    @else
                                                        <button type="button" class="bg-gray-300 text-black px-4 py-2 rounded-md ver-receta" data-receta-index="{{ $index }}">Ver Receta</button>
                                                    @endif
                                                </td>                                                    
                                            </tr>
                                            @endforeach
                                        </tbody>                                            
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal de Receta -->
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
            </div>
        </div>
    </div>

    <!-- Inclusión de jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            // Función para navegar entre consultas
            function navigateConsultation(direction) {
                $.ajax({
                    url: "{{ route('consultations.navigate') }}",
                    type: 'GET',
                    data: {
                        direction: direction,
                        currentConsultationId: {{ $consulta->id }}
                    },
                    success: function(response) {
                        if (response.success) {
                            // Redirigir a la URL de la consulta navegada
                            window.location.href = response.redirectUrl;
                        } else {
                            alert('No se pudo navegar a la consulta.');
                        }
                    },
                    error: function() {
                        alert('Error al navegar a la consulta.');
                    }
                });
            }

            // Event Listeners para los botones de navegación
            $('#firstConsultation').on('click', function() {
                navigateConsultation('first');
            });
            $('#prevConsultation').on('click', function() {
                navigateConsultation('prev');
            });
            $('#nextConsultation').on('click', function() {
                navigateConsultation('next');
            });
            $('#lastConsultation').on('click', function() {
                navigateConsultation('last');
            });

            // Event Listeners para los botones "Ver Receta"
            $('.ver-receta').on('click', function(event) {
                event.preventDefault(); // Prevenir comportamiento predeterminado
                var index = $(this).data('receta-index');
                var receta = {!! json_encode($consulta->recetas->pluck('receta')) !!}[index];
                $('#recetaModalTitle').text('Receta');
                $('#recetaModalContent').html('<div class="bg-gray-100 p-4 rounded-lg">' + receta + '</div>');
                $('#recetaModal').removeClass('hidden');
            });

            $('.ver-recetas').on('click', function(event) {
                event.preventDefault(); // Prevenir comportamiento predeterminado
                var index = $(this).data('receta-index');
                var receta = {!! json_encode($consulta->recetas->pluck('receta')) !!}[index];
                $('#recetaModalTitle').text('Recetas');
                $('#recetaModalContent').html('<div class="bg-gray-100 p-4 rounded-lg">' + receta + '</div>');
                $('#recetaModal').removeClass('hidden');
            });

            // Cerrar el Modal de Receta
            $('#closeRecetaModal').on('click', function() {
                $('#recetaModal').addClass('hidden');
            });

            // Función para manejar la apertura de tabs
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

            // Inicialización del tab por defecto
            document.addEventListener("DOMContentLoaded", function() {
                // El primer tab ya está activo por defecto
            });
        });
    </script>    

    <style>
        /* Estilos para el contenido del modal de receta */
        #recetaModalContent p {
            margin: 1em 0; /* Controla el interlineado cuando se presiona Enter */
        }

        #recetaModalContent br {
            margin: 0; /* No agrega espacio cuando se presiona Shift + Enter */
            line-height: 1.2em; /* Ajusta el interlineado de las líneas */
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

        /* Estilos para los tabs */
        #tabs {
            border-bottom: 1px solid #e2e8f0; /* Mantiene la línea gris */
            margin-top: 0;
            padding-top: 0;
            margin-bottom: 0.5rem; /* Ajusta el espacio inferior */
        }

        /* Estilos para los tabs */
        .tab-link {
            padding: 8px 16px; /* Reduce el padding de los tabs */
        }

        #modalPacienteName {
            margin-left: 10px; /* Reduce el espacio entre las iniciales y el nombre */
        }

        #modalPacienteInitials {
            margin-right: 0; /* Elimina cualquier margen adicional entre las iniciales y el nombre */
        }

        /* Estilos adicionales */
        .tab-link {
            color: black;
            text-decoration: none;
            padding: 10px 20px;
            display: inline-block;
            font-weight: normal;
            border-bottom: 2px solid transparent;
            cursor: pointer;
            font-size: 16px; /* Asegura que el tamaño de la fuente sea el mismo */
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
        /* Estilos adicionales para la presentación */
        /* Asegúrate de que los contenedores no tengan bordes no deseados */
        .nombre-contenedor {
            border-bottom: none; /* Asegura que el borde inferior esté desactivado */
            margin-bottom: 0; /* Ajusta el margen si es necesario */
        }
    </style>
</x-app-layout>
