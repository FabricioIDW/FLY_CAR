<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Quotation;
use App\Models\Vehicle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuotationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $quotations = Quotation::factory(5)->create();
        for ($i = 1; $i <= 5; $i++) {
            $vehicle = Vehicle::where('vehicleState', '=', 'availabled')->first();
            $quotation = new Quotation();
            $quotation->id = $i; 
            $quotation->finalAmount = $vehicle->getPrice();
            $quotation->customer_id = Customer::all()->random()->id;
            $quotation->save();
            $vehicle->vehicleState = 'reserved';
            $vehicle->save();
            $quotation->vehicles()->attach($vehicle->id);
        }
    }
}
