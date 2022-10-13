<?php

namespace Database\Seeders;

use App\Models\ExpirationDate;
use App\Models\Payment;
use App\Models\Quotation;
use App\Models\Reserve;
use DateInterval;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Nette\Utils\DateTime;

class ReserveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cant = 2;
        $reserves = Reserve::factory($cant)->create();
        $quotations = Quotation::take($cant)->get();
        for ($i = 0; $i < $cant; $i++) {
            $reserve = $reserves[$i];
            $quotation = $quotations[$i];
            $reserve->amount = $reserve->calculateAmount($quotation->finalAmount);
            $payment = Payment::create();
            $payment->amount = $reserve->amount;
            $payment->save();
            $reserve->quotation_id = $quotation->id;
            $reserve->payment_id = $payment->id;
            $reserve->dateTimeExpiration = ExpirationDate::getExpiration($reserve->dateTimeGenerated, 7);
            $quotation->updateTimes($reserve->dateTimeGenerated);
            $reserve->save();
        }
    }
}
