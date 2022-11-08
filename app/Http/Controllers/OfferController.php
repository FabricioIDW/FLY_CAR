<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOffer;
use App\Http\Requests\UpdateOffer;
use App\Models\Accessory;
use App\Models\Offer;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class OfferController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:offers.index')->only('index');
        $this->middleware('can:offers.create')->only(['create', 'store']);
        $this->middleware('can:offers.edit')->only(['edit', 'update']);
        $this->middleware('can:offers.destroy')->only('destroy');
    }

    public function index()
    {
        $offers = Offer::orderBy('updated_at', 'desc')->paginate(10);
        return view('offers.index', compact('offers'));
    }

    public function create()
    {
        $vehicles = Vehicle::where('enabled', 1)->where('offer_id', null)->where('removed', 0)->get();
        $accessories = Accessory::where('enabled', 1)->where('offer_id', null)->where('removed', 0)->get();
        return view('offers.create', compact('vehicles', 'accessories'));
    }

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
                $vehicle->offer_id = $offer->id;
                $vehicle->save();
            }
        }
        if ($request->accessories) {
            foreach ($request->accessories as $accessory_id) {
                $accessory = Accessory::find($accessory_id);
                $accessory->offer_id = $offer->id;
                $accessory->save();
            }
        }
        Alert::success('La oferta se creó correctamente.');
        return redirect()->route('offers.index');
    }

    public function show(Offer $offer)
    {
        return view('offers.show', compact('offer'));
    }

    public function edit(Offer $offer)
    {
        $vehicles = Vehicle::where('enabled', 1)->where('offer_id', null)->where('removed', 0)->get();
        $accessories = Accessory::where('enabled', 1)->where('offer_id', null)->where('removed', 0)->get();
        return view('offers.edit', compact('offer', 'vehicles', 'accessories'));
    }
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
                $vehicle->offer_id = null;
                $vehicle->save();
            }
        }
        // Se quita esta oferta a los accesorios seleccionados
        if ($request->supAccessories) {
            foreach ($request->supAccessories as $accessory_id) {
                $accessory = Accessory::find($accessory_id);
                $accessory->offer_id = null;
                $accessory->save();
            }
        }
        // Se asocia esta oferta a los vehiculos seleccionados
        if ($request->addVehicles) {
            foreach ($request->addVehicles as $vehicle_id) {
                $vehicle = Vehicle::find($vehicle_id);
                $vehicle-> offer_id = $offer->id;
                $vehicle->save();
            }
        }
        // Se asocia esta oferta a los accesorios seleccionados
        if ($request->addAccessories) {
            foreach ($request->addAccessories as $accessory_id) {
                $accessory = Accessory::find($accessory_id);
                $accessory->offer_id = $offer->id;
                $accessory->save();
            }
        }
        Alert::success('La oferta se actualizó correctamente.');
        return redirect()->route('offers.index');
    }

    public function destroy(Offer $offer)
    {
        $offer->delete();
        Alert::success('La oferta se eliminó correctamente.');
        return  redirect()->route('offers.index');
    }
}
