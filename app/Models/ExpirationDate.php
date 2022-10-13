<?php

namespace App\Models;

use DateInterval;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpirationDate extends Model
{
    use HasFactory;
    public static function getExpiration($generated, $days)
    {
        $expires = new DateTime($generated);
        $expires->add(new DateInterval('P' . $days . 'D'));
        return $expires;
    }
}
