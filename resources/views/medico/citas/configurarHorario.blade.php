<x-app-layout>
    <!-- Pantalla de carga -->
    <div id="loader" class="loader-container">
        <div class="loader"></div>
    </div>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-xl font-bold text-gray-900 uppercase">Configuracion de Horario</h1>
                        <button type="submit" form="horarioForm" id="guardarHorario" class="bg-blue-500 text-white px-4 py-2 rounded-md">Guardar Horario</button>
                    </div>
                
                    <form id="horarioForm" method="POST" action="{{ route('horarios.store') }}">
                        @csrf
                    
                        <div class="grid grid-cols-1 md:grid-cols-6 gap-6 mb-6">

                            <!-- Día de la Semana -->
                            <div>
                                <label for="dia_semana" class="block text-sm font-medium text-gray-700">Día de la Semana (Opcional)</label>
                                <select name="dia_semana" id="dia_semana" class="mt-1 block w-full px-3 py-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="" disabled selected>Seleccionar Día</option>
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
                    
                            <!-- Turno -->
                            <div>
                                <label for="turno" class="block text-sm font-medium text-gray-700">Turno</label>
                                <select name="turno" id="turno" class="mt-1 block w-full px-3 py-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="" disabled selected>Seleccionar Turno</option>
                                    <option value="Matutino">Matutino</option>
                                    <option value="Vespertino">Vespertino</option>
                                    <option value="Nocturno">Nocturno</option>
                                </select>
                            </div>
                    
                            <!-- Campo oculto de Disponible -->
                            <input type="hidden" name="disponible" value="1">
                        </div>
                    </form>
                    
                    <!-- Tabla de horarios configurados -->
                    <div class="mt-8">
                        <h1 class="text-lg font-semibold mb-4">Horarios Configurados para Días de la Semana</h1>
                        <div class="overflow-x-auto bg-white dark:bg-neutral-700">
                            <table id="horariosSemanaTable" class="display nowrap w-full shadow-md rounded-lg overflow-hidden" style="width:100%">
                                <thead class="bg-table-header-color text-white">
                                    <tr>
                                        <th>Día</th>
                                        <th>Horario</th>
                                        <th>Duración</th>
                                        <th>Turno</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($horariosSemana as $horario)
                                        <tr>
                                            <td>{{ $horario->dia_semana }}</td>
                                            <td>{{ \Carbon\Carbon::parse($horario->hora_inicio)->format('h:i A') }} - {{ \Carbon\Carbon::parse($horario->hora_fin)->format('h:i A') }}</td>
                                            <td>{{ $horario->duracion_sesion }} minutos</td>
                                            <td>{{ $horario->turno }}</td>
                                            <td>
                                                <form action="{{ route('horarios.destroy', $horario->id) }}" method="POST" class="delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="text-red-500 hover:text-red-700 delete-button">Eliminar</button>
                                                </form>
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

    @if ($errors->has('turno_repetido'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Turno Repetido',
                text: '{{ $errors->first('turno_repetido') }}',
                confirmButtonColor: '#007BFF',
            });
        </script>
    @endif

    @if ($errors->has('hora_fin'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error en la Hora',
                text: '{{ $errors->first('hora_fin') }}',
                confirmButtonColor: '#007BFF',
            });
        </script>
    @endif


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
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
        
        document.getElementById('horarioForm').addEventListener('submit', function(event) {
            // Obtener los valores seleccionados
            const diaSemana = document.getElementById('dia_semana').value;
            const turno = document.getElementById('turno').value;

            // Verificar si el valor seleccionado es el valor predeterminado
            if (diaSemana === "" || turno === "") {
                event.preventDefault(); // Prevenir el envío del formulario

                // Mostrar SweetAlert si no se ha seleccionado día o turno
                Swal.fire({
                    icon: 'Error',
                    title: 'Error',
                    text: 'Por favor selecciona un Día de la Semana y un Turno.',
                    confirmButtonColor: '#007BFF',
                });

                return false; // Detener el envío del formulario
            }
        });

        $(document).ready(function() {
            // Función de orden personalizada para los días de la semana
            jQuery.extend(jQuery.fn.dataTableExt.oSort, {
                "dayOfWeek-pre": function(value) {
                    var daysOrder = {
                        "Lunes": 1,
                        "Martes": 2,
                        "Miércoles": 3,
                        "Jueves": 4,
                        "Viernes": 5,
                        "Sábado": 6,
                        "Domingo": 7
                    };
                    return daysOrder[value] || 8;  // Devolver un número alto si el valor es indefinido
                },
                "dayOfWeek-asc": function(a, b) {
                    return a - b;
                },
                "dayOfWeek-desc": function(a, b) {
                    return b - a;
                }
            });

            // Función de orden personalizada para los turnos (Matutino, Vespertino, Nocturno)
            jQuery.extend(jQuery.fn.dataTableExt.oSort, {
                "turnOrder-pre": function(value) {
                    var turnOrder = {
                        "Matutino": 1,
                        "Vespertino": 2,
                        "Nocturno": 3
                    };
                    return turnOrder[value] || 4;  // Devolver un número alto si el valor es indefinido
                },
                "turnOrder-asc": function(a, b) {
                    return a - b;
                },
                "turnOrder-desc": function(a, b) {
                    return b - a;
                }
            });

            $('#horariosSemanaTable').DataTable({
                columnDefs: [
                    { type: "dayOfWeek", targets: 0 }, // Ordenar la columna del día de la semana
                    { type: "turnOrder", targets: 3 }  // Ordenar la columna del turno
                ],
                language: {
                    decimal: "",
                    emptyTable: "No hay datos disponibles",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                    infoEmpty: "Mostrando 0 a 0 de 0 entradas",
                    infoFiltered: "(filtrado de _MAX_ entradas totales)",
                    lengthMenu: "Mostrar _MENU_ entradas",
                    loadingRecords: "Cargando...",
                    processing: "Procesando...",
                    search: "Buscar:",
                    zeroRecords: "No se encontraron coincidencias",
                    paginate: {
                        first: "Primero",
                        last: "Último",
                        next: "Siguiente",
                        previous: "Anterior"
                    }
                },
                paging: true,
                searching: true,
                info: true,
                autoWidth: false,
                lengthMenu: [[5, 10, 15, -1], [5, 10, 15, "Todos"]],
                order: [[0, 'asc'], [3, 'asc']]  // Ordenar primero por día y luego por turno
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Seleccionar todos los botones de eliminar
            const deleteButtons = document.querySelectorAll('.delete-button');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.closest('form');

                    // Mostrar SweetAlert para confirmar la eliminación
                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: "No podrás revertir esta acción.",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Si el usuario confirma, se envía el formulario
                            form.submit();
                        }
                    });
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Desactiva el botón de "Guardar Horario" al enviar el formulario
            document.getElementById('horarioForm').addEventListener('submit', function() {
                const submitButton = document.getElementById('guardarHorario');
                submitButton.disabled = true;
                submitButton.innerText = 'Guardando...';  // Cambia el texto del botón mientras se guarda
            });
        });
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

    /* Quitar cualquier borde de la tabla, celdas y cabeceras */
    table {
        border-collapse: collapse; /* Asegura que se "unan" las celdas */
        border: none;             /* Quita el borde exterior de la tabla */
    }

    th, td {
        border: none;             /* Quita las líneas divisorias entre celdas */
        border-bottom: none;      /* Si quisieras quitar solo la línea inferior */
    }

    /* Si DataTables aplica sus propios bordes, puedes sobrescribirlos de esta manera: */
    table.dataTable,
    table.dataTable th,
    table.dataTable td {
        border: none !important;
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
