<?php

namespace Database\Seeders;

use App\Models\Accessory;
use App\Models\VehicleModel;
use Faker as FakerFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $models = VehicleModel::factory(5)->create();
        foreach ($models as $model) {
            $count = Accessory::all()->count();
            $rand1 = rand(1, $count);
            $rand2 = rand(1, $count);
            if ($rand1 == $rand2) {
                $rand2 = rand(1, $count);
            }
            $model->accessories()->attach([$rand1, $rand2]);
        }
    }
}
