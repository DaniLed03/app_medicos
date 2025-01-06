<x-app-layout>
    <!-- Pantalla de carga -->
    <div id="loader" class="loader-container">
        <div class="loader"></div>
    </div>
    
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-10">
                <div class="p-8 bg-white border-b border-gray-200">
                    @if (session('success'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('success') }}
                        </div>
                    @endif

                    @role('Administrador')
                    <h1 class="text-2xl font-bold text-gray-900 uppercase mb-4">Agregar Permiso</h1>
                    <form action="{{ route('permisos.store') }}" method="POST" class="mb-6">
                        @csrf
                        <div class="flex items-center mb-6">
                            <input type="text" name="name" id="name" class="form-input rounded-md shadow-sm mt-1 block w-full" placeholder="Nombre del Permiso" required>
                            <button type="submit" class="ml-4 px-4 py-2 bg-blue-500 text-white text-sm rounded-md hover:bg-blue-600">Agregar Permiso</button>
                        </div>
                    </form>
                    @endrole

                    <div class="overflow-x-auto bg-white dark:bg-neutral-700">
                        <table id="permissionsTable" class="display nowrap min-w-full shadow-md rounded-lg overflow-hidden" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 bg-header-color text-left text-xs font-medium text-white uppercase tracking-wider">
                                        Nombre
                                    </th>
                                    @role('Administrador')
                                    <th class="px-6 py-3 bg-header-color text-left text-xs font-medium text-white uppercase tracking-wider">
                                        Acciones
                                    </th>
                                    @endrole
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($permissions as $permission)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $permission->name }}
                                        </td>
                                        @role('Administrador')
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 flex items-center">
                                            <form action="{{ route('permisos.destroy', $permission->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este permiso?');" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                                            </form>
                                        </td>
                                        @endrole
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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
        $('#permissionsTable').DataTable({
            "language": {
                "decimal": "",
                "emptyTable": "No hay permisos disponibles",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
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
            "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]]
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
