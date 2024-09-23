<x-app-layout>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-xl font-bold text-gray-900 uppercase">Listado de Usuarios</h1>
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-4">
                            <!-- Contenedor de Total Usuarios -->
                            <div class="bg-white p-4 shadow-2xl rounded-md flex items-center space-x-4">
                                <div class="bg-icon-color p-2 rounded-full">
                                    <svg class="w-8 h-8 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M12 6a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7Zm-1.5 8a4 4 0 0 0-4 4 2 2 0 0 0 2 2h7a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-3Zm6.82-3.096a5.51 5.51 0 0 0-2.797-6.293 3.5 3.5 0 1 1 2.796 6.292ZM19.5 18h.5a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-1.1a5.503 5.503 0 0 1-.471.762A5.998 5.998 0 0 1 19.5 18ZM4 7.5a3.5 3.5 0 0 1 5.477-2.889 5.5 5.5 0 0 0-2.796 6.293A3.501 3.501 0 0 1 4 7.5ZM7.1 12H6a4 4 0 0 0-4 4 2 2 0 0 0 2 2h.5a5.998 5.998 0 0 1 3.071-5.238A5.505 5.505 0 0 1 7.1 12Z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="text-center">
                                    <h2 class="text-lg font-bold">Total Usuarios: {{ $totalUsers }}</h2>
                                </div>
                            </div>
                            <!-- Contenedor de Mujeres y Hombres -->
                            <div class="flex items-center space-x-4">
                                <div class="bg-white p-4 shadow-2xl rounded-md flex items-center space-x-4">
                                    <div class="bg-icon-color p-2 rounded-full">
                                        <img src="{{ asset('images/woman.svg') }}" class="w-8 h-8 text-white" alt="Icono de Mujer">
                                    </div>
                                    <div class="text-center">
                                        <h2 class="text-lg font-bold">Mujeres: {{ number_format($porcentajeMujeres, 1) }}%</h2>
                                    </div>
                                    <div class="bg-icon-color p-2 rounded-full">
                                        <img src="{{ asset('images/man.svg') }}" class="w-8 h-8 text-white" alt="Icono de Hombre">
                                    </div>
                                    <div class="text-center">
                                        <h2 class="text-lg font-bold">Hombres: {{ number_format($porcentajeHombres, 1) }}%</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <button id="openModal" class="bg-button-color hover:bg-button-hover text-white font py-2 px-4 rounded">
                                Agregar Usuario
                            </button>
                        </div>
                    </div>
                    
                    <!-- Tabla de usuarios -->
                    <div class="overflow-x-auto bg-white dark:bg-neutral-700">
                        <table id="usersTable" class="display nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Rol</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->nombres }} {{ $user->apepat }} {{ $user->apemat }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->roles->pluck('name')->join(', ') }}</td>
                                        <td>
                                            <a href="{{ route('users.edit', $user->id) }}" class="text-blue-500 hover:text-blue-700">Editar</a>
                                            @if(!$user->roles->contains('name', 'Administrador'))
                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700 ml-4">Eliminar</button>
                                                </form>
                                            @endif
                                            <form action="{{ route('users.resetPassword', $user->id) }}" method="POST" class="inline-block reset-password-form">
                                                @csrf
                                                <button type="button" class="text-yellow-500 hover:text-yellow-700 ml-4 reset-password-button">Restablecer Contraseña</button>
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

    <!-- Modal Agregar Usuario -->
    <div id="modal" class="fixed z-10 inset-0 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity" aria-hidden="true"></div>
            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full" style="margin: 50px 0; height: auto;">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="sm:flex sm:items-center w-full">
                            <h3 class="text-2xl leading-6 font-bold text-center text-gray-900 w-full" style="color: #316986;">
                                Agregar Usuario
                            </h3>
                            <button type="button" class="absolute top-0 right-0 mt-4 mr-4 text-gray-400 hover:text-gray-500 text-4xl" id="closeModal">
                                <span class="sr-only">Close</span>
                                &times;
                            </button>
                        </div>
                    </div>
                    <div class="border-t border-gray-200 mt-4"></div>
                    <div class="mt-2">
                        <form method="POST" action="{{ route('users.store') }}" id="addUserForm">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Nombres -->
                                <div class="mt-4">
                                    <x-input-label for="nombres" :value="__('Nombres')" />
                                    <x-text-input id="nombres" class="block mt-1 w-full uppercase-input" type="text" name="nombres" :value="old('nombres')" required autofocus autocomplete="name" />
                                    <x-input-error :messages="$errors->get('nombres')" class="mt-2" />
                                </div>
                                
                                <!-- Apellido Paterno -->
                                <div class="mt-4">
                                    <x-input-label for="apepat" :value="__('Apellido Paterno')" />
                                    <x-text-input id="apepat" class="block mt-1 w-full uppercase-input" type="text" name="apepat" :value="old('apepat')" required autofocus autocomplete="name" />
                                    <x-input-error :messages="$errors->get('apepat')" class="mt-2" />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Apellido Materno -->
                                <div class="mt-4">
                                    <x-input-label for="apemat" :value="__('Apellido Materno')" />
                                    <x-text-input id="apemat" class="block mt-1 w-full uppercase-input" type="text" name="apemat" :value="old('apemat')" required autofocus autocomplete="name" />
                                    <x-input-error :messages="$errors->get('apemat')" class="mt-2" />
                                </div>

                                <!-- Fecha de Nacimiento -->
                                <div class="mt-4">
                                    <x-input-label for="fechanac" :value="__('Fecha de Nacimiento')" />
                                    <x-text-input id="fechanac" class="block mt-1 w-full" type="date" name="fechanac" :value="old('fechanac')" required autofocus />
                                    <x-input-error :messages="$errors->get('fechanac')" class="mt-2" />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Teléfono -->
                                <div class="mt-4">
                                    <x-input-label for="telefono" :value="__('Teléfono')" />
                                    <x-text-input id="telefono" class="block mt-1 w-full uppercase-input" type="text" name="telefono" :value="old('telefono')" required autofocus />
                                    <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
                                </div>
                            
                                <!-- Sexo -->
                                <div class="mt-4 md:col-span-1">
                                    <x-input-label for="sexo" :value="__('Sexo')" />
                                    <div class="flex items-center space-x-4">
                                        <div class="flex items-center">
                                            <input type="radio" id="masculino" name="sexo" value="masculino" class="mr-2" required>
                                            <label for="masculino" class="text-sm font-medium text-gray-700">Masculino</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="radio" id="femenino" name="sexo" value="femenino" class="mr-2" required>
                                            <label for="femenino" class="text-sm font-medium text-gray-700">Femenino</label>
                                        </div>
                                    </div>
                                    <x-input-error :messages="$errors->get('sexo')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="mt-4">
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <x-primary-button class="ml-4">
                                    {{ __('Registrar Usuario') }}
                                </x-primary-button>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


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
    document.querySelectorAll('.reset-password-button').forEach(button => {
        button.addEventListener('click', function() {
            const form = this.closest('.reset-password-form');
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¿Deseas restablecer la contraseña de este usuario?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, restablecer',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            })
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#usersTable').DataTable({
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
                    title: 'Listado de Usuarios',
                    exportOptions: {
                        columns: ':not(:last-child)' // Excluye la última columna (Acciones)
                    }
                },
                {
                    extend: 'excel',
                    text: 'Excel',
                    title: 'Listado de Usuarios',
                    exportOptions: {
                        columns: ':not(:last-child)' // Excluye la última columna (Acciones)
                    }
                },
                {
                    extend: 'pdf',
                    text: 'PDF',
                    title: 'Listado de Usuarios',
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
                "emptyTable": "No hay usuarios registrados",
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

        document.getElementById('openModal').addEventListener('click', function() {
            document.getElementById('modal').classList.remove('hidden');
        });

        document.getElementById('closeModal').addEventListener('click', function() {
            document.getElementById('modal').classList.add('hidden');
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
    .dataTables_wrapper .dataTables_scrollBody {
        overflow-x: hidden;
        overflow-y: hidden;
    }
</style>
