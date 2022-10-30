<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class PDFController extends Controller
{
    public function generatePDF()
    {
        $startDate = '2022-10-21 00:00:00';
        $endDate = '2022-10-31 00:00:00';
        $sortBy = 'Cantidad';
        $queryBuilder = DB::table('quotation_vehicle AS q_v')
            ->join('quotations AS q', 'q_v.quotation_id', '=', 'q.id')
            ->join('vehicles AS v', 'q_v.vehicle_id', '=', 'v.id')
            ->join('vehicle_models AS v_m', 'v_m.id', '=', 'v.vehicle_model_id')
            ->join('brands AS b', 'v_m.brand_id', '=', 'b.id')
            ->select(['b.name AS Marca', 'v_m.name AS Modelo', DB::raw('COUNT(v_m.id) AS Cantidad')])
            ->whereBetween('q.dateTimeGenerated', [$startDate, $endDate])
            ->groupBy(['v_m.id', 'b.name', 'v_m.name'])
            ->orderBy('Cantidad', 'DESC')
            ->get();
        $data = ['title' => 'Vehículos más cotizados', 'reporte' => $queryBuilder];
        $pdf = PDF::loadView('myPDF', $data);
  
        return $pdf->download('vehiculos-mas-cotizados.pdf');
    }
}
