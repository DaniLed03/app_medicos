<div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full modal-content">
    <div class="modal-header relative">
        <div class="absolute right-0 top-0">
            <button type="button" class="text-gray" @click="isModalOpen = false">
                <svg class="h-6 w-6 fill-none stroke-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <h2 class="font-bold text-center w-full" style="color:#2D7498">Agregar Cita</h2>
    </div>
    <form method="POST" action="{{ route('citas.store') }}">
        @csrf
        <div class="form-group flex">
            <div class="mr-2 w-1/2">
                <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha</label>
                <input type="date" name="fecha" id="fecha" class="mt-1 block w-full px-3 py-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
            </div>
            <div class="ml-2 w-1/2">
                <label for="hora" class="block text-sm font-medium text-gray-700">Hora</label>
                <select name="hora" id="hora" class="mt-1 block w-full px-3 py-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                    <!-- Options will be dynamically added here by JavaScript -->
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="persona_id" class="block text-sm font-medium text-gray-700 mb-1">Persona</label>
            <div class="flex items-center">
                <select name="persona_id" id="persona" class="mt-1 block w-full px-3 py-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                    @foreach($personas as $persona)
                        <option value="{{ $persona->id }}">{{ $persona->nombres }} {{ $persona->apepat }} {{ $persona->apemat }}</option>
                    @endforeach
                </select>
                <button type="button" class="ml-2 bg-button-color text-white p-2 rounded-md" @click="isPersonaModalOpen = true">+</button>
            </div>
        </div>
        <div class="form-group" hidden>
            <label for="usuariomedico" class="block text-sm font-medium text-gray-700">Usuario Médico</label>
            <input id="usuariomedico" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-600" type="text" value="{{ Auth::user()->name }}" disabled />
            <input type="hidden" id="usuariomedicoid" name="usuariomedicoid" value="{{ Auth::id() }}">
        </div>
        <div class="form-group">
            <label for="motivo_consulta" class="block text-sm font-medium text-gray-700">Motivo de la consulta</label>
            <textarea name="motivo_consulta" id="motivo_consulta" rows="6" class="mt-1 block w-full px-3 py-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" style="resize: none;" required></textarea>
        </div>
        <div class="modal-footer">
            <button type="submit" class="bg-blue-500 text-white p-2 rounded-md">Registrar Cita</button>
        </div>
    </form>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fechaInput = document.getElementById('fecha');
        const horaSelect = document.getElementById('hora');
        const usuarioMedicoInput = document.getElementById('usuariomedicoid');

        fechaInput.addEventListener('change', function() {
            fetchHorasDisponibles();
        });

        usuarioMedicoInput.addEventListener('change', function() {
            fetchHorasDisponibles();
        });

        function fetchHorasDisponibles() {
            const fecha = fechaInput.value;
            const medicoid = usuarioMedicoInput.value;

            if (!fecha || !medicoid) return;

            fetch(`/horas-disponibles?fecha=${fecha}&medicoid=${medicoid}`)
                .then(response => response.json())
                .then(data => {
                    const horaOptions = horaSelect.options;
                    while (horaOptions.length > 0) {
                        horaOptions.remove(0);
                    }

                    for (let i = 10; i <= 23; i++) {
                        const hour = i < 10 ? `0${i}:00` : `${i}:00`;
                        if (!data.includes(hour)) {
                            const option = document.createElement('option');
                            option.value = hour;
                            option.textContent = hour;
                            horaSelect.appendChild(option);
                        }
                    }
                });
        }

        // Set the min date to today
        fechaInput.min = new Date().toISOString().split("T")[0];
    });

    // Mostrar alerta de SweetAlert2 si hay mensajes de éxito
    @if(session('status'))
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: '{{ session('status') }}',
                showConfirmButton: false,
                timer: 2500
            });
    @endif

    // Mostrar alerta de SweetAlert2 si hay mensajes de error
    @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Error',
                html: '<ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
            });
    @endif

</script>
