<x-app-layout>
    <div class="py-12" x-data="{ isModalOpen: false }">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto bg-white dark:bg-neutral-700">
                        <div class="lg:flex lg:h-full lg:flex-col">
                            <header class="flex items-center justify-between border-b border-gray-200 px-6 py-4 lg:flex-none">
                                <h1 class="text-base font-semibold leading-6 text-gray-900">
                                    <time datetime="2022-01" id="current-month">{{ \Carbon\Carbon::now()->format('F Y') }}</time>
                                </h1>
                                <div class="flex items-center">
                                    <div class="relative flex items-center rounded-md bg-white shadow-sm md:items-stretch">
                                        <button id="prev-month-btn" type="button" class="flex h-9 w-12 items-center justify-center rounded-l-md border-y border-l border-gray-300 pr-1 text-gray-400 hover:text-gray-500 focus:relative md:w-9 md:pr-0 md:hover:bg-gray-50" onclick="changeMonth(-1)">
                                            <span class="sr-only">Previous month</span>
                                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                        <span class="relative -mx-px h-5 w-px bg-gray-300 md:hidden"></span>
                                        <button type="button" class="hidden border-y border-gray-300 px-3.5 text-sm font-semibold text-gray-900 hover:bg-gray-50 focus:relative md:block" onclick="goToToday()">Mes</button>
                                        <span class="relative -mx-px h-5 w-px bg-gray-300 md:hidden"></span>
                                        <button type="button" class="flex h-9 w-12 items-center justify-center rounded-r-md border-y border-r border-gray-300 pl-1 text-gray-400 hover:text-gray-500 focus:relative md:w-9 md:pl-0 md:hover:bg-gray-50" onclick="changeMonth(1)">
                                            <span class="sr-only">Next month</span>
                                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                    <button type="button" class="ml-6 hidden border-y border-gray-300 px-3.5 text-sm font-semibold text-gray-900 hover:bg-gray-50 focus:relative md:block" onclick="goToToday()">Hoy</button>
                                    <button @click="isModalOpen = true" class="ml-6 rounded-md bg-button-color px-3 py-2 text-sm text-white shadow-sm hover:bg-button-hover focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
                                        {{ __('Agregar Cita') }}
                                    </button>
                                </div>
                            </header>                                                       
                            <div class="lg:flex lg:flex-auto lg:flex-row">
                                <!-- Calendar -->
                                <div class="shadow ring-1 ring-black ring-opacity-5 lg:flex lg:flex-auto lg:flex-col lg:w-2/3">
                                    <div class="grid grid-cols-7 gap-px border-b border-gray-300 text-center text-xs font-semibold leading-6 text-white bg-primary lg:flex-none">
                                        <div class="flex justify-center bg-primary py-2">
                                            <span>M</span>
                                            <span class="sr-only sm:not-sr-only">on</span>
                                        </div>
                                        <div class="flex justify-center bg-primary py-2">
                                            <span>T</span>
                                            <span class="sr-only sm:not-sr-only">ue</span>
                                        </div>
                                        <div class="flex justify-center bg-primary py-2">
                                            <span>W</span>
                                            <span class="sr-only sm:not-sr-only">ed</span>
                                        </div>
                                        <div class="flex justify-center bg-primary py-2">
                                            <span>T</span>
                                            <span class="sr-only sm:not-sr-only">hu</span>
                                        </div>
                                        <div class="flex justify-center bg-primary py-2">
                                            <span>F</span>
                                            <span class="sr-only sm:not-sr-only">ri</span>
                                        </div>
                                        <div class="flex justify-center bg-primary py-2">
                                            <span>S</span>
                                            <span class="sr-only sm:not-sr-only">at</span>
                                        </div>
                                        <div class="flex justify-center bg-primary py-2">
                                            <span>S</span>
                                            <span class="sr-only sm:not-sr-only">un</span>
                                        </div>
                                    </div>
                                    <div class="flex bg-gray-200 text-xs leading-6 text-gray-700 lg:flex-auto">
                                        <div class="hidden w-full lg:grid lg:grid-cols-7 lg:grid-rows-6 lg:gap-px" id="calendar-grid">
                                            <!-- Placeholder for dynamically generated days -->
                                        </div>
                                    </div>
                                </div>
                                <!-- Appointment Table -->
                                <div class="lg:flex lg:flex-auto lg:flex-col lg:w-1/3 lg:ml-4">
                                    <div class="bg-white shadow overflow-hidden rounded-lg">
                                        <div class="bg-primary text-white px-4 py-2 font-bold">Hoy</div>
                                        <div class="p-4">
                                            @foreach($citas as $cita)
                                                @if($cita->fecha === \Carbon\Carbon::now()->format('Y-m-d'))
                                                    <div class="bg-gray-100 p-3 rounded-lg mb-3 flex items-center cursor-pointer" onclick="window.location.href='{{ route('citas.editar', $cita->id) }}'">
                                                        <div class="bg-gray-200 p-2 rounded-full mr-3">
                                                            <svg class="h-6 w-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 4h10M5 11h14m-7 4h.01M12 17h.01M7 21h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                            </svg>
                                                        </div>
                                                        <div class="flex-1">
                                                            <a href="#" class="text-lg font-semibold text-gray-900">{{ $cita->nombres }} {{ $cita->apepat }} {{ $cita->apemat }}</a>
                                                            <div class="text-sm text-gray-600">{{ $cita->fecha }} - {{ $cita->hora }}</div>
                                                        </div>
                                                        <form action="{{ route('citas.eliminar', $cita->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-600 hover:text-red-900 ml-2">Eliminar</button>
                                                        </form>
                                                    </div>
                                                @endif
                                            @endforeach
                                            @if($citas->where('fecha', \Carbon\Carbon::now()->format('Y-m-d'))->isEmpty())
                                                <p class="text-center text-gray-500">No hay citas para hoy.</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div x-show="isModalOpen" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
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
        </div>
    </div>
</x-app-layout>

<style>
    .calendar-day {
        max-height: 100px; /* Adjust height as needed */
        overflow-y: auto;
    }
    .calendar-day div {
        margin-bottom: 4px; /* Space between appointments */
    }
    /* Hide scrollbar for Chrome, Safari and Opera */
    .calendar-day::-webkit-scrollbar {
        display: none;
    }
    /* Hide scrollbar for IE, Edge and Firefox */
    .calendar-day {
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
    }
    .modal {
        max-width: 400px;
        margin: 0 auto;
    }
    .bg-primary {
        background-color: #2D7498;
    }
    .bg-button-color {
        background-color: #33AD9B;
    }
    .hover\:bg-button-hover:hover {
        background-color: #278A75;
    }
    .current-day {
        background-color: #2D7498;
        border-radius: 50%;
        color: white;
        padding: 0; /* Remove padding to avoid oval shape */
        width: 30px; /* Set a fixed width */
        height: 30px; /* Set a fixed height */
        line-height: 30px; /* Center text vertically */
        text-align: center; /* Center text horizontally */
        margin: auto; /* Center the circle within its container */
    }
    .selectable {
        user-select: text;
    }
    .appointment {
        background-color: #d1d5db; /* Tailwind CSS gray-300 */
        color: #1f2937; /* Tailwind CSS gray-800 */
        padding: 2px 4px;
        border-radius: 4px;
        margin-bottom: 2px;
    }
    .day-circle {
        display: inline-block;
        margin-top: 8px; /* Ajusta el valor según sea necesario */
        margin-bottom: 8px; /* Ajusta el valor según sea necesario */
    }
</style>

<script>
    const initialDate = new Date();
    let currentDate = new Date();
    const citas = @json($citas);

    function changeMonth(monthChange) {
        const newDate = new Date(currentDate.setMonth(currentDate.getMonth() + monthChange));
        if (newDate < initialDate) {
            currentDate = initialDate;
        } else {
            currentDate = newDate;
        }
        updateCalendar();
    }

    function goToToday() {
        currentDate = new Date();
        updateCalendar();
    }

    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

    function updateCalendar() {
        const currentMonth = capitalizeFirstLetter(new Intl.DateTimeFormat('es-ES', { month: 'long' }).format(currentDate));
        const currentYear = currentDate.getFullYear();
        document.getElementById('current-month').textContent = `${currentMonth} ${currentYear}`;
        
        const firstDayOfMonth = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
        const lastDayOfMonth = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0);
        
        let calendarGrid = '';
        
        // Days of the previous month
        for (let i = firstDayOfMonth.getDay(); i > 0; i--) {
            const prevMonthDay = new Date(firstDayOfMonth);
            prevMonthDay.setDate(prevMonthDay.getDate() - i);
            calendarGrid += `<div class="relative bg-gray-50 px-3 py-2 text-gray-500">
                                <time datetime="${prevMonthDay.toISOString().split('T')[0]}">${prevMonthDay.getDate()}</time>
                            </div>`;
        }
        
        // Days of the current month
        for (let i = 1; i <= lastDayOfMonth.getDate(); i++) {
            const currentDay = new Date(currentYear, currentDate.getMonth(), i);
            const dateString = currentDay.toISOString().split('T')[0];
            let citaContent = '';
            let isToday = currentDay.toDateString() === new Date().toDateString();
            
            // Check if there are any appointments for this day
            citas.forEach(cita => {
                if (cita.fecha === dateString) {
                    citaContent += `<div class="appointment flex items-center justify-between p-1 cursor-pointer" onclick="window.location.href='/medico/citas/editar/${cita.id}'">
                                        <div class="flex items-center">
                                            <div>${cita.hora} - ${cita.nombres} ${cita.apepat} ${cita.apemat}</div>
                                        </div>
                                    </div>`;
                }
            });

            calendarGrid += `<div class="relative bg-white px-3 py-2 h-24 calendar-day">
                                <time datetime="${dateString}" class="day-circle ${isToday ? 'current-day' : ''}">${i}</time>
                                ${citaContent}
                            </div>`;
        }
        
        // Days of the next month
        const daysInNextMonth = 42 - (firstDayOfMonth.getDay() + lastDayOfMonth.getDate());
        for (let i = 1; i <= daysInNextMonth; i++) {
            const nextMonthDay = new Date(lastDayOfMonth);
            nextMonthDay.setDate(nextMonthDay.getDate() + i);
            calendarGrid += `<div class="relative bg-gray-50 px-3 py-2 text-gray-500">
                                <time datetime="${nextMonthDay.toISOString().split('T')[0]}">${nextMonthDay.getDate()}</time>
                            </div>`;
        }
        
        document.getElementById('calendar-grid').innerHTML = calendarGrid;
    }

    function changeMonth(monthChange) {
        currentDate.setMonth(currentDate.getMonth() + monthChange);
        updateCalendar();
    }

    function goToToday() {
        currentDate = new Date();
        updateCalendar();
    }

    document.addEventListener('DOMContentLoaded', updateCalendar);

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

                for (let i = 10; i <= 22; i++) { // Limiting hours from 10:00 AM to 10:00 PM
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
        const errorMessage = document.getElementById('error-message');

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
                    document.getElementById('registrar-cita-btn').disabled = true;
                } else {
                    errorMessage.style.display = 'none';
                    document.getElementById('registrar-cita-btn').disabled = false;
                }
            });
        }
    });

    document.getElementById('cita-form').addEventListener('submit', function(event) {
        const fecha = document.getElementById('fecha').value;
        const hora = document.getElementById('hora').value;
        const medicoId = document.getElementById('usuariomedicoid').value;
        const errorMessage = document.getElementById('error-message');

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
                    document.getElementById('registrar-cita-btn').disabled = true;
                } else {
                    errorMessage.style.display = 'none';
                    document.getElementById('registrar-cita-btn').disabled = false;
                    event.target.submit();
                }
            });
        }
    });
</script>
