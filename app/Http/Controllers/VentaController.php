<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Venta;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade as DomPDF;
use Barryvdh\DomPDF\PDF;
use Picqer\Barcode\BarcodeGeneratorHTML;

class VentaController extends Controller
{
    protected $pdf;

    // Usa inyección de dependencias para instanciar la clase PDF
    public function __construct(PDF $pdf)
    {
        $this->pdf = $pdf;
    }

    public function show($id)
    {
        $venta = Venta::findOrFail($id);
        $productos = Producto::where('medico_id', Auth::id())->get();
        $paciente = $venta->paciente; // Asumiendo que la relación 'paciente' está definida en el modelo Venta

        return view('medico.ventas.show', compact('venta', 'productos', 'paciente'));
    }
    
    public function index()
    {
        $currentUser = Auth::user();
        $medicoId = $currentUser->medico_id ? $currentUser->medico_id : $currentUser->id;
        
        // Filtrar las ventas según el ID del médico o el ID del usuario autenticado a través de la relación con la consulta
        $ventas = Venta::whereHas('consulta', function($query) use ($medicoId, $currentUser) {
            $query->where('usuariomedicoid', $medicoId)
                ->orWhere('usuariomedicoid', $currentUser->id);
        })->get();

        return view('medico.ventas.index', compact('ventas'));
    }

    public function store(Request $request)
    {
        // Validación de datos
        $request->validate([
            'consulta_id' => 'required|exists:consultas,id',
            'precio_consulta' => 'required|numeric',
            'iva' => 'required|numeric',
            'total' => 'required|numeric',
            'paciente_id' => 'required|exists:pacientes,id',
            'productos' => 'nullable|array', // Asegura que productos es un array, puede ser null
            'productos.*.id' => 'required_with:productos|exists:productos,id',
            'productos.*.cantidad' => 'required_with:productos|integer|min:1',
        ]);

        // Inicializar total con el precio de la consulta
        $total = $request->precio_consulta;
        $iva = $total * 0.16; // IVA inicial basado solo en el precio de la consulta

        if (!empty($request->productos)) {
            foreach ($request->productos as $producto) {
                $productoModel = Producto::find($producto['id']);

                // Verificar que haya suficiente inventario
                if ($productoModel->inventario < $producto['cantidad']) {
                    return redirect()->back()->with('error', 'No hay suficiente inventario para el producto ' . $productoModel->nombre);
                }

                // Sumar el precio de los productos al total
                $total += $productoModel->precio * $producto['cantidad'];
            }

            // Recalcular el IVA basado en el nuevo total
            $iva = $total * 0.16;
        }

        // Crear la venta con el total final y los datos de la consulta
        $venta = Venta::updateOrCreate(
            ['consulta_id' => $request->consulta_id],
            [
                'precio_consulta' => $request->precio_consulta,
                'iva' => $iva,
                'total' => $total + $iva,
                'paciente_id' => $request->paciente_id,
                'status' => 'en proceso',
            ]
        );

        // Asociar productos a la venta y actualizar inventario si existen productos
        if (!empty($request->productos)) {
            foreach ($request->productos as $producto) {
                $productoModel = Producto::find($producto['id']);
                $venta->productos()->syncWithoutDetaching([$producto['id'] => ['cantidad' => $producto['cantidad']]]);
                $productoModel->inventario -= $producto['cantidad'];
                $productoModel->save();
            }
        }

        // Redirigir con un mensaje de éxito a la vista de consultas
        return redirect()->route('consultas.index')->with('success', 'Venta guardada exitosamente y el inventario ha sido actualizado.');
    }

    public function generateInvoice($id)
    {
        $venta = Venta::findOrFail($id);
        $paciente = $venta->paciente;

        // Generar el código de barras en HTML utilizando el ID de la venta y ajustando el ancho y la altura
        $generator = new BarcodeGeneratorHTML();
        $barcode = $generator->getBarcode($venta->id, $generator::TYPE_CODE_128, 3, 50); // Ajusta la escala y la altura

        // Usar la instancia PDF para generar la factura e incluir el código de barras
        $pdf = $this->pdf->loadView('medico.ventas.invoice', compact('venta', 'paciente', 'barcode'));

        // Definir el nombre del archivo como "NombreDelPaciente_Factura.pdf"
        $fileName = $paciente->Nombre_fact . '_Factura.pdf';

        // Verificar si la carpeta 'facturas' existe, si no, crearla
        $facturasPath = storage_path('app/facturas');
        if (!file_exists($facturasPath)) {
            mkdir($facturasPath, 0777, true);
        }

        // Guardar el archivo en el sistema de archivos (en la carpeta 'facturas' dentro de 'storage/app')
        $pdf->save($facturasPath . '/' . $fileName);

        // Retornar la descarga del archivo
        return response()->download($facturasPath . '/' . $fileName);
    }

    public function pagar($id)
    {
        $venta = Venta::findOrFail($id);
        $venta->status = 'pagado';
        $venta->save();

        return redirect()->route('ventas.index')->with('success', 'El estado de la venta ha sido actualizado a Pagado.');
    }

}
