<?php

namespace App\Exports;

use App\Models\Quotation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class QuotationExport implements

    FromCollection,
    Responsable,
    WithCustomStartCell,
    WithHeadings,
    WithDrawings,
    WithStyles,
    ShouldAutoSize,
    WithMapping
{
    use Exportable;

    private $fileName = 'quotation.xlsx';

    private $writerType = Excel::XLSX;
    public $quotation_id;
    public function __construct($quotation_id)
    {
        $this->quotation_id = $quotation_id;
    }

    public function collection()
    {
        return Quotation::where('id', $this->quotation_id)->first();
    }
    public function startCell(): string
    {
        return 'A10';
    }
    public function headings(): array
    {
        return [
            'Nro',
            'Cliente',
            'Fecha generada',
            'Fecha vencimiento',
            // 'Vehiculos',
            'Importe',
        ];
    }
    public function map($quotation): array
    {
        return [
            $quotation->id,
            $quotation->customer->name . ' ' . $quotation->customer->lastName,
            $quotation->dateTimeGenerated,
            $quotation->dateTimeExpiration,
            // $quotation->,
            $quotation->finalAmount,
            // Date::dateTimeToExcel($quotation->created_at),
        ];
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
