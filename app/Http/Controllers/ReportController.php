<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\PDF;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin.reports')->only('reports');
        $this->middleware('can:reportes.vehiculosMasCotizados')->only('vehiculosMasCotizados');
        $this->middleware('can:reportes.ventasNoConcretadas')->only('ventasNoConcretadas');
        $this->middleware('can:reportes.accesoriosMasSolicitados')->only('accesoriosMasSolicitados');
        $this->middleware('can:reportes.comisionesMensuales')->only('comisionesMensuales');
        $this->middleware('can:reportes.modelosMasVendidos')->only('modelosMasVendidos');
        $this->middleware('can:reportes.reporte')->only('reporte');
    }

public function reports()
{
    return view('reports.reports');
}

    public function reporte()
    {
        $startDate = '2022-10-21 00:00:00';
        $endDate = '2022-10-31 00:00:00';
        $sortBy = 'Cantidad';
        $reporte = DB::table('sales AS s')
            ->join('quotation_vehicle AS q_v', 'q_v.quotation_id', '=', 's.quotation_id')
            ->join('vehicles AS v', 'q_v.vehicle_id', '=', 'v.id')
            ->join('vehicle_models AS v_m', 'v_m.id', '=', 'v.vehicle_model_id')
            ->join('brands AS b', 'v_m.brand_id', '=', 'b.id')
            ->select(['b.name AS Marca', 'v_m.name AS Modelo', DB::raw('COUNT(v_m.id) AS Cantidad')])
            ->whereBetween('s.dateTimeGenerated', [$startDate, $endDate])
            ->groupBy(['v_m.id', 'b.name', 'v_m.name'])
            ->orderBy('Cantidad', 'DESC')
            ->get();
        return view('reports.reporte', compact('reporte'));
    }
    public function vehiculosMasCotizados(Request $request)
    {
        $title = "Vehículos más cotizados";
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $sortBy = 'Cantidad';
        $queryBuilder = DB::table('quotation_vehicle AS q_v')
            ->join('quotations AS q', 'q_v.quotation_id', '=', 'q.id')
            ->join('vehicles AS v', 'q_v.vehicle_id', '=', 'v.id')
            ->join('vehicle_models AS v_m', 'v_m.id', '=', 'v.vehicle_model_id')
            ->join('brands AS b', 'v_m.brand_id', '=', 'b.id')
            ->select(['b.name AS Marca', 'v_m.name AS Modelo', DB::raw('COUNT(v_m.id) AS Cantidad')])
            ->whereBetween(DB::raw('DATE(q.dateTimeGenerated)'), [$startDate, $endDate])
            ->groupBy(['v_m.id', 'b.name', 'v_m.name'])
            ->orderBy('Cantidad', 'DESC')
            ->get();
        return view('reports.reporte', compact('queryBuilder', 'title'));
    }
    public function ventasNoConcretadas(Request $request)
    {
        $title = "Ventas no concretadas";
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $sales = Sale::where('concretized', 0)->get();
        $reporte = [];
        // $quotation->vehicles[0]->accessoriesQuotation[0]->models[0]->pivot->price; //Precio del accesorio para un modelo
        foreach ($sales as $sale) {
            $vehicles = [];
            foreach ($sale->quotation->vehicles as $vehicle) {
                $accesories = [];
                foreach ($vehicle->accessoriesQuotation as $accessorie) {
                    $accesories[] = [
                        'Nombre' => $accessorie->name,
                    ];
                }
                $vehicles[] = [
                    'ID' => $vehicle->id,
                    'Marca' => $vehicle->vehicleModel->brand->name,
                    'Modelo' => $vehicle->vehicleModel->name,
                    'Chassis' => $vehicle->chassis,
                    'Precio' => $vehicle->price,
                    'Accesorios' => $accesories,
                ];
            }
            $reporte[] = [
                'Venta' => $sale->id,
                'Vendedor' => $sale->seller->name . ' ' . $sale->seller->lastName,
                'Comisión' => $sale->comission,
                'Cotización' => $sale->quotation->id,
                'Importe' => $sale->quotation->finalAmount,
                'Vehiculos' => $vehicles,
            ];
        }
        // return $reporte;
        return view('reports.ventas-no-concretadas', compact('reporte', 'title'));
    }
    public function accesoriosMasSolicitados(Request $request)
    {
        $title = "Accesorios más solicitados";
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $sortBy = 'Cantidad';
        $queryBuilder = DB::table('accessory_quotation_vehicle AS a_q_v')
            ->join('quotations AS q', 'a_q_v.quotation_id', '=', 'q.id')
            ->join('accessories AS a', 'a_q_v.accessory_id', '=', 'a.id')
            ->select(['a.name AS Accesorio', DB::raw('COUNT(a.id) AS Cantidad')])
            ->whereBetween(DB::raw('DATE(q.dateTimeGenerated)'), [$startDate, $endDate])
            ->groupBy(['a.name'])
            ->orderBy('Cantidad', 'DESC')
            ->get();
        return view('reports.reporte', compact('queryBuilder', 'title'));
    }
    public function comisionesMensuales(Request $request)
    {
        $title = "Comisiones mensuales";
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $queryBuilder = DB::table('sales AS s')
            ->join('sellers AS sl', 's.seller_id', '=', 'sl.id')
            ->select([DB::raw("CONCAT(sl.name, ' ', sl.lastName) AS Vendedor"), 'sl.dni', DB::raw('SUM(s.comission) AS Comision'), DB::raw('COUNT(*) AS Ventas')])
            ->whereBetween(DB::raw('DATE(s.dateTimeGenerated)'), [$startDate, $endDate])
            ->where('s.concretized', '=', '1')
            ->groupBy(['sl.id', 'Vendedor', 'sl.dni'])
            ->orderBy('Comision', 'DESC')
            ->get();
        return view('reports.reporte', compact('queryBuilder', 'title'));
    }
    public function modelosMasVendidos(Request $request)
    {
        $title = "Modelos más vendidos";
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $sortBy = 'Cantidad';
        $queryBuilder = DB::table('sales AS s')
            ->join('quotation_vehicle AS q_v', 'q_v.quotation_id', '=', 's.quotation_id')
            ->join('vehicles AS v', 'q_v.vehicle_id', '=', 'v.id')
            ->join('vehicle_models AS v_m', 'v_m.id', '=', 'v.vehicle_model_id')
            ->join('brands AS b', 'v_m.brand_id', '=', 'b.id')
            ->select(['b.name AS Marca', 'v_m.name AS Modelo', DB::raw('COUNT(v_m.id) AS Cantidad')])
            ->whereBetween(DB::raw('DATE(s.dateTimeGenerated)'), [$startDate, $endDate])
            ->groupBy(['v_m.id', 'b.name', 'v_m.name'])
            ->orderBy('Cantidad', 'DESC')
            ->get();
        return view('reports.reporte', compact('queryBuilder', 'title'));
    }
}
