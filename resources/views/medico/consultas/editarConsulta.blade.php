<x-app-layout>
    <div class="bg-gray-100 min-h-screen flex justify-center items-center">
        <div class="bg-white shadow-lg rounded-lg p-8 mx-4 my-8 w-full" style="max-width: 100%;">
            <div class="flex justify-between items-center mb-6 border-b-2 pb-4">
                <div class="flex items-center">
                    <div class="flex items-center justify-center h-12 w-12 rounded-full bg-white text-xl font-bold border-2" style="border-color: #2D7498; color: #33AD9B;">
                        {{ substr($consulta->cita->paciente->nombres, 0, 1) }}{{ substr($consulta->cita->paciente->apepat, 0, 1) }}
                    </div>
                    <h2 class="text-3xl font-bold text-left ml-4" style="color: black;">
                        {{ $consulta->cita->paciente->nombres }} {{ $consulta->cita->paciente->apepat }} {{ $consulta->cita->paciente->apemat }}
                    </h2>
                </div>
                <p class="text-lg font-medium">
                    Edad: 
                    <?php
                        $fecha_nacimiento = \Carbon\Carbon::parse($consulta->cita->paciente->fechanac);
                        $edad = $fecha_nacimiento->diff(\Carbon\Carbon::now());
                        echo $edad->y . ' años, ' . $edad->m . ' meses, ' . $edad->d . ' días';
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

            <form action="{{ route('consultas.update', $consulta->id) }}" method="POST" id="consultasForm">
                @csrf
                @method('PUT')

                <input type="hidden" name="citai_id" value="{{ $consulta->cita->id }}">
                <input type="hidden" name="usuariomedicoid" value="{{ $consulta->usuariomedicoid }}">
                <input type="hidden" name="status" value="en curso">

                <div class="mb-6 grid md:grid-cols-3 gap-4">
                    <div class="bg-gray-100 p-4 rounded-lg">
                        <h3 class="text-lg font-medium mb-4">Signos Vitales</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="hidden_talla" class="block text-sm font-medium text-gray-700">Talla</label>
                                <input type="text" id="hidden_talla" name="hidden_talla" class="mt-1 p-2 w-full border rounded-md" value="{{ $consulta->talla }}" placeholder="m">
                            </div>
                            <div>
                                <label for="hidden_temperatura" class="block text-sm font-medium text-gray-700">Temperatura</label>
                                <input type="text" id="hidden_temperatura" name="hidden_temperatura" class="mt-1 p-2 w-full border rounded-md" value="{{ $consulta->temperatura }}" placeholder="°C">
                            </div>
                            <div>
                                <label for="hidden_saturacion_oxigeno" class="block text-sm font-medium text-gray-700">Saturación de Oxígeno</label>
                                <input type="text" id="hidden_saturacion_oxigeno" name="hidden_saturacion_oxigeno" class="mt-1 p-2 w-full border rounded-md" value="{{ $consulta->saturacion_oxigeno }}" placeholder="%">
                            </div>
                            <div>
                                <label for="hidden_frecuencia_cardiaca" class="block text-sm font-medium text-gray-700">Frecuencia Cardíaca</label>
                                <input type="text" id="hidden_frecuencia_cardiaca" name="hidden_frecuencia_cardiaca" class="mt-1 p-2 w-full border rounded-md" value="{{ $consulta->frecuencia_cardiaca }}" placeholder="bpm">
                            </div>
                            <div>
                                <label for="hidden_peso" class="block text-sm font-medium text-gray-700">Peso</label>
                                <input type="text" id="hidden_peso" name="hidden_peso" class="mt-1 p-2 w-full border rounded-md" value="{{ $consulta->peso }}" placeholder="kg">
                            </div>
                            <div>
                                <label for="hidden_tension_arterial" class="block text-sm font-medium text-gray-700">Tensión Arterial</label>
                                <input type="text" id="hidden_tension_arterial" name="hidden_tension_arterial" class="mt-1 p-2 w-full border rounded-md" value="{{ $consulta->tension_arterial }}" placeholder="mmHg">
                            </div>
                            <div>
                                <label for="circunferencia_cabeza" class="block text-sm font-medium text-gray-700">Circunferencia de Cabeza</label>
                                <input type="text" id="circunferencia_cabeza" name="circunferencia_cabeza" class="mt-1 p-2 w-full border rounded-md" value="{{ $consulta->circunferencia_cabeza }}" placeholder="cm">
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-100 p-4 rounded-lg">
                        <label for="motivoConsulta" class="block text-sm font-medium text-gray-700">Motivo de la Consulta</label>
                        <textarea id="motivoConsulta" name="motivoConsulta" class="mt-1 p-2 w-full border rounded-md resize-none" style="height: 230px;">{{ $consulta->motivoConsulta }}</textarea>
                    </div>

                    <div class="bg-gray-100 p-4 rounded-lg">
                        <label for="diagnostico" class="block text-sm font-medium text-gray-700">Diagnóstico</label>
                        <textarea id="diagnostico" name="diagnostico" class="mt-1 p-2 w-full border rounded-md resize-none" style="height: 230px;">{{ $consulta->diagnostico }}</textarea>
                    </div>
                </div>

                <div class="mb-6">
                    <div class="bg-gray-100 p-4 rounded-lg flex justify-between items-center">
                        <h3 class="text-lg font-medium mb-2">Recetas</h3>
                        <button type="button" id="addReceta" class="bg-blue-500 text-white px-4 py-2 rounded-md">Agregar Receta</button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border rounded-lg">
                            <thead>
                                <tr class="bg-[#2D7498] text-white uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-left">No.Receta</th>
                                    <th class="py-3 px-6 text-left">Tipo de Receta</th>
                                    <th class="py-3 px-6 text-left">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="recetas">
                                @foreach ($consulta->recetas as $index => $receta)
                                    <tr class="receta bg-gray-100 border-b border-gray-200" data-index="{{ $index }}">
                                        <td class="py-3 px-6 text-left whitespace-nowrap">{{ $index + 1 }}</td>
                                        <td class="py-3 px-6 text-left">
                                            <input type="hidden" name="recetas[{{ $index }}][tipo_de_receta]" value="{{ $receta->tipo_de_receta }}">{{ $receta->tipo_de_receta }}
                                        </td>
                                        <td class="py-3 px-6 text-left">
                                            <input type="hidden" name="recetas[{{ $index }}][receta]" value="{{ $receta->receta }}">
                                            <button type="button" class="text-blue-500 hover:text-blue-700 previsualizar-receta" data-receta="{{ htmlentities($receta->receta) }}">Previsualizar</button>
                                            <button type="button" class="text-yellow-500 hover:text-yellow-700 editar-receta ml-2" data-receta-index="{{ $index }}">Editar</button>
                                            <button type="button" class="text-red-500 hover:text-red-700 eliminar-receta ml-2">Eliminar</button>
                                        </td>
                                    </tr>
                                @endforeach
                                @if (count($consulta->recetas) === 0)
                                    <tr id="noRecetasMessage">
                                        <td colspan="3" class="text-center py-3">No hay recetas</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mb-6">
                    <div class="bg-gray-100 p-4 rounded-lg">
                        <label for="totalPagar" class="block text-sm font-medium text-gray-700">Total a Pagar</label>
                        <input type="number" id="totalPagar" name="totalPagar" class="mt-1 p-2 w-full border rounded-md" value="{{ $consulta->totalPagar }}">
                    </div>
                </div>

                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">Guardar Consulta</button>
            </form>

            <!-- Modal -->
            <div id="modalReceta" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center hidden">
                <div class="bg-white rounded-lg shadow-lg w-1/2 p-6">
                    <h2 class="text-xl font-semibold mb-4">Agregar Receta</h2>
                    <div class="mb-4">
                        <label for="modalTipoReceta" class="block text-sm font-medium text-gray-700">Tipo de Receta</label>
                        <input type="text" id="modalTipoReceta" class="mt-1 p-2 w-full border rounded-md">
                    </div>
                    <div class="mb-4">
                        <label for="modalRecetaInput" class="block text-sm font-medium text-gray-700">Receta</label>
                        <textarea id="modalRecetaInput" class="mt-1 p-2 w-full border rounded-md resize-none" style="height: 300px;"></textarea>
                    </div>
                    <div class="flex justify-end">
                        <button id="closeModal" class="bg-gray-500 text-white px-4 py-2 rounded-md mr-2">Cancelar</button>
                        <button id="saveReceta" class="bg-green-500 text-white px-4 py-2 rounded-md">Guardar</button>
                    </div>
                </div>
            </div>

            <!-- Preview Modal -->
            <div id="previewModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center hidden">
                <div class="bg-white rounded-lg shadow-lg w-1/2 p-6">
                    <h2 class="text-xl font-semibold mb-4">Previsualización de Receta</h2>
                    <div id="previewContent" class="mb-4"></div>
                    <div class="flex justify-end">
                        <button id="closePreview" class="bg-gray-500 text-white px-4 py-2 rounded-md">Cerrar</button>
                    </div>
                </div>
            </div>

            <!-- Summernote CSS & JS -->
            <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-lite.min.css" rel="stylesheet">
            <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-lite.min.js"></script>

            <script>
                function clearModalFields() {
                    document.getElementById('modalTipoReceta').value = '';
                    $('#modalRecetaInput').summernote('destroy');
                    $('#modalRecetaInput').val('');
                    document.getElementById('modalReceta').classList.add('hidden');
                }

                function decodeHtml(html) {
                    var txt = document.createElement("textarea");
                    txt.innerHTML = html;
                    return txt.value;
                }

                document.getElementById('addReceta').addEventListener('click', function () {
                    clearModalFields();
                    $('#modalRecetaInput').summernote({
                        height: 300,
                        toolbar: [
                            ['style', ['bold', 'italic', 'underline', 'clear']],
                            ['font', ['strikethrough', 'superscript', 'subscript']],
                            ['fontsize', ['fontsize']],
                            ['color', ['color']],
                            ['para', ['ul', 'ol', 'paragraph']],
                            ['height', ['height']]
                        ]
                    });
                    document.getElementById('modalReceta').classList.remove('hidden');
                    document.getElementById('saveReceta').setAttribute('data-edit-index', '');
                });

                document.getElementById('closeModal').addEventListener('click', function () {
                    clearModalFields();
                });

                function saveReceta(clearModal) {
                    let tipoReceta = document.getElementById('modalTipoReceta').value.trim();
                    let receta = $('#modalRecetaInput').summernote('code').trim();
                    let editIndex = document.getElementById('saveReceta').getAttribute('data-edit-index');

                    if (tipoReceta && receta) {
                        let recetasDiv = document.getElementById('recetas');
                        let noRecetasMessage = document.getElementById('noRecetasMessage');

                        if (noRecetasMessage) {
                            noRecetasMessage.remove();
                        }

                        let newRecetaRow;
                        if (editIndex === '') {
                            let newRecetaIndex = recetasDiv.getElementsByClassName('receta').length;
                            newRecetaRow = document.createElement('tr');
                            newRecetaRow.classList.add('receta', 'bg-gray-100', 'border-b', 'border-gray-200');
                            newRecetaRow.setAttribute('data-index', newRecetaIndex);

                            newRecetaRow.innerHTML = `
                                <td class="py-3 px-6 text-left whitespace-nowrap">${newRecetaIndex + 1}</td>
                                <td class="py-3 px-6 text-left">
                                    <input type="hidden" name="recetas[${newRecetaIndex}][tipo_de_receta]" value="${tipoReceta}">${tipoReceta}
                                </td>
                                <td class="py-3 px-6 text-left">
                                    <input type="hidden" name="recetas[${newRecetaIndex}][receta]" value="${encodeURIComponent(receta)}">
                                    <button type="button" class="text-blue-500 hover:text-blue-700 previsualizar-receta" data-receta="${encodeURIComponent(receta)}">Previsualizar</button>
                                    <button type="button" class="text-yellow-500 hover:text-yellow-700 editar-receta ml-2" data-receta-index="${newRecetaIndex}">Editar</button>
                                    <button type="button" class="text-red-500 hover:text-red-700 eliminar-receta ml-2">Eliminar</button>
                                </td>
                            `;
                            recetasDiv.appendChild(newRecetaRow);
                        } else {
                            newRecetaRow = document.querySelector(`tr[data-index="${editIndex}"]`);
                            newRecetaRow.innerHTML = `
                                <td class="py-3 px-6 text-left whitespace-nowrap">${parseInt(editIndex) + 1}</td>
                                <td class="py-3 px-6 text-left">
                                    <input type="hidden" name="recetas[${editIndex}][tipo_de_receta]" value="${tipoReceta}">${tipoReceta}
                                </td>
                                <td class="py-3 px-6 text-left">
                                    <input type="hidden" name="recetas[${editIndex}][receta]" value="${encodeURIComponent(receta)}">
                                    <button type="button" class="text-blue-500 hover:text-blue-700 previsualizar-receta" data-receta="${encodeURIComponent(receta)}">Previsualizar</button>
                                    <button type="button" class="text-yellow-500 hover:text-yellow-700 editar-receta ml-2" data-receta-index="${editIndex}">Editar</button>
                                    <button type="button" class="text-red-500 hover:text-red-700 eliminar-receta ml-2">Eliminar</button>
                                </td>
                            `;
                        }

                        newRecetaRow.querySelector('.eliminar-receta').addEventListener('click', function () {
                            newRecetaRow.remove();
                            if (recetasDiv.getElementsByClassName('receta').length === 0) {
                                recetasDiv.innerHTML = '<tr id="noRecetasMessage"><td colspan="3" class="text-center py-3">No hay recetas</td></tr>';
                            }
                        });

                        newRecetaRow.querySelector('.previsualizar-receta').addEventListener('click', function () {
                            const recetaContent = decodeHtml(decodeURIComponent(this.dataset.receta));
                            document.getElementById('previewContent').innerHTML = recetaContent;
                            document.getElementById('previewModal').classList.remove('hidden');
                        });

                        newRecetaRow.querySelector('.editar-receta').addEventListener('click', function () {
                            const recetaIndex = this.dataset.recetaIndex;
                            const tipoRecetaInput = document.querySelector(`input[name="recetas[${recetaIndex}][tipo_de_receta]"]`).value;
                            const recetaInput = decodeHtml(decodeURIComponent(document.querySelector(`input[name="recetas[${recetaIndex}][receta]"]`).value));
                            
                            document.getElementById('modalTipoReceta').value = tipoRecetaInput;
                            $('#modalRecetaInput').summernote({
                                height: 300,
                                toolbar: [
                                    ['style', ['bold', 'italic', 'underline', 'clear']],
                                    ['font', ['strikethrough', 'superscript', 'subscript']],
                                    ['fontsize', ['fontsize']],
                                    ['color', ['color']],
                                    ['para', ['ul', 'ol', 'paragraph']],
                                    ['height', ['height']]
                                ]
                            }).summernote('code', recetaInput);
                            document.getElementById('modalReceta').classList.remove('hidden');
                            document.getElementById('saveReceta').setAttribute('data-edit-index', recetaIndex);
                        });

                        if (clearModal) {
                            clearModalFields();
                        }
                    } else {
                        alert('Por favor, complete todos los campos.');
                    }
                }

                document.getElementById('saveReceta').addEventListener('click', function () {
                    saveReceta(true);
                });

                document.getElementById('closePreview').addEventListener('click', function () {
                    document.getElementById('previewModal').classList.add('hidden');
                });

                document.querySelectorAll('.eliminar-receta').forEach(button => {
                    button.addEventListener('click', function () {
                        button.closest('tr').remove();
                        if (document.getElementById('recetas').getElementsByClassName('receta').length === 0) {
                            document.getElementById('recetas').innerHTML = '<tr id="noRecetasMessage"><td colspan="3" class="text-center py-3">No hay recetas</td></tr>';
                        }
                    });
                });

                document.querySelectorAll('.previsualizar-receta').forEach(button => {
                    button.addEventListener('click', function () {
                        const recetaContent = decodeHtml(decodeURIComponent(this.dataset.receta));
                        document.getElementById('previewContent').innerHTML = recetaContent;
                        document.getElementById('previewModal').classList.remove('hidden');
                    });
                });

                document.querySelectorAll('.editar-receta').forEach(button => {
                    button.addEventListener('click', function () {
                        const recetaIndex = this.dataset.recetaIndex;
                        const tipoRecetaInput = document.querySelector(`input[name="recetas[${recetaIndex}][tipo_de_receta]"]`).value;
                        const recetaInput = decodeHtml(decodeURIComponent(document.querySelector(`input[name="recetas[${recetaIndex}][receta]"]`).value));

                        document.getElementById('modalTipoReceta').value = tipoRecetaInput;
                        $('#modalRecetaInput').summernote({
                            height: 300,
                            toolbar: [
                                ['style', ['bold', 'italic', 'underline', 'clear']],
                                ['font', ['strikethrough', 'superscript', 'subscript']],
                                ['fontsize', ['fontsize']],
                                ['color', ['color']],
                                ['para', ['ul', 'ol', 'paragraph']],
                                ['height', ['height']]
                            ]
                        }).summernote('code', recetaInput);
                        document.getElementById('modalReceta').classList.remove('hidden');
                        document.getElementById('saveReceta').setAttribute('data-edit-index', recetaIndex);
                    });
                });

                document.getElementById('consultasForm').addEventListener('submit', function () {
                    document.querySelectorAll('.receta input[name*="receta"]').forEach(function (input) {
                        const recetaIndex = input.name.match(/recetas\[(\d+)\]/)[1];
                        input.value = decodeURIComponent(input.value);  // Decodifica el contenido antes de enviar
                    });
                });

                // Add unit validation on blur event for vital signs fields
                const vitalSignsFields = {
                    'hidden_talla': 'm',
                    'hidden_temperatura': '°C',
                    'hidden_saturacion_oxigeno': '%',
                    'hidden_frecuencia_cardiaca': 'bpm',
                    'hidden_peso': 'kg',
                    'hidden_tension_arterial': 'mmHg',
                    'circunferencia_cabeza': 'cm'
                };

                for (const [fieldId, unit] of Object.entries(vitalSignsFields)) {
                    document.getElementById(fieldId).addEventListener('blur', function () {
                        if (this.value && !this.value.endsWith(unit)) {
                            this.value += ` ${unit}`;
                        }
                    });
                }
            </script>
        </div>
    </div>
</x-app-layout>
