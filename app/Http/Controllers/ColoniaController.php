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
        $entidades = EntidadFederativa::all();
        $municipios = Municipio::all(); // Añade esta línea para obtener los municipios
        $colonias = Colonia::with(['municipio', 'entidadFederativa'])->get();
        
        return view('medico.catalogos.colonias.colonias', compact('colonias', 'entidades', 'municipios'));
    }

    
    public function getMunicipiosByEntidad($id_entidad)
    {
        $municipios = Municipio::where('entidad_federativa_id', $id_entidad)->get();
        return response()->json($municipios);
    }
    
    public function getColoniasByMunicipio(Request $request, $municipioId)
    {
        $entidadId = $request->input('entidad_id'); // Asegúrate de que este valor esté siendo pasado correctamente desde el front-end.

        $search = $request->input('search')['value']; // Obtén el valor de búsqueda.
        $start = $request->input('start'); // Desde qué registro comenzar.
        $length = $request->input('length'); // Cuántos registros cargar.

        // Filtra las colonias por municipio y entidad, y busca coincidencias.
        $query = Colonia::where('id_municipio', $municipioId)
            ->where('id_entidad', $entidadId) // Filtra también por entidad
            ->with(['municipio', 'entidadFederativa']);

        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('asentamiento', 'like', "%$search%")
                    ->orWhere('tipo_asentamiento', 'like', "%$search%")
                    ->orWhere('cp', 'like', "%$search%")
                    ->orWhereHas('municipio', function ($query) use ($search) {
                        $query->where('nombre', 'like', "%$search%");
                    })
                    ->orWhereHas('entidadFederativa', function ($query) use ($search) {
                        $query->where('nombre', 'like', "%$search%");
                    });
            });
        }

        $totalFiltered = $query->count();

        $colonias = $query->offset($start)
            ->limit($length)
            ->get();

        // Aquí estamos asegurando que la respuesta JSON incluya los nombres correctos del municipio y entidad federativa.
        $data = $colonias->map(function ($colonia) {
            return [
                'asentamiento' => $colonia->asentamiento,
                'tipo_asentamiento' => $colonia->tipo_asentamiento,
                'cp' => $colonia->cp,
                'municipio' => $colonia->municipio->nombre,
                'entidad' => $colonia->entidadFederativa->nombre,
                'acciones' => '
                    <div class="flex space-x-2">
                        <button class="text-blue-500 hover:text-blue-700" onclick="openEditColoniaModal(' . $colonia->id_asentamiento . ', ' . $colonia->id_entidad . ', ' . $colonia->id_municipio . ')">Editar</button>
                        
                        <button class="text-red-500 hover:text-red-700" onclick="confirmarEliminarColonia(' . $colonia->id_asentamiento . ', ' . $colonia->id_entidad . ', ' . $colonia->id_municipio . ')">Eliminar</button>
                    </div>
                '
                ];
        });
        
        return response()->json([
            "draw" => intval($request->input('draw')),
            "recordsTotal" => Colonia::where('id_municipio', $municipioId)->where('id_entidad', $entidadId)->count(),
            "recordsFiltered" => $totalFiltered,
            "data" => $data
        ]);
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
        // Validamos los datos entrantes
        $request->validate([
            'asentamiento' => 'required|string|max:255',
            'tipo_asentamiento' => 'required|string|max:255',
            'cp' => 'required|string|max:10',
            'id_municipio' => 'required|exists:municipios,id_municipio',
            'id_entidad' => 'required|exists:entidades_federativas,id',
        ]);

        // Generación del próximo id_asentamiento
        $lastAsentamientoId = Colonia::max('id_asentamiento');
        $nextAsentamientoId = $lastAsentamientoId ? $lastAsentamientoId + 1 : 1;

        // Inserción de la colonia
        Colonia::create([
            'id_asentamiento' => $nextAsentamientoId,
            'id_entidad' => $request->input('id_entidad'),
            'id_municipio' => $request->input('id_municipio'),
            'asentamiento' => $request->input('asentamiento'),
            'tipo_asentamiento' => $request->input('tipo_asentamiento'),
            'cp' => $request->input('cp')
        ]);

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
    
        // Devolver los datos de la colonia como JSON
        return response()->json($colonia);
    }
    


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_asentamiento, $id_entidad, $id_municipio)
    {
        $request->validate([
            'cp' => 'required|string|max:10',
            'tipo_asentamiento' => 'required|string|max:255',
            'asentamiento' => 'required|string|max:255'
        ]);

        Colonia::where('id_asentamiento', $id_asentamiento)
            ->where('id_entidad', $id_entidad)
            ->where('id_municipio', $id_municipio)
            ->update([
                'cp' => $request->cp,
                'tipo_asentamiento' => $request->tipo_asentamiento,
                'asentamiento' => $request->asentamiento
            ]);

        return redirect()->route('colonias.index')
            ->with('success', 'Colonia actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_asentamiento, $id_entidad, $id_municipio)
    {
        Colonia::where('id_asentamiento', $id_asentamiento)
            ->where('id_entidad', $id_entidad)
            ->where('id_municipio', $id_municipio)
            ->delete();

        return redirect()->route('colonias.index')
            ->with('success', 'Colonia eliminada exitosamente.');
    }

}
