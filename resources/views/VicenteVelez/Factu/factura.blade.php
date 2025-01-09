<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recibo</title>
    <style>
        @page {
            size: A5 portrait;
            margin: 15mm 5mm; /* Márgenes: 15mm superior/inferior, 5mm izquierda/derecha */
        }
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            font-size: 10px; /* Tamaño reducido para fuente base */
            line-height: 1.4;
        }
        .marco {
            width: calc(100% - 10mm);
            height: calc(100% - 30mm);
            padding: 10px;
            margin: auto;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .encabezado {
            text-align: center;
            margin-bottom: 10px;
        }
        .fecha {
            text-align: right;
            margin-bottom: 10px;
            font-size: 10px; /* Ajustado proporcionalmente */
        }
        .titulo {
            font-size: 13px; /* Ajustado proporcionalmente */
            font-weight: bold;
        }
        .subtitulo {
            font-size: 12px; /* Ajustado proporcionalmente */
        }
        .contenido {
            margin-top: 20px;
        }
        .campo {
            margin-bottom: 15px;
        }
        .firma {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="marco">
        <div class="encabezado">
            <!-- Línea única para el título y la dirección -->
            <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                <!-- Título alineado a la izquierda -->
                <div style="text-align: left; font-size: 9px; flex: 1;">
                    CONSULTORIO MÉDICO ESPECIALIZADO EN PEDIATRÍA
                </div>
                <!-- Dirección alineada a la derecha -->
                <div style="text-align: right; font-size: 9px; flex: 1;">
                    {{ $calle }}
                </div>
            </div>
            <!-- Información adicional justificada a la izquierda -->
            <div style="text-align: left; font-size: 14px; font-weight: bold;">
                {{ strtoupper($doctorName) }}
            </div>
            <div style="text-align: left; font-size: 9px;">
                VICTORIA TAMS. TEL: {{ $telefonoConsultorio }} | CEL: {{ $telefonoPersonalMedico }}
            </div>
            <div style="text-align: left; font-size: 9px;">
                CÉD. PROF. {{ $cedula }} | CORREO: {{ $emailMedico }}
            </div>
        </div>

        <!-- Fecha -->
        <div class="fecha">
            CD. VICTORIA TAM. {{ now()->format('d') }} DE {{ strtoupper(now()->locale('es')->monthName) }} DE {{ now()->format('Y') }}
        </div>

        <!-- Contenido -->
        <div class="contenido">
            <div class="campo">
                RECIBÍ DE: {{ $quienRecibe }}
            </div>
            <div class="campo">
                LA CANTIDAD DE: ${{ number_format($cantidad, 2) }} ({{ $cantidad_letra }})
            </div>
            <div class="campo">
                POR CONCEPTO DE: 
                <span style="white-space: normal; word-wrap: break-word;">
                    {{ $concepto }}
                </span>
            </div>            
        </div>

        <!-- Firma -->
        <div class="firma">
            RECIBÍ:
            <div class="campo">
                <strong>{{ strtoupper($doctorName) }}</strong>
            </div>
        </div>
    </div>
</body>
</html>
