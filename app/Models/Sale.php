<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }
    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }
}
