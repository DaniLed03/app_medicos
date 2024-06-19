<x-app-layout>
    <div class="bg-white overflow-hidden">
        <!-- Hero Section -->
        <div class="bg-primary py-12 text-center text-white">
            <img src="{{ asset('images/LedeHealth.png') }}" alt="Lede Health" class="mx-auto h-24">
            <h1 class="text-4xl font-bold">Bienvenido a LedeHealth</h1>
            <p class="mt-4 text-lg">Tu tiempo es para tus pacientes. Nosotros nos encargamos del resto.</p>
            <div class="mt-8">
                <a href="{{ route('login') }}" class="bg-secondary text-white font-bold py-3 px-6 rounded-full hover:bg-secondary-dark ml-4">Iniciar Sesión</a>
            </div>
        </div>

        <!-- Features Section -->
        <div class="py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-center text-gray-900">¿Por qué LedeHealth?</h2>
                <div class="mt-8 flex justify-around">
                    <div class="text-center max-w-xs">
                        <div class="inline-block bg-primary text-white rounded-full p-4">
                            <svg class="w-12 h-12 text-white-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h3 class="mt-4 text-xl font-semibold text-gray-900">Tu tiempo es importante</h3>
                        <p class="mt-2 text-gray-600">Creemos que tu tiempo debe ser para brindarle la mejor atención a tus pacientes.</p>
                    </div>
                    <div class="text-center max-w-xs">
                        <div class="inline-block bg-primary text-white rounded-full p-4">
                            <svg class="w-12 h-12 text-white-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M20.337 3.664c.213.212.354.486.404.782.294 1.711.657 5.195-.906 6.76-1.77 1.768-8.485 5.517-10.611 6.683a.987.987 0 0 1-1.176-.173l-.882-.88-.877-.884a.988.988 0 0 1-.173-1.177c1.165-2.126 4.913-8.841 6.682-10.611 1.562-1.563 5.046-1.198 6.757-.904.296.05.57.191.782.404ZM5.407 7.576l4-.341-2.69 4.48-2.857-.334a.996.996 0 0 1-.565-1.694l2.112-2.111Zm11.357 7.02-.34 4-2.111 2.113a.996.996 0 0 1-1.69-.565l-.422-2.807 4.563-2.74Zm.84-6.21a1.99 1.99 0 1 1-3.98 0 1.99 1.99 0 0 1 3.98 0Z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h3 class="mt-4 text-xl font-semibold text-gray-900">Producto construido para ti</h3>
                        <p class="mt-2 text-gray-600">Creamos productos fáciles de utilizar, con diseños amigables y con las funcionalidades que realmente necesitas.</p>
                    </div>
                    <div class="text-center max-w-xs">
                        <div class="inline-block bg-primary text-white rounded-full p-4">
                            <svg class="w-12 h-12 text-white-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M13.383 4.076a6.5 6.5 0 0 0-6.887 3.95A5 5 0 0 0 7 18h3v-4a2 2 0 0 1-1.414-3.414l2-2a2 2 0 0 1 2.828 0l2 2A2 2 0 0 1 14 14v4h4a4 4 0 0 0 .988-7.876 6.5 6.5 0 0 0-5.605-6.048Z"/>
                                <path d="M12.707 9.293a1 1 0 0 0-1.414 0l-2 2a1 1 0 1 0 1.414 1.414l.293-.293V19a1 1 0 1 0 2 0v-6.586l.293.293a1 1 0 0 0 1.414-1.414l-2-2Z"/>
                            </svg>
                        </div>
                        <h3 class="mt-4 text-xl font-semibold text-gray-900">Software en la nube</h3>
                        <p class="mt-2 text-gray-600">Podrás administrar expedientes médicos de tus pacientes, generar recetas y estudios de laboratorio, controlar cuentas y más.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Functionalities Section -->
        <div class="bg-gray-50 py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-center text-gray-900">Funcionalidades</h2>
                <div class="mt-8 grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8">
                    <!-- Feature Card 1 -->
                    <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                        <div class="bg-tercero text-white rounded-full p-4 inline-block">
                            <svg class="w-12 h-12 text-white-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M7 2a2 2 0 0 0-2 2v1a1 1 0 0 0 0 2v1a1 1 0 0 0 0 2v1a1 1 0 1 0 0 2v1a1 1 0 1 0 0 2v1a1 1 0 1 0 0 2v1a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H7Zm3 8a3 3 0 1 1 6 0 3 3 0 0 1-6 0Zm-1 7a3 3 0 0 1 3-3h2a3 3 0 0 1 3 3 1 1 0 0 1-1 1h-6a1 1 0 0 1-1-1Z" clip-rule="evenodd"/>
                            </svg>  
                        </div>
                        <h3 class="mt-4 text-xl font-semibold text-gray-900">Gestión de Pacientes</h3>
                        <p class="mt-2 text-gray-600">Administra los expedientes médicos de tus pacientes de manera eficiente y segura.</p>
                    </div>

                    <!-- Feature Card 2 -->
                    <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                        <div class="bg-tercero text-white rounded-full p-4 inline-block">
                            <svg class="w-12 h-12 text-white-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M5.617 2.076a1 1 0 0 1 1.09.217L8 3.586l1.293-1.293a1 1 0 0 1 1.414 0L12 3.586l1.293-1.293a1 1 0 0 1 1.414 0L16 3.586l1.293-1.293A1 1 0 0 1 19 3v18a1 1 0 0 1-1.707.707L16 20.414l-1.293 1.293a1 1 0 0 1-1.414 0L12 20.414l-1.293 1.293a1 1 0 0 1-1.414 0L8 20.414l-1.293 1.293A1 1 0 0 1 5 21V3a1 1 0 0 1 .617-.924ZM9 7a1 1 0 0 0 0 2h6a1 1 0 1 0 0-2H9Zm0 4a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2H9Zm0 4a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2H9Z" clip-rule="evenodd"/>
                            </svg>   
                        </div>
                        <h3 class="mt-4 text-xl font-semibold text-gray-900">Generación de Recetas</h3>
                        <p class="mt-2 text-gray-600">Genera y administra recetas médicas fácilmente desde cualquier dispositivo.</p>
                    </div>

                    <!-- Feature Card 3 -->
                    <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                        <div class="bg-tercero text-white rounded-full p-4 inline-block">
                            <svg class="w-12 h-12 text-white-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M5 5a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1h1a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1h1a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1 2 2 0 0 1 2 2v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V7a2 2 0 0 1 2-2ZM3 19v-7a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2Zm6.01-6a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm2 0a1 1 0 1 1 2 0 1 1 0 0 1-2 0Zm6 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm-10 4a1 1 0 1 1 2 0 1 1 0 0 1-2 0Zm6 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm2 0a1 1 0 1 1 2 0 1 1 0 0 1-2 0Z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h3 class="mt-4 text-xl font-semibold text-gray-900">Control de Citas</h3>
                        <p class="mt-2 text-gray-600">Agenda, reprograma y gestiona citas con facilidad, evitando conflictos de horarios.</p>
                    </div>

                    <!-- Feature Card 4 -->
                    <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                        <div class="bg-tercero text-white rounded-full p-4 inline-block">
                            <svg class="w-12 h-12 text-white-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 0 0-1 1H6a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2h-2a1 1 0 0 0-1-1H9Zm1 2h4v2h1a1 1 0 1 1 0 2H9a1 1 0 0 1 0-2h1V4Zm5.707 8.707a1 1 0 0 0-1.414-1.414L11 14.586l-1.293-1.293a1 1 0 0 0-1.414 1.414l2 2a1 1 0 0 0 1.414 0l4-4Z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h3 class="mt-4 text-xl font-semibold text-gray-900">Reportes y Análisis</h3>
                        <p class="mt-2 text-gray-600">Genera reportes detallados y análisis para tomar decisiones informadas y mejorar la atención.</p>
                    </div>

                    <!-- Feature Card 5 -->
                    <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                        <div class="bg-tercero text-white rounded-full p-4 inline-block">
                            <svg class="w-12 h-12 text-white-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M11.644 3.066a1 1 0 0 1 .712 0l7 2.666A1 1 0 0 1 20 6.68a17.694 17.694 0 0 1-2.023 7.98 17.406 17.406 0 0 1-5.402 6.158 1 1 0 0 1-1.15 0 17.405 17.405 0 0 1-5.403-6.157A17.695 17.695 0 0 1 4 6.68a1 1 0 0 1 .644-.949l7-2.666Zm4.014 7.187a1 1 0 0 0-1.316-1.506l-3.296 2.884-.839-.838a1 1 0 0 0-1.414 1.414l1.5 1.5a1 1 0 0 0 1.366.046l4-3.5Z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h3 class="mt-4 text-xl font-semibold text-gray-900">Acceso Seguro</h3>
                        <p class="mt-2 text-gray-600">Protege la información de tus pacientes con nuestros sistemas de seguridad avanzados.</p>
                    </div>

                    <!-- Feature Card 6 -->
                    <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                        <div class="bg-tercero text-white rounded-full p-4 inline-block">
                            <svg class="w-12 h-12 text-white-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M5 3a2 2 0 0 0-2 2v5h18V5a2 2 0 0 0-2-2H5ZM3 14v-2h18v2a2 2 0 0 1-2 2h-6v3h2a1 1 0 1 1 0 2H9a1 1 0 1 1 0-2h2v-3H5a2 2 0 0 1-2-2Z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h3 class="mt-4 text-xl font-semibold text-gray-900">Interfaz Amigable</h3>
                        <p class="mt-2 text-gray-600">Disfruta de una interfaz intuitiva y fácil de usar, diseñada para mejorar tu productividad.</p>
                    </div>

                    <!-- Feature Card 7 -->
                    <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                        <div class="bg-tercero text-white rounded-full p-4 inline-block">
                            <svg class="w-12 h-12 text-white-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.133 12.632v-1.8a5.407 5.407 0 0 0-4.154-5.262.955.955 0 0 0 .021-.106V3.1a1 1 0 0 0-2 0v2.364a.933.933 0 0 0 .021.106 5.406 5.406 0 0 0-4.154 5.262v1.8C6.867 15.018 5 15.614 5 16.807 5 17.4 5 18 5.538 18h12.924C19 18 19 17.4 19 16.807c0-1.193-1.867-1.789-1.867-4.175Zm-13.267-.8a1 1 0 0 1-1-1 9.424 9.424 0 0 1 2.517-6.391A1.001 1.001 0 1 1 6.854 5.8a7.43 7.43 0 0 0-1.988 5.037 1 1 0 0 1-1 .995Zm16.268 0a1 1 0 0 1-1-1A7.431 7.431 0 0 0 17.146 5.8a1 1 0 0 1 1.471-1.354 9.424 9.424 0 0 1 2.517 6.391 1 1 0 0 1-1 .995ZM8.823 19a3.453 3.453 0 0 0 6.354 0H8.823Z"/>
                            </svg>
                        </div>
                        <h3 class="mt-4 text-xl font-semibold text-gray-900">Soporte 24/7</h3>
                        <p class="mt-2 text-gray-600">Nuestro equipo de soporte está disponible las 24 horas del día, los 7 días de la semana, para ayudarte en cualquier momento.</p>
                    </div>

                    <!-- Feature Card 8 -->
                    <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                        <div class="bg-tercero text-white rounded-full p-4 inline-block">
                            <svg class="w-12 h-12 text-white-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m16 10 3-3m0 0-3-3m3 3H5v3m3 4-3 3m0 0 3 3m-3-3h14v-3"/>
                            </svg>
                        </div>
                        <h3 class="mt-4 text-xl font-semibold text-gray-900">Actualizaciones Constantes</h3>
                        <p class="mt-2 text-gray-600">Recibe actualizaciones periódicas con nuevas funcionalidades y mejoras.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Section -->
        <div class="py-6" style="background-color: #2D7498;">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <p class="text-white-600">&copy; 2024 LedeHealth. Todos los derechos reservados.</p>
            </div>
        </div>
    </div>
</x-app-layout>

<style>
    .bg-primary {
        background-color: #2D7498;
    }
    .bg-secondary {
        background-color: #33AD9B;
    }
    .bg-secondary-dark {
        background-color: #278A75;
    }
    .bg-tercero {
        background-color: #000000;
    }
</style>
