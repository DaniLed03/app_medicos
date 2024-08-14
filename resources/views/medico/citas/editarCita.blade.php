<x-app-layout>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto bg-white dark:bg-neutral-700">
                        <div class="lg:flex lg:h-full lg:flex-col">
                            <div class="lg:flex lg:flex-auto lg:flex-row">
                                <!-- Formulario Editar Cita -->
                                <div class="lg:flex lg:flex-auto lg:flex-col lg:w-full">
                                    <div class="bg-white shadow overflow-hidden rounded-lg h-full">
                                        <div class="flex items-center justify-between px-4 py-2 font-bold text-white" style="background-color: #2D7498;">
                                            Cita
                                        </div>
                                        <div class="p-4">
                                            <!-- Datos de la Persona -->
                                            <div class="flex items-center mb-6">
                                                <!-- Icono con iniciales -->
                                                <div class="flex items-center justify-center h-12 w-12 rounded-full bg-white text-xl font-bold border-2" style="border-color: #2D7498; color: #33AD9B;">
                                                    {{ substr($cita->persona->nombres, 0, 1) }}{{ substr($cita->persona->apepat, 0, 1) }}
                                                </div>
                                                <!-- Nombre de la persona -->
                                                <h2 class="text-3xl font-bold text-left ml-4" style="color: black;">
                                                    {{ $cita->persona->nombres }} {{ $cita->persona->apepat }} {{ $cita->persona->apemat }}
                                                </h2>
                                            </div>

                                            <form id="update-cita-form" method="POST" action="{{ route('citas.update', $cita->id) }}">
                                                @csrf
                                                @method('PATCH')
                                                
                                                <div class="form-group flex">
                                                    <div class="mr-2 w-1/2">
                                                        <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha</label>
                                                        <input type="date" name="fecha" id="fecha" class="mt-1 block w-full px-3 py-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="{{ $fecha }}" max="{{ $fecha }}" required>
                                                    </div>
                                                    <div class="ml-2 w-1/2">
                                                        <label for="hora" class="block text-sm font-medium text-gray-700">Hora</label>
                                                        <select name="hora" id="hora" class="mt-1 block w-full px-3 py-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                                            @foreach ($horasDisponibles as $horaDisponible)
                                                                <option value="{{ $horaDisponible }}" {{ $horaDisponible == $hora ? 'selected' : '' }}>{{ $horaDisponible }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <input type="hidden" name="persona_id" value="{{ $cita->persona_id }}">

                                                <div class="form-group">
                                                    <label for="usuariomedico" class="block text-sm font-medium text-gray-700">Usuario Médico</label>
                                                    <input id="usuariomedico" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-600" type="text" value="{{ $cita->medico->nombres }} {{ $cita->medico->apepat }} {{ $cita->medico->apemat }}" disabled />
                                                    <input type="hidden" name="usuariomedicoid" value="{{ $cita->medicoid }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="motivo_consulta" class="block text-sm font-medium text-gray-700">Motivo de la consulta</label>
                                                    <textarea name="motivo_consulta" id="motivo_consulta" rows="6" class="mt-1 block w-full px-3 py-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" style="resize: none;">{{ $cita->motivo_consulta }}</textarea>
                                                </div>
                                                                                                <div class="flex justify-end space-x-2 mb-4">
                                                    <button type="button" class="bg-blue-500 text-white p-2 rounded-md" onclick="confirmUpdate()">Actualizar Cita</button>
                                                    <button type="button" class="bg-red-500 text-white p-2 rounded-md" onclick="confirmDelete()">Borrar Cita</button>
                                                    <a href="{{ route('citas') }}" class="bg-gray-500 text-white p-2 rounded-md">Regresar a la agenda</a>
                                                </div>                                             
                                            </form>
                                            <form id="delete-cita-form" action="{{ route('citas.borrar', $cita->id) }}" method="POST" style="display:none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('error'))
                Swal.fire({
                    title: "Error",
                    text: "{{ session('error') }}",
                    icon: "error",
                    confirmButtonColor: "#3085d6",
                });
            @endif
        });

        function confirmUpdate() {
            Swal.fire({
                title: "¿Estás seguro?",
                text: "¡Deseas actualizar esta cita!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sí, ¡actualízala!"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Asegúrate de que este ID corresponde al formulario de actualización
                    document.getElementById('update-cita-form').submit();
                }
            });
        }

        function confirmDelete() {
            Swal.fire({
                title: "¿Estás seguro?",
                text: "¡No podrás revertir esto!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sí, ¡bórralo!"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-cita-form').submit();
                    Swal.fire({
                        title: "¡Borrado!",
                        text: "La cita ha sido borrada.",
                        icon: "success"
                    });
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const fechaInput = document.getElementById('fecha');
            const horaSelect = document.getElementById('hora');
            const usuarioMedicoInput = document.getElementById('usuariomedicoid');

            function fetchHorasDisponibles() {
                const fecha = fechaInput.value;
                const medicoid = usuarioMedicoInput.value;

                if (!fecha || !medicoid) return;

                fetch(`/horas-disponibles?fecha=${fecha}&medicoid=${medicoid}`)
                    .then(response => response.json())
                    .then(data => {
                        // Limpia las opciones actuales del select de horas
                        while (horaSelect.options.length > 0) {
                            horaSelect.remove(0);
                        }

                        // Genera las opciones de horas disponibles
                        data.forEach(hour => {
                            const option = document.createElement('option');
                            option.value = hour;
                            option.textContent = hour;
                            horaSelect.appendChild(option);
                        });

                        // Establece la hora seleccionada previamente si está disponible
                        if (data.includes('{{ $cita->hora }}')) {
                            horaSelect.value = '{{ $cita->hora }}';
                        } else if(horaSelect.options.length > 0){
                            horaSelect.value = horaSelect.options[0].value;
                        }
                    });
            }

            fechaInput.addEventListener('change', fetchHorasDisponibles);
            usuarioMedicoInput.addEventListener('change', fetchHorasDisponibles);

            // Inicializa las opciones al cargar la página
            fetchHorasDisponibles();

            // Establece la fecha mínima a hoy
            fechaInput.min = new Date().toISOString().split("T")[0];
        });

    </script>
</x-app-layout>
