<x-app-layout>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg"> <!-- Añadido shadow-lg para la sombra -->
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto bg-white dark:bg-neutral-700">
                        <div class="flex my-4 mx-4 items-center justify-between">
                            <h1 class="text-xl font-bold text-gray-900 uppercase">Lista de Médicos</h1>
                            <a href="{{ route('medicos.agregar') }}">
                                <x-primary-button class="bg-button-color hover:bg-button-hover">
                                    {{ __('Agregar Médico') }}
                                </x-primary-button>
                            </a>
                        </div>
                        <!-- Table -->
                        <table class="min-w-full text-center text-sm whitespace-nowrap">
                            <!-- Table head -->
                            <thead class="uppercase tracking-wider border-b-2 dark:border-neutral-600 bg-table-header-color text-white font-bold">
                                <tr>
                                    <th scope="col" class="px-6 py-4">Nombre</th>
                                    <th scope="col" class="px-6 py-4">Apellido Paterno</th>
                                    <th scope="col" class="px-6 py-4">Apellido Materno</th>
                                    <th scope="col" class="px-6 py-4">Correo</th>
                                    <th scope="col" class="px-6 py-4">Teléfono</th>
                                    <th scope="col" class="px-6 py-4">Activo</th>
                                    <th scope="col" class="px-6 py-4">Acciones</th>
                                </tr>
                            </thead>

                            <!-- Table body -->
                            <tbody>
                                @foreach($medicos as $medico)
                                    <tr class="border-b dark:border-neutral-600">
                                        <td class="px-6 py-4">{{ $medico->nombres }}</td>
                                        <td class="px-6 py-4">{{ $medico->apepat }}</td>
                                        <td class="px-6 py-4">{{ $medico->apemat }}</td>
                                        <td class="px-6 py-4">{{ $medico->email }}</td>
                                        <td class="px-6 py-4">{{ $medico->telefono }}</td>
                                        <td class="px-6 py-4">{{ $medico->activo }}</td>
                                        <td class="px-6 py-4">
                                            <!-- Enlace para editar el médico -->
                                            <a href="{{ route('medicos.editar', $medico->id) }}" class="text-blue-500 hover:underline">Editar</a>
                                            <!-- Formulario para eliminar el médico -->
                                            <form action="{{ route('medicos.eliminar', $medico->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:underline ml-2">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- Mensaje si no hay médicos registrados -->
                        @if($medicos->isEmpty())
                            <p class="text-center text-gray-500 mt-4">No hay médicos registrados.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

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
