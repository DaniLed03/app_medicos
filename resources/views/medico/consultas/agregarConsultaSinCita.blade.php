<x-app-layout>
    <div class="bg-gray-100 min-h-screen flex justify-center items-center">
        <div class="bg-white shadow-lg rounded-lg p-8 mx-4 my-8 w-full" style="max-width: 100%;">
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center">
                    <div class="flex items-center justify-center h-12 w-12 rounded-full bg-white text-xl font-bold border-2" style="border-color: #2D7498; color: #33AD9B;">
                        {{ substr($paciente->nombres, 0, 1) }}{{ substr($paciente->apepat, 0, 1) }}
                    </div>
                    <h2 class="text-3xl font-bold text-left ml-4" style="color: black;">
                        {{ $paciente->nombres }} {{ $paciente->apepat }} {{ $paciente->apemat }}
                    </h2>
                </div>
                <p class="text-lg font-medium">
                    Edad: 
                    <?php
                        $fecha_nacimiento = \Carbon\Carbon::parse($paciente->fechanac);
                        $edad = $fecha_nacimiento->diff(\Carbon\Carbon::now());
                        echo $edad->y . ' años ' . $edad->m . ' meses ' . $edad->d . ' días';
                    ?>
                </p>
            </div>

            <!-- Estructura de Tabs, Total a Pagar y Botón Terminar Consulta en la misma línea -->
            <div class="flex justify-between items-center mb-4">
                <!-- Estructura de Tabs -->
                <ul class="flex border-b mb-0" id="tabs">
                    <li class="-mb-px mr-1">
                        <a class="tab-link active-tab" href="#consultaTab" onclick="openTab(event, 'consultaTab')">Consulta</a>
                    </li>
                    <li class="mr-1">
                        <a class="tab-link" href="#recetasTab" onclick="openTab(event, 'recetasTab')">Recetas</a>
                    </li>
                </ul>

                <!-- Total a Pagar y Botón Terminar Consulta -->
                <div class="flex items-center space-x-4">
                    <label for="totalPagar" class="block text-sm font-medium text-gray-700">Precio de la Consulta</label>
                    <input type="number" id="totalPagar" name="totalPagar" class="mt-1 p-2 w-24 border rounded-md" value="{{ $precioConsulta }}" {{ $precioConsulta ? '' : 'required' }}>
                    
                    <!-- Botón Terminar Consulta -->
                    <button type="submit" form="consultasForm" class="bg-green-500 text-white px-4 py-2 rounded-md">Terminar Consulta</button>
                </div>
            </div>


            <!-- Contenedor para el contenido de las pestañas -->
            <div id="tab-content-wrapper" style="min-height: 400px; max-height: 600px; overflow-y: auto;">
                <div id="consultaTab" class="tab-pane active">
                    <form action="{{ route('consultas.storeWithoutCita') }}" method="POST" id="consultasForm">
                        @csrf
                        <input type="hidden" name="pacienteid" value="{{ $paciente->id }}">
                        <input type="hidden" name="usuariomedicoid" value="{{ $medico->id }}">
                        <input type="hidden" name="status" value="en curso">
                        <input type="hidden" name="notas_padecimiento" value="">
                        <input type="hidden" name="interrogatorio_por_aparatos" value="">
                        <input type="hidden" name="examen_fisico" value="">
                        <input type="hidden" name="plan" value="">

                        <div class="mb-6 grid md:grid-cols-3 gap-4">
                            <div class="bg-gray-100 p-4 rounded-lg">
                                <h3 class="text-lg font-medium mb-4">Signos Vitales</h3>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label for="hidden_talla" class="block text-sm font-medium text-gray-700">Talla</label>
                                        <input type="text" id="hidden_talla" name="hidden_talla" class="mt-1 p-2 w-full border rounded-md" placeholder="m" value="{{ old('hidden_talla') }}">
                                    </div>
                                    <div>
                                        <label for="hidden_temperatura" class="block text-sm font-medium text-gray-700">Temperatura</label>
                                        <input type="text" id="hidden_temperatura" name="hidden_temperatura" class="mt-1 p-2 w-full border rounded-md" placeholder="°C" value="{{ old('hidden_temperatura') }}">
                                    </div>
                                    <div>
                                        <label for="hidden_frecuencia_cardiaca" class="block text-sm font-medium text-gray-700">Frecuencia Cardíaca</label>
                                        <input type="text" id="hidden_frecuencia_cardiaca" name="hidden_frecuencia_cardiaca" class="mt-1 p-2 w-full border rounded-md" placeholder="bpm" value="{{ old('hidden_frecuencia_cardiaca') }}">
                                    </div>
                                    <div>
                                        <label for="hidden_peso" class="block text-sm font-medium text-gray-700">Peso</label>
                                        <input type="text" id="hidden_peso" name="hidden_peso" class="mt-1 p-2 w-full border rounded-md" placeholder="kg" value="{{ old('hidden_peso') }}">
                                    </div>
                                    <div>
                                        <label for="hidden_tension_arterial" class="block text-sm font-medium text-gray-700">Tensión Arterial</label>
                                        <input type="text" id="hidden_tension_arterial" name="hidden_tension_arterial" class="mt-1 p-2 w-full border rounded-md" placeholder="mmHg" value="{{ old('hidden_tension_arterial') }}">
                                    </div>
                                    <div>
                                        <label for="circunferencia_cabeza" class="block text-sm font-medium text-gray-700">Perímetro Cefálico</label>
                                        <input type="text" id="circunferencia_cabeza" name="circunferencia_cabeza" class="mt-1 p-2 w-full border rounded-md" placeholder="cm" value="{{ old('circunferencia_cabeza') }}">
                                    </div>
                                    <div>
                                        <label for="hidden_saturacion_oxigeno" class="block text-sm font-medium text-gray-700">Saturación de Oxígeno</label>
                                        <input type="text" id="hidden_saturacion_oxigeno" name="hidden_saturacion_oxigeno" class="mt-1 p-2 w-full border rounded-md" placeholder="%" value="{{ old('hidden_saturacion_oxigeno') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gray-100 p-4 rounded-lg">
                                <label for="motivoConsulta" class="block text-sm font-medium text-gray-700">Motivo de la Consulta</label>
                                <textarea id="motivoConsulta" name="motivoConsulta" class="mt-1 p-2 w-full border rounded-md resize-none" style="height: 230px;">{{ old('motivoConsulta') }}</textarea>
                            </div>

                            <div class="bg-gray-100 p-4 rounded-lg">
                                <label for="diagnostico" class="block text-sm font-medium text-gray-700">Diagnóstico</label>
                                <textarea id="diagnostico" name="diagnostico" class="mt-1 p-2 w-full border rounded-md resize-none" style="height: 230px;">{{ old('diagnostico') }}</textarea>
                            </div>
                        </div>
                    </form>
                </div>

                <div id="recetasTab" class="tab-pane hidden">
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
                                    <tr id="noRecetasMessage">
                                        <td colspan="3" class="text-center py-3">No hay recetas</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div id="modalReceta" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center hidden">
                        <div class="bg-white rounded-lg shadow-lg w-1/2 p-6">
                            <h2 class="text-xl font-semibold mb-4">Agregar Receta</h2>
                            <div class="mb-4">
                                <label for="modalTipoReceta" class="block text-sm font-medium text-gray-700">Tipo de Receta</label>
                                <div class="flex">
                                    <select id="modalTipoReceta" class="mt-1 p-2 w-full border rounded-md">
                                        <option value="Estudios de Laboratorio">Estudios de Laboratorio</option>
                                        <option value="Estudios de Gabinete">Estudios de Gabinete</option>
                                    </select>
                                </div>
                            </div>                    
                            <div class="mb-4">
                                <label for="modalRecetaInput" class="block text-sm font-medium text-gray-700">Receta</label>
                                <textarea id="modalRecetaInput" class="mt-1 p-2 w-full border rounded-md resize-none" style="height: 300px;">{{ old('modalRecetaInput') }}</textarea>
                            </div>
                            <div class="flex justify-end">
                                <button id="closeModal" class="bg-gray-500 text-white px-4 py-2 rounded-md mr-2">Cancelar</button>
                                <button id="saveReceta" class="bg-green-500 text-white px-4 py-2 rounded-md">Guardar</button>
                            </div>
                        </div>
                    </div>

                    <!-- Preview Modal -->
                    <div id="recetaModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
                        <div class="bg-white p-6 rounded-lg shadow-lg w-3/4">
                            <div class="flex justify-between items-center mb-4 border-b-2 pb-4">
                                <h3 id="recetaModalTitle" class="text-xl font-medium">Receta</h3>
                                <button id="closeRecetaModal" class="text-red-600 font-bold text-lg">&times;</button>
                            </div>
                            <div id="recetaModalContent" class="mt-4">
                                <!-- Aquí se mostrará la receta -->
                            </div>
                        </div>
                    </div> 
                </div>      
            </div>

            @if (old('recetas'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        let recetas = @json(old('recetas'));
                        let recetasDiv = document.getElementById('recetas');
                        recetasDiv.innerHTML = ''; // Limpia el contenido actual

                        recetas.forEach((receta, index) => {
                            let newRecetaRow = document.createElement('tr');
                            newRecetaRow.classList.add('receta', 'bg-gray-100', 'border-b', 'border-gray-200');
                            newRecetaRow.setAttribute('data-index', index);

                            newRecetaRow.innerHTML = `
                                <td class="py-3 px-6 text-left whitespace-nowrap">${index + 1}</td>
                                <td class="py-3 px-6 text-left">
                                    <input type="hidden" name="recetas[${index}][tipo_de_receta]" value="${receta.tipo_de_receta}">${receta.tipo_de_receta}
                                </td>
                                <td class="py-3 px-6 text-left">
                                    <input type="hidden" name="recetas[${index}][receta]" value="${encodeURIComponent(receta.receta)}">
                                    <button type="button" class="text-blue-500 hover:text-blue-700 previsualizar-receta" data-receta="${encodeURIComponent(receta.receta)}">Previsualizar</button>
                                    <button type="button" class="text-yellow-500 hover:text-yellow-700 editar-receta ml-2" data-receta-index="${index}">Editar</button>
                                    <button type="button" class="text-red-500 hover:text-red-700 eliminar-receta ml-2">Eliminar</button>
                                </td>
                            `;

                            recetasDiv.appendChild(newRecetaRow);

                            // Añadir event listeners a los botones de cada receta
                            newRecetaRow.querySelector('.eliminar-receta').addEventListener('click', function () {
                                newRecetaRow.remove();
                                if (recetasDiv.getElementsByClassName('receta').length === 0) {
                                    recetasDiv.innerHTML = '<tr id="noRecetasMessage"><td colspan="3" class="text-center py-3">No hay recetas</td></tr>';
                                }
                            });

                            newRecetaRow.querySelector('.previsualizar-receta').addEventListener('click', function () {
                                const recetaContent = decodeURIComponent(this.dataset.receta);
                                document.getElementById('recetaModalContent').innerHTML = recetaContent;
                                document.getElementById('recetaModal').classList.remove('hidden');
                            });

                            newRecetaRow.querySelector('.editar-receta').addEventListener('click', function () {
                                const recetaIndex = this.dataset.recetaIndex;
                                const tipoRecetaInput = document.querySelector(`input[name="recetas[${recetaIndex}][tipo_de_receta]"]`).value;
                                const recetaInput = decodeURIComponent(document.querySelector(`input[name="recetas[${recetaIndex}][receta]"]`).value);
                                
                                document.getElementById('modalTipoReceta').value = tipoRecetaInput;
                                CKEDITOR.instances['modalRecetaInput'].setData(recetaInput);
                                document.getElementById('modalReceta').classList.remove('hidden');
                                document.getElementById('saveReceta').setAttribute('data-edit-index', recetaIndex);
                            });
                        });
                    });
                </script>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-4 rounded mb-6">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

            <script>
                function openTab(event, tabName) {
                    var i, tabcontent, tablinks;
                    tabcontent = document.getElementsByClassName("tab-pane");
                    for (i = 0; i < tabcontent.length; i++) {
                        tabcontent[i].classList.remove("active");
                    }
                    tablinks = document.getElementsByClassName("tab-link");
                    for (i = 0; i < tablinks.length; i++) {
                        tablinks[i].classList.remove("active-tab");
                    }
                    document.getElementById(tabName).classList.add("active");
                    event.currentTarget.classList.add("active-tab");
                }

                // Set default tab
                document.addEventListener("DOMContentLoaded", function() {
                    openTab({currentTarget: document.querySelector(`[href="#consultaTab"]`)}, 'consultaTab');
                });

                CKEDITOR.replace('motivoConsulta', {
                    versionCheck: false,
                    enterMode: CKEDITOR.ENTER_P, // Salto de línea con interlineado
                    shiftEnterMode: CKEDITOR.ENTER_BR, // Salto de línea sin interlineado
                    toolbar: [
                        { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat'] },
                        { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote'] },
                        { name: 'styles', items: ['Format', 'Font', 'FontSize'] },
                        { name: 'insert', items: ['HorizontalRule'] },
                        { name: 'document', items: ['Source'] },
                        { name: 'justify', items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'] }
                    ]
                });

                CKEDITOR.replace('diagnostico', {
                    versionCheck: false,
                    enterMode: CKEDITOR.ENTER_P, // Salto de línea con interlineado
                    shiftEnterMode: CKEDITOR.ENTER_BR, // Salto de línea sin interlineado
                    toolbar: [
                        { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat'] },
                        { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote'] },
                        { name: 'styles', items: ['Format', 'Font', 'FontSize'] },
                        { name: 'insert', items: ['HorizontalRule'] },
                        { name: 'document', items: ['Source'] },
                        { name: 'justify', items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'] }
                    ]
                });

                CKEDITOR.replace('modalRecetaInput', {
                    versionCheck: false,
                    enterMode: CKEDITOR.ENTER_P, // Salto de línea con interlineado
                    shiftEnterMode: CKEDITOR.ENTER_BR, // Salto de línea sin interlineado
                    toolbar: [
                        { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat'] },
                        { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote'] },
                        { name: 'styles', items: ['Format', 'Font', 'FontSize'] },
                        { name: 'insert', items: ['HorizontalRule'] },
                        { name: 'document', items: ['Source'] },
                        { name: 'justify', items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'] }
                    ]
                });

                CKEDITOR.extraPlugins = "justify"
                CKEDITOR.extraPlugins = "font"
                CKEDITOR.extraPlugins = "size"

                document.getElementById('addReceta').addEventListener('click', function () {
                    document.getElementById('modalTipoReceta').value = '';
                    CKEDITOR.instances['modalRecetaInput'].setData('');
                    document.getElementById('modalReceta').classList.remove('hidden');
                    document.getElementById('saveReceta').setAttribute('data-edit-index', '');
                });

                document.getElementById('closeModal').addEventListener('click', function () {
                    clearModalFields();
                });

                function clearModalFields() {
                    document.getElementById('modalReceta').classList.add('hidden');
                    document.getElementById('modalTipoReceta').value = '';
                    CKEDITOR.instances['modalRecetaInput'].setData('');
                }

                function saveReceta(clearModal) {
                    let tipoReceta = document.getElementById('modalTipoReceta').value.trim();
                    let receta = CKEDITOR.instances['modalRecetaInput'].getData().trim();
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
                                    <button type="button" class="text-green-500 hover:text-green-700 imprimir-receta ml-2" data-receta="${encodeURIComponent(receta)}">Imprimir</button>
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
                                    <button type="button" class="text-green-500 hover:text-green-700 imprimir-receta ml-2" data-receta="${encodeURIComponent(receta)}">Imprimir</button>
                                </td>
                            `;
                        }

                        newRecetaRow.querySelector('.imprimir-receta').addEventListener('click', function () {
                            const recetaContent = decodeURIComponent(this.dataset.receta);
                            
                            // Extraemos el nombre, fecha, talla y peso
                            const nombreCompleto = "{{ $paciente->nombres }} {{ $paciente->apepat }} {{ $paciente->apemat }}";
                            const fechaActual = new Date().toLocaleDateString();
                            const talla = document.getElementById('hidden_talla').value || 'N/A';
                            const peso = document.getElementById('hidden_peso').value || 'N/A';
                            
                            // Crear un elemento temporal para calcular el número de líneas
                            const tempDiv = document.createElement('div');
                            tempDiv.style.position = 'absolute';
                            tempDiv.style.visibility = 'hidden';
                            tempDiv.style.width = '800px';
                            tempDiv.style.lineHeight = '1.5em';
                            tempDiv.innerHTML = recetaContent;
                            document.body.appendChild(tempDiv);
                            
                            // Calcular la altura y determinar cuántas líneas hay
                            const lineHeight = parseFloat(window.getComputedStyle(tempDiv).lineHeight);
                            const totalLines = tempDiv.offsetHeight / lineHeight;
                            
                            // Remover el elemento temporal
                            document.body.removeChild(tempDiv);

                            // Verificar si excede el límite de 8 líneas
                            if (totalLines > 6) {
                                alert("Sobrepasa los límites de la receta");
                            } else {
                                const printWindow = window.open('', '', 'width=800,height=600');
                                printWindow.document.write(`
                                    <br><br><br><br><br><br><br>
                                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 0 40px;">
                                        <div style="flex-basis: 40%; text-align: left; font-size: 15px; font-weight: normal;">${nombreCompleto}</div>
                                        <div style="flex-basis: 20%; text-align: right; font-size: 15px; font-weight: normal;">${fechaActual}</div>
                                        <div style="flex-basis: 10%; text-align: right; font-size: 15px; font-weight: normal;">${peso}</div>
                                        <div style="flex-basis: 10%; text-align: right; font-size: 15px; font-weight: normal;">${talla}</div>
                                    </div>
                                    <div style="padding: 20px 40px; font-size: 15px;">
                                        ${recetaContent}
                                    </div>
                                `);
                                printWindow.document.write('</body></html>');
                                printWindow.document.close();
                                printWindow.focus();
                                printWindow.print();
                            }
                        });


                        // Aquí debes asegurar que se agrega correctamente el event listener a cada nueva fila
                        newRecetaRow.querySelector('.eliminar-receta').addEventListener('click', function () {
                            newRecetaRow.remove();
                            if (recetasDiv.getElementsByClassName('receta').length === 0) {
                                recetasDiv.innerHTML = '<tr id="noRecetasMessage"><td colspan="3" class="text-center py-3">No hay recetas</td></tr>';
                            }
                        });

                        newRecetaRow.querySelector('.previsualizar-receta').addEventListener('click', function () {
                            const recetaContent = decodeURIComponent(this.dataset.receta);
                            document.getElementById('recetaModalContent').innerHTML = recetaContent;
                            document.getElementById('recetaModal').classList.remove('hidden');
                        });

                        newRecetaRow.querySelector('.editar-receta').addEventListener('click', function () {
                            const recetaIndex = this.dataset.recetaIndex;
                            const tipoRecetaInput = document.querySelector(`input[name="recetas[${recetaIndex}][tipo_de_receta]"]`).value;
                            const recetaInput = decodeURIComponent(document.querySelector(`input[name="recetas[${recetaIndex}][receta]"]`).value);
                            
                            document.getElementById('modalTipoReceta').value = tipoRecetaInput;
                            CKEDITOR.instances['modalRecetaInput'].setData(recetaInput);
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

                document.getElementById('closeRecetaModal').addEventListener('click', function () {
                    document.getElementById('recetaModal').classList.add('hidden');
                });

                document.querySelectorAll('.eliminar-receta').forEach(button => {
                    button.addEventListener('click', function () {
                        button.closest('tr').remove();
                        if (document.getElementById('recetas').getElementsByClassName('receta').length === 0) {
                            document.getElementById('recetas').innerHTML = '<tr id="noRecetasMessage"><td colspan="3" class="text-center py-3">No hay recetas</td></tr>';
                        }
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

                document.addEventListener('DOMContentLoaded', function() {
                    let showAlert = @json($showAlert); // Pasamos la variable desde el backend

                    if (showAlert) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Concepto de Consulta no encontrado',
                            text: 'Por favor, agregue un concepto de consulta en la configuración antes de continuar.',
                            confirmButtonText: 'Aceptar'
                        }).then(() => {
                            window.location.href = "{{ route('conceptos.index') }}"; // Redirigir a la página de crear concepto
                        });
                    }
                });
            </script>

            <style>
                #recetaModalContent ul,
                #recetaModalContent ol {
                    list-style-type: disc; /* Puntos para listas no ordenadas */
                    padding-left: 30px;
                    font-size: 0.9em; /* Reduce el tamaño de la fuente */
                    line-height: 1.2em; /* Reduce el interlineado */
                }
            
                #recetaModalContent ol {
                    list-style-type: decimal; /* Números para listas ordenadas */
                }
            
                #recetaModalContent li {
                    margin-bottom: 0.3em; /* Espaciado reducido entre elementos de lista */
                }

                #recetaModalContent p {
                    margin: 1em 0; /* Controla el interlineado cuando se presiona Enter */
                }

                #recetaModalContent br {
                    margin: 0; /* No agrega espacio cuando se presiona Shift + Enter */
                    line-height: 1.2em; /* Opcional: ajusta el interlineado de las líneas */
                }

                /* Estilos para las pestañas */
                .tab-link {
                    color: black;
                    text-decoration: none;
                    padding: 10px 20px;
                    display: inline-block;
                    font-weight: normal;
                    border-bottom: 2px solid transparent;
                    cursor: pointer;
                    font-size: 16px; /* Asegúrate de que el tamaño de la fuente sea el mismo */
                }

                .active-tab {
                    font-weight: bold;
                    border-bottom: 2px solid #2D7498;
                }

                .tab-link:hover {
                    font-weight: bold;
                }

                .tab-pane {
                    display: none;
                }

                .tab-pane.active {
                    display: block;
                }

                /* Si la línea es un borde en el contenedor del nombre, elimínalo */
                .nombre-contenedor {
                    border-bottom: none; /* Asegúrate de que el borde inferior esté desactivado */
                    margin-bottom: 0; /* Ajusta el margen si es necesario */
                }

                /* Mantén la línea en los tabs */
                #tabs {
                    border-bottom: 1px solid #e2e8f0; /* Mantén la línea en los tabs */
                    margin-top: 0; /* Elimina el margen superior para que las pestañas estén pegadas al nombre */
                }
            </style>
        </div>
    </div>
</x-app-layout>
