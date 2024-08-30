<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        /* Estilo personalizado para el checkbox */
        .toggle-checkbox:checked {
            right: 0;
            background-color: #2D7498;
        }
        
        .toggle-checkbox:checked + .toggle-label {
            background-color: #2D7498;
        }

        .toggle-checkbox {
            display: none;
        }

        .toggle-label {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 2.5rem;
            height: 1.5rem;
            background-color: #ddd;
            border-radius: 1.5rem;
            cursor: pointer;
            transition: background-color 0.3s;
            position: relative;
        }

        .toggle-label::after {
            content: '';
            display: block;
            width: 1rem;
            height: 1rem;
            background-color: white;
            border-radius: 50%;
            position: absolute;
            top: 50%;
            left: 0.25rem;
            transform: translateY(-50%);
            transition: left 0.3s;
        }

        .toggle-checkbox:checked + .toggle-label::after {
            left: 1.25rem;
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white shadow-lg rounded-lg flex flex-col md:flex-row max-w-6xl w-full overflow-hidden">
        <!-- Left Side (Formulario de Login) -->
        <div class="w-full md:w-1/2 p-12">
            <h3 class="text-4xl font-bold mb-6">Iniciar sesión</h3>            
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-6">
                    <label class="block text-gray-600 text-lg mb-2" for="email">Correo electrónico</label>
                    <input name="email" type="email" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:border-blue-500" placeholder="Ingrese correo electrónico" required />
                    @error('email')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-6">
                    <label class="block text-gray-600 text-lg mb-2" for="password">Contraseña</label>
                    <input name="password" type="password" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:border-blue-500" placeholder="Ingrese contraseña" required />
                    @error('password')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <input type="checkbox" id="remember" name="remember" class="toggle-checkbox">
                        <label for="remember" class="toggle-label"></label>
                        <span class="ml-3 text-lg text-gray-600">Recuérdame</span>
                    </div>
                </div>
                <div class="mb-6">
                    <button type="submit" class="w-full text-white py-3 rounded-lg transition duration-200" style="background-color: #2D7498 !important; hover:bg-color: #2D8C7A !important;">Iniciar sesión</button>
                </div>
            </form>
        </div>

        <!-- Right Side (Imagen) -->
        <div class="hidden md:flex md:w-1/2 items-center justify-center" style="background-color: #2D7498 !important;">
            <img src="{{ url('images/LedeHealth.png') }}" alt="LedeHealth Logo" class="w-3/4 h-auto">
        </div>
    </div>
</body>
</html>
