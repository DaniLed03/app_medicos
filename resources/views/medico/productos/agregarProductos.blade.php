<form id="addProductoForm" action="{{ route('productos.store') }}" method="POST">
    @csrf
    <div class="mt-4">
        <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
        <input type="text" id="nombre" name="nombre" class="mt-1 p-2 w-full border rounded-md" required>
    </div>
    <div class="mt-4">
        <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
        <textarea id="descripcion" name="descripcion" class="mt-1 p-2 w-full border rounded-md"></textarea>
    </div>
    <div class="mt-4">
        <label for="inventario" class="block text-sm font-medium text-gray-700">Inventario</label>
        <input type="number" id="inventario" name="inventario" class="mt-1 p-2 w-full border rounded-md" required>
    </div>
    <div class="mt-4">
        <label for="precio" class="block text-sm font-medium text-gray-700">Precio</label>
        <input type="number" step="0.01" id="precio" name="precio" class="mt-1 p-2 w-full border rounded-md" required>
    </div>
    <div class="flex items-center justify-end mt-4">
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">Guardar Producto</button>
    </div>
</form>
