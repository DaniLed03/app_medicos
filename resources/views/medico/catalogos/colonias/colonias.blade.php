<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Colonias') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex justify-end mb-4">
                    <a href="{{ route('colonias.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Agregar Colonia</a>
                </div>

                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-2">Asentamiento</th>
                            <th class="py-2">Tipo</th>
                            <th class="py-2">Código Postal</th>
                            <th class="py-2">Municipio</th>
                            <th class="py-2">Entidad</th>
                            <th class="py-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($colonias as $colonia)
                            <tr>
                                <td class="border px-4 py-2">{{ $colonia->asentamiento }}</td>
                                <td class="border px-4 py-2">{{ $colonia->tipo_asentamiento }}</td>
                                <td class="border px-4 py-2">{{ $colonia->cp }}</td>
                                <td class="border px-4 py-2">{{ $colonia->municipio->nombre }}</td>
                                <td class="border px-4 py-2">{{ $colonia->entidad->nombre }}</td>
                                <td class="border px-4 py-2 flex space-x-2">
                                    <a href="{{ route('colonias.edit', [$colonia->id_asentamiento, $colonia->id_entidad, $colonia->id_municipio]) }}" class="bg-yellow-500 text-white px-4 py-2 rounded">Editar</a>
                                    <form action="{{ route('colonias.destroy', [$colonia->id_asentamiento, $colonia->id_entidad, $colonia->id_municipio]) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta colonia?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
