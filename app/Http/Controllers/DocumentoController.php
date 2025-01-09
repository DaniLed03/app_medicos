<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // <--- Importamos Log
use NumberToWords\NumberToWords;

class DocumentoController extends Controller
{
    public function generarPasaporteDesdeFormulario(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'doctorName' => 'required|string|max:255',
            'cedula' => 'nullable|string|max:50',
            'calle' => 'nullable|string|max:255',
            'telefonoConsultorio' => 'nullable|string|max:20',
            'telefonoPersonalMedico' => 'nullable|string|max:20',
            'pacienteNombre' => 'required|string|max:255',
            'padre' => 'nullable|string|max:255',
            'madre' => 'nullable|string|max:255',
        ]);

        // Extraer los datos del formulario
        $doctorName = $request->input('doctorName');
        $cedula = $request->input('cedula', '');
        $calle = $request->input('calle', '');
        $telefonoConsultorio = $request->input('telefonoConsultorio', '');
        $telefonoPersonalMedico = $request->input('telefonoPersonalMedico', '');

        // Separar el nombre completo del paciente en nombres, apepat y apemat
        $nombreCompleto = trim($request->input('pacienteNombre'));
        $partesNombre = preg_split('/\s+/', $nombreCompleto); // Separar por espacios múltiples
        $count = count($partesNombre);

        if ($count >= 3) {
            // Asignar todas las partes excepto las dos últimas a 'nombres'
            $apemat = array_pop($partesNombre); // Última parte
            $apepat = array_pop($partesNombre); // Penúltima parte
            $nombres = implode(' ', $partesNombre); // Resto del nombre
        } elseif ($count == 2) {
            $nombres = $partesNombre[0];
            $apepat = $partesNombre[1];
            $apemat = '';
        } elseif ($count == 1) {
            $nombres = $partesNombre[0];
            $apepat = '';
            $apemat = '';
        } else {
            // Manejar caso donde no hay partes en el nombre
            $nombres = '';
            $apepat = '';
            $apemat = '';
        }

        $padre = $request->input('padre', '');
        $madre = $request->input('madre', '');

        // Crear el objeto 'menor'
        $menor = (object)[
            'nombres' => $nombres,
            'apepat' => $apepat,
            'apemat' => $apemat,
            'padre' => $padre,
            'madre' => $madre,
        ];

        // Crear el objeto 'consultorio' con los nuevos campos
        $consultorio = (object)[
            'calle' => $calle,
            'telefono' => $telefonoConsultorio,
            'cedula_profesional' => $cedula,
        ];

        // Generar el PDF con los datos proporcionados
        $pdf = PDF::loadView('VicenteVelez.RE.pasaportePDF', [
            'doctorName'  => $doctorName,
            'cedula'      => $cedula,
            'calle'       => $calle,
            'consultorio' => $consultorio,
            'telefonoPersonalMedico' => $telefonoPersonalMedico,
            'menor'       => $menor,
        ]);

        // Obtener el contenido del PDF y codificarlo en base64
        $pdfContent = $pdf->output();
        $base64Pdf  = base64_encode($pdfContent);

        // Retornar la respuesta en JSON
        return response()->json([
            'pdfBase64' => $base64Pdf,
        ]);
    }

    public function generarFacturaDesdeFormulario(Request $request)
    {
        // Validación de campos requeridos
        $validatedData = $request->validate([
            'doctorName' => 'required|string|max:255',
            'cedula' => 'required|string|max:50',
            'telefonoPersonalMedico' => 'required|string|max:20',
            'calle' => 'required|string|max:255',
            'telefonoConsultorio' => 'required|string|max:20',
            'quienRecibe' => 'required|string|max:255',
            'cantidad' => 'required|numeric',
            'concepto' => 'required|string',
        ]);

        // Obtener el correo del médico autenticado
        $medico = Auth::user();
        $emailMedico = $medico->email;

        // Asignar variables desde la solicitud validada
        $quienRecibe = $validatedData['quienRecibe'];
        $cantidad = $validatedData['cantidad'];

        // Convertir cantidad a letras y formatear los decimales
        $numberToWords = new NumberToWords();
        $numberTransformer = $numberToWords->getNumberTransformer('es');

        // Parte entera de la cantidad
        $parteEntera = floor($cantidad);
        // Parte decimal multiplicada por 100 y redondeada
        $decimales = round(($cantidad - $parteEntera) * 100);

        // Convertir la parte entera a letras
        $cantidad_letra = ucfirst($numberTransformer->toWords($parteEntera)) . ' pesos';

        // Agregar la parte decimal en formato XX/100 M.N.
        if ($decimales > 0) {
            // Si hay decimales diferentes de .00
            $cantidad_letra .= " {$decimales}/100 M.N.";
        } else {
            // Si la parte decimal es .00
            $cantidad_letra .= " 00/100 M.N.";
        }

        // Generar el PDF pasando todas las variables necesarias a la vista
        $pdf = PDF::loadView('VicenteVelez.Factu.factura', [
            'doctorName' => $validatedData['doctorName'],
            'cedula' => $validatedData['cedula'],
            'telefonoPersonalMedico' => $validatedData['telefonoPersonalMedico'],
            'calle' => $validatedData['calle'],
            'telefonoConsultorio' => $validatedData['telefonoConsultorio'],
            'quienRecibe' => $quienRecibe,
            'cantidad' => $cantidad,
            'cantidad_letra' => $cantidad_letra,
            'concepto' => $validatedData['concepto'],
            'emailMedico' => $emailMedico,
        ])->setPaper('A5', 'portrait'); // Establece el tamaño de papel a A5 y orientación vertical

        $pdfContent = $pdf->output();
        $base64Pdf = base64_encode($pdfContent);

        return response()->json([
            'pdfBase64' => $base64Pdf,
        ]);
    }



}
