<?php

namespace App\Http\Controllers;

use App\Models\Consultas;
use App\Models\Paciente;
use App\Models\Productos;
use App\Models\User;
use App\Models\Citas;
use App\Models\Servicio;
use App\Models\ConsultaReceta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsultaController extends Controller
{
    public function create($citaId)
    {
        $cita = Citas::with('paciente')->findOrFail($citaId);
        $medico = Auth::user();
        $productos = Productos::all();
        $servicios = Servicio::all();

        return view('medico.consultas.agregarConsulta', compact('cita', 'medico', 'productos', 'servicios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'citai_id' => 'required|exists:citas,id',
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
            'totalPagar' => 'required|numeric',
            'usuariomedicoid' => 'required|exists:users,id',
            'productos' => 'array',
            'servicios' => 'array',
            'recetas' => 'array',
            'recetas.*.medicacion' => 'required|string',
            'recetas.*.cantidad_medicacion' => 'required|integer',
            'recetas.*.frecuencia' => 'required|string',
            'recetas.*.duracion' => 'required|string',
            'recetas.*.notas' => 'nullable|string'
        ]);

        // Creación de la consulta
        $consulta = Consultas::create($request->all());

        // Adjuntar productos y servicios
        if ($request->has('productos')) {
            $consulta->productos()->attach($request->productos);
        }
        if ($request->has('servicios')) {
            $consulta->servicios()->attach($request->servicios);
        }

        // Guardar recetas
        if ($request->has('recetas')) {
            foreach ($request->recetas as $receta) {
                $consulta->recetas()->create($receta);
            }
        }

        return redirect()->route('consultas.index')->with('success', 'Consulta creada exitosamente.');
    }


    // Muestra todas las consultas
    public function index()
    {
        $consultas = Consultas::with('cita.paciente')->get();
        return view('medico.consultas.consultas', compact('consultas'));
    }

    // Muestra el formulario de edición de una consulta específica
    public function edit($id)
    {
        $consulta = Consultas::findOrFail($id);
        $productos = Productos::where('activo', 'si')->get();
        $servicios = Servicio::where('activo', 'si')->get();
        $consulta_productos = $consulta->productos()->pluck('producto_id')->toArray();
        $consulta_servicios = $consulta->servicios()->pluck('servicio_id')->toArray();
        return view('medico.consultas.editarConsulta', compact('consulta', 'productos', 'servicios', 'consulta_productos', 'consulta_servicios'));
    }

    // Actualiza la información de una consulta específica
    public function update(Request $request, $id)
    {
        // Validación de los datos recibidos
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
            'productos' => 'array',
            'servicios' => 'array',
            'recetas' => 'array',
            'recetas.*.medicacion' => 'required|string',
            'recetas.*.cantidad_medicacion' => 'required|integer',
            'recetas.*.frecuencia' => 'required|string',
            'recetas.*.duracion' => 'required|string',
            'recetas.*.notas' => 'nullable|string'
        ]);

        // Encuentra la consulta y actualiza sus datos
        $consulta = Consultas::findOrFail($id);
        $consulta->update($request->all());

        // Actualizar productos asociados a la consulta
        $consulta->productos()->sync($request->productos);

        // Actualizar servicios asociados a la consulta
        $consulta->servicios()->sync($request->servicios);

        // Actualizar recetas
        $consulta->recetas()->delete();
        if ($request->has('recetas')) {
            foreach ($request->recetas as $receta) {
                $consulta->recetas()->create($receta);
            }
        }

        // Redirecciona a la vista de consultas con un mensaje de éxito
        return redirect()->route('consultas.index')->with('status', 'Consulta actualizada correctamente');
    }
}
