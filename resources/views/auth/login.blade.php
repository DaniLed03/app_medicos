<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        .gradient-text {
            background: linear-gradient(to right, #3b82f6, #06b6d4, #34d399);
            -webkit-background-clip: text;
            color: transparent;
        }

        /* Toggle switch */
        .switch {
            position: relative;
            display: inline-block;
            width: 42px;
            height: 24px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: 0.4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: 0.4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: #3b82f6;
        }

        input:checked + .slider:before {
            transform: translateX(18px);
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex w-screen h-screen">
        <div class="flex w-full flex-col md:w-1/2 lg:w-3/5 p-10">
            <div class="my-auto mx-auto flex flex-col justify-center px-6 pt-8 md:justify-start lg:w-[32rem]">
                <p class="text-center text-3xl font-bold md:leading-tight md:text-left md:text-5xl">
                    Bienvenido
                    a <span class="gradient-text">LedeHealth</span>
                </p>
      
                <form method="POST" action="{{ route('login') }}" class="flex flex-col items-stretch pt-3 md:pt-8">
                    @csrf
                    <!-- Email Input -->
                    <div class="flex flex-col pt-4">
                        <div class="relative flex overflow-hidden rounded-md border-2 transition focus-within:border-blue-600">
                            <input type="email" id="login-email" name="email" class="w-full flex-shrink appearance-none border-gray-300 bg-white py-3 px-5 text-lg text-gray-700 placeholder-gray-400 focus:outline-none" style="width: 560px;" placeholder="Correo electrónico" required />
                        </div>
                        @error('email')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- Password Input -->
                    <div class="mb-4 flex flex-col pt-4">
                        <div class="relative flex overflow-hidden rounded-md border-2 transition focus-within:border-blue-600">
                            <input type="password" id="login-password" name="password" class="w-full flex-shrink appearance-none border-gray-300 bg-white py-3 px-5 text-lg text-gray-700 placeholder-gray-400 focus:outline-none" style="width: 560px;" placeholder="Contraseña" required />
                        </div>
                        @error('password')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- Remember Me and Forgot Password -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <label class="switch">
                                <input type="checkbox" name="remember" id="remember">
                                <span class="slider"></span>
                            </label>
                            <span class="ml-2 block text-sm text-gray-900">Recuérdame</span>
                        </div>
                        <a href="{{ route('password.request') }}" class="text-sm font-medium text-gray-600 md:text-left">¿Olvidaste tu contraseña?</a>
                    </div>
                    <!-- Buttons Container -->
                    <div class="flex mt-6 space-x-4">
                        <!-- Login Button -->
                        <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2 text-center text-base font-semibold text-white shadow-md outline-none ring-blue-500 ring-offset-2 transition hover:bg-blue-700 focus:ring-2 md:w-32">Iniciar sesión</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="relative hidden h-full w-full select-none bg-gradient-to-br from-green-600 via-blue-500 to-blue-700 md:block md:w-1/2 lg:w-2/5">
            <div class="py-8 px-8 text-white xl:w-[40rem] text-center">
                <img src="{{ url('images/LedeHealth.png') }}" alt="LedeHealth Logo" class="mx-auto h-100 mb-4">
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @include('sweetalert::alert')
</body>
</html>
