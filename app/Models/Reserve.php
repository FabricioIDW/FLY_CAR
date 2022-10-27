<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserve extends Model
{
    use HasFactory;
    // RELACIONES
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }
    // FUNCIONES
    public function calculateAmount($price)
    {
        return (5 * $price) / 100;
    }
    public function setState($state)
    {
        $this->reserveState = $state;
        $this->save();
    }
}
