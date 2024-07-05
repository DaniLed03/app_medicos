<x-app-layout>
    <div class="py-12 flex flex-col items-center justify-center">
        <div class="max-w-4xl w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between">
                        <h1 class="text-2xl font-bold" style="color: #316986;">Reagendar Cita</h1>
                    </div>
                    <hr class="my-4">

                    <form method="POST" action="{{ route('citas.update', $cita->id) }}" class="space-y-4" id="cita-edit-form">
                        @csrf
                        @method('PATCH')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Fecha -->
                            <div>
                                <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha</label>
                                <input id="fecha" name="fecha" type="date" class="block w-full mt-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-indigo-500" value="{{ $cita->fecha }}" required autofocus>
                                @error('fecha')
                                    <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Hora -->
                            <div>
                                <label for="hora" class="block text-sm font-medium text-gray-700">Hora</label>
                                <select id="hora" name="hora" class="block w-full mt-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-indigo-500" required>
                                    <!-- Opciones de horas se rellenarán con JavaScript -->
                                </select>
                                @error('hora')
                                    <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Paciente -->
                        <div>
                            <label for="pacienteid" class="block text-sm font-medium text-gray-700">Paciente</label>
                            <select id="pacienteid" name="pacienteid" class="block w-full mt-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-indigo-500" required>
                                @foreach($pacientes as $paciente)
                                    <option value="{{ $paciente->id }}" {{ $cita->pacienteid == $paciente->id ? 'selected' : '' }}>
                                        {{ $paciente->nombres }} {{ $paciente->apepat }} {{ $paciente->apemat }}
                                    </option>
                                @endforeach
                            </select>
                            @error('pacienteid')
                                <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Usuario Médico -->
                        <div>
                            <label for="usuariomedicoid" class="block text-sm font-medium text-gray-700">Usuario Médico</label>
                            <select id="usuariomedicoid" name="usuariomedicoid" class="block w-full mt-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-indigo-500" required>
                                @foreach($usuarios as $usuario)
                                    <option value="{{ $usuario->id }}" {{ $cita->usuariomedicoid == $usuario->id ? 'selected' : '' }}>
                                        {{ $usuario->nombres }} {{ $usuario->apepat }}
                                    </option>
                                @endforeach
                            </select>
                            @error('usuariomedicoid')
                                <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-4 space-x-2">
                            <a href="{{ route('consultas.create', ['citaId' => $cita->id]) }}" class="text-gray-800 cursor-pointer">
                                <svg class="w-10 h-10" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                  <path fill-rule="evenodd" d="M8 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1h2a2 2 0 0 1 2 2v15a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h2Zm6 1h-4v2H9a1 1 0 0 0 0 2h6a1 1 0 1 0 0-2h-1V4Zm-6 8a1 1 0 0 1 1-1h6a1 1 0 1 1 0 2H9a1 1 0 0 1-1-1Zm1 3a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2H9Z" clip-rule="evenodd"/>
                                </svg>
                            </a>
                            <button id="actualizar-cita-btn" type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-md shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                Actualizar Cita
                            </button>
                        </div>

                        <div id="error-message-edit" class="text-red-500 text-sm mt-2" style="display: none;"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('fecha').setAttribute('min', today);
            
            populateHours();
        });

        document.getElementById('fecha').addEventListener('change', function() {
            const fecha = this.value;
            const horaSelect = document.getElementById('hora');

            if (fecha) {
                fetch('{{ route('horas.disponibles') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ fecha: fecha })
                })
                .then(response => response.json())
                .then(data => {
                    horaSelect.innerHTML = '';
                    const now = new Date();
                    const selectedDate = new Date(fecha);
                    const currentHour = now.getHours();

                    for (let i = 10; i <= 22; i++) { // Mostrar horas de 10:00 AM a 10:00 PM
                        const hour = i < 10 ? `0${i}:00` : `${i}:00`;

                        const option = document.createElement('option');
                        option.value = hour;
                        option.textContent = hour;

                        // Deshabilitar horas ya seleccionadas
                        if (data.includes(hour)) {
                            option.disabled = true;
                        }

                        horaSelect.appendChild(option);
                    }
                });
            }
        });

        document.getElementById('hora').addEventListener('change', function() {
            const fecha = document.getElementById('fecha').value;
            const hora = this.value;
            const medicoId = document.getElementById('usuariomedicoid').value;
            const errorMessage = document.getElementById('error-message-edit');

            if (fecha && hora && medicoId) {
                fetch('{{ route('horas.disponibles') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ fecha: fecha, medicoid: medicoId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.includes(hora)) {
                        errorMessage.textContent = 'La hora seleccionada ya está ocupada. Por favor, elija otra hora.';
                        errorMessage.style.display = 'block';
                        document.getElementById('actualizar-cita-btn').disabled = true;
                    } else {
                        errorMessage.style.display = 'none';
                        document.getElementById('actualizar-cita-btn').disabled = false;
                    }
                });
            }
        });

        document.getElementById('cita-edit-form').addEventListener('submit', function(event) {
            const fecha = document.getElementById('fecha').value;
            const hora = document.getElementById('hora').value;
            const medicoId = document.getElementById('usuariomedicoid').value;
            const errorMessage = document.getElementById('error-message-edit');

            if (fecha && hora && medicoId) {
                event.preventDefault();
                fetch('{{ route('horas.disponibles') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ fecha: fecha, hora: hora, medicoid: medicoId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.includes(hora)) {
                        errorMessage.textContent = 'La hora seleccionada ya está ocupada. Por favor, elija otra hora.';
                        errorMessage.style.display = 'block';
                        document.getElementById('actualizar-cita-btn').disabled = true;
                    } else {
                        errorMessage.style.display = 'none';
                        document.getElementById('actualizar-cita-btn').disabled = false;
                        event.target.submit();
                    }
                });
            }
        });

        function populateHours() {
            const horaSelect = document.getElementById('hora');
            const horas = [
                '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', 
                '18:00', '19:00', '20:00', '21:00', '22:00'
            ];

            horas.forEach(hora => {
                const option = document.createElement('option');
                option.value = hora;
                option.textContent = hora;
                horaSelect.appendChild(option);
            });

            horaSelect.value = "{{ $cita->hora }}";
        }
    </script>
</x-app-layout>
