<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAccessory;
use App\Models\Accessory;
use Illuminate\Http\Request;

class AccessoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accessories = Accessory::orderBy('id', 'updated_at')->paginate();
        return view('accessories.index', compact('accessories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('accessories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAccessory $request)
    {
        $accessory = Accessory::create($request->all());
        return redirect()->route('accessories.show', $accessory);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Accessory $accessory)
    {
        return view('accessories.show', compact('accessories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Accessory $accessory)
    {
        return view('accessories.edit', compact('accessories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreAccessory $request, Accessory $accessory)
    {
        $accessory->update($request->all());
        return redirect()->route('accessories.show', $accessory);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Accessory $accessory)
    {
        $accessory->delete();
        return  redirect()->route('accessories.index');
    }
}
