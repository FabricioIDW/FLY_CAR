<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Accessory;
use App\Models\Brand;
use App\Models\Customer;
use App\Models\Offer;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehicleModel;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        Offer::factory(10)->create();
        Accessory::factory(25)->create();
        $this->call(UserTypeSeeder::class);
        User::factory(25)->create();
        Customer::factory(25)->create();
        Brand::factory(5)->create();
        $this->call(VehicleModelSeeder::class);
        Vehicle::factory(5)->create();
    }
}
