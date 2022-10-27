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
    public function setVehicles($state)
    {
        foreach ($this->vehicles as $vehicle) {
            $vehicle->setState($state);
        }
    }
    public function setValid($valor)
    {
        $this->valid = $valor;
        $this->save();
    }
    public function checkVehiclesState() 
    {
        foreach ($this->vehicles as $vehicle) {
            if (!$vehicle->enabled) {
                return false;
            }
        }
        return true;
    }
}
