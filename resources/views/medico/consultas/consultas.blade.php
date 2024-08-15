<x-app-layout>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto bg-white dark:bg-neutral-700">

                        @php
                            $startDate = request('start_date');
                            $endDate = request('end_date');
                            $today = \Carbon\Carbon::today()->format('d/m/Y');
                        @endphp

                        @if($startDate && $endDate && $startDate != $endDate)
                            <h1 class="text-xl font-bold text-gray-900 uppercase">Consultas de {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} a {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</h1>
                        @elseif($startDate)
                            <h1 class="text-xl font-bold text-gray-900 uppercase">Consultas del {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }}</h1>
                        @else
                            <h1 class="text-xl font-bold text-gray-900 uppercase">Consultas del {{ $today }}</h1>
                        @endif

                        <br>

                        <!-- Filtros de fecha -->
                        <form id="filterForm" method="GET" action="{{ route('consultas.index') }}" class="flex mb-4">
                            <div class="mr-2">
                                <label for="start_date" class="block text-sm font-medium text-gray-700">Fecha Inicio</label>
                                <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" class="mt-1 block w-full pl-3 pr-12 py-2 border-gray-300 rounded-md shadow-sm">
                            </div>
                            <div class="mr-2">
                                <label for="end_date" class="block text-sm font-medium text-gray-700">Fecha Fin</label>
                                <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" class="mt-1 block w-full pl-3 pr-12 py-2 border-gray-300 rounded-md shadow-sm">
                            </div>
                            <div class="mt-4">
                                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Filtrar</button>
                            </div>
                            <div class="mt-4 ml-2">
                                <button type="button" id="resetButton" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">Reiniciar</button>
                            </div>
                        </form>

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
                                @forelse($consultas as $consulta)
                                    <tr>
                                        <td class="px-6 py-4">
                                            @if($consulta->isCita)
                                                {{ \Carbon\Carbon::parse($consulta->fecha)->format('d/m/Y') }}
                                            @else
                                                {{ \Carbon\Carbon::parse($consulta->fechaHora)->format('d/m/Y') }}
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($consulta->isCita)
                                                {{ \Carbon\Carbon::parse($consulta->hora)->format('H:i') }}
                                            @else
                                                {{ \Carbon\Carbon::parse($consulta->fechaHora)->format('H:i') }}
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($consulta->isCita && $consulta->persona)
                                                {{ $consulta->persona->nombres }} {{ $consulta->persona->apepat }} {{ $consulta->persona->apemat }}
                                            @elseif(!$consulta->isCita)
                                                {{ $consulta->paciente->nombres }} {{ $consulta->paciente->apepat }} {{ $consulta->paciente->apemat }}
                                            @else
                                                No disponible
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="status-label bg-blue-200 text-blue-800 px-2 py-1 rounded-full">{{ $consulta->status }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($consulta->status === 'Por comenzar')
                                                <a href="#" class="text-blue-500 hover:text-blue-700 iniciar-consulta" data-id="{{ $consulta->id }}">Iniciar consulta</a>
                                            @elseif($consulta->status === 'En proceso')
                                                <a href="#" class="text-blue-500 hover:text-blue-700 iniciar-consulta" data-id="{{ $consulta->id }}">Continuar consulta</a>
                                            @elseif($consulta->status === 'Finalizada')
                                                <span class="text-green-500">
                                                    <i class="fas fa-check-circle"></i>
                                                </span>
                                            @endif
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

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

    document.getElementById('resetButton').addEventListener('click', function() {
        const today = new Date();
        const offset = today.getTimezoneOffset(); // Obtener la diferencia horaria
        const adjustedToday = new Date(today.getTime() - offset * 60 * 1000); // Ajustar la fecha según la diferencia horaria
        const formattedToday = adjustedToday.toISOString().split('T')[0]; // Obtener la fecha ajustada en formato YYYY-MM-DD

        document.getElementById('start_date').value = formattedToday;
        document.getElementById('end_date').value = formattedToday;
        document.getElementById('filterForm').submit();
    });

    const iniciarConsultaButtons = document.querySelectorAll('.iniciar-consulta');

    iniciarConsultaButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const consultaId = this.dataset.id;
            const estado = this.closest('tr').querySelector('.status-label').textContent.trim();

            if (estado === 'En proceso') {
                // Redirigir directamente si el estado es "En proceso"
                window.location.href = `/consultas/verificarPaciente/${consultaId}`;
            } else {
                Swal.fire({
                    title: '¿Desea comenzar con la consulta?',
                    showCancelButton: true,
                    confirmButtonText: 'Sí',
                    cancelButtonText: 'No',
                    icon: 'warning'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/consultas/${consultaId}/iniciar`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log(data); // <-- Agrega esta línea para depuración
                            if (data.success) {
                                Swal.fire('¡Consulta iniciada!', '', 'success').then(() => {
                                    window.location.href = `/consultas/verificarPaciente/${consultaId}`;
                                });
                            } else {
                                Swal.fire('Hubo un error', 'No se pudo iniciar la consulta', 'error');
                            }
                        });

                    }
                });
            }
        });
    });

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
