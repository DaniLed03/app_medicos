<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Secretaria') }}
        </h2>
    </x-slot>

    <div class="container mx-auto mt-8">
        <div class="max-w-md mx-auto bg-white rounded-lg overflow-hidden shadow-md">
            <div class="px-6 py-4">
                <form method="POST" action="{{ route('secretarias.update', $secretaria->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="nombres" class="block text-gray-700">Nombres:</label>
                        <input type="text" name="nombres" id="nombres" class="w-full px-3 py-2 border rounded" value="{{ $secretaria->nombres }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="apepat" class="block text-gray-700">Apellido Paterno:</label>
                        <input type="text" name="apepat" id="apepat" class="w-full px-3 py-2 border rounded" value="{{ $secretaria->apepat }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="apemat" class="block text-gray-700">Apellido Materno:</label>
                        <input type="text" name="apemat" id="apemat" class="w-full px-3 py-2 border rounded" value="{{ $secretaria->apemat }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="fechanac" class="block text-gray-700">Fecha de Nacimiento:</label>
                        <input type="date" name="fechanac" id="fechanac" class="w-full px-3 py-2 border rounded" value="{{ $secretaria->fechanac }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="telefono" class="block text-gray-700">Teléfono:</label>
                        <input type="text" name="telefono" id="telefono" class="w-full px-3 py-2 border rounded" value="{{ $secretaria->telefono }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700">Correo Electrónico:</label>
                        <input type="email" name="email" id="email" class="w-full px-3 py-2 border rounded" value="{{ $secretaria->email }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="block text-gray-700">Contraseña:</label>
                        <input type="password" name="password" id="password" class="w-full px-3 py-2 border rounded">
                    </div>
                    <div class="mb-4">
                        <label for="password_confirmation" class="block text-gray-700">Confirmar Contraseña:</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-3 py-2 border rounded">
                    </div>
                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Actualizar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
