{{-- resources/views/VicenteVelez/RE/pasaportePDF.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Constancia Pediátrica para Trámite de Pasaporte</title>
    <style>
        @page {
            size: letter;      /* Hoja tamaño carta */
            margin: 20mm;      /* Margen de la hoja en todos los lados */
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 18px; /* Tamaño de fuente base para el resto del documento */
            line-height: 1.6;   /* Espacio entre líneas para el resto del documento */
        }

        .marco {
            border: 1px solid #000;
            padding: 30px;
            margin: 0 auto; /* Centrar horizontalmente */
            height: 800px; /* Altura fija para tamaño carta, ajusta según sea necesario */
            box-sizing: border-box; /* Asegura que el borde y el padding no aumenten la altura */
            page-break-inside: avoid; /* Evita que el contenido se divida en páginas */
        }


        .encabezado {
            text-align: center;
            margin-bottom: 10px;
        }

        /* Dr. Vicente con 34px */
        .encabezado .nombre-doctor {
            font-size: 34px;
        }

        /* Fuente más pequeña para estas líneas */
        .encabezado .linea-pequena {
            font-size: 14px;
        }

        /* Por si queremos reutilizarlos en el bloque de "Constancia" */
        .titulo {
            font-size: 15px;
            font-weight: bold;
            margin: 0; /* Eliminamos margen, lo controlaremos con <br> o CSS */
        }

        .subtitulo {
            font-size: 15px;
            margin: 0;
        }

        .contenido {
            text-align: justify;
            margin: 30px 0; /* Reducido de 40px a 30px */
            font-size: 14px; /* Tamaño de fuente reducido */
            line-height: 1.4; /* Interlineado ajustado */
        }

        .contenido p {
            margin: 0 0 10px; /* Reducido de 12px a 10px */
        }

        .firma {
            margin-top: 60px;
            text-align: center;
        }

        .firma span {
            display: block;
        }
    </style>
</head>
<body>
    <div class="marco">
        {{-- ENCABEZADO --}}
        {{-- ENCABEZADO --}}
        <div class="encabezado" style="line-height: 1; margin-bottom: 3px;">
            <!-- Nombre del Doctor, grande, dinámico -->
            <strong class="nombre-doctor">{{ $doctorName }}</strong><br>

            <!-- Resto de líneas con fuente más pequeña -->
            <span class="linea-pequena" style="display: block;">ESPECIALISTA EN PEDIATRÍA</span>
            <span class="linea-pequena" style="display: block;">
                CÉDULA PROFESIONAL: {{ $cedula }} REG. S.S.A. 92703
            </span>
            <span class="linea-pequena" style="display: block;">
                CONSULTORIO: {{ $calle }}
            </span>
        </div>



        <!-- Dos espacios y línea de teléfonos (centrada, mayúsculas y letra pequeña) -->
        <br>
        <div style="text-align: center; font-size: 11px; text-transform: uppercase;">
            TELEFONO CELULAR: {{ $telefonoPersonalMedico }}. TELEFONO CONSULTORIO: {{ $consultorio->telefono }}
        </div>

        <!-- DOS SALTOS DE LÍNEA y luego el título + subtítulo a la derecha con line-height 1.5 -->
        <br><br>
        <div style="text-align: right; line-height: 1.5;">
            <div class="titulo" style="text-align: right;">
                Constancia Pediátrica para el
                <div class="titulo" style="text-align: right;">
                    Trámite de Pasaporte
                </div>
            </div>
            <div class="subtitulo" style="text-align: right;">
                Cd. Victoria Tam. {{ \Carbon\Carbon::now()->locale('es')->translatedFormat('d \d\e F \d\e Y') }}
            </div>
        </div>

        {{-- CONTENIDO --}}
        <div class="contenido">
            <p><strong>A QUIEN CORRESPONDA:</strong></p>
            <p>
                El que suscribe, médico pediatra 
                <strong>{{ $doctorName }}</strong>, legalmente autorizado para ejercer mi profesión
                tal como se desprende de mi cédula profesional número:
                <strong>{{ $cedula }}</strong>, de la cual adjunto al presente una copia simple,
                <strong>HAGO CONSTAR QUE</strong>: el (la) menor 
                <strong>{{ $menor->nombres }} {{ $menor->apepat }} {{ $menor->apemat }}</strong>, 
                cuya fotografía aparece al margen, es hijo(a) de 
                <strong>{{ $menor->padre }}</strong> y 
                <strong>{{ $menor->madre }}</strong>, siendo mi paciente desde recién nacido(a)
                y encontrándose al corriente con sus inmunizaciones. 
                Se extiende la presente a petición de los padres de el(la) menor,
                para los fines que a ellos convengan.
            </p>
        </div>
        <br><br>
        {{-- FIRMA --}}
        <div class="firma">
            <span>ATENTAMENTE</span>
            <span><strong>{{ $doctorName }}</strong></span>
        </div>
    </div>
</body>
</html>
