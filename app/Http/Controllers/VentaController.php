<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Venta;
use App\Models\Concepto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Picqer\Barcode\BarcodeGeneratorHTML;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Models\Paciente;    

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
        $conceptos = Concepto::where('medico_id', Auth::id())->get();
        $paciente = $venta->paciente;

        return view('medico.ventas.show', compact('venta', 'conceptos', 'paciente'));
    }



    public function index()
    {
        Carbon::setLocale('es');

        $currentUser = Auth::user();
        $medicoId = $currentUser->medico_id ? $currentUser->medico_id : $currentUser->id;

        $currentMonth = Carbon::now()->format('Y-m');
        $lastMonth = cache()->get('last_month', $currentMonth);

        if ($currentMonth !== $lastMonth) {
            cache()->put('last_month', $currentMonth);
            cache()->put('total_facturacion', 0);
        }

        $ventas = Venta::whereHas('consulta', function($query) use ($medicoId, $currentUser) {
            $query->where('usuariomedicoid', $medicoId)
                ->orWhere('usuariomedicoid', $currentUser->id);
        })->get();

        // Calcular el total de facturación solo de las ventas con estado "Pagado" o "pagado"
        $totalFacturacion = Venta::whereHas('consulta', function($query) use ($medicoId, $currentUser) {
            $query->where('usuariomedicoid', $medicoId)
                ->orWhere('usuariomedicoid', $currentUser->id);
        })
        ->where('status', 'Pagado')
        ->orWhere('status', 'pagado')
        ->whereMonth('created_at', Carbon::now()->month)
        ->whereYear('created_at', Carbon::now()->year)
        ->sum('total');

        cache()->put('total_facturacion', $totalFacturacion);

        return view('medico.ventas.index', compact('ventas', 'totalFacturacion'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'consulta_id' => 'nullable|exists:consultas,id', 
            'precio_consulta' => 'required|numeric',
            'total' => 'required|numeric',
            'paciente_id' => 'required|exists:pacientes,id',
            'conceptos' => 'nullable|array',
            'conceptos.*.id' => 'required_with:conceptos|exists:conceptos,id',
            'conceptos.*.cantidad' => 'required_with:conceptos|integer|min:1',
        ]);

        // Buscar si ya existe una venta para esta consulta
        $venta = Venta::where('consulta_id', $request->consulta_id)->first();

        $total = $request->precio_consulta;
        $impuestos = 0;
        $conceptosAgregados = false;

        if (!empty($request->conceptos)) {
            foreach ($request->conceptos as $concepto) {
                $conceptoModel = Concepto::find($concepto['id']);

                $subtotal = $conceptoModel->precio_unitario * $concepto['cantidad'];
                $total += $subtotal;

                // Calcular el impuesto basado en el porcentaje de impuesto del concepto
                if ($conceptoModel->impuesto > 0) {
                    $impuestos += ($subtotal * ($conceptoModel->impuesto / 100));
                }
                $conceptosAgregados = true;  // Indicar que se han agregado nuevos conceptos
            }
        }

        // Si existen nuevos conceptos, actualizamos el total y el IVA
        if ($venta && !$conceptosAgregados) {
            $impuestos = $venta->iva;  // Mantener el IVA existente
            $total = $venta->total;    // Mantener el total existente
        } else {
            $totalConImpuesto = $total + $impuestos;
        }

        // Guardar o actualizar la venta
        $venta = Venta::updateOrCreate(
            ['consulta_id' => $request->consulta_id],
            [
                'precio_consulta' => $request->precio_consulta,
                'iva' => $impuestos, // Guardar o mantener el impuesto calculado
                'total' => $totalConImpuesto ?? $total, // Guardar o mantener el total
                'paciente_id' => $request->paciente_id,
                'status' => $venta ? $venta->status : 'Por pagar', // Mantener el estado o establecerlo como 'Por pagar'
            ]
        );

        // Asociar conceptos a la venta
        if (!empty($request->conceptos)) {
            foreach ($request->conceptos as $concepto) {
                $venta->conceptos()->syncWithoutDetaching([$concepto['id'] => ['cantidad' => $concepto['cantidad']]]);
            }
        }

        return redirect()->route('ventas.index')->with('success', 'Venta guardada correctamente.');
    }

    public function marcarComoPagado($id)
    {
        $venta = Venta::findOrFail($id);
        $conceptos = Concepto::where('medico_id', Auth::id())->get();
        $paciente = $venta->paciente;

        // Redirigir a la vista show con los datos de la venta actual
        return view('medico.ventas.show', compact('venta', 'conceptos', 'paciente'));
    }

    public function actualizarVenta(Request $request, $id)
    {
        $venta = Venta::findOrFail($id);

        // Inicializar valores
        $precioConsulta = $venta->precio_consulta;
        $total = $precioConsulta;
        $porcentajeImpuestoTotal = $venta->iva;

        // Decodificar el JSON enviado desde la vista
        $conceptos = json_decode($request->input('conceptos'), true);

        // Verificar si se han agregado conceptos
        if (is_array($conceptos) && !empty($conceptos)) {
            foreach ($conceptos as $conceptoData) {
                $concepto = Concepto::find($conceptoData['id']);

                // Calcular subtotal del concepto
                $subtotal = $concepto->precio_unitario * $conceptoData['cantidad'];
                $total += $subtotal;

                // Acumular el porcentaje de impuesto de cada concepto
                $porcentajeImpuestoTotal += $concepto->impuesto;
            }
        }

        // Calcular el total del impuesto basado en el porcentaje total acumulado
        $impuestoCalculado = ($total * $porcentajeImpuestoTotal) / 100;
        $totalConImpuesto = $total + $impuestoCalculado;

        // Actualizar el total, IVA y marcar como "Pagado"
        $venta->update([
            'iva' => $porcentajeImpuestoTotal,
            'total' => $totalConImpuesto,
            'status' => 'Pagado',
        ]);

        return redirect()->route('ventas.index')->with('success');
    }


    
    public function generateInvoice($id)
    {
        $venta = Venta::findOrFail($id);
        $paciente = $venta->paciente;

        $generator = new BarcodeGeneratorHTML();
        $barcode = $generator->getBarcode($venta->id, $generator::TYPE_CODE_128, 3, 50);

        $pdf = PDF::loadView('medico.ventas.invoice', compact('venta', 'paciente', 'barcode'));

        $fileName = $paciente->Nombre_fact . '_Factura.pdf';

        $facturasPath = storage_path('app/facturas');
        if (!file_exists($facturasPath)) {
            mkdir($facturasPath, 0777, true);
        }

        $pdf->save($facturasPath . '/' . $fileName);

        return response()->download($facturasPath . '/' . $fileName);
    }

    public function pagar($id)
    {
        $venta = Venta::findOrFail($id);
        $venta->status = 'pagado';
        $venta->save();

        return redirect()->route('ventas.index')->with('success', 'El estado de la venta ha sido actualizado a Pagado.');
    }

    public function mostrarVenta($ventaId)
    {
        $venta = Venta::findOrFail($ventaId);
        $paciente = $venta->paciente;

        // Recuperar todos los conceptos (puedes aplicar un filtro si es necesario)
        $conceptos = Concepto::all();

        $edad = \Carbon\Carbon::parse($paciente->fechanac)->diff(\Carbon\Carbon::now());

        return view('medico.ventas.show', compact('venta', 'paciente', 'edad', 'conceptos'));
    }

}

