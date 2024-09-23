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
                                                    {{ substr($cita->paciente->nombres, 0, 1) }}{{ substr($cita->paciente->apepat, 0, 1) }}
                                                </div>
                                                <!-- Nombre de la persona -->
                                                <h2 class="text-3xl font-bold text-left ml-4" style="color: black;">
                                                    {{ $cita->paciente->nombres }} {{ $cita->paciente->apepat }} {{ $cita->paciente->apemat }}
                                                </h2>
                                            </div>

                                            <form id="update-cita-form" method="POST" action="{{ route('citas.update', $cita->id) }}">
                                                @csrf
                                                @method('PATCH')
                                                
                                                <div class="form-group flex">
                                                    <div class="mr-2 w-1/2">
                                                        <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha</label>
                                                        <input type="date" name="fecha" id="fecha" class="mt-1 block w-full px-3 py-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="{{ $fecha }}" min="{{ now()->toDateString() }}" required>
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
                                                

                                                <input type="hidden" name="paciente_no_exp" value="{{ $cita->no_exp }}">

                                                <div class="form-group">
                                                    <label for="usuariomedico" class="block text-sm font-medium text-gray-700">Doctor</label>
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
        const today = new Date().toISOString().split('T')[0];
        fechaInput.setAttribute('min', today); // Establecer la fecha mínima a hoy

        // Función para cargar las horas disponibles
        function fetchHorasDisponibles() {
            const fecha = fechaInput.value;
            if (!fecha) return;

            // Obtener los horarios disponibles para la fecha seleccionada
            fetch(`/obtener-horarios-por-dia?fecha=${encodeURIComponent(fecha)}`)
                .then(response => response.json())
                .then(data => {
                    horaSelect.innerHTML = ''; // Limpiar el select

                    if (data.mensaje) {
                        Swal.fire({
                            icon: 'info',
                            title: 'Sin horarios',
                            text: data.mensaje,
                            confirmButtonColor: '#007BFF',
                        });
                    } else {
                        // Obtener las horas ocupadas para la fecha seleccionada
                        fetch(`/obtener-horas-ocupadas?fecha=${encodeURIComponent(fecha)}`)
                            .then(response => response.json())
                            .then(ocupadas => {
                                // Revisar las horas disponibles y deshabilitar las ocupadas
                                data.forEach(horario => {
                                    if (horario.turno) {
                                        const option = document.createElement('option');
                                        option.disabled = true;
                                        option.textContent = horario.turno;
                                        option.style.fontWeight = 'bold';
                                        horaSelect.appendChild(option);
                                    } else if (horario.inicio) {
                                        const option = document.createElement('option');
                                        option.value = horario.inicio;
                                        option.textContent = horario.inicio;

                                        // Deshabilitar la hora si está ocupada
                                        if (ocupadas.includes(horario.inicio)) {
                                            option.disabled = true;
                                            option.textContent += " (Ocupada)";
                                        }

                                        horaSelect.appendChild(option);
                                    }
                                });
                            })
                            .catch(() => {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Hubo un problema al cargar las horas ocupadas.',
                                    confirmButtonColor: '#007BFF',
                                });
                            });
                    }
                })
                .catch(() => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Hubo un problema al cargar los horarios disponibles.',
                        confirmButtonColor: '#007BFF',
                    });
                });
        }

        // Cargar las horas disponibles inmediatamente al cargar la página
        fetchHorasDisponibles();

        // Agregar el evento para cargar las horas cuando cambia la fecha
        fechaInput.addEventListener('change', fetchHorasDisponibles);
    });
    </script>
    <style>
        select#hora {
            max-height: 200px; /* Ajusta la altura máxima de la lista desplegable */
            overflow-y: auto;  /* Permite que aparezca el scroll si es necesario */
            scroll-behavior: smooth; /* Suaviza el desplazamiento */
            padding-right: 20px; /* Agrega espacio adicional para que no corte la lista con el scroll */
        }
    </style>
</x-app-layout>
