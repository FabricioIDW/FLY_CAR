<?php

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\Quotation;
use App\Models\Sale;
use App\Models\Seller;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cant = 5;
        $quotations = Quotation::where('valid', 1)->limit($cant)->get();
        foreach ($quotations as $quotation) {
            $sale = Sale::create();
            // obtengo un vendedor random
            $seller_id = Seller::all()->random()->id;
            // calculo monto de la venta
            $amount = $quotation->finalAmount;
            if ($quotation->reserve && $quotation->reserve->reserveState == 'enabled') {
                $amount = $quotation->actualizeAmount($quotation->reserve->amount);
            }
            // creo un pago
            $payment = Payment::create();
            $payment->amount = $amount;
            $payment->save();
            // calculo comision
            $sale->comission = $sale->calculateComission($amount);
            // guardo datos (payment_id, quotation_id, seller_id)
            $sale->payment_id = $payment->id;
            $sale->quotation_id = $quotation->id;
            $sale->seller_id = $seller_id;
            $sale->save();
            $quotation->setVehiclesSold('sold');
            $quotation->setValid(0);
        }
    }
}

/*
cotizacion = 1
reserva = 410491.37 (5%)
venta = 779933.61 (comission)
cotizacion = 7799336.10 (finalAmount)
cotizacion sin reserva = 8209827,47
*/