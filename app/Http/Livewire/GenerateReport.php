<?php

namespace App\Http\Livewire;

use App\Models\Report;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class GenerateReport extends Component
{
    use WithPagination;
    public $report = '';
    public $startDate = '';
    public $endDate = '';
    public function render()
    {
        $result = [];
        if ($this->report != '' && $this->startDate != '' && $this->endDate != '') {
            switch ($this->report) {
                case 'vehiculosMasCotizados':
                    $result = $this->vehiculosMasCotizados();
                    break;
                case 'accesoriosMasSolicitados':
                    $result = $this->accesoriosMasSolicitados();
                    break;
                case 'comisionesMensuales':
                    $result = $this->comisionesMensuales();
                    break;
                case 'modelosMasVendidos':
                    $result = $this->modelosMasVendidos();
                    break;
                default:
                    $result = [];
                    break;
            }
        }
        return view('livewire.generate-report', compact('result'));
    }

    public function vehiculosMasCotizados()
    {
        return DB::table('quotation_vehicle AS q_v')
            ->join('quotations AS q', 'q_v.quotation_id', '=', 'q.id')
            ->join('vehicles AS v', 'q_v.vehicle_id', '=', 'v.id')
            ->join('vehicle_models AS v_m', 'v_m.id', '=', 'v.vehicle_model_id')
            ->join('brands AS b', 'v_m.brand_id', '=', 'b.id')
            ->select(['b.name AS Marca', 'v_m.name AS Modelo', DB::raw('COUNT(v_m.id) AS Cantidad')])
            ->whereBetween(DB::raw('DATE(q.dateTimeGenerated)'), [$this->startDate, $this->endDate])
            ->groupBy(['v_m.id', 'b.name', 'v_m.name'])
            ->orderBy('Cantidad', 'DESC')
            ->get();
    }

    public function accesoriosMasSolicitados()
    {
        return DB::table('accessory_quotation_vehicle AS a_q_v')
            ->join('quotations AS q', 'a_q_v.quotation_id', '=', 'q.id')
            ->join('accessories AS a', 'a_q_v.accessory_id', '=', 'a.id')
            ->select(['a.name AS Accesorio', DB::raw('COUNT(a.id) AS Cantidad')])
            ->whereBetween(DB::raw('DATE(q.dateTimeGenerated)'), [$this->startDate, $this->endDate])
            ->groupBy(['a.name'])
            ->orderBy('Cantidad', 'DESC')
            ->get();
    }

    public function comisionesMensuales()
    {
        return DB::table('sales AS s')
            ->join('sellers AS sl', 's.seller_id', '=', 'sl.id')
            ->select([DB::raw("CONCAT(sl.name, ' ', sl.lastName) AS Vendedor"), 'sl.dni', DB::raw('SUM(s.comission) AS Comision'), DB::raw('COUNT(*) AS Ventas')])
            ->whereBetween(DB::raw('DATE(s.dateTimeGenerated)'), [$this->startDate, $this->endDate])
            ->where('s.concretized', '=', '1')
            ->groupBy(['sl.id', 'Vendedor', 'sl.dni'])
            ->orderBy('Comision', 'DESC')
            ->get();
    }

    public function modelosMasVendidos()
    {
        return DB::table('sales AS s')
            ->join('quotation_vehicle AS q_v', 'q_v.quotation_id', '=', 's.quotation_id')
            ->join('vehicles AS v', 'q_v.vehicle_id', '=', 'v.id')
            ->join('vehicle_models AS v_m', 'v_m.id', '=', 'v.vehicle_model_id')
            ->join('brands AS b', 'v_m.brand_id', '=', 'b.id')
            ->select(['b.name AS Marca', 'v_m.name AS Modelo', DB::raw('COUNT(v_m.id) AS Cantidad')])
            ->whereBetween(DB::raw('DATE(s.dateTimeGenerated)'), [$this->startDate, $this->endDate])
            ->groupBy(['v_m.id', 'b.name', 'v_m.name'])
            ->orderBy('Cantidad', 'DESC')
            ->get();
    }
}
