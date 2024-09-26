<link href="https://cdn.jsdelivr.net/npm/tom-select@2.0.0/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.0.0/dist/js/tom-select.complete.min.js"></script>

<div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full modal-content border border-gray-300">
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
    <form method="POST" action="{{ route('citas.store') }}" class="space-y-4" id="addCitaForm">
        @csrf
        <div class="form-group flex space-x-4">
            <div class="w-1/2">
                <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha</label>
                <input type="date" name="fecha" id="fecha" class="mt-1 block w-full px-4 py-2 rounded-md border border-gray-400 focus:border-gray-500 shadow-sm focus:ring-gray-500" required>
            </div>            
            <div class="w-1/2">
                <label for="hora" class="block text-sm font-medium text-gray-700">Hora</label>
                <select name="hora" id="hora" class="mt-1 block w-full px-4 py-2 rounded-md border border-gray-400 focus:border-gray-500 shadow-sm focus:ring-gray-500" required></select>
            </div>
        </div>
        
        <div class="form-group">
            <label for="paciente_no_exp" class="block text-sm font-medium text-gray-700">Paciente</label>
            <div class="flex items-center space-x-2">
                <select id="paciente_no_exp" name="paciente_no_exp" placeholder="Buscar paciente..." class="mt-1 block w-full px-4 py-2 rounded-md border border-gray-400 focus:border-gray-500 shadow-sm focus:ring-gray-500" required></select>
                <button type="button" class="bg-[#33AD9B] hover:bg-[#33AD9B] text-white p-2 rounded-md" @click="isPacienteModalOpen = true">+</button>
            </div>
        </div>
        
        <div class="form-group">
            <label for="motivo_consulta" class="block text-sm font-medium text-gray-700">Motivo de la consulta</label>
            <textarea name="motivo_consulta" id="motivo_consulta" rows="6" class="mt-1 block w-full px-4 py-2 rounded-md border border-gray-400 focus:border-gray-500 shadow-sm focus:ring-gray-500" style="resize: none;" required></textarea>
        </div>
        
        <div class="modal-footer text-right">
            <button type="submit" id="guardarCita" class="bg-blue-500 text-white p-2 rounded-md shadow-md">Registrar Cita</button>
        </div>        
    </form>   
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializa Tom Select con búsqueda remota
        new TomSelect("#paciente_no_exp", {
            create: false,
            load: function(query, callback) {
                if (!query.length) return callback();
                fetch(`/search-pacientes?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        callback(data.map(paciente => ({ 
                            value: paciente.no_exp, 
                            text: `${paciente.full_name}` 
                        })));
                    }).catch(() => {
                        callback();
                    });
            }
        });

        // Muestra mensajes de éxito o error
        @if(session('status'))
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: '{{ session('status') }}',
                showConfirmButton: false,
                timer: 2500
            });
        @endif

        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Error',
                html: '<ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
            });
        @endif

        // Desactivar el botón después de hacer clic en "Registrar Cita"
        document.getElementById('addCitaForm').addEventListener('submit', function() {
            const submitButton = document.getElementById('guardarCita');
            submitButton.disabled = true;
            submitButton.innerText = 'Guardando...'; // Cambiar el texto del botón mientras se guarda
        });
    });
    
    document.addEventListener('DOMContentLoaded', function() {
        const fechaInput = document.getElementById('fecha');
        const today = new Date().toISOString().split('T')[0]; // Obtener la fecha actual en formato YYYY-MM-DD
        fechaInput.setAttribute('min', today); // Establecer la fecha mínima

        fechaInput.addEventListener('change', function() {
            const fecha = fechaInput.value;
            if (!fecha) return;

            // Primero obtenemos los horarios disponibles para el día seleccionado
            fetch(`/obtener-horarios-por-dia?fecha=${encodeURIComponent(fecha)}`)
                .then(response => response.json())
                .then(data => {
                    const horaSelect = document.getElementById('hora');
                    horaSelect.innerHTML = ''; // Limpiar el select

                    if (data.mensaje) {
                        Swal.fire({
                            icon: 'info',
                            title: 'Sin horarios',
                            text: data.mensaje,
                            confirmButtonColor: '#007BFF',
                        });
                    } else {
                        // Después obtenemos las horas ocupadas para la fecha seleccionada
                        fetch(`/obtener-horas-ocupadas?fecha=${encodeURIComponent(fecha)}`)
                            .then(response => response.json())
                            .then(ocupadas => {
                                // Revisamos los horarios disponibles y deshabilitamos los ocupados
                                data.forEach(horario => {
                                    if (horario.turno) {
                                        const option = document.createElement('option');
                                        option.disabled = true;
                                        option.textContent = horario.turno;
                                        option.style.fontWeight = 'bold';
                                        horaSelect.appendChild(option);
                                    } else if (horario.inicio) {
                                        const option = document.createElement('option');
                                        option.value = horario.inicio;
                                        option.textContent = horario.inicio;

                                        // Verificamos si la hora está ocupada y la deshabilitamos si es necesario
                                        if (ocupadas.includes(horario.inicio)) {
                                            option.disabled = true; // Deshabilitar la hora si está ocupada
                                            option.textContent += " (Ocupada)";
                                        }

                                        horaSelect.appendChild(option);
                                    }
                                });
                            })
                            .catch(() => {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Hubo un problema al cargar las horas ocupadas.',
                                    confirmButtonColor: '#007BFF',
                                });
                            });
                    }
                })
                .catch(() => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Hubo un problema al cargar los horarios.',
                        confirmButtonColor: '#007BFF',
                    });
                });
        });
    });
</script>
<style>
    select#hora {
        max-height: 200px; /* Ajusta la altura máxima de la lista desplegable */
        overflow-y: auto;  /* Permite que aparezca el scroll si es necesario */
        scroll-behavior: smooth; /* Suaviza el desplazamiento */
        padding-right: 20px; /* Agrega espacio adicional para que no corte la lista con el scroll */
    }
</style>

