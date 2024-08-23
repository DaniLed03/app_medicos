<x-app-layout>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-xl font-bold text-gray-900 uppercase">Lista de Ventas</h1>
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-4">
                            <!-- Contenedor de la Gráfica -->
                            <div class="bg-white p-4 shadow-2xl rounded-md flex items-center space-x-4">
                                <div class="text-center">
                                    <canvas id="ventasChart" width="400" height="200"></canvas>
                                </div>
                            </div>
                        </div>
                        <!-- Botón para descargar ventas en PDF -->
                        <div>
                            <a href="{{ route('ventas.pdf') }}" class="bg-blue-500 hover:bg-blue-700 text-white font py-2 px-4 rounded ml-4">
                                Descargar Ventas PDF
                            </a>
                        </div>
                    </div>

                    <!-- Tabla de ventas -->
                    <div class="overflow-x-auto bg-white dark:bg-neutral-700">
                        <table id="ventasTable" class="display nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Paciente</th>
                                    <th>Precio Consulta</th>
                                    <th>IVA</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ventas as $venta)
                                    <tr>
                                        <td>{{ $venta->id }}</td>
                                        <td>{{ $venta->paciente ? $venta->paciente->nombres : 'No disponible' }}</td>
                                        <td>{{ number_format($venta->precio_consulta, 2) }}</td>
                                        <td>{{ number_format($venta->iva, 2) }}</td>
                                        <td>{{ number_format($venta->total, 2) }}</td>
                                        <td class="px-6 py-4">
                                            <span class="status-label bg-blue-200 text-blue-800 px-2 py-1 rounded-full">{{ ucfirst($venta->status) }}</span>
                                        </td>
                                        <td>
                                            @if($venta->status == 'en proceso')
                                                <!-- Botón para cambiar el estado a 'Pagado' -->
                                                <form action="{{ route('ventas.pagar', $venta->id) }}" method="POST" class="inline-block pagar-form">
                                                    @csrf
                                                    <button type="submit" class="text-blue-500 hover:text-blue-700">
                                                        Pagar
                                                    </button>
                                                </form>
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

    <script>
        $(document).ready(function() {
            $('#ventasTable').DataTable({
                "language": {
                    "decimal": "",
                    "emptyTable": "No hay ventas registradas",
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

            // Datos de la gráfica
            const ventasData = @json($ventas->pluck('total')->toArray()); 
            const labels = @json($ventas->pluck('paciente.nombres')->toArray());

            const ctx = document.getElementById('ventasChart').getContext('2d');
            const ventasChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Ventas',
                        data: ventasData,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });

        $(document).ready(function() {
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
