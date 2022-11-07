<?php

namespace App\Http\Livewire;

use App\Models\Vehicle;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class ShowVehicles extends Component
{
    public $search;
    public function render()
    {
        $vehiculos = Vehicle::select('vehicles.id', 'vehicles.chassis', 'brands.name as nombreMarca', 'vehicle_models.name as nombreModelo', 'vehicles.vehicle_model_id', 'vehicle_models.brand_id')
            ->join('vehicle_models', 'vehicle_models.id', '=', 'vehicles.vehicle_model_id')
            ->join('brands', 'brands.id', '=', 'vehicle_models.brand_id')
            ->where('vehicles.removed', '=', 'false')->where(function ($query) {
                $query->where('vehicle_models.name', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('vehicles.id', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('brands.name', 'LIKE', '%' . $this->search . '%');
            })->orderBy('vehicles.id', 'ASC')
            ->get();
        "WHERE condicion1 AND (condicion2)";

        return view('livewire.show-vehicles', compact('vehiculos'));
    }
}
