<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Ventas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
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
    <h1>Lista de Ventas</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Paciente</th>
                <th>Precio Consulta</th>
                <th>IVA</th>
                <th>Total</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ventas as $venta)
                <tr>
                    <td>{{ $venta->id }}</td>
                    <td>{{ $venta->paciente ? $venta->paciente->nombres : 'No disponible' }}</td>
                    <td>{{ number_format($venta->precio_consulta, 2) }}</td>
                    <td>{{ number_format($venta->iva, 2) }}</td>
                    <td>{{ number_format($venta->total, 2) }}</td>
                    <td>{{ ucfirst($venta->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
