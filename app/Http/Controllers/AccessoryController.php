<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAccessory;
use App\Models\Accessory;
use Illuminate\Http\Request;

class AccessoryController extends Controller
{
    public function index()
    {
        $accessories = Accessory::orderBy('id', 'updated_at')->paginate();
        return view('accessories.index', compact('accessories'));
    }

    public function create()
    {
        return view('accessories.create');
    }

    public function store(StoreAccessory $request)
    {
        $accessory = Accessory::create($request->all());
        return redirect()->route('accessories.show', $accessory);
    }


    public function show(Accessory $accessory)
    {
        return view('accessories.show', compact('accessories'));
    }

    public function edit(Accessory $accessory)
    {
        return view('accessories.edit', compact('accessories'));
    }

    public function update(StoreAccessory $request, Accessory $accessory)
    {
        $accessory->update($request->all());
        return redirect()->route('accessories.show', $accessory);
    }

    public function destroy(Accessory $accessory)
    {
        $accessory->delete();
        return  redirect()->route('accessories.index');
    }
}
