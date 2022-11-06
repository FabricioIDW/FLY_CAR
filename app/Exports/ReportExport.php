<?php

namespace App\Exports;

use App\Actions\Report;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportExport implements FromCollection, WithCustomStartCell, WithHeadings, WithDrawings, WithStyles, ShouldAutoSize
{
    use Exportable;

    private $fileName = 'reporte.xlsx';

    private $writerType = Excel::XLSX;

    private $report;

    private $startDate;

    private $endDate;

    private $header = [];

    public function __construct($report, $startDate, $endDate)
    {
        $this->report = $report;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->fileName = $report . '_' . $startDate . '_' . $endDate . '.xlsx';
    }

    public function collection()
    {
        $result = [];
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
        foreach ($result[0] as $key => $value) {
            array_push($this->header, $key);
        }
        return $result;
    }

    public function startCell(): string
    {
        return 'A10';
    }
    public function headings(): array
    {
        $headers = [];
        foreach ($this->collection()[0] as $key => $value) {
            $headers[] = $key;
        }
        return $headers;
    }
    public function drawings()
    {
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('FLY CAR');
        $drawing->setDescription('FLY CAR LOGO');
        $drawing->setPath(public_path('FLY_CAR_LOGO3.png'));
        $drawing->setHeight(170);
        $drawing->setCoordinates('A1');
        return $drawing;
    }
    public function styles(Worksheet $sheet)
    {
        $sheet->setTitle('Reporte');
        $sheet->mergeCells('A1:A9');
        $sheet->getStyle('A10:' . $sheet->getHighestColumn() . '10')->applyFromArray([
            'font' => [
                'bold' => true,
                'name' => 'Arial',
            ],
            'alignment' => [
                'horizontal' => 'center',
            ],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => [
                    'argb' => 'C5D9F1',
                ],
            ]
        ]);
        $sheet->getStyle('A10:' . $sheet->getHighestColumn() . '' . $sheet->getHighestRow())->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => 'thin',
                ],
            ],
        ]);
        $sheet->getStyle('B1')->applyFromArray([]);
    }
}
