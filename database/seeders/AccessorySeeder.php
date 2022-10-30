<?php

namespace Database\Seeders;

use App\Models\Accessory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccessorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $accessoriesData = [
            [
                'name' => 'Vidrio polarizado',
                'description' => 'Polarizado al 65%',
            ],
            [
                'name' => 'Alerón trasero',
                'description' => '',
            ],
            [
                'name' => 'Porta equipaje',
                'description' => '',
            ],
            [
                'name' => 'Perilla de cambio de cuero',
                'description' => '',
            ],
            [
                'name' => 'Tapizado para volante',
                'description' => 'Tapizado de cuero',
            ],
            [
                'name' => 'Cubre alfombra',
                'description' => 'Para todos los asientos',
            ],
            [
                'name' => 'Tapizado de cuero',
                'description' => 'Cuerina 75%',
            ],
        ];
        $accessories = Accessory::factory(count($accessoriesData))->create();
        $i = 0;
        foreach ($accessories as $accessory) {
            $accessory->update([
                'name' => $accessoriesData[$i]['name'],
                'description' => $accessoriesData[$i]['description'],
            ]);
            $i++;
        }
    }
}
