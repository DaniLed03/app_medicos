<x-app-layout>
    <div class="bg-gray-100 min-h-screen flex justify-center items-center">
        <div class="bg-white shadow-md rounded-lg p-8 w-full mx-4 my-8" style="max-width: 1900px;">
            <div class="flex justify-between items-center mb-6 border-b-2 pb-4">
                <div class="flex items-center">
                    <div class="flex items-center justify-center h-12 w-12 rounded-full bg-white text-xl font-bold border-2" style="border-color: #2D7498; color: #33AD9B;">
                        {{ substr($cita->paciente->nombres, 0, 1) }}{{ substr($cita->paciente->apepat, 0, 1) }}
                    </div>
                    <h2 class="text-3xl font-bold text-left ml-4" style="color: black;">
                        {{ $cita->paciente->nombres }} {{ $cita->paciente->apepat }} {{ $cita->paciente->apemat }}
                    </h2>
                </div>
                <p class="text-lg font-medium">
                    Edad: 
                    <?php
                        $fecha_nacimiento = \Carbon\Carbon::parse($cita->paciente->fechanac);
                        $edad = $fecha_nacimiento->diff(\Carbon\Carbon::now());
                        echo $edad->y . ' años ' . $edad->m . ' meses ' . $edad->d . ' días';
                    ?>
                </p>
            </div>

            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-4 rounded mb-6">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('consultas.store') }}" method="POST">
                @csrf
                <input type="hidden" name="citai_id" value="{{ $cita->id }}">
                <input type="hidden" name="usuariomedicoid" value="{{ $medico->id }}">

                <div class="mb-6">
                    <div class="bg-gray-200 p-4 rounded-lg">
                        <h3 class="text-lg font-medium mb-4">Signos Vitales</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="hidden_talla" class="block text-sm font-medium text-gray-700">Talla</label>
                                <input type="text" id="hidden_talla" name="hidden_talla" class="mt-1 p-2 w-full border rounded-md" placeholder="m">
                            </div>
                            <div>
                                <label for="hidden_temperatura" class="block text-sm font-medium text-gray-700">Temperatura</label>
                                <input type="text" id="hidden_temperatura" name="hidden_temperatura" class="mt-1 p-2 w-full border rounded-md" placeholder="°C">
                            </div>
                            <div>
                                <label for="hidden_saturacion_oxigeno" class="block text-sm font-medium text-gray-700">Saturación de Oxígeno</label>
                                <input type="text" id="hidden_saturacion_oxigeno" name="hidden_saturacion_oxigeno" class="mt-1 p-2 w-full border rounded-md" placeholder="%">
                            </div>
                            <div>
                                <label for="hidden_frecuencia_cardiaca" class="block text-sm font-medium text-gray-700">Frecuencia Cardíaca</label>
                                <input type="text" id="hidden_frecuencia_cardiaca" name="hidden_frecuencia_cardiaca" class="mt-1 p-2 w-full border rounded-md" placeholder="bpm">
                            </div>
                            <div>
                                <label for="hidden_peso" class="block text-sm font-medium text-gray-700">Peso</label>
                                <input type="text" id="hidden_peso" name="hidden_peso" class="mt-1 p-2 w-full border rounded-md" placeholder="kg">
                            </div>
                            <div>
                                <label for="hidden_tension_arterial" class="block text-sm font-medium text-gray-700">Tensión Arterial</label>
                                <input type="text" id="hidden_tension_arterial" name="hidden_tension_arterial" class="mt-1 p-2 w-full border rounded-md" placeholder="mmHg">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="motivoConsulta" class="block text-sm font-medium text-gray-700">Motivo de la Consulta</label>
                    <textarea id="motivoConsulta" name="motivoConsulta" class="mt-1 p-2 w-full border rounded-md"></textarea>
                </div>

                <div class="mb-6">
                    <label for="notas_padecimiento" class="block text-sm font-medium text-gray-700">Notas del Padecimiento</label>
                    <textarea id="notas_padecimiento" name="notas_padecimiento" class="mt-1 p-2 w-full border rounded-md"></textarea>
                </div>

                <div class="mb-6">
                    <label for="interrogatorio_por_aparatos" class="block text-sm font-medium text-gray-700">Interrogatorio por Aparatos</label>
                    <textarea id="interrogatorio_por_aparatos" name="interrogatorio_por_aparatos" class="mt-1 p-2 w-full border rounded-md"></textarea>
                </div>

                <div class="mb-6">
                    <label for="examen_fisico" class="block text-sm font-medium text-gray-700">Examen Físico</label>
                    <textarea id="examen_fisico" name="examen_fisico" class="mt-1 p-2 w-full border rounded-md"></textarea>
                </div>

                <div class="mb-6">
                    <label for="diagnostico" class="block text-sm font-medium text-gray-700">Diagnóstico</label>
                    <textarea id="diagnostico" name="diagnostico" class="mt-1 p-2 w-full border rounded-md"></textarea>
                </div>

                <div class="mb-6">
                    <label for="plan" class="block text-sm font-medium text-gray-700">Plan</label>
                    <textarea id="plan" name="plan" class="mt-1 p-2 w-full border rounded-md"></textarea>
                </div>

                <div class="mb-6">
                    <label for="status" class="block text-sm font-medium text-gray-700">Estado</label>
                    <select id="status" name="status" class="mt-1 p-2 w-full border rounded-md">
                        <option value="en curso">En Curso</option>
                        <option value="finalizada">Finalizada</option>
                    </select>
                </div>

                <div class="mb-6">
                    <label for="totalPagar" class="block text-sm font-medium text-gray-700">Total a Pagar</label>
                    <input type="number" id="totalPagar" name="totalPagar" class="mt-1 p-2 w-full border rounded-md">
                </div>

                <div class="mb-6">
                    <h3 class="text-lg font-medium mb-2">Recetas</h3>
                    <div id="recetas" class="space-y-4">
                        <div class="receta flex space-x-4 items-center">
                            <div class="flex-1">
                                <label for="recetas[0][tipo_de_receta]" class="block text-sm font-medium text-gray-700">Tipo de Receta</label>
                                <input type="text" name="recetas[0][tipo_de_receta]" class="mt-1 p-2 w-full border rounded-md">
                            </div>
                            <div class="flex-1">
                                <label for="recetas[0][receta]" class="block text-sm font-medium text-gray-700">Receta</label>
                                <textarea name="recetas[0][receta]" class="mt-1 p-2 w-full border rounded-md"></textarea>
                            </div>
                            <button type="button" class="text-red-500 hover:text-red-700">Eliminar</button>
                        </div>
                    </div>
                    <button type="button" id="addReceta" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded-md">Agregar Receta</button>
                </div>

                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">Guardar Consulta</button>
            </form>

            <script>
                document.getElementById('addReceta').addEventListener('click', function () {
                    let recetasDiv = document.getElementById('recetas');
                    let newRecetaIndex = recetasDiv.getElementsByClassName('receta').length;

                    let newRecetaDiv = document.createElement('div');
                    newRecetaDiv.classList.add('receta', 'flex', 'space-x-4', 'items-center');

                    let tipoDeRecetaDiv = document.createElement('div');
                    tipoDeRecetaDiv.classList.add('flex-1');
                    let tipoDeRecetaLabel = document.createElement('label');
                    tipoDeRecetaLabel.innerText = 'Tipo de Receta';
                    tipoDeRecetaLabel.classList.add('block', 'text-sm', 'font-medium', 'text-gray-700');
                    let tipoDeRecetaInput = document.createElement('input');
                    tipoDeRecetaInput.type = 'text';
                    tipoDeRecetaInput.name = 'recetas[' + newRecetaIndex + '][tipo_de_receta]';
                    tipoDeRecetaInput.classList.add('mt-1', 'p-2', 'w-full', 'border', 'rounded-md');
                    tipoDeRecetaDiv.appendChild(tipoDeRecetaLabel);
                    tipoDeRecetaDiv.appendChild(tipoDeRecetaInput);

                    let recetaDiv = document.createElement('div');
                    recetaDiv.classList.add('flex-1');
                    let recetaLabel = document.createElement('label');
                    recetaLabel.innerText = 'Receta';
                    recetaLabel.classList.add('block', 'text-sm', 'font-medium', 'text-gray-700');
                    let recetaTextarea = document.createElement('textarea');
                    recetaTextarea.name = 'recetas[' + newRecetaIndex + '][receta]';
                    recetaTextarea.classList.add('mt-1', 'p-2', 'w-full', 'border', 'rounded-md');
                    recetaDiv.appendChild(recetaLabel);
                    recetaDiv.appendChild(recetaTextarea);

                    let removeButton = document.createElement('button');
                    removeButton.type = 'button';
                    removeButton.innerText = 'Eliminar';
                    removeButton.classList.add('text-red-500', 'hover:text-red-700');
                    removeButton.addEventListener('click', function () {
                        newRecetaDiv.remove();
                    });

                    newRecetaDiv.appendChild(tipoDeRecetaDiv);
                    newRecetaDiv.appendChild(recetaDiv);
                    newRecetaDiv.appendChild(removeButton);

                    recetasDiv.appendChild(newRecetaDiv);
                });
            </script>
        </div>
    </div>
</x-app-layout>
