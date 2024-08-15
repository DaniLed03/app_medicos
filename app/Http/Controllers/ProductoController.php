<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\PDF;
use Picqer\Barcode\BarcodeGeneratorHTML;

class ProductoController extends Controller
{
    protected $pdf;

    // Usa inyección de dependencias para instanciar la clase PDF
    public function __construct(PDF $pdf)
    {
        $this->pdf = $pdf;
    }

    public function generateReport()
    {
        $productos = Producto::all(); // Obtener todos los productos

        // Generar el código de barras en HTML utilizando un identificador único (opcional)
        $generator = new BarcodeGeneratorHTML();
        $barcode = $generator->getBarcode('PRODUCTOS_' . time(), $generator::TYPE_CODE_128, 3, 50); // Ajusta la escala y la altura

        // Usar la instancia PDF para generar el reporte e incluir el código de barras
        $pdf = $this->pdf->loadView('medico.productos.reporte', compact('productos', 'barcode'));

        // Definir el nombre del archivo como "Reporte_Productos_Fecha.pdf"
        $fileName = 'Reporte_Productos_' . date('Y_m_d') . '.pdf';

        // Verificar si la carpeta 'reportes' existe, si no, crearla
        $reportesPath = storage_path('app/reportes');
        if (!file_exists($reportesPath)) {
            mkdir($reportesPath, 0777, true);
        }

        // Guardar el archivo en el sistema de archivos (en la carpeta 'reportes' dentro de 'storage/app')
        $pdf->save($reportesPath . '/' . $fileName);

        // Retornar la descarga del archivo
        return response()->download($reportesPath . '/' . $fileName);
    }

    public function index()
    {
        $currentUser = Auth::user();
        $medicoId = $currentUser->medico_id ? $currentUser->medico_id : $currentUser->id;

        // Filtrar los productos por el ID del médico o el ID del usuario autenticado
        $productos = Producto::where(function($q) use ($medicoId, $currentUser) {
                            $q->where('medico_id', $medicoId)
                            ->orWhere('medico_id', $currentUser->id);
                        })->get();
        
        return view('medico.productos.productos', compact('productos'));
    }

    public function create()
    {
        return view('medico.productos.agregarProductos');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'inventario' => 'required|integer',
            'precio' => 'required|numeric', // Validar el campo precio
        ]);

        // Obtener el ID del médico que creó al usuario autenticado
        $medicoId = Auth::user()->medico_id ? Auth::user()->medico_id : Auth::id();

        Producto::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'inventario' => $request->inventario,
            'precio' => $request->precio, // Guardar el precio
            'medico_id' => $medicoId, // Guardar el ID del médico
        ]);

        return redirect()->route('productos.index');
    }


    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        return view('medico.productos.editarProductos', compact('producto'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'inventario' => 'required|integer',
            'precio' => 'required|numeric', // Validar el campo precio
        ]);

        $producto = Producto::findOrFail($id);
        $producto->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'inventario' => $request->inventario,
            'precio' => $request->precio, // Actualizar el precio
        ]);

        return redirect()->route('productos.index');
    }
}
