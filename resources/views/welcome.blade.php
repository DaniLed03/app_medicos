<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LedeHealth</title>
    <link rel="icon" href="{{ asset('images/LedeHealth.ico') }}" type="image/x-icon">
</head>

<x-app-layout>
    <div class="bg-white overflow-hidden">
        
        <!-- Navbar Section -->
        <div class="text-white py-2 fixed top-0 left-0 right-0 z-10" style="background-color: #2D7498;">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <!-- Título alineado a la izquierda -->
                <div class="text-lg font-bold text-left">LedeHealth</div>
                <!-- Botón de Hamburguesa alineado a la derecha -->
                <div class="block md:hidden text-right">
                    <button id="menu-toggle" class="text-white focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                        </svg>
                    </button>
                </div>
                <!-- Opciones de Menú -->
                <div id="nav-content" class="hidden md:flex space-x-4">
                    <a href="#nosotros" class="text-white hover:underline">Nosotros</a>
                    <a href="#por-que-ledehealth" class="text-white hover:underline">¿Por qué LedeHealth?</a>
                    <a href="#funcionalidades" class="text-white hover:underline">Funcionalidades</a>
                    <a href="{{ route('login') }}" class="text-white font-bold py-2 px-4 rounded-full hover:bg-secondary-dark" style="background-color: #33AD9B;">Iniciar Sesión</a>
                </div>
            </div>
        </div>

        <!-- Hero Section -->
        <div class="py-20 text-center text-white" style="background-color: #2D7498;">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center">
                <!-- Contenedor para el logo y el texto -->
                <div class="md:flex-1 flex flex-col md:flex-row mr-12">
                    <div class="md:w-1/2"> <!-- Logo -->
                        <img src="{{ asset('images/LedeHealth.png') }}" alt="Lede Health" class="h-74 mx-auto">
                    </div>
                    <div class="md:w-1/2 mt-8 md:mt-0 md:text-center"> <!-- Texto -->
                        <h1 class="text-5xl font-bold">Tu tiempo es para tus pacientes</h1>
                        <p class="mt-4 text-xl">En LedeHealth creemos que tu valioso tiempo debe ser para brindarle la mejor atención a tus pacientes.</p>
                    </div>
                </div>
                <!-- Contenedor para el carrusel -->
                <div class="md:flex-1 mt-8 md:mt-0">
                    <!-- Slider Section -->
                    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel" data-interval="3000">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img class="d-block w-100 h-64" src="{{ asset('images/consultas.jpg') }}" alt="Consultas">
                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100 h-64" src="{{ asset('images/pacientes.jpg') }}" alt="Pacientes">
                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100 h-64" src="{{ asset('images/citas.jpg') }}" alt="Citas">
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Nosotros Section -->
        <div id="nosotros" class="py-12 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-center text-gray-900">Nosotros</h2>
                <div class="mt-8 flex flex-col md:flex-row items-center md:space-x-8">
                    <div class="md:w-1/2">
                        <img src="{{ asset('images/team.webp') }}" alt="Nuestro equipo" class="rounded-lg shadow-lg w-55 h-auto">
                    </div>
                    <div class="md:w-1/2 mt-8 md:mt-0">
                        <p class="text-2xl text-gray-600 text-justify">En LedeHealth, nos dedicamos a proporcionar soluciones tecnológicas de vanguardia para el sector salud. Nuestro equipo está compuesto por profesionales apasionados y experimentados que trabajan incansablemente para ofrecer productos y servicios que mejoren la calidad de vida de los pacientes y optimicen la gestión médica.</p>
                        <p class="mt-4 text-2xl text-gray-600 text-justify">Desde nuestra fundación, hemos crecido y evolucionado, siempre con el objetivo de estar a la vanguardia en tecnología de la salud. Creemos en la innovación constante y en la mejora continua de nuestros productos para satisfacer las necesidades cambiantes de nuestros clientes.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div id="por-que-ledehealth" class="py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center space-y-8 md:space-y-0 md:space-x-8">
                <div class="md:w-1/2 flex flex-col items-center md:items-start space-y-8">
                    <h2 class="text-3xl font-bold text-center md:text-left text-gray-900">¿Por qué LedeHealth?</h2>
                    <div class="flex items-start space-x-4">
                        <div class="inline-block bg-feature-circle text-white rounded-full p-4">
                            <svg class="w-12 h-12 text-white-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="text-left">
                            <h3 class="text-xl font-semibold text-gray-900 text-center">Tu tiempo es importante</h3>
                            <p class="mt-2 text-gray-600 text-center">Creemos que tu tiempo debe ser para brindarle la mejor atención a tus pacientes.</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-4">
                        <div class="inline-block bg-feature-circle text-white rounded-full p-4">
                            <svg class="w-12 h-12 text-white-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M20.337 3.664c.213.212.354.486.404.782.294 1.711.657 5.195-.906 6.76-1.77 1.768-8.485 5.517-10.611 6.683a.987.987 0 0 1-1.176-.173l-.882-.88-.877-.884a.988.988 0 0 1-.173-1.177c1.165-2.126 4.913-8.841 6.682-10.611 1.562-1.563 5.046-1.198 6.757-.904.296.05.57.191.782.404ZM5.407 7.576l4-.341-2.69 4.48-2.857-.334a.996.996 0 0 1-.565-1.694l2.112-2.111Zm11.357 7.02-.34 4-2.111 2.113a.996.996 0 0 1-1.69-.565l-.422-2.807 4.563-2.74Zm.84-6.21a1.99 1.99 0 1 1-3.98 0 1.99 1.99 0 0 1 3.98 0Z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="text-left">
                            <h3 class="text-xl font-semibold text-gray-900 text-center">Producto construido para ti</h3>
                            <p class="mt-2 text-gray-600 text-center">Creamos productos fáciles de utilizar, con diseños amigables y con las funcionalidades que realmente necesitas.</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-4">
                        <div class="inline-block bg-feature-circle text-white rounded-full p-4">
                            <svg class="w-12 h-12 text-white-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M13.383 4.076a6.5 6.5 0 0 0-6.887 3.95A5 5 0 0 0 7 18h3v-4a2 2 0 0 1-1.414-3.414l2-2a2 2 0 0 1 2.828 0l2 2A2 2 0 0 1 14 14v4h4a4 4 0 0 0 .988-7.876 6.5 6.5 0 0 0-5.605-6.048Z"/>
                                <path d="M12.707 9.293a1 1 0 0 0-1.414 0l-2 2a1 1 0 1 0 1.414 1.414l.293-.293V19a1 1 0 1 0 2 0v-6.586l.293.293a1 1 0 0 0 1.414-1.414l-2-2Z"/>
                            </svg>
                        </div>
                        <div class="text-left">
                            <h3 class="text-xl font-semibold text-gray-900 text-center">Software en la nube</h3>
                            <p class="mt-2 text-gray-600 text-center">Podrás administrar expedientes médicos de tus pacientes, generar recetas y estudios de laboratorio, controlar cuentas y más.</p>
                        </div>
                    </div>
                </div>
                <div class="md:w-1/2">
                    <img src="{{ asset('images/Hospital.webp') }}" alt="Hospital" class="rounded-lg shadow-lg">
                </div>
            </div>
        </div>



        <!-- Functionalities Section -->
        <div id="funcionalidades" class="bg-gray-50 py-12">
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
    .bg-tercero {
        background-color: #000000;
    }

    .bg-feature-circle {
        background-color: #2D7498;
    }

    .bg-register-button {
        background-color: #33AD9B;
    }

    /* Cambio de color de hover para los círculos */
    .inline-block.bg-feature-circle:hover {
        background-color: #2D7498;
    }

    /* Cambio de color de hover para el botón "Crear cuenta" */
    .bg-secondary:hover {
        background-color: #33AD9B;
    }

    @media (max-width: 768px) {
        #nav-content {
            display: none;
            flex-direction: column;
            text-align: center;
            background-color: #2D7498;
        }

        #nav-content.active {
            display: flex;
        }

        .flex {
            flex-direction: column;
        }

        .md\:flex-1 {
            width: 100%;
        }

        .md\:w-1\/2 {
            width: 100%;
            text-align: center;
        }

        .mr-12 {
            margin-right: 0;
        }
        
        .space-x-4 > * {
            margin-right: 10px;
        }
        .space-x-4 > *:last-child {
            margin-right: 0;
        }

        /* Alineación de íconos y texto en el centro */
        .flex.items-start.space-x-4 {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        .inline-block.bg-feature-circle {
            margin-bottom: 10px;
        }
        .text-left {
            text-align: center;
        }

        /* Botones uno al lado del otro */
        .mt-8.flex.justify-between.space-x-4 a {
            width: 48%;
            text-align: center;
        }
        .mt-8.flex.justify-between.space-x-4 {
            flex-direction: row;
            justify-content: space-between;
        }
    }

    @media (max-width: 768px) {
        .text-lg.font-bold.text-left {
            flex: 1;
            text-align: left;
        }
        .block.md\:hidden.text-right {
            flex: 1;
            text-align: right;
        }
    }

</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const menuToggle = document.getElementById('menu-toggle');
        const navContent = document.getElementById('nav-content');

        menuToggle.addEventListener('click', function() {
            navContent.classList.toggle('active');
        });
    });
</script>
