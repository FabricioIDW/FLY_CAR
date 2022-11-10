<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePayment;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:payments.index')->only('index');
        $this->middleware('can:payments.store')->only('store');
    }
    public function index($action, $amount)
    {
        // Action = De donde se llama el pago (reserve o sale).
        session(['action' => $action]);
        return view('payments.index', compact('amount'));
    }

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
                session(['newSale' => true]);
                return redirect()->route('sales.create', ['concretized' => 1]);
            }
            if (session('action') == 'cancelateReserve') {
                session(['newSale' => true]);
                return redirect()->route('sales.create', ['concretized' => 0]);
            }
        }
    }
}
