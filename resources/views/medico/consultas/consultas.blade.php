<x-app-layout>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto bg-white dark:bg-neutral-700">
                        <div class="flex my-4 mx-4 items-center justify-between">
                            <h1 class="text-xl font-bold text-gray-900 uppercase">Histórico de Consultas</h1>
                            <button class="px-4 py-2 bg-orange-500 text-white rounded-md hover:bg-orange-600">Descargar reporte</button>
                        </div>

                        <!-- Resumen -->
                        <div class="flex items-center space-x-4 mb-4">
                            <div class="bg-white p-4 shadow-2xl rounded-md flex items-center space-x-4">
                                <div class="bg-icon-color p-2 rounded-full">
                                    <svg class="w-8 h-8 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M8 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1h2a2 2 0 0 1 2 2v15a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h2Zm6 1h-4v2H9a1 1 0 0 0 0 2h6a1 1 0 1 0 0-2h-1V4Zm-6 8a1 1 0 0 1 1-1h6a1 1 0 1 1 0 2H9a1 1 0 0 1-1-1Zm1 3a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2H9Z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="text-center">
                                    <h2 class="text-lg font-bold">Total consultas: {{ $totalConsultas }}</h2>
                                    <p>Periodo: {{ $monthName }} {{ now()->year }}</p>
                                </div>
                            </div>
                            <div class="bg-white p-4 shadow-2xl rounded-md flex items-center space-x-4">
                                <div class="bg-icon-color p-2 rounded-full">
                                    <svg class="w-8 h-8 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M9 15a6 6 0 1 1 12 0 6 6 0 0 1-12 0Zm3.845-1.855a2.4 2.4 0 0 1 1.2-1.226 1 1 0 0 1 1.992-.026c.426.15.809.408 1.111.749a1 1 0 1 1-1.496 1.327.682.682 0 0 0-.36-.213.997.997 0 0 1-.113-.032.4.4 0 0 0-.394.074.93.93 0 0 0 .455.254 2.914 2.914 0 0 1 1.504.9c.373.433.669 1.092.464 1.823a.996.996 0 0 1-.046.129c-.226.519-.627.94-1.132 1.192a1 1 0 0 1-1.956.093 2.68 2.68 0 0 1-1.227-.798 1 1 0 1 1 1.506-1.315.682.682 0 0 0 .363.216c.038.009.075.02.111.032a.4.4 0 0 0 .395-.074.93.93 0 0 0-.455-.254 2.91 2.91 0 0 1-1.503-.9c-.375-.433-.666-1.089-.466-1.817a.994.994 0 0 1 .047-.134Zm1.884.573.003.008c-.003-.005-.003-.008-.003-.008Zm.55 2.613s-.002-.002-.003-.007a.032.032 0 0 1 .003.007ZM4 14a1 1 0 0 1 1 1v4a1 1 0 1 1-2 0v-4a1 1 0 0 1 1-1Zm3-2a1 1 0 0 1 1 1v6a1 1 0 1 1-2 0v-6a1 1 0 0 1 1-1Zm6.5-8a1 1 0 0 1 1-1H18a1 1 0 0 1 1 1v3a1 1 0 1 1-2 0v-.796l-2.341 2.049a1 1 0 0 1-1.24.06l-2.894-2.066L6.614 9.29a1 1 0 1 1-1.228-1.578l4.5-3.5a1 1 0 0 1 1.195-.025l2.856 2.04L15.34 5h-.84a1 1 0 0 1-1-1Z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="text-center">
                                    <h2 class="text-lg font-bold">Total facturación: ${{ number_format($totalFacturacion, 2) }}</h2>
                                    <p>Periodo: {{ $monthName }} {{ now()->year }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Table -->
                        <table id="consultasTable" class="min-w-full text-center text-sm whitespace-nowrap">
                            <!-- Table head -->
                            <thead class="uppercase tracking-wider border-b-2 bg-table-header-color text-white">
                                <tr>
                                    <th scope="col" class="px-6 py-4 font-bold">Fecha</th>
                                    <th scope="col" class="px-6 py-4 font-bold">Paciente</th>
                                    <th scope="col" class="px-6 py-4 font-bold">Doctor</th>
                                    <th scope="col" class="px-6 py-4 font-bold">Total a Pagar</th>
                                    <th scope="col" class="px-6 py-4 font-bold">Estado</th>
                                    <th scope="col" class="px-6 py-4 font-bold">Acciones</th>
                                </tr>
                            </thead>

                            <!-- Table body -->
                            <tbody>
                                @forelse($consultas as $consulta)
                                    <tr>
                                        <td class="px-6 py-4">{{ $consulta->fechaHora->format('d M, Y') }}</td>
                                        <td class="px-6 py-4">{{ $consulta->paciente->nombres }} {{ $consulta->paciente->apepat }} {{ $consulta->paciente->apemat }}</td>
                                        <td class="px-6 py-4">{{ $consulta->usuarioMedico->full_name }}</td>
                                        <td class="px-6 py-4">${{ number_format($consulta->totalPagar, 2) }}</td>
                                        <td class="px-6 py-4">
                                            @if($consulta->status == 'en curso')
                                                <span class="bg-green-200 text-green-800 px-2 py-1 rounded-full">En curso</span>
                                            @else
                                                <span class="bg-gray-200 text-gray-800 px-2 py-1 rounded-full">Finalizada</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($consulta->status == 'en curso')
                                                <a href="{{ route('consultas.edit', $consulta->id) }}" class="text-blue-500 hover:text-blue-700">Ir a consulta</a>
                                                <form method="POST" class="inline" onsubmit="return terminarConsulta(event, {{ $consulta->id }})">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="text-red-500 hover:text-red-700 ml-2">Terminar</button>
                                                </form>
                                            @else
                                                <svg class="w-6 h-6 text-green-600 mx-auto" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                    <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm13.707-1.293a1 1 0 0 0-1.414-1.414L11 12.586l-1.793-1.793a1 1 0 0 0-1.414 1.414l2.5 2.5a1 1 0 0 0 1.414 0l4-4Z" clip-rule="evenodd"/>
                                                </svg>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4">No se encontraron consultas.</td>
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
