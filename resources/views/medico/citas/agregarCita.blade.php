<!-- resources/views/agregarCita.blade.php -->
<form method="POST" id="cita-form" action="{{ route('citas.store') }}" class="bg-white p-6 rounded-lg shadow-lg max-w-lg mx-auto relative">
    @csrf
    <button type="button" @click="isModalOpen = false" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 focus:outline-none">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>
    <h2 class="text-2xl font-bold text-center mb-4" style="color: #316986;">Agregar Cita</h2>
    <hr class="mb-4">

    <!-- Fecha y Hora -->
    <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
            <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha</label>
            <input id="fecha" class="block w-full mt-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" type="date" name="fecha" :value="old('fecha')" required autofocus min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" />
            @error('fecha')
                <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="hora" class="block text-sm font-medium text-gray-700">Hora</label>
            <select id="hora" name="hora" class="block w-full mt-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                <!-- Options will be dynamically populated -->
            </select>
            @error('hora')
                <span class="text-red-500 text-sm mt-2">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <!-- Paciente -->
    <div class="flex items-center mb-4">
        <div class="flex-grow">
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
    </div>

    <!-- Usuario Médico (Visible but Disabled Field and Hidden Field) -->
    <div class="mb-4">
        <label for="usuariomedico" class="block text-sm font-medium text-gray-700">Usuario Médico</label>
        <input id="usuariomedico" class="block w-full mt-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" type="text" value="Daniel Ledezma Donjuan" disabled />
        <input type="hidden" id="usuariomedicoid" name="usuariomedicoid" value="1">
    </div>

    <div id="error-message" class="text-red-500 text-sm mt-2" style="display: none;"></div>

    <div class="flex items-center justify-end mt-4">
        <button type="submit" id="registrar-cita-btn" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-md shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
            Registrar Cita
        </button>
    </div>
</form>
