<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accessory extends Model
{
    use HasFactory;
    // RELATIONS
    public function offer()
    {
        // 1:1
        return $this->belongsTo(Offer::class);
    }
    public function models()
    {
        // M:M
        return $this->belongsToMany(VehicleModel::class)->withPivot('price');
    }
    // FUNCTIONS
    // public function getPrice($model_id)
    // {
    //     $price = VehicleModel::where
    //     $offer = $this->offer;
    //     if ($offer) {
    //         return $this->price - (($offer->discount / 100) * $this->price);
    //     }
    //     return $this->price;
    // }
    public function discountStock()
    {
        if ($this->stock >= 1) {
            $this->stock = $this->stock - 1;
            $this->save();
            if ($this->stock == 0) {
                $this->setEnabled(false);
            }
            return true;
        }
        return false;
    }
    public function setEnabled($valor)
    {
        $this->enabled = $valor;
        $this->save();
    }
}
