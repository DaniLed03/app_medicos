<x-app-layout>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-semibold mb-4">Configuración del Sistema</h1>
        <form method="POST" action="{{ route('configuracion.guardar') }}">
            @csrf
            <div class="flex items-center mb-4">
                <label for="toggle-agenda" class="mr-2">Mostrar Agenda</label>
                <input type="checkbox" id="toggle-agenda" name="mostrar_agenda" 
                    @if(auth()->user()->userSetting && auth()->user()->userSetting->mostrar_agenda) checked @endif class="toggle-checkbox">
                <label for="toggle-agenda" class="toggle-label"></label>
            </div>
            <div class="flex items-center mb-4">
                <label for="toggle-caja" class="mr-2">Mostrar Caja</label>
                <input type="checkbox" id="toggle-caja" name="mostrar_caja" 
                    @if(auth()->user()->userSetting && auth()->user()->userSetting->mostrar_caja) checked @endif class="toggle-checkbox">
                <label for="toggle-caja" class="toggle-label"></label>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Guardar Configuración</button>
        </form>
    </div>
</x-app-layout>

<!-- Estilos para el Toggle -->
<style>
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
