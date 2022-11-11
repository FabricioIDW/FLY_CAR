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
                'Nro. Venta',
                'Cliente',
                'Fecha generada',
                'DNI vendedor',
                'Nro. Pago',
                'Importe',
            ],
        ];
    }
    public function map($sale): array
    {
        $accessoriesData = [];
        $accessoriesPrices = [];
        foreach ($sale->quotation->vehicles as $vehicle) {
            $accessories = $vehicle->getAccessoriesFromQuotation($sale->quotation->id);
            $data = '';
            $accessoriesPrice = 0;
            if (count($accessories) > 0) {
                foreach ($accessories as $accessory) {
                    $data .= $accessory['name'] . ', ';
                    $accessoriesPrice += $accessory['price'];
                }
                $accessoriesPrices[] = $accessoriesPrice;
                $accessoriesData[] = $data;
            } else {
                $accessoriesData[] = 'No posee';
                $accessoriesPrices[] = 0;
            }
        }
        if (count($sale->quotation->vehicles) > 1) {
            return  [
                [
                    $sale->id,
                    $sale->quotation->customer->dni,
                    $sale->dateTimeGenerated,
                    $sale->seller->dni,
                    $sale->payment->id,
                    number_format($sale->quotation->finalAmount, 2, ',', '.'),
                ],
                [
                    'Marca',
                    'Modelo',
                    'Año',
                    'Precio',
                    'Accesorios',
                    'Precio total accesorios',
                ],
                [
                    $sale->quotation->vehicles[0]->vehicleModel->brand->name,
                    $sale->quotation->vehicles[0]->vehicleModel->name,
                    $sale->quotation->vehicles[0]->year,
                    number_format($sale->quotation->vehicles[0]->getPrice(), 2, ',', '.'),
                    $accessoriesData[0],
                    number_format($accessoriesPrices[0], 2, ',', '.'),
                ],
                [
                    $sale->quotation->vehicles[1]->vehicleModel->brand->name,
                    $sale->quotation->vehicles[1]->vehicleModel->name,
                    $sale->quotation->vehicles[1]->year,
                    number_format($sale->quotation->vehicles[1]->getPrice(), 2, ',', '.'),
                    $accessoriesData[1],
                    number_format($accessoriesPrices[1], 2, ',', '.'),
                ],
            ];
        } else {
            return
                [
                    [
                        $sale->id,
                        $sale->quotation->customer->dni,
                        $sale->dateTimeGenerated,
                        $sale->seller->dni,
                        $sale->payment->id,
                        number_format($sale->quotation->finalAmount, 2, ',', '.'),
                    ],
                    [
                        'Marca',
                        'Modelo',
                        'Año',
                        'Precio',
                        'Accesorios',
                        'Precio total accesorios',
                    ],
                    [
                        $sale->quotation->vehicles[0]->vehicleModel->brand->name,
                        $sale->quotation->vehicles[0]->vehicleModel->name,
                        $sale->quotation->vehicles[0]->year,
                        number_format($sale->quotation->vehicles[0]->getPrice(), 2, ',', '.'),
                        $accessoriesData[0],
                        number_format($accessoriesPrices[0], 2, ',', '.'),
                    ]
                ];
        }
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
        $sheet->getStyle('A12:' . $sheet->getHighestColumn() . '12')->applyFromArray([
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
        $sheet->getStyle('B1')->applyFromArray([]);
    }
}
