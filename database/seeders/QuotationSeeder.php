<?php

namespace Database\Seeders;

use App\Models\Accessory;
use App\Models\Customer;
use App\Models\ExpirationDate;
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
        $cant = 10;
        // Crea cotizaciones, a cada una le asigna 1 vehiculo y 1 accesorio para el mismo.
        for ($i = 1; $i <= $cant; $i++) {
            $quotation = Quotation::create();
            $quotation = Quotation::find($quotation->id);
            $vehicle = Vehicle::where('vehicleState', '=', 'availabled')->first();
            $vehicle->setState('reserved');
            $finalAmount = $vehicle->getPrice();
            // Si el modelo del vehiculo tiene accessorios en stock (Solo comprueba el primero ya que es de prueba)
            $hasAccessory = false;
            if (count($vehicle->vehicleModel->accessories) > 0 && $vehicle->vehicleModel->accessories[0]->stock >= 0) {
                $hasAccessory = true;
                $accessory = $vehicle->vehicleModel->accessories[0];
                $accessory->discountStock();
                $finalAmount += $accessory->getPrice($vehicle->vehicleModel->accessories[0]->pivot->price);
            }
            $quotation->finalAmount = $finalAmount;
            $quotation->dateTimeExpiration = ExpirationDate::getExpiration($quotation->dateTimeGenerated, 2);
            // Obtiene un cliente random y chequea si tiene cotizacion valida
            $customer = Customer::all()->random();
            $quotation->customer_id = $customer->id;
            if ($customer->hasValidQuotation()) {
                $customer->disableQuotation();
            }
            $quotation->save();
            // Guarda los datos de las relaciones M:M
            $quotation->vehicles()->attach($vehicle->id);
            if ($hasAccessory) {
                $vehicle->accessoriesQuotation()->attach($accessory->id, ['quotation_id' => $quotation->id]);
            }
        }
    }
}
