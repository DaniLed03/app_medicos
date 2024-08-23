<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Lista de Pacientes</title>
    <style>
        /* Agrega aquí los estilos necesarios para el PDF */
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

    <h1>Lista de Pacientes</h1>

    <table>
        <thead>
            <tr>
                <th>No. Exp</th>
                <th>Nombre del Paciente</th>
                <th>Fecha de Nacimiento</th>
                <th>Sexo</th>
                <th>Teléfono</th>
                <th>Correo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pacientes as $paciente)
                <tr>
                    <td>{{ $paciente->no_exp }}</td>
                    <td>{{ $paciente->nombres }} {{ $paciente->apepat }} {{ $paciente->apemat }}</td>
                    <td>{{ \Carbon\Carbon::parse($paciente->fechanac)->format('j M, Y') }}</td>
                    <td>{{ $paciente->sexo }}</td>
                    <td>{{ $paciente->telefono }}</td>
                    <td>{{ $paciente->correo }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
