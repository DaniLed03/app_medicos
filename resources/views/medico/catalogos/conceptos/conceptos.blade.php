<x-app-layout>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-xl font-bold text-gray-900 uppercase">Lista de Conceptos</h1>
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-4">
                            <!-- Contenedor de Total Conceptos -->
                            <div class="bg-white p-4 shadow-2xl rounded-md flex items-center space-x-4">
                                <div class="bg-icon-color p-2 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-capsule-pill text-white" viewBox="0 0 16 16">
                                        <path d="M11.02 5.364a3 3 0 0 0-4.242-4.243L1.121 6.778a3 3 0 1 0 4.243 4.243l5.657-5.657Zm-6.413-.657 2.878-2.879a2 2 0 1 1 2.829 2.829L7.435 7.536zM12 8a4 4 0 1 1 0 8 4 4 0 0 1 0-8m-.5 1.042a3 3 0 0 0 0 5.917zm1 5.917a3 3 0 0 0 0-5.917z"/>
                                    </svg>
                                </div>
                                <div class="text-center">
                                    <h2 class="text-lg font-bold">Total Conceptos: {{ count($conceptos) }}</h2>
                                </div>
                            </div>
                        </div>                        
                        <div>
                            <!-- Botón para agregar concepto -->
                            <button id="openAddModal" class="bg-button-color hover:bg-button-hover text-white font py-2 px-4 rounded">
                                Agregar Concepto
                            </button>
                        </div>
                    </div>

                    <!-- Tabla de conceptos -->
                    <div class="overflow-x-auto bg-white dark:bg-neutral-700">
                        <table id="conceptosTable" class="display nowrap w-full" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Tipo de Concepto</th>
                                    <th style="width: 25%;">Concepto</th>
                                    <th style="width: 25%;">Unidad de Medida</th>
                                    <th>Impuesto</th>
                                    <th>Precio Unitario</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($conceptos as $concepto)
                                    <tr>
                                        <td>{{ $concepto->tipo_concepto }}</td>
                                        <td>{{ $concepto->concepto }}</td>
                                        <td>{{ $concepto->unidad_medida }}</td>
                                        <td>{{ number_format($concepto->impuesto, 2) }}%</td>
                                        <td>${{ number_format($concepto->precio_unitario, 2) }}</td>
                                        <td>
                                            <a href="javascript:void(0);" class="edit-button text-blue-500 hover:text-blue-700" 
                                                data-id="{{ $concepto->id_concepto }}" 
                                                data-concepto="{{ $concepto->concepto }}" 
                                                data-precio_unitario="{{ $concepto->precio_unitario }}" 
                                                data-impuesto="{{ $concepto->impuesto }}" 
                                                data-unidad_medida="{{ $concepto->unidad_medida }}" 
                                                data-tipo_concepto="{{ $concepto->tipo_concepto }}">
                                                Editar
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

    <!-- Modal Agregar Concepto -->
    <div id="addModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity" aria-hidden="true"></div>
            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full" style="margin: 50px 0; height: auto;">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="sm:flex sm:items-center w-full">
                            <h3 class="text-2xl leading-6 font-bold text-center text-gray-900 w-full" style="color: #316986;">
                                Agregar Concepto
                            </h3>
                            <button type="button" class="absolute top-0 right-0 mt-4 mr-4 text-gray-400 hover:text-gray-500 text-4xl" id="closeAddModal">
                                <span class="sr-only">Close</span>
                                &times;
                            </button>
                        </div>
                    </div>
                    <div class="border-t border-gray-200 mt-4"></div>
                    <div class="mt-2">
                        @include('medico.catalogos.conceptos.agregarConcepto')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Editar Concepto -->
    <div id="editModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity" aria-hidden="true"></div>
            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full" style="margin: 50px 0; height: auto;">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="sm:flex sm:items-center w-full">
                            <h3 class="text-2xl leading-6 font-bold text-center text-gray-900 w-full" style="color: #316986;">
                                Editar Concepto
                            </h3>
                            <button type="button" class="absolute top-0 right-0 mt-4 mr-4 text-gray-400 hover:text-gray-500 text-4xl" id="closeEditModal">
                                <span class="sr-only">Close</span>
                                &times;
                            </button>
                        </div>
                    </div>
                    <div class="border-t border-gray-200 mt-4"></div>
                    <div class="mt-2">
                        <form id="editConceptoForm" action="" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mt-4">
                                <label for="concepto_edit" class="block text-sm font-medium text-gray-700">Concepto</label>
                                <input type="text" id="concepto_edit" name="concepto" class="mt-1 p-2 w-full border rounded-md" required>
                            </div>
                            <div class="mt-4">
                                <label for="unidad_medida_edit" class="block text-sm font-medium text-gray-700">Unidad de Medida</label>
                                <input type="text" id="unidad_medida_edit" name="unidad_medida" class="mt-1 p-2 w-full border rounded-md" required>
                            </div>
                            <div class="mt-4 grid grid-cols-2 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="impuesto_edit" class="block text-sm font-medium text-gray-700">Impuesto (%)</label>
                                    <input type="number" step="0.01" id="impuesto_edit" name="impuesto" class="mt-1 p-2 w-full border rounded-md">
                                </div>
                                <div>
                                    <label for="precio_unitario_edit" class="block text-sm font-medium text-gray-700">Precio Unitario</label>
                                    <input type="number" step="0.01" id="precio_unitario_edit" name="precio_unitario" class="mt-1 p-2 w-full border rounded-md" required>
                                </div>
                            </div>
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700">Tipo de Concepto</label>
                                <div class="flex items-center space-x-4">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="tipo_concepto" id="tipo_concepto_producto_edit" value="Producto" class="form-radio" required>
                                        <span class="ml-2">Producto</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="tipo_concepto" id="tipo_concepto_servicio_edit" value="Servicio" class="form-radio" required>
                                        <span class="ml-2">Servicio</span>
                                    </label>
                                </div>
                            </div>
                            <div class="flex items-center justify-end mt-4">
                                <button type="submit" id="guardarEditConcepto" class="bg-blue-500 text-white px-4 py-2 rounded-md">Actualizar Concepto</button>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

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
        $('#conceptosTable').DataTable({
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
                    title: 'Lista de Conceptos',
                    exportOptions: {
                        columns: ':not(:last-child)' // Excluye la última columna (Acciones)
                    }
                },
                {
                    extend: 'excel',
                    text: 'Excel',
                    title: 'Lista de Conceptos',
                    exportOptions: {
                        columns: ':not(:last-child)' // Excluye la última columna (Acciones)
                    }
                },
                {
                    extend: 'pdf',
                    text: 'PDF',
                    title: 'Lista de Conceptos',
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
                "emptyTable": "No hay conceptos registrados",
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
            "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "Todos"]]
        });

        // Open Add Modal
        document.getElementById('openAddModal').addEventListener('click', function() {
            document.getElementById('addModal').classList.remove('hidden');
        });

        document.getElementById('closeAddModal').addEventListener('click', function() {
            document.getElementById('addModal').classList.add('hidden');
        });

        // Abre el modal de editar concepto
        document.querySelectorAll('.edit-button').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const concepto = this.getAttribute('data-concepto');
                const precio_unitario = this.getAttribute('data-precio_unitario');
                const impuesto = this.getAttribute('data-impuesto');
                const unidad_medida = this.getAttribute('data-unidad_medida');
                const tipo_concepto = this.getAttribute('data-tipo_concepto');

                // Configurar el formulario para enviar la actualización
                const form = document.getElementById('editConceptoForm');
                form.setAttribute('action', `{{ url('conceptos') }}/${id}`);
                form.querySelector('#concepto_edit').value = concepto;
                form.querySelector('#precio_unitario_edit').value = precio_unitario;
                form.querySelector('#impuesto_edit').value = impuesto;
                form.querySelector('#unidad_medida_edit').value = unidad_medida;

                // Seleccionar el radio button correspondiente
                if (tipo_concepto === 'Producto') {
                    form.querySelector('#tipo_concepto_producto_edit').checked = true;
                } else if (tipo_concepto === 'Servicio') {
                    form.querySelector('#tipo_concepto_servicio_edit').checked = true;
                }

                // Mostrar el modal
                document.getElementById('editModal').classList.remove('hidden');
            });
        });



        document.getElementById('closeEditModal').addEventListener('click', function() {
            document.getElementById('editModal').classList.add('hidden');
        });

        // Desactiva el botón de "Actualizar Concepto" al enviar el formulario
        document.getElementById('editConceptoForm').addEventListener('submit', function() {
            const submitButton = document.getElementById('guardarEditConcepto');
            submitButton.disabled = true;
            submitButton.innerText = 'Guardando...';  // Cambia el texto del botón mientras se guarda
        });
    });
</script>

<style>
    .dt-buttons {
        margin-bottom: 10px;
    }

    .buttons-html5, .buttons-print {
        margin-right: 5px;
    }
    
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


    .form-radio {
        appearance: none;
        border-radius: 50%;
        width: 16px;
        height: 16px;
        position: relative;
    }

    .form-radio:checked:before {
        content: '';
        display: block;
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: white;
        position: absolute;
        top: 4px;
        left: 4px;
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
</style>
