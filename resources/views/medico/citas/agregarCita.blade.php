<!-- resources/views/agregarCita.blade.php -->
<form method="POST" id="cita-form" action="{{ route('citas.store') }}" class="bg-white p-6 rounded-lg shadow-lg max-w-lg mx-auto relative" x-data="citaForm()">
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
    <div class="relative mb-4">
        <label for="search" class="block text-sm font-medium text-gray-700">Buscar Paciente</label>
        <input type="text" id="search" x-model="search" @input="filterPacientes" @focus="showOptions = true" @blur="hideOptions()" class="block w-full mt-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Escribe para buscar...">
        <ul x-show="showOptions && filteredPacientes.length > 0" @mousedown.away="showOptions = false" class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
            <template x-for="paciente in filteredPacientes" :key="paciente.id">
                <li @click="selectPaciente(paciente)" class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-indigo-600 hover:text-white">
                    <span x-text="paciente.nombres + ' ' + paciente.apepat + ' ' + paciente.apemat" class="block truncate"></span>
                </li>
            </template>
        </ul>
        <input type="hidden" name="pacienteid" x-model="selectedPaciente.id">
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

<script>
    function citaForm() {
        return {
            search: '',
            pacientes: @json($pacientes),
            filteredPacientes: [],
            selectedPaciente: null,
            showOptions: false,
            filterPacientes() {
                this.filteredPacientes = this.pacientes.filter(paciente => {
                    const searchLower = this.search.toLowerCase();
                    const nombresLower = paciente.nombres.toLowerCase();
                    const apepatLower = paciente.apepat.toLowerCase();
                    const apematLower = paciente.apemat.toLowerCase();
                    return nombresLower.includes(searchLower) || apepatLower.includes(searchLower) || apematLower.includes(searchLower);
                });
                this.showOptions = true; // Show options while typing
            },
            selectPaciente(paciente) {
                this.search = `${paciente.nombres} ${paciente.apepat} ${paciente.apemat}`;
                this.selectedPaciente = paciente;
                this.showOptions = false;
            },
            hideOptions() {
                setTimeout(() => {
                    this.showOptions = false;
                }, 100); // Delay to allow click event to register
            }
        }
    }
</script>
