<x-app-layout>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto bg-white dark:bg-neutral-700">
                        <div class="flex my-4 mx-4 items-center justify-between">
                            <h1 class="text-xl font-bold text-gray-900 uppercase">Lista de Enfermeras</h1>
                            <button id="openModalAgregar" class="bg-button-color hover:bg-button-hover text-white py-2 px-4 rounded">
                                Agregar Enfermera
                            </button>
                        </div>
                        <!-- Table -->
                        <table class="min-w-full text-center text-sm whitespace-nowrap">
                            <!-- Table head -->
                            <thead class="uppercase tracking-wider border-b-2 dark:border-neutral-600 bg-table-header-color text-white font-bold">
                                <tr>
                                    <th scope="col" class="px-6 py-4">ID</th>
                                    <th scope="col" class="px-6 py-4">Nombres</th>
                                    <th scope="col" class="px-6 py-4">Apellido Paterno</th>
                                    <th scope="col" class="px-6 py-4">Apellido Materno</th>
                                    <th scope="col" class="px-6 py-4">Fecha de Nacimiento</th>
                                    <th scope="col" class="px-6 py-4">Teléfono</th>
                                    <th scope="col" class="px-6 py-4">Email</th>
                                    <th scope="col" class="px-6 py-4">Acciones</th>
                                </tr>
                            </thead>

                            <!-- Table body -->
                            <tbody>
                                @foreach($enfermeras as $enfermera)
                                    <tr class="border-b dark:border-neutral-600">
                                        <td class="px-6 py-4">{{ $enfermera->id }}</td>
                                        <td class="px-6 py-4">{{ $enfermera->nombres }}</td>
                                        <td class="px-6 py-4">{{ $enfermera->apepat }}</td>
                                        <td class="px-6 py-4">{{ $enfermera->apemat }}</td>
                                        <td class="px-6 py-4">{{ $enfermera->fechanac }}</td>
                                        <td class="px-6 py-4">{{ $enfermera->telefono }}</td>
                                        <td class="px-6 py-4">{{ $enfermera->email }}</td>
                                        <td class="px-6 py-4">
                                            <!-- Enlace para editar la enfermera -->
                                            <a href="#" data-id="{{ $enfermera->id }}" class="text-blue-500 hover:underline editarEnfermera">Editar</a>
                                            <!-- Formulario para eliminar la enfermera -->
                                            <form action="{{ route('enfermeras.destroy', $enfermera->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:underline ml-2">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- Mensaje si no hay enfermeras registradas -->
                        @if($enfermeras->isEmpty())
                            <p class="text-center text-gray-500 mt-4">No hay enfermeras registradas.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para agregar enfermera -->
    <div id="modalAgregar" class="fixed z-10 inset-0 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity" aria-hidden="true"></div>
            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="sm:flex sm:items-center w-full">
                            <h3 class="text-2xl leading-6 font-bold text-center text-gray-900 w-full" style="color: #316986;">
                                Agregar Enfermera
                            </h3>
                            <button type="button" class="absolute top-0 right-0 mt-4 mr-4 text-gray-400 hover:text-gray-500 text-2xl" id="closeModalAgregar">
                                <span class="sr-only">Close</span>
                                &times;
                            </button>
                        </div>
                    </div>
                    <div class="border-t border-gray-200 mt-4"></div>
                    <div class="mt-2">
                        @include('medico.enfermeras.agregarEnfermera')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para editar enfermera -->
    <div id="modalEditar" class="fixed z-10 inset-0 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity" aria-hidden="true"></div>
            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="sm:flex sm:items-center w-full">
                            <h3 class="text-2xl leading-6 font-bold text-center text-gray-900 w-full" style="color: #316986;">
                                Editar Enfermera
                            </h3>
                            <button type="button" class="absolute top-0 right-0 mt-4 mr-4 text-gray-400 hover:text-gray-500 text-2xl" id="closeModalEditar">
                                <span class="sr-only">Close</span>
                                &times;
                            </button>
                        </div>
                    </div>
                    <div class="border-t border-gray-200 mt-4"></div>
                    <div class="mt-2" id="formEditarEnfermera">
                        <!-- El formulario de edición se cargará aquí -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.getElementById('openModalAgregar').addEventListener('click', function() {
        document.getElementById('modalAgregar').classList.remove('hidden');
    });

    document.getElementById('closeModalAgregar').addEventListener('click', function() {
        document.getElementById('modalAgregar').classList.add('hidden');
    });

    document.querySelectorAll('.editarEnfermera').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const id = this.getAttribute('data-id');
            fetch(`/enfermeras/${id}/edit`)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('formEditarEnfermera').innerHTML = html;
                    document.getElementById('modalEditar').classList.remove('hidden');
                });
        });
    });

    document.getElementById('closeModalEditar').addEventListener('click', function() {
        document.getElementById('modalEditar').classList.add('hidden');
    });
</script>

<style>
    .bg-button-color {
        background-color: #33AD9B;
    }
    .hover\:bg-button-hover:hover {
        background-color: #278A75;
    }
    .bg-table-header-color {
        background-color: #2D7498;
    }
</style>
