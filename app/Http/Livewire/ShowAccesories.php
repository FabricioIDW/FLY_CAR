<?php

namespace App\Http\Livewire;

use App\Models\Accessory;
use Livewire\Component;

class ShowAccesories extends Component
{
    public $search;
    public function render()
    {
        $accesorios = Accessory::select('id', 'name', 'stock')->where('removed', '=', 'false')
        ->where(function($query){
            $query->where('id', 'Like', '%'.$this->search.'%')
            ->orWhere('stock', 'Like', '%'.$this->search.'%')
            ->orWhere('name', 'Like', '%'.$this->search.'%');
        })->get();
        return view('livewire.show-accesories', compact('accesorios'));
    }
}
