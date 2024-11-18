<?php

namespace App\Http\Controllers;

use App\Models\Consultas;
use App\Models\Paciente;
use App\Models\ConsultaReceta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TipoDeReceta;
use Illuminate\Support\Facades\DB;

class ActualizarConsultaSinCitaController extends Controller
{
    public function editWithoutCita($pacienteId, $medicoId, $consultaId)
    {
        // Obtener los datos de la consulta y sus recetas
        $consulta = Consultas::where('usuariomedicoid', $medicoId)
                            ->where('pacienteid', $pacienteId)
                            ->where('id', $consultaId)
                            ->firstOrFail();

        // Obtener el paciente incluyendo el 'medico_id'
        $paciente = Paciente::where('no_exp', $pacienteId)
                            ->where('medico_id', $medicoId)
                            ->firstOrFail();

        // El resto de tu código permanece igual
        $tiposDeReceta = TipoDeReceta::all();
        $recetas = ConsultaReceta::where('consulta_id', $consultaId)
                                ->where('id_medico', $medicoId)
                                ->where('no_exp', $pacienteId)
                                ->get();

        // Obtener las consultas pasadas
        $consultasPasadas = Consultas::where('pacienteid', $pacienteId)
                                    ->where('usuariomedicoid', $medicoId)
                                    ->where('status', 'Finalizada')
                                    ->orderBy('fechaHora', 'desc')
                                    ->get();

        // Definir el valor de showAlert (true o false)
        $showAlert = false;

        // Retornar la vista con los datos
        return view('medico.consultas.actualizarConsultaSinCita', compact('paciente', 'consulta', 'tiposDeReceta', 'recetas', 'consultasPasadas', 'showAlert'));
    }


    public function updateWithoutCita(Request $request, $pacienteId, $medicoId, $consultaId)
    {
        // Validar los datos del formulario
        $request->validate([
            'talla' => 'nullable|string',
            'temperatura' => 'nullable|string',
            'saturacion_oxigeno' => 'nullable|string',
            'frecuencia_cardiaca' => 'nullable|string',
            'peso' => 'nullable|string',
            'tension_arterial' => 'nullable|string',
            'circunferencia_cabeza' => 'nullable|string',
            'motivoConsulta' => 'required|string',
            'diagnostico' => 'required|string',
            'recetas' => 'array', // Asegurarse de que sea un array de recetas
            'recetas.*.tipo_de_receta' => 'required|string',
            'recetas.*.receta' => 'required|string',
        ]);

        // Actualizar la consulta principal
        DB::update('UPDATE consultas
                    SET talla = ?, temperatura = ?, saturacion_oxigeno = ?, frecuencia_cardiaca = ?, 
                        peso = ?, tension_arterial = ?, circunferencia_cabeza = ?, motivoConsulta = ?, diagnostico = ?
                    WHERE usuariomedicoid = ? AND pacienteid = ? AND id = ?',
            [
                $request->talla,
                $request->temperatura,
                $request->saturacion_oxigeno,
                $request->frecuencia_cardiaca,
                $request->peso,
                $request->tension_arterial,
                $request->circunferencia_cabeza,
                $request->motivoConsulta,
                $request->diagnostico,
                $medicoId,
                $pacienteId,
                $consultaId
            ]
        );

        // **Actualización precisa de los antecedentes**
        DB::update('UPDATE pacientes 
                    SET antecedentes = ? 
                    WHERE no_exp = ? AND medico_id = ?', 
            [
                $request->input('antecedentes'),
                $pacienteId,  // Solo actualizamos si coinciden ambos no_exp y medico_id
                $medicoId
            ]
        );

        // Eliminar todas las recetas existentes para la consulta, el médico y el paciente
    DB::delete('DELETE FROM consulta_recetas WHERE id_medico = ? AND no_exp = ? AND consulta_id = ?', [
        $medicoId,
        $pacienteId,
        $consultaId
    ]);

    // Obtener el valor máximo de 'id' en la tabla consulta_recetas
    $lastId = DB::table('consulta_recetas')->max('id');

    // Si no hay un 'id' previo, comenzamos con 1
    $newId = $lastId ? $lastId + 1 : 1;

    // Insertar todas las recetas de nuevo
    if (!empty($request->recetas)) {
        foreach ($request->recetas as $recetaData) {
            // Insertar nueva receta con el id incremental
            DB::insert('INSERT INTO consulta_recetas (id, consulta_id, id_medico, no_exp, id_tiporeceta, receta)
                    VALUES (?, ?, ?, ?, ?, ?)',
                [
                    $newId,
                    $consultaId,
                    $medicoId,
                    $pacienteId,
                    $recetaData['tipo_de_receta'],
                    $recetaData['receta']
                ]
            );
            // Incrementamos el ID para la siguiente receta
            $newId++;
        }
    }

        return redirect()->route('consultas.index')->with('success', 'Consulta y recetas actualizadas exitosamente.');
    }

}
