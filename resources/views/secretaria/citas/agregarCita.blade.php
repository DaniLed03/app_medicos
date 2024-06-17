<form method="POST" action="{{ route('citas.store') }}">
    @csrf

    <div class="grid grid-cols-2 gap-4">
        <!-- Fecha -->
        <div class="mt-4">
            <x-input-label for="fecha" :value="__('Fecha')" />
            <x-text-input id="fecha" class="block mt-1 w-full" type="date" name="fecha" :value="old('fecha')" required autofocus min="{{ date('Y-m-d') }}" />
            <x-input-error :messages="$errors->get('fecha')" class="mt-2" />
        </div>

        <!-- Hora -->
        <div class="mt-4">
            <x-input-label for="hora" :value="__('Hora')" />
            <select id="hora" name="hora" class="block mt-1 w-full" required>
                <!-- Options will be dynamically populated -->
            </select>
            <x-input-error :messages="$errors->get('hora')" class="mt-2" />
        </div>

        <!-- Paciente -->
        <div class="mt-4">
            <x-input-label for="pacienteid" :value="__('Paciente')" />
            <select id="pacienteid" name="pacienteid" class="block mt-1 w-full" required>
                @foreach($pacientes as $paciente)
                    <option value="{{ $paciente->id }}" {{ old('pacienteid') == $paciente->id ? 'selected' : '' }}>
                        {{ $paciente->nombres }} {{ $paciente->apepat }} {{ $paciente->apemat }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('pacienteid')" class="mt-2" />
        </div>

        <!-- Usuario Médico -->
        <div class="mt-4">
            <x-input-label for="usuariomedicoid" :value="__('Usuario Médico')" />
            <select id="usuariomedicoid" name="usuariomedicoid" class="block mt-1 w-full" required>
                @foreach($usuarios as $usuario)
                    <option value="{{ $usuario->id }}" {{ old('usuariomedicoid') == $usuario->id ? 'selected' : '' }}>
                        {{ $usuario->nombres }} {{ $usuario->apepat }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('usuariomedicoid')" class="mt-2" />
        </div>
    </div>

    <div class="flex items-center justify-end mt-4">
        <x-primary-button class="ml-4">
            {{ __('Registrar Cita') }}
        </x-primary-button>
    </div>
</form>

<script>
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

                    // Evitar horas pasadas si la fecha seleccionada es hoy
                    if (selectedDate.toDateString() === now.toDateString() && i <= currentHour) {
                        continue;
                    }

                    if (!data.includes(hour)) {
                        const option = document.createElement('option');
                        option.value = hour;
                        option.textContent = hour;
                        horaSelect.appendChild(option);
                    }
                }
            });
        }
    });
</script>
