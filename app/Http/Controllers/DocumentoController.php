<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // <--- Importamos Log

class DocumentoController extends Controller
{
    public function generarPasaportePDF($pacienteId)
    {
        $menor = DB::selectOne("
            SELECT *
            FROM pacientes
            WHERE no_exp = ?
            LIMIT 1
        ", [$pacienteId]);

        if (!$menor) {
            abort(404, "Paciente no encontrado");
        }

        $pdf = PDF::loadView('VicenteVelez.RE.pasaportePDF', compact('menor'));
        return $pdf->stream('ConstanciaPasaporte.pdf');
    }

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

}
