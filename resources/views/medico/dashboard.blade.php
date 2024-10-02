<x-app-layout>
    <!-- Pantalla de carga -->
    <div id="loader" class="loader-container">
        <div class="loader"></div>
    </div>

    <div class="py-12" style="display: none;">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-xl font-bold text-gray-900 uppercase">Lista de Pacientes</h1>
                    
                    <!-- Contenedor Total Pacientes y porcentaje -->
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-4">
                            <!-- Contenedor de Total Pacientes -->
                            <div class="bg-white p-4 shadow-2xl rounded-md flex items-center space-x-4">
                                <div class="bg-icon-color p-2 rounded-full">
                                    <svg class="w-8 h-8 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M12 6a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7Zm-1.5 8a4 4 0 0 0-4 4 2 2 0 0 0 2 2h7a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-3Zm6.82-3.096a5.51 5.51 0 0 0-2.797-6.293 3.5 3.5 0 1 1 2.796 6.292ZM19.5 18h.5a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-1.1a5.503 5.503 0 0 1-.471.762A5.998 5.998 0 0 1 19.5 18ZM4 7.5a3.5 3.5 0 0 1 5.477-2.889 5.5 5.5 0 0 0-2.796 6.293A3.501 3.501 0 0 1 4 7.5ZM7.1 12H6a4 4 0 0 0-4 4 2 2 0 0 0 2 2h.5a5.998 5.998 0 0 1 3.071-5.238A5.505 5.505 0 0 1 7.1 12Z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="text-center">
                                    <h2 class="text-lg font-bold">Total Pacientes: {{ $totalPacientes }}</h2>
                                </div>
                            </div>
                            <!-- Contenedor de Mujeres y Hombres -->
                            <div class="flex items-center space-x-4">
                                <div class="bg-white p-4 shadow-2xl rounded-md flex items-center space-x-4">
                                    <div class="bg-icon-color p-2 rounded-full">
                                        <img src="{{ asset('images/woman.svg') }}" class="w-8 h-8" alt="Icono de Mujer">
                                    </div>
                                    <div class="text-center">
                                        <h2 class="text-lg font-bold">Mujeres: {{ number_format($porcentajeMujeres, 1) }}%</h2>
                                    </div>
                                    <div class="bg-icon-color p-2 rounded-full">
                                        <img src="{{ asset('images/man.svg') }}" class="w-8 h-8" alt="Icono de Hombre">
                                    </div>
                                    <div class="text-center">
                                        <h2 class="text-lg font-bold">Hombres: {{ number_format($porcentajeHombres, 1) }}%</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Botón para agregar paciente -->
                        <div>
                            @can('Agregar Pacientes')
                                <button id="openModal" class="bg-button-color hover:bg-button-hover text-white font py-2 px-4 rounded">
                                    Agregar Paciente
                                </button>
                            @endcan
                        </div>
                    </div>




                    <!-- Tabla de pacientes (siempre visible) -->
                    <div class="overflow-x-auto bg-white dark:bg-neutral-700">
                        <!-- Formulario de búsqueda -->
                        <form method="GET" action="{{ route('medico.dashboard') }}" class="mb-4 float-right">
                            <input type="text" name="name" placeholder="Buscar por nombre completo" class="border rounded p-2 w-96 uppercase-input"> <!-- w-96 hace que el campo sea más largo -->
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded ml-2">Buscar</button>
                        </form>
                        
                        <table id="pacientesTable" class="display nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No. Exp</th>
                                    <th>Nombre del Paciente</th>
                                    <th>Fecha de Nacimiento</th>
                                    <th>Sexo</th>
                                    <th>Teléfono</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(request()->has('name') && request()->name != '')
                                    @if($pacientes->isNotEmpty())
                                        @foreach($pacientes as $paciente)
                                            <tr>
                                                <td>{{ $paciente->no_exp }}</td>
                                                <td>{{ $paciente->apepat }} {{ $paciente->apemat }} {{ $paciente->nombres }}</td>
                                                <td>{{ strtoupper(\Carbon\Carbon::parse($paciente->fechanac)->locale('es')->isoFormat('DD MMM YYYY')) }}</td>
                                                <td>{{ $paciente->sexo }}</td>
                                                <td>{{ $paciente->telefono }}</td>
                                                <td>
                                                    @can('Editar Paciente')
                                                        <a href="{{ route('pacientes.editar', $paciente->no_exp) }}" class="text-blue-500 hover:text-blue-700">Expediente</a>
                                                    @endcan
                                                    @can('Consultar')
                                                        <a href="{{ route('consultas.createWithoutCita', $paciente->no_exp) }}" class="text-green-500 hover:text-green-700 ml-4">Consultar</a>
                                                    @endcan
                                                    @can('Eliminar Paciente')
                                                        <form action="{{ route('pacientes.eliminar', $paciente->no_exp) }}" method="POST" class="inline-block">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="eliminar-paciente text-red-500 hover:text-red-700 ml-4">
                                                                Eliminar
                                                            </button>
                                                        </form>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <script>
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Sin resultados',
                                                text: 'No se encontraron pacientes que coincidan con la búsqueda.'
                                            });
                                        </script>
                                    @endif
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    @if(session('error'))
        <script>
            Swal.fire({
                title: 'Error!',
                text: "{{ session('error') }}",
                icon: 'error',
                confirmButtonText: 'OK'
            });
        </script>
    @endif

    <!-- Modal Agregar -->
    <div id="modal" class="fixed z-10 inset-0 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity" aria-hidden="true"></div>
            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full" style="margin: 50px 0; height: auto;">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="sm:flex sm:items-center w-full">
                            <h3 class="text-2xl leading-6 font-bold text-center text-gray-900 w-full" style="color: #316986;">
                                Agregar Paciente
                            </h3>
                            <button type="button" class="absolute top-0 right-0 mt-4 mr-4 text-gray-400 hover:text-gray-500 text-4xl" id="closeModal">
                                <span class="sr-only">Close</span>
                                &times;
                            </button>
                        </div>
                    </div>
                    <div class="border-t border-gray-200 mt-4"></div>
                    <div class="mt-2">
                        <form method="POST" action="{{ route('pacientes.store') }}" id="addPacienteForm">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Nombres -->
                                <div class="mt-4">
                                    <x-input-label for="nombres" :value="__('Nombres')" />
                                    <x-text-input id="nombres" class="block mt-1 w-full uppercase-input" type="text" name="nombres" :value="old('nombres')" required autofocus autocomplete="name" />
                                    <x-input-error :messages="$errors->get('nombres')" class="mt-2" />
                                </div>
                                
                                <!-- Apellido Paterno -->
                                <div class="mt-4">
                                    <x-input-label for="apepat" :value="__('Apellido Paterno')" />
                                    <x-text-input id="apepat" class="block mt-1 w-full uppercase-input" type="text" name="apepat" :value="old('apepat')" required autofocus autocomplete="name" />
                                    <x-input-error :messages="$errors->get('apepat')" class="mt-2" />
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Apellido Materno -->
                                <div class="mt-4">
                                    <x-input-label for="apemat" :value="__('Apellido Materno')" />
                                    <x-text-input id="apemat" class="block mt-1 w-full uppercase-input" type="text" name="apemat" :value="old('apemat')" required autofocus autocomplete="name" />
                                    <x-input-error :messages="$errors->get('apemat')" class="mt-2" />
                                </div>
                                
                                <!-- Fecha de Nacimiento -->
                                <div class="mt-4">
                                    <x-input-label for="fechanac" :value="__('Fecha de Nacimiento')" />
                                    <x-text-input id="fechanac" class="block mt-1 w-full" type="date" name="fechanac" :value="old('fechanac')" required autofocus />
                                    <x-input-error :messages="$errors->get('fechanac')" class="mt-2" />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Teléfono -->
                                <div class="mt-4">
                                    <x-input-label for="telefono" :value="__('Teléfono')" />
                                    <x-text-input id="telefono" class="block mt-1 w-full uppercase-input" type="text" name="telefono" :value="old('telefono')" required autofocus />
                                    <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
                                </div>
                            
                                <!-- Sexo -->
                                <div class="mt-4 md:col-span-1">
                                    <x-input-label for="sexo" :value="__('Sexo')" />
                                    <div class="flex items-center space-x-4">
                                        <div class="flex items-center">
                                            <input type="radio" id="masculino" name="sexo" value="masculino" class="mr-2" required>
                                            <label for="masculino" class="text-sm font-medium text-gray-700">Masculino</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="radio" id="femenino" name="sexo" value="femenino" class="mr-2" required>
                                            <label for="femenino" class="text-sm font-medium text-gray-700">Femenino</label>
                                        </div>
                                    </div>
                                    <x-input-error :messages="$errors->get('sexo')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Campos ocultos -->
                            <input type="hidden" name="hora" value="null">
                            <input type="hidden" name="lugar_naci" value="null">
                            <input type="hidden" name="hospital" value="null">
                            <input type="hidden" name="peso" value="null">
                            <input type="hidden" name="talla" value="null">
                            <input type="hidden" name="tipoparto" value="null">
                            <input type="hidden" name="tiposangre" value="null">
                            <input type="hidden" name="antecedentes" value="null">
                            <input type="hidden" name="padre" value="null">
                            <input type="hidden" name="madre" value="null">
                            <input type="hidden" name="direccion" value="null">
                            <input type="hidden" name="telefono2" value="null">
                            <input type="hidden" name="correo" value="null">
                            <input type="hidden" name="curp" value="null">
                            
                            <!-- Botón para guardar paciente -->
                            <div class="flex items-center justify-end mt-4">
                                <x-primary-button id="guardarPaciente" class="ml-4">
                                    {{ __('Registrar Usuario') }}
                                </x-primary-button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.bootstrap4.min.css">

<script>
    document.getElementById('addPacienteForm').addEventListener('submit', function() {
        // Desactivar el botón después de hacer clic
        document.getElementById('guardarPaciente').disabled = true;
        document.getElementById('guardarPaciente').innerText = 'Guardando...'; // Cambiar el texto del botón mientras se guarda
    });
    
    document.querySelectorAll('.eliminar-paciente').forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault(); // Evitar el envío inmediato del formulario
            const form = this.closest('form'); // Buscar el formulario más cercano
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Esta acción no se puede deshacer.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Si se confirma, enviar el formulario
                }
            });
        });
    });

</script>
<script>
    $(document).ready(function() {
        $('#pacientesTable').DataTable({
            "dom": '<"row"<"col-sm-12 col-md-6"lB><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            "buttons": [
                {
                    extend: 'copy',
                    text: 'Copiar',
                    exportOptions: {
                        columns: ':not(:last-child)' // Excluye la última columna (Acciones)
                    }
                },
                {
                    extend: 'csv',
                    text: 'CSV',
                    title: 'Lista de Pacientes',
                    exportOptions: {
                        columns: ':not(:last-child)' // Excluye la última columna (Acciones)
                    }
                },
                {
                    extend: 'excel',
                    text: 'Excel',
                    title: 'Lista de Pacientes',
                    exportOptions: {
                        columns: ':not(:last-child)' // Excluye la última columna (Acciones)
                    }
                },
                {
                    extend: 'pdf',
                    text: 'PDF',
                    title: 'Lista de Pacientes',
                    exportOptions: {
                        columns: ':not(:last-child)' // Excluye la última columna (Acciones)
                    }
                },
                {
                    extend: 'print',
                    text: 'Imprimir',
                    title: 'Lista de Pacientes',
                    exportOptions: {
                        columns: ':not(:last-child)' // Excluye la última columna (Acciones)
                    }
                }
            ],
            "language": {
                "decimal": "",
                "emptyTable": "Ingresa un nombre para mostrar coincidencias.",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                "infoEmpty": "Mostrando 0 a 0 de 0 Entradas",
                "infoFiltered": "(Filtrado de _MAX_ entradas totales)",
                "lengthMenu": "Mostrar _MENU_ entradas",
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
            "paging": true,
            "searching": false,
            "info": true,
            "scrollX": false,
            "autoWidth": true,
            "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "Todos"]]
        });

        document.getElementById('openModal').addEventListener('click', function() {
            // Muestra el modal sin necesidad de asignar manualmente el número de expediente
            document.getElementById('modal').classList.remove('hidden');
        });

        document.getElementById('closeModal').addEventListener('click', function() {
            document.getElementById('modal').classList.add('hidden');
        });

        @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: "{{ session('error') }}",
            });
        </script>
        @endif

        document.querySelectorAll('.edit-button').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                const id = this.getAttribute('data-id');
                const formAction = `{{ url('medico/pacientes/editar') }}/${id}`;
                document.getElementById('editPacienteForm').setAttribute('action', formAction);
                
                // Fill the form with the data from the patient
                const patient = @json($pacientes).find(p => p.id == id);
                document.getElementById('no_expEditar').value = patient.id; // Auto-increment based on ID
                document.getElementById('nombresEditar').value = patient.nombres;
                document.getElementById('apepatEditar').value = patient.apepat;
                document.getElementById('apematEditar').value = patient.apemat;
                document.getElementById('fechanacEditar').value = patient.fechanac;
                document.getElementById('horaEditar').value = patient.hora;
                document.getElementById('pesoEditar').value = patient.peso;
                document.getElementById('tallaEditar').value = patient.talla;
                document.getElementById('lugar_naciEditar').value = patient.lugar_naci;
                document.getElementById('hospitalEditar').value = patient.hospital;
                document.getElementById('tipopartoEditar').value = patient.tipoparto;
                document.getElementById('tiposangreEditar').value = patient.tiposangre;
                document.getElementById('antecedentesEditar').value = patient.antecedentes;
                document.getElementById('padreEditar').value = patient.padre;
                document.getElementById('madreEditar').value = patient.madre;
                document.getElementById('direccionEditar').value = patient.direccion;
                document.getElementById('telefonoEditar').value = patient.telefono;
                document.getElementById('telefono2Editar').value = patient.telefono2;
                document.getElementById('curpEditar').value = patient.curp; 
                document.querySelector(`input[name="sexo"][value="${patient.sexo}"]`).checked = true;
                document.getElementById('correoEditar').value = patient.correo;

                document.getElementById('modalEditar').classList.remove('hidden');
            });
        });

        document.getElementById('closeModalEditar').addEventListener('click', function() {
            document.getElementById('modalEditar').classList.add('hidden');
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
    
    .dt-buttons {
        margin-bottom: 10px;
    }

    .buttons-html5, .buttons-print {
        margin-right: 5px;
    }

    .bg-button-color {
        background-color: #33AD9B;
    }
    .hover\:bg-button-hover:hover {
        background-color: #278A75;
    }
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
    .info-box {
        display: flex;
        align-items: center;
        background-color: white;
        border-radius: 8px;
        padding: 16px;
        width: 300px;
        border: 1px solid #ddd;
    }
    .info-icon {
        margin-right: 12px;
    }
    .icon-circle {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #2D7498;
    }
    .info-title {
        font-weight: bold;
        color: black;
    }
    .info-value {
        font-size: 24px;
        font-weight: bold;
        color: black;
    }
    .icon-small {
        width: 20px;
        height: 20px;
    }
    .shadow-md {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .bg-icon-color {
        background-color: #2D7498;
    }
    .dataTables_wrapper .dataTables_scrollBody {
        overflow-x: hidden;
        overflow-y: hidden; /* Esto ocultará el scroll vertical */
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

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Aplica mayúsculas a toda la tabla excepto a la columna de acciones */
    table tbody tr {
        text-transform: uppercase;
    }

    table tbody tr td:last-child {
        text-transform: none; /* Excepción para la columna de Acciones */
    }

    /* Forzar texto en mayúsculas al escribir en los campos */
    .uppercase-input {
        text-transform: uppercase;
    }

    .uppercase-input::placeholder {
        text-transform: none; /* Para que los placeholders no se vean en mayúsculas */
    }

    input[type="text"] {
        text-transform: uppercase; /* Convierte el texto a mayúsculas */
    }

    input[type="text"]::placeholder {
        text-transform: none; /* Mantiene el placeholder sin cambios de formato */
    }

    /* Estilo para el campo de búsqueda en DataTables */
    .dataTables_filter input[type="search"] {
        text-transform: uppercase; /* Convierte el texto a mayúsculas */
    }

    .dataTables_filter input[type="search"]::placeholder {
        text-transform: none; /* Placeholder permanece sin cambios */
    }



</style>
