<?php

namespace App\Http\Controllers;

use App\Models\Consultas;
use App\Models\Paciente;
use App\Models\User;
use App\Models\Citas;
use App\Models\ConsultaReceta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ConsultaController extends Controller
{
    public function create($citaId)
    {
        $cita = Citas::with('paciente')->findOrFail($citaId);
        $medico = Auth::user();

        return view('medico.consultas.agregarConsulta', compact('cita', 'medico'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'citai_id' => 'required|exists:citas,id',
            'hidden_talla' => 'nullable|string',
            'hidden_temperatura' => 'nullable|string',
            'hidden_saturacion_oxigeno' => 'nullable|string',
            'hidden_frecuencia_cardiaca' => 'nullable|string',
            'hidden_peso' => 'nullable|string',
            'hidden_tension_arterial' => 'nullable|string',
            'motivoConsulta' => 'required|string',
            'notas_padecimiento' => 'nullable|string',
            'interrogatorio_por_aparatos' => 'nullable|string',
            'examen_fisico' => 'nullable|string',
            'diagnostico' => 'required|string',
            'plan' => 'nullable|string',
            'status' => 'required|string|in:en curso,finalizada',
            'totalPagar' => 'required|numeric',
            'usuariomedicoid' => 'required|exists:users,id',
            'circunferencia_cabeza' => 'nullable|string', 
            'recetas' => 'array',
            'recetas.*.tipo_de_receta' => 'required|string',
            'recetas.*.receta' => 'required|string',
        ]);

        // Obtener el paciente desde la cita
        $cita = Citas::findOrFail($request->citai_id);
        $pacienteId = $cita->pacienteid;

        // Creación de la consulta
        $consultaData = $request->except('recetas'); // Exclude recetas from consultaData
        $consultaData['pacienteid'] = $pacienteId;
        $consultaData['talla'] = $request->hidden_talla;
        $consultaData['temperatura'] = $request->hidden_temperatura;
        $consultaData['saturacion_oxigeno'] = $request->hidden_saturacion_oxigeno;
        $consultaData['frecuencia_cardiaca'] = $request->hidden_frecuencia_cardiaca;
        $consultaData['peso'] = $request->hidden_peso;
        $consultaData['tension_arterial'] = $request->hidden_tension_arterial;
        $consultaData['circunferencia_cabeza'] = $request->circunferencia_cabeza;
        $consulta = Consultas::create($consultaData);

        // Guardar recetas
        if ($request->has('recetas')) {
            foreach ($request->recetas as $recetaData) {
                ConsultaReceta::create([
                    'consulta_id' => $consulta->id,
                    'tipo_de_receta' => $recetaData['tipo_de_receta'],
                    'receta' => $recetaData['receta']
                ]);
            }
        }

        return redirect()->route('consultas.index')->with('success', 'Consulta creada exitosamente.');
    }

    public function createWithoutCita($pacienteId)
    {
        $paciente = Paciente::findOrFail($pacienteId);
        $medico = Auth::user();

        return view('medico.consultas.agregarConsultaSinCita', compact('paciente', 'medico'));
    }

    public function storeWithoutCita(Request $request)
    {
        $request->validate([
            'pacienteid' => 'required|exists:pacientes,id',
            'hidden_talla' => 'nullable|string',
            'hidden_temperatura' => 'nullable|string',
            'hidden_saturacion_oxigeno' => 'nullable|string',
            'hidden_frecuencia_cardiaca' => 'nullable|string',
            'hidden_peso' => 'nullable|string',
            'hidden_tension_arterial' => 'nullable|string',
            'motivoConsulta' => 'required|string',
            'notas_padecimiento' => 'nullable|string',
            'interrogatorio_por_aparatos' => 'nullable|string',
            'examen_fisico' => 'nullable|string',
            'diagnostico' => 'required|string',
            'plan' => 'nullable|string',
            'status' => 'required|string|in:en curso,finalizada',
            'totalPagar' => 'required|numeric',
            'usuariomedicoid' => 'required|exists:users,id',
            'circunferencia_cabeza' => 'nullable|string',
            'recetas' => 'array',
            'recetas.*.tipo_de_receta' => 'required|string',
            'recetas.*.receta' => 'required|string'
        ]);

        // Creación de la consulta
        $consultaData = $request->except('recetas'); // Exclude recetas from consultaData
        $consultaData['talla'] = $request->hidden_talla;
        $consultaData['temperatura'] = $request->hidden_temperatura;
        $consultaData['saturacion_oxigeno'] = $request->hidden_saturacion_oxigeno;
        $consultaData['frecuencia_cardiaca'] = $request->hidden_frecuencia_cardiaca;
        $consultaData['peso'] = $request->hidden_peso;
        $consultaData['tension_arterial'] = $request->hidden_tension_arterial;
        $consultaData['circunferencia_cabeza'] = $request->circunferencia_cabeza;
        $consultaData['status'] = 'finalizada'; // Cambia el estado a 'finalizada'
        $consulta = Consultas::create($consultaData);

        // Guardar recetas
        if ($request->has('recetas')) {
            foreach ($request->recetas as $recetaData) {
                ConsultaReceta::create([
                    'consulta_id' => $consulta->id,
                    'tipo_de_receta' => $recetaData['tipo_de_receta'],
                    'receta' => $recetaData['receta']
                ]);
            }
        }

        // Redirigir a la vista de detalles de la consulta
        return redirect()->route('consultas.show', $consulta->id)->with('success', 'Consulta creada y finalizada exitosamente.');
    }


    public function index(Request $request)
    {
        $medicoId = Auth::id(); // Get the ID of the logged-in doctor
        $today = Carbon::today();

        // Obtener las fechas de inicio y fin del filtro
        $startDate = $request->input('start_date', $today->format('Y-m-d'));
        $endDate = $request->input('end_date', $today->format('Y-m-d'));

        // Fetch consultations within the date range with pagination
        $consultas = Citas::where('medicoid', $medicoId)
            ->where('activo', 'si')
            ->whereBetween('fecha', [$startDate, $endDate])
            ->with('persona') // Include the relationship with the person
            ->paginate(10);

        return view('medico.consultas.consultas', compact('consultas'));
    }

    public function verificarPaciente(Request $request, $citaId)
    {
        $cita = Citas::with('persona')->findOrFail($citaId);
        $correo = $cita->persona->correo;
        $curp = $cita->persona->curp;

        $paciente = Paciente::where('correo', $correo)->orWhere('curp', $curp)->first();

        if ($paciente) {
            // Si el paciente existe, redirige a la vista de agregarConsultaSinCita
            return redirect()->route('consultas.createWithoutCita', $paciente->id);
        } else {
            // Mostrar SweetAlert y redirigir
            session()->flash('alerta', true);

            return view('medico.pacientes.editarPaciente', [
                'paciente' => new Paciente([
                    'nombres' => $cita->persona->nombres,
                    'apepat' => $cita->persona->apepat,
                    'apemat' => $cita->persona->apemat,
                    'fechanac' => $cita->persona->fechanac->format('Y-m-d'),
                    'correo' => $correo,
                    'curp' => $curp,
                    'sexo' => $cita->persona->sexo,
                    'telefono' => $cita->persona->telefono,
                    'no_exp' => Paciente::max('no_exp') ? Paciente::max('no_exp') + 1 : 1,
                ])
            ]);

        }
    }


    public function edit($id)
    {
        $consulta = Consultas::findOrFail($id);

        if ($consulta->cita) {
            return view('medico.consultas.editarConsulta', compact('consulta'));
        } else {
            return view('medico.consultas.editarConsultaSinCita', compact('consulta'));
        }
    }

    public function show($id)
    {
        $consulta = Consultas::with(['recetas', 'usuarioMedico', 'cita.paciente'])
            ->findOrFail($id);

        if ($consulta->cita) {
            $paciente = $consulta->cita->paciente;
        } else {
            $paciente = Paciente::findOrFail($consulta->pacienteid);
        }

        return view('medico.consultas.verConsulta', compact('consulta', 'paciente'));
    }

    public function print($id)
    {
        $consulta = Consultas::with(['recetas', 'usuarioMedico', 'cita.paciente'])
            ->findOrFail($id);

        if ($consulta->cita) {
            $paciente = $consulta->cita->paciente;
        } else {
            $paciente = Paciente::findOrFail($consulta->pacienteid);
        }

        return view('medico.consultas.print', compact('consulta', 'paciente'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'talla' => 'nullable|string',
            'temperatura' => 'nullable|string',
            'saturacion_oxigeno' => 'nullable|string',
            'frecuencia_cardiaca' => 'nullable|string',
            'peso' => 'nullable|string',
            'tension_arterial' => 'nullable|string',
            'motivoConsulta' => 'required|string',
            'notas_padecimiento' => 'nullable|string',
            'interrogatorio_por_aparatos' => 'nullable|string',
            'examen_fisico' => 'nullable|string',
            'diagnostico' => 'required|string',
            'plan' => 'nullable|string',
            'status' => 'required|string|in:en curso,finalizada',
            'totalPagar' => 'required|numeric|min:0',
            'recetas' => 'array',
            'recetas.*.tipo_de_receta' => 'required|string',
            'recetas.*.receta' => 'required|string'
        ]);

        $consulta = Consultas::findOrFail($id);
        $consulta->update($request->all());

        $consulta->recetas()->delete();
        if ($request->has('recetas')) {
            foreach ($request->recetas as $recetaData) {
                ConsultaReceta::create([
                    'consulta_id' => $consulta->id,
                    'tipo_de_receta' => $recetaData['tipo_de_receta'],
                    'receta' => $recetaData['receta']
                ]);
            }
        }

        return redirect()->route('consultas.index')->with('status', 'Consulta actualizada correctamente');
    }

    public function terminate($id)
    {
        $consulta = Consultas::findOrFail($id);
        $consulta->status = 'finalizada';
        $consulta->save();

        return response()->json(['success' => true]);
    }

    public function navigate(Request $request)
    {
        $direction = $request->input('direction');
        $currentConsultationId = $request->input('currentConsultationId');

        $currentConsultation = Consultas::findOrFail($currentConsultationId);
        $medicoId = Auth::id(); // Get the ID of the logged-in doctor

        if ($direction == 'first') {
            $consulta = Consultas::where('usuariomedicoid', $medicoId)->orderBy('id', 'asc')->first();
        } elseif ($direction == 'prev') {
            $consulta = Consultas::where('usuariomedicoid', $medicoId)->where('id', '<', $currentConsultationId)->orderBy('id', 'desc')->first();
        } elseif ($direction == 'next') {
            $consulta = Consultas::where('usuariomedicoid', $medicoId)->where('id', '>', $currentConsultationId)->orderBy('id', 'asc')->first();
        } elseif ($direction == 'last') {
            $consulta = Consultas::where('usuariomedicoid', $medicoId)->orderBy('id', 'desc')->first();
        }

        if ($consulta) {
            $consulta->load('recetas'); // Ensure recetas are loaded
            if ($consulta->cita) {
                $paciente = $consulta->cita->paciente;
            } else {
                $paciente = Paciente::findOrFail($consulta->pacienteid);
            }

            return response()->json([
                'success' => true,
                'consulta' => $consulta,
                'paciente' => $paciente
            ]);
        } else {
            return response()->json(['success' => false]);
        }
    }
}
