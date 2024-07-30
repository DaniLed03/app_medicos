<x-app-layout>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto bg-white dark:bg-neutral-700">
                        <div class="flex my-4 mx-4 items-center justify-between">
                            <h1 class="text-xl font-bold text-gray-900 uppercase">Consultas por Realizar</h1>
                            <button class="px-4 py-2 bg-orange-500 text-white rounded-md hover:bg-orange-600">Descargar reporte</button>
                        </div>

                        <!-- Table -->
                        <table id="consultasTable" class="min-w-full text-center text-sm whitespace-nowrap">
                            <!-- Table head -->
                            <thead class="uppercase tracking-wider border-b-2 bg-table-header-color text-white">
                                <tr>
                                    <th scope="col" class="px-6 py-4 font-bold">Fecha</th>
                                    <th scope="col" class="px-6 py-4 font-bold">Hora</th>
                                    <th scope="col" class="px-6 py-4 font-bold">Persona</th>
                                    <th scope="col" class="px-6 py-4 font-bold">Estado</th>
                                    <th scope="col" class="px-6 py-4 font-bold">Acciones</th>
                                </tr>
                            </thead>

                            <!-- Table body -->
                            <tbody>
                                @forelse($consultas as $cita)
                                    <tr>
                                        <td class="px-6 py-4">{{ $cita->fecha }}</td>
                                        <td class="px-6 py-4">{{ $cita->hora }}</td>
                                        <td class="px-6 py-4">{{ $cita->persona->nombres }} {{ $cita->persona->apepat }} {{ $cita->persona->apemat }}</td>
                                        <td class="px-6 py-4">
                                            <span class="bg-blue-200 text-blue-800 px-2 py-1 rounded-full">Por comenzar</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <a href="{{ route('consultas.verificarPaciente', $cita->id) }}" class="text-blue-500 hover:text-blue-700">Iniciar consulta</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4">No se encontraron consultas por realizar.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <!-- Paginación -->
                        <div class="my-4">
                            {{ $consultas->links() }}
                        </div>
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
        $('#consultasTable').DataTable({
            "language": {
                "decimal": "",
                "emptyTable": "No hay pacientes registrados",
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

    function terminarConsulta(event, id) {
        event.preventDefault();
        if (confirm('¿Está seguro de que desea terminar la consulta?')) {
            fetch(`/consultas/${id}/terminate`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Consulta terminada exitosamente.');
                    window.location.reload();
                } else {
                    alert('Hubo un error al terminar la consulta.');
                }
            });
        }
    }
</script>

<style>
    .bg-table-header-color {
        background-color: #2D7498;
    }
    .bg-icon-color {
        background-color: #2D7498;
    }
    .shadow-2xl {
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }
</style>
