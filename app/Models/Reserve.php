<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserve extends Model
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
}