<x-app-layout>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-xl font-bold text-gray-900 uppercase">Configuracion de Horario</h1>
                        <button type="submit" form="horarioForm" class="bg-blue-500 text-white px-4 py-2 rounded-md">Guardar Horario</button>
                    </div>
                
                    <form id="horarioForm" method="POST" action="{{ route('horarios.store') }}">
                        @csrf
                
                        <div class="grid grid-cols-1 md:grid-cols-6 gap-6 mb-6">
                            <!-- Fecha -->
                            <div>
                                <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha (Opcional)</label>
                                <input type="date" name="fecha" id="fecha" class="mt-1 block w-full px-3 py-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                
                            <!-- Día de la Semana -->
                            <div>
                                <label for="dia_semana" class="block text-sm font-medium text-gray-700">Día de la Semana (Opcional)</label>
                                <select name="dia_semana" id="dia_semana" class="mt-1 block w-full px-3 py-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">Seleccionar Día</option>
                                    <option value="Lunes">Lunes</option>
                                    <option value="Martes">Martes</option>
                                    <option value="Miércoles">Miércoles</option>
                                    <option value="Jueves">Jueves</option>
                                    <option value="Viernes">Viernes</option>
                                    <option value="Sábado">Sábado</option>
                                    <option value="Domingo">Domingo</option>
                                </select>
                            </div>
                
                            <!-- Hora Inicio -->
                            <div>
                                <label for="hora_inicio" class="block text-sm font-medium text-gray-700">Hora de Inicio</label>
                                <input type="time" name="hora_inicio" id="hora_inicio" class="mt-1 block w-full px-3 py-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                            </div>
                
                            <!-- Hora Fin -->
                            <div>
                                <label for="hora_fin" class="block text-sm font-medium text-gray-700">Hora de Fin</label>
                                <input type="time" name="hora_fin" id="hora_fin" class="mt-1 block w-full px-3 py-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                            </div>
                
                            <!-- Duración de la Sesión -->
                            <div>
                                <label for="duracion_sesion" class="block text-sm font-medium text-gray-700">Duración de la Sesión (minutos)</label>
                                <input type="number" name="duracion_sesion" id="duracion_sesion" class="mt-1 block w-full px-3 py-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                            </div>
                
                            <!-- Disponibilidad -->
                            <div>
                                <label for="disponible" class="block text-sm font-medium text-gray-700">¿Disponible?</label>
                                <select name="disponible" id="disponible" class="mt-1 block w-full px-3 py-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="1">Sí</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                    </form>
                
                    <div class="mt-8">
                        <h1 class="text-lg font-semibold mb-4">Horarios Configurados para Días de la Semana</h1>
                        <div class="overflow-x-auto bg-white dark:bg-neutral-700">
                            <table id="horariosSemanaTable" class="display nowrap w-full" style="width:100%">
                                <thead class="bg-table-header-color text-white">
                                    <tr>
                                        <th>Día</th>
                                        <th>Horario</th>
                                        <th>Duración</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($horariosSemana as $horario)
                                        <tr>
                                            <td>{{ $horario->dia_semana }}</td>
                                            <td>{{ \Carbon\Carbon::parse($horario->hora_inicio)->format('h:i A') }} - {{ \Carbon\Carbon::parse($horario->hora_fin)->format('h:i A') }}</td>
                                            <td>{{ $horario->duracion_sesion }} minutos</td>
                                            <td>
                                                <button class="text-blue-500 hover:text-blue-700" 
                                                        onclick="openEditModal('{{ $horario->id }}', '{{ $horario->dia_semana }}', '{{ $horario->hora_inicio }}', '{{ $horario->hora_fin }}', '{{ $horario->duracion_sesion }}', '{{ $horario->disponible }}')">
                                                    Editar
                                                </button>
                                                <button class="text-red-500 hover:text-red-700">Eliminar</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>                                
                            </table>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h1 class="text-lg font-semibold mb-4">Horarios Configurados para Fechas Particulares</h1>
                        <div class="overflow-x-auto bg-white dark:bg-neutral-700">
                            <table id="horariosFechasTable" class="display nowrap w-full" style="width:100%">
                                <thead class="bg-table-header-color text-white">
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Horario</th>
                                        <th>Duración</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($horariosFechas as $horario)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($horario->fecha)->format('j F, Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($horario->hora_inicio)->format('h:i A') }} - {{ \Carbon\Carbon::parse($horario->hora_fin)->format('h:i A') }}</td>
                                            <td>{{ $horario->duracion_sesion }} minutos</td>
                                            <td>
                                                <button class="text-blue-500 hover:text-blue-700" 
                                                        onclick="openEditModal('{{ $horario->id }}', '', '{{ $horario->hora_inicio }}', '{{ $horario->hora_fin }}', '{{ $horario->duracion_sesion }}', '{{ $horario->disponible }}', '{{ \Carbon\Carbon::parse($horario->fecha)->format('Y-m-d') }}')">
                                                    Editar
                                                </button>
                                                <button class="text-red-500 hover:text-red-700">Eliminar</button>
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

    <!-- Modal para Editar Horario -->
    <div id="editModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-gray-900 bg-opacity-50 fixed inset-0"></div>
            <div class="bg-white p-6 rounded-lg shadow-lg w-96 relative z-20">
                <!-- Icono para cerrar el modal -->
                <button onclick="closeEditModal()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl">
                    &times;
                </button>
                <!-- Título centrado con color personalizado -->
                <h2 class="text-xl font-bold mb-4 text-center" style="color: #2D7498;">Editar Horario</h2>
                <!-- Línea de separación -->
                <hr class="border-gray-300 mb-4">
                <form id="editHorarioForm" method="POST" action="">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="id" id="editId">
                    
                    <!-- Fecha (Opcional) -->
                    <div class="mb-4" id="fechaField">
                        <label for="editFecha" class="block text-sm font-medium text-gray-700">Fecha</label>
                        <input type="date" name="fecha" id="editFecha" class="mt-1 block w-full px-3 py-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <!-- Día de la Semana (Opcional) -->
                    <div class="mb-4" id="diaSemanaField">
                        <label for="editDiaSemana" class="block text-sm font-medium text-gray-700">Día de la Semana</label>
                        <select name="dia_semana" id="editDiaSemana" class="mt-1 block w-full px-3 py-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">Seleccionar Día</option>
                            <option value="Lunes">Lunes</option>
                            <option value="Martes">Martes</option>
                            <option value="Miércoles">Miércoles</option>
                            <option value="Jueves">Jueves</option>
                            <option value="Viernes">Viernes</option>
                            <option value="Sábado">Sábado</option>
                            <option value="Domingo">Domingo</option>
                        </select>
                    </div>

                    <!-- Hora Inicio -->
                    <div class="mb-4">
                        <label for="editHoraInicio" class="block text-sm font-medium text-gray-700">Hora de Inicio</label>
                        <input type="time" name="hora_inicio" id="editHoraInicio" class="mt-1 block w-full px-3 py-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                    </div>

                    <!-- Hora Fin -->
                    <div class="mb-4">
                        <label for="editHoraFin" class="block text-sm font-medium text-gray-700">Hora de Fin</label>
                        <input type="time" name="hora_fin" id="editHoraFin" class="mt-1 block w-full px-3 py-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                    </div>

                    <!-- Duración de la Sesión -->
                    <div class="mb-4">
                        <label for="editDuracionSesion" class="block text-sm font-medium text-gray-700">Duración de la Sesión (minutos)</label>
                        <input type="number" name="duracion_sesion" id="editDuracionSesion" class="mt-1 block w-full px-3 py-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                    </div>

                    <!-- Disponibilidad -->
                    <div class="mb-4">
                        <label for="editDisponible" class="block text-sm font-medium text-gray-700">¿Disponible?</label>
                        <select name="disponible" id="editDisponible" class="mt-1 block w-full px-3 py-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            $('#horariosSemanaTable').DataTable({
                "pageLength": 7,
                "lengthChange": false,
                "language": {
                    "decimal": "",
                    "emptyTable": "No hay horarios registrados",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                    "infoEmpty": "Mostrando 0 a 0 de 0 entradas",
                    "infoFiltered": "(filtrado de _MAX_ entradas en total)",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "No se encontraron resultados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
                "scrollX": false,
                "autoWidth": true
            });

            $('#horariosFechasTable').DataTable({
                "pageLength": 5,
                "lengthChange": true,
                "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]],
                "language": {
                    "decimal": "",
                    "emptyTable": "No hay horarios registrados",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                    "infoEmpty": "Mostrando 0 a 0 de 0 entradas",
                    "infoFiltered": "(filtrado de _MAX_ entradas en total)",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "No se encontraron resultados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
                "scrollX": false,
                "autoWidth": true
            });
        });

        function openEditModal(id, dia_semana, hora_inicio, hora_fin, duracion_sesion, disponible, fecha = '') {
            document.getElementById('editId').value = id;
            document.getElementById('editFecha').value = fecha;
            document.getElementById('editDiaSemana').value = dia_semana;
            document.getElementById('editHoraInicio').value = hora_inicio;
            document.getElementById('editHoraFin').value = hora_fin;
            document.getElementById('editDuracionSesion').value = duracion_sesion;
            document.getElementById('editDisponible').value = disponible;

            if (fecha) { // Si hay una fecha, mostrar solo el campo de fecha
                document.getElementById('fechaField').style.display = 'block';
                document.getElementById('diaSemanaField').style.display = 'none';
            } else { // Si no hay fecha, mostrar solo el campo de día de la semana
                document.getElementById('fechaField').style.display = 'none';
                document.getElementById('diaSemanaField').style.display = 'block';
            }

            document.getElementById('editHorarioForm').action = `/horarios/update/${id}`;
            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }
    </script>
</x-app-layout>

<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.js" defer></script>

<style>
    .bg-table-header-color {
        background-color: #2D7498;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #2D7498;
        color: white;
    }

    tr:hover {
        background-color: #f5f5f5;
    }

    /* Ocultar el selector de cantidad de entradas en el primer DataTable */
    #horariosSemanaTable_wrapper .dataTables_length {
        display: none;
    }

    /* Estilos para los botones de acción */
    .text-blue-500 {
        color: #007BFF;
        cursor: pointer;
    }

    .text-blue-500:hover {
        color: #0056b3;
    }

    .text-red-500 {
        color: #DC3545;
        cursor: pointer;
    }

    .text-red-500:hover {
        color: #bd2130;
    }

</style>
