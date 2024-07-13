<form action="{{ route('enfermeras.store') }}" method="POST">
    @csrf
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div class="col-span-2">
            <label for="nombres" class="block text-sm font-medium text-gray-700">Nombres</label>
            <input type="text" name="nombres" id="nombres" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
        </div>

        <div>
            <label for="apepat" class="block text-sm font-medium text-gray-700">Apellido Paterno</label>
            <input type="text" name="apepat" id="apepat" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
        </div>

        <div>
            <label for="apemat" class="block text-sm font-medium text-gray-700">Apellido Materno</label>
            <input type="text" name="apemat" id="apemat" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
        </div>

        <div>
            <label for="fechanac" class="block text-sm font-medium text-gray-700">Fecha de Nacimiento</label>
            <input type="date" name="fechanac" id="fechanac" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
        </div>

        <div>
            <label for="telefono" class="block text-sm font-medium text-gray-700">Teléfono</label>
            <input type="text" name="telefono" id="telefono" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
        </div>

        <div class="col-span-2">
            <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
            <input type="email" name="email" id="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
            <input type="password" name="password" id="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Contraseña</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
        </div>
    </div>

    <div class="mt-5 sm:mt-6 flex justify-end">
        <button type="submit" class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:text-sm">
            Registrar Enfermera
        </button>
    </div>
</form>
