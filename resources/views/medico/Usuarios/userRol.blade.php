<x-app-layout>
    <!-- Pantalla de carga -->
    <div id="loader" class="loader-container">
        <div class="loader"></div>
    </div>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg p-10">
                <div class="p-8 bg-white border-b border-gray-200">
                    <div class="flex items-center mb-6 md:mb-2">
                        <div class="flex items-center justify-center h-20 w-20 rounded-full bg-white text-3xl font-bold border-2" style="border-color: #2D7498; color: #33AD9B;">
                            {{ substr($user->nombres, 0, 1) }}{{ substr($user->apepat, 0, 1) }}
                        </div>
                        <h2 class="text-4xl font-bold text-left ml-6" style="color: black;">
                            {{ $user->nombres }} {{ $user->apepat }} {{ $user->apemat }}
                        </h2>
                    </div>
                    
                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="mb-6 mt-8">
                            <label for="roles" class="block text-xl font-medium text-gray-700">Roles</label>
                            <div class="overflow-x-auto bg-white dark:bg-neutral-700">
                                <table id="rolesTable" class="display nowrap shadow-md rounded-lg overflow-hidden" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Rol</th>
                                            <th>Asignado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($roles as $role)
                                            <tr>
                                                <td>{{ $role->name }}</td>
                                                <td>
                                                    <input type="checkbox" name="roles[]" value="{{ $role->id }}" {{ $user->roles->contains($role->id) ? 'checked' : '' }} class="form-checkbox h-6 w-6 rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
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
        $('#rolesTable').DataTable({
            "language": {
                "decimal": "",
                "emptyTable": "No hay roles disponibles",
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
