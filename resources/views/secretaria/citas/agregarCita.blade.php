<form method="POST" id="cita-form" action="{{ route('citas.store') }}" class="bg-white p-6 rounded-lg shadow-lg max-w-lg mx-auto relative">
    @csrf
    <button type="button" @click="isModalOpen = false" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 focus:outline-none">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>
    <h2 class="text-2xl font-bold text-center mb-4" style="color: #316986;">Agregar Cita</h2>
    <hr class="mb-4">
    <div class="grid grid-cols-2 gap-4">
        <!-- Fecha -->
        <div>
            <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha</label>
            <input id="fecha" class="block w-full mt-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" type="date" name="fecha" :value="old('fecha')" required autofocus min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" />
            @error('fecha')
                <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
            @enderror
        </div>

        <!-- Hora -->
        <div>
            <label for="hora" class="block text-sm font-medium text-gray-700">Hora</label>
            <select id="hora" name="hora" class="block w-full mt-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                <!-- Options will be dynamically populated -->
            </select>
            @error('hora')
                <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
            @enderror
        </div>

        <!-- Paciente -->
        <div>
            <label for="pacienteid" class="block text-sm font-medium text-gray-700">Paciente</label>
            <select id="pacienteid" name="pacienteid" class="block w-full mt-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                @foreach($pacientes as $paciente)
                    <option value="{{ $paciente->id }}" {{ old('pacienteid') == $paciente->id ? 'selected' : '' }}>
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
            <select id="usuariomedicoid" name="usuariomedicoid" class="block w-full mt-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                @foreach($usuarios as $usuario)
                    <option value="{{ $usuario->id }}" {{ old('usuariomedicoid') == $usuario->id ? 'selected' : '' }}>
                        {{ $usuario->nombres }} {{ $usuario->apepat }}
                    </option>
                @endforeach
            </select>
            @error('usuariomedicoid')
                <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="flex items-center justify-end mt-4">
        <button type="submit" id="registrar-cita-btn" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-md shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
            Registrar Cita
        </button>
    </div>
</form>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('fecha').setAttribute('min', today);
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

                for (let i = 0; i < 24; i++) {
                    const hour = i < 10 ? `0${i}:00` : `${i}:00`;

                    // Permitir horas futuras si la fecha seleccionada es hoy
                    if (selectedDate.toDateString() === now.toDateString() && i <= currentHour) {
                        continue;
                    }

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
                    alert('La hora seleccionada ya está ocupada. Por favor, elija otra hora.');
                    document.getElementById('registrar-cita-btn').disabled = true;
                } else {
                    document.getElementById('registrar-cita-btn').disabled = false;
                }
            });
        }
    });
</script>

