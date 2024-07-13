<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Listado de Secretarias') }}
        </h2>
    </x-slot>

    <div class="container mx-auto mt-8">
        <div class="bg-white rounded-lg shadow-md">
            <div class="px-6 py-4">
                <a href="{{ route('secretarias.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">Agregar Secretaria</a>
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b">Nombres</th>
                            <th class="py-2 px-4 border-b">Apellido Paterno</th>
                            <th class="py-2 px-4 border-b">Apellido Materno</th>
                            <th class="py-2 px-4 border-b">Correo Electrónico</th>
                            <th class="py-2 px-4 border-b">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($secretarias as $secretaria)
                        <tr>
                            <td class="py-2 px-4 border-b">{{ $secretaria->nombres }}</td>
                            <td class="py-2 px-4 border-b">{{ $secretaria->apepat }}</td>
                            <td class="py-2 px-4 border-b">{{ $secretaria->apemat }}</td>
                            <td class="py-2 px-4 border-b">{{ $secretaria->email }}</td>
                            <td class="py-2 px-4 border-b">
                                <a href="{{ route('secretarias.edit', $secretaria->id) }}" class="text-blue-600 hover:text-blue-800">Editar</a>
                                <form action="{{ route('secretarias.destroy', $secretaria->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 ml-2">Eliminar</button>
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

