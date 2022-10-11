<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;
    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }
    public function vehicleModel()
    {
        return $this->belongsTo(VehicleModel::class);
    }
}
