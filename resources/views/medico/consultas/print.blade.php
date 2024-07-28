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
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Consulta - {{ $consulta->id }}</h1>
            <h2>Paciente: {{ $consulta->cita->paciente->nombres }} {{ $consulta->cita->paciente->apepat }} {{ $consulta->cita->paciente->apemat }}</h2>
            <h2>Doctor: Dr. {{ $consulta->usuarioMedico->nombres }} {{ $consulta->usuarioMedico->apellidos }}</h2>
        </div>
        <div class="content">
            <p><label>Fecha:</label> {{ \Carbon\Carbon::parse($consulta->fechaHora)->format('d M, Y h:i A') }}</p>
            <p><label>Motivo:</label> {{ $consulta->motivoConsulta }}</p>
            <p><label>Diagnóstico:</label> {{ $consulta->diagnostico }}</p>
            <p><label>Notas del Padecimiento:</label> {{ $consulta->notas_padecimiento }}</p>
            <p><label>Plan:</label> {{ $consulta->plan }}</p>
            <!-- Puedes agregar más información aquí según sea necesario -->
        </div>
    </div>
</body>
</html>
