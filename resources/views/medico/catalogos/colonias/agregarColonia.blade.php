<form id="addColoniaForm" action="{{ route('colonias.store') }}" method="POST">
    @csrf

    <div class="mt-4 flex space-x-4">
        <div class="w-1/2">
            <label for="id_entidad" class="block text-sm font-medium text-gray-700">Entidad Federativa</label>
            <select id="id_entidad" name="id_entidad" class="mt-1 p-2 w-full border rounded-md" required>
                <option value="">Seleccione una Entidad</option>
                @foreach($entidades as $entidad)
                    <option value="{{ $entidad->id }}">{{ $entidad->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="w-1/2">
            <label for="id_municipio" class="block text-sm font-medium text-gray-700">Municipio</label>
            <select id="id_municipio" name="id_municipio" class="mt-1 p-2 w-full border rounded-md" disabled required>
                <option value="">Seleccione un Municipio</option>
            </select>
        </div>
    </div>

    <div class="mt-4 flex space-x-4">
        <div class="w-1/2">
            <label for="cp" class="block text-sm font-medium text-gray-700">Código Postal</label>
            <input type="text" id="cp" name="cp" class="mt-1 p-2 w-full border rounded-md" required>
        </div>
        <div class="w-1/2">
            <label for="tipo_asentamiento" class="block text-sm font-medium text-gray-700">Tipo de Asentamiento</label>
            <input type="text" id="tipo_asentamiento" name="tipo_asentamiento" class="mt-1 p-2 w-full border rounded-md" required>
        </div>
    </div>

    <div class="mt-4">
        <label for="asentamiento" class="block text-sm font-medium text-gray-700">Asentamiento</label>
        <input type="text" id="asentamiento" name="asentamiento" class="mt-1 p-2 w-full border rounded-md" required>
    </div>

    <div class="flex items-center justify-end mt-4">
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">Guardar Colonia</button>
    </div>
</form>


<script>
    document.getElementById('id_entidad').addEventListener('change', function() {
        const entidadId = this.value;
        const municipioSelect = document.getElementById('id_municipio');

        // Desactivar el select de municipios mientras se realiza la solicitud
        municipioSelect.disabled = true;

        // Limpiar el select de municipios
        municipioSelect.innerHTML = '<option value="">Seleccione un Municipio</option>';

        if (entidadId) {
            // Realizar una solicitud a la API para obtener los municipios según la entidad seleccionada
            fetch(`/api/municipios/${entidadId}`)
                .then(response => response.json())
                .then(municipios => {
                    // Habilitar el select de municipios
                    municipioSelect.disabled = false;

                    // Añadir las opciones de los municipios al select
                    municipios.forEach(municipio => {
                        municipioSelect.innerHTML += `<option value="${municipio.id_municipio}">${municipio.nombre}</option>`;
                    });
                })
                .catch(error => {
                    console.error('Error al obtener los municipios:', error);
                });
        }
    });
</script>
