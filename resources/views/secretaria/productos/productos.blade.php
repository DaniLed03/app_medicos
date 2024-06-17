<x-app-layout>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto bg-white dark:bg-neutral-700">
                        <div class="flex my-4 mx-4 items-center justify-between">
                            <h1 class="text-xl font-bold text-gray-900 uppercase">Lista de Productos</h1>
                            <a href="{{ route('productos.agregar') }}">
                                <x-primary-button class="bg-button-color hover:bg-button-hover">
                                    {{ __('Agregar Producto') }}
                                </x-primary-button>
                            </a>
                        </div>
                        <!-- Table -->
                        <table class="min-w-full text-center text-sm whitespace-nowrap">
                            <!-- Table head -->
                            <thead class="uppercase tracking-wider border-b-2 dark:border-neutral-600 bg-custom-color text-white font-bold">
                                <tr>
                                    <th scope="col" class="px-6 py-4">Nombre</th>
                                    <th scope="col" class="px-6 py-4">Precio</th>
                                    <th scope="col" class="px-6 py-4">Activo</th>
                                    <th scope="col" class="px-6 py-4">Acciones</th>
                                </tr>
                            </thead>

                            <!-- Table body -->
                            <tbody>
                                @foreach($productos as $producto)
                                    <tr class="border-b dark:border-neutral-600">
                                        <td class="px-6 py-4">{{ $producto->nombre }}</td>
                                        <td class="px-6 py-4">{{ $producto->precio }}</td>
                                        <td class="px-6 py-4">{{ $producto->activo }}</td>
                                        <td class="px-6 py-4">
                                            <!-- Enlace para editar el producto -->
                                            <a href="{{ route('productos.editar', $producto->id) }}" class="text-blue-500 hover:text-blue-700">Editar</a>
                                            <!-- Formulario para eliminar el producto -->
                                            <form action="{{ route('productos.eliminar', $producto->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 ml-4">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- Mensaje si no hay productos registrados -->
                        @if($productos->isEmpty())
                            <p class="text-center text-gray-500 mt-4">No hay productos registrados.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<style>
    .bg-custom-color {
        background-color: #2D7498;
    }
    .bg-button-color {
        background-color: #33AD9B;
    }
    .hover\:bg-button-hover:hover {
        background-color: #278A75;
    }
</style>
