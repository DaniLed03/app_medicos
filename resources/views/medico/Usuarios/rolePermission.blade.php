<x-app-layout>
    <!-- Pantalla de carga -->
    <div id="loader" class="loader-container">
        <div class="loader"></div>
    </div>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg p-10">
                <div class="p-8 bg-white border-b border-gray-200">
                    @if (session('success'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('success') }}
                        </div>
                    @endif

                    <h1 class="text-2xl font-bold text-gray-900 uppercase mb-4">Editar Rol</h1>
                    <form action="{{ route('roles.update', $role->id) }}" method="POST" class="mb-6">
                        @csrf
                        @method('PATCH')
                        <div class="mb-6">
                            <input type="text" name="name" id="name" value="{{ $role->name }}" class="form-input rounded-md shadow-sm mt-1 block w-full" placeholder="Nombre del Rol" readonly>
                        </div>

                        <div class="mb-6">
                            <div class="overflow-x-auto bg-white dark:bg-neutral-700">
                                <table id="permissionsTable" class="display nowrap min-w-full" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="px-6 py-3 bg-header-color text-left text-xs font-medium text-white uppercase tracking-wider">
                                                Permiso
                                            </th>
                                            <th class="px-6 py-3 bg-header-color text-left text-xs font-medium text-white uppercase tracking-wider">
                                                Asignado
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($permissions as $permission)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ $permission->name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 flex items-center">
                                                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" {{ $role->permissions->contains($permission->id) ? 'checked' : '' }} class="form-checkbox h-6 w-6 rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="flex justify-end items-center mt-6">
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white text-sm rounded-md hover:bg-blue-600">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">

<script>
    $(document).ready(function() {
        let checkboxStates = JSON.parse(localStorage.getItem('checkboxStates')) || {};

        // Inicializar DataTables
        var table = $('#permissionsTable').DataTable({
            "language": {
                "decimal": "",
                "emptyTable": "No hay permisos disponibles",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                "infoEmpty": "Mostrando 0 a 0 de 0 Entradas",
                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ entradas",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
            "paging": true,
            "searching": true,
            "info": true,
            "scrollX": false,
            "autoWidth": true,
            "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "Todos"]],
            "drawCallback": function(settings) {
                // Al cambiar de página, restaurar el estado de los checkboxes
                $('#permissionsTable input[type="checkbox"]').each(function() {
                    var id = $(this).val();
                    if (checkboxStates[id]) {
                        $(this).prop('checked', checkboxStates[id]);
                    }
                });
            }
        });

        // Guardar el estado de los checkboxes en localStorage al cambiar su valor
        $('#permissionsTable').on('change', 'input[type="checkbox"]', function() {
            var id = $(this).val();
            checkboxStates[id] = $(this).prop('checked');
            localStorage.setItem('checkboxStates', JSON.stringify(checkboxStates));
        });

        // Al enviar el formulario, envía los estados de los checkboxes al backend (si es necesario)
        $('form').on('submit', function() {
            localStorage.setItem('checkboxStates', JSON.stringify(checkboxStates));
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

    .form-input {
        border-radius: 0.375rem;
        border: 1px solid #2D7498;
        padding: 0.625rem 1rem;
        width: 100%;
    }
    .form-input:focus {
        border-color: #2D7498;
        box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.45);
    }
    .form-checkbox:checked {
        background-color: #33AD9B;
        border-color: #33AD9B;
    }
    .form-checkbox:focus {
        border-color: #33AD9B;
        box-shadow: 0 0 0 3px rgba(51, 173, 155, 0.5);
    }
    .form-checkbox:hover {
        border-color: #278A75;
    }
    .bg-button-color {
        background-color: #33AD9B;
    }
    .hover\:bg-button-hover:hover {
        background-color: #278A75;
    }
    .bg-icon-color {
        background-color: #2D7498;
    }
    .bg-header-color {
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
    .dataTables_wrapper .dataTables_scrollBody {
        overflow-x: hidden;
        overflow-y: hidden;
    }
</style>
