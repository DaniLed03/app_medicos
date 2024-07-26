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
                            <span class="block text-sm text-gray-500">{{ Auth::user()->rol }}</span>
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
                    <a href="{{ route('medico.dashboard') }}" class="text-white {{ request()->routeIs('medico.dashboard') ? 'bg-[#33AD9B]' : '' }} hover:bg-[#33AD9B] hover:text-white px-3 py-2 rounded-md text-sm font-medium">Pacientes</a>
                    <a href="{{ route('medicos') }}" class="text-white {{ request()->routeIs('medicos') ? 'bg-[#33AD9B]' : '' }} hover:bg-[#33AD9B] hover:text-white px-3 py-2 rounded-md text-sm font-medium">Médicos</a>
                    <a href="{{ route('enfermeras') }}" class="text-white {{ request()->routeIs('enfermeras') ? 'bg-[#33AD9B]' : '' }} hover:bg-[#33AD9B] hover:text-white px-3 py-2 rounded-md text-sm font-medium">Enfermeras</a>
                    <a href="{{ route('secretarias') }}" class="text-white {{ request()->routeIs('secretarias') ? 'bg-[#33AD9B]' : '' }} hover:bg-[#33AD9B] hover:text-white px-3 py-2 rounded-md text-sm font-medium">Secretarias</a>
                    <a href="{{ route('citas') }}" class="text-white {{ request()->routeIs('citas') ? 'bg-[#33AD9B]' : '' }} hover:bg-[#33AD9B] hover:text-white px-3 py-2 rounded-md text-sm font-medium">Citas</a>
                    <a href="{{ route('consultas.index') }}" class="text-white {{ request()->routeIs('consultas.index') ? 'bg-[#33AD9B]' : '' }} hover:bg-[#33AD9B] hover:text-white px-3 py-2 rounded-md text-sm font-medium">Consultas</a>
                    <a href="{{ route('servicios') }}" class="text-white {{ request()->routeIs('servicios') ? 'bg-[#33AD9B]' : '' }} hover:bg-[#33AD9B] hover:text-white px-3 py-2 rounded-md text-sm font-medium">Servicios</a>
                    <a href="{{ route('productos') }}" class="text-white {{ request()->routeIs('productos') ? 'bg-[#33AD9B]' : '' }} hover:bg-[#33AD9B] hover:text-white px-3 py-2 rounded-md text-sm font-medium">Productos</a>
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
                    <a href="{{ route('medico.dashboard') }}" class="block text-white {{ request()->routeIs('medico.dashboard') ? 'bg-[#33AD9B]' : '' }} hover:bg-[#33AD9B] hover:text-white px-3 py-2 rounded-md text-base font-medium">Pacientes</a>
                    <a href="{{ route('medicos') }}" class="block text-white {{ request()->routeIs('medicos') ? 'bg-[#33AD9B]' : '' }} hover:bg-[#33AD9B] hover:text-white px-3 py-2 rounded-md text-base font-medium">Médicos</a>
                    <a href="{{ route('enfermeras') }}" class="block text-white {{ request()->routeIs('enfermeras') ? 'bg-[#33AD9B]' : '' }} hover:bg-[#33AD9B] hover:text-white px-3 py-2 rounded-md text-base font-medium">Enfermeras</a>
                    <a href="{{ route('secretarias') }}" class="block text-white {{ request()->routeIs('secretarias') ? 'bg-[#33AD9B]' : '' }} hover:bg-[#33AD9B] hover:text-white px-3 py-2 rounded-md text-base font-medium">Secretarias</a>
                    <a href="{{ route('citas') }}" class="block text-white {{ request()->routeIs('citas') ? 'bg-[#33AD9B]' : '' }} hover:bg-[#33AD9B] hover:text-white px-3 py-2 rounded-md text-base font-medium">Citas</a>
                    <a href="{{ route('consultas.index') }}" class="block text-white {{ request()->routeIs('consultas.index') ? 'bg-[#33AD9B]' : '' }} hover:bg-[#33AD9B] hover:text-white px-3 py-2 rounded-md text-base font-medium">Consultas</a>
                    <a href="{{ route('servicios') }}" class="block text-white {{ request()->routeIs('servicios') ? 'bg-[#33AD9B]' : '' }} hover:bg-[#33AD9B] hover:text-white px-3 py-2 rounded-md text-base font-medium">Servicios</a>
                    <a href="{{ route('productos') }}" class="block text-white {{ request()->routeIs('productos') ? 'bg-[#33AD9B]' : '' }} hover:bg-[#33AD9B] hover:text-white px-3 py-2 rounded-md text-base font-medium">Productos</a>
                </div>
            </div>
        </div>
    </nav>
</body>
</html>
