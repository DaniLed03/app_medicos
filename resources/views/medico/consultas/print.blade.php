<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta - {{ $consulta->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }
        .header, .content {
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
        }
        .header h2 {
            margin: 0;
            font-weight: normal;
            color: #555;
        }
        .content p {
            margin: 5px 0;
        }
        .content label {
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Consulta - {{ $consulta->id }}</h1>
            <h2>Paciente: {{ $paciente->nombres }} {{ $paciente->apepat }} {{ $paciente->apemat }}</h2>
            <h2>Doctor: Dr. {{ $consulta->usuarioMedico->nombres }} {{ $consulta->usuarioMedico->apellidos }}</h2>
        </div>
        <div class="content">
            <p><label>Fecha:</label> {{ \Carbon\Carbon::parse($consulta->fechaHora)->format('d M, Y h:i A') }}</p>
            <p><label>Motivo:</label> {{ $consulta->motivoConsulta }}</p>
            <p><label>Diagnóstico:</label> {{ $consulta->diagnostico }}</p>
            <p><label>Notas del Padecimiento:</label> {{ $consulta->notas_padecimiento }}</p>
            <p><label>Plan:</label> {{ $consulta->plan }}</p>

            <h3>Signos Vitales</h3>
            <p><label>Talla:</label> {{ $consulta->talla }}</p>
            <p><label>Temperatura:</label> {{ $consulta->temperatura }}</p>
            <p><label>Saturación de Oxígeno:</label> {{ $consulta->saturacion_oxigeno }}</p>
            <p><label>Frecuencia Cardíaca:</label> {{ $consulta->frecuencia_cardiaca }}</p>
            <p><label>Peso:</label> {{ $consulta->peso }}</p>
            <p><label>Tensión Arterial:</label> {{ $consulta->tension_arterial }}</p>
            <p><label>Circunferencia de Cabeza:</label> {{ $consulta->circunferencia_cabeza }}</p>

            <h3>Recetas</h3>
            <table>
                <thead>
                    <tr>
                        <th>No. Receta</th>
                        <th>Tipo de Receta</th>
                        <th>Receta</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($consulta->recetas as $index => $receta)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $receta->tipo_de_receta }}</td>
                            <td>{!! $receta->receta !!}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <p><label>Total a Pagar:</label> {{ $consulta->totalPagar }}</p>
        </div>
    </div>
</body>
</html>
