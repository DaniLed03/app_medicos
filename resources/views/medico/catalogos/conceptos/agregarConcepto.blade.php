<form id="addConceptoForm" action="{{ route('conceptos.store') }}" method="POST">
    @csrf
    <div class="mt-4">
        <label for="concepto" class="block text-sm font-medium text-gray-700">Concepto</label>
        <input type="text" id="concepto" name="concepto" class="mt-1 p-2 w-full border rounded-md" required>
    </div>
    <div class="mt-4">
        <label for="unidad_medida" class="block text-sm font-medium text-gray-700">Unidad de Medida</label>
        <input type="text" id="unidad_medida" name="unidad_medida" class="mt-1 p-2 w-full border rounded-md" required>
    </div>
    <div class="mt-4 grid grid-cols-2 md:grid-cols-2 gap-4">
        <div>
            <label for="impuesto" class="block text-sm font-medium text-gray-700">Impuesto (%)</label>
            <input type="number" step="0.01" id="impuesto" name="impuesto" class="mt-1 p-2 w-full border rounded-md">
        </div>
        <div>
            <label for="precio_unitario" class="block text-sm font-medium text-gray-700">Precio Unitario</label>
            <input type="number" step="0.01" id="precio_unitario" name="precio_unitario" class="mt-1 p-2 w-full border rounded-md" required>
        </div>  
    </div>
    <div class="mt-4">
        <label class="block text-sm font-medium text-gray-700">Tipo de Concepto</label>
        <div class="flex items-center space-x-4">
            <div class="flex items-center">
                <input type="radio" id="servicio" name="tipo_concepto" value="Servicio" class="mr-2" required>
                <label for="servicio" class="text-sm font-medium text-gray-700">Servicio</label>
            </div>
            <div class="flex items-center">
                <input type="radio" id="producto" name="tipo_concepto" value="Producto" class="mr-2" required>
                <label for="producto" class="text-sm font-medium text-gray-700">Producto</label>
            </div>
        </div>
    </div>
    <div class="flex items-center justify-end mt-4">
        <button type="submit" id="guardarConcepto" class="bg-blue-500 text-white px-4 py-2 rounded-md">Guardar Concepto</button>
    </div>
    
</form>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Desactivar el botón después de hacer clic en "Guardar Concepto"
        document.getElementById('addConceptoForm').addEventListener('submit', function() {
            const submitButton = document.getElementById('guardarConcepto');
            submitButton.disabled = true;  // Desactiva el botón
            submitButton.innerText = 'Guardando...';  // Cambia el texto del botón mientras se procesa
        });
    });
</script>
