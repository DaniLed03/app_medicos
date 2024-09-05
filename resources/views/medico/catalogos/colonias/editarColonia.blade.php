<form id="editColoniaForm" action="{{ route('colonias.update', ['id_asentamiento' => $colonia->id_asentamiento, 'id_entidad' => $colonia->id_entidad, 'id_municipio' => $colonia->id_municipio]) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mt-4">
        <label for="asentamiento_edit" class="block text-sm font-medium text-gray-700">Asentamiento</label>
        <input type="text" id="asentamiento_edit" name="asentamiento" value="{{ $colonia->asentamiento }}" class="mt-1 p-2 w-full border rounded-md" required>
    </div>

    <div class="mt-4">
        <label for="tipo_asentamiento_edit" class="block text-sm font-medium text-gray-700">Tipo de Asentamiento</label>
        <input type="text" id="tipo_asentamiento_edit" name="tipo_asentamiento" value="{{ $colonia->tipo_asentamiento }}" class="mt-1 p-2 w-full border rounded-md" required>
    </div>

    <div class="mt-4">
        <label for="cp_edit" class="block text-sm font-medium text-gray-700">Código Postal</label>
        <input type="text" id="cp_edit" name="cp" value="{{ $colonia->cp }}" class="mt-1 p-2 w-full border rounded-md" required>
    </div>

    <!-- Ocultar los campos de entidad y municipio pero incluirlos como campos hidden -->
    <input type="hidden" id="entidad_id_edit" name="id_entidad" value="{{ $colonia->id_entidad }}">
    <input type="hidden" id="municipio_id_edit" name="id_municipio" value="{{ $colonia->id_municipio }}">

    <div class="flex items-center justify-end mt-4">
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">Actualizar Colonia</button>
    </div>
</form>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const entidadSelect = document.getElementById('entidad_id_edit');
        const municipioSelect = document.getElementById('municipio_id_edit');
        
        // Al cargar la página, desactiva el select de municipio si no hay entidad seleccionada
        if (!entidadSelect.value) {
            municipioSelect.disabled = true;
        }

        // Manejo del cambio en la entidad seleccionada
        entidadSelect.addEventListener('change', function() {
            const entidadId = this.value;

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
                            municipioSelect.innerHTML += `<option value="${municipio.id_municipio}" ${municipio.id_municipio == '{{ $colonia->id_municipio }}' ? 'selected' : ''}>${municipio.nombre}</option>`;
                        });
                    })
                    .catch(error => {
                        console.error('Error al obtener los municipios:', error);
                    });
            }
        });
    });
</script>