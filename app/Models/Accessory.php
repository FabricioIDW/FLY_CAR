<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accessory extends Model
{
    use HasFactory;
    // 1:1
    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }
    // M:M
    public function models()
    {
        return $this->belongsToMany(VehicleModel::class)->withPivot('price');
    }
}
