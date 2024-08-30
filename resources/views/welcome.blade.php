<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LedeHealth</title>
    <link rel="icon" href="{{ asset('images/LedeHealth.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css"/>
    <style>
        @import url("https://rsms.me/inter/inter.css");
        html {
            font-family: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI",
            Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif,
            "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol",
            "Noto Color Emoji";
        }
        .hero-bg {
            background-color: #316986;
        }
        .hero-bg {
            min-height: 85vh; /* Ajusta esto según sea necesario */
        }
        button,
        .gradient2 {
            background-color: #f39f86;
            background-image: linear-gradient(315deg, #f39f86 0%, #f9d976 74%);
        }
        .gradient {
            background-image: linear-gradient(-225deg, #316986 0%, #316986 100%);
        }
        .browser-mockup {
            border-top: 2em solid rgba(230, 230, 230, 0.7);
            position: relative;
            height: 85vh;
        }
        .browser-mockup:before {
            display: block;
            position: absolute;
            content: "";
            top: -1.25em;
            left: 1em;
            width: 0.5em;
            height: 0.5em;
            border-radius: 50%;
            background-color: #f44;
            box-shadow: 0 0 0 2px #f44, 1.5em 0 0 2px #9b3, 3em 0 0 2px #fb5;
        }
        .browser-mockup > * {
            display: block;
        }
        @media (max-width: 768px) {
            .browser-mockup {
                height: 40vh; /* Reduce el tamaño del contenedor a la mitad */
            }

            /* Ajusta la navegación para que se vea como en la segunda imagen */
            nav#header {
                background-color: #33AD9B;
            }

            /* Centra el contenido y reduce el tamaño de los elementos */
            .hero-bg {
                padding: 1rem;
            }

            .hero-bg h1 {
                font-size: 1.5rem; /* Reduce el tamaño del título */
            }

            .hero-bg p {
                font-size: 1rem; /* Reduce el tamaño del párrafo */
            }

            .hero-bg button {
                font-size: 0.875rem; /* Reduce el tamaño del botón */
                width: auto; /* Ajusta el ancho del botón al contenido */
                padding: 0.5rem 1rem; /* Ajusta el padding */
            }

            /* Ajusta el padding en el footer */
            footer {
                padding: 2rem 1rem;
            }
        }

        nav#header {
            background-color: #316986; /* Color original */
        }

        /* Estilo del contenedor del menú cuando se despliega */
        #nav-content {
            background-color: #33AD9B; /* Color al abrirse */
            border-radius: 15px; /* Bordes redondeados */
            padding: 1.5rem; /* Espaciado interno */
            display: none;
            text-align: left; /* Alinear contenido a la izquierda */
        }

        /* Estilo de los enlaces de navegación */
        #nav-content a {
            display: block;
            color: #FFFFFF; /* Texto blanco */
            font-size: 1.125rem; /* Tamaño de fuente */
            margin-bottom: 1rem; /* Espaciado inferior */
            text-decoration: none;
            text-align: left; /* Alinear enlaces a la izquierda */
        }

        /* Estilo del botón de acción */
        #navAction {
            display: inline-block;
            background-color: #316986; /* Color del botón */
            padding: 0.75rem 2rem; /* Espaciado interno */
            font-size: 1rem; /* Tamaño de fuente */
            color: #FFFFFF; /* Texto blanco */
            border-radius: 9999px; /* Botón con borde completamente redondeado */
            margin-top: 2rem; /* Espaciado superior */
            text-align: center; /* Centrar el texto dentro del botón */
            width: 100%; /* Ancho completo para centrar el botón */
        }

        /* Cambiar color del icono de hamburguesa a blanco */
        #nav-toggle svg {
            fill: #FFFFFF; /* Color blanco para el icono */
        }

        /* Ajustes en modo móvil */
        @media (max-width: 768px) {
            #nav-content.active {
                display: block;
            }
        }

       /* Enlaces de navegación */
        #header .hidden.lg\\:flex.space-x-4 a {
            margin-right: 5px; /* Reduce aún más la separación entre los accesos directos */
        }

        /* Botón de Iniciar Sesión */
        .hidden.lg\:flex.items-center.space-x-4 a {
            display: flex;
            justify-content: center; /* Centra el texto horizontalmente */
            align-items: center; /* Centra el texto verticalmente */
            margin-top: 0; /* Elimina el margen superior */
            padding: 10px 20px; /* Ajusta el padding para centrar mejor el texto */
            background-color: #33AD9B; /* Color de fondo */
            color: #000000; /* Color de texto */
            border-radius: 9999px; /* Bordes redondeados */
            text-align: center; /* Asegura el centrado del texto */
            width: auto; /* Ajusta el ancho automáticamente */
            margin-left: auto; /* Asegura que el botón se mantenga a la derecha */
            text-decoration: none; /* Asegura que el texto no tenga subrayado */
        }


        /* Contenedor de los enlaces y el botón */
        #header .hidden.lg\\:flex.items-center.space-x-4 {
            justify-content: flex-end; /* Asegura que los elementos estén alineados a la derecha */
            gap: 10px; /* Ajusta el espacio entre los enlaces y el botón */
        }

        #header a {
            text-decoration: none; /* Elimina el subrayado */
        }


    </style>
</head>

<x-app-layout>
    <body class="leading-relaxed tracking-wide flex flex-col">
        <div class="hero-bg">
            <!-- Nav -->
            <nav id="header" class="w-full z-30 top-0 text-white py-1 lg:py-6">
                <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 px-2 py-2 lg:py-6">
                    <div class="flex items-center">
                        <a class="flex items-center text-white no-underline hover:no-underline font-bold text-2xl lg:text-4xl" href="#">
                            <img src="{{ asset('images/LedeHealth.png') }}" alt="LedeHealth Logo" class="h-12 w-12 mr-2"> 
                            LedeHealth
                        </a>
                    </div>
                    <div class="hidden lg:flex space-x-6">
                        <a href="#nosotros" class="text-white hover:underline">Nosotros</a>
                        <a href="#por-que-ledehealth" class="text-white hover:underline">¿Por qué LedeHealth?</a>
                        <a href="#funcionalidades" class="text-white hover:underline">Funcionalidades</a>
                    </div>
                    <div class="hidden lg:flex items-center space-x-4">
                        <a href="{{ route('login') }}" class="mx-auto lg:mx-0 hover:underline text-gray-800 font-extrabold rounded my-2 md:my-6 py-4 px-8 shadow-lg w-48" style="background-color: #33AD9B;">
                            Iniciar Sesión
                        </a>
                    </div>
                    <!-- Botón de hamburguesa (solo visible en versión móvil) -->
                    <div class="lg:hidden pr-4">
                        <button id="nav-toggle" class="flex items-center px-3 py-2 border rounded text-gray-500 border-gray-600 hover:text-gray-800 hover:border-green-500 appearance-none focus:outline-none">
                            <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <title>Menu</title>
                                <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/>
                            </svg>
                        </button>
                    </div>

                </div>
            </nav>
            
            <!-- Mobile Menu -->
            <div id="nav-content" class="w-full flex-grow lg:hidden items-center lg:w-auto hidden lg:block mt-2 lg:mt-0 text-white p-4 lg:p-0 z-20">
                <ul class="list-reset lg:flex flex-col items-start flex-1">
                    <li>
                        <a href="#nosotros">Nosotros</a>
                    </li>
                    <li>
                        <a href="#por-que-ledehealth">¿Por qué LedeHealth?</a>
                    </li>
                    <li>
                        <a href="#funcionalidades">Funcionalidades</a>
                    </li>
                    <li class="mt-4">
                        <a href="{{ route('login') }}" class="w-full block text-center font-extrabold rounded py-4 px-8 shadow-lg" style="background-color: #316986;">
                            Iniciar Sesión
                        </a>
                    </li>
                </ul>
            </div>

            
            <!-- Hero Section -->
            <div class="container mx-auto h-screen">
                <div class="text-center px-3 lg:px-0">
                    <h1 class="my-4 text-3xl md:text-4xl lg:text-6xl font-black leading-tight text-white">Tu tiempo es para tus pacientes</h1>
                    <p class="leading-normal text-white text-lg md:text-2xl lg:text-3xl mb-8">
                        En LedeHealth creemos que tu valioso tiempo debe ser para brindarle la mejor atención a tus pacientes.
                    </p>
                    <button href="{{ route('register') }}" class="mx-auto lg:mx-0 hover:underline text-gray-800 font-extrabold rounded my-2 md:my-6 py-4 px-8 shadow-lg w-48" style="background-color: #33AD9B;">
                        Registrarse
                    </button>
                </div>
                <div class="flex items-center w-full mx-auto content-end">
                    <div id="carouselExampleIndicators" class="browser-mockup flex flex-1 m-6 md:px-0 md:m-14 bg-white w-1/2 rounded shadow-xl carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                        </div>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="{{ asset('images/agenda.jpg') }}" class="d-block w-full h-full object-cover rounded" alt="Doctor y paciente 1">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('images/cons.jpg') }}" class="d-block w-full h-full object-cover rounded" alt="Doctor y paciente 2">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('images/pas.jpg') }}" class="d-block w-full h-full object-cover rounded" alt="Doctor y paciente 3">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>                
            </div>
        </div>
        <br>
        <br>
        <br>
        <br>
        <br>

        <!-- Nosotros Section -->
        <div id="nosotros" class="py-12 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="w-full text-5xl font-black leading-tight text-center text-gray-900 mb-8">Nosotros</h2>
                <!-- Linea debajo del titulo -->
                <div class="w-full mb-4">
                    <div class="h-1 mx-auto gradient w-64 opacity-25 my-0 py-0 rounded-t"></div>
                </div>
                <div class="flex flex-col-reverse md:flex-row items-center">
                    <div class="md:w-1/2 md:pr-8">
                        <p class="text-xl text-gray-600 mb-4 text-justify">En LedeHealth, nos dedicamos a proporcionar soluciones tecnológicas de vanguardia para el sector salud. Nuestro equipo está compuesto por profesionales apasionados y experimentados que trabajan incansablemente para ofrecer productos y servicios que mejoren la calidad de vida de los pacientes y optimicen la gestión médica.</p>
                        <p class="text-xl text-gray-600 mb-4 text-justify">Desde nuestra fundación, hemos crecido y evolucionado, siempre con el objetivo de estar a la vanguardia en tecnología de la salud. Creemos en la innovación constante y en la mejora continua de nuestros productos para satisfacer las necesidades cambiantes de nuestros clientes.</p>
                    </div>
                    <div class="md:w-1/2 md:pl-8 mb-8 md:mb-0">
                        <img src="{{ asset('images/Team.jpg') }}" alt="Nuestro equipo" class="rounded-lg shadow-lg w-full">
                    </div>
                </div>
            </div>
        </div>

        <!-- ¿Por qué LedeHealth? Section -->
        <div class="container mx-auto py-12">
            <h2 class="text-4xl md:text-5xl font-black leading-tight text-center text-gray-900 mb-12">
                ¿Por qué LedeHealth?
            </h2>
            <!-- Línea debajo del título -->
            <div class="w-full mb-8">
                <div class="h-1 mx-auto gradient w-64 opacity-25 my-0 py-0 rounded-t"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Primer bloque -->
                <div class="text-center">
                    <div class="bg-[#33AD9B] text-white rounded-full p-6 inline-flex items-center justify-center mb-4">
                        <svg class="w-10 h-10" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl md:text-3xl font-semibold text-gray-900 mb-2">Tu tiempo es importante</h3>
                    <p class="text-lg md:text-xl text-gray-600">Creemos que tu tiempo debe ser para brindarle la mejor atención a tus pacientes.</p>
                </div>
                <!-- Segundo bloque -->
                <div class="text-center">
                    <div class="bg-[#33AD9B] text-white rounded-full p-6 inline-flex items-center justify-center mb-4">
                        <svg class="w-10 h-10" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M20.337 3.664c.213.212.354.486.404.782.294 1.711.657 5.195-.906 6.76-1.77 1.768-8.485 5.517-10.611 6.683a.987.987 0 0 1-1.176-.173l-.882-.88-.877-.884a.988.988 0 0 1-.173-1.177c1.165-2.126 4.913-8.841 6.682-10.611 1.562-1.563 5.046-1.198 6.757-.904.296.05.57.191.782.404ZM5.407 7.576l4-.341-2.69 4.48-2.857-.334a.996.996 0 0 1-.565-1.694l2.112-2.111Zm11.357 7.02-.34 4-2.111 2.113a.996.996 0 0 1-1.69-.565l-.422-2.807 4.563-2.74Zm.84-6.21a1.99 1.99 0 1 1-3.98 0 1.99 1.99 0 0 1 3.98 0Z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl md:text-3xl font-semibold text-gray-900 mb-2">Producto construido para ti</h3>
                    <p class="text-lg md:text-xl text-gray-600">Creamos productos fáciles de utilizar, con diseños amigables y con las funcionalidades que realmente necesitas.</p>
                </div>
                <!-- Tercer bloque -->
                <div class="text-center">
                    <div class="bg-[#33AD9B] text-white rounded-full p-6 inline-flex items-center justify-center mb-4">
                        <svg class="w-10 h-10" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M13.383 4.076a6.5 6.5 0 0 0-6.887 3.95A5 5 0 0 0 7 18h3v-4a2 2 0 0 1-1.414-3.414l2-2a2 2 0 0 1 2.828 0l2 2A2 2 0 0 1 14 14v4h4a4 4 0 0 0 .988-7.876 6.5 6.5 0 0 0-5.605-6.048Z"/>
                            <path d="M12.707 9.293a1 1 0 0 0-1.414 0l-2 2a1 1 0 1 0 1.414 1.414l.293-.293V19a1 1 0 1 0 2 0v-6.586l.293.293a1 1 0 0 0 1.414-1.414l-2-2Z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl md:text-3xl font-semibold text-gray-900 mb-2">Software en la nube</h3>
                    <p class="text-lg md:text-xl text-gray-600">Podrás administrar expedientes médicos de tus pacientes, generar recetas y estudios de laboratorio, controlar cuentas y más.</p>
                </div>
            </div>
        </div>

        
        <!-- Functionalities Section -->
        <section id="funcionalidades" class="bg-gray-100 py-8"> <!-- Aquí asegúrate de que el id es 'funcionalidades' -->
            <div class="container mx-auto">
                <h2 class="w-full text-5xl font-black leading-tight text-center text-gray-800 mb-8">
                    Funcionalidades
                </h2>
                <!-- Linea debajo del titulo -->
                <div class="w-full mb-4">
                    <div class="h-1 mx-auto gradient w-64 opacity-25 my-0 py-0 rounded-t"></div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div class="bg-white rounded-lg shadow p-6 text-center">
                        <div class="bg-black text-white rounded-full p-4 inline-block">
                            <svg class="w-12 h-12 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M7 2a2 2 0 0 0-2 2v1a1 1 0 0 0 0 2v1a1 1 0 0 0 0 2v1a1 1 0 1 0 0 2v1a1 1 0 1 0 0 2v1a1 1 0 1 0 0 2v1a1 1 0 1 0 0 2v1a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H7Zm3 8a3 3 0 1 1 6 0 3 3 0 0 1-6 0Zm-1 7a3 3 0 0 1 3-3h2a3 3 0 0 1 3 3 1 1 0 0 1-1 1h-6a1 1 0 0 1-1-1Z" clip-rule="evenodd"/>
                            </svg>  
                        </div>
                        <h3 class="mt-4 text-xl font-semibold text-gray-900">Gestión de Pacientes</h3>
                        <p class="mt-2 text-gray-600">Administra los expedientes médicos de tus pacientes de manera eficiente y segura.</p>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6 text-center">
                        <div class="bg-black text-white rounded-full p-4 inline-block">
                            <svg class="w-12 h-12 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M5.617 2.076a1 1 0 0 1 1.09.217L8 3.586l1.293-1.293a1 1 0 0 1 1.414 0L12 3.586l1.293-1.293a1 1 0 0 1 1.414 0L16 3.586l1.293-1.293A1 1 0 0 1 19 3v18a1 1 0 0 1-1.707.707L16 20.414l-1.293 1.293a1 1 0 0 1-1.414 0L12 20.414l-1.293 1.293a1 1 0 0 1-1.414 0L8 20.414l-1.293 1.293A1 1 0 0 1 5 21V3a1 1 0 0 1 .617-.924ZM9 7a1 1 0 0 0 0 2h6a1 1 0 1 0 0-2H9Zm0 4a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2H9Zm0 4a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2H9Z" clip-rule="evenodd"/>
                            </svg>   
                        </div>
                        <h3 class="mt-4 text-xl font-semibold text-gray-900">Generación de Recetas</h3>
                        <p class="mt-2 text-gray-600">Genera y administra recetas médicas fácilmente desde cualquier dispositivo.</p>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6 text-center">
                        <div class="bg-black text-white rounded-full p-4 inline-block">
                            <svg class="w-12 h-12 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M5 5a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1h1a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1h1a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1 2 2 0 0 1 2 2v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V7a2 2 0 0 1 2-2ZM3 19v-7a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2Zm6.01-6a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm2 0a1 1 0 1 1 2 0 1 1 0 0 1-2 0Zm6 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm-10 4a1 1 0 1 1 2 0 1 1 0 0 1-2 0Zm6 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm2 0a1 1 0 1 1 2 0 1 1 0 0 1-2 0Z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h3 class="mt-4 text-xl font-semibold text-gray-900">Control de Citas</h3>
                        <p class="mt-2 text-gray-600">Agenda, reprograma y gestiona citas con facilidad, evitando conflictos de horarios.</p>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6 text-center">
                        <div class="bg-black text-white rounded-full p-4 inline-block">
                            <svg class="w-12 h-12 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 0 0-1 1H6a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2h-2a1 1 0 0 0-1-1H9Zm1 2h4v2h1a1 1 0 1 1 0 2H9a1 1 0 0 1 0-2h1V4Zm5.707 8.707a1 1 0 0 0-1.414-1.414L11 14.586l-1.293-1.293a1 1 0 0 0-1.414 1.414l2 2a1 1 0 0 0 1.414 0l4-4Z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h3 class="mt-4 text-xl font-semibold text-gray-900">Reportes y Análisis</h3>
                        <p class="mt-2 text-gray-600">Genera reportes detallados y análisis para tomar decisiones informadas y mejorar la atención.</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mt-8">
                    <div class="bg-white rounded-lg shadow p-6 text-center">
                        <div class="bg-black text-white rounded-full p-4 inline-block">
                            <svg class="w-12 h-12 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M11.644 3.066a1 1 0 0 1 .712 0l7 2.666A1 1 0 0 1 20 6.68a17.694 17.694 0 0 1-2.023 7.98 17.406 17.406 0 0 1-5.402 6.158 1 1 0 0 1-1.15 0 17.405 17.405 0 0 1-5.403-6.157A17.695 17.695 0 0 1 4 6.68a1 1 0 0 1 .644-.949l7-2.666Zm4.014 7.187a1 1 0 0 0-1.316-1.506l-3.296 2.884-.839-.838a1 1 0 0 0-1.414 1.414l1.5 1.5a1 1 0 0 0 1.366.046l4-3.5Z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h3 class="mt-4 text-xl font-semibold text-gray-900">Acceso Seguro</h3>
                        <p class="mt-2 text-gray-600">Protege la información de tus pacientes con nuestros sistemas de seguridad avanzados.</p>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6 text-center">
                        <div class="bg-black text-white rounded-full p-4 inline-block">
                            <svg class="w-12 h-12 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M5 3a2 2 0 0 0-2 2v5h18V5a2 2 0 0 0-2-2H5ZM3 14v-2h18v2a2 2 0 0 1-2 2h-6v3h2a1 1 0 1 1 0 2H9a1 1 0 1 1 0-2h2v-3H5a2 2 0 0 1-2-2Z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h3 class="mt-4 text-xl font-semibold text-gray-900">Interfaz Amigable</h3>
                        <p class="mt-2 text-gray-600">Disfruta de una interfaz intuitiva y fácil de usar, diseñada para mejorar tu productividad.</p>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6 text-center">
                        <div class="bg-black text-white rounded-full p-4 inline-block">
                            <svg class="w-12 h-12 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.133 12.632v-1.8a5.407 5.407 0 0 0-4.154-5.262.955.955 0 0 0 .021-.106V3.1a1 1 0 0 0-2 0v2.364a.933.933 0 0 0 .021.106 5.406 5.406 0 0 0-4.154 5.262v1.8C6.867 15.018 5 15.614 5 16.807 5 17.4 5 18 5.538 18h12.924C19 18 19 17.4 19 16.807c0-1.193-1.867-1.789-1.867-4.175Zm-13.267-.8a1 1 0 0 1-1-1 9.424 9.424 0 0 1 2.517-6.391A1.001 1.001 0 1 1 6.854 5.8a7.43 7.43 0 0 0-1.988 5.037 1 1 0 0 1-1 .995Zm16.268 0a1 1 0 0 1-1-1A7.431 7.431 0 0 0 17.146 5.8a1 1 0 0 1 1.471-1.354 9.424 9.424 0 0 1 2.517 6.391 1 1 0 0 1-1 .995ZM8.823 19a3.453 3.453 0 0 0 6.354 0H8.823Z"/>
                            </svg>
                        </div>
                        <h3 class="mt-4 text-xl font-semibold text-gray-900">Soporte 24/7</h3>
                        <p class="mt-2 text-gray-600">Nuestro equipo de soporte está disponible las 24 horas del día, los 7 días de la semana, para ayudarte en cualquier momento.</p>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6 text-center">
                        <div class="bg-black text-white rounded-full p-4 inline-block">
                            <svg class="w-12 h-12 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m16 10 3-3m0 0-3-3m3 3H5v3m3 4-3 3m0 0 3 3m-3-3h14v-3"/>
                            </svg>
                        </div>
                        <h3 class="mt-4 text-xl font-semibold text-gray-900">Actualizaciones Constantes</h3>
                        <p class="mt-2 text-gray-600">Recibe actualizaciones periódicas con nuevas funcionalidades y mejoras.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer Section -->
        <footer class="py-6 gradient">
            <div class="container mx-auto text-center">
                <p class="text-white">&copy; 2024 LedeHealth. Todos los derechos reservados.</p>
            </div>
        </footer>
    </body>
</x-app-layout>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.getElementById('nav-toggle').onclick = function() {
        document.getElementById('nav-content').classList.toggle('active');
    };
</script>