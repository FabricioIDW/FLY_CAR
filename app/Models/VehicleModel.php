<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleModel extends Model
{
    use HasFactory;
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function accessories()
    {
        return $this->belongsToMany(Accessory::class)->withPivot('price');
    }
    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
}
