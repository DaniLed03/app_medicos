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

    public function index(Request $request)
    {
        $medicoId = Auth::id(); // Get the ID of the logged-in doctor
        $query = Consultas::with(['cita.paciente', 'usuarioMedico'])
            ->where('usuariomedicoid', $medicoId); // Filter by the doctor's ID
    
        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = Carbon::parse($request->start_date);
            $endDate = Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('fechaHora', [$startDate, $endDate]);
        } else {
            $currentMonth = now()->month;
            $currentYear = now()->year;
            $query->whereMonth('fechaHora', $currentMonth)->whereYear('fechaHora', $currentYear);
        }
    
        if ($request->has('name')) {
            $name = $request->name;
            $query->whereHas('cita.paciente', function ($query) use ($name) {
                $query->where('nombres', 'like', "%{$name}%")
                    ->orWhere('apepat', 'like', "%{$name}%")
                    ->orWhere('apemat', 'like', "%{$name}%");
            });
        }
    
        $consultas = $query->paginate(10);
    
        $months = [
            1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
            5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
            9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
        ];
        $monthName = $months[now()->month];
        $totalConsultas = $consultas->total();
        
        $consultasCollection = collect($consultas->items());
        $totalFacturacion = $consultasCollection->sum('totalPagar');
    
        return view('medico.consultas.consultas', compact('consultas', 'monthName', 'totalConsultas', 'totalFacturacion'));
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

    public function print($id)
    {
        $consulta = Consultas::with('cita.paciente', 'usuarioMedico')->findOrFail($id);
        return view('medico.consultas.print', compact('consulta'));
    }

    public function show($id)
    {
        $consulta = Consultas::with(['cita.paciente', 'recetas', 'usuarioMedico'])->findOrFail($id);
        return view('medico.consultas.verConsulta', compact('consulta'));
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
}
