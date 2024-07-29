<x-app-layout>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg p-10">
                <div class="p-8 bg-white border-b border-gray-200">
                    @if (session('success'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('success') }}
                        </div>
                    @endif

                    <h1 class="text-2xl font-bold text-gray-900 uppercase mb-4">Crear Rol</h1>
                    <form action="{{ route('roles.store') }}" method="POST" class="mb-6">
                        @csrf
                        <div class="flex items-center">
                            <input type="text" name="name" class="form-input rounded-md shadow-sm mt-1 block w-full" placeholder="Nombre del Rol">
                            <button type="submit" class="ml-4 px-6 py-3 bg-blue-500 text-white text-lg rounded-md hover:bg-blue-600">Crear</button>
                        </div>
                    </form>

                    <div class="overflow-x-auto bg-white dark:bg-neutral-700">
                        <table id="rolesTable" class="display nowrap min-w-full" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 bg-header-color text-left text-xs font-medium text-white uppercase tracking-wider">
                                        Nombre
                                    </th>
                                    <th class="px-6 py-3 bg-header-color text-left text-xs font-medium text-white uppercase tracking-wider">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($roles as $role)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $role->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 flex items-center">
                                            <a href="{{ route('roles.edit', $role->id) }}" class="text-blue-600 hover:text-blue-900 mr-4">Editar</a>
                                            <form action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display:inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
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
</script>

<style>
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
