<?php

namespace App\Http\Controllers;

use App\Models\Colonia;
use App\Models\Municipio;
use App\Models\EntidadFederativa;
use Illuminate\Http\Request;

class ColoniaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Asegúrate de que las relaciones 'municipio' y 'entidad' están correctamente definidas en el modelo Colonia.
        $colonias = Colonia::with(['municipio', 'entidad'])->get();
    
        return view('medico.catalogos.colonias.colonias', compact('colonias'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $municipios = Municipio::all(); // O la consulta que sea necesaria para obtener los municipios
        $entidades = EntidadFederativa::all(); // O la consulta necesaria para obtener las entidades federativas
        
        return view('medico.catalogos.colonias.agregarColonia', compact('municipios', 'entidades'));
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'asentamiento' => 'required|string|max:255',
            'tipo_asentamiento' => 'required|string|max:255',
            'cp' => 'required|string|max:10',
            'id_municipio' => 'required|exists:municipios,id_municipio',
            'id_entidad' => 'required|exists:entidades_federativas,id',
        ]);

        Colonia::create($request->all());

        return redirect()->route('colonias.index')
            ->with('success', 'Colonia creada exitosamente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id_asentamiento, $id_entidad, $id_municipio)
    {
        $colonia = Colonia::where([
            ['id_asentamiento', $id_asentamiento],
            ['id_entidad', $id_entidad],
            ['id_municipio', $id_municipio]
        ])->firstOrFail();

        $municipios = Municipio::all();
        $entidades = EntidadFederativa::all();

        return view('medico.catalogos.colonias.editarColonia', compact('colonia', 'municipios', 'entidades'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_asentamiento, $id_entidad, $id_municipio)
    {
        $request->validate([
            'asentamiento' => 'required|string|max:255',
            'tipo_asentamiento' => 'required|string|max:255',
            'cp' => 'required|string|max:10',
            'id_municipio' => 'required|exists:municipios,id_municipio',
            'id_entidad' => 'required|exists:entidades_federativas,id',
        ]);

        $colonia = Colonia::where([
            ['id_asentamiento', $id_asentamiento],
            ['id_entidad', $id_entidad],
            ['id_municipio', $id_municipio]
        ])->firstOrFail();

        $colonia->update($request->all());

        return redirect()->route('colonias.index')
            ->with('success', 'Colonia actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_asentamiento, $id_entidad, $id_municipio)
    {
        $colonia = Colonia::where([
            ['id_asentamiento', $id_asentamiento],
            ['id_entidad', $id_entidad],
            ['id_municipio', $id_municipio]
        ])->firstOrFail();

        $colonia->delete();

        return redirect()->route('colonias.index')
            ->with('success', 'Colonia eliminada exitosamente.');
    }
}
