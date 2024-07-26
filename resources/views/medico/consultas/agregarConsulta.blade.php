<x-app-layout>
    <div class="py-12 flex flex-col items-center justify-center">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center">
                            <!-- Icono con iniciales -->
                            <div class="flex items-center justify-center h-12 w-12 rounded-full bg-white text-xl font-bold border-2" style="border-color: #2D7498; color: #33AD9B;">
                                {{ substr($cita->paciente->nombres, 0, 1) }}{{ substr($cita->paciente->apepat, 0, 1) }}
                            </div>
                            <!-- Nombre del paciente -->
                            <h2 class="text-3xl font-bold text-left ml-4" style="color: black;">
                                {{ $cita->paciente->nombres }} {{ $cita->paciente->apepat }} {{ $cita->paciente->apemat }}
                            </h2>
                        </div>
                        <!-- Información adicional del paciente -->
                        <div class="flex items-center space-x-4 bg-[#2D7498] border rounded-lg p-4 text-white">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M5 4a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V4Zm12 12V5H7v11h10Zm-5 1a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2H12Z" clip-rule="evenodd"/>
                                </svg>
                                <span class="ml-1">{{ $cita->paciente->sexo }}</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20 7h-.7c.229-.467.349-.98.351-1.5a3.5 3.5 0 0 0-3.5-3.5c-1.717 0-3.215 1.2-4.331 2.481C10.4 2.842 8.949 2 7.5 2A3.5 3.5 0 0 0 4 5.5c.003.52.123 1.033.351 1.5H4a2 2 0 0 0-2 2v2a1 1 0 0 0 1 1h18a1 1 0 0 0 1-1V9a2 2 0 0 0-2-2Zm-9.942 0H7.5a1.5 1.5 0 0 1 0-3c.9 0 2 .754 3.092 2.122-.219.337-.392.635-.534.878Zm6.1 0h-3.742c.933-1.368 2.371-3 3.739-3a1.5 1.5 0 0 1 0 3h.003ZM13 14h-2v8h2v-8Zm-4 0H4v6a2 2 0 0 0 2 2h3v-8Zm6 0v8h3a2 2 0 0 0 2-2v-6h-5Z"/>
                                </svg>
                                <span class="ml-1">{{ $cita->paciente->fechanac }}</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20 7h-.7c.229-.467.349-.98.351-1.5a3.5 3.5 0 0 0-3.5-3.5c-1.717 0-3.215 1.2-4.331 2.481C10.4 2.842 8.949 2 7.5 2A3.5 3.5 0 0 0 4 5.5c.003.52.123 1.033.351 1.5H4a2 2 0 0 0-2 2v2a1 1 0 0 0 1 1h18a1 1 0 0 0 1-1V9a2 2 0 0 0-2-2Zm-9.942 0H7.5a1.5 1.5 0 0 1 0-3c.9 0 2 .754 3.092 2.122-.219.337-.392.635-.534.878Zm6.1 0h-3.742c.933-1.368 2.371-3 3.739-3a1.5 1.5 0 0 1 0 3h.003ZM13 14h-2v8h2v-8Zm-4 0H4v6a2 2 0 0 0 2 2h3v-8Zm6 0v8h3a2 2 0 0 0 2-2v-6h-5Z"/>
                                </svg>
                                <span class="ml-1">{{ $cita->paciente->telefono }}</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M5.024 3.783A1 1 0 0 1 6 3h12a1 1 0 0 1 .976.783L20.802 12h-4.244a1.99 1.99 0 0 0-1.824 1.205 2.978 2.978 0 0 1-5.468 0A1.991 1.991 0 0 0 7.442 12H3.198l1.826-8.217ZM3 14v5a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-5h-4.43a4.978 4.978 0 0 1-9.14 0H3Z" clip-rule="evenodd"/>
                                </svg>
                                <span class="ml-1">{{ $cita->paciente->correo }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Signos vitales -->
                    <div class="bg-gray-100 p-6 rounded-lg mb-6">
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg font-bold mb-4">Signos vitales</h3>
                            <button id="toggleSignosVitales" class="text-blue-500 hover:text-blue-700">
                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28"/>
                                </svg>
                            </button>
                        </div>
                        <div class="grid grid-cols-3 gap-4">
                            <div class="text-center">
                                <label class="block font-semibold">Talla</label>
                                <input type="text" id="talla" name="talla" class="form-input w-full bg-gray-50 border border-gray-300 rounded-lg p-2" disabled>
                            </div>
                            <div class="text-center">
                                <label class="block font-semibold">Temperatura</label>
                                <input type="text" id="temperatura" name="temperatura" class="form-input w-full bg-gray-50 border border-gray-300 rounded-lg p-2" disabled>
                            </div>
                            <div class="text-center">
                                <label class="block font-semibold">Saturación de oxígeno</label>
                                <input type="text" id="saturacion_oxigeno" name="saturacion_oxigeno" class="form-input w-full bg-gray-50 border border-gray-300 rounded-lg p-2" disabled>
                            </div>
                            <div class="text-center">
                                <label class="block font-semibold">Frecuencia cardíaca</label>
                                <input type="text" id="frecuencia_cardiaca" name="frecuencia_cardiaca" class="form-input w-full bg-gray-50 border border-gray-300 rounded-lg p-2" disabled>
                            </div>
                            <div class="text-center">
                                <label class="block font-semibold">Peso</label>
                                <input type="text" id="peso" name="peso" class="form-input w-full bg-gray-50 border border-gray-300 rounded-lg p-2" disabled>
                            </div>
                            <div class="text-center">
                                <label class="block font-semibold">Tensión arterial</label>
                                <input type="text" id="tension_arterial" name="tension_arterial" class="form-input w-full bg-gray-50 border border-gray-300 rounded-lg p-2" disabled>
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
                        <input type="hidden" name="hidden_talla">
                        <input type="hidden" name="hidden_temperatura">
                        <input type="hidden" name="hidden_saturacion_oxigeno">
                        <input type="hidden" name="hidden_frecuencia_cardiaca">
                        <input type="hidden" name="hidden_peso">
                        <input type="hidden" name="hidden_tension_arterial">

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
                            <div id="recetas-container" class="space-y-2">
                                <div class="receta-item flex items-center">
                                    <div class="grid grid-cols-4 gap-4 flex-1">
                                        <input type="text" name="recetas[0][medicacion]" class="form-input col-span-1 bg-gray-50 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:border-transparent" placeholder="Medicación" required>
                                        <input type="number" name="recetas[0][cantidad_medicacion]" class="form-input col-span-1 bg-gray-50 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:border-transparent" placeholder="Cantidad" required>
                                        <input type="text" name="recetas[0][frecuencia]" class="form-input col-span-1 bg-gray-50 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:border-transparent" placeholder="Frecuencia" required>
                                        <input type="text" name="recetas[0][duracion]" class="form-input col-span-1 bg-gray-50 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:border-transparent" placeholder="Duración" required>
                                        <textarea name="recetas[0][notas]" class="hidden"></textarea>
                                    </div>
                                    <button id="add-receta" type="button" class="bg-blue-500 text-white p-2 rounded ml-2">
                                        <svg class="w-5 h-5" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 4a1 1 0 00-1 1v6H5a1 1 0 000 2h6v6a1 1 0 002 0v-6h6a1 1 0 000-2h-6V5a1 1 0 00-1-1z"></path></svg>
                                    </button>
                                </div>
                                <!-- Additional Recetas will be added here -->
                            </div>
                            <textarea id="notas-unica" class="form-input w-full bg-gray-50 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:border-transparent h-24 resize-none mt-2" placeholder="Agregar notas..."></textarea>
                            <input type="hidden" name="notas_unica" id="hidden-notas-unica">
                        </div>

                        <div class="flex flex-wrap -mx-3">
                            <!-- Productos -->
                            <div class="bg-gray-100 p-6 rounded-lg mb-6 flex-1 mx-3">
                                <h3 class="text-lg font-bold mb-4">Productos</h3>
                                @foreach($productos as $producto)
                                    <div class="mb-2 flex items-center justify-between">
                                        <label class="flex items-center">
                                            <input type="checkbox" name="productos[]" value="{{ $producto->id }}" data-precio="{{ $producto->precio }}" class="producto-checkbox mr-2">
                                            {{ $producto->nombre }} ({{ $producto->precio }} pesos)
                                        </label>
                                        <div class="flex items-center space-x-2">
                                            <button type="button" class="bg-gray-300 text-gray-700 px-2 py-1 rounded minus-button">-</button>
                                            <span class="product-quantity">1</span>
                                            <button type="button" class="bg-gray-300 text-gray-700 px-2 py-1 rounded plus-button">+</button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        
                            <!-- Servicios -->
                            <div class="bg-gray-100 p-6 rounded-lg mb-6 flex-1 mx-3">
                                <h3 class="text-lg font-bold mb-4">Servicios</h3>
                                @foreach($servicios as $servicio)
                                    <div class="mb-2 flex items-center justify-between">
                                        <label class="flex items-center">
                                            <input type="checkbox" name="servicios[]" value="{{ $servicio->id }}" data-precio="{{ $servicio->precio }}" class="servicio-checkbox mr-2">
                                            {{ $servicio->nombre }} ({{ $servicio->precio }} pesos)
                                        </label>
                                        <div class="flex items-center space-x-2">
                                            <button type="button" class="bg-gray-300 text-gray-700 px-2 py-1 rounded minus-button">-</button>
                                            <span class="service-quantity">1</span>
                                            <button type="button" class="bg-gray-300 text-gray-700 px-2 py-1 rounded plus-button">+</button>
                                        </div>
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

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                let enableSignosVitales = false;

                const toggleSignosVitalesButton = document.getElementById('toggleSignosVitales');
                const signosVitalesInputs = document.querySelectorAll('input[name="talla"], input[name="temperatura"], input[name="saturacion_oxigeno"], input[name="frecuencia_cardiaca"], input[name="peso"], input[name="tension_arterial"]');
                const hiddenSignosVitalesInputs = {
                    'talla': document.querySelector('input[name="hidden_talla"]'),
                    'temperatura': document.querySelector('input[name="hidden_temperatura"]'),
                    'saturacion_oxigeno': document.querySelector('input[name="hidden_saturacion_oxigeno"]'),
                    'frecuencia_cardiaca': document.querySelector('input[name="hidden_frecuencia_cardiaca"]'),
                    'peso': document.querySelector('input[name="hidden_peso"]'),
                    'tension_arterial': document.querySelector('input[name="hidden_tension_arterial"]')
                };

                toggleSignosVitalesButton.addEventListener('click', function () {
                    enableSignosVitales = !enableSignosVitales;
                    signosVitalesInputs.forEach(input => {
                        input.disabled = !enableSignosVitales;
                    });
                });

                signosVitalesInputs.forEach(input => {
                    input.addEventListener('blur', function () {
                        const unit = getUnit(input.name);
                        if (input.value !== '' && !input.value.includes(unit)) {
                            input.value += ` ${unit}`;
                        }
                        hiddenSignosVitalesInputs[input.name].value = input.value;
                    });
                });

                function getUnit(fieldName) {
                    switch (fieldName) {
                        case 'talla':
                            return 'm';
                        case 'temperatura':
                            return '°C';
                        case 'saturacion_oxigeno':
                            return '%';
                        case 'frecuencia_cardiaca':
                            return 'bpm';
                        case 'peso':
                            return 'kg';
                        case 'tension_arterial':
                            return 'mmHg';
                        default:
                            return '';
                    }
                }

                const productoCheckboxes = document.querySelectorAll('.producto-checkbox');
                const servicioCheckboxes = document.querySelectorAll('.servicio-checkbox');
                const totalPagarInput = document.getElementById('totalPagar');
                const notasUnicaInput = document.getElementById('notas-unica');
                const hiddenNotasUnicaInput = document.getElementById('hidden-notas-unica');

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

                function actualizarNotas() {
                    const notas = notasUnicaInput.value;
                    hiddenNotasUnicaInput.value = notas;
                    const notasFields = document.querySelectorAll('textarea[name^="recetas"][name$="[notas]"]');
                    notasFields.forEach(field => {
                        field.value = notas;
                    });
                }

                productoCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', actualizarTotal);
                });
                servicioCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', actualizarTotal);
                });

                notasUnicaInput.addEventListener('input', actualizarNotas);

                actualizarTotal(); // Para calcular el total inicial si ya hay productos o servicios seleccionados
                actualizarNotas(); // Para actualizar las notas iniciales si ya hay algún texto

                document.getElementById('add-receta').addEventListener('click', function () {
                    const container = document.getElementById('recetas-container');
                    const index = container.children.length;
                    const newItem = document.createElement('div');
                    newItem.classList.add('receta-item', 'flex', 'items-center', 'mb-2');
                    newItem.innerHTML = `
                        <div class="grid grid-cols-4 gap-4 flex-1">
                            <input type="text" name="recetas[${index}][medicacion]" class="form-input col-span-1 bg-gray-50 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:border-transparent" placeholder="Medicación" required>
                            <input type="number" name="recetas[${index}][cantidad_medicacion]" class="form-input col-span-1 bg-gray-50 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:border-transparent" placeholder="Cantidad" required>
                            <input type="text" name="recetas[${index}][frecuencia]" class="form-input col-span-1 bg-gray-50 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:border-transparent" placeholder="Frecuencia" required>
                            <input type="text" name="recetas[${index}][duracion]" class="form-input col-span-1 bg-gray-50 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:border-transparent" placeholder="Duración" required>
                            <textarea name="recetas[${index}][notas]" class="hidden"></textarea>
                        </div>
                        <button type="button" class="remove-receta bg-red-500 text-white p-2 rounded ml-2">
                            <svg class="w-4 h-4" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    `;
                    container.appendChild(newItem);

                    // Update notes for the newly added medication
                    actualizarNotas();
                });

                document.addEventListener('click', function (event) {
                    if (event.target.closest('.remove-receta')) {
                        event.target.closest('.receta-item').remove();
                    }
                });

                document.addEventListener('click', function (event) {
                    if (event.target.classList.contains('plus-button')) {
                        const quantityElement = event.target.previousElementSibling;
                        let quantity = parseInt(quantityElement.textContent);
                        quantity++;
                        quantityElement.textContent = quantity;
                        actualizarTotal();
                    } else if (event.target.classList.contains('minus-button')) {
                        const quantityElement = event.target.nextElementSibling;
                        let quantity = parseInt(quantityElement.textContent);
                        if (quantity > 1) {
                            quantity--;
                            quantityElement.textContent = quantity;
                            actualizarTotal();
                        }
                    }
                });
            });
        </script>
</x-app-layout>
