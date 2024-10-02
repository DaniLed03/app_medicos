<x-app-layout>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Título y Contenedor de Facturación y Filtros -->
                    <div class="flex justify-between items-center mb-4">
                        <div class="flex flex-col">
                            @php
                                $startDate = request('start_date');
                                $endDate = request('end_date');
                                $today = \Carbon\Carbon::today()->format('d/m/Y');
                            @endphp

                            <!-- Título -->
                            @if($startDate && $endDate && $startDate != $endDate)
                                <h1 class="text-xl font-bold text-gray-900 uppercase">Cobros de {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} a {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</h1>
                            @elseif($startDate)
                                <h1 class="text-xl font-bold text-gray-900 uppercase">Cobros del {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }}</h1>
                            @else
                                <h1 class="text-xl font-bold text-gray-900 uppercase">Cobros del {{ $today }}</h1>
                            @endif
                        </div>
                    </div>

                    <div class="flex justify-between items-center mb-4">
                        <!-- Filtros de fecha -->
                        <form id="filterForm" method="GET" action="{{ route('ventas.index') }}" class="flex items-center mb-4">
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

                        <div class="flex items-center space-x-4">
                            <div class="bg-white p-4 shadow-2xl rounded-md flex items-center space-x-4">
                                <div class="bg-icon-color p-2 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-cash-coin text-white" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8m5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0"/>
                                        <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195z"/>
                                        <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083q.088-.517.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1z"/>
                                        <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 6 6 0 0 1 3.13-1.567"/>
                                    </svg>
                                </div>
                                <div class="text-center">
                                    <h2 class="text-lg font-bold">Total Cobrado: ${{ number_format($totalFacturacion, 2) }}</h2>
                                    <p class="text-gray-600">Período: 
                                        @if($startDate && $endDate && $startDate != $endDate)
                                            {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} a {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}
                                        @else
                                            {{ $today }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de ventas -->
                    <div class="overflow-x-auto bg-white dark:bg-neutral-700">
                        <table id="ventasTable" class="display nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Fecha y Hora</th>
                                    <th>Paciente</th>
                                    <th>Precio Consulta</th>
                                    <th>Impuesto</th>
                                    <th>Total</th>
                                    <th>Fecha y Hora de Pago</th>
                                    <th>Status</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ventas as $venta)
                                    <tr>
                                        <td>{{ $venta->id }}</td>
                                        <td>{{ \Carbon\Carbon::parse($venta->created_at)->translatedFormat('j M Y h:i A') }}</td>
                                        <td>
                                            {{ $venta->paciente ? $venta->paciente->nombres . ' ' . $venta->paciente->apepat . ' ' . $venta->paciente->apemat : 'No disponible' }}
                                        </td>
                                        <td>{{ number_format($venta->precio_consulta, 2) }}</td>
                                        <td>{{ number_format($venta->iva, 2) }}%</td>
                                        <td>${{ number_format($venta->total, 2) }}</td>
                                        <td>{{ $venta->status == 'Pagado' ? \Carbon\Carbon::parse($venta->updated_at)->translatedFormat('j M Y h:i A') : '-' }}</td>
                                        <td class="px-6 py-4">
                                            <span class="status-label {{ $venta->status == 'Pagado' ? 'bg-green-200 text-green-800' : 'bg-blue-200 text-blue-800' }} px-2 py-1 rounded-full">
                                                {{ ucfirst($venta->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($venta->status == 'Por pagar')
                                                <a href="{{ route('ventas.marcarComoPagado', $venta->id) }}" class="text-blue-500 hover:text-blue-700">
                                                    Pagar
                                                </a>
                                            @endif
                                            @if($venta->status == 'Pagado')
                                                <a href="{{ route('ventas.generateInvoice', $venta->id) }}" class="text-green-500 hover:text-green-700">
                                                    Generar Factura
                                                </a>
                                            @endif
                                        </td>                                        
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>                        
                    </div>
                    
                    @if (session('success'))
                        <div class="bg-green-100 text-green-700 p-4 rounded mb-4 mt-4">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Agregar librerías -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <!-- Botones de exportación para DataTables -->
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.bootstrap4.min.css">

    <script>
        $(document).ready(function() {
            $('#ventasTable').DataTable({
                "order": [[1, 'desc']], // Ordenar por la columna de Fecha y Hora
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
                        title: 'Cobros',
                        exportOptions: {
                            columns: ':not(:last-child)' // Excluye la última columna (Acciones)
                        }
                    },
                    {
                        extend: 'excel',
                        text: 'Excel',
                        title: 'Cobros',
                        exportOptions: {
                            columns: ':not(:last-child)' // Excluye la última columna (Acciones)
                        }
                    },
                    {
                        extend: 'pdf',
                        text: 'PDF',
                        title: 'Cobros',
                        exportOptions: {
                            columns: ':not(:last-child)' // Excluye la última columna (Acciones)
                        }
                    },
                    {
                        extend: 'print',
                        text: 'Imprimir',
                        exportOptions: {
                            columns: ':not(:last-child)' // Excluye la última columna (Acciones)
                        }
                    }
                ],
                "language": {
                    "decimal": "",
                    "emptyTable": "No hay ventas registradas",
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
                "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "Todos"]]
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
        .bg-table-header-color {
            background-color: #2D7498;
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
        .status-label {
            display: inline-block;
            font-size: 0.875rem;
            font-weight: 600;
        }
        .bg-blue-200 {
            background-color: #bfdbfe;
        }
        .text-blue-800 {
            color: #1e3a8a;
        }
        .px-2 {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }
        .py-1 {
            padding-top: 0.25rem;
            padding-bottom: 0.25rem;
        }
        .rounded-full {
            border-radius: 9999px;
        }
    </style>

</x-app-layout>
