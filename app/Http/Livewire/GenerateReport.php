<?php

namespace App\Http\Livewire;

use App\Actions\Report;
use App\Exports\ReportExport;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class GenerateReport extends Component
{
    use WithPagination;
    public $report = '';
    public $startDate = '';
    public $endDate = '';
    public $enableBtns = false;

    public function generateReportExcel()
    {
        return (new ReportExport($this->report, $this->startDate, $this->endDate))->download();
    }

    public function generateReportPDF()
    {
        return (new ReportExport($this->report, $this->startDate, $this->endDate))->download($this->report . '_' . $this->startDate . '_' . $this->endDate . '.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }

    public function render()
    {
        $result = [];
        if ($this->report != '' && $this->startDate != '' && $this->endDate != '') {
            $this->enableBtns = true;
            switch ($this->report) {
                case 'vehiculosMasCotizados':
                    $result = Report::vehiculosMasCotizados($this->startDate, $this->endDate);
                    break;
                case 'accesoriosMasSolicitados':
                    $result = Report::accesoriosMasSolicitados($this->startDate, $this->endDate);
                    break;
                case 'comisionesMensuales':
                    $result = Report::comisionesMensuales($this->startDate, $this->endDate);
                    break;
                case 'modelosMasVendidos':
                    $result = Report::modelosMasVendidos($this->startDate, $this->endDate);
                    break;
                case 'ventasNoConcretadas':
                    $result = Report::ventasNoConcretadas($this->startDate, $this->endDate);
                    break;
                default:
                    $result = [];
                    break;
            }
        }
        return view('livewire.generate-report', compact('result'));
    }
}
