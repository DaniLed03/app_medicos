<x-app-layout>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto bg-white dark:bg-neutral-700">
                        <div class="flex my-4 mx-4 items-center justify-between">
                            <h1 class="text-xl font-bold text-gray-900 uppercase">Lista de Consultas</h1>
                        </div>
                        <!-- Table -->
                        <table class="min-w-full text-center text-sm whitespace-nowrap">
                            <!-- Table head -->
                            <thead class="uppercase tracking-wider border-b-2 dark:border-neutral-600 bg-table-header-color">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-white font-bold">ID</th>
                                    <th scope="col" class="px-6 py-4 text-white font-bold">Fecha y Hora</th>
                                    <th scope="col" class="px-6 py-4 text-white font-bold">Paciente</th>
                                    <th scope="col" class="px-6 py-4 text-white font-bold">Diagnóstico</th>
                                    <th scope="col" class="px-6 py-4 text-white font-bold">Recete</th>
                                    <th scope="col" class="px-6 py-4 text-white font-bold">Total a Pagar</th>
                                    <th scope="col" class="px-6 py-4 text-white font-bold">Acciones</th>
                                </tr>
                            </thead>

                            <!-- Table body -->
                            <tbody>
                                @foreach($consultas as $consulta)
                                    <tr>
                                        <td class="px-6 py-4">{{ $consulta->id }}</td>
                                        <td class="px-6 py-4">{{ $consulta->fechaHora }}</td>
                                        <td class="px-6 py-4">{{ $consulta->cita->paciente->nombres }} {{ $consulta->cita->paciente->apepat}} {{ $consulta->cita->paciente->apemat}}</td>
                                        <td class="px-6 py-4">{{ $consulta->diagnostico }}</td>
                                        <td class="px-6 py-4">{{ $consulta->recete }}</td>
                                        <td class="px-6 py-4">${{ $consulta->totalPagar }}</td>
                                        <td class="px-6 py-4">
                                            <a href="{{ route('consultas.edit', $consulta->id) }}" class="text-blue-500 hover:text-blue-700">Editar</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- Mensaje si no hay consultas registradas -->
                        @if($consultas->isEmpty())
                            <p class="text-center text-gray-500 mt-4">No hay consultas registradas.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<style>
    .bg-table-header-color {
        background-color: #2D7498;
    }
</style>
