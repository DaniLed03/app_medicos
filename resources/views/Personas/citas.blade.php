<x-app-layout>
    <div class="py-12" x-data="{ isModalOpen: false }">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto bg-white dark:bg-neutral-700">
                        <div class="lg:flex lg:h-full lg:flex-col">
                            <div class="lg:flex lg:flex-auto lg:flex-row">
                                <!-- FullCalendar -->
                                <div class="lg:flex lg:flex-auto lg:flex-col lg:w-3/4">
                                    <div id="calendar" class="p-6 no-scrollbar"></div>
                                </div>
                                <!-- Appointment Table -->
                                <div class="lg:flex lg:flex-auto lg:flex-col lg:w-1/4 lg:ml-4">
                                    <div class="bg-white shadow overflow-hidden rounded-lg h-full">
                                        <div class="flex items-center justify-between px-4 py-2 font-bold text-white" style="background-color: #2D7498;">
                                            Hoy
                                        </div>
                                        <div class="p-4 overflow-y-auto max-h-screen no-scrollbar">
                                            @foreach($citas as $cita)
                                                @if($cita->fecha === \Carbon\Carbon::now()->format('Y-m-d'))
                                                    <div class="bg-gray-100 p-3 rounded-lg mb-3 flex items-center cursor-pointer">
                                                        <div class="bg-gray-200 p-2 rounded-full mr-3">
                                                            <svg class="h-6 w-6 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 4h10M5 11h14m-7 4h.01M12 17h.01M7 21h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                            </svg>
                                                        </div>
                                                        <div class="flex-1">
                                                            <a href="{{ route('citas.editar', $cita->id) }}" class="text-lg font-semibold text-gray-900">{{ $cita->nombres }} {{ $cita->apepat }} {{ $cita->apemat }}</a>
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
    </div>
</x-app-layout>

<style>
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
        background-color: #1DC2DF;
        border-radius: 50%;
        color: white;
        padding: 0; /* Remove padding to avoid oval shape */
        width: 30px; /* Set a fixed width */
        height: 30px; /* Set a fixed height */
        line-height: 30px; /* Center text vertically */
        text-align: center; /* Center text horizontally */
        margin: auto; /* Center the circle within its container */
    }
    .fc-daygrid-day-events {
        max-height: 80px; /* Adjust this value as needed */
        overflow-y: auto;
        scrollbar-width: none; /* Firefox */
    }
    .fc-daygrid-day-events::-webkit-scrollbar {
        display: none; /* Chrome, Safari and Opera */
    }
    .fc-daygrid-day {
        height: 150px; /* Adjust this value to ensure uniform height */
    }
    .fc-daygrid-day-frame {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
    }
    /* Hide scrollbar */
    .no-scrollbar::-webkit-scrollbar {
        display: none; /* Chrome, Safari and Opera */
    }
    .no-scrollbar {
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
    }

    /* Custom FullCalendar Styles */
    .fc .fc-toolbar.fc-header-toolbar {
        background-color: white;
        color: black;
    }

    .fc .fc-button {
        background-color: #B0BEC5;
        border-color: #B0BEC5;
        color: black;
    }

    .fc .fc-button:hover {
        background-color: #90A4AE;
        border-color: #90A4AE;
    }

    .fc .fc-col-header-cell {
        background-color: #2D7498;
        color: white;
    }

    .fc-event {
        color: black; /* Text color for events */
    }

    #month:selected, #week:selected, #day:selected {
        background-color: grey;
    }

    /* Additional styles to manage modal z-index */
    .modal-backdrop.show {
        opacity: 0.5;
    }

    #agregarPacienteModal {
        z-index: 1060;
    }

    #agregarPacienteModal .modal-backdrop {
        z-index: 1050;
    }

    /* Estilo para el fondo oscuro */
    .modal-backdrop {
        z-index: 1040; /* Fondo oscuro con menor z-index */
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 10px;
        margin-bottom: 20px;
        justify-content: center; /* Centra horizontalmente */
        text-align: center;
    }
    .modal-header h2 {
        font-size: 1.75rem; /* Ajusta el tamaño del título */
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'es',
            headerToolbar: {
                left: 'prev,today,next',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: {!! json_encode($citas->map(function($cita) {
                return [
                    'title' => $cita->nombres . ' ' . $cita->apepat . ' ' . $cita->apemat,
                    'start' => $cita->fecha . 'T' . $cita->hora,
                    'url' => route('citas.editar', $cita->id),
                    'color' => '#33AD9B',
                    'textColor' => 'black'
                ];
            })) !!},
            dateClick: function(info) {
                document.querySelector('[x-data]').__x.$data.isModalOpen = true;
            },
            eventClick: function(info) {
                window.location.href = info.event.url;
                info.jsEvent.preventDefault();
            },
            dayCellDidMount: function(info) {
                var today = new Date();
                var cellDate = new Date(info.date);
                if (cellDate.setHours(0, 0, 0, 0) === today.setHours(0, 0, 0, 0)) {
                    info.el.style.backgroundColor = '#EBF2F4';
                }
            },
            slotMinTime: '10:00:00',
            slotMaxTime: '23:00:00',
            allDaySlot: false,
            height: 'auto'
        });

        calendar.render();
    });
</script>
