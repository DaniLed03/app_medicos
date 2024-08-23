<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Productos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .barcode {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Reporte de Productos</h1>

    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Inventario</th>
                <th>Precio</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productos as $producto)
                <tr>
                    <td>{{ $producto->nombre }}</td>
                    <td>{{ $producto->descripcion }}</td>
                    <td>{{ $producto->inventario }}</td>
                    <td>${{ number_format($producto->precio, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="barcode">
        {!! $barcode !!}
    </div>
</body>
</html>
