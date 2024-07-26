<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Agregar Consulta</title>
</head>
<body>
    <h1>Agregar Consulta</h1>

    <h2>Información del Paciente</h2>
    <p><strong>Nombre:</strong> {{ $cita->paciente->nombres }} {{ $cita->paciente->apepat }} {{ $cita->paciente->apemat }}</p>
    <p><strong>Edad:</strong> 
        <?php
            $fecha_nacimiento = \Carbon\Carbon::parse($cita->paciente->fechanac);
            $edad = $fecha_nacimiento->diff(\Carbon\Carbon::now());
            echo $edad->y . ' años, ' . $edad->m . ' meses, ' . $edad->d . ' días';
        ?>
    </p>
    <p><strong>Género:</strong> {{ $cita->paciente->genero }}</p>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('consultas.store') }}" method="POST">
        @csrf
        <input type="hidden" name="citai_id" value="{{ $cita->id }}">
        <input type="hidden" name="usuariomedicoid" value="{{ $medico->id }}">

        <div>
            <label for="hidden_talla">Talla:</label>
            <input type="text" id="hidden_talla" name="hidden_talla">
        </div>

        <div>
            <label for="hidden_temperatura">Temperatura:</label>
            <input type="text" id="hidden_temperatura" name="hidden_temperatura">
        </div>

        <div>
            <label for="hidden_saturacion_oxigeno">Saturación de Oxígeno:</label>
            <input type="text" id="hidden_saturacion_oxigeno" name="hidden_saturacion_oxigeno">
        </div>

        <div>
            <label for="hidden_frecuencia_cardiaca">Frecuencia Cardíaca:</label>
            <input type="text" id="hidden_frecuencia_cardiaca" name="hidden_frecuencia_cardiaca">
        </div>

        <div>
            <label for="hidden_peso">Peso:</label>
            <input type="text" id="hidden_peso" name="hidden_peso">
        </div>

        <div>
            <label for="hidden_tension_arterial">Tensión Arterial:</label>
            <input type="text" id="hidden_tension_arterial" name="hidden_tension_arterial">
        </div>

        <div>
            <label for="circunferencia_cabeza">Circunferencia de la Cabeza:</label>
            <input type="text" id="circunferencia_cabeza" name="circunferencia_cabeza">
        </div>

        <div>
            <label for="motivoConsulta">Motivo de la Consulta:</label>
            <textarea id="motivoConsulta" name="motivoConsulta"></textarea>
        </div>

        <div>
            <label for="notas_padecimiento">Notas del Padecimiento:</label>
            <textarea id="notas_padecimiento" name="notas_padecimiento"></textarea>
        </div>

        <div>
            <label for="interrogatorio_por_aparatos">Interrogatorio por Aparatos:</label>
            <textarea id="interrogatorio_por_aparatos" name="interrogatorio_por_aparatos"></textarea>
        </div>

        <div>
            <label for="examen_fisico">Examen Físico:</label>
            <textarea id="examen_fisico" name="examen_fisico"></textarea>
        </div>

        <div>
            <label for="diagnostico">Diagnóstico:</label>
            <textarea id="diagnostico" name="diagnostico"></textarea>
        </div>

        <div>
            <label for="plan">Plan:</label>
            <textarea id="plan" name="plan"></textarea>
        </div>

        <div>
            <label for="status">Estado:</label>
            <select id="status" name="status">
                <option value="en curso">En Curso</option>
                <option value="finalizada">Finalizada</option>
            </select>
        </div>

        <div>
            <label for="totalPagar">Total a Pagar:</label>
            <input type="number" id="totalPagar" name="totalPagar">
        </div>

        <div id="recetas">
            <h2>Recetas</h2>
            <div class="receta">
                <label for="tipo_de_receta">Tipo de Receta:</label>
                <input type="text" name="recetas[0][tipo_de_receta]">

                <label for="receta">Receta:</label>
                <textarea name="recetas[0][receta]"></textarea>
            </div>
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
