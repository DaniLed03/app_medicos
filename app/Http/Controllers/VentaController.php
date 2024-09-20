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
use App\Models\VentaConcepto;

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
        $venta = Venta::with('paciente')->findOrFail($id);
        $conceptos = Concepto::where('medico_id', Auth::id())->get();
        $paciente = $venta->paciente;

        return view('medico.ventas.show', compact('venta', 'conceptos', 'paciente'));
    }

    public function index(Request $request)
    {
        Carbon::setLocale('es');

        $currentUser = Auth::user();
        $medicoId = $currentUser->medico_id ? $currentUser->medico_id : $currentUser->id;
        $today = Carbon::today();

        // Obtener las fechas de inicio y fin del filtro
        $startDate = $request->input('start_date', $today->format('Y-m-d'));
        $endDate = $request->input('end_date', $today->format('Y-m-d'));

        // Filtrar las ventas para el médico
        $ventas = Venta::whereHas('consulta', function($query) use ($medicoId) {
            $query->where('medico_id', $medicoId);
        })
        ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
        ->orderByRaw("CASE WHEN status = 'Por pagar' THEN 0 ELSE 1 END")
        ->get();

        // Calcular el total de facturación solo de las ventas con estado "Pagado"
        $totalFacturacion = Venta::whereHas('consulta', function($query) use ($medicoId) {
                $query->where('medico_id', $medicoId);
            })
            ->where('status', 'Pagado')
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->sum('total');

        return view('medico.ventas.index', compact('ventas', 'totalFacturacion'));
    }

    public function marcarComoPagado($id)
    {
        $venta = Venta::findOrFail($id);
        $currentUser = Auth::user();
        $medicoId = $currentUser->medico_id ? $currentUser->medico_id : $currentUser->id;

        $conceptos = Concepto::where('medico_id', $medicoId)->get();
        $paciente = $venta->paciente;

        // Redirigir a la vista show con los datos de la venta actual
        return view('medico.ventas.show', compact('venta', 'conceptos', 'paciente'));
    }

    public function actualizarVenta(Request $request, $id)
    {
        $venta = Venta::findOrFail($id);

        // Obtén los valores directamente del request
        $iva = $request->input('iva');
        $total = $request->input('total');
        $tipoPago = $request->input('tipo_pago'); // Obtener el tipo de pago

        // Decodificar el JSON enviado desde la vista
        $conceptos = json_decode($request->input('conceptos'), true);

        // Verificar si se han agregado conceptos
        if (is_array($conceptos) && !empty($conceptos)) {
            foreach ($conceptos as $conceptoData) {
                // Guardar cada concepto en la tabla venta_conceptos
                VentaConcepto::create([
                    'venta_id' => $venta->id,
                    'concepto_id' => $conceptoData['id'],
                    'cantidad' => $conceptoData['cantidad'],
                ]);
            }
        }

        // Actualizar la venta con los valores extraídos directamente
        $venta->update([
            'iva' => $iva,
            'total' => $total,
            'tipo_pago' => $tipoPago, // Guardar el tipo de pago
            'status' => 'Pagado',
        ]);

        return redirect()->route('ventas.index')->with('success');
    }

    public function generateInvoice($id)
    {
        $venta = Venta::with('paciente', 'conceptos')->findOrFail($id);
        $paciente = $venta->paciente;

        // Obtener el impuesto de la consulta desde la tabla Conceptos
        $consultaImpuesto = Concepto::where('id_concepto', 1) // Asegúrate de que estás obteniendo el ID correcto
                                    ->value('impuesto');

        $generator = new BarcodeGeneratorHTML();
        $barcode = $generator->getBarcode($venta->id, $generator::TYPE_CODE_128, 3, 50);

        $pdf = PDF::loadView('medico.ventas.invoice', compact('venta', 'paciente', 'barcode', 'consultaImpuesto'));

        $fileName = $paciente->Nombre_fact . '_Factura.pdf';

        $facturasPath = storage_path('app/facturas');
        if (!file_exists($facturasPath)) {
            mkdir($facturasPath, 0777, true);
        }

        $pdf->save($facturasPath . '/' . $fileName);

        return response()->download($facturasPath . '/' . $fileName);
    }

    public function mostrarVenta($ventaId)
    {
        $venta = Venta::findOrFail($ventaId);
        $paciente = $venta->paciente;

        $currentUser = Auth::user();
        $medicoId = $currentUser->medico_id ? $currentUser->medico_id : $currentUser->id;

        // Recuperar solo los conceptos del médico autenticado o su médico asociado
        $conceptos = Concepto::where('medico_id', $medicoId)->get();

        $edad = \Carbon\Carbon::parse($paciente->fechanac)->diff(\Carbon\Carbon::now());

        return view('medico.ventas.show', compact('venta', 'paciente', 'edad', 'conceptos'));
    }
}
