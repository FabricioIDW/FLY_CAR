<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Vehicle extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $fillable = ['url'];
    // RELACIONES
    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }
    public function vehicleModel()
    {
        return $this->belongsTo(VehicleModel::class);
    }
    public function accessoriesQuotation()
    {
        // M:M
        return $this->belongsToMany(Accessory::class, 'accessory_quotation_vehicle', 'vehicle_id', 'accessory_id')->withPivot('quotation_id');
    }

    // FUNCIONES
    public function getAccessoriesFromQuotation($quotation_id)
    {
        $result = DB::table('accessory_quotation_vehicle AS a_q_v')
            ->join('accessories AS a', 'a_q_v.accessory_id', '=', 'a.id')
            ->select(['a.id', 'a.name'])
            ->where('a_q_v.quotation_id', $quotation_id)
            ->where('a_q_v.vehicle_id', $this->id)
            ->get();
        $accessories = [];
        foreach ($result as $accessory) {
            $price = DB::table('accessory_vehicle_model AS a_v')->select('a_v.price')->where('a_v.accessory_id', $accessory->id)->where('a_v.vehicle_model_id', $this->vehicle_model_id)->first();
            $accessories[] = ['name' => $accessory->name, 'price' => Accessory::find($accessory->id)->getPrice($price->price)];
        }
        return $accessories;
    }
    public function getPrice()
    {
        $offer = $this->offer;
        if ($offer) {
            return Discount::calculateDiscount($this->price, $offer->discount);
        }
        return $this->price;
    }
    public function setState($state)
    {
        $this->vehicleState = $state;
        $this->save();
    }
    public static function getPriceEnd(array $vehiculos)
    {
        $priceEnd = 0;
        foreach ($vehiculos as $vehiculo) {

            $priceEnd = $priceEnd + $vehiculo->getPrice();
        }

        return $priceEnd;
    }
}
