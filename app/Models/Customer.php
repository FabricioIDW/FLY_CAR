<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $guarded = [];
    // RELACIONES
    public function quotations()
    {
        return $this->hasMany(Quotation::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // FUNCIONES
    public function hasValidQuotation()
    {
        return Quotation::where('customer_id', $this->id)->where('valid', 1)->first() != null;
    }
    public function disableQuotation()
    {
        $quotation = Quotation::where('customer_id', $this->id)->where('valid', 1)->first();
        if ($quotation) {
            $quotation->valid = 0;
            $quotation->save();
            return true;
        }
        return false;
    }
}
