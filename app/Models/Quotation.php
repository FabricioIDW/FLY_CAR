<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;
    public function vehicles()
    {
        // M:M
        return $this->hasMany(Vehicle::class);
    }
    public function customer()
    {
        // 1:1 
    return $this->belongsTo(Customer::class);
    }
    public function vehicleAccessories()
    {
        // M:M
        
    }
}