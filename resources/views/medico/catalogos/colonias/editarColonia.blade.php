<form id="editColoniaForm" action="" method="POST">
    @csrf
    @method('PUT')
    <div class="mt-4">
        <label for="asentamiento_edit" class="block text-sm font-medium text-gray-700">Asentamiento</label>
        <input type="text" id="asentamiento_edit" name="asentamiento" class="mt-1 p-2 w-full border rounded-md" required>
    </div>
    <div class="mt-4">
        <label for="tipo_asentamiento_edit" class="block text-sm font-medium text-gray-700">Tipo de Asentamiento</label>
        <input type="text" id="tipo_asentamiento_edit" name="tipo_asentamiento" class="mt-1 p-2 w-full border rounded-md" required>
    </div>
    <div class="mt-4">
        <label for="cp_edit" class="block text-sm font-medium text-gray-700">Código Postal</label>
        <input type="text" id="cp_edit" name="cp" class="mt-1 p-2 w-full border rounded-md" required>
    </div>
    <div class="mt-4">
        <label for="municipio_id_edit" class="block text-sm font-medium text-gray-700">Municipio</label>
        <select id="municipio_id_edit" name="id_municipio" class="mt-1 p-2 w-full border rounded-md" required>
            @foreach($municipios as $municipio)
                <option value="{{ $municipio->id_municipio }}">{{ $municipio->nombre }}</option>
            @endforeach
        </select>
    </div>
    <div class="mt-4">
        <label for="entidad_id_edit" class="block text-sm font-medium text-gray-700">Entidad Federativa</label>
        <select id="entidad_id_edit" name="id_entidad" class="mt-1 p-2 w-full border rounded-md" required>
            @foreach($entidades as $entidad)
                <option value="{{ $entidad->id }}">{{ $entidad->nombre }}</option>
            @endforeach
        </select>
    </div>
    <div class="flex items-center justify-end mt-4">
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">Actualizar Colonia</button>
    </div>
</form>
