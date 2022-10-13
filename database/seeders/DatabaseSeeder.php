<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Accessory;
use App\Models\Brand;
use App\Models\Customer;
use App\Models\Offer;
use App\Models\Seller;
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
        $this->call(UserTypeSeeder::class);
        User::factory(30)->create();
        Customer::factory(25)->create();
        Seller::factory(5)->create();
        Offer::factory(10)->create();
        Brand::factory(5)->create();
        Accessory::factory(25)->create();
        $this->call(VehicleModelSeeder::class);
        Vehicle::factory(30)->create();
        $this->call(QuotationSeeder::class);
        $this->call(ReserveSeeder::class);
        $this->call(SaleSeeder::class);
    }
}
