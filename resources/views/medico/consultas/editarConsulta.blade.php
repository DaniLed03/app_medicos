<x-app-layout>
    <div class="py-12 flex flex-col items-center justify-center">
        <div class="max-w-5xl w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center">
                        <!-- Icono con iniciales -->
                        <div class="flex items-center justify-center h-12 w-12 rounded-full bg-white text-xl font-bold border-2" style="border-color: #2D7498; color: #33AD9B;">
                            {{ substr($consulta->cita->paciente->nombres, 0, 1) }}{{ substr($consulta->cita->paciente->apepat, 0, 1) }}
                        </div>
                        <!-- Nombre del paciente -->
                        <h2 class="text-3xl font-bold text-left ml-4" style="color: black;">
                            {{ $consulta->cita->paciente->nombres }} {{ $consulta->cita->paciente->apepat }} {{ $consulta->cita->paciente->apemat }}
                        </h2>
                    </div>
                    <hr class="my-4">

                    <form method="POST" action="{{ route('consultas.update', $consulta->id) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="usuariomedicoid" value="{{ $consulta->usuariomedicoid }}">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <!-- Motivo de Consulta -->
                            <div class="col-span-2">
                                <label for="motivoConsulta" class="block text-sm font-medium text-gray-700">Motivo de Consulta</label>
                                <textarea id="motivoConsulta" name="motivoConsulta" class="block w-full h-32 mt-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 resize-none" required>{{ $consulta->motivoConsulta }}</textarea>
                            </div>

                            <!-- Diagnóstico -->
                            <div>
                                <label for="diagnostico" class="block text-sm font-medium text-gray-700">Diagnóstico</label>
                                <textarea id="diagnostico" name="diagnostico" class="block w-full h-32 mt-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 resize-none" required>{{ $consulta->diagnostico }}</textarea>
                            </div>

                            <!-- Recete -->
                            <div>
                                <label for="recete" class="block text-sm font-medium text-gray-700">Recete</label>
                                <textarea id="recete" name="recete" class="block w-full h-32 mt-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 resize-none" required>{{ $consulta->recete }}</textarea>
                            </div>
                        </div>

                        <!-- Productos -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <!-- Lista de productos -->
                            <div class="col-span-1">
                                <label class="block text-sm font-medium text-gray-700">Productos</label>
                                @foreach($productos as $producto)
                                    <div class="flex items-center mb-2">
                                        <input id="producto_{{ $producto->id }}" name="productos[]" type="checkbox" value="{{ $producto->id }}" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 producto" data-price="{{ $producto->precio }}" {{ in_array($producto->id, $consulta_productos) ? 'checked' : '' }}>
                                        <label for="producto_{{ $producto->id }}" class="ml-2 block text-sm text-gray-900">{{ $producto->nombre }} - ${{ $producto->precio }}</label>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Lista de servicios -->
                            <div class="col-span-1">
                                <label class="block text-sm font-medium text-gray-700">Servicios</label>
                                @foreach($servicios as $servicio)
                                    <div class="flex items-center mb-2">
                                        <input id="servicio_{{ $servicio->id }}" name="servicios[]" type="checkbox" value="{{ $servicio->id }}" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 servicio" data-price="{{ $servicio->precio }}" {{ in_array($servicio->id, $consulta_servicios) ? 'checked' : '' }}>
                                        <label for="servicio_{{ $servicio->id }}" class="ml-2 block text-sm text-gray-900">{{ $servicio->nombre }} - ${{ $servicio->precio }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Total a Pagar y Botón Actualizar Consulta en la misma línea -->
                        <div class="flex items-center justify-between mt-4">
                            <div class="w-full">
                                <label for="totalPagar" class="block text-sm font-medium text-gray-700">Total a Pagar</label>
                                <input id="totalPagar" name="totalPagar" type="number" step="0.01" value="{{ $consulta->totalPagar }}" readonly class="block w-full mt-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                            </div>
                            <div class="ml-4">
                                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-md shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                    Actualizar Consulta
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const totalPagarInput = document.getElementById('totalPagar');
            const checkboxes = document.querySelectorAll('.producto, .servicio');
            let total = parseFloat(totalPagarInput.value);

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function () {
                    const price = parseFloat(this.getAttribute('data-price'));
                    if (this.checked) {
                        total += price;
                    } else {
                        total -= price;
                    }
                    totalPagarInput.value = total.toFixed(2);
                });
            });
        });
    </script>
</x-app-layout>
