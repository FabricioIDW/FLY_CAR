<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;
    // RELATIONS
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
        return $this->belongsToMany(Accessory::class, 'accessory_quotation_vehicle');
    }

    // FUNCTIONS
    public function getPrice()
    {
        $offer = $this->offer;
        if ($offer) {
            return $this->price - (($offer->discount / 100) * $this->price);
        }
        return $this->price;
    }
    public function setReserved()
    {
        $this->vehicleState = 'reserved';
        $this->save();
    }
}
