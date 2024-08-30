<x-app-layout>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-xl font-bold text-gray-900 uppercase">Cobro de Servicios</h1>
                    <div class="flex items-center justify-between mb-4">
                        <!-- Contenedor de Total Facturación -->
                        <div class="flex items-center space-x-4">
                            <div class="bg-white p-4 shadow-2xl rounded-md flex items-center space-x-4">
                                <div class="bg-icon-color p-2 rounded-full">
                                    <svg class="w-8 h-8 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M5 2a3 3 0 0 0-3 3v16a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V7l-6-5H5zm1 6h6v2H6V8zm8 2h4v2h-4v-2z"/>
                                    </svg>
                                </div>
                                <div class="text-center">
                                    <h2 class="text-lg font-bold">Total facturación: ${{ number_format($totalFacturacion, 2) }}</h2>
                                    <p class="text-gray-600">Período: {{ ucfirst(\Carbon\Carbon::now()->translatedFormat('F Y')) }}</p>
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
                                            <a href="{{ route('ventas.generateInvoice', $venta->id) }}" class="text-green-500 hover:text-green-700">
                                                Generar Factura
                                            </a>
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

    <!-- Modal Ver Venta -->
    <div id="viewModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity" aria-hidden="true"></div>
            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full" style="margin: 50px 0; height: auto;">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="sm:flex sm:items-center w-full">
                            <h3 class="text-2xl leading-6 font-bold text-center text-gray-900 w-full" style="color: #316986;">
                                Detalles de la Venta
                            </h3>
                            <button type="button" class="absolute top-0 right-0 mt-4 mr-4 text-gray-400 hover:text-gray-500 text-4xl" id="closeViewModal">
                                <span class="sr-only">Close</span>
                                &times;
                            </button>
                        </div>
                    </div>
                    <div class="border-t border-gray-200 mt-4"></div>
                    <div class="mt-2">
                        <div id="ventaDetails"></div>
                    </div>
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
                        title: 'Cobro de Servicios',
                        exportOptions: {
                            columns: ':not(:last-child)' // Excluye la última columna (Acciones)
                        }
                    },
                    {
                        extend: 'excel',
                        text: 'Excel',
                        title: 'Cobro de Servicios',
                        exportOptions: {
                            columns: ':not(:last-child)' // Excluye la última columna (Acciones)
                        }
                    },
                    {
                        extend: 'pdf',
                        text: 'PDF',
                        title: 'Cobro de Servicios',
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

            // Open View Modal
            document.querySelectorAll('.view-button').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');

                    // Fetch the venta details from the server and display in the modal
                    fetch(`{{ url('ventas') }}/${id}`)
                        .then(response => response.text())
                        .then(html => {
                            document.getElementById('ventaDetails').innerHTML = html;
                            document.getElementById('viewModal').classList.remove('hidden');
                        });
                });
            });

            document.getElementById('closeViewModal').addEventListener('click', function() {
                document.getElementById('viewModal').classList.add('hidden');
            });

            // Manejo de la acción de pago con confirmación
            $('.pagar-form').on('submit', function(e) {
                e.preventDefault();
                const form = $(this);
                const actionUrl = form.attr('action');

                // Mostrar alerta de confirmación
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¡Esta acción marcará la venta como pagada!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, pagar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Si el usuario confirma, envía el formulario
                        $.post(actionUrl, form.serialize(), function(data) {
                            form.closest('tr').find('.status-label')
                                .removeClass('bg-blue-200 text-blue-800')
                                .addClass('bg-green-200 text-green-800')
                                .text('Pagado');
                            form.remove(); // Eliminar el botón de pagar

                            // Mostrar alerta de éxito
                            Swal.fire(
                                'Pagado!',
                                'El estado de la venta ha sido actualizado.',
                                'success'
                            );
                        }).fail(function() {
                            Swal.fire(
                                'Error!',
                                'Ocurrió un error al procesar el pago. Por favor, inténtalo de nuevo.',
                                'error'
                            );
                        });
                    }
                });
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
