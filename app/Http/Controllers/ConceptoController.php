<?php

namespace App\Http\Controllers;

use App\Models\Concepto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConceptoController extends Controller
{
    public function index()
    {
        $currentUser = Auth::user();
        $medicoId = $currentUser->medico_id ? $currentUser->medico_id : $currentUser->id;

        // Obtener todos los conceptos asociados al médico actual o usuario autenticado
        $conceptos = Concepto::where('medico_id', $medicoId)
                    ->orWhere('medico_id', $currentUser->id)
                    ->get();

        return view('medico.catalogos.conceptos.conceptos', compact('conceptos'));
    }

    public function create()
    {
        return view('medico.catalogos.conceptos.agregarConcepto');
    }

    public function store(Request $request)
    {
        $request->validate([
            'concepto' => 'required|string|max:255',
            'precio_unitario' => 'required|numeric',
            'impuesto' => 'nullable|numeric',
            'unidad_medida' => 'required|string|max:50',
            'tipo_concepto' => 'required|string|max:50',
        ]);

        $currentUser = Auth::user();
        $medicoId = $currentUser->medico_id ? $currentUser->medico_id : $currentUser->id;

        Concepto::create([
            'concepto' => $request->concepto,
            'precio_unitario' => $request->precio_unitario,
            'impuesto' => $request->impuesto,
            'unidad_medida' => $request->unidad_medida,
            'tipo_concepto' => $request->tipo_concepto,
            'medico_id' => $medicoId, // Guardar con el ID del médico
        ]);

        return redirect()->route('conceptos.index')->with('success');
    }


    public function edit($id_concepto)
    {
        $concepto = Concepto::where('id_concepto', $id_concepto)->firstOrFail();
        return view('medico.catalogos.conceptos.editarConcepto', compact('concepto'));
    }

    public function update(Request $request, $id_concepto)
    {
        $request->validate([
            'concepto' => 'required|string|max:255',
            'precio_unitario' => 'required|numeric',
            'impuesto' => 'nullable|numeric',
            'unidad_medida' => 'required|string|max:50',
            'tipo_concepto' => 'required|string|max:50',
        ]);

        $concepto = Concepto::where('id_concepto', $id_concepto)->firstOrFail();
        $concepto->update([
            'concepto' => $request->concepto,
            'precio_unitario' => $request->precio_unitario,
            'impuesto' => $request->impuesto,
            'unidad_medida' => $request->unidad_medida,
            'tipo_concepto' => $request->tipo_concepto,
        ]);
        

        return redirect()->route('conceptos.index')->with('success');
    }

    public function destroy($id)
    {
        $concepto = Concepto::findOrFail($id);
        $concepto->delete();

        return redirect()->route('conceptos.index')->with('success', 'Concepto eliminado exitosamente');
    }

    public function show($id_concepto)
    {
        $medicoId = Auth::id();  // Obtener el ID del médico autenticado
        // Buscar y mostrar solo entre los conceptos del médico autenticado
        $concepto = Concepto::where('id_concepto', $id_concepto)
                            ->where('medico_id', $medicoId)
                            ->firstOrFail();

        return view('medico.catalogos.conceptos.show', compact('concepto'));
    }

    public function generateReport()
    {
        // Aquí podrías implementar la lógica para generar un PDF u otro tipo de reporte
    }
}
