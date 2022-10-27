<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePayment;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($action, $amount)
    {
        // Action = De donde se llama el pago (reserve o sale).
        session(['action' => $action]);
        return view('payments.index', compact('amount'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->accepted) {
            $payment = Payment::create([
                'amount' => $request->amount,
            ]);
            session(['payment' => $payment]);
            if (session('action') == 'reserve') {
                return redirect()->route('reserves.create');
            }
            if (session('action') == 'sale') {
                return redirect()->route('sales.create', ['concretized' => 1]);
            }
        }
    }
}
