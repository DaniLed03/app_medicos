<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura - {{ $venta->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header, .footer {
            text-align: center;
            margin-bottom: 20px;
        }
        .content {
            margin: 0 40px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .table th {
            background-color: #f2f2f2;
        }
        .total {
            font-size: 14px;
            font-weight: bold;
            text-align: right;
        }
        .barcode {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>Factura</h1>
    <p><strong>RFC del Emisor:</strong> ABC123456T1</p>
    <p><strong>Nombre del Emisor:</strong> Nombre de la Empresa</p>
    <p><strong>Domicilio Fiscal:</strong> Calle Falsa 123, Col. Centro, Ciudad, Estado, C.P. 12345</p>
    <p><strong>Régimen Fiscal:</strong> Régimen General de Ley Personas Morales</p>
</div>

<div class="content">
    <p><strong>RFC del Receptor:</strong> {{ $paciente->RFC }}</p>
    <p><strong>Nombre del Receptor:</strong> {{ $paciente->Nombre_fact }}</p>
    <p><strong>Dirección del Receptor:</strong> {{ $paciente->Direccion_fact }}</p>
    <p><strong>Régimen Fiscal del Receptor:</strong> {{ $paciente->Regimen_fiscal }}</p>
    <p><strong>Uso del CFDI:</strong> {{ $paciente->CFDI }}</p>
    <p><strong>Fecha de Emisión:</strong> {{ now()->format('d/m/Y') }}</p>

    <table class="table">
        <thead>
            <tr>
                <th>Clave ProdServ</th>
                <th>Descripción</th>
                <th>Cantidad</th>
                <th>Unidad</th>
                <th>Valor Unitario</th>
                <th>Impuesto</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>84111506</td> <!-- Clave del Servicio SAT para consultas -->
                <td>Consulta Médica</td>
                <td>1</td>
                <td>Servicio</td>
                <td>${{ number_format($venta->precio_consulta, 2) }}</td>
                <td>{{ number_format($consultaImpuesto, 2) }}%</td> <!-- Aquí se muestra el impuesto dinámico -->
            </tr>
            
            
            
            @foreach ($venta->conceptos as $concepto)
                <?php
                    $precioUnitario = $concepto->precio_unitario;
                    $impuesto = $concepto->impuesto;
                    $cantidad = $concepto->pivot->cantidad;
                    $impuestoCalculado = ($precioUnitario * $impuesto / 100);
                ?>
                <tr>
                    <td>01010101</td> <!-- Clave de Producto/Servicio SAT -->
                    <td>{{ $concepto->concepto }}</td>
                    <td>{{ $cantidad }}</td>
                    <td>Unidad</td>
                    <td>${{ number_format($precioUnitario, 2) }}</td>
                    <td>{{ number_format($impuesto, 2) }}%</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        <p><strong>Subtotal:</strong> {{ number_format($venta->total - $venta->iva, 2) }}</p>
        <p><strong>IVA ({{ $venta->iva > 0 ? '16%' : '0%' }}):</strong> {{ number_format($venta->iva, 2) }}</p>
        <p><strong>Total:</strong> {{ number_format($venta->total, 2) }}</p>
    </div>

    <p><strong>Forma de Pago:</strong> Pago en una sola exhibición</p>
    <p><strong>Método de Pago:</strong> {{ $venta->tipo_pago }}</p> <!-- Aquí se muestra el método de pago -->
</div>

<div class="footer">
    <p>Este documento es una representación impresa de un CFDI</p>
    <div class="barcode">
        {!! $barcode !!}
    </div>
</div>

</body>
</html>
