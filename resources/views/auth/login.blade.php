<!DOCTYPE html>
<html lang="en">
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
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex w-screen h-screen">
        <div class="flex w-full flex-col md:w-1/2 lg:w-3/5 p-10">
            <div class="my-auto mx-auto flex flex-col justify-center px-6 pt-8 md:justify-start lg:w-[32rem]">
                <p class="text-center text-3xl font-bold md:leading-tight md:text-left md:text-5xl">
                    Bienvenido de nuevo <br />
                    a <span class="gradient-text">LedeHealth</span>
                </p>
                <p class="mt-6 text-center font-medium md:text-left">Inicia sesión en tu cuenta a continuación.</p>
      
                <form method="POST" action="{{ route('login') }}" class="flex flex-col items-stretch pt-3 md:pt-8">
                    @csrf
                    <div class="flex flex-col pt-4">
                        <div class="relative flex overflow-hidden rounded-md border-2 transition focus-within:border-blue-600">
                            <input type="email" id="login-email" name="email" class="w-full flex-shrink appearance-none border-gray-300 bg-white py-2 px-4 text-base text-gray-700 placeholder-gray-400 focus:outline-none" placeholder="Correo electrónico" required />
                        </div>
                    </div>
                    <div class="mb-4 flex flex-col pt-4">
                        <div class="relative flex overflow-hidden rounded-md border-2 transition focus-within:border-blue-600">
                            <input type="password" id="login-password" name="password" class="w-full flex-shrink appearance-none border-gray-300 bg-white py-2 px-4 text-base text-gray-700 placeholder-gray-400 focus:outline-none" placeholder="Contraseña" required />
                        </div>
                    </div>
                    <a href="{{ route('password.request') }}" class="mb-6 text-center text-sm font-medium text-gray-600 md:text-left">¿Olvidaste tu contraseña?</a>
                    <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2 text-center text-base font-semibold text-white shadow-md outline-none ring-blue-500 ring-offset-2 transition hover:bg-blue-700 focus:ring-2 md:w-32">Iniciar sesión</button>
                </form>
                <div class="py-12 text-center">
                    <p class="text-gray-600">
                        ¿No tienes una cuenta?
                        <a href="{{ route('register') }}" class="whitespace-nowrap font-semibold text-gray-900 underline underline-offset-4">Regístrate gratis.</a>
                    </p>
                </div>
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
