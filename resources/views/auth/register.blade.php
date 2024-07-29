<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        .gradient-text {
            background: linear-gradient(to right, #3b82f6, #06b6d4, #34d399);
            -webkit-background-clip: text;
            color: transparent;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex w-screen h-screen">
        <div class="flex w-full flex-col md:w-1/2 lg:w-3/5 p-10">
            <div class="my-auto mx-auto flex flex-col justify-center px-6 pt-8 md:justify-start lg:w-[32rem]">
                <p class="text-center text-3xl font-bold md:leading-tight md:text-left md:text-5xl">
                    Crea tu cuenta en <br />
                    <span class="gradient-text">LedeHealth</span>
                </p>
                <p class="mt-6 text-center font-medium md:text-left">Completa el formulario para registrarte.</p>

                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <strong class="font-bold">Oops! Algo salió mal.</strong>
                        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="flex flex-col items-stretch pt-3 md:pt-8">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex flex-col pt-4">
                            <div class="relative flex overflow-hidden rounded-md border-2 transition focus-within:border-blue-600">
                                <input type="text" id="nombres" name="nombres" class="w-full flex-shrink appearance-none border-gray-300 bg-white py-2 px-4 text-base text-gray-700 placeholder-gray-400 focus:outline-none" placeholder="Nombres" required value="{{ old('nombres') }}" />
                            </div>
                            @error('nombres')
                                <span class="text-red-500 text-xs mt-2">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex flex-col pt-4">
                            <div class="relative flex overflow-hidden rounded-md border-2 transition focus-within:border-blue-600">
                                <input type="text" id="apepat" name="apepat" class="w-full flex-shrink appearance-none border-gray-300 bg-white py-2 px-4 text-base text-gray-700 placeholder-gray-400 focus:outline-none" placeholder="Apellido Paterno" required value="{{ old('apepat') }}" />
                            </div>
                            @error('apepat')
                                <span class="text-red-500 text-xs mt-2">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex flex-col pt-4">
                            <div class="relative flex overflow-hidden rounded-md border-2 transition focus-within:border-blue-600">
                                <input type="text" id="apemat" name="apemat" class="w-full flex-shrink appearance-none border-gray-300 bg-white py-2 px-4 text-base text-gray-700 placeholder-gray-400 focus:outline-none" placeholder="Apellido Materno" required value="{{ old('apemat') }}" />
                            </div>
                            @error('apemat')
                                <span class="text-red-500 text-xs mt-2">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex flex-col pt-4">
                            <div class="relative flex overflow-hidden rounded-md border-2 transition focus-within:border-blue-600">
                                <input type="date" id="fechanac" name="fechanac" class="w-full flex-shrink appearance-none border-gray-300 bg-white py-2 px-4 text-base text-gray-700 placeholder-gray-400 focus:outline-none" placeholder="Fecha de Nacimiento" required value="{{ old('fechanac') }}" />
                            </div>
                            @error('fechanac')
                                <span class="text-red-500 text-xs mt-2">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex flex-col pt-4">
                            <div class="relative flex overflow-hidden rounded-md border-2 transition focus-within:border-blue-600">
                                <input type="number" id="telefono" name="telefono" class="w-full flex-shrink appearance-none border-gray-300 bg-white py-2 px-4 text-base text-gray-700 placeholder-gray-400 focus:outline-none" placeholder="Teléfono" required value="{{ old('telefono') }}" />
                            </div>
                            @error('telefono')
                                <span class="text-red-500 text-xs mt-2">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex flex-col pt-4">
                            <div class="relative flex overflow-hidden rounded-md border-2 transition focus-within:border-blue-600">
                                <select id="sexo" name="sexo" class="w-full flex-shrink appearance-none border-gray-300 bg-white py-2 px-4 text-base text-gray-700 placeholder-gray-400 focus:outline-none" required>
                                    <option value="masculino" {{ old('sexo') == 'masculino' ? 'selected' : '' }}>Masculino</option>
                                    <option value="femenino" {{ old('sexo') == 'femenino' ? 'selected' : '' }}>Femenino</option>
                                </select>
                            </div>
                            @error('sexo')
                                <span class="text-red-500 text-xs mt-2">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex flex-col pt-4">
                            <div class="relative flex overflow-hidden rounded-md border-2 transition focus-within:border-blue-600">
                                <input type="email" id="email" name="email" class="w-full flex-shrink appearance-none border-gray-300 bg-white py-2 px-4 text-base text-gray-700 placeholder-gray-400 focus:outline-none" placeholder="Correo Electrónico" required value="{{ old('email') }}" />
                            </div>
                            @error('email')
                                <span class="text-red-500 text-xs mt-2">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex flex-col pt-4">
                            <div class="relative flex overflow-hidden rounded-md border-2 transition focus-within:border-blue-600">
                                <input type="password" id="password" name="password" class="w-full flex-shrink appearance-none border-gray-300 bg-white py-2 px-4 text-base text-gray-700 placeholder-gray-400 focus:outline-none" placeholder="Contraseña" required />
                            </div>
                            @error('password')
                                <span class="text-red-500 text-xs mt-2">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex flex-col pt-4">
                            <div class="relative flex overflow-hidden rounded-md border-2 transition focus-within:border-blue-600">
                                <input type="password" id="password_confirmation" name="password_confirmation" class="w-full flex-shrink appearance-none border-gray-300 bg-white py-2 px-4 text-base text-gray-700 placeholder-gray-400 focus:outline-none" placeholder="Confirmar Contraseña" required />
                            </div>
                            @error('password_confirmation')
                                <span class="text-red-500 text-xs mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="py-12 text-center">
                        <p class="text-gray-600">
                            ¿Ya tienes una cuenta?
                            <a href="{{ route('login') }}" class="whitespace-nowrap font-semibold text-gray-900 underline underline-offset-4">Inicia sesión.</a>
                        </p>
                    </div>

                    <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2 text-center text-base font-semibold text-white shadow-md outline-none ring-blue-500 ring-offset-2 transition hover:bg-blue-700 focus:ring-2 md:w-32 mx-auto">Registrarse</button>
                </form>
            </div>
        </div>
        <div class="relative hidden h-full w-full select-none bg-gradient-to-br from-green-600 via-blue-500 to-blue-700 md:block md:w-1/2 lg:w-2/5">
            <div class="py-8 px-8 text-white xl:w-[40rem] text-center">
                <img src="{{ asset('images/Ledehealth.png') }}" alt="LedeHealth Logo" class="mx-auto h-100 mb-4">
                <p class="mt-8 font-bold">En nuestro consultorio virtual, podrás gestionar tus citas, consultar resultados de exámenes y recibir asesoramiento médico de manera remota.</p>
            </div>
        </div>
    </div>
</body>
</html>
