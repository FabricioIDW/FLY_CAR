<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVehicle;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:vehicles.index')->only('index');
        $this->middleware('can:vehicles.create')->only(['create', 'store']);
        $this->middleware('can:vehicles.edit')->only(['edit', 'update']);
        $this->middleware('can:vehicles.destroy')->only('destroy');
    }

    public function index()
    {
        $vehicles = Vehicle::orderBy('updated_at', 'desc')->paginate();
        return view('vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        return view('vehicles.create');
    }

    public function store(StoreVehicle $request)
    {
        $vehicle = Vehicle::create($request->all());
        return redirect()->route('vehicles.show', $vehicle);
    }

    public function show(Vehicle $vehicle)
    {
        // return $vehicle;
        return view('vehicles.show', compact('vehicle'));
    }

    public function edit(Vehicle $vehicle)
    {
        return view('vehicles.edit', compact('vehicle'));
    }

    public function update(StoreVehicle $request, Vehicle $vehicle)
    {
        $vehicle->update($request->all());
        return redirect()->route('vehicles.show', $vehicle);
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        return  redirect()->route('vehicles.index');
    }
}
