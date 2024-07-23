<form method="POST" action="{{ route('productos.store') }}">
    @csrf

    <!-- Nombre del Producto -->
    <div class="mt-4 col-span-2">
        <x-input-label for="nombre" :value="__('Nombre del Producto')" />
        <x-text-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre')" required autofocus />
        <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
    </div>

    <!-- Precio y Cantidad en la misma línea -->
    <div class="mt-4 col-span-2 grid grid-cols-2 gap-4">
        <!-- Precio -->
        <div>
            <x-input-label for="precio" :value="__('Precio')" />
            <x-text-input id="precio" class="block mt-1 w-full" type="number" step="0.01" name="precio" :value="old('precio')" required />
            <x-input-error :messages="$errors->get('precio')" class="mt-2" />
        </div>

        <!-- Cantidad -->
        <div>
            <x-input-label for="cantidad" :value="__('Cantidad')" />
            <x-text-input id="cantidad" class="block mt-1 w-full" type="number" name="cantidad" :value="old('cantidad')" required />
            <x-input-error :messages="$errors->get('cantidad')" class="mt-2" />
        </div>
    </div>

    <!-- Descripción -->
    <div class="mt-4 col-span-2">
        <x-input-label for="descripcion" :value="__('Descripción')" />
        <textarea id="descripcion" rows="5" class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" name="descripcion" style="resize: none;">{{ old('descripcion') }}</textarea>        <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
    </div>

    <div class="flex items-center justify-end mt-4">
        <x-primary-button class="ml-4">
            {{ __('Agregar Producto') }}
        </x-primary-button>
    </div>
</form>