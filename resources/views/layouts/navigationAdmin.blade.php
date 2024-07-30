<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navegación</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.10.2/cdn.min.js" defer></script>
    <style>
        .navbar-superior {
            background-color: #2D7498; /* Color especificado para el navbar superior */
        }
        .navbar-inferior {
            background-color: #316986; /* Color especificado para el navbar inferior */
        }
        .dropdown-item:hover {
            background-color: #33AD9B; /* Color de fondo al hacer hover */
            color: white; /* Color de texto al hacer hover */
        }
        .hover-bg-custom:hover {
            background-color: #33AD9B; /* Color de fondo al hacer hover en el botón */
        }
        .custom-button {
            padding: 5px 10px; /* Ajuste de tamaño para hacerlo más pequeño */
            border-radius: 9999px; /* Borde redondeado completo */
            margin-right: 20px; /* Margen derecho */
            font-size: 0.875rem; /* Tamaño de fuente reducido */
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Navbar superior -->
    <nav class="navbar-superior">
        <div class="max-w-screen-xl mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('medico.dashboard') }}" class="flex items-center space-x-3">
                        <img src="{{ asset('images/LedeHealth.png') }}" alt="LedeHealth" class="h-8 w-auto">
                        <span class="text-white text-lg font-semibold">Lede<span class="text-[#33AD9B]">Health</span></span>
                    </a>
                </div>
                <div class="flex-grow flex justify-center">
                    <span class="text-white text-xl font-semibold">
                        @role('Administrador')
                            ADMINISTRADOR
                        @endrole
                        @role('Medico')
                            MÉDICO
                        @endrole
                        @role('Enfermera')
                            ENFERMERA
                        @endrole
                        @role('Secretaria')
                            SECRETARIA
                        @endrole
                    </span>
                </div>
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white hover-bg-custom custom-button" id="user-menu-button" aria-expanded="false">
                        <span class="text-white hidden md:block mr-2">{{ Auth::user()->nombres }} {{ Auth::user()->apepat }} {{ Auth::user()->apemat }}</span>
                        <img class="h-8 w-8 rounded-full" src="{{ asset('images/user-photo.jpg') }}" alt="">
                        <svg class="w-4 h-4 ml-2 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button">
                        <div class="px-4 py-3 bg-gray-100">
                            <span class="block text-sm text-gray-500">{{ Auth::user()->email }}</span>
                            <span class="block text-sm text-gray-500">{{ Auth::user()->telefono }}</span>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 dropdown-item" role="menuitem">Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault(); this.closest('form').submit();"
                               class="block px-4 py-2 text-sm text-gray-700 dropdown-item" role="menuitem">Sign out</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Navbar inferior -->
    <nav class="navbar-inferior">
        <div class="max-w-screen-xl mx-auto px-4" x-data="{ open: false }">
            <div class="flex items-center justify-between h-10">
                <div class="hidden md:flex md:space-x-8">
                    <div x-data="{ dropdownOpen: false }" class="relative">
                        <button @click="dropdownOpen = !dropdownOpen" class="flex items-center text-white hover:bg-[#33AD9B] px-3 py-2 rounded-md text-sm font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clipboard2-pulse-fill mr-2" viewBox="0 0 16 16">
                                <path d="M10 .5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5.5.5 0 0 1-.5.5.5.5 0 0 0-.5.5V2a.5.5 0 0 0 .5.5h5A.5.5 0 0 0 11 2v-.5a.5.5 0 0 0-.5-.5.5.5 0 0 1-.5-.5"/>
                                <path d="M4.085 1H3.5A1.5 1.5 0 0 0 2 2.5v12A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 1h-.585q.084.236.085.5V2a1.5 1.5 0 0 1-1.5 1.5h-5A1.5 1.5 0 0 1 4 2v-.5q.001-.264.085-.5M9.98 5.356 11.372 10h.128a.5.5 0 0 1 0 1H11a.5.5 0 0 1-.479-.356l-.94-3.135-1.092 5.096a.5.5 0 0 1-.968.039L6.383 8.85l-.936 1.873A.5.5 0 0 1 5 11h-.5a.5.5 0 0 1 0-1h.191l1.362-2.724a.5.5 0 0 1 .926.08l.94 3.135 1.092-5.096a.5.5 0 0 1 .968-.039Z"/>
                            </svg>
                            Expediente Clínico
                        </button>
                        <div x-show="dropdownOpen" @click.away="dropdownOpen = false" class="absolute mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 z-20">
                            @can('Vista Pacientes')
                                <a href="{{ route('medico.dashboard') }}" class="block text-gray-700 px-4 py-2 text-sm dropdown-item hover:text-white">Pacientes</a>
                            @endcan
                            @can('Vista Consultas')
                                <a href="{{ route('consultas.index') }}" class="block text-gray-700 px-4 py-2 text-sm dropdown-item hover:text-white">Consultas</a>
                            @endcan
                        </div>
                    </div>
                    <div class="relative">
                        <a href="{{ route('citas') }}" class="flex items-center text-white hover:bg-[#33AD9B] px-3 py-2 rounded-md text-sm font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-event-fill mr-2" viewBox="0 0 16 16">
                                <path d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4zM16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2m-3.5-7h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5"/>
                            </svg>
                            Agenda
                        </a>
                    </div>
                    <div x-data="{ dropdownOpen: false }" class="relative">
                        <button @click="dropdownOpen = !dropdownOpen" class="flex items-center text-white hover:bg-[#33AD9B] px-3 py-2 rounded-md text-sm font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gear-fill mr-2" viewBox="0 0 16 16">
                                <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z"/>
                            </svg>
                            Configuración
                        </button>
                        <div x-show="dropdownOpen" @click.away="dropdownOpen = false" class="absolute mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 z-20">
                            @can('Vista Usuarios')
                                <a href="{{ route('users.index') }}" class="block text-gray-700 px-4 py-2 text-sm dropdown-item hover:text-white">Usuarios</a>
                            @endcan
                            @can('Vista Roles')
                                <a href="{{ route('roles.index') }}" class="block text-gray-700 px-4 py-2 text-sm dropdown-item hover:text-white">Roles</a>
                            @endcan
                            @can('Vista Permisos')
                                <a href="{{ route('permisos.index') }}" class="block text-gray-700 px-4 py-2 text-sm dropdown-item hover:text-white">Permisos</a>
                            @endcan
                        </div>
                    </div>
                </div>
                <div class="md:hidden">
                    <button @click="open = !open" class="text-white hover:bg-[#1E40AF] hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <div x-show="open" class="md:hidden">
                <div class="space-y-1 px-2 pt-2 pb-3 sm:px-3">
                    @can('Vista Pacientes')
                        <a href="{{ route('medico.dashboard') }}" class="block text-white {{ request()->routeIs('medico.dashboard') ? 'bg-[#33AD9B]' : '' }} hover:bg-[#33AD9B] hover:text-white px-3 py-2 rounded-md text-base font-medium">Pacientes</a>
                    @endcan
                    @can('Vista Citas')
                        <a href="{{ route('citas') }}" class="block text-white {{ request()->routeIs('citas') ? 'bg-[#33AD9B]' : '' }} hover:bg-[#33AD9B] hover:text-white px-3 py-2 rounded-md text-base font-medium">Citas</a>
                    @endcan
                    @can('Vista Consultas')
                        <a href="{{ route('consultas.index') }}" class="block text-white {{ request()->routeIs('consultas.index') ? 'bg-[#33AD9B]' : '' }} hover:bg-[#33AD9B] hover:text-white px-3 py-2 rounded-md text-base font-medium">Consultas</a>
                    @endcan
                    @can('Vista Roles')
                        <a href="{{ route('roles.index') }}" class="block text-white {{ request()->routeIs('roles.index') ? 'bg-[#33AD9B]' : '' }} hover:bg-[#33AD9B] hover:text-white px-3 py-2 rounded-md text-base font-medium">Roles</a>
                    @endcan
                    @can('Vista Permisos')
                        <a href="{{ route('permisos.index') }}" class="block text-white {{ request()->routeIs('permisos.index') ? 'bg-[#33AD9B]' : '' }} hover:bg-[#33AD9B] hover:text-white px-3 py-2 rounded-md text-base font-medium">Permisos</a>
                    @endcan
                    @can('Vista Usuarios')
                        <a href="{{ route('users.index') }}" class="block text-white {{ request()->routeIs('users.index') ? 'bg-[#33AD9B]' : '' }} hover:bg-[#33AD9B] hover:text-white px-3 py-2 rounded-md text-base font-medium">Usuarios</a>
                    @endcan
                </div>
            </div>
        </div>
    </nav>
</body>
</html>
