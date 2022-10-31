<?php

namespace Database\Seeders;

use App\Models\Accessory;
use App\Models\Brand;
use App\Models\Vehicle;
use App\Models\VehicleModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $brands = [
        //     'Abarth',
        //     'Alfa Romeo',
        //     'Aston Martin',
        //     'Audi',
        //     'Bentley',
        //     'BMW',
        //     'Cadillac',
        //     'Caterham',
        //     'Chevrolet',
        //     'Citroen',
        //     'Dacia',
        //     'Ferrari',
        //     'Fiat',
        //     'Ford',
        //     'Honda',
        //     'Infiniti',
        //     'Isuzu',
        //     'Iveco',
        //     'Jaguar',
        //     'Jeep',
        //     'Kia',
        //     'KTM',
        //     'Lada',
        //     'Lamborghini',
        //     'Lancia',
        //     'Land Rover',
        //     'Lexus',
        //     'Lotus',
        //     'Maserati',
        //     'Mazda',
        //     'Mercedes-Benz',
        //     'Mini',
        //     'Mitsubishi',
        //     'Morgan',
        //     'Nissan',
        //     'Opel',
        //     'Peugeot',
        //     'Piaggio',
        //     'Porsche',
        //     'Renault',
        //     'Rolls-Royce',
        //     'Seat',
        //     'Skoda',
        //     'Smart',
        //     'SsangYong',
        //     'Subaru',
        //     'Suzuki',
        //     'Tata',
        //     'Tesla',
        //     'Toyota',
        // ];
        // [
        //     'brand' => '',
        //     'models' => [
        //         '',
        //     ],
        // ],
        $brands = [
            [
                'brand' => 'Alfa Romeo',
                'models' => [
                    '145',
                    'Giulia',
                    'Stelvio',
                    'Tonale',
                ],
            ],
            [
                'brand' => 'Audi',
                'models' => [
                    'A1',
                    'A3',
                    'A4',
                    'A5',
                    'A6',
                    'A7',
                    'e-tron',
                    'Q2',
                    'Q3',
                    'Q5',
                ],
            ],
            [
                'brand' => 'BMW',
                'models' => [
                    'i4',
                    'i7',
                    'iX',
                    'Serie 1',
                    'Serie 2',
                    'Serie 3',
                    'Serie 4',
                    'X1',
                ],
            ],
            [
                'brand' => 'Chevrolet',
                'models' => [
                    'Onix',
                    'Cruze',
                    'Cruze 5',
                    'S10 Z71',
                    'S10 High Country',
                    'S10 Cabina simple',
                    'S10 Cabina doble',
                    'Camaro',
                    'Tracker',
                    'Equinox',
                    'TrailBlazer',
                    'Spin',
                    'Spin Activ',
                ],
            ],
            [
                'brand' => 'Citroen',
                'models' => [
                    'C3',
                    'C4',
                    'C5 Aircross',
                    'Berlingo multispace',
                    'Berlingo Furgón',
                    'Jumper',
                ],
            ],
            [
                'brand' => 'Dacia',
                'models' => [
                    'Duster',
                    'Jogger',
                    'Logan',
                    'Sandero',
                    'Spring',
                ],
            ],
            [
                'brand' => 'Fiat',
                'models' => [
                    'Mobi',
                    'Cronos',
                    'Argo',
                    'Fiorino',
                    'Nueva Strada',
                    '500 Abarth',
                    'Ducato',
                    'Toro',
                    'Pulso',
                    'Strada',
                ],
            ],
            [
                'brand' => 'Ford',
                'models' => [
                    'EcoSport',
                    'Territory',
                    'Bronco Sport',
                    'Kuga Híbrida',
                    'Maverick',
                    'Ranger',
                    'Ranger Raptor',
                    'F-150',
                    'F-150 Raptor',
                    'F-150 Híbrida',
                    'Mustang',
                    'Transit',
                    'Transit Minibus',
                ],
            ],
            [
                'brand' => 'Honda',
                'models' => [
                    'CR-V',
                    'HR-V',
                    'Pilot',
                    'WR-V',
                ],
            ],
            [
                'brand' => 'Jeep',
                'models' => [
                    'Renegade',
                    'Compass',
                    'Wrangler',
                    'Gladiator',
                    'Commander',
                    'Grand Cherokee',
                ],
            ],
            [
                'brand' => 'KIA',
                'models' => [
                    'Rio',
                    'Cerato',
                    'Seltor',
                    'Sportage',
                    'Sorento',
                    'Carnival',
                ],
            ],
            [
                'brand' => 'Land Rover',
                'models' => [
                    'Range Rover',
                    'Range Rover Sport',
                    'Range Rover Velar',
                    'Range Rover Evoque',
                    'Discovery',
                    'Discovery Sport',
                    'Defender',
                ],
            ],
            [
                'brand' => 'Hyundai',
                'models' => [
                    'Creta',
                    'Ioniq',
                    'Kona',
                    'Tucson',
                    'Veloster',
                ],
            ],
            [
                'brand' => 'Mercedes Benz',
                'models' => [
                    'Clase C Sedán',
                ],
            ],
            [
                'brand' => 'Mitsubishi',
                'models' => [
                    'Outlander',
                    'L200',
                ],
            ],
            [
                'brand' => 'Nissan',
                'models' => [
                    'Frontier',
                    'Kicks',
                    'Sentra',
                    'Leaf',
                    'Versa',
                    'X-Trail',
                ],
            ],
            [
                'brand' => 'Peugeot',
                'models' => [
                    '2008',
                    '208',
                    'Partner',
                    'Partner Patagónica',
                    'Boxer Minibus',
                    'Boxer',
                ],
            ],
            [
                'brand' => 'Porsche',
                'models' => [
                    '718 Boxster',
                ],
            ],
            [
                'brand' => 'RAM',
                'models' => [
                    '1500',
                    '2500',
                ],
            ],
            [
                'brand' => 'Renault',
                'models' => [
                    'Laskan',
                    'Captur',
                    'Kangoo',
                    'Duster',
                    'Kangoo Express',
                    'Logan',
                    'Oroch',
                    'Koleos',
                    'Sandero',
                    'Stepway',
                ],
            ],
            [
                'brand' => 'Toyota',
                'models' => [
                    '86',
                    'Camry',
                    'C-HR',
                    'Corolla',
                    'Corolla Cross',
                    'Corolla Hybrid',
                    'Etios Aibo',
                    'Etios Hatchback',
                    'Etios Sedán',
                    'Hilux',
                    'Hilux GR Sport',
                    'Land Cruiser',
                    'Prius',
                    'SW4',
                    'RAV4',
                    'Yaris',
                    'Yaris Sedán',
                ],
            ],
            [
                'brand' => 'Volkswagen',
                'models' => [
                    'Amarok',
                    'Gol Trend',
                    'Gol',
                    'Nivus',
                    'Polo 5P',
                    'Saveiro',
                    'Taos',
                    'T-Cross',
                    'Tiguan',
                    'Vento',
                    'Virtus',
                ],
            ],
        ];
        $accessoriesCount = Accessory::all()->count();
        for ($i = 0; $i < count($brands); $i++) {
            $brand = Brand::create([
                'name' => $brands[$i]['brand'],
            ]);
            foreach ($brands[$i]['models'] as $model) {
                $vehicleModel = VehicleModel::create([
                    'name' => $model,
                    'brand_id' => $brand->id,
                ]);
                $accessories = Accessory::all()->take(rand(1, $accessoriesCount));
                foreach ($accessories as $accessory) {
                    $vehicleModel->accessories()->attach($accessory->id);
                }
            }
        }
    }
}
