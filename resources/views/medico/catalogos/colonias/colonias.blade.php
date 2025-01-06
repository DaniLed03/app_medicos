    <x-app-layout>
        <!-- Pantalla de carga -->
        <div id="loader" class="loader-container">
            <div class="loader"></div>
        </div>

        <div class="py-12">
            <div class="max-w-full mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h1 class="text-xl font-bold text-gray-900 uppercase">Lista de Colonias</h1>
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-4">
                                <!-- Filtro por entidad -->
                                <div class="bg-white p-4 shadow-2xl rounded-md flex items-center space-x-4">
                                    <label for="entidadSelect" class="font-bold">Entidad:</label>
                                    <select id="entidadSelect" class="p-2 border rounded">
                                        <option value="">Seleccione una Entidad</option>
                                        @foreach($entidades as $entidad)
                                            <option value="{{ $entidad->id }}">{{ $entidad->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                        
                                <!-- Filtro por municipio -->
                                <div class="bg-white p-4 shadow-2xl rounded-md flex items-center space-x-4">
                                    <label for="municipioSelect" class="font-bold">Municipio:</label>
                                    <select id="municipioSelect" class="p-2 border rounded" disabled>
                                        <option value="">Seleccione un Municipio</option>
                                    </select>
                                </div>
                        
                                <!-- Botón para aceptar los filtros al lado de los selectores -->
                                <button id="applyFilters" class="bg-button-color hover:bg-button-hover text-white font py-2 px-4 rounded h-full" disabled>
                                    Aceptar Filtros
                                </button>
                            </div>
                        
                            <!-- Botón para agregar una colonia -->
                            <button id="openAddColoniaModal" class="bg-button-color hover:bg-button-hover text-white font py-2 px-4 rounded ml-auto">
                                Agregar Colonia
                            </button>
                        </div>
                        



                        <!-- Tabla de colonias -->
                        <div class="overflow-x-auto bg-white dark:bg-neutral-700">
                            <table id="coloniasTable" class="display nowrap w-full shadow-md rounded-lg overflow-hidden" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Código Postal</th>
                                        <th>Tipo de Asentamiento</th>
                                        <th>Asentamiento</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Las filas se agregarán dinámicamente después de filtrar -->
                                </tbody>
                            </table>
                        </div>                    
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para Agregar Colonia -->
        <div id="addColoniaModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
            <div class="flex items-center justify-center min-h-screen">
                <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity" aria-hidden="true"></div>
                <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full" style="margin: 50px 0;">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <h3 class="text-2xl leading-6 font-bold text-center text-gray-900 w-full" style="color: #316986;">
                                Agregar Colonia
                            </h3>
                            <button type="button" class="absolute top-0 right-0 mt-4 mr-4 text-gray-400 hover:text-gray-500 text-4xl" id="closeAddColoniaModal">
                                &times;
                            </button>
                        </div>
                        <div class="border-t border-gray-200 mt-4"></div>
                        <div class="mt-2">
                            @include('medico.catalogos.colonias.agregarColonia')
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para Editar Colonia -->
        <div id="editColoniaModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
            <div class="flex items-center justify-center min-h-screen">
                <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity" aria-hidden="true"></div>
                <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full" style="margin: 50px 0;">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <h3 class="text-2xl leading-6 font-bold text-center text-gray-900 w-full" style="color: #316986;">
                                Editar Colonia
                            </h3>
                            <button type="button" class="absolute top-0 right-0 mt-4 mr-4 text-gray-400 hover:text-gray-500 text-4xl" id="closeEditColoniaModal">
                                &times;
                            </button>
                        </div>
                        <div class="border-t border-gray-200 mt-4"></div>
                        <div class="mt-2">
                            <form id="editColoniaForm" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mt-4">
                                    <label for="editAsentamiento" class="block text-sm font-medium text-gray-700">Asentamiento</label>
                                    <input type="text" id="editAsentamiento" name="asentamiento" class="mt-1 p-2 w-full border rounded-md" required>
                                </div>

                                <div class="mt-4">
                                    <label for="editTipoAsentamiento" class="block text-sm font-medium text-gray-700">Tipo de Asentamiento</label>
                                    <input type="text" id="editTipoAsentamiento" name="tipo_asentamiento" class="mt-1 p-2 w-full border rounded-md" required>
                                </div>

                                <div class="mt-4">
                                    <label for="editCp" class="block text-sm font-medium text-gray-700">Código Postal</label>
                                    <input type="text" id="editCp" name="cp" class="mt-1 p-2 w-full border rounded-md" required>
                                </div>

                                <!-- Campos hidden para IDs -->
                                <input type="hidden" id="editIdAsentamiento" name="id_asentamiento">
                                <input type="hidden" id="editIdEntidad" name="id_entidad">
                                <input type="hidden" id="editIdMunicipio" name="id_municipio">

                                <div class="flex items-center justify-end mt-4">
                                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">Actualizar Colonia</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: '{{ session("success") }}',
                showConfirmButton: false,
                timer: 2000
            });
        </script>
        @endif

        @if(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: '{{ session("error") }}',
                showConfirmButton: false,
                timer: 2000
            });
        </script>
        @endif

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Abrir modal
                document.getElementById('openAddColoniaModal').addEventListener('click', function() {
                    document.getElementById('addColoniaModal').classList.remove('hidden');
                    document.getElementById('addColoniaModal').style.display = 'block';
                });
        
                // Cerrar modal
                document.getElementById('closeAddColoniaModal').addEventListener('click', function() {
                    document.getElementById('addColoniaModal').classList.add('hidden');
                    document.getElementById('addColoniaModal').style.display = 'none';
                });
            });

            // Función para eliminar una colonia con SweetAlert
            function confirmarEliminarColonia(id_asentamiento, id_entidad, id_municipio) {
                Swal.fire({
                    title: '¿Estás seguro de eliminar esta colonia?',
                    text: "¡No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Crear un formulario dinámico para enviar la solicitud de eliminación
                        var form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `/colonias/${id_asentamiento}/${id_entidad}/${id_municipio}`;

                        // Agregar token CSRF y el campo _method para la petición DELETE
                        var csrfField = document.createElement('input');
                        csrfField.type = 'hidden';
                        csrfField.name = '_token';
                        csrfField.value = '{{ csrf_token() }}'; // Laravel CSRF token
                        form.appendChild(csrfField);

                        var methodField = document.createElement('input');
                        methodField.type = 'hidden';
                        methodField.name = '_method';
                        methodField.value = 'DELETE';
                        form.appendChild(methodField);

                        // Agregar el formulario al body y enviarlo
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            }




            function openEditColoniaModal(id_asentamiento, id_entidad, id_municipio) {
                // Hacer una petición para obtener los datos de la colonia
                fetch(`/colonias/${id_asentamiento}/${id_entidad}/${id_municipio}/edit`)
                    .then(response => response.json())
                    .then(data => {
                        // Rellenar el formulario con los datos obtenidos
                        document.getElementById('editAsentamiento').value = data.asentamiento;
                        document.getElementById('editTipoAsentamiento').value = data.tipo_asentamiento;
                        document.getElementById('editCp').value = data.cp;
                        document.getElementById('editIdAsentamiento').value = data.id_asentamiento;
                        document.getElementById('editIdEntidad').value = data.id_entidad;
                        document.getElementById('editIdMunicipio').value = data.id_municipio;

                        // Actualizar la acción del formulario para apuntar a la ruta de actualización correcta
                        document.getElementById('editColoniaForm').action = `/colonias/${id_asentamiento}/${id_entidad}/${id_municipio}`;
                        
                        // Mostrar el modal
                        document.getElementById('editColoniaModal').classList.remove('hidden');
                        document.getElementById('editColoniaModal').style.display = 'block';
                    })
                    .catch(error => console.error('Error al obtener los datos de la colonia:', error));
            }

            // Cerrar el modal de edición
            document.getElementById('closeEditColoniaModal').addEventListener('click', function() {
                document.getElementById('editColoniaModal').classList.add('hidden');
                document.getElementById('editColoniaModal').style.display = 'none';
            });

            document.getElementById('editColoniaForm').action = `/colonias/${id_asentamiento}/${id_entidad}/${id_municipio}`;

            document.getElementById('editColoniaForm').addEventListener('submit', function(event) {
                event.preventDefault(); // Prevenir el comportamiento por defecto del formulario

                // Realizar la solicitud para actualizar la colonia
                const form = event.target;
                const formData = new FormData(form);

                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Colonia actualizada exitosamente.');
                        // Cerrar el modal y refrescar los datos
                        $('#editColoniaModal').modal('hide');
                        location.reload(); // Recargar la página o la tabla
                    } else {
                        alert('Error al actualizar la colonia.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        </script>
        
        <script>
            document.getElementById('entidadSelect').addEventListener('change', function() {
                const entidadId = this.value;
                const municipioSelect = document.getElementById('municipioSelect');
                const applyButton = document.getElementById('applyFilters');
                municipioSelect.disabled = !entidadId;
                applyButton.disabled = true;
        
                if (entidadId) {
                    fetch(`/api/municipios/${entidadId}`)
                        .then(response => response.json())
                        .then(municipios => {
                            municipioSelect.innerHTML = '<option value="">Seleccione un Municipio</option>';
                            municipios.forEach(municipio => {
                                municipioSelect.innerHTML += `<option value="${municipio.id_municipio}">${municipio.nombre}</option>`;
                            });
                        });
                } else {
                    municipioSelect.innerHTML = '<option value="">Seleccione un Municipio</option>';
                }
            });
        
            document.getElementById('municipioSelect').addEventListener('change', function() {
                const applyButton = document.getElementById('applyFilters');
                applyButton.disabled = !this.value;
            });
        
            document.getElementById('applyFilters').addEventListener('click', function() {
                const entidadId = document.getElementById('entidadSelect').value;
                const municipioId = document.getElementById('municipioSelect').value;

                if (municipioId && entidadId) {
                    $('#coloniasTable').DataTable({
                        "dom": '<"row"<"col-sm-12 col-md-6"lB><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
                        "buttons": [
                            {
                                extend: 'copy',
                                text: 'Copiar',
                                exportOptions: {
                                    columns: ':not(:last-child)',
                                    modifier: {
                                        search: 'none',
                                        order: 'applied',
                                        page: 'all'
                                    }
                                }
                            },
                            {
                                extend: 'csv',
                                exportOptions: {
                                    columns: ':not(:last-child)',
                                    modifier: {
                                        search: 'none',
                                        order: 'applied',
                                        page: 'all'
                                    }
                                }
                            },
                            {
                                extend: 'excel',
                                exportOptions: {
                                    columns: ':not(:last-child)',
                                    modifier: {
                                        search: 'none',
                                        order: 'applied',
                                        page: 'all'
                                    }
                                }
                            },
                            {
                                extend: 'pdf',
                                text: 'PDF',
                                title: 'Listado de Colonias',
                                exportOptions: {
                                    columns: ':not(:last-child)',
                                    modifier: {
                                        search: 'none',
                                        order: 'applied',
                                        page: 'all'
                                    }
                                }
                            },
                            {
                                extend: 'print',
                                text: 'Imprimir',
                                exportOptions: {
                                    columns: ':not(:last-child)',
                                    modifier: {
                                        search: 'none',
                                        order: 'applied',
                                        page: 'all'
                                    }
                                }
                            }
                        ],
                        "processing": true,
                        "serverSide": true,
                        "destroy": true,
                        "ajax": {
                            "url": `/api/colonias/${municipioId}`,
                            "data": {
                                "entidad_id": entidadId
                            },
                            "dataType": "json",
                            "type": "GET"
                        },
                        "columns": [
                            { "data": "cp" },
                            { "data": "tipo_asentamiento" },
                            { "data": "asentamiento" },
                            { "data": "acciones" }
                        ],
                        "language": {
                            "processing": `
                            <button type="button" class="bg-[#2D7498] text-white font-bold py-2 px-4 rounded inline-flex items-center" disabled>
                                <svg class="animate-spin h-5 w-5 mr-3 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v2a6 6 0 00-6 6H4z"></path>
                                </svg>
                            Procesando ...
                            </button>
                            `
                        },
                        "paging": true,
                        "searching": true,
                        "info": true,
                        "pageLength": 10,
                        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                        "scrollX": false,
                        "autoWidth": true
                    });

                }
            });

            function editarColonia(id) {
                // Redirigir a la página de edición
                window.location.href = `/colonias/${id}/editar`;
            }

            function eliminarColonia(id) {
                if (confirm('¿Estás seguro de eliminar esta colonia?')) {
                    fetch(`/colonias/${id}/eliminar`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    }).then(response => {
                        if (response.ok) {
                            alert('Colonia eliminada exitosamente.');
                            $('#coloniasTable').DataTable().ajax.reload();
                        } else {
                            alert('Hubo un problema al eliminar la colonia.');
                        }
                    });
                }
            }

            function consultarColonia(id) {
                // Lógica para consultar la colonia
                alert(`Consultando información de la colonia con ID: ${id}`);
            }

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
        
        <!-- Importa jQuery antes de cualquier otra librería -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

        <!-- DataTables JS y CSS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
        <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

        <!-- Botones de exportación para DataTables -->
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.bootstrap4.min.css">
        <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.bootstrap4.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
    </x-app-layout>

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

        #addColoniaModal {
            display: none;
        }
        #addColoniaModal.active {
            display: block;
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

        a {
            text-decoration: none;
        }

    </style>
