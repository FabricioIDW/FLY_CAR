<?php

namespace App\Exports;

use App\Models\sale;
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

class SaleExport implements

    FromCollection,
    WithCustomStartCell,
    WithHeadings,
    WithDrawings,
    WithStyles,
    ShouldAutoSize,
    WithMapping
{
    use Exportable;

    private $fileName = 'venta.xlsx';

    private $writerType = Excel::XLSX;
    public $sale;
    public function __construct($sale)
    {
        $this->sale = $sale;
    }

    public function collection()
    {
        return $this->sale;
    }
    public function startCell(): string
    {
        return 'A10';
    }
    public function headings(): array
    {
        return [
            [
                'Nro',
                'Cliente',
                'Fecha generada',
                'Importe',
                'Vendedor',
                'Pago',
            ],
        ];
    }
    public function map($sale): array
    {
        return [
            [
                $sale->id,
                $sale->quotation->customer->name . ' ' . $sale->quotation->customer->lastName,
                $sale->dateTimeGenerated,
                number_format($sale->quotation->finalAmount, 2, ',', '.'),
                $sale->seller->name . ' ' . $sale->seller->lastName,
                $sale->payment->id,
            ],
        ];
    }
    public function drawings()
    {
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('FLY CAR');
        $drawing->setDescription('FLY CAR LOGO');
        $drawing->setPath(public_path('FLY_CAR_LOGO3.png'));
        $drawing->setHeight(170);
        $drawing->setCoordinates('D1');
        return $drawing;
    }
    public function styles(Worksheet $sheet)
    {
        $sheet->setTitle('Reporte');
        $sheet->mergeCells('D1:D9');
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
        // $sheet->getStyle('A12:' . $sheet->getHighestColumn() . '12')->applyFromArray([
        //     'font' => [
        //         'bold' => true,
        //         'name' => 'Arial',
        //     ],
        //     'alignment' => [
        //         'horizontal' => 'center',
        //     ],
        //     'fill' => [
        //         'fillType' => 'solid',
        //         'startColor' => [
        //             'argb' => 'C5D9F1',
        //         ],
        //     ]
        // ]);
        $sheet->getStyle('B1')->applyFromArray([]);
    }
}
