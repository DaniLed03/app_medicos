<x-app-layout>
    <!-- Pantalla de carga -->
    <div id="loader" class="loader-container">
        <div class="loader"></div>
    </div>
    
    <div class="py-12 flex items-center justify-center">
        <div class="bg-white shadow-lg rounded-lg p-6 text-center w-full max-w-7xl flex flex-col md:flex-row justify-between">
            <!-- Contenedor Vertical (Datos Profesionales) -->
            <div class="w-full md:w-1/3 flex flex-col items-start justify-center shadow-md rounded-lg p-6 bg-gray-100 mr-4">
                <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" class="w-48 h-48 rounded-full mx-auto mb-4">
                <h3 class="text-2xl font-semibold mb-2">Datos Profesionales</h3>
                <p class="text-gray-700 text-sm mb-0.5 text-left"><strong>Nombre:</strong> {{ Auth::user()->full_name }}</p>
                @if(Auth::user()->consultorio)
                    <p class="text-gray-700 text-sm mb-0.5 text-left"><strong>Cédula Profesional:</strong> {{ Auth::user()->consultorio->cedula_profesional }}</p>
                    <p class="text-gray-700 text-sm mb-0.5 text-left"><strong>Especialidad:</strong> {{ Auth::user()->consultorio->especialidad }}</p>
                    <p class="text-gray-700 text-sm mb-0.5 text-left"><strong>Facultad de Medicina:</strong> {{ Auth::user()->consultorio->facultad_medicina }}</p>
                @else
                    <p class="text-gray-700 text-sm mb-0.5 text-left"><strong>Cédula Profesional:</strong> No disponible</p>
                    <p class="text-gray-700 text-sm mb-0.5 text-left"><strong>Especialidad:</strong> No disponible</p>
                    <p class="text-gray-700 text-sm mb-0.5 text-left"><strong>Facultad de Medicina:</strong> No disponible</p>
                @endif
                <p class="text-gray-700 text-sm mb-0.5 text-left"><strong>Teléfono:</strong> {{ Auth::user()->telefono }}</p>
                <p class="text-gray-700 text-sm mb-0.5 text-left"><strong>Email:</strong> {{ Auth::user()->email }}</p>
            </div>
            
            <div class="w-full md:w-1/3 flex flex-col items-center justify-center shadow-md rounded-lg p-6 bg-gray-100 mr-4">
                <h3 class="text-2xl font-semibold mb-2 text-center">Avisos Pendientes</h3>
                <!-- Aquí irían los avisos pendientes -->
            </div>
            
            <!-- Contenedor Principal - Datos del Consultorio al lado derecho -->
            <div class="w-full md:w-1/3 flex flex-col items-end justify-center shadow-md rounded-lg p-6 bg-gray-100 mr-4">
                @if(Auth::user()->consultorio && Auth::user()->consultorio->logo)
                    <img src="{{ asset('storage/' . Auth::user()->consultorio->logo) }}" alt="Logo del Consultorio" class="w-48 h-48 rounded-full mx-auto mb-4">
                @else
                    <img src="{{ asset('images/default-logo.png') }}" alt="Logo del Consultorio" class="w-48 h-48 rounded-full mx-auto mb-4">
                @endif
                <h3 class="text-2xl font-semibold mb-2 text-right">Datos del Consultorio</h3>
                @if(Auth::user()->consultorio)
                    <p class="text-gray-700 text-sm mb-0.5 text-right"><strong>Entidad Federativa:</strong> {{ Auth::user()->consultorio->entidadFederativa->nombre ?? 'No disponible' }}</p>
                    <p class="text-gray-700 text-sm mb-0.5 text-right"><strong>Municipio:</strong> {{ Auth::user()->consultorio->municipio->nombre ?? 'No disponible' }}</p>
                    <p class="text-gray-700 text-sm mb-0.5 text-right"><strong>Localidad:</strong> {{ Auth::user()->consultorio->localidad->nombre ?? 'No disponible' }}</p>
                    <p class="text-gray-700 text-sm mb-0.5 text-right"><strong>Calle:</strong> {{ Auth::user()->consultorio->calle ?? 'No disponible' }}</p>
                    <p class="text-gray-700 text-sm mb-0.5 text-right"><strong>Colonia:</strong> {{ Auth::user()->consultorio->colonia ? Auth::user()->consultorio->colonia->tipo_asentamiento . ' ' . Auth::user()->consultorio->colonia->asentamiento . ', C.P. ' . Auth::user()->consultorio->colonia->cp : 'No disponible' }}</p>
                    <p class="text-gray-700 text-sm mb-0.5 text-right"><strong>Teléfono:</strong> {{ Auth::user()->consultorio->telefono ?? 'No disponible' }}</p>
                @else
                    <p class="text-gray-700 text-sm mb-0.5 text-right">No tienes un consultorio registrado.</p>
                @endif
            </div>            
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // El loader ya está visible por defecto gracias a CSS, no es necesario mostrarlo aquí.

            window.onload = function() {
                // Ocultar el loader una vez que todo el contenido se haya cargado
                document.getElementById('loader').style.display = 'none';
                // No es necesario modificar la visualización del contenido principal
            };
        });
    </script>
</x-app-layout>


<!-- Estilos adicionales -->
<style>
    /* Pantalla de carga centrada */
    .loader-container {
        position: fixed;
        z-index: 9999;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.9); /* Fondo semitransparente */
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .loader {
        border: 16px solid #f3f3f3;
        border-top: 16px solid #3498db;
        border-radius: 50%;
        width: 120px;
        height: 120px;
        animation: spin 2s linear infinite;
    }

    .shadow-lg {
        box-shadow: 0 0.15rem 1.75rem 0 rgb(33 40 50 / 15%);
    }
    .shadow-md {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .mr-4 {
        margin-right: 1rem; /* Margen derecho para separar el contenedor */
    }
    .rounded-lg {
        border-radius: 0.5rem; /* Bordes redondeados */
    }
    .bg-gray-100 {
        background-color: #f8f8f8; /* Fondo ligeramente gris para los contenedores */
    }
    .mb-0.5 {
        margin-bottom: 0.125rem; /* Menos interlineado entre los textos */
    }
    .text-sm {
        font-size: 0.875rem; /* Tamaño de fuente más pequeño */
    }
    .text-right {
        text-align: right; /* Alineación del texto a la derecha */
    }
    .text-center {
        text-align: center; /* Alineación del texto al centro */
    }

    /* Animación del loader */
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
