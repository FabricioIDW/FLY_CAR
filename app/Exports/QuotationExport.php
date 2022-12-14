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
    public $quotation;
    public function __construct($quotation)
    {
        $this->quotation = $quotation;
    }

    public function collection()
    {
        return $this->quotation;
    }
    public function startCell(): string
    {
        return 'A10';
    }
    public function headings(): array
    {
        // if ($this->quotation[0]->reserve) {
        //     # code...
        // }
        return [
            [
                'Nro',
                'Cliente',
                'Fecha generada',
                'Fecha vencimiento',
                'Importe',
                'Reserva',
                'Seña pagada',
            ],
        ];
    }
    public function map($quotation): array
    {
        $reserva = 'No';
        $importeReserva = 'No aplica';
        if ($quotation->reserve) {
            $reserva = 'Si';
            $importeReserva = number_format($quotation->reserve->amount, 2, ',', '.');
        }
        $accessoriesData = [];
        $accessoriesPrices = [];
        foreach ($quotation->vehicles as $vehicle) {
            $accessories = $vehicle->getAccessoriesFromQuotation($quotation->id);
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
        if (count($quotation->vehicles) > 1) {
            return [
                [
                    $quotation->id,
                    $quotation->customer->name . ' ' . $quotation->customer->lastName,
                    $quotation->dateTimeGenerated,
                    $quotation->dateTimeExpiration,
                    number_format($quotation->finalAmount, 2, ',', '.'),
                    $reserva,
                    $importeReserva,
                ],
                [
                    'Marca',
                    'Modelo',
                    'Año',
                    'Precio',
                    'Accesorios',
                    'Precio total accesorios'
                ],
                [
                    $quotation->vehicles[0]->vehicleModel->brand->name,
                    $quotation->vehicles[0]->vehicleModel->name,
                    $quotation->vehicles[0]->year,
                    number_format($quotation->vehicles[0]->getPrice(), 2, ',', '.'),
                    $accessoriesData[0],
                    number_format($accessoriesPrices[0], 2, ',', '.'),
                ],
                [
                    $quotation->vehicles[1]->vehicleModel->brand->name,
                    $quotation->vehicles[1]->vehicleModel->name,
                    $quotation->vehicles[1]->year,
                    number_format($quotation->vehicles[1]->getPrice(), 2, ',', '.'),
                    $accessoriesData[1],
                    number_format($accessoriesPrices[1], 2, ',', '.'),
                ],
            ];
        }
        return [
            [
                $quotation->id,
                $quotation->customer->name . ' ' . $quotation->customer->lastName,
                $quotation->dateTimeGenerated,
                $quotation->dateTimeExpiration,
                number_format($quotation->finalAmount, 2, ',', '.'),
                $reserva,
                $importeReserva,
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
                $quotation->vehicles[0]->vehicleModel->brand->name,
                $quotation->vehicles[0]->vehicleModel->name,
                $quotation->vehicles[0]->year,
                number_format($quotation->vehicles[0]->getPrice(), 2, ',', '.'),
                $accessoriesData[0],
                number_format($accessoriesPrices[0], 2, ',', '.'),
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
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A3);
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
