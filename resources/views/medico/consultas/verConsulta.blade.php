<x-app-layout>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div id="consultaModal" class="flex flex-col items-center">
                        <div class="bg-white rounded-lg shadow-lg p-6 w-full">
                            <div class="flex justify-between items-center mb-6 border-b-2 pb-4">
                                <div class="flex items-center">
                                    <div id="modalPacienteInitials" class="flex items-center justify-center h-12 w-12 rounded-full bg-white text-xl font-bold border-2" style="border-color: #2D7498; color: #33AD9B;"></div>
                                    <h2 id="modalPacienteName" class="text-3xl font-bold text-left ml-4" style="color: black;"></h2>
                                </div>
                                <p id="modalPacienteAge" class="text-lg font-medium"></p>
                            </div>
                            <form>
                                <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="bg-gray-100 p-4 rounded-lg">
                                        <h3 class="text-lg font-medium mb-4">Signos Vitales</h3>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label for="modalTalla" class="block text-sm font-medium text-gray-700">Talla</label>
                                                <input type="text" id="modalTalla" class="mt-1 p-2 w-full border rounded-md" disabled>
                                            </div>
                                            <div>
                                                <label for="modalTemperatura" class="block text-sm font-medium text-gray-700">Temperatura</label>
                                                <input type="text" id="modalTemperatura" class="mt-1 p-2 w-full border rounded-md" disabled>
                                            </div>
                                            <div>
                                                <label for="modalSaturacionOxigeno" class="block text-sm font-medium text-gray-700">Saturación de Oxígeno</label>
                                                <input type="text" id="modalSaturacionOxigeno" class="mt-1 p-2 w-full border rounded-md" disabled>
                                            </div>
                                            <div>
                                                <label for="modalFrecuenciaCardiaca" class="block text-sm font-medium text-gray-700">Frecuencia Cardíaca</label>
                                                <input type="text" id="modalFrecuenciaCardiaca" class="mt-1 p-2 w-full border rounded-md" disabled>
                                            </div>
                                            <div>
                                                <label for="modalPeso" class="block text-sm font-medium text-gray-700">Peso</label>
                                                <input type="text" id="modalPeso" class="mt-1 p-2 w-full border rounded-md" disabled>
                                            </div>
                                            <div>
                                                <label for="modalTensionArterial" class="block text-sm font-medium text-gray-700">Tensión Arterial</label>
                                                <input type="text" id="modalTensionArterial" class="mt-1 p-2 w-full border rounded-md" disabled>
                                            </div>
                                            <div>
                                                <label for="modalCircunferenciaCabeza" class="block text-sm font-medium text-gray-700">Circunferencia de Cabeza</label>
                                                <input type="text" id="modalCircunferenciaCabeza" class="mt-1 p-2 w-full border rounded-md" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-gray-100 p-4 rounded-lg">
                                        <label for="modalMotivoConsulta" class="block text-sm font-medium text-gray-700">Motivo de la Consulta</label>
                                        <textarea id="modalMotivoConsulta" class="mt-1 p-2 w-full border rounded-md resize-none" style="height: 230px;" disabled></textarea>
                                    </div>
                                    <div class="bg-gray-100 p-4 rounded-lg">
                                        <label for="modalDiagnostico" class="block text-sm font-medium text-gray-700">Diagnóstico</label>
                                        <textarea id="modalDiagnostico" class="mt-1 p-2 w-full border rounded-md resize-none" style="height: 230px;" disabled></textarea>
                                    </div>
                                </div>
                                <div class="mb-6">
                                    <div class="bg-gray-100 p-4 rounded-lg flex justify-between items-center">
                                        <h3 class="text-lg font-medium mb-2">Recetas</h3>
                                    </div>
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full bg-white border rounded-lg">
                                            <thead>
                                                <tr class="bg-[#2D7498] text-white uppercase text-sm leading-normal">
                                                    <th class="py-3 px-6 text-left">No.Receta</th>
                                                    <th class="py-3 px-6 text-left">Tipo de Receta</th>
                                                    <th class="py-3 px-6 text-left">Receta</th>
                                                </tr>
                                            </thead>
                                            <tbody id="modalRecetas">
                                                <!-- Recetas will be appended here by JS -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="mb-6">
                                    <div class="bg-gray-100 p-4 rounded-lg">
                                        <label for="modalTotalPagar" class="block text-sm font-medium text-gray-700">Total a Pagar</label>
                                        <input type="number" id="modalTotalPagar" class="mt-1 p-2 w-full border rounded-md" disabled>
                                    </div>
                                </div>
                                <div class="flex justify-end">
                                    <button id="closeModal" class="bg-gray-500 text-white px-4 py-2 rounded-md mr-2">Cerrar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ensure jQuery is included -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            const consultaModal = $('#consultaModal');
            const closeModalButton = $('#closeModal');

            // Get the consultation data from the URL
            const consultaData = @json($consulta);
            
            // Populate modal with consultation data
            $('#modalPacienteInitials').text(consultaData.cita.paciente.nombres.charAt(0) + consultaData.cita.paciente.apepat.charAt(0));
            $('#modalPacienteName').text(`${consultaData.cita.paciente.nombres} ${consultaData.cita.paciente.apepat} ${consultaData.cita.paciente.apemat}`);
            $('#modalPacienteAge').text(`Edad: ${calculateAge(consultaData.cita.paciente.fechanac)}`);
            $('#modalTalla').val(consultaData.talla);
            $('#modalTemperatura').val(consultaData.temperatura);
            $('#modalSaturacionOxigeno').val(consultaData.saturacion_oxigeno);
            $('#modalFrecuenciaCardiaca').val(consultaData.frecuencia_cardiaca);
            $('#modalPeso').val(consultaData.peso);
            $('#modalTensionArterial').val(consultaData.tension_arterial);
            $('#modalCircunferenciaCabeza').val(consultaData.circunferencia_cabeza);
            $('#modalMotivoConsulta').val(consultaData.motivoConsulta);
            $('#modalDiagnostico').val(consultaData.diagnostico);
            $('#modalTotalPagar').val(consultaData.totalPagar);

            // Populate recetas
            const recetasTbody = $('#modalRecetas');
            recetasTbody.html('');
            consultaData.recetas.forEach((receta, index) => {
                recetasTbody.append(`
                    <tr>
                        <td class="py-3 px-6 text-left whitespace-nowrap">${index + 1}</td>
                        <td class="py-3 px-6 text-left">${receta.tipo_de_receta}</td>
                        <td class="py-3 px-6 text-left">${receta.receta}</td>
                    </tr>
                `);
            });

            closeModalButton.on('click', function() {
                window.location.href = "{{ route('pacientes.show', $consulta->cita->paciente->id) }}";
            });

            function calculateAge(fecha_nacimiento) {
                const birthDate = new Date(fecha_nacimiento);
                const today = new Date();
                let age = today.getFullYear() - birthDate.getFullYear();
                const monthDifference = today.getMonth() - birthDate.getMonth();
                if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }
                return `${age} años, ${Math.abs(monthDifference)} meses, ${Math.abs(today.getDate() - birthDate.getDate())} días`;
            }
        });
    </script>    
</x-app-layout>
