<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;
    public function accessories()
    {
        return $this->hasMany(Accessory::class);
    }
    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
}
