<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    public function reserve()
    {
        return $this->belongsTo(Reserve::class);
    }
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
