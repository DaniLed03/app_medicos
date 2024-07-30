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
                                                        <input type="date" name="fecha" id="fecha" min="{{ now()->toDateString() }}" class="mt-1 block w-full px-3 py-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="{{ $cita->fecha }}" required>
                                                    </div>
                                                    <div class="ml-2 w-1/2">
                                                        <label for="hora" class="block text-sm font-medium text-gray-700">Hora</label>
                                                        <select name="hora" id="hora" class="mt-1 block w-full px-3 py-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                                            @for ($i = 10; $i <= 23; $i++)
                                                                @php
                                                                    $hour = $i < 10 ? '0' . $i . ':00' : $i . ':00';
                                                                @endphp
                                                                <option value="{{ $hour }}" {{ $cita->hora == $hour ? 'selected' : '' }}>{{ $hour }}</option>
                                                            @endfor
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
                                                <div class="flex justify-end">
                                                    <button type="button" class="bg-blue-500 text-white p-2 rounded-md mr-2" onclick="confirmUpdate()">Actualizar Cita</button>
                                                    <button type="button" class="bg-red-500 text-white p-2 rounded-md" onclick="confirmDelete()">Borrar Cita</button>
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
                    Swal.fire({
                        title: "¡Cita Actualizada!",
                        text: "La cita ha sido actualizada.",
                        icon: "success"
                    });
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
                        const horaOptions = horaSelect.options;
                        while (horaOptions.length > 0) {
                            horaOptions.remove(0);
                        }

                        for (let i = 10; i <= 23; i++) {
                            const hour = i < 10 ? `0${i}:00` : `${i}:00`;
                            if (!data.includes(hour)) {
                                const option = document.createElement('option');
                                option.value = hour;
                                option.textContent = hour;
                                horaSelect.appendChild(option);
                            }
                        }

                        horaSelect.value = '{{ $cita->hora }}';
                    });
            }

            fechaInput.addEventListener('change', fetchHorasDisponibles);
            usuarioMedicoInput.addEventListener('change', fetchHorasDisponibles);

            // Initialize options
            fetchHorasDisponibles();

            // Set the min date to today
            fechaInput.min = new Date().toISOString().split("T")[0];
        });
    </script>
</x-app-layout>
