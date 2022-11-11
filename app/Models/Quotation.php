<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;
    protected $guarded = [];
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
        // $this->dateTimeGenerated = $current;
        $this->dateTimeExpiration = ExpirationDate::getExpiration($current, 7);
        $this->save();
    }
    public function setExpiration()
    {
        $this->dateTimeExpiration = ExpirationDate::getExpiration($this->dateTimeGenerated, 2);
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
    public function changeProductsState(Quotation $quotation)
    {
        $vehiculos = $quotation->vehicles;
        foreach ($vehiculos as $vehiculo) {
            $colecAccesorios = [];
            if ($vehiculo->getAccessoriesFromQuotation($quotation->id)) {
                $colecAccesorios = $vehiculo->getAccessoriesFromQuotation($quotation->id);
                foreach ($colecAccesorios as $unAccesorio) {
                    $acc = Accessory::find($unAccesorio["id"]);
                    $acc->addStock();
                    $acc->save();
                }
            }
            $vehiculo->vehicleState = 'availabled';
            $vehiculo->save();
        }

        if ($quotation->reserve) {
            $quotation->reserve->reserveState = 'disabled';
            $quotation->reserve->save();
        }

        return $quotation;
    }
}
