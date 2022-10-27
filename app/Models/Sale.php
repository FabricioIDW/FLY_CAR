<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    protected $guarded = [];
    // RELACIONES
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }
    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }
    // FUNCIONES
    public static function calculateComission($amount)
    {
        return (10 * $amount) / 100;
    }
}
