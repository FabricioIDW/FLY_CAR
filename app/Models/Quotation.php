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
        return $this->belongsToMany(Vehicle::class);
    }
    public function customer()
    {
        // 1:1 
        return $this->belongsTo(Customer::class);
    }
    public function reserve()
    {
        return $this->hasOne(Reserve::class);
    }
    // FUNCIONES
    public function updateTimes($current)
    {
        $this->dateTimeGenerated = $current;
        $this->dateTimeExpiration = ExpirationDate::getExpiration($current, 7);
        $this->save();
    }
    public function actualizeAmount($reserveAmount)
    {
        $this->finalAmount -= $reserveAmount;
        $this->save();
        return $this->finalAmount;
    }
    public function setVehiclesSold()
    {
        $vehicles = $this->vehicles;
        foreach ($vehicles as $vehicle) {
            $vehicle->setState('sold');
        }
    }
    public function setValid($valor)
    {
        $this->valid = $valor;
        $this->save();
    }
}
