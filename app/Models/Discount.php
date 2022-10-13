<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;
    public static function calculateDiscount($amount, $discount)
    {
        return $amount - (($discount / 100) * $amount);
    }
}
