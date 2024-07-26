<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Editar Consulta Sin Cita</title>
</head>
<body>
    <h1>Editar Consulta Sin Cita</h1>

    <h2>Información del Paciente</h2>
    <p><strong>Nombre:</strong> {{ $consulta->paciente->nombres }} {{ $consulta->paciente->apepat }} {{ $consulta->paciente->apemat }}</p>
    <p><strong>Edad:</strong> 
        <?php
            $fecha_nacimiento = \Carbon\Carbon::parse($consulta->paciente->fechanac);
            $edad = $fecha_nacimiento->diff(\Carbon\Carbon::now());
            echo $edad->y . ' años, ' . $edad->m . ' meses, ' . $edad->d . ' días';
        ?>
    </p>
    <p><strong>Género:</strong> {{ $consulta->paciente->genero }}</p>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('consultas.update', $consulta->id) }}" method="POST">
        @csrf
        @method('PUT')

        <input type="hidden" name="pacienteid" value="{{ $consulta->paciente->id }}">
        <input type="hidden" name="usuariomedicoid" value="{{ $consulta->usuariomedicoid }}">

        <div>
            <label for="hidden_talla">Talla:</label>
            <input type="text" id="hidden_talla" name="hidden_talla" value="{{ $consulta->talla }}">
        </div>

        <div>
            <label for="hidden_temperatura">Temperatura:</label>
            <input type="text" id="hidden_temperatura" name="hidden_temperatura" value="{{ $consulta->temperatura }}">
        </div>

        <div>
            <label for="hidden_saturacion_oxigeno">Saturación de Oxígeno:</label>
            <input type="text" id="hidden_saturacion_oxigeno" name="hidden_saturacion_oxigeno" value="{{ $consulta->saturacion_oxigeno }}">
        </div>

        <div>
            <label for="hidden_frecuencia_cardiaca">Frecuencia Cardíaca:</label>
            <input type="text" id="hidden_frecuencia_cardiaca" name="hidden_frecuencia_cardiaca" value="{{ $consulta->frecuencia_cardiaca }}">
        </div>

        <div>
            <label for="hidden_peso">Peso:</label>
            <input type="text" id="hidden_peso" name="hidden_peso" value="{{ $consulta->peso }}">
        </div>

        <div>
            <label for="hidden_tension_arterial">Tensión Arterial:</label>
            <input type="text" id="hidden_tension_arterial" name="hidden_tension_arterial" value="{{ $consulta->tension_arterial }}">
        </div>

        <div>
            <label for="circunferencia_cabeza">Circunferencia de la Cabeza:</label>
            <input type="text" id="circunferencia_cabeza" name="circunferencia_cabeza" value="{{ $consulta->circunferencia_cabeza }}">
        </div>

        <div>
            <label for="motivoConsulta">Motivo de la Consulta:</label>
            <textarea id="motivoConsulta" name="motivoConsulta">{{ $consulta->motivoConsulta }}</textarea>
        </div>

        <div>
            <label for="notas_padecimiento">Notas del Padecimiento:</label>
            <textarea id="notas_padecimiento" name="notas_padecimiento">{{ $consulta->notas_padecimiento }}</textarea>
        </div>

        <div>
            <label for="interrogatorio_por_aparatos">Interrogatorio por Aparatos:</label>
            <textarea id="interrogatorio_por_aparatos" name="interrogatorio_por_aparatos">{{ $consulta->interrogatorio_por_aparatos }}</textarea>
        </div>

        <div>
            <label for="examen_fisico">Examen Físico:</label>
            <textarea id="examen_fisico" name="examen_fisico">{{ $consulta->examen_fisico }}</textarea>
        </div>

        <div>
            <label for="diagnostico">Diagnóstico:</label>
            <textarea id="diagnostico" name="diagnostico">{{ $consulta->diagnostico }}</textarea>
        </div>

        <div>
            <label for="plan">Plan:</label>
            <textarea id="plan" name="plan">{{ $consulta->plan }}</textarea>
        </div>

        <div>
            <label for="status">Estado:</label>
            <select id="status" name="status">
                <option value="en curso" {{ $consulta->status == 'en curso' ? 'selected' : '' }}>En Curso</option>
                <option value="finalizada" {{ $consulta->status == 'finalizada' ? 'selected' : '' }}>Finalizada</option>
            </select>
        </div>

        <div>
            <label for="totalPagar">Total a Pagar:</label>
            <input type="number" id="totalPagar" name="totalPagar" value="{{ $consulta->totalPagar }}">
        </div>

        <div id="recetas">
            <h2>Recetas</h2>
            @foreach ($consulta->recetas as $index => $receta)
                <div class="receta">
                    <label for="recetas[{{ $index }}][tipo_de_receta]">Tipo de Receta:</label>
                    <input type="text" name="recetas[{{ $index }}][tipo_de_receta]" value="{{ $receta->tipo_de_receta }}">

                    <label for="recetas[{{ $index }}][receta]">Receta:</label>
                    <textarea name="recetas[{{ $index }}][receta]">{{ $receta->receta }}</textarea>
                </div>
            @endforeach
        </div>

        <button type="button" id="addReceta">Agregar Receta</button>
        <button type="submit">Guardar Consulta</button>
    </form>

    <script>
        function getUnit(fieldName) {
            switch (fieldName) {
                case 'hidden_talla':
                    return 'm';
                case 'hidden_temperatura':
                    return '°C';
                case 'hidden_saturacion_oxigeno':
                    return '%';
                case 'hidden_frecuencia_cardiaca':
                    return 'bpm';
                case 'hidden_peso':
                    return 'kg';
                case 'hidden_tension_arterial':
                    return 'mmHg';
                default:
                    return '';
            }
        }

        document.querySelectorAll('input[type="text"]').forEach(input => {
            input.addEventListener('blur', function () {
                let unit = getUnit(this.name);
                if (unit) {
                    if (!this.value.includes(unit)) {
                        this.value += ' ' + unit;
                    }
                }
            });
        });

        document.getElementById('addReceta').addEventListener('click', function () {
            let recetasDiv = document.getElementById('recetas');
            let newRecetaIndex = recetasDiv.getElementsByClassName('receta').length;

            let newRecetaDiv = document.createElement('div');
            newRecetaDiv.classList.add('receta');

            let tipoDeRecetaLabel = document.createElement('label');
            tipoDeRecetaLabel.innerText = 'Tipo de Receta:';
            newRecetaDiv.appendChild(tipoDeRecetaLabel);

            let tipoDeRecetaInput = document.createElement('input');
            tipoDeRecetaInput.type = 'text';
            tipoDeRecetaInput.name = 'recetas[' + newRecetaIndex + '][tipo_de_receta]';
            newRecetaDiv.appendChild(tipoDeRecetaInput);

            let recetaLabel = document.createElement('label');
            recetaLabel.innerText = 'Receta:';
            newRecetaDiv.appendChild(recetaLabel);

            let recetaTextarea = document.createElement('textarea');
            recetaTextarea.name = 'recetas[' + newRecetaIndex + '][receta]';
            newRecetaDiv.appendChild(recetaTextarea);

            recetasDiv.appendChild(newRecetaDiv);
        });
    </script>
</body>
</html>
