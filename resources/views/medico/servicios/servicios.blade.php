<x-app-layout>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto bg-white dark:bg-neutral-700">
                        <div class="flex my-4 mx-4 items-center justify-between">
                            <h1 class="text-xl font-bold text-gray-900 uppercase">Lista de Servicios</h1>
                            <button id="openAddModal" class="bg-button-color hover:bg-button-hover text-white py-2 px-4 rounded">
                                Agregar Servicio
                            </button>
                        </div>
                        <!-- Table -->
                        <table id="serviciosTable" class="min-w-full text-center text-sm whitespace-nowrap">
                            <!-- Table head -->
                            <thead class="uppercase tracking-wider border-b-2 dark:border-neutral-600 bg-custom-color text-white font-bold">
                                <tr>
                                    <th scope="col" class="px-6 py-4">Nombre</th>
                                    <th scope="col" class="px-6 py-4">Descripción</th>
                                    <th scope="col" class="px-6 py-4">Precio</th>
                                    <th scope="col" class="px-6 py-4">Cantidad</th>
                                    <th scope="col" class="px-6 py-4">Acciones</th>
                                </tr>
                            </thead>

                            <!-- Table body -->
                            <tbody>
                                @foreach($servicios as $servicio)
                                    <tr class="border-b dark:border-neutral-600">
                                        <td class="px-6 py-4">{{ $servicio->nombre }}</td>
                                        <td class="px-6 py-4">{{ $servicio->descripcion }}</td>
                                        <td class="px-6 py-4">{{ $servicio->precio }}</td>
                                        <td class="px-6 py-4">{{ $servicio->cantidad }}</td>
                                        <td class="px-6 py-4">
                                            <!-- Enlace para editar el servicio -->
                                            <button data-id="{{ $servicio->id }}" class="openEditModal text-blue-500 hover:underline">Editar</button>
                                            <!-- Formulario para eliminar el servicio -->
                                            <form action="{{ route('servicios.eliminar', $servicio->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:underline ml-2">Eliminar</button>
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

    <!-- Add Modal -->
    <div id="addModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity" aria-hidden="true"></div>
            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="sm:flex sm:items-center w-full">
                            <h3 class="text-2xl leading-6 font-bold text-center text-gray-900 w-full" style="color: #316986;">
                                Agregar Servicio
                            </h3>
                            <button type="button" class="absolute top-0 right-0 mt-4 mr-4 text-gray-400 hover:text-gray-500 text-2xl" id="closeAddModal">
                                <span class="sr-only">Close</span>
                                &times;
                            </button>
                        </div>
                    </div>
                    <div class="border-t border-gray-200 mt-4"></div>
                    <div class="mt-2">
                        @include('medico.servicios.agregarServicio')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity" aria-hidden="true"></div>
            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="sm:flex sm:items-center w-full">
                            <h3 class="text-2xl leading-6 font-bold text-center text-gray-900 w-full" style="color: #316986;">
                                Editar Servicio
                            </h3>
                            <button type="button" class="absolute top-0 right-0 mt-4 mr-4 text-gray-400 hover:text-gray-500 text-2xl" id="closeEditModal">
                                <span class="sr-only">Close</span>
                                &times;
                            </button>
                        </div>
                    </div>
                    <div class="border-t border-gray-200 mt-4"></div>
                    <div class="mt-2">
                        <div id="editFormContainer"></div>
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
        $('#serviciosTable').DataTable({
            "language": {
                "decimal": "",
                "emptyTable": "No hay servicios registrados",
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

        // Open Add Modal
        document.getElementById('openAddModal').addEventListener('click', function() {
            document.getElementById('addModal').classList.remove('hidden');
        });

        // Close Add Modal
        document.getElementById('closeAddModal').addEventListener('click', function() {
            document.getElementById('addModal').classList.add('hidden');
        });

        // Open Edit Modal
        $('.openEditModal').on('click', function() {
            var id = $(this).data('id');
            $.ajax({
                url: '/servicios/' + id + '/editar',
                method: 'GET',
                success: function(response) {
                    $('#editFormContainer').html(response);
                    $('#editModal').removeClass('hidden');
                }
            });
        });

        // Close Edit Modal
        document.getElementById('closeEditModal').addEventListener('click', function() {
            document.getElementById('editModal').classList.add('hidden');
        });
    });
</script>

<style>
    .bg-custom-color {
        background-color: #2D7498;
    }
    .bg-button-color {
        background-color: #33AD9B;
    }
    .hover\:bg-button-hover:hover {
        background-color: #278A75;
    }
</style>
