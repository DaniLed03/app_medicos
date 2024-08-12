<x-app-layout>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-center items-center mb-4 space-x-2">
                        <!-- Botones de Navegación -->
                        <button id="firstConsultation" class="bg-gray-300 text-black px-4 py-2 rounded-md">
                            <!-- Icono SVG -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-double-left" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M8.354 1.646a.5.5 0 0 1 0 .708L2.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0"/>
                                <path fill-rule="evenodd" d="M12.354 1.646a.5.5 0 0 1 0 .708L6.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0"/>
                            </svg>
                        </button>
                        <button id="prevConsultation" class="bg-gray-300 text-black px-4 py-2 rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-compact-left" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M9.224 1.553a.5.5 0 0 1 .223.67L6.56 8l2.888 5.776a.5.5 0 1 1-.894.448l-3-6a.5.5 0 0 1 0-.448l3-6a.5.5 0 0 1 .67-.223"/>
                            </svg>
                        </button>
                        <h3 id="consultationDate" class="text-xl font-medium">Fecha de Consulta: {{ $fechaConsulta }}</h3>
                        <button id="nextConsultation" class="bg-gray-300 text-black px-4 py-2 rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-compact-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M6.776 1.553a.5.5 0 0 1 .671.223l3 6a.5.5 0 0 1 0 .448l-3 6a.5.5 0 1 1-.894-.448L9.44 8 6.553 2.224a.5.5 0 0 1 .223-.671"/>
                            </svg>
                        </button>
                        <button id="lastConsultation" class="bg-gray-300 text-black px-4 py-2 rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-double-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M3.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L9.293 8 3.646 2.354a.5.5 0 0 1 0-.708"/>
                                <path fill-rule="evenodd" d="M7.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L13.293 8 7.646 2.354a.5.5 0 0 1 0-.708"/>
                            </svg>
                        </button>
                    </div>

                    <!-- Modal de Consulta -->
                    <div id="consultaModal" class="flex flex-col items-center">
                        <div class="bg-white rounded-lg shadow-lg p-6 w-full">
                            <div class="flex justify-between items-center mb-6 border-b-2 pb-4">
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
                            <form>
                                <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
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
                                    <div class="bg-gray-100 p-4 rounded-lg">
                                        <label for="modalMotivoConsulta" class="block text-sm font-medium text-gray-700">Motivo de la Consulta</label>
                                        <div id="modalMotivoConsulta" class="mt-1 p-2 w-full border rounded-md resize-none" style="height: 230px;">
                                            {!! $consulta->motivoConsulta !!}
                                        </div>
                                    </div>
                                    <div class="bg-gray-100 p-4 rounded-lg">
                                        <label for="modalDiagnostico" class="block text-sm font-medium text-gray-700">Diagnóstico</label>
                                        <div id="modalDiagnostico" class="mt-1 p-2 w-full border rounded-md resize-none" style="height: 230px;">
                                            {!! $consulta->diagnostico !!}
                                        </div>
                                    </div>
                                </div>
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
                                <div class="mb-6">
                                    <div class="bg-gray-100 p-4 rounded-lg">
                                        <label for="modalTotalPagar" class="block text-sm font-medium text-gray-700">Total a Pagar</label>
                                        <input type="number" id="modalTotalPagar" value="{{ $consulta->totalPagar }}" class="mt-1 p-2 w-full border rounded-md" disabled>
                                    </div>
                                </div>
                                <a href="{{ route('medico.pacientes.editarPaciente', ['id' => $paciente->id, 'tab' => 'historial']) }}" class="bg-gray-500 text-white px-4 py-2 rounded-md mr-2">
                                    Cerrar
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

    <!-- Ensure jQuery is included -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
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

            $('#closeRecetaModal').on('click', function() {
                $('#recetaModal').addClass('hidden');
            });

            const consultaDate = new Date(consultaData.fechaHora);
            $('#consultationDate').text(`Fecha de Consulta: ${consultaDate.toLocaleDateString()}`);

        });
    </script>    
    <style>
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
    </style>
</x-app-layout>
