<x-app-layout>
    <div x-data="{ 
        openModal: false, 
        talla: '', 
        temperatura: '', 
        saturacion_oxigeno: '', 
        frecuencia_cardiaca: '', 
        peso: '', 
        tension_arterial: '',
        temp_talla: '', 
        temp_temperatura: '', 
        temp_saturacion_oxigeno: '', 
        temp_frecuencia_cardiaca: '', 
        temp_peso: '', 
        temp_tension_arterial: '',
        guardarSignosVitales() {
            this.talla = this.temp_talla + ' m';
            this.temperatura = this.temp_temperatura + ' c';
            this.saturacion_oxigeno = this.temp_saturacion_oxigeno + ' %';
            this.frecuencia_cardiaca = this.temp_frecuencia_cardiaca + ' bpm';
            this.peso = this.temp_peso + ' kg';
            this.tension_arterial = this.temp_tension_arterial + ' mm/Hg';
            this.openModal = false;
        }
    }" class="py-12 flex flex-col items-center justify-center">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center mb-6">
                        <!-- Icono con iniciales -->
                        <div class="flex items-center justify-center h-12 w-12 rounded-full bg-white text-xl font-bold border-2" style="border-color: #2D7498; color: #33AD9B;">
                            {{ substr($cita->paciente->nombres, 0, 1) }}{{ substr($cita->paciente->apepat, 0, 1) }}
                        </div>
                        <!-- Nombre del paciente -->
                        <h2 class="text-3xl font-bold text-left ml-4" style="color: black;">
                            {{ $cita->paciente->nombres }} {{ $cita->paciente->apepat }} {{ $cita->paciente->apemat }}
                        </h2>
                    </div>
                    
                    <!-- Signos vitales -->
                    <div class="bg-gray-100 p-6 rounded-lg mb-6">
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg font-bold mb-4">Signos vitales</h3>
                            <button @click="openModal = true" class="text-blue-500 hover:text-blue-700">
                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28"/>
                                </svg>
                            </button>
                        </div>
                        <div class="grid grid-cols-3 gap-4">
                            <div class="text-center">
                                <label class="block font-semibold">Talla</label>
                                <input type="text" name="talla" class="form-input w-full bg-gray-50 border border-gray-300 rounded-lg p-2" x-bind:value="talla" readonly>
                            </div>
                            <div class="text-center">
                                <label class="block font-semibold">Temperatura</label>
                                <input type="text" name="temperatura" class="form-input w-full bg-gray-50 border border-gray-300 rounded-lg p-2" x-bind:value="temperatura" readonly>
                            </div>
                            <div class="text-center">
                                <label class="block font-semibold">Saturación de oxígeno</label>
                                <input type="text" name="saturacion_oxigeno" class="form-input w-full bg-gray-50 border border-gray-300 rounded-lg p-2" x-bind:value="saturacion_oxigeno" readonly>
                            </div>
                            <div class="text-center">
                                <label class="block font-semibold">Frecuencia cardíaca</label>
                                <input type="text" name="frecuencia_cardiaca" class="form-input w-full bg-gray-50 border border-gray-300 rounded-lg p-2" x-bind:value="frecuencia_cardiaca" readonly>
                            </div>
                            <div class="text-center">
                                <label class="block font-semibold">Peso</label>
                                <input type="text" name="peso" class="form-input w-full bg-gray-50 border border-gray-300 rounded-lg p-2" x-bind:value="peso" readonly>
                            </div>
                            <div class="text-center">
                                <label class="block font-semibold">Tensión arterial</label>
                                <input type="text" name="tension_arterial" class="form-input w-full bg-gray-50 border border-gray-300 rounded-lg p-2" x-bind:value="tension_arterial" readonly>
                            </div>
                        </div>
                    </div>

                    <!-- Formulario para agregar consulta -->
                    <form method="POST" action="{{ route('consultas.store') }}">
                        @csrf
                        <input type="hidden" name="citai_id" value="{{ $cita->id }}">
                        <input type="hidden" name="usuariomedicoid" value="{{ $medico->id }}">
                        <input type="hidden" name="status" value="en curso">

                        <!-- Añadir campos ocultos para signos vitales -->
                        <input type="hidden" name="talla" x-model="talla">
                        <input type="hidden" name="temperatura" x-model="temperatura">
                        <input type="hidden" name="saturacion_oxigeno" x-model="saturacion_oxigeno">
                        <input type="hidden" name="frecuencia_cardiaca" x-model="frecuencia_cardiaca">
                        <input type="hidden" name="peso" x-model="peso">
                        <input type="hidden" name="tension_arterial" x-model="tension_arterial">

                        <!-- Motivo de la consulta -->
                        <div class="bg-gray-100 p-6 rounded-lg mb-6">
                            <h3 class="text-lg font-bold mb-4">Motivo de la consulta</h3>
                            <textarea name="motivoConsulta" class="form-input w-full bg-gray-50 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:border-transparent h-24 resize-none">{{ old('motivoConsulta') }}</textarea>
                        </div>

                        <!-- Notas de padecimiento -->
                        <div class="bg-gray-100 p-6 rounded-lg mb-6">
                            <h3 class="text-lg font-bold mb-4">Notas de padecimiento</h3>
                            <textarea name="notas_padecimiento" class="form-input w-full bg-gray-50 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:border-transparent h-24 resize-none">{{ old('notas_padecimiento') }}</textarea>
                        </div>

                        <!-- Interrogatorio por aparatos y sistemas -->
                        <div class="bg-gray-100 p-6 rounded-lg mb-6">
                            <h3 class="text-lg font-bold mb-4">Interrogatorio por aparatos y sistemas</h3>
                            <textarea name="interrogatorio_por_aparatos" class="form-input w-full bg-gray-50 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:border-transparent h-24 resize-none">{{ old('interrogatorio_por_aparatos') }}</textarea>
                        </div>

                        <!-- Examen físico -->
                        <div class="bg-gray-100 p-6 rounded-lg mb-6">
                            <h3 class="text-lg font-bold mb-4">Examen físico</h3>
                            <textarea name="examen_fisico" class="form-input w-full bg-gray-50 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:border-transparent h-24 resize-none">{{ old('examen_fisico') }}</textarea>
                        </div>

                        <!-- Diagnóstico -->
                        <div class="bg-gray-100 p-6 rounded-lg mb-6">
                            <h3 class="text-lg font-bold mb-4">Diagnóstico</h3>
                            <input type="text" name="diagnostico" class="form-input w-full bg-gray-50 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:border-transparent" value="{{ old('diagnostico') }}" required>
                        </div>

                        <!-- Plan -->
                        <div class="bg-gray-100 p-6 rounded-lg mb-6">
                            <h3 class="text-lg font-bold mb-4">Plan</h3>
                            <textarea name="plan" class="form-input w-full bg-gray-50 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:border-transparent h-24 resize-none">{{ old('plan') }}</textarea>
                        </div>

                        <!-- Recetas -->
                        <div class="bg-gray-100 p-6 rounded-lg mb-6">
                            <h3 class="text-lg font-bold mb-4">Recetas</h3>
                            <div id="recetas-container">
                                @if(old('recetas'))
                                    @foreach(old('recetas') as $index => $receta)
                                        <div class="receta-item mb-4">
                                            <div class="grid grid-cols-4 gap-4 mb-4">
                                                <input type="text" name="recetas[{{ $index }}][medicacion]" class="form-input col-span-1 bg-gray-50 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:border-transparent" placeholder="Medicación" value="{{ $receta['medicacion'] }}" required>
                                                <input type="number" name="recetas[{{ $index }}][cantidad_medicacion]" class="form-input col-span-1 bg-gray-50 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:border-transparent" placeholder="Cantidad" value="{{ $receta['cantidad_medicacion'] }}" required>
                                                <input type="text" name="recetas[{{ $index }}][frecuencia]" class="form-input col-span-1 bg-gray-50 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:border-transparent" placeholder="Frecuencia" value="{{ $receta['frecuencia'] }}" required>
                                                <input type="text" name="recetas[{{ $index }}][duracion]" class="form-input col-span-1 bg-gray-50 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:border-transparent" placeholder="Duración" value="{{ $receta['duracion'] }}" required>
                                            </div>
                                            <textarea name="recetas[{{ $index }}][notas]" class="form-input w-full bg-gray-50 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:border-transparent mb-2" placeholder="Agregar notas...">{{ $receta['notas'] }}</textarea>
                                            <button type="button" class="remove-receta bg-red-500 text-white p-2 rounded">Eliminar</button>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="receta-item mb-4">
                                        <div class="grid grid-cols-4 gap-4 mb-4">
                                            <input type="text" name="recetas[0][medicacion]" class="form-input col-span-1 bg-gray-50 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:border-transparent" placeholder="Medicación" required>
                                            <input type="number" name="recetas[0][cantidad_medicacion]" class="form-input col-span-1 bg-gray-50 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:border-transparent" placeholder="Cantidad" required>
                                            <input type="text" name="recetas[0][frecuencia]" class="form-input col-span-1 bg-gray-50 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:border-transparent" placeholder="Frecuencia" required>
                                            <input type="text" name="recetas[0][duracion]" class="form-input col-span-1 bg-gray-50 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:border-transparent" placeholder="Duración" required>
                                        </div>
                                        <textarea name="recetas[0][notas]" class="form-input w-full bg-gray-50 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:border-transparent h-24 resize-none" placeholder="Agregar notas..."></textarea>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="flex flex-wrap -mx-3">
                            <!-- Productos -->
                            <div class="bg-gray-100 p-6 rounded-lg mb-6 flex-1 mx-3">
                                <h3 class="text-lg font-bold mb-4">Productos</h3>
                                @foreach($productos as $producto)
                                    <div class="mb-2">
                                        <label class="flex items-center">
                                            <input type="checkbox" name="productos[]" value="{{ $producto->id }}" data-precio="{{ $producto->precio }}" class="producto-checkbox mr-2">
                                            {{ $producto->nombre }} ({{ $producto->precio }} pesos)
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        
                            <!-- Servicios -->
                            <div class="bg-gray-100 p-6 rounded-lg mb-6 flex-1 mx-3">
                                <h3 class="text-lg font-bold mb-4">Servicios</h3>
                                @foreach($servicios as $servicio)
                                    <div class="mb-2">
                                        <label class="flex items-center">
                                            <input type="checkbox" name="servicios[]" value="{{ $servicio->id }}" data-precio="{{ $servicio->precio }}" class="servicio-checkbox mr-2">
                                            {{ $servicio->nombre }} ({{ $servicio->precio }} pesos)
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Total a Pagar -->
                        <div class="bg-gray-100 p-6 rounded-lg mb-6">
                            <h3 class="text-lg font-bold mb-4">Total a Pagar</h3>
                            <input type="number" name="totalPagar" id="totalPagar" class="form-input w-full bg-gray-50 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:border-transparent" value="70" readonly>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="bg-green-500 text-white p-4 rounded">Guardar Consulta</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div x-show="openModal" class="fixed z-10 inset-0 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="openModal" class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div x-show="openModal" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <div style="color: #316986;">
                                    <h3 class="text-3xl text-center leading-6 font-medium">Edición de signos vitales</h3>
                                </div>
                                <div class="border-t border-gray-300 my-4"></div>
                                <div class="mt-2">
                                    <form @submit.prevent="guardarSignosVitales">
                                        <div class="grid grid-cols-2 gap-4">
                                            <div class="col-span-1">
                                                <label class="block text-sm font-medium text-gray-700">Talla</label>
                                                <input type="text" name="modal_talla" x-model="temp_talla" class="mt-1 form-input w-full bg-gray-50 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:border-transparent">
                                            </div>
                                            <div class="col-span-1">
                                                <label class="block text-sm font-medium text-gray-700">Temperatura</label>
                                                <input type="text" name="modal_temperatura" x-model="temp_temperatura" class="mt-1 form-input w-full bg-gray-50 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:border-transparent">
                                            </div>
                                            <div class="col-span-1">
                                                <label class="block text-sm font-medium text-gray-700">Saturación de oxígeno</label>
                                                <input type="text" name="modal_saturacion_oxigeno" x-model="temp_saturacion_oxigeno" class="mt-1 form-input w-full bg-gray-50 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:border-transparent">
                                            </div>
                                            <div class="col-span-1">
                                                <label class="block text-sm font-medium text-gray-700">Frecuencia cardíaca</label>
                                                <input type="text" name="modal_frecuencia_cardiaca" x-model="temp_frecuencia_cardiaca" class="mt-1 form-input w-full bg-gray-50 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:border-transparent">
                                            </div>
                                            <div class="col-span-1">
                                                <label class="block text-sm font-medium text-gray-700">Peso</label>
                                                <input type="text" name="modal_peso" x-model="temp_peso" class="mt-1 form-input w-full bg-gray-50 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:border-transparent">
                                            </div>
                                            <div class="col-span-1">
                                                <label class="block text-sm font-medium text-gray-700">Tensión arterial</label>
                                                <input type="text" name="modal_tension_arterial" x-model="temp_tension_arterial" class="mt-1 form-input w-full bg-gray-50 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:border-transparent">
                                            </div>
                                        </div>
                                        <div class="mt-4 flex justify-end">
                                            <button type="submit" class="p-2 rounded" style="background-color: #316986; color: white;">Guardar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <button @click="openModal = false" class="absolute top-0 right-0 p-2 text-gray-700 hover:text-gray-900">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('signosVitales', () => ({
                talla: '',
                temperatura: '',
                saturacion_oxigeno: '',
                frecuencia_cardiaca: '',
                peso: '',
                tension_arterial: ''
            }));
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const productoCheckboxes = document.querySelectorAll('.producto-checkbox');
            const servicioCheckboxes = document.querySelectorAll('.servicio-checkbox');
            const totalPagarInput = document.getElementById('totalPagar');
            
            function actualizarTotal() {
                let total = 70; // Valor por defecto de la consulta
                productoCheckboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        total += parseFloat(checkbox.getAttribute('data-precio'));
                    }
                });
                servicioCheckboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        total += parseFloat(checkbox.getAttribute('data-precio'));
                    }
                });
                totalPagarInput.value = total;
            }

            productoCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', actualizarTotal);
            });
            servicioCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', actualizarTotal);
            });

            actualizarTotal(); // Para calcular el total inicial si ya hay productos o servicios seleccionados
        });

        document.getElementById('add-receta').addEventListener('click', function () {
            const container = document.getElementById('recetas-container');
            const index = container.children.length;
            const newItem = document.createElement('div');
            newItem.classList.add('receta-item', 'mb-4');
            newItem.innerHTML = `
                <div class="grid grid-cols-4 gap-4 mb-4">
                    <input type="text" name="recetas[${index}][medicacion]" class="form-input col-span-1 bg-gray-50 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:border-transparent" placeholder="Medicación" required>
                    <input type="number" name="recetas[${index}][cantidad_medicacion]" class="form-input col-span-1 bg-gray-50 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:border-transparent" placeholder="Cantidad" required>
                    <input type="text" name="recetas[${index}][frecuencia]" class="form-input col-span-1 bg-gray-50 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:border-transparent" placeholder="Frecuencia" required>
                    <input type="text" name="recetas[${index}][duracion]" class="form-input col-span-1 bg-gray-50 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:border-transparent" placeholder="Duración" required>
                </div>
                <textarea name="recetas[${index}][notas]" class="form-input w-full bg-gray-50 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:border-transparent mb-2" placeholder="Agregar notas..."></textarea>
                <button type="button" class="remove-receta bg-red-500 text-white p-2 rounded">Eliminar</button>
            `;
            container.appendChild(newItem);
        });

        document.addEventListener('click', function (event) {
            if (event.target.classList.contains('remove-receta')) {
                event.target.closest('.receta-item').remove();
            }
        });
    </script>
</x-app-layout>
