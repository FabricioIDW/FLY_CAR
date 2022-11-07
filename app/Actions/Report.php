<?php

namespace App\Actions;

use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class Report
{
    public static function vehiculosMasCotizados($startDate, $endDate)
    {
        return DB::table('quotation_vehicle AS q_v')
            ->join('quotations AS q', 'q_v.quotation_id', '=', 'q.id')
            ->join('vehicles AS v', 'q_v.vehicle_id', '=', 'v.id')
            ->join('vehicle_models AS v_m', 'v_m.id', '=', 'v.vehicle_model_id')
            ->join('brands AS b', 'v_m.brand_id', '=', 'b.id')
            ->select(['b.name AS Marca', 'v_m.name AS Modelo', DB::raw('COUNT(v_m.id) AS Cantidad')])
            ->whereBetween(DB::raw('DATE(q.dateTimeGenerated)'), [$startDate, $endDate])
            ->groupBy(['v_m.id', 'b.name', 'v_m.name'])
            ->orderBy('Cantidad', 'DESC')
            ->get();
    }

    public static function accesoriosMasSolicitados($startDate, $endDate)
    {
        return DB::table('accessory_quotation_vehicle AS a_q_v')
            ->join('quotations AS q', 'a_q_v.quotation_id', '=', 'q.id')
            ->join('accessories AS a', 'a_q_v.accessory_id', '=', 'a.id')
            ->select(['a.name AS Accesorio', DB::raw('COUNT(a.id) AS Cantidad')])
            ->whereBetween(DB::raw('DATE(q.dateTimeGenerated)'), [$startDate, $endDate])
            ->groupBy(['a.name'])
            ->orderBy('Cantidad', 'DESC')
            ->get();
    }

    public static function comisionesMensuales($startDate, $endDate)
    {
        return DB::table('sales AS s')
            ->join('sellers AS sl', 's.seller_id', '=', 'sl.id')
            ->select([DB::raw("CONCAT(sl.name, ' ', sl.lastName) AS Vendedor"), 'sl.dni', DB::raw('SUM(s.comission) AS Comision'), DB::raw('COUNT(*) AS Ventas')])
            ->whereBetween(DB::raw('DATE(s.dateTimeGenerated)'), [$startDate, $endDate])
            ->where('s.concretized', '=', '1')
            ->groupBy(['sl.id', 'Vendedor', 'sl.dni'])
            ->orderBy('Comision', 'DESC')
            ->get();
    }

    public static function modelosMasVendidos($startDate, $endDate)
    {
        return DB::table('sales AS s')
            ->join('quotation_vehicle AS q_v', 'q_v.quotation_id', '=', 's.quotation_id')
            ->join('vehicles AS v', 'q_v.vehicle_id', '=', 'v.id')
            ->join('vehicle_models AS v_m', 'v_m.id', '=', 'v.vehicle_model_id')
            ->join('brands AS b', 'v_m.brand_id', '=', 'b.id')
            ->select(['b.name AS Marca', 'v_m.name AS Modelo', DB::raw('COUNT(v_m.id) AS Cantidad')])
            ->whereBetween(DB::raw('DATE(s.dateTimeGenerated)'), [$startDate, $endDate])
            ->groupBy(['v_m.id', 'b.name', 'v_m.name'])
            ->orderBy('Cantidad', 'DESC')
            ->get();
    }

    public static function ventasNoConcretadas($startDate, $endDate)
    {
        return DB::table('sales AS s')
            ->join('sellers AS sl', 's.seller_id', '=', 'sl.id')
            ->join('quotations AS q', 's.quotation_id', '=', 'q.id')
            ->select(['s.id AS Venta', 's.dateTimeGenerated AS Fecha', DB::raw("CONCAT(sl.name, ' ', sl.lastName) AS Vendedor"), 'sl.dni AS DNI', 's.comission AS Comisión', 'q.id AS Cotización', 'q.finalAmount AS Importe'])
            ->where('s.concretized', '=', '0')
            ->whereBetween(DB::raw('DATE(s.dateTimeGenerated)'), [$startDate, $endDate])
            ->orderBy('s.id', 'DESC')
            ->get();
    }
}
