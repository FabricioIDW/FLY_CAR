<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;
    protected $guarded = [];
    // RELACIONES
    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }
    public function vehicleModel()
    {
        return $this->belongsTo(VehicleModel::class);
    }
    public function accessoriesQuotation()
    {
        // M:M
        return $this->belongsToMany(Accessory::class, 'accessory_quotation_vehicle', 'vehicle_id', 'accessory_id')->withPivot('quotation_id');
    }

    // FUNCIONES
    public function getPrice()
    {
        $offer = $this->offer;
        if ($offer) {
            return Discount::calculateDiscount($this->price, $offer->discount);
        }
        return $this->price;
    }
    public function setState($state)
    {
        $this->vehicleState = $state;
        $this->save();
    }
    public static function getPriceEnd(Array $vehiculos)
    {
        $priceEnd = 0;
        foreach ($vehiculos as $vehiculo) {
         
                $priceEnd = $priceEnd + $vehiculo->getPrice();

            }
        
        return $priceEnd;
    }
}
