<x-app-layout>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto bg-white dark:bg-neutral-700">
                        <div class="flex my-4 mx-4 items-center justify-between">
                            <h1 class="text-xl font-bold text-gray-900 uppercase">Lista de Pacientes</h1>
                            <a href="{{ route('agregarPaciente') }}">
                                <x-primary-button class="bg-button-color hover:bg-button-hover">
                                    {{ __('Agregar Paciente') }}
                                </x-primary-button>
                            </a>
                        </div>
                        <!-- Table -->
                        <table class="min-w-full text-center text-sm whitespace-nowrap">
                            <!-- Table head -->
                            <thead class="uppercase tracking-wider border-b-2 dark:border-neutral-600 bg-table-header-color">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-white font-bold">Nombres</th>
                                    <th scope="col" class="px-6 py-4 text-white font-bold">Apellido Paterno</th>
                                    <th scope="col" class="px-6 py-4 text-white font-bold">Apellido Materno</th>
                                    <th scope="col" class="px-6 py-4 text-white font-bold">Activo</th>
                                    <th scope="col" class="px-6 py-4 text-white font-bold">Acciones</th>
                                </tr>
                            </thead>

                            <!-- Table body -->
                            <tbody>
                                @foreach($pacientes as $paciente)
                                    <tr>
                                        <td class="px-6 py-4">{{ $paciente->nombres }}</td>
                                        <td class="px-6 py-4">{{ $paciente->apepat }}</td>
                                        <td class="px-6 py-4">{{ $paciente->apemat }}</td>
                                        <td class="px-6 py-4">{{ $paciente->activo }}</td>
                                        <td class="px-6 py-4">
                                            <!-- Enlace para editar el paciente -->
                                            <a href="{{ route('pacientes.editar', $paciente->id) }}" class="text-blue-500 hover:text-blue-700">Editar</a>
                                            <!-- Formulario para eliminar el paciente -->
                                            <form action="{{ route('pacientes.eliminar', $paciente->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 ml-4">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- Mensaje si no hay pacientes registrados -->
                        @if($pacientes->isEmpty())
                            <p class="text-center text-gray-500 mt-4">No hay citas registradas.</p>
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
