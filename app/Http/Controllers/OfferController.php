<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOffer;
use App\Http\Requests\UpdateOffer;
use App\Models\Accessory;
use App\Models\Offer;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offers = Offer::orderBy('updated_at', 'desc')->paginate(10);
        return view('offers.index', compact('offers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vehicles = Vehicle::where('enabled', 1)->where('offer_id', null)->where('removed', 0)->get();
        $accessories = Accessory::where('enabled', 1)->where('offer_id', null)->where('removed', 0)->get();
        return view('offers.create', compact('vehicles', 'accessories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOffer $request)
    {
        $offer = Offer::create([
            'discount' => $request->discount,
            'startDate' => $request->startDate,
            'endDate' => $request->endDate,
        ]);
        if ($request->vehicles) {
            foreach ($request->vehicles as $vehicle_id) {
                $vehicle = Vehicle::find($vehicle_id);
                $vehicle->update([
                    'offer_id' => $offer->id,
                ]);
            }
        }
        if ($request->accessories) {
            foreach ($request->accessories as $accessory_id) {
                $accessory = Accessory::find($accessory_id);
                $accessory->update([
                    'offer_id' => $offer->id,
                ]);
            }
        }
        return redirect()->route('offers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Offer $offer)
    {
        return view('offers.show', compact('offer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Offer $offer)
    {
        $vehicles = Vehicle::where('enabled', 1)->where('offer_id', null)->where('removed', 0)->get();
        $accessories = Accessory::where('enabled', 1)->where('offer_id', null)->where('removed', 0)->get();
        return view('offers.edit', compact('offer', 'vehicles', 'accessories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOffer $request, Offer $offer)
    {
        $offer->update([
            'discount' => $request->discount,
            'startDate' => $request->startDate,
            'endDate' => $request->endDate,
        ]);
        // Se quita esta oferta a los vehiculos seleccionados
        if ($request->supVehicles) {
            foreach ($request->supVehicles as $vehicle_id) {
                $vehicle = Vehicle::find($vehicle_id);
                $vehicle->update([
                    'offer_id' => null,
                ]);
            }
        }
        // Se quita esta oferta a los accesorios seleccionados
        if ($request->supAccessories) {
            foreach ($request->supAccessories as $accessory_id) {
                $accessory = Accessory::find($accessory_id);
                $accessory->update([
                    'offer_id' => null,
                ]);
            }
        }
        // Se asocia esta oferta a los vehiculos seleccionados
        if ($request->addVehicles) {
            foreach ($request->addVehicles as $vehicle_id) {
                $vehicle = Vehicle::find($vehicle_id);
                $vehicle->update([
                    'offer_id' => $offer->id,
                ]);
            }
        }
        // Se asocia esta oferta a los accesorios seleccionados
        if ($request->addAccessories) {
            foreach ($request->addAccessories as $accessory_id) {
                $accessory = Accessory::find($accessory_id);
                $accessory->update([
                    'offer_id' => $offer->id,
                ]);
            }
        }
        return redirect()->route('offers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Offer $offer)
    {
        $offer->delete();
        return  redirect()->route('offers.index');
    }
}
